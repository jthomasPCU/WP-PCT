<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WP_Webhooks_Integrations_events_manager Class
 *
 * This class integrates all Events Manager related features and endpoints
 *
 * @since 4.2.0
 */
class WP_Webhooks_Integrations_events_manager {

    public function is_active(){
        return class_exists( 'EM_Events' );
    }

    public function get_details(){
        return array(
            'name' => 'Events Manager',
            'icon' => 'assets/img/icon-events-manager.svg',
        );
    }

}
