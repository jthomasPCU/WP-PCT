<?php
require_once(dirname(__FILE__) . '/wordfenceClass.php');
class wordfenceHash {
	private $engine = false;
	private $db = false;
	private $startTime = false;

	//Begin serialized vars
	public $totalFiles = 0;
	public $totalDirs = 0;
	public $totalData = 0; //To do a sanity check, don't use 'du' because it gets sparse files wrong and reports blocks used on disk. Use : find . -type f -ls | awk '{total += $7} END {print total}'
	public $stoppedOnFile = false;
	private $coreEnabled = false;
	private $pluginsEnabled = false;
	private $themesEnabled = false;
	private $malwareEnabled = false;
	private $coreUnknownEnabled = false;
	private $knownFiles = false;
	private $malwareData = "";
	private $coreHashesData = '';
	private $haveIssues = array();
	private $status = array();
	private $possibleMalware = array();
	private $scannedFiles;
	private $totalForks = 0;
	private $alertedOnUnknownWordPressVersion = false;
	private $foldersEntered = array();
	private $foldersProcessed = array();
	private $suspectedFiles = array();
	private $indexed = false;
	private $indexSize = 0;
	private $currentIndex = 0;
	private $coalescingIssues = array();
	private $pathMap = array();

	/**
	 * @param string $path
	 * @param array $only
	 * @param array $themes
	 * @param array $plugins
	 * @param wfScanEngine $engine
	 * @throws Exception
	 */
	public function __construct($scannedFiles, $engine, $malwarePrefixesHash, $coreHashesHash, $scanMode) {
		$this->scannedFiles = $scannedFiles;
		$this->engine = $engine;

		$this->startTime = microtime(true);

		$options = $this->engine->scanController()->scanOptions();
		if ($options['scansEnabled_core']) { $this->coreEnabled = true; }
		if ($options['scansEnabled_plugins']) { $this->pluginsEnabled = true; }
		if ($options['scansEnabled_themes']) { $this->themesEnabled = true; }
		if ($options['scansEnabled_malware']) { $this->malwareEnabled = true; }
		if ($options['scansEnabled_coreUnknown']) { $this->coreUnknownEnabled = true; }

		$this->db = new wfDB();

		//Doing a delete for now. Later we can optimize this to only scan modified files.
		//$this->db->queryWrite("update " . wfDB::networkTable('wfFileMods') . " set oldMD5 = newMD5");
		$this->db->truncate(wfDB::networkTable('wfFileMods'));
		$this->db->truncate(wfDB::networkTable('wfKnownFileList'));
		$this->db->truncate(wfDB::networkTable('wfPendingIssues'));
		$fetchCoreHashesStatus = wfIssues::statusStart(__("Fetching core, theme and plugin file signatures from Wordfence", 'wordfence'));
		try {
			$this->knownFiles = $this->engine->getKnownFilesLoader()->getKnownFiles();
		} catch (wfScanKnownFilesException $e) {
			wfIssues::statusEndErr();
			throw $e;
		}
		wfIssues::statusEnd($fetchCoreHashesStatus, wfIssues::STATUS_SUCCESS);
		if ($this->malwareEnabled) {
			$malwarePrefixStatus = wfIssues::statusStart(__("Fetching list of known malware files from Wordfence", 'wordfence'));
			
			$stored = wfConfig::get_ser('malwarePrefixes', array(), false);
			if (is_array($stored) && isset($stored['hash']) && $stored['hash'] == $malwarePrefixesHash && isset($stored['prefixes']) && wfWAFUtils::strlen($stored['prefixes']) % 4 == 0) {
				wordfence::status(4, 'info', __("Using cached malware prefixes", 'wordfence'));
			}
			else {
				wordfence::status(4, 'info', __("Fetching fresh malware prefixes", 'wordfence'));
				
				$malwareData = $engine->api->getStaticURL('/malwarePrefixes.bin');
				if (!$malwareData) {
					wfIssues::statusEndErr();
					throw new Exception(__("Could not fetch malware signatures from Wordfence servers.", 'wordfence'));
				}
				
				if (wfWAFUtils::strlen($malwareData) % 4 != 0) {
					wfIssues::statusEndErr();
					throw new Exception(__("Malware data received from Wordfence servers was not valid.", 'wordfence'));
				}
				
				$stored = array('hash' => $malwarePrefixesHash, 'prefixes' => $malwareData);
				wfConfig::set_ser('malwarePrefixes', $stored, true, wfConfig::DONT_AUTOLOAD);
			}
			
			$this->malwareData = $stored['prefixes'];
			wfIssues::statusEnd($malwarePrefixStatus, wfIssues::STATUS_SUCCESS);
		}
		
		if ($this->coreUnknownEnabled) {
			$coreHashesStatus = wfIssues::statusStart(__("Fetching list of known core files from Wordfence", 'wordfence'));
			
			$stored = wfConfig::get_ser('coreHashes', array(), false);
			if (is_array($stored) && isset($stored['hash']) && $stored['hash'] == $coreHashesHash && isset($stored['hashes']) && wfWAFUtils::strlen($stored['hashes']) > 0 && wfWAFUtils::strlen($stored['hashes']) % 32 == 0) {
				wordfence::status(4, 'info', __("Using cached core hashes", 'wordfence'));
			}
			else {
				wordfence::status(4, 'info', __("Fetching fresh core hashes", 'wordfence'));
				
				$coreHashesData = $engine->api->getStaticURL('/coreHashes.bin');
				if (!$coreHashesData) {
					wfIssues::statusEndErr();
					throw new Exception(__("Could not fetch core hashes from Wordfence servers.", 'wordfence'));
				}
				
				if (wfWAFUtils::strlen($coreHashesData) % 32 != 0) {
					wfIssues::statusEndErr();
					throw new Exception(__("Core hashes data received from Wordfence servers was not valid.", 'wordfence'));
				}
				
				$stored = array('hash' => $coreHashesHash, 'hashes' => $coreHashesData);
				wfConfig::set_ser('coreHashes', $stored, true, wfConfig::DONT_AUTOLOAD);
			}
			
			$this->coreHashesData = $stored['hashes'];
			wfIssues::statusEnd($coreHashesStatus, wfIssues::STATUS_SUCCESS);
		}

		$this->haveIssues = array(
			'core' => wfIssues::STATUS_SECURE,
			'coreUnknown' => wfIssues::STATUS_SECURE,
			'themes' => wfIssues::STATUS_SECURE,
			'plugins' => wfIssues::STATUS_SECURE,
			'malware' => wfIssues::STATUS_SECURE,
			);
		if($this->coreEnabled){ $this->status['core'] = wfIssues::statusStart(__("Comparing core WordPress files against originals in repository", 'wordfence')); $this->engine->scanController()->startStage(wfScanner::STAGE_FILE_CHANGES); } else { wfIssues::statusDisabled(__("Skipping core scan", 'wordfence')); }
		if($this->themesEnabled){ $this->status['themes'] = wfIssues::statusStart(__("Comparing open source themes against WordPress.org originals", 'wordfence')); $this->engine->scanController()->startStage(wfScanner::STAGE_FILE_CHANGES); } else { wfIssues::statusDisabled(__("Skipping theme scan", 'wordfence')); }
		if($this->pluginsEnabled){ $this->status['plugins'] = wfIssues::statusStart(__("Comparing plugins against WordPress.org originals", 'wordfence')); $this->engine->scanController()->startStage(wfScanner::STAGE_FILE_CHANGES); } else { wfIssues::statusDisabled(__("Skipping plugin scan", 'wordfence')); }
		if($this->malwareEnabled){ $this->status['malware'] = wfIssues::statusStart(__("Scanning for known malware files", 'wordfence')); $this->engine->scanController()->startStage(wfScanner::STAGE_MALWARE_SCAN); } else { wfIssues::statusDisabled(__("Skipping malware scan", 'wordfence')); }
		if($this->coreUnknownEnabled){ $this->status['coreUnknown'] = wfIssues::statusStart(__("Scanning for unknown files in wp-admin and wp-includes", 'wordfence')); $this->engine->scanController()->startStage(wfScanner::STAGE_FILE_CHANGES); } else { wfIssues::statusDisabled(__("Skipping unknown core file scan", 'wordfence')); }
		
		if ($options['scansEnabled_fileContents']) { $this->engine->scanController()->startStage(wfScanner::STAGE_MALWARE_SCAN); }
		if ($options['scansEnabled_fileContentsGSB']) { $this->engine->scanController()->startStage(wfScanner::STAGE_CONTENT_SAFETY); }
		
		if ($this->coreUnknownEnabled && !$this->alertedOnUnknownWordPressVersion && empty($this->knownFiles['core'])) {
			require(ABSPATH . 'wp-includes/version.php'); /* @var string $wp_version */
			$this->alertedOnUnknownWordPressVersion = true;
			$added = $this->engine->addIssue(
				'coreUnknown',
				wfIssues::SEVERITY_MEDIUM,
				'coreUnknown' . $wp_version,
				'coreUnknown' . $wp_version,
				sprintf(/* translators: WordPress version. */ __('Unknown WordPress core version: %s', 'wordfence'), $wp_version),
				__("The core files scan will not be run because this version of WordPress is not currently indexed by Wordfence. This may be due to using a prerelease version or because the servers are still indexing a new release. If you are using an official WordPress release, this issue will automatically dismiss once the version is indexed and another scan is run.", 'wordfence'),
				array()
			);
			
			if ($added == wfIssues::ISSUE_ADDED || $added == wfIssues::ISSUE_UPDATED) { $this->haveIssues['coreUnknown'] = wfIssues::STATUS_PROBLEM; }
			else if ($this->haveIssues['coreUnknown'] != wfIssues::STATUS_PROBLEM && ($added == wfIssues::ISSUE_IGNOREP || $added == wfIssues::ISSUE_IGNOREC)) { $this->haveIssues['coreUnknown'] = wfIssues::STATUS_IGNORED; }
		}
	}
	public function __sleep(){
		return array('totalFiles', 'totalDirs', 'totalData', 'stoppedOnFile', 'coreEnabled', 'pluginsEnabled', 'themesEnabled', 'malwareEnabled', 'coreUnknownEnabled', 'knownFiles', 'haveIssues', 'status', 'possibleMalware', 'scannedFiles', 'totalForks', 'alertedOnUnknownWordPressVersion', 'foldersProcessed', 'suspectedFiles', 'indexed', 'indexSize', 'currentIndex', 'coalescingIssues', 'pathMap');
	}
	public function __wakeup(){
		$this->db = new wfDB();
		$this->startTime = microtime(true);
		$this->totalForks++;
		
		$stored = wfConfig::get_ser('malwarePrefixes', array(), false);
		if (!isset($stored['prefixes'])) {
			$stored['prefixes'] = '';
		}
		$this->malwareData = $stored['prefixes'];
		
		$stored = wfConfig::get_ser('coreHashes', array(), false);
		if (!isset($stored['hashes'])) {
			$stored['hashes'] = '';
		}
		$this->coreHashesData = $stored['hashes'];
	}
	public function getSuspectedFiles() {
		return array_keys($this->suspectedFiles);
	}
	public function run($engine) {
		if($this->totalForks > 1000){
			throw new Exception(sprintf(/* translators: File path. */ __("Wordfence file scanner detected a possible infinite loop. Exiting on file: %s", 'wordfence'), $this->stoppedOnFile));
		}
		$this->engine = $engine;
		if (!$this->indexed) {
			$start = microtime(true);
			$indexedFiles = array();
			foreach ($this->scannedFiles as $file) {
				$this->_dirIndex($file, $indexedFiles);
			}
			$this->_serviceIndexQueue($indexedFiles, true);
			$this->indexed = true;
			unset($this->foldersEntered); $this->foldersEntered = array();
			unset($this->foldersProcessed); $this->foldersProcessed = array();
			$end = microtime(true);
			wordfence::status(4, 'info', sprintf(/* translators: Time in seconds. */ __("Index time: %s", 'wordfence'), ($end - $start)));
		}
		
		$this->_checkForTimeout();
		
		wordfence::status(4, 'info', __("Beginning file hashing", 'wordfence'));
		while ($file = $this->_nextFile()) {
			$this->processFile($file);
			$this->_checkForTimeout($file);
		}
		
		wordfence::status(4, 'info', __("Processing pending issues", 'wordfence'));
		$this->_processPendingIssues();
		
		wordfence::status(2, 'info', sprintf(/* translators: 1. Number of files. 2. Data in bytes. */ __('Analyzed %1$d files containing %2$s of data.', 'wordfence'), $this->totalFiles, wfUtils::formatBytes($this->totalData)));
		if($this->coreEnabled){ wfIssues::statusEnd($this->status['core'], $this->haveIssues['core']); $this->engine->scanController()->completeStage(wfScanner::STAGE_FILE_CHANGES, $this->haveIssues['core']); }
		if($this->themesEnabled){ wfIssues::statusEnd($this->status['themes'], $this->haveIssues['themes']); $this->engine->scanController()->completeStage(wfScanner::STAGE_FILE_CHANGES, $this->haveIssues['themes']); }
		if($this->pluginsEnabled){ wfIssues::statusEnd($this->status['plugins'], $this->haveIssues['plugins']); $this->engine->scanController()->completeStage(wfScanner::STAGE_FILE_CHANGES, $this->haveIssues['plugins']); }
		if($this->coreUnknownEnabled){ wfIssues::statusEnd($this->status['coreUnknown'], $this->haveIssues['coreUnknown']); $this->engine->scanController()->completeStage(wfScanner::STAGE_FILE_CHANGES, $this->haveIssues['coreUnknown']); }
		if(sizeof($this->possibleMalware) > 0){
			$malwareResp = $engine->api->binCall('check_possible_malware', json_encode($this->possibleMalware));
			if($malwareResp['code'] != 200){
				wfIssues::statusEndErr();
				throw new Exception(__("Invalid response from Wordfence API during check_possible_malware", 'wordfence'));
			}
			$malwareList = json_decode($malwareResp['data'], true);
			if(is_array($malwareList) && sizeof($malwareList) > 0){
				for($i = 0; $i < sizeof($malwareList); $i++){ 
					$file = $malwareList[$i][0];
					$md5 = $malwareList[$i][1];
					$name = $malwareList[$i][2];
					$added = $this->engine->addIssue(
						'file',
						wfIssues::SEVERITY_CRITICAL,
						$file,
						$md5,
						sprintf(/* translators: File path. */ __('This file is suspected malware: %s', 'wordfence'), $file),
						sprintf(/* translators: Malware name/title. */ __("This file's signature matches a known malware file. The title of the malware is '%s'. Immediately inspect this file using the 'View' option below and consider deleting it from your server.", 'wordfence'), $name),
						array(
							'file' => $file,
							'realFile' => array_key_exists($file, $this->pathMap) ? $this->pathMap[$file] : null,
							'cType' => 'unknown',
							'canDiff' => false,
							'canFix' => false,
							'canDelete' => true
							)
						);
					
					if ($added == wfIssues::ISSUE_ADDED || $added == wfIssues::ISSUE_UPDATED) { $this->haveIssues['malware'] = wfIssues::STATUS_PROBLEM; }
					else if ($this->haveIssues['malware'] != wfIssues::STATUS_PROBLEM && ($added == wfIssues::ISSUE_IGNOREP || $added == wfIssues::ISSUE_IGNOREC)) { $this->haveIssues['malware'] = wfIssues::STATUS_IGNORED; }
				}
			}
		}
		if($this->malwareEnabled){ wfIssues::statusEnd($this->status['malware'], $this->haveIssues['malware']); $this->engine->scanController()->completeStage(wfScanner::STAGE_MALWARE_SCAN, $this->haveIssues['malware']); }
		unset($this->knownFiles); $this->knownFiles = false;
	}
	private function _dirIndex($file, &$indexedFiles) {
		$realPath = $file->getRealPath();
		//Applies to files and dirs
		if (!is_readable($realPath))
			return;
		if (!$this->_shouldProcessFile($file))
			return;
		if (is_dir($realPath)) {
			if (isset($this->foldersEntered[$realPath]))
				return;
			
			$this->foldersEntered[$file->getRealPath()] = 1;
			
			$this->totalDirs++;
			try {
				foreach (wfFileUtils::getContents($realPath) as $child) {
					if (wfFileUtils::isCurrentOrParentDirectory($child)) {
						continue;
					}
					try {
						$child = $file->createChild($child);
					}
					catch (wfInvalidPathException $e) {
						wordfence::status(4, 'info', sprintf(__("Ignoring invalid scan file child: %s", 'wordfence'), $e->getPath()));
						continue;
					}
					if (is_file($child->getRealPath())) {
						$relativeFile = $child->getWordpressPath();
						if ($this->stoppedOnFile && $child->getRealPath() != $this->stoppedOnFile) {
							continue;
						}

						if (preg_match('/\.suspected$/i', $relativeFile)) { //Already iterating over all files in the search areas so generate this list here
							wordfence::status(4, 'info', sprintf(/* translators: File path. */ __("Found .suspected file: %s", 'wordfence'), $relativeFile));
							$this->suspectedFiles[$relativeFile] = 1;
						}

						$this->_checkForTimeout($child, $indexedFiles);
						if ($this->_shouldHashFile($child)) {
							$indexedFiles[] = $child;
						}
						else {
							wordfence::status(4, 'info', sprintf(/* translators: File path. */ __("Skipping unneeded hash: %s", 'wordfence'), (string) $child));
						}
						$this->_serviceIndexQueue($indexedFiles);
					}
					elseif (is_dir($child->getRealPath())) {
						$this->_dirIndex($child, $indexedFiles);
					}
				}
			}
			catch (wfInaccessibleDirectoryException $e) {
				wordfence::status(4, 'info', sprintf(/* translators: File path. */ __("Skipping inaccessible directory: %s", 'wordfence'), (string) $file));
			}
			
			$this->foldersProcessed[$realPath] = 1;
			unset($this->foldersEntered[$realPath]);
		}
		else {
			if (is_file($realPath)) {
				$relativeFile = $file->getWordpressPath();
				if ($this->stoppedOnFile && $realPath != $this->stoppedOnFile) {
					return;
				}
				
				if (preg_match('/\.suspected$/i', $relativeFile)) { //Already iterating over all files in the search areas so generate this list here
					wordfence::status(4, 'info', sprintf(/* translators: File path. */ __("Found .suspected file: %s", 'wordfence'), $relativeFile));
					$this->suspectedFiles[$relativeFile] = 1;
				}
				
				$this->_checkForTimeout($file, $indexedFiles);
				if ($this->_shouldHashFile($file)) {
					$indexedFiles[] = $file;
				}
				else {
					wordfence::status(4, 'info', sprintf(/* translators: File path. */ __("Skipping unneeded hash: %s", 'wordfence'), (string) $file));
				}
				$this->_serviceIndexQueue($indexedFiles);
			}
		}
	}
	private function _serviceIndexQueue(&$indexedFiles, $final = false) {
		$files = array();
		if (count($indexedFiles) > 500) {
			$files = array_splice($indexedFiles, 0, 500);
		}
		else if ($final) {
			$files = $indexedFiles;
			$indexedFiles = array();
		}

		$fileCount = count($files);
		if ($fileCount > 0) {
			$payload = array();
			foreach ($files as $file) {
				$payload[] = (string) $file;
				$payload[] = $file->getWordpressPath();
			}
			global $wpdb;
			$table_wfKnownFileList = wfDB::networkTable('wfKnownFileList');
			$query = substr("INSERT INTO {$table_wfKnownFileList} (path, wordpress_path) VALUES " . str_repeat("('%s', '%s'), ", count($files)), 0, -2);
			$wpdb->query($wpdb->prepare($query, $payload));
			$this->indexSize += $fileCount;
			wordfence::status(2, 'info', sprintf(/* translators: Number of files. */ __("%d files indexed", 'wordfence'), $this->indexSize));
		}
	}
	private function _nextFile($advanceCursor = true) {
		static $files = array();
		if (count($files) == 0) {
			global $wpdb;
			$table_wfKnownFileList = wfDB::networkTable('wfKnownFileList');
			$rows = $wpdb->get_results($wpdb->prepare("SELECT path, wordpress_path FROM {$table_wfKnownFileList} WHERE id > %d ORDER BY id ASC LIMIT 500", $this->currentIndex));
			$files = array_map(
				function ($row) {
					return new wfScanFile($row->path, $row->wordpress_path);
				},
				$rows
			);
		}
		
		$file = null;
		if ($advanceCursor) {
			$file = array_shift($files);
			$this->currentIndex++;
		}
		else if (count($files) > 0) {
			$file = $files[0];
		}
		
		if ($file === null) {
			return null;
		}
		return $file;
	}
	private function _checkForTimeout($file = null, $indexQueue = false) {
		$realPath = $file ? $file->getRealPath() : null;
		if (($this->stoppedOnFile !== $realPath) && $this->engine->shouldFork()) { //max X seconds but don't allow fork if we're looking for the file we stopped on. Search mode is VERY fast.
			if ($indexQueue !== false) {
				$this->_serviceIndexQueue($indexQueue, true);
				$this->stoppedOnFile = $realPath;
				wordfence::status(4, 'info', sprintf(/* translators: File path. */ __("Forking during indexing: %s", 'wordfence'), (string) $file));
			}
			else {
				wordfence::status(4, 'info', sprintf(/* translators: PHP max execution time. */ __("Calling fork() from wordfenceHash with maxExecTime: %s", 'wordfence'), $this->engine->maxExecTime));
			}
			$this->engine->fork();
			//exits
		}
		
		if ($this->stoppedOnFile && $realPath != $this->stoppedOnFile && $indexQueue !== false) {
			return;
		}
		else if ($this->stoppedOnFile && $realPath == $this->stoppedOnFile) {
			$this->stoppedOnFile = false; //Continue indexing
		}
	}
	private function _shouldProcessFile($file) {
		$excludePatterns = wordfenceScanner::getExcludeFilePattern(wordfenceScanner::EXCLUSION_PATTERNS_USER);
		if ($excludePatterns) {
			foreach ($excludePatterns as $pattern) {
				if (preg_match($pattern, $file->getWordpressPath())) {
					return false;
				}
			}
		}
		
		$realPath = $file->getRealPath();
		if ($realPath === '/') {
			return false;
		}
		if (isset($this->foldersProcessed[$realPath])) {
			return false;
		}
		
		return true;
	}
	private function processFile($file) {
		$realPath = $file->getRealPath();
		$wordpressPath = $file->getWordpressPath();
		if (wfUtils::fileTooBig($realPath)) {
			wordfence::status(4, 'info', sprintf(/* translators: File path. */ __("Skipping file larger than max size: %s", 'wordfence'), $realPath));
			return;
		}
		
		if (function_exists('memory_get_usage')) {
			wordfence::status(4, 'info', sprintf(/* translators: 1. File path. 2. Memory in bytes. */ __('Scanning: %1$s (Mem:%2$s)', 'wordfence'), $realPath, sprintf('%.1fM', memory_get_usage(true) / (1024 * 1024))));
		}
		else {
			wordfence::status(4, 'info', sprintf(/* translators: File path. */ __("Scanning: %s", 'wordfence'), $realPath));
		}
		
		wfUtils::beginProcessingFile($wordpressPath);
		$wfHash = self::hashFile($realPath);
		$this->engine->scanController()->incrementSummaryItem(wfScanner::SUMMARY_SCANNED_FILES);
		if ($wfHash) {
			$md5 = strtoupper($wfHash[0]);
			$shac = strtoupper($wfHash[1]);
			$knownFile = 0;
			if($this->malwareEnabled && $this->isMalwarePrefix($md5)){
				$this->possibleMalware[] = array($wordpressPath, $md5);
				$this->pathMap[$wordpressPath] = $realPath;
			}

			$knownFileExclude = wordfenceScanner::getExcludeFilePattern(wordfenceScanner::EXCLUSION_PATTERNS_KNOWN_FILES);
			$allowKnownFileScan = true;
			if ($knownFileExclude) {
				foreach ($knownFileExclude as $pattern) {
					if (preg_match($pattern, $realPath)) {
						$allowKnownFileScan = false;
					}
				}
			}

			if ($allowKnownFileScan) {
				if (isset($this->knownFiles['core'][$wordpressPath])) {
					if (strtoupper($this->knownFiles['core'][$wordpressPath]) == $shac) {
						$knownFile = 1;
					}
					else {
						if ($this->coreEnabled) {
							$localFile = ABSPATH . '/' . preg_replace('/^[\.\/]+/', '', $wordpressPath);
							$fileContents = @file_get_contents($localFile);
							if ($fileContents && (!preg_match('/<\?' . 'php[\r\n\s\t]*\/\/[\r\n\s\t]*Silence is golden\.[\r\n\s\t]*(?:\?>)?[\r\n\s\t]*$/s', $fileContents))) {
								$this->engine->addPendingIssue(
									'knownfile',
									wfIssues::SEVERITY_HIGH,
									'coreModified' . $wordpressPath,
									'coreModified' . $wordpressPath . $md5,
									sprintf(/* translators: File path. */ __('WordPress core file modified: %s', 'wordfence'), $wordpressPath),
									__("This WordPress core file has been modified and differs from the original file distributed with this version of WordPress.", 'wordfence'),
									array(
										'file' => $wordpressPath,
										'realFile' => $realPath,
										'cType' => 'core',
										'canDiff' => true,
										'canFix' => true,
										'canDelete' => false,
										'haveIssues' => 'core'
									)
								);
							}
						}
					}
				}
				else if (isset($this->knownFiles['plugins'][$wordpressPath])) {
					if (in_array($shac, $this->knownFiles['plugins'][$wordpressPath])) {
						$knownFile = 1;
					}
					else {
						if ($this->pluginsEnabled) {
							$options = $this->engine->scanController()->scanOptions();
							$shouldGenerateIssue = true;
							if (!$options['scansEnabled_highSense'] && preg_match('~/readme\.(?:txt|md)$~i', $wordpressPath)) { //Don't generate issues for changed readme files unless high sensitivity is on
								$shouldGenerateIssue = false;
							}
							
							if ($shouldGenerateIssue) {
								$itemName = $this->knownFiles['plugins'][$wordpressPath][0];
								$itemVersion = $this->knownFiles['plugins'][$wordpressPath][1];
								$cKey = $this->knownFiles['plugins'][$wordpressPath][2];
								$this->engine->addPendingIssue(
									'knownfile',
									wfIssues::SEVERITY_MEDIUM,
									'modifiedplugin' . $wordpressPath,
									'modifiedplugin' . $wordpressPath . $md5,
									sprintf(/* translators: File path. */ __('Modified plugin file: %s', 'wordfence'), $wordpressPath),
									sprintf(
										/* translators: 1. Plugin name. 2. Plugin version. 3. Support URL. */
										__('This file belongs to plugin "%1$s" version "%2$s" and has been modified from the file that is distributed by WordPress.org for this version. Please use the link to see how the file has changed. If you have modified this file yourself, you can safely ignore this warning. If you see a lot of changed files in a plugin that have been made by the author, then try uninstalling and reinstalling the plugin to force an upgrade. Doing this is a workaround for plugin authors who don\'t manage their code correctly. <a href="%3$s" target="_blank" rel="noopener noreferrer">Learn More<span class="screen-reader-text"> (' . esc_html__('opens in new tab', 'wordfence') . ')</span></a>', 'wordfence'),
										$itemName,
										$itemVersion,
										wfSupportController::esc_supportURL(wfSupportController::ITEM_SCAN_RESULT_MODIFIED_PLUGIN)
									),
									array(
										'file' => $wordpressPath,
										'realFile' => $realPath,
										'cType' => 'plugin',
										'canDiff' => true,
										'canFix' => true,
										'canDelete' => false,
										'cName' => $itemName,
										'cVersion' => $itemVersion,
										'cKey' => $cKey,
										'haveIssues' => 'plugins'
									)
								);
							}
						}

					}
				}
				else if (isset($this->knownFiles['themes'][$wordpressPath])) {
					if (in_array($shac, $this->knownFiles['themes'][$wordpressPath])) {
						$knownFile = 1;
					}
					else {
						if ($this->themesEnabled) {
							$options = $this->engine->scanController()->scanOptions();
							$shouldGenerateIssue = true;
							if (!$options['scansEnabled_highSense'] && preg_match('~/readme\.(?:txt|md)$~i', $wordpressPath)) { //Don't generate issues for changed readme files unless high sensitivity is on
								$shouldGenerateIssue = false;
							}
							
							if ($shouldGenerateIssue) {
								$itemName = $this->knownFiles['themes'][$wordpressPath][0];
								$itemVersion = $this->knownFiles['themes'][$wordpressPath][1];
								$cKey = $this->knownFiles['themes'][$wordpressPath][2];
								$this->engine->addPendingIssue(
									'knownfile',
									wfIssues::SEVERITY_MEDIUM,
									'modifiedtheme' . $wordpressPath,
									'modifiedtheme' . $wordpressPath . $md5,
									sprintf(/* translators: File path. */ __('Modified theme file: %s', 'wordfence'), $wordpressPath),
									sprintf(
										/* translators: 1. Plugin name. 2. Plugin version. 3. Support URL. */
										__('This file belongs to theme "%1$s" version "%2$s" and has been modified from the original distribution. It is common for site owners to modify their theme files, so if you have modified this file yourself you can safely ignore this warning. <a href="%3$s" target="_blank" rel="noopener noreferrer">Learn More<span class="screen-reader-text"> (' . esc_html__('opens in new tab', 'wordfence') . ')</span></a>', 'wordfence'),
										$itemName,
										$itemVersion,
										wfSupportController::esc_supportURL(wfSupportController::ITEM_SCAN_RESULT_MODIFIED_THEME)
									),
									array(
										'file' => $wordpressPath,
										'realFile' => $realPath,
										'cType' => 'theme',
										'canDiff' => true,
										'canFix' => true,
										'canDelete' => false,
										'cName' => $itemName,
										'cVersion' => $itemVersion,
										'cKey' => $cKey,
										'haveIssues' => 'themes'
									)
								);
							}
						}

					}
				}
				else if ($this->coreUnknownEnabled && !$this->alertedOnUnknownWordPressVersion) { //Check for unknown files in system directories
					$restrictedWordPressFolders = array(ABSPATH . 'wp-admin/', ABSPATH . WPINC . '/');
					$added = false;
					foreach ($restrictedWordPressFolders as $path) {
						if (strpos($realPath, $path) === 0) {
							if ($this->isPreviousCoreFile($shac)) {
								$added = $this->engine->addIssue(
									'knownfile',
									wfIssues::SEVERITY_LOW,
									'coreUnknown' . $wordpressPath,
									'coreUnknown' . $wordpressPath . $md5,
									sprintf(/* translators: File path. */ __('Old WordPress core file not removed during update: %s', 'wordfence'), $wordpressPath),
									__('This file is in a WordPress core location but is from an older version of WordPress and not used with your current version. Hosting or permissions issues can cause these files to get left behind when WordPress is updated and they should be removed if possible.', 'wordfence'),
									array(
										'file' => $wordpressPath,
										'realFile' => $realPath,
										'cType' => 'core',
										'canDiff' => false,
										'canFix' => false,
										'canDelete' => true,
									)
								);
							}
							else if (preg_match('#/php\.ini$#', $wordpressPath)) {
								$this->engine->addPendingIssue(
									'knownfile',
									wfIssues::SEVERITY_HIGH,
									'coreUnknown' . $wordpressPath,
									'coreUnknown' . $wordpressPath . $md5,
									sprintf(/* translators: File path. */ __('Unknown file in WordPress core: %s', 'wordfence'), $wordpressPath),
									__('This file is in a WordPress core location but is not distributed with this version of WordPress. This scan often includes files left over from a previous WordPress version, but it may also find files added by another plugin, files added by your host, or malicious files added by an attacker.', 'wordfence'),
									array(
										'file' => $wordpressPath,
										'realFile' => $realPath,
										'cType' => 'core',
										'canDiff' => false,
										'canFix' => false,
										'canDelete' => true,
										'coalesce' => 'php.ini',
										'learnMore' => wfSupportController::supportURL(wfSupportController::ITEM_SCAN_RESULT_UNKNOWN_FILE_CORE),
										'haveIssues' => 'coreUnknown',
									)
								);
							}
							else {
								$added = $this->engine->addIssue(
									'knownfile',
									wfIssues::SEVERITY_HIGH,
									'coreUnknown' . $wordpressPath,
									'coreUnknown' . $wordpressPath . $md5,
									sprintf(/* translators: File path. */ __('Unknown file in WordPress core: %s', 'wordfence'), $wordpressPath),
									sprintf(/* translators: Support URL. */ __('This file is in a WordPress core location but is not distributed with this version of WordPress. This scan often includes files left over from a previous WordPress version, but it may also find files added by another plugin, files added by your host, or malicious files added by an attacker. <a href="%s" target="_blank" rel="noopener noreferrer">Learn More<span class="screen-reader-text"> (' . esc_html__('opens in new tab', 'wordfence') . ')</span></a>', 'wordfence'), wfSupportController::esc_supportURL(wfSupportController::ITEM_SCAN_RESULT_UNKNOWN_FILE_CORE)),
									array(
										'file' => $wordpressPath,
										'realFile' => $realPath,
										'cType' => 'core',
										'canDiff' => false,
										'canFix' => false,
										'canDelete' => true,
									)
								);
							}
						}
					}
					
					if ($added == wfIssues::ISSUE_ADDED || $added == wfIssues::ISSUE_UPDATED) { $this->haveIssues['coreUnknown'] = wfIssues::STATUS_PROBLEM; }
					else if ($this->haveIssues['coreUnknown'] != wfIssues::STATUS_PROBLEM && ($added == wfIssues::ISSUE_IGNOREP || $added == wfIssues::ISSUE_IGNOREC)) { $this->haveIssues['coreUnknown'] = wfIssues::STATUS_IGNORED; }
				}
			}
			// knownFile means that the file is both part of core or a known plugin or theme AND that we recognize the file's hash. 
			// we could split this into files whose path we recognize and file's whose path we recognize AND who have a valid sig.
			// But because we want to scan files whose sig we don't recognize, regardless of known path or not, we only need one "knownFile" field.
			$fileModsTable = wfDB::networkTable('wfFileMods');
			$this->db->queryWrite("INSERT INTO {$fileModsTable} (filename, real_path, filenameMD5, knownFile, oldMD5, newMD5, SHAC) VALUES ('%s', '%s', UNHEX(MD5('%s')), %d, '', UNHEX('%s'), UNHEX('%s')) ON DUPLICATE KEY UPDATE newMD5 = UNHEX('%s'), SHAC = UNHEX('%s'), knownFile = %d", $wordpressPath, $realPath, $wordpressPath, $knownFile, $md5, $shac, $md5, $shac, $knownFile);

			$this->totalFiles++;
			$this->totalData += @filesize($realPath); //We already checked if file overflows int in the fileTooBig routine above
			if($this->totalFiles % 100 === 0){
				wordfence::status(2, 'info', sprintf(
					/* translators: 1. Number of files. 2. Data in bytes. */
					__('Analyzed %1$d files containing %2$s of data so far', 'wordfence'),
					$this->totalFiles,
					wfUtils::formatBytes($this->totalData)
				));
			}
		} else {
			//wordfence::status(2, 'error', "Could not gen hash for file (probably because we don't have permission to access the file): $realPath");
		}
		wfUtils::endProcessingFile();
	}
	private function _processPendingIssues() {
		$fileModsTable = wfDB::networkTable('wfFileMods');
		
		$count = $this->engine->getPendingIssueCount();
		$offset = 0;
		while ($offset < $count) {
			$issues = $this->engine->getPendingIssues($offset);
			if (count($issues) == 0) {
				break;
			}
			
			//Do a bulk check of is_safe_file
			$hashesToCheck = array();
			foreach ($issues as &$i) {
				$shac = $this->db->querySingle("SELECT HEX(SHAC) FROM {$fileModsTable} WHERE filename = '%s' AND isSafeFile = '?'", $i['data']['file']);
				$shac = strtoupper($shac);
				$i['shac'] = null;
				if ($shac !== null) {
					$shac = strtoupper($shac);
					$i['shac'] = $shac;
					$hashesToCheck[] = $shac;
				}
			}
			
			$safeFiles = array();
			if (count($hashesToCheck) > 0) {
				$safeFiles = $this->isSafeFile($hashesToCheck);
			}
			
			//Migrate non-safe file issues to official issues and begin coalescing tagged issues
			foreach ($issues as &$i) {
				if (!in_array($i['shac'], $safeFiles)) {
					$haveIssuesType = $i['data']['haveIssues'];
					if (isset($i['data']['coalesce'])) {
						$key = $i['data']['coalesce'];
						if (!isset($this->coalescingIssues[$key])) { $this->coalescingIssues[$key] = array('count' => 0, 'issue' => $i); }
						$this->coalescingIssues[$key]['count']++;
					}
					else {
						$added = $this->engine->addIssue(
							$i['type'],
							$i['severity'],
							$i['ignoreP'],
							$i['ignoreC'],
							$i['shortMsg'],
							$i['longMsg'],
							$i['data'],
							true //Prevent ignoreP and ignoreC from being hashed again
						);
						if ($added == wfIssues::ISSUE_ADDED || $added == wfIssues::ISSUE_UPDATED) { $this->haveIssues[$haveIssuesType] = wfIssues::STATUS_PROBLEM; }
						else if ($this->haveIssues[$haveIssuesType] != wfIssues::STATUS_PROBLEM && ($added == wfIssues::ISSUE_IGNOREP || $added == wfIssues::ISSUE_IGNOREC)) { $this->haveIssues[$haveIssuesType] = wfIssues::STATUS_IGNORED; }
					}
					
					$this->db->queryWrite("UPDATE {$fileModsTable} SET isSafeFile = '0' WHERE SHAC = UNHEX('%s')", $i['shac']);
				}
				else {
					$this->db->queryWrite("UPDATE {$fileModsTable} SET isSafeFile = '1' WHERE SHAC = UNHEX('%s')", $i['shac']);
				}
			}
			
			$offset += count($issues);
			$this->engine->checkForKill();
		}
		
		//Insert the coalesced issues (currently just multiple php.ini in system directories)
		foreach ($this->coalescingIssues as $c) {
			$count = $c['count'];
			$i = $c['issue'];
			$haveIssuesType = $i['data']['haveIssues'];
			$added = $this->engine->addIssue(
				$i['type'],
				$i['severity'],
				$i['ignoreP'],
				$i['ignoreC'],
				$i['shortMsg'] . ($count > 1 ? ' ' . sprintf(/* translators: Number of scan results. */ __('(+ %d more)', 'wordfence'), $count - 1) : ''),
				$i['longMsg'] . ($count > 1 ? ' ' . ($count > 2 ? sprintf(/* translators: Number of files. */ __('%d more similar files were found.', 'wordfence'), $count - 1) : __('1 more similar file was found.', 'wordfence')) : '') . (isset($i['data']['learnMore']) ? ' ' . sprintf(__('<a href="%s" target="_blank" rel="noopener noreferrer">Learn More<span class="screen-reader-text"> (' . esc_html__('opens in new tab', 'wordfence') . ')</span></a>', 'wordfence'), esc_attr($i['data']['learnMore'])) : ''),
				$i['data'],
				true //Prevent ignoreP and ignoreC from being hashed again
			);
			if ($added == wfIssues::ISSUE_ADDED || $added == wfIssues::ISSUE_UPDATED) { $this->haveIssues[$haveIssuesType] = wfIssues::STATUS_PROBLEM; }
			else if ($this->haveIssues[$haveIssuesType] != wfIssues::STATUS_PROBLEM && ($added == wfIssues::ISSUE_IGNOREP || $added == wfIssues::ISSUE_IGNOREC)) { $this->haveIssues[$haveIssuesType] = wfIssues::STATUS_IGNORED; }
		}
	}
	public static function hashFile($file) {
		$fp = @fopen($file, "rb");
		if (!$fp) {
			return false;
		}
		$md5Context = hash_init('md5');
		$sha256Context = hash_init('sha256');
		while (!feof($fp)) {
			$data = fread($fp, 65536);
			if ($data === false) {
				return false;
			}
			hash_update($md5Context, $data);
			hash_update($sha256Context, str_replace(array("\n","\r","\t"," "),"", $data));
		}
		$md5 = hash_final($md5Context, false);
		$shac = hash_final($sha256Context, false);
		return array($md5, $shac);
	}
	private function _shouldHashFile($file) {
		$wordpressPath = $file->getWordpressPath();

		//Core File, return true
		if ((isset($this->knownFiles['core']) && isset($this->knownFiles['core'][$wordpressPath])) ||
			(isset($this->knownFiles['plugins']) && isset($this->knownFiles['plugins'][$wordpressPath])) ||
			(isset($this->knownFiles['themes']) && isset($this->knownFiles['themes'][$wordpressPath]))) {
			return true;
		}
		
		//Excluded file, return false
		$excludePatterns = wordfenceScanner::getExcludeFilePattern(wordfenceScanner::EXCLUSION_PATTERNS_USER | wordfenceScanner::EXCLUSION_PATTERNS_MALWARE); 
		if ($excludePatterns) {
			foreach ($excludePatterns as $pattern) {
				if (preg_match($pattern, $wordpressPath)) {
					return false;
				}
			}
		}
		
		//Unknown file in a core location
		if ($this->coreUnknownEnabled && !$this->alertedOnUnknownWordPressVersion) {
			$restrictedWordPressFolders = array(ABSPATH . 'wp-admin/', ABSPATH . WPINC . '/');
			foreach ($restrictedWordPressFolders as $path) {
				if (strpos($file->getRealPath(), $path) === 0) {
					return true;
				}
			}
		}
		
		//Determine treatment
		$fileExt = '';
		if (preg_match('/\.([a-zA-Z\d\-]{1,7})$/', $wordpressPath, $matches)) {
			$fileExt = strtolower($matches[1]);
		}
		$isPHP = false;
		if (preg_match('/\.(?:php(?:\d+)?|phtml)(\.|$)/i', $wordpressPath)) {
			$isPHP = true;
		}
		$isHTML = false;
		if (preg_match('/\.(?:html?)(\.|$)/i', $wordpressPath)) {
			$isHTML = true;
		}
		$isJS = false;
		if (preg_match('/\.(?:js|svg)(\.|$)/i', $wordpressPath)) {
			$isJS = true;
		}
		
		$options = $this->engine->scanController()->scanOptions();
		
		//If scan images is disabled, only allow .js through
		if (!$isPHP && preg_match('/^(?:jpg|jpeg|mp3|avi|m4v|mov|mp4|gif|png|tiff?|svg|sql|js|tbz2?|bz2?|xz|zip|tgz|gz|tar|log|err\d+)$/', $fileExt)) {
			if (!$options['scansEnabled_scanImages'] && !$isJS) {
				return false;
			}
		}
		
		//If high sensitivity is disabled, don't allow .sql
		if (strtolower($fileExt) == 'sql') {
			if (!$options['scansEnabled_highSense']) {
				return false;
			}
		}
		
		//Treating as binary, return true
		$treatAsBinary = ($isPHP || $isHTML || $options['scansEnabled_scanImages']);
		if ($treatAsBinary) {
			return true;
		}
		
		//Will be malware scanned, return true
		if ($isJS) {
			return true;
		}
		
		return false;
	}
	private function isMalwarePrefix($hexMD5){
		$hasPrefix = $this->_binaryListContains($this->malwareData, wfUtils::hex2bin($hexMD5), 4);
		return $hasPrefix !== false;
	}
	private function isPreviousCoreFile($hexContentsSHAC) {
		$hasPrefix = $this->_binaryListContains($this->coreHashesData, wfUtils::hex2bin($hexContentsSHAC), 32);
		return $hasPrefix !== false;
	}
	
