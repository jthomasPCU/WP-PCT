<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'WP_Webhooks_Integrations_givewp_Triggers_give_donation_completed' ) ) :

 /**
  * Load the give_donation_completed trigger
  *
  * @since 4.3.4
  * @author Ironikus <info@ironikus.com>
  */
  class WP_Webhooks_Integrations_givewp_Triggers_give_donation_completed {

	public function get_callbacks(){

		return array(
			array(
				'type' => 'action',
				'hook' => 'give_update_payment_status',
				'callback' => array( $this, 'give_donation_completed_callback' ),
				'priority' => 20,
				'arguments' => 3,
				'delayed' => true,
			),
		);
	}

	public function get_details(){

		$parameter = array(
			'payment_id' => array( 'short_description' => __( '(Integer) The id of the current payment.', 'wp-webhooks' ) ),
			'old_status' => array( 'short_description' => __( '(String) The previous status of the payment.', 'wp-webhooks' ) ),
			'payment' => array( 'short_description' => __( '(Array) All related data to the payment itself.', 'wp-webhooks' ) ),
		);

		$settings = array(
			'load_default_settings' => true,
			'data' => array(
				'wpwhpro_givewp_trigger_on_selected_forms' => array(
					'id'		  => 'wpwhpro_givewp_trigger_on_selected_forms',
					'type'		=> 'select',
					'multiple'	=> true,
					'choices'	  => array(),
					'query'			=> array(
						'filter'	=> 'posts',
						'args'		=> array(
							'post_type' => 'give_forms'
						)
					),
					'label'	   => __( 'Trigger on selected forms', 'wp-webhooks' ),
					'placeholder' => '',
					'required'	=> false,
					'description' => __( 'Select only the give forms you want to fire the trigger on. You can also choose multiple ones. If none is selected, all are triggered.', 'wp-webhooks' )
				),
			)
		);

		return array(
			'trigger'		   => 'give_donation_completed',
			'name'			  => __( 'Donation completed', 'wp-webhooks' ),
			'sentence'			  => __( 'a donation was completed', 'wp-webhooks' ),
			'parameter'		 => $parameter,
			'settings'		  => $settings,
			'returns_code'	  => $this->get_demo( array() ),
			'short_description' => __( 'This webhook fires as soon as a donation was completed within GiveWP.', 'wp-webhooks' ),
			'description'	   => array(),
			'integration'	   => 'givewp',
			'premium'		   => false,
		);

	}

	public function give_donation_completed_callback( $payment_id, $status, $old_status ){

		if( $status !== 'publish' ){
			return;
		}

		$webhooks = WPWHPRO()->webhook->get_hooks( 'trigger', 'give_donation_completed' );
		$response_data_array = array();
		$payment = new Give_Payment( $payment_id );

		$payload = array(
			'payment_id' => $payment_id,
			'old_status' => $old_status,
			'payment' => array(
				'id' => $payment->ID,
				'new' => $payment->new,
				'number' => $payment->number,
				'mode' => $payment->mode,
				'import' => $payment->import,
				'key' => $payment->key,
				'form_title' => $payment->form_title,
				'form_id' => $payment->form_id,
				'price_id' => $payment->price_id,
				'total' => $payment->total,
				'subtotal' => $payment->subtotal,
				'date' => $payment->date,
				'post_date' => $payment->post_date,
				'completed_date' => $payment->completed_date,
				'status' => $payment->status,
				'status_nicename' => $payment->status_nicename,
				'customer_id' => $payment->customer_id,
				'donor_id' => $payment->donor_id,
				'user_id' => $payment->user_id,
				'title_prefix' => $payment->title_prefix,
				'first_name' => $payment->first_name,
				'last_name' => $payment->last_name,
				'email' => $payment->email,
				'address' => $payment->address,
				'transaction_id' => $payment->transaction_id,
				'ip' => $payment->ip,
				'gateway' => $payment->gateway,
				'currency' => $payment->currency,
				'parent_payment' => $payment->parent_payment,
			),
		);

		foreach( $webhooks as $webhook ){

			$webhook_url_name = ( is_array($webhook) && isset( $webhook['webhook_url_name'] ) ) ? $webhook['webhook_url_name'] : null;
			$is_valid = true;

			if( isset( $webhook['settings'] ) ){

				if( isset( $webhook['settings']['wpwhpro_givewp_trigger_on_selected_forms'] ) && ! empty( $webhook['settings']['wpwhpro_givewp_trigger_on_selected_forms'] ) ){
					if( ! in_array( $payment->form_id, $webhook['settings']['wpwhpro_givewp_trigger_on_selected_forms'] ) ){
						$is_valid = false;
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

		do_action( 'wpwhpro/webhooks/trigger_give_donation_completed', $payload, $response_data_array );
	}

	public function get_demo( $options = array() ) {

		$data = array (
			'payment_id' => 9067,
			'old_status' => 'pending',
			'payment' => 
			array (
			  'id' => 9067,
			  'new' => false,
			  'number' => '3',
			  'mode' => 'test',
			  'import' => false,
			  'key' => '15dec3828eb4dff030a028c8fad12829',
			  'form_title' => 'Donation Form',
			  'form_id' => '9063',
			  'price_id' => '3',
			  'total' => 100,
			  'subtotal' => 100,
			  'date' => '2022-01-24 04:20:48',
			  'post_date' => '2022-01-24 04:20:48',
			  'completed_date' => '2022-01-24 04:20:49',
			  'status' => 'publish',
			  'status_nicename' => 'Complete',
			  'customer_id' => '1',
			  'donor_id' => '1',
			  'user_id' => 1,
			  'title_prefix' => '',
			  'first_name' => 'Demo',
			  'last_name' => 'User',
			  'email' => 'demo@user.test',
			  'address' => 
			  array (
				'line1' => '',
				'line2' => '',
				'city' => '',
				'state' => '',
				'zip' => '',
				'country' => '',
			  ),
			  'transaction_id' => 9067,
			  'ip' => '127.0.0.1',
			  'gateway' => 'manual',
			  'currency' => 'USD',
			  'parent_payment' => 0,
			),
		);

		return $data;
	}

  }

endif; // End if class_exists check.