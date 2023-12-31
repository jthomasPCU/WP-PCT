<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'WP_Webhooks_Integrations_woocommerce_Triggers_wc_customer_updated' ) ) :

 /**
  * Load the wc_customer_updated trigger
  *
  * @since 4.3.2
  * @author Ironikus <info@ironikus.com>
  */
  class WP_Webhooks_Integrations_woocommerce_Triggers_wc_customer_updated {

	public function get_callbacks(){

		return array(
			array(
				'type' => 'action',
				'hook' => 'profile_update',
				'callback' => array( $this, 'wc_customer_updated_callback' ),
				'priority' => 20,
				'arguments' => 1,
				'delayed' => true,
			),
			array(
				'type' => 'action',
				'hook' => 'woocommerce_update_customer',
				'callback' => array( $this, 'wc_customer_updated_callback' ),
				'priority' => 20,
				'arguments' => 1,
				'delayed' => true,
			),
		);
	}

	public function get_details(){

		$parameter = array(
			'custom' => array( 'short_description' => __( 'A custom data construct from your chosen Woocommerce API.', 'wp-webhooks' ) ),
		);

		$description = array(
			'tipps' => array(
				__( 'If the webhook does not work as expected due to an error like "woocommerce_rest_cannot_view", please adjust the user ID within the trigger settings.', 'wp-webhooks' ),
				__( 'You can fire this trigger as well on a specific Woocommerce API version. To do that, select a version within the webhook URL settings.', 'wp-webhooks' ),
				__( 'You can also set a custom secret key just as for the default Woocommerce webhooks. IF you do not set one, there will be one automatically generated.', 'wp-webhooks' ),
			)
		);

		$settings = array(
			'load_default_settings' => true,
			'data' => array(
				'wpwhpro_woocommerce_set_user' => array(
					'id'		  => 'wpwhpro_woocommerce_set_user',
					'type'		=> 'text',
					'label'	   => __( 'Set user id', 'wp-webhooks' ),
					'placeholder' => '',
					'required'	=> false,
					'description' => __( 'Set the numeric ID of a user that has permission to view the Woocommerce REST API. By default we try to locate the ID of the first admin user.', 'wp-webhooks' )
				),
				'wpwhpro_woocommerce_set_api_version' => array(
					'id'		  => 'wpwhpro_woocommerce_set_api_version',
					'type'		=> 'select',
					'multiple'	=> false,
					'choices'	  => array(),
					'query'			=> array(
						'filter'	=> 'helpers',
						'args'		=> array(
							'integration' => 'woocommerce',
							'helper' => 'wc_helpers',
							'function' => 'get_query_wc_api_versions',
						)
					),
					'label'	   => __( 'Set API version', 'wp-webhooks' ),
					'placeholder' => '',
					'required'	=> false,
					'default_value'	=> 'wp_api_v2',
					'description' => __( 'Select the Woocommerce API version you want to use for this request. By default, we use wp_api_v2', 'wp-webhooks' )
				),
				'wpwhpro_woocommerce_set_secret' => array(
					'id'		  => 'wpwhpro_woocommerce_set_secret',
					'type'		=> 'text',
					'label'	   => __( 'Set secret', 'wp-webhooks' ),
					'placeholder' => '',
					'required'	=> false,
					'description' => __( 'Set a custom secret that gets validated by Woocommerce, just as you know it from the default Woocommerce webhooks.', 'wp-webhooks' )
				),
			)
		);

		return array(
			'trigger'		   => 'wc_customer_updated',
			'name'			  => __( 'Customer updated', 'wp-webhooks' ),
			'sentence'			  => __( 'a customer was updated', 'wp-webhooks' ),
			'parameter'		 => $parameter,
			'settings'		  => $settings,
			'returns_code'	  => $this->get_demo( array() ),
			'short_description' => __( 'This webhook fires as soon as a customer was updated within Woocommerce.', 'wp-webhooks' ),
			'description'	   => $description,
			'integration'	   => 'woocommerce',
			'premium'		   => true,
		);

	}

	/**
	 * Triggers once a customer was updated
	 *
	 * @param mixed $arg
	 */
	public function wc_customer_updated_callback( $arg ){

		$webhooks = WPWHPRO()->webhook->get_hooks( 'trigger', 'wc_customer_updated' );
		$wc_helpers = WPWHPRO()->integrations->get_helper( 'woocommerce', 'wc_helpers' );
		$payload = array();
		$payload_track = array();

		$topic = 'customer.updated';
		$api_version = 'wp_api_v2';

		if( ! class_exists( 'WC_Webhook' ) ){
			return;
		}

		$user_id = ( is_numeric( $arg ) ) ? intval( $arg ) : 0;

		$wc_webhook = new WC_Webhook();
		$wc_webhook->set_name( 'wpwh-' . $topic );
		$wc_webhook->set_status( 'active' );
		$wc_webhook->set_topic( $topic );
		$wc_webhook->set_user_id( 0 );
		$wc_webhook->set_pending_delivery( false );
		#$wc_webhook->set_delivery_url(  );

		//Make sure we follow Woocommerce standards of verifying webhooks
		$continue_webhook = false;

		if( is_numeric( $arg ) ){
			$user = get_userdata( absint( $arg ) );
			// Only deliver deleted customer event for users with customer role.
			if ( $user && in_array( 'customer', (array) $user->roles, true ) ) {
				$continue_webhook = true;
			}
		}

		if ( ! $continue_webhook ) {
			return;
		}

		$response_data_array = array();

		foreach( $webhooks as $webhook ){

			$webhook_url_name = ( is_array($webhook) && isset( $webhook['webhook_url_name'] ) ) ? $webhook['webhook_url_name'] : null;
			$is_valid = true;

			if( isset( $webhook['settings'] ) ){

				if( $is_valid && isset( $webhook['settings']['wpwhpro_woocommerce_set_api_version'] ) && ! empty( $webhook['settings']['wpwhpro_woocommerce_set_api_version'] ) ){
					$api_version = $webhook['settings']['wpwhpro_woocommerce_set_api_version'];
				}

				if( $is_valid && isset( $webhook['settings']['wpwhpro_woocommerce_set_secret'] ) && ! empty( $webhook['settings']['wpwhpro_woocommerce_set_secret'] ) ){
					$wc_webhook->set_secret( $webhook['settings']['wpwhpro_woocommerce_set_secret'] );
				}

				if( $is_valid 
					&& isset( $webhook['settings']['wpwhpro_woocommerce_set_user'] ) 
					&& ! empty( $webhook['settings']['wpwhpro_woocommerce_set_user'] ) 
					&& is_numeric( $webhook['settings']['wpwhpro_woocommerce_set_user'] )
				){
					$wc_webhook->set_user_id( intval( $webhook['settings']['wpwhpro_woocommerce_set_user'] ) );
				}

				//Make sure we automatically prevent the webhook from firing twice due to the Woocommerce hook notation
				$webhook['settings']['wpwhpro_trigger_single_instance_execution'] = 1;
			} else {
				$webhook['settings'] = array(
					'wpwhpro_trigger_single_instance_execution' => 1,
				);
			}

			if( $is_valid ){

				//Maybe assign a default user ID of none hase been given
				if( ! $wc_webhook->get_user_id() ){
					$admin_id = $wc_helpers->get_first_admin_id();

					if( ! empty( $admin_id ) ){
						$wc_webhook->set_user_id( intval( $admin_id ) );
					}
				}

				$wc_webhook->set_api_version( $api_version );
				$payload = $wc_webhook->build_payload( $arg );

				//Append additional data
				if( ! empty( $user_id ) && is_array( $payload ) ){
					$payload['wpwh_meta_data'] = get_user_meta( $user_id );
				}

				//setup headers
				$headers	                                      = array();
				$headers['Content-Type']      		 = 'application/json';
				$headers['X-WC-Webhook-Source']      = home_url( '/' ); // Since 2.6.0.
				$headers['X-WC-Webhook-Topic']       = $wc_webhook->get_topic();
				$headers['X-WC-Webhook-Resource']    = $wc_webhook->get_resource();
				$headers['X-WC-Webhook-Event']       = $wc_webhook->get_event();
				$headers['X-WC-Webhook-Signature']   = $wc_webhook ->generate_signature( trim( wp_json_encode( $payload ) ) );
				$headers['X-WC-Webhook-ID']          = 0;
				$headers['X-WC-Webhook-Delivery-ID'] = 0;

				if( $webhook_url_name !== null ){
					$response_data_array[ $webhook_url_name ] = WPWHPRO()->webhook->post_to_webhook( $webhook, $payload, array( 'headers' => $headers ) );
					$payload_track[] = $payload;
				} else {
					$response_data_array[] = WPWHPRO()->webhook->post_to_webhook( $webhook, $payload, array( 'headers' => $headers ) );
				}
			}

		}

		do_action( 'wpwhpro/webhooks/trigger_wc_customer_updated', $payload, $response_data_array, $payload_track );
	}
	
	public function get_demo( $options = array() ) {

		$data = array (
			'id' => 150,
			'date_created' => '2021-12-27T20:07:10',
			'date_modified' => '2021-12-27T20:12:21',
			'email' => 'demo@yourdomain.test',
			'first_name' => 'Jon',
			'last_name' => 'Doe',
			'username' => 'jon.doe',
			'last_order' => 
			array (
			  'id' => 8092,
			  'date' => '2021-12-27T20:07:11',
			),
			'orders_count' => 1,
			'total_spent' => '0.00',
			'avatar_url' => 'https://secure.gravatar.com/avatar/ac0153ebc7286731000000000000?s=96&d=mm&r=g',
			'billing' => 
			array (
			  'first_name' => 'Jon',
			  'last_name' => 'Doe',
			  'company' => 'Doe Corp',
			  'address_1' => 'Demo St. 5',
			  'address_2' => '',
			  'city' => 'Demo City',
			  'postcode' => '12345',
			  'country' => 'DE',
			  'state' => '',
			  'email' => 'demo@yourdomain.test',
			  'phone' => '123456789',
			),
			'shipping' => 
			array (
			  'first_name' => '',
			  'last_name' => '',
			  'company' => '',
			  'address_1' => '',
			  'address_2' => '',
			  'city' => '',
			  'postcode' => '',
			  'country' => '',
			  'state' => '',
			  'phone' => '',
			),
			'_links' => 
			array (
			  'self' => 
			  array (
				0 => 
				array (
				  'href' => 'https://yourdomain.test/wp-json/wc/v1/customers/150',
				),
			  ),
			  'collection' => 
			  array (
				0 => 
				array (
				  'href' => 'https://yourdomain.test/wp-json/wc/v1/customers',
				),
			  ),
			),
			'wpwh_meta_data' => 
			array (
				'nickname' => 
				array (
				0 => 'jon.doe',
				),
				'first_name' => 
				array (
				0 => 'Jon',
				),
				'last_name' => 
				array (
				0 => 'Doe',
				),
				'description' => 
				array (
				0 => '',
				),
				'rich_editing' => 
				array (
				0 => 'true',
				),
				'syntax_highlighting' => 
				array (
				0 => 'true',
				),
				'comment_shortcuts' => 
				array (
				0 => 'false',
				),
				'admin_color' => 
				array (
				0 => 'fresh',
				),
				'use_ssl' => 
				array (
				0 => '0',
				),
				'show_admin_bar_front' => 
				array (
				0 => 'true',
				),
				'locale' => 
				array (
				0 => '',
				),
				'zipf_capabilities' => 
				array (
				0 => 'a:1:{s:8:"customer";b:1;}',
				),
				'zipf_user_level' => 
				array (
				0 => '0',
				),
				'last_update' => 
				array (
				0 => '1641461719',
				),
				'session_tokens' => 
				array (),
				'billing_first_name' => 
				array (
				0 => 'Jon',
				),
				'billing_last_name' => 
				array (
				0 => 'Doe',
				),
				'billing_company' => 
				array (
				0 => 'Demo Corp',
				),
				'billing_address_1' => 
				array (
				0 => 'Demo St. 55',
				),
				'billing_city' => 
				array (
				0 => 'Demo City',
				),
				'billing_postcode' => 
				array (
				0 => '12345',
				),
				'billing_country' => 
				array (
				0 => 'DE',
				),
				'billing_email' => 
				array (
				0 => 'demouser@yourdomain.test',
				),
				'billing_phone' => 
				array (
				0 => '123456789',
				),
				'shipping_method' => 
				array (
				0 => '',
				),
				'wc_last_active' => 
				array (
				0 => '1640649600',
				),
				'paying_customer' => 
				array (
				0 => '1',
				),
				'_last_order' => 
				array (
				0 => '8095',
				),
				'_order_count' => 
				array (
				0 => '1',
				),
				'_money_spent' => 
				array (
				0 => '0',
				),
				'billing_address_2' => 
				array (
				0 => '',
				),
				'billing_state' => 
				array (
				0 => '',
				),
				'shipping_first_name' => 
				array (
				0 => '',
				),
				'shipping_last_name' => 
				array (
				0 => '',
				),
				'shipping_company' => 
				array (
				0 => '',
				),
				'shipping_address_1' => 
				array (
				0 => '',
				),
				'shipping_address_2' => 
				array (
				0 => '',
				),
				'shipping_city' => 
				array (
				0 => '',
				),
				'shipping_postcode' => 
				array (
				0 => '',
				),
				'shipping_country' => 
				array (
				0 => '',
				),
				'shipping_state' => 
				array (
				0 => '',
				),
				'shipping_phone' => 
				array (
				0 => '',
				),
			),
		);

		return $data;
	}

  }

endif; // End if class_exists check.