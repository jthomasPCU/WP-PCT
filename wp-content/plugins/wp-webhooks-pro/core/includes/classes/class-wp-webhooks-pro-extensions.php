<?php

/**
 * WP_Webhooks_Pro_Extensions Class
 *
 * This class contains all of the available functions
 * for our available extension
 *
 * @since 4.2.3
 */

/**
 * The api class of the plugin.
 *
 * @since 4.2.3
 * @package WPWHPRO
 * @author Ironikus <info@ironikus.com>
 */
class WP_Webhooks_Pro_Extensions {

	/**
	 * Execute feature related hooks and logic to get 
	 * everything running
	 *
	 * @since 4.2.3
	 * @return void
	 */
	public function execute(){

		add_action( 'wp_ajax_ironikus_manage_extensions',  array( $this, 'ironikus_manage_extensions' ) );

	}

    /*
     * Manage WP Webhooks extensions
     */
	public function ironikus_manage_extensions(){
        check_ajax_referer( md5( WPWHPRO()->settings->get_page_name() ), 'ironikus_nonce' );

        $extension_slug            = isset( $_REQUEST['extension_slug'] ) ? sanitize_text_field( $_REQUEST['extension_slug'] ) : '';
        $extension_status            = isset( $_REQUEST['extension_status'] ) ? sanitize_text_field( $_REQUEST['extension_status'] ) : '';
        $extension_download            = isset( $_REQUEST['extension_download'] ) ? sanitize_text_field( $_REQUEST['extension_download'] ) : '';
        $extension_id            = isset( $_REQUEST['extension_id'] ) ? intval( $_REQUEST['extension_id'] ) : '';
        $extension_version            = isset( $_REQUEST['extension_version'] ) ? sanitize_text_field( $_REQUEST['extension_version'] ) : '';
		$response           = array( 'success' => false );

		if( empty( $extension_slug ) || empty( $extension_status ) ){
			$response['msg'] = __( 'An error occured while doing this action.', 'wp-webhooks' );
			return $response;
		}

		switch( $extension_status ){
			case 'activated': //runs when the "Deactivate" button was clicked
				$response['new_class'] = 'text-green';
				$response['new_status'] = 'deactivated';
				$response['new_label'] = __( 'Activate', 'wp-webhooks' );
				$response['success'] = $this->deactivate_extension( $extension_slug );
				$response['msg'] = __( 'The plugin was successfully deactivated.', 'wp-webhooks' );
				break;
			case 'deactivated': //runs when the "Activate" button was clicked
				$response['new_class'] = 'text-warning';
				$response['new_status'] = 'activated';
				$response['new_label'] = __( 'Deactivate', 'wp-webhooks' );
				$response['success'] = $this->activate_extension( $extension_slug );
				$response['msg'] = __( 'The plugin was successfully activated.', 'wp-webhooks' );
				break;
			case 'uninstalled': //runs when the "Install" button was clicked
				$response['new_class'] = 'text-green';
				$response['new_status'] = 'deactivated';
				$response['delete_name'] = __( 'Delete', 'wp-webhooks' );
				$response['new_label'] = __( 'Activate', 'wp-webhooks' );
				$response['success'] = $this->install_wpwh_extension( $extension_slug, $extension_download, $extension_id, $extension_version );
				$response['msg'] = __( 'The plugin was successfully installed.', 'wp-webhooks' );
				break;
			case 'update_active': //runs when the "Update" button was clicked and the previous status was active
				$response['new_class'] = 'text-warning';
				$response['new_status'] = 'activated';
				$response['new_label'] = __( 'Deactivate', 'wp-webhooks' );
				$response['success'] = $this->update_wpwh_extension( $extension_slug, $extension_download, $extension_id, $extension_version );;
				$response['msg'] = __( 'The plugin was successfully updated.', 'wp-webhooks' );
				break;
			case 'update_deactive': //runs when the "Update" button was clicked and the previous status was inactive
				$response['new_class'] = 'text-green';
				$response['new_status'] = 'deactivated';
				$response['new_label'] = __( 'Activate', 'wp-webhooks' );
				$response['success'] = $this->update_wpwh_extension( $extension_slug, $extension_download, $extension_id, $extension_version );;
				$response['msg'] = __( 'The plugin was successfully updated.', 'wp-webhooks' );
				break;
			case 'delete': //runs when the "Delete" link was clicked
				$response['new_class'] = 'text-secondary';
				$response['new_status'] = 'uninstalled';
				$response['new_label'] = __( 'Install', 'wp-webhooks' );
				$response['success'] = $this->uninstall_extension( $extension_slug );
				$response['msg'] = __( 'The plugin was successfully deleted.', 'wp-webhooks' );
				break;
		}

        echo json_encode( $response );
		die();
    }

    public function deactivate_extension( $slug ){

		if( empty( $slug ) ){
			return false;
		}

		if ( is_plugin_active( $slug ) ) {
			deactivate_plugins( $slug );
		}

		return true;
    }

    public function activate_extension( $slug ){

		if( empty( $slug ) ){
			return false;
		}

		if ( ! WPWHPRO()->helpers->is_plugin_installed( $slug ) ) {
			return false;
		}

		$activate = activate_plugin( $slug );
		if (is_null($activate)) {
			return true;
		}

		return false;
    }

	private function install_wpwh_extension( $slug, $dl, $item_id, $version ){

		if( empty( $slug ) || empty( $dl ) ){
			return false;
		}

		if ( WPWHPRO()->helpers->is_plugin_installed( $slug ) ) {
			return false;
		}

		if( $dl === 'ironikus' ){
			$dl = $this->manage_extension_get_premium( $slug, $item_id, $version );
			if( empty( $dl ) ){
				return false;
			}
		}

		$check = $this->install_extension( $slug, $dl );

		return $check;
	}

	public function install_extension( $slug, $dl ){

		@include_once ABSPATH . 'wp-admin/includes/plugin.php';
		@include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		@include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
		@include_once ABSPATH . 'wp-admin/includes/file.php';
		@include_once ABSPATH . 'wp-admin/includes/misc.php';
		@include_once WPWHPRO_PLUGIN_DIR . 'core/includes/classes/class-wp-webhooks-pro-upgrader-skin.php';

		if( ! class_exists( 'Plugin_Upgrader' ) || ! class_exists( 'WP_Webhooks_Upgrader_Skin' ) ){
			return false;
		}

		wp_cache_flush();
		$skin = new WP_Webhooks_Upgrader_Skin( array( 'plugin' => $slug ) );
		$upgrader = new Plugin_Upgrader( $skin );
		$installed = $upgrader->install( $dl );
		wp_cache_flush();

		if( ! is_wp_error( $installed ) && $installed ) {
			return true;
		} else {
			return false;
		}

	}

	public function uninstall_extension( $slug ){

		if ( ! WPWHPRO()->helpers->is_plugin_installed( $slug ) ) {
			return false;
		}

		@include_once ABSPATH . 'wp-admin/includes/plugin.php';
		@include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		@include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
		@include_once ABSPATH . 'wp-admin/includes/file.php';
		@include_once ABSPATH . 'wp-admin/includes/misc.php';

		if( ! function_exists( 'delete_plugins' ) ){
			return false;
		}

		if ( is_plugin_active( $slug ) ) {
			deactivate_plugins( $slug );
		}

		$deleted = delete_plugins( array( $slug ) );

		if( ! is_wp_error( $deleted ) && $deleted ) {
			return true;
		} else {
			return false;
		}

	 }

	private function update_wpwh_extension( $slug, $dl, $item_id, $version ){

		if( empty( $slug ) || empty( $dl ) ){
			return false;
		}

		if ( ! WPWHPRO()->helpers->is_plugin_installed( $slug ) ) {
			return false;
		}

		if( $dl === 'ironikus' ){
			$dl = $this->manage_extension_get_premium( $slug, $item_id, $version );
			if( empty( $dl ) ){
				return false;
			}
		}

		$check = $this->update_extension( $slug, $dl );

		return $check;
	 }

	 public function update_extension( $slug, $dl ){

		@include_once ABSPATH . 'wp-admin/includes/plugin.php';
		@include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		@include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
		@include_once ABSPATH . 'wp-admin/includes/file.php';
		@include_once ABSPATH . 'wp-admin/includes/misc.php';
		@include_once WPWHPRO_PLUGIN_DIR . 'core/includes/classes/class-wp-webhooks-pro-upgrader-skin.php';

		if( ! class_exists( 'Plugin_Upgrader' ) || ! class_exists( 'WP_Webhooks_Upgrader_Skin' ) ){
			return false;
		}

		wp_cache_flush();
		$skin = new WP_Webhooks_Upgrader_Skin( array( 'plugin' => $slug ) );
		$upgrader = new Plugin_Upgrader( $skin );
		$updated = $upgrader->upgrade( $slug );
		wp_cache_flush();

		if( ! is_wp_error( $updated ) && $updated ) {
			return true;
		} else {
			return false;
		}

	 }

	public function manage_extension_get_premium( $slug, $item_id, $version ){

		$license_status = WPWHPRO()->settings->get_license('status');

		if ( $license_status === false || $license_status !== 'valid' ){
			return false;
		}

		$license_key = WPWHPRO()->settings->get_license('key');

		$api_params = array(
			'edd_action' => 'get_version',
			'license'    => ! empty( $license_key ) ? $license_key : '',
			'item_name'  => false,
			'item_id'    => ! empty( $item_id ) ? $item_id : false,
			'version'    => ! empty( $version ) ? $version : false,
			'slug'       => basename( WPWHPRO_PLUGIN_FILE, '.php' ),
			'author'     => 'Ironikus',
			'url'        => home_url(),
			'beta'       => false,
		);

		$request = wp_remote_post( IRONIKUS_STORE, array( 'timeout' => 15, 'sslverify' => true, 'body' => $api_params ) );

		if ( ! is_wp_error( $request ) ) {
			$request = json_decode( wp_remote_retrieve_body( $request ) );
		}

		if ( $request && isset( $request->download_link ) ) {
			return $request->download_link;
		} else {
			return false;
		}

	}

}
