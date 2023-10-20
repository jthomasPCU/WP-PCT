<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_Webhooks_Integrations_w3_total_cache_Triggers_w3tc_full_cache_cleared' ) ) :

	/**
	 * Load the w3tc_full_cache_cleared trigger
	 *
	 * @since 6.0
	 * @author Ironikus <info@ironikus.com>
	 */
	class WP_Webhooks_Integrations_w3_total_cache_Triggers_w3tc_full_cache_cleared {

		public function get_callbacks() {

			return array(
				array(
					'type'      => 'action',
					'hook'      => 'w3tc_flush_all',
					'callback'  => array( $this, 'w3tc_full_cache_cleared_callback' ),
					'priority'  => 1100,
					'arguments' => 1,
					'delayed'   => true,
				),
			);
		}

		public function get_details() {


			$parameter = array(
				'success' => array( 'short_description' => __( '(Bool) True if the cache was successfully cleared.', 'wp-webhooks' ) ),
                'msg' => array( 'short_description' => __( '(String) Further details about the clearing of the cache.', 'wp-webhooks' ) ),
				'extras' => array( 'short_description' => __( '(String) The type of the cleared cache. E.g. all, post, term, user, url.', 'wp-webhooks' ) ),
			);

			$settings = array(
				'load_default_settings' => true,
			);

			return array(
				'trigger'           => 'w3tc_full_cache_cleared',
				'name'              => __( 'Full cache cleared', 'wp-webhooks' ),
				'sentence'          => __( 'the full cache was cleared', 'wp-webhooks' ),
				'parameter'         => $parameter,
				'settings'          => $settings,
				'returns_code'      => $this->get_demo( array() ),
				'short_description' => __( 'This webhook fires as soon as the full cache was cleared within W3 Total Cache.', 'wp-webhooks' ),
				'description'       => array(),
				'integration'       => 'w3-total-cache',
				'premium'           => true,
			);

		}

		/**
		 * Triggers when W3 Total Cache clears the cache
		 *
		 * @param string $extras Type of the cache
		 */
		public function w3tc_full_cache_cleared_callback( $extras ) {

			$webhooks            = WPWHPRO()->webhook->get_hooks( 'trigger', 'w3tc_full_cache_cleared' );
			$response_data_array = array();

			$payload = array(
				'success' => true,
				'msg'     => __( 'The full cache has been cleared.', 'wp-webhooks' ),
				'extras' => $extras,
			);

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

			do_action( 'wpwhpro/webhooks/trigger_w3tc_full_cache_cleared', $payload, $response_data_array );
		}

		public function get_demo( $options = array() ) {

			$data = array(
				'success' => true,
				'msg'     => 'The full cache has been cleared.',
				'extras' => array(
					'ui_action' => 'flush_button',
				),
			);

			return $data;
		}

	}

endif; // End if class_exists check.
