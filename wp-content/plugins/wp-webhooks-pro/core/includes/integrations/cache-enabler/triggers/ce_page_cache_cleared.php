<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_Webhooks_Integrations_cache_enabler_Triggers_ce_page_cache_cleared' ) ) :

	/**
	 * Load the ce_page_cache_cleared trigger
	 *
	 * @since 6.0
	 * @author Ironikus <info@ironikus.com>
	 */
	class WP_Webhooks_Integrations_cache_enabler_Triggers_ce_page_cache_cleared {

		public function get_callbacks() {

			return array(
				array(
					'type'      => 'action',
					'hook'      => 'cache_enabler_page_cache_cleared',
					'callback'  => array( $this, 'ce_page_cache_cleared_callback' ),
					'priority'  => 10,
					'arguments' => 3,
					'delayed'   => true,
				),
			);
		}

		public function get_details() {


			$parameter = array(
                'success' => array( 'short_description' => __( '(Bool) True if the page cache was successfully cleared.', 'wp-webhooks' ) ),
                'msg' => array( 'short_description' => __( '(String) Further details about the clearing of the page cache.', 'wp-webhooks' ) ),
                'page_cleared_url' => array( 'short_description' => __( '(String) The URL of the cleared page.', 'wp-webhooks' ) ),
                'page_cleared_id' => array( 'short_description' => __( '(String) The ID of the cleared page.', 'wp-webhooks' ) ),
            );

			$settings = array(
				'load_default_settings' => true,
			);

			return array(
				'trigger'           => 'ce_page_cache_cleared',
				'name'              => __( 'Page cache cleared', 'wp-webhooks' ),
				'sentence'          => __( 'the page cache was cleared', 'wp-webhooks' ),
				'parameter'         => $parameter,
				'settings'          => $settings,
				'returns_code'      => $this->get_demo( array() ),
				'short_description' => __( 'This webhook fires as soon as the page cache was cleared within Cache Enabler.', 'wp-webhooks' ),
				'description'       => array(),
				'integration'       => 'cache-enabler',
				'premium'           => true,
			);

		}

		public function ce_page_cache_cleared_callback( $page_cleared_url, $page_cleared_id, $cache_cleared_index ) {

			$webhooks            = WPWHPRO()->webhook->get_hooks( 'trigger', 'ce_page_cache_cleared' );
			$response_data_array = array();

			$payload = array(
				'success'             => true,
				'msg'                 => __( 'The page cache has been cleared.', 'wp-webhooks' ),
				'page_cleared_url'    => $page_cleared_url,
				'page_cleared_id'     => $page_cleared_id,
			);

			//dont use the index as it can get huge

			foreach ( $webhooks as $webhook ) {

				$webhook_url_name = ( is_array( $webhook ) && isset( $webhook['webhook_url_name'] ) ) ? $webhook['webhook_url_name'] : null;
				$is_valid         = true;

				if ( $is_valid ) {
					if ( $webhook_url_name !== null ) {
						$response_data_array[ $webhook_url_name ] = WPWHPRO()->webhook->post_to_webhook( $webhook, $payload );
					} else {
						$response_data_array[] = WPWHPRO()->webhook->post_to_webhook( $webhook, $payload );
					}
				}
			}

			do_action( 'wpwhpro/webhooks/trigger_ce_page_cache_cleared', $payload, $response_data_array );
		}

		public function get_demo( $options = array() ) {

			$data = array(
				'success' => true,
				'msg'     => 'The page cache has been cleared.',
				"page_cleared_url" => "https://yourdomain.test/my-page/",
				"page_cleared_id" => 123,
			);
			return $data;
		}

	}

endif; // End if class_exists check.
