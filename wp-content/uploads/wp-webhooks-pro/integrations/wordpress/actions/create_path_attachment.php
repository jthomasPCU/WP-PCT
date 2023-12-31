<?php
if ( ! class_exists( 'WP_Webhooks_Integrations_wordpress_Actions_create_path_attachment' ) ) :

	/**
	 * Load the create_path_attachment action
	 *
	 * @since 4.2.0
	 * @author Ironikus <info@ironikus.com>
	 */
	class WP_Webhooks_Integrations_wordpress_Actions_create_path_attachment {

		public function is_active(){

			//Backwards compatibility for the "Manage Media Files" integration
			if( class_exists( 'WP_Webhooks_Pro_Manage_Media_Files' ) ){
				return false;
			}

			return true;
		}

		public function get_details(){

				$parameter = array(
				'path'		   => array( 'required' => true, 'short_description' => __( 'The relative path of the file you want to create the attachment of. Please see the description for more information.', 'wp-webhooks' ) ),
				'parent_post_id' => array( 'short_description' => __( 'The parent post id in case you want to set a parent for it. Default: 0', 'wp-webhooks' ) ),
				'file_name'	  => array( 'short_description' => __( 'Customize the file name of the attachment. - Please see the description for further information.', 'wp-webhooks' ) ),
				'add_post_thumbnail' => array( 'short_description' => __( 'Assign this attachment as a post thumbnail to one or multiple posts. Please see the description for further details.', 'wp-webhooks' ) ),
				'attachment_image_alt' => array( 'short_description' => __( 'Add a custom Alternative Text to the attachment (Image ALT).', 'wp-webhooks' ) ),
				'attachment_title' => array( 'short_description' => __( 'Add a custom title to the attachment (Image Title).', 'wp-webhooks' ) ),
				'attachment_caption' => array( 'short_description' => __( 'Add a custom caption to the attachment (Image Caption).', 'wp-webhooks' ) ),
				'attachment_description' => array( 'short_description' => __( 'Add a custom description to the attachment (Image Descripiton).', 'wp-webhooks' ) ),
				'do_action'	  => array( 'short_description' => __( 'Advanced: Register a custom action after Webhooks Pro fires this webhook. More infos are in the description.', 'wp-webhooks' ) )
			);

			ob_start();
			?>
<?php echo __( "Pleae set the relative path of your media file. For security reasons, we restrict the creation of attachments via the path to the WordPress root folder and its sub folders. This means, that you have to define the path in a relative way. Here is an example:", 'wp-webhooks' ); ?>
<pre>wp-content/uploads/demo-uploads/image.png</pre>
			<?php
			$parameter['path']['description'] = ob_get_clean();

			ob_start();
			?>
<?php echo __( "Using the <strong>file_name</strong> argument, you can customize the original name of the file (how it comes from the server). Please make sure to also include the extension since it tells this webhook what file type to use. changing the extension also means changing the filetype. E.g.:", 'wp-webhooks' ); ?>
<pre>demo-file.txt</pre>
<?php echo __( 'In case you want to delete a file within the WordPress root folder, just declare the file:', 'wp-webhooks' ); ?>
<pre>image.png</pre>
			<?php
			$parameter['file_name']['description'] = ob_get_clean();

			ob_start();
			?>
<?php echo __( "The <strong>add_post_thumbnail</strong> argument allows you to assign the attachment, as a featured image, to one or multiple posts. To use it, simply include a comma-separated list of post ids as a value. Custom post types are supported as well. E.g.:", 'wp-webhooks' ); ?>
<pre>42,134,251</pre>
			<?php
			$parameter['add_post_thumbnail']['description'] = ob_get_clean();

			ob_start();
			?>
<?php echo __( "The <strong>do_action</strong> argument is an advanced webhook for developers. It allows you to fire a custom WordPress hook after the <strong>create_path_attachment</strong> action was fired.", 'wp-webhooks' ); ?>
<br>
<?php echo __( "You can use it to trigger further logic after the webhook action. Here's an example:", 'wp-webhooks' ); ?>
<br>
<br>
<?php echo __( "Let's assume you set for the <strong>do_action</strong> parameter <strong>fire_this_function</strong>. In this case, we will trigger an action with the hook name <strong>fire_this_function</strong>. Here's how the code would look in this case:", 'wp-webhooks' ); ?>
<pre>add_action( 'fire_this_function', 'my_custom_callback_function', 20, 3 );
function my_custom_callback_function( $path, $parent_post_id, $return_args ){
	//run your custom logic in here
}
</pre>
<?php echo __( "Here's an explanation to each of the variables that are sent over within the custom function.", 'wp-webhooks' ); ?>
<ol>
	<li>
		<strong>$path</strong> (string)<br>
		<?php echo __( "The original, relative path of the provided file.", 'wp-webhooks' ); ?>
	</li>
	<li>
		<strong>$parent_post_id</strong> (integer)<br>
		<?php echo __( "The parent post id. In case it wasn't given, we return 0.", 'wp-webhooks' ); ?>
	</li>
	<li>
		<strong>$return_args</strong> (array)<br>
		<?php echo __( "All the values that are sent back as a response to the initial webhook action caller.", 'wp-webhooks' ); ?>
	</li>
</ol>
			<?php
			$parameter['do_action']['description'] = ob_get_clean();

			$returns = array(
				'success'		=> array( 'short_description' => __( '(Bool) True if the action was successful, false if not. E.g. array( \'success\' => true )', 'wp-webhooks' ) ),
				'data'		=> array( 'short_description' => __( '(mixed) The attachment id on success, wp_error on inserting error, upload error on wrong upload or status code error.', 'wp-webhooks' ) ),
				'msg'		=> array( 'short_description' => __( '(string) A message with more information about the current request. E.g. array( \'msg\' => "This action was successful." )', 'wp-webhooks' ) ),
			);

			$returns_code = array (
				'success' => true,
				'msg' => 'File successfully created.',
				'data' => 
				array (
				  'path' => NULL,
				  'attach_id' => 14,
				  'post_info' => NULL,
				  'add_post_thumbnail' => 
				  array (
				  ),
				),
			);

			return array(
				'action'			=> 'create_path_attachment',
				'name'			  => __( 'Create path attachment', 'wp-webhooks' ),
				'sentence'			  => __( 'create an attachment from a server path', 'wp-webhooks' ),
				'parameter'		 => $parameter,
				'returns'		   => $returns,
				'returns_code'	  => $returns_code,
				'short_description' => __( 'Create an attachment from a local and relative path on your website using webhooks.', 'wp-webhooks' ),
				'description'	   => array(),
				'integration'	   => 'wordpress',
				'premium' 			=> true,
			);

		}

		public function execute( $return_data, $response_body ){

			$file_helpers = WPWHPRO()->integrations->get_helper( 'wordpress', 'file_helpers' );
			$return_args = array(
				'success' => false,
				'msg' => '',
				'data' => array(
					'path' => null,
					'attach_id' => null,
					'post_info' => null,
				)
			);

			$path		   = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'path' );
			$file_name	  = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'file_name' );
			$parent_post_id = intval( WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'parent_post_id' ) );
			$add_post_thumbnail = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'add_post_thumbnail' );
			$attachment_image_alt = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'attachment_image_alt' );
			$attachment_title = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'attachment_title' );
			$attachment_caption = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'attachment_caption' );
			$attachment_description = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'attachment_description' );
			$do_action	  = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'do_action' );

			if( ! empty( $path ) ){

				$path = $file_helpers->validate_path( $path );

				if( file_exists( $path ) ){

					if( empty( $file_name ) ){
						$file_name = basename($path);
					}

					$upload = wp_upload_bits( $file_name, null, file_get_contents( $path ) );
					if( empty( $upload['error'] ) ) {

						if( empty( $parent_post_id ) ){
							$parent_post_id = 0;

						}

						$file_path = $upload['file'];
						$file_type = wp_check_filetype( $file_name, null );
						$org_attachment_title = sanitize_file_name( pathinfo( $file_name, PATHINFO_FILENAME ) );
						$wp_upload_dir = wp_upload_dir();
						$post_info = array(
							'guid'		   => $wp_upload_dir['url'] . '/' . $file_name,
							'post_mime_type' => $file_type['type'],
							'post_title'	 => $org_attachment_title,
							'post_content'   => '',
							'post_status'	=> 'inherit',
						);
						// Create the attachment
						$attach_id = wp_insert_attachment( $post_info, $file_path, $parent_post_id );

						if( ! is_wp_error( $attach_id ) ){

							// Include image.php
							require_once( ABSPATH . 'wp-admin/includes/image.php' );
							// Define attachment metadata
							$attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );
							// Assign metadata to attachment
							wp_update_attachment_metadata( $attach_id,  $attach_data );
							$return_args['data']['attachment_metadata'] = $attach_data;
							
							$return_args['data']['add_post_thumbnail'] = array();
							if( ! empty( $add_post_thumbnail ) ){
								$posts_to_attach = explode( ',', $add_post_thumbnail );
								foreach( $posts_to_attach as $single_post ){
									$single_post = intval( trim( $single_post ) );

									$sub_post_thumb_data = array(
										'post_id' => $single_post,
										'attachment_id' => $attach_id,
										'response' => set_post_thumbnail( $single_post, $attach_id ),
									);

									$return_args['data']['add_post_thumbnail'][] = $sub_post_thumb_data;
								}
							}

							if( ! empty( $attachment_image_alt ) ){
								update_post_meta( $attach_id, '_wp_attachment_image_alt', $attachment_image_alt );
								$return_args['data']['attachment_image_alt'] = $attachment_image_alt;
							}

							$attachment_meta = array();

							if( ! empty( $attachment_title ) ){
								$attachment_meta['post_title'] = $attachment_title;
								$return_args['data']['attachment_title'] = $attachment_title;
							}

							if( ! empty( $attachment_caption ) ){
								$attachment_meta['post_excerpt'] = $attachment_caption;
								$return_args['data']['attachment_caption'] = $attachment_caption;
							}

							if( ! empty( $attachment_description ) ){
								$attachment_meta['post_content'] = $attachment_description;
								$return_args['data']['attachment_description'] = $attachment_description;
							}

							if( ! empty( $attachment_meta ) ){
								$attachment_meta = array_merge( array( 'ID' => $attach_id ), $attachment_meta );
								wp_update_post( $attachment_meta );
							}

							$return_args['data']['attach_id'] = $attach_id;
							$return_args['success'] = true;
							$return_args['msg'] = __( "File successfully created.", 'action-create_url_attachment-success' );

						} else {

							$return_args['data']['attach_id'] = $attach_id;
							$return_args['data']['post_info'] = $post_info;
							$return_args['data']['upload_info'] = $upload;
							$return_args['msg'] = __( "An error occured while inserting the file.", 'action-create_url_attachment-success' );

						}


					} else {

						$return_args['data']['upload_info'] = $upload;
						$return_args['msg'] = __( "An error occured while uploading the file.", 'action-create_url_attachment-success' );

					}

				} else {

					$return_args['data']['path'] = $path;
					$return_args['msg'] = __( "The file you specified does not exist.", 'action-create_url_attachment-success' );

				}

			} else {

				$return_args['msg'] = __( "Error: No path set.", 'action-create_url_attachment-success' );

			}



			if( ! empty( $do_action ) ){
				do_action( $do_action, $path, $parent_post_id, $return_args );
			}

			return $return_args;
	
		}

	}

endif; // End if class_exists check.