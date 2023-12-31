<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WP_Webhooks_Integrations_bbpress Class
 *
 * This class integrates all bbPress related features and endpoints
 *
 * @since 5.1
 */
class WP_Webhooks_Integrations_bbpress {

    public function is_active(){
        return class_exists( 'bbPress' );
    }

    public function get_details(){
        return array(
            'name' => 'bbPress',
            'icon' => 'assets/img/icon-bbpress.png',
        );
    }

}
