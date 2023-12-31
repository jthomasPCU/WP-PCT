<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WP_Webhooks_Integrations_broken_link_checker Class
 *
 * This class integrates all Broken Link Checker related features and endpoints
 *
 * @since 4.3.2
 */
class WP_Webhooks_Integrations_broken_link_checker {

    public function is_active(){
        return defined( 'BLC_PLUGIN_FILE' );
    }

    public function get_details(){
        return array(
            'name' => 'Broken Link Checker',
            'icon' => 'assets/img/icon-broken-link-checker.png',
        );
    }

}
