<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'WP_Webhooks_Integrations_wp_webhooks_Triggers_received_request' ) ) :

 /**
  * Load the received_request trigger
  *
  * @since 4.3.6
  * @author Ironikus <info@ironikus.com>
  */
  class WP_Webhooks_Integrations_wp_webhooks_Triggers_received_request {

	public function get_callbacks(){

		return array(
			array(
				'type' => 'filter',
				'hook' => 'wpwhpro/webhooks/add_webhook_actions',
				'callback' => array( $this, 'received_request_callback' ),
				'priority' => 20,
				'arguments' => 4,
				'delayed' => true,
			),
		);
	}

	public function get_details(){

		$parameter = array(
			'content_type' => array( 'short_description' => __( '(String) The content type that was used to fire the webhook action URL.', 'wp-webhooks' ) ),
			'content' => array( 'short_description' => __( '(Mixed) The sanitized body (payload) of the webhook action URL request.', 'wp-webhooks' ) ),
		);

		$description = array(
			'tipps' => array(
				__( 'This webhook fires once a webhook action URL (From within the Receive Data tab) was called.', 'wp-webhooks' ),
				__( 'Please note: Activating this trigger on an existing webhook action URL does not interfere with its other webhook actions you use it for.', 'wp-webhooks' ),
				__( 'You can fire this trigger as well on specific Receive Data action URLs only. To do that, simply specify the URLs within the webhook URL settings.', 'wp-webhooks' ),
			)
		);

		$settings = array(
			'load_default_settings' => false,
			'data' => array(
				'wpwhpro_webhooks_trigger_on_selected_actions' => array(
					'id'		  => 'wpwhpro_webhooks_trigger_on_selected_actions',
					'type'		=> 'select',
					'multiple'	=> true,
					'choices'	  => array(),
					'query'			=> array(
						'filter'	=> 'helpers',
						'args'		=> array(
							'integration' => 'wp-webhooks',
							'helper' => 'wpwh_helpers',
							'function' => 'get_query_action_urls',
						)
					),
					'label'	   => __( 'Trigger on selected Receive Data action URLs', 'wp-webhooks' ),
					'placeholder' => '',
					'required'	=> false,
					'description' => __( 'Select only the action URLs (From within the Receive Data tab) you want to fire the trigger on. You can also choose multiple ones. If none is selected, all are triggered. The names seen are the names you chose for your action URL within the Receive Data tab.', 'wp-webhooks' )
				),
			)
		);

		return array(
			'trigger'		   => 'received_request',
			'name'			  => __( 'Action URL request received', 'wp-webhooks' ),
			'sentence'			  => __( 'an action URL request was received', 'wp-webhooks' ),
			'parameter'		 => $parameter,
			'settings'		  => $settings,
			'returns_code'	  => $this->get_demo( array() ),
			'short_description' => sprintf( __( 'This webhook fires as soon as an action URL request was received on a Receive Data URL within %s.', 'wp-webhooks' ), WPWHPRO()->settings->get_page_title() ),
			'description'	   => $description,
			'integration'	   => 'wp-webhooks',
			'premium'		   => true,
		);

	}

	public function received_request_callback( $return_data, $action, $response_ident_value, $response_api_key ){

		$webhooks = WPWHPRO()->webhook->get_hooks( 'trigger', 'received_request' );
		$response_data_array = array();

		$payload = WPWHPRO()->http->get_current_request();

		foreach( $webhooks as $webhook ){

			$webhook_url_name = ( is_array($webhook) && isset( $webhook['webhook_url_name'] ) ) ? $webhook['webhook_url_name'] : null;
			$is_valid = true;

			if( isset( $webhook['settings'] ) ){
				foreach( $webhook['settings'] as $settings_name => $settings_data ){
	  
				  if( $settings_name === 'wpwhpro_webhooks_trigger_on_selected_actions' && ! empty( $settings_data ) ){
					if( ! in_array( $response_ident_value, $settings_data ) ){
					  $is_valid = false;
					}
				  }
	  
				}
			}

			if( $is_valid ){
				if( $webhook_url_name !== null ){
					$response_data_array[ $webhook_url_name ] = WPWHPRO()->webhook->post_to_webhook( $webhook, $payload );
				} else {
					$response_data_array[] = WPWHPRO()->webhook->post_to_webhook( $webhook, $payload );
				}
			}

		}

		do_action( 'wpwhpro/webhooks/trigger_received_request', $payload, $response_data_array );

		return $return_data;
	}

	public function get_demo( $options = array() ) {

		$data = array (
			'content_type' => 'application/x-www-form-urlencoded',
			'content' => 
			array (
			  'custom_construct' => 'The data that was sent to the Receive Data URL.',
			),
		  );

		return $data;
	}

  }

endif; // End if class_exists check.