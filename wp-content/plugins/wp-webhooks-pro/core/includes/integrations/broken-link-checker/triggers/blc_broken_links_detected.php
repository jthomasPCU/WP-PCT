<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'WP_Webhooks_Integrations_broken_link_checker_Triggers_blc_broken_links_detected' ) ) :

 /**
  * Load the blc_broken_links_detected trigger
  *
  * @since 4.3.2
  * @author Ironikus <info@ironikus.com>
  */
  class WP_Webhooks_Integrations_broken_link_checker_Triggers_blc_broken_links_detected {

	public function get_callbacks(){

		return array(
			array(
				'type' => 'filter',
				'hook' => 'blc_allow_send_email_notification',
				'callback' => array( $this, 'blc_broken_links_detected_callback' ),
				'priority' => 20,
				'arguments' => 1,
				'delayed' => false,
			),
		);
	}

	public function get_details(){

		$parameter = array(
			'msg' => array( 'short_description' => __( '(String) The subject of the normally sent Broken Link Checker Email', 'wp-webhooks' ) ),
			'link_count' => array( 'short_description' => __( '(Integer) The number of broken links that are send within this request.', 'wp-webhooks' ) ),
			'admin_url' => array( 'short_description' => __( '(String) The URL of the Broken Link Checker admin page.', 'wp-webhooks' ) ),
			'links' => array( 'short_description' => __( '(Array) An array containing all broken links within this request + further details.', 'wp-webhooks' ) ),
		);

		$description = array(
			'tipps' => array(
				__( 'Please note: This trigger fires based on the notifications cron job (blc_cron_email_notifications). This means that based on your "Check each link" settings time, this webhook gets triggered (default: all 72 hours).', 'wp-webhooks' ),
			)
		);

		$settings = array(
			'load_default_settings' => false,
		);

		return array(
			'trigger'		   => 'blc_broken_links_detected',
			'name'			  => __( 'Broken links detected', 'wp-webhooks' ),
			'sentence'			  => __( 'broken links have been detected', 'wp-webhooks' ),
			'parameter'		 => $parameter,
			'settings'		  => $settings,
			'returns_code'	  => $this->get_demo( array() ),
			'short_description' => __( 'This webhook fires as soon as as the broken link notifications cron job is triggered and broken links have been detected within Broken Link Checker.', 'wp-webhooks' ),
			'description'	   => $description,
			'integration'	   => 'broken-link-checker',
			'premium'		   => false,
		);

	}

	/**
	 * Triggers once the notifications are about to be sent
	 *
	 * @param bool $send_notification  Whether user notifiations are sent or not
	 */
	public function blc_broken_links_detected_callback( $send_notification ){

		global $wpdb;
		 
		$webhooks = WPWHPRO()->webhook->get_hooks( 'trigger', 'blc_broken_links_detected' );
		$blc_helpers = WPWHPRO()->integrations->get_helper( 'broken-link-checker ', 'blc_helpers' );
		$response_data_array = array();

		$options = get_option( 'wsblc_options' );
		if( is_string( $options ) ){
			$options = json_decode( $options, true );
		} else {
			$options = array();
		}

		$last_notification_sent = time();
		if( isset( $options['last_notification_sent'] ) && ! empty( $options['last_notification_sent'] ) ){
			$last_notification_sent = $options['last_notification_sent'];
		}

		$send_authors_email_notifications = time();
		if( isset( $options['send_authors_email_notifications'] ) && ! empty( $options['send_authors_email_notifications'] ) ){
			$send_authors_email_notifications = $options['send_authors_email_notifications'];
		}

		$last_notification = date( 'Y-m-d H:i:s', $last_notification_sent );
		$where             = $wpdb->prepare( '( first_failure >= %s )', $last_notification );

		$links = blc_get_links(
			array(
				's_filter'             => 'broken',
				'where_expr'           => $where,
				'load_instances'       => true,
				'load_containers'      => true,
				'load_wrapped_objects' => $send_authors_email_notifications,
				'max_results'          => 0,
			)
		);

		if ( empty( $links ) ) {
			return $send_notification;
		}

		$payload = $blc_helpers->get_notification_payload( $links );

		foreach( $webhooks as $webhook ){

			$webhook_url_name = ( is_array($webhook) && isset( $webhook['webhook_url_name'] ) ) ? $webhook['webhook_url_name'] : null;
			$is_valid = true;

			if( $is_valid ){
				if( $webhook_url_name !== null ){
					$response_data_array[ $webhook_url_name ] = WPWHPRO()->webhook->post_to_webhook( $webhook, $payload );
				} else {
					$response_data_array[] = WPWHPRO()->webhook->post_to_webhook( $webhook, $payload );
				}
			}

		}

		do_action( 'wpwhpro/webhooks/trigger_blc_broken_links_detected', $payload, $response_data_array );

		return $send_notification;
	}
	
	public function get_demo( $options = array() ) {

		$data = array (
			'msg' => '[yourwebsite] Broken links detected',
			'link_count' => 2,
			'admin_url' => 'https://yourdomain.test/wp-admin/tools.php?page=view-broken-links',
			'links' => 
			array (
			  0 => 
			  array (
				'text' => 'Image',
				'url' => 'https://yourdomain.dev/wp-content/uploads/2019/12/cheap-or-luxury-travel-min.jpg',
				'src' => 'https://yourdomain.test/wp-admin/post.php?post=586&amp;action=edit',
			  ),
			  1 => 
			  array (
				'text' => 'Image',
				'url' => 'https://yourdomain.test/wp-content/uploads/icon@3x.svg',
				'src' => 'https://yourdomain.test/wp-admin/post.php?post=613&amp;action=edit',
			  ),
			),
		);

		return $data;
	}

  }

endif; // End if class_exists check.