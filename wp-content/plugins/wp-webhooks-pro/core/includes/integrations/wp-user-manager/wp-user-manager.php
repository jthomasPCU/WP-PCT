<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WP_Webhooks_Integrations_wp_user_manager Class
 *
 * This class integrates all WP User Manager related features and endpoints
 *
 * @since 4.3.5
 */
class WP_Webhooks_Integrations_wp_user_manager {

    public function is_active(){
        return class_exists( 'WP_User_Manager' );
    }

    public function get_details(){
        return array(
            'name' => 'WP User Manager',
            'icon' => 'assets/img/icon-wp-user-manager.svg',
        );
    }

}