	/**
	 * @param $binaryList The binary list to search, sorted as a binary string.
	 * @param $needle The binary needle to search for.
	 * @param int $size The byte size of each item in the list.
	 * @return bool|int false if not found, otherwise the index in the list
	 */
	private function _binaryListContains($binaryList, $needle, $size /* bytes */) {
		$p = substr($needle, 0, $size);
		
		$count = ceil(wfWAFUtils::strlen($binaryList) / $size);
		$low = 0;
		$high = $count - 1;
		
		while ($low <= $high) {
			$mid = (int) (($high + $low) / 2);
			$val = wfWAFUtils::substr($binaryList, $mid * $size, $size);
			$cmp = strcmp($val, $p);
			if ($cmp < 0) {
				$low = $mid + 1;
			}
			else if ($cmp > 0) {
				$high = $mid - 1;
			}
			else {
				return $mid;
			}
		}
		
		return false;
	}
	
	/**
	 * Queries the is_safe_file endpoint. If provided an array, it does a bulk check and returns an array containing the
	 * hashes that were marked as safe. If provided a string, it returns a boolean to indicate the safeness of the file.
	 * 
	 * @param string|array $shac
	 * @return array|bool
	 */
	private function isSafeFile($shac) {
		if (is_array($shac)) {
			$result = $this->engine->api->call('is_safe_file', array(), array('multipleSHAC' => json_encode($shac)));
			if (isset($result['isSafe'])) {
				return $result['isSafe'];
			}
			return array();
		}
		
		$result = $this->engine->api->call('is_safe_file', array(), array('shac' => strtoupper($shac)));
		if(isset($result['isSafe']) && $result['isSafe'] == 1){
			return true;
		}
		return false;
	}
}