<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'WP_Webhooks_Integrations_fluent_support_Triggers_flsup_ticket_response' ) ) :

 /**
  * Load the flsup_ticket_response trigger
  *
  * @since 4.3.4
  * @author Ironikus <info@ironikus.com>
  */
  class WP_Webhooks_Integrations_fluent_support_Triggers_flsup_ticket_response {

	public function get_callbacks(){

		return array(
			array(
				'type' => 'action',
				'hook' => 'fluent_support/response_added_by_agent',
				'callback' => array( $this, 'fluentcrm_flsup_ticket_response_callback' ),
				'priority' => 20,
				'arguments' => 3,
				'delayed' => true,
			),
			array(
				'type' => 'action',
				'hook' => 'fluent_support/response_added_by_customer',
				'callback' => array( $this, 'fluentcrm_flsup_ticket_response_callback' ),
				'priority' => 20,
				'arguments' => 3,
				'delayed' => true,
			),
		);
	}

	public function get_details(){

		$parameter = array(
			'response' => array( 'short_description' => __( '(Array) Further information on the given reply.', 'wp-webhooks' ) ),
			'ticket' => array( 'short_description' => __( '(Array) All ticket related information, including the customer details.', 'wp-webhooks' ) ),
			'person' => array( 'short_description' => __( '(Array) All details of the agent (or customer) that was responding to this ticket.', 'wp-webhooks' ) ),
		);

		$settings = array(
			'load_default_settings' => true,
			'data' => array(
				'wpwhpro_fluent_support_trigger_on_person_type' => array(
					'id'		  => 'wpwhpro_fluent_support_trigger_on_person_type',
					'type'		=> 'select',
					'multiple'	=> true,
					'choices'	  => array(),
					'query'			=> array(
						'filter'	=> 'helpers',
						'args'		=> array(
							'integration' => 'fluent-support',
							'helper' => 'flsup_helpers',
							'function' => 'get_query_types',
						)
					),
					'label'	   => __( 'Trigger on selected person types', 'wp-webhooks' ),
					'placeholder' => '',
					'required'	=> false,
					'description' => __( 'Trigger this webhook only when a specific type of person responded to the ticket. You can also choose multiple ones. If none is selected, all are triggered.', 'wp-webhooks' )
				),
			)
		);

		return array(
			'trigger'		   => 'flsup_ticket_response',
			'name'			  => __( 'Ticket response added', 'wp-webhooks' ),
			'sentence'			  => __( 'a response was added to a ticket', 'wp-webhooks' ),
			'parameter'		 => $parameter,
			'settings'		  => $settings,
			'returns_code'	  => $this->get_demo( array() ),
			'short_description' => __( 'This webhook fires as soon as a response was added to a ticket within Fluent Support.', 'wp-webhooks' ),
			'description'	   => array(),
			'integration'	   => 'fluent-support',
			'premium'		   => true,
		);

	}

	/**
	 * Triggers once a response was added to a ticket within Fluent Support
	 *
	 * @param object $response The ticket response
	 * @param object $ticket The ticket object
	 * @param object $person The person object
	 */
	public function fluentcrm_flsup_ticket_response_callback( $response, $ticket, $person ){

		$webhooks = WPWHPRO()->webhook->get_hooks( 'trigger', 'flsup_ticket_response' );

		$person_type = ( is_object( $person ) && isset( $person->person_type  ) ) ? $person->person_type : '';

		$payload = array(
			'response' => $response,
			'ticket' => $ticket,
			'person' => $person,
		);

		$response_data_array = array();

		foreach( $webhooks as $webhook ){

			$webhook_url_name = ( is_array($webhook) && isset( $webhook['webhook_url_name'] ) ) ? $webhook['webhook_url_name'] : null;
			$is_valid = true;

			if( isset( $webhook['settings'] ) ){

				if( isset( $webhook['settings']['wpwhpro_fluent_support_trigger_on_person_type'] ) && ! empty( $webhook['settings']['wpwhpro_fluent_support_trigger_on_person_type'] ) ){
					if( ! in_array( $person_type, $webhook['settings']['wpwhpro_fluent_support_trigger_on_person_type'] ) ){
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

		do_action( 'wpwhpro/webhooks/trigger_flsup_ticket_response', $payload, $response_data_array );
	}

	public function get_demo( $options = array() ) {

		$data = array (
			'response' => 
				array (
					'person_id' => 1,
					'ticket_id' => 1,
					'conversation_type' => 'response',
					'content' => '<p>This is a demo response from an agent.</p>
				',
					'source' => 'web',
					'content_hash' => 'b85f60317bca9af59fb95b142584bdf7',
					'updated_at' => '2022-01-22 10:30:32',
					'created_at' => '2022-01-22 10:30:32',
					'id' => 15,
					'person' => 
					array (
					'id' => 1,
					'first_name' => 'Agent',
					'last_name' => 'Demo',
					'email' => 'agent@demo.test',
					'title' => NULL,
					'avatar' => NULL,
					'person_type' => 'agent',
					'status' => 'active',
					'ip_address' => NULL,
					'last_ip_address' => NULL,
					'address_line_1' => NULL,
					'address_line_2' => NULL,
					'city' => NULL,
					'zip' => NULL,
					'state' => NULL,
					'country' => NULL,
					'note' => NULL,
					'hash' => '8ea9a292d79281xxxxxxx18625d7d30',
					'user_id' => '1',
					'description' => NULL,
					'remote_uid' => NULL,
					'last_response_at' => NULL,
					'created_at' => '2022-01-22 07:53:23',
					'updated_at' => '2022-01-22 07:53:23',
					'full_name' => 'Agent Demo',
					'photo' => 'https://www.gravatar.com/avatar/ab43f84ba71xxxxxxxxx90c9778?s=128',
					),
			),
			'ticket' => 
			array (
			  'id' => 1,
			  'customer_id' => '2',
			  'agent_id' => NULL,
			  'mailbox_id' => '1',
			  'product_id' => '0',
			  'product_source' => NULL,
			  'privacy' => 'private',
			  'priority' => 'normal',
			  'client_priority' => 'medium',
			  'status' => 'closed',
			  'title' => 'This is a demo ticket subject',
			  'slug' => 'this-is-a-demo-ticket-subject',
			  'hash' => '5207cf2073',
			  'content_hash' => '28e42a075dd070101be323505083aec6',
			  'message_id' => NULL,
			  'source' => NULL,
			  'content' => '<p>Those are the details about the ticket. </p>',
			  'secret_content' => NULL,
			  'last_agent_response' => NULL,
			  'last_customer_response' => '2022-01-22 08:15:18',
			  'waiting_since' => '2022-01-22 08:15:18',
			  'response_count' => '0',
			  'first_response_time' => NULL,
			  'total_close_time' => 37,
			  'resolved_at' => '2022-01-22 08:15:55',
			  'closed_by' => 1,
			  'created_at' => '2022-01-22 08:15:18',
			  'updated_at' => '2022-01-22 08:15:55',
			  'mailbox' => 
			  array (
				'id' => 1,
				'name' => 'Demo Business',
				'slug' => 'demo-business',
				'box_type' => 'web',
				'email' => 'demo@business.test',
				'mapped_email' => NULL,
				'email_footer' => NULL,
				'settings' => 
				array (
				  'admin_email_address' => 'demo@business.test',
				),
				'avatar' => NULL,
				'created_by' => '1',
				'is_default' => 'yes',
				'created_at' => '2022-01-22 08:14:06',
				'updated_at' => '2022-01-22 08:14:06',
			  ),
			  'customer' => 
			  array (
				'id' => 2,
				'first_name' => 'Jon',
				'last_name' => 'Doe',
				'email' => 'jondoe@democustomer.test',
				'title' => NULL,
				'avatar' => NULL,
				'person_type' => 'customer',
				'status' => 'active',
				'ip_address' => NULL,
				'last_ip_address' => NULL,
				'address_line_1' => NULL,
				'address_line_2' => NULL,
				'city' => NULL,
				'zip' => NULL,
				'state' => NULL,
				'country' => NULL,
				'note' => NULL,
				'hash' => '384ec0f98dbc0axxxx2eb73d2fcde8f',
				'user_id' => NULL,
				'description' => NULL,
				'remote_uid' => NULL,
				'last_response_at' => '2022-01-22 08:15:20',
				'created_at' => '2022-01-22 08:15:18',
				'updated_at' => '2022-01-22 08:15:20',
				'full_name' => 'Jon Doe',
				'photo' => 'https://www.gravatar.com/avatar/ab43f84ba713a84c93axxxxxxxxx?s=128',
			  ),
			),
			'person' => 
			array (
			  'id' => 1,
			  'first_name' => 'Agent',
			  'last_name' => 'Demo',
			  'email' => 'agent@demo.test',
			  'title' => NULL,
			  'avatar' => NULL,
			  'person_type' => 'agent',
			  'status' => 'active',
			  'ip_address' => NULL,
			  'last_ip_address' => NULL,
			  'address_line_1' => NULL,
			  'address_line_2' => NULL,
			  'city' => NULL,
			  'zip' => NULL,
			  'state' => NULL,
			  'country' => NULL,
			  'note' => NULL,
			  'hash' => '8ea9a292d79281xxxxe8e18625d7d30',
			  'user_id' => '1',
			  'description' => NULL,
			  'remote_uid' => NULL,
			  'last_response_at' => NULL,
			  'created_at' => '2022-01-22 07:53:23',
			  'updated_at' => '2022-01-22 07:53:23',
			  'full_name' => 'Agent Demo',
			  'photo' => 'https://www.gravatar.com/avatar/ab43f84ba713a84c93axxxxxxxxx?s=128',
			),
		);

		return $data;
	}

  }

endif; // End if class_exists check.