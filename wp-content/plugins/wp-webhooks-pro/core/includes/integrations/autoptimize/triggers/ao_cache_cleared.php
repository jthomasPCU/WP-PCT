<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_Webhooks_Integrations_autoptimize_Triggers_ao_cache_cleared' ) ) :

	/**
	 * Load the ao_cache_cleared trigger
	 *
	 * @since 6.0
	 * @author Ironikus <info@ironikus.com>
	 */
	class WP_Webhooks_Integrations_autoptimize_Triggers_ao_cache_cleared {

		public function get_callbacks() {

			return array(
				array(
					'type'      => 'action',
					'hook'      => 'autoptimize_action_cachepurged',
					'callback'  => array( $this, 'ao_cache_cleared_callback' ),
					'priority'  => 10,
					'arguments' => 1,
					'delayed'   => true,
				),
			);
		}

		public function get_details() {


			$parameter = array();

			$settings = array(
				'load_default_settings' => true,
			);

			return array(
				'trigger'           => 'ao_cache_cleared',
				'name'              => __( 'Full cache cleared', 'wp-webhooks' ),
				'sentence'          => __( 'the full cache was cleared', 'wp-webhooks' ),
				'parameter'         => $parameter,
				'settings'          => $settings,
				'returns_code'      => $this->get_demo( array() ),
				'short_description' => __( 'This webhook fires as soon as the full cache was cleared within Autoptimize.', 'wp-webhooks' ),
				'description'       => array(),
				'integration'       => 'autoptimize',
				'premium'           => true,
			);

		}

		public function ao_cache_cleared_callback() {

			$webhooks            = WPWHPRO()->webhook->get_hooks( 'trigger', 'ao_cache_cleared' );
			$response_data_array = array();

			$payload = array(
				'success'             => true,
				'msg'                 => __( 'The full cache has been cleared.', 'wp-webhooks' ),
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

			do_action( 'wpwhpro/webhooks/trigger_ao_cache_cleared', $payload, $response_data_array );
		}

		public function get_demo( $options = array() ) {

			$data = array(
				'success' => true,
				'msg'     => 'The full cache has been cleared.',
			);
			return $data;
		}

	}

endif; // End if class_exists check.
