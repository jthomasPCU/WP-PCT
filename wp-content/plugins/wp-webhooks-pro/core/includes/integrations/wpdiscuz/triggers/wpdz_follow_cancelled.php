<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'WP_Webhooks_Integrations_wpdiscuz_Triggers_wpdz_follow_cancelled' ) ) :

 /**
  * Load the wpdz_follow_cancelled trigger
  *
  * @since 5.1.1
  * @author Ironikus <info@ironikus.com>
  */
  class WP_Webhooks_Integrations_wpdiscuz_Triggers_wpdz_follow_cancelled {

	public function get_callbacks(){

		return array(
			array(
				'type' => 'action',
				'hook' => 'wpdiscuz_follow_cancelled',
				'callback' => array( $this, 'ironikus_trigger_wpdz_follow_cancelled' ),
				'priority' => 20,
				'arguments' => 1,
				'delayed' => true,
			),
		);

	}

	public function get_details(){

		$parameter = array(
			'post_id' => array( 'short_description' => __( '(Integer) The related post ID.', 'wp-webhooks' ) ),
			'user_id' => array( 'short_description' => __( '(Integer) The user ID which the user unfollowed.', 'wp-webhooks' ) ),
			'user_email' => array( 'short_description' => __( '(String) The email of the unfollowed user.', 'wp-webhooks' ) ),
			'user_name' => array( 'short_description' => __( '(String) The name of the unfollowed user.', 'wp-webhooks' ) ),
			'follower_id' => array( 'short_description' => __( '(Integer) The ID of the user who unfollowed.', 'wp-webhooks' ) ),
			'follower_email' => array( 'short_description' => __( '(String) The email of the user who unfollowed.', 'wp-webhooks' ) ),
			'follower_name' => array( 'short_description' => __( '(String) The name of the user who unfollowed.', 'wp-webhooks' ) ),
			'confirm' => array( 'short_description' => __( '(Integer) Whether the unfollow is confirmed or not.', 'wp-webhooks' ) ),
		);

	  	$settings = array(
			'load_default_settings' => true,
			'data' => array()
		);

		return array(
			'trigger'	  => 'wpdz_follow_cancelled',
			'name'	   => __( 'Follow cancelled', 'wp-webhooks' ),
			'sentence'	   => __( 'a user unfollowed a user', 'wp-webhooks' ),
			'parameter'	 => $parameter,
			'settings'	 => $settings,
			'returns_code'   => $this->get_demo( array() ),
			'short_description' => __( 'This webhook fires after user unfollowed a user within wpDiscuz.', 'wp-webhooks' ),
			'description'	=> array(),
			'integration'	=> 'wpdiscuz',
			'premium'	=> true,
		);

	}

	public function ironikus_trigger_wpdz_follow_cancelled( $args ){

		$webhooks = WPWHPRO()->webhook->get_hooks( 'trigger', 'wpdz_follow_cancelled' );
		$data_array = $args;
		$response_data = array();

		foreach( $webhooks as $webhook ){

			$is_valid = true;

			if( $is_valid ) {
			$webhook_url_name = ( is_array($webhook) && isset( $webhook['webhook_url_name'] ) ) ? $webhook['webhook_url_name'] : null;

			if( $webhook_url_name !== null ){
				$response_data[ $webhook_url_name ] = WPWHPRO()->webhook->post_to_webhook( $webhook, $data_array );
			} else {
				$response_data[] = WPWHPRO()->webhook->post_to_webhook( $webhook, $data_array );
			}
			}
		}

		do_action( 'wpwhpro/webhooks/trigger_wpdz_follow_cancelled', $data_array, $response_data );
	}

	/*
	* Register the demo post delete trigger callback
	*
	* @since 1.2
	*/
	public function get_demo( $options = array() ) {

		$data = array (
			'post_id' => '7912',
			'user_id' => '1',
			'user_email' => 'demouser@demo.test',
			'user_name' => 'demouser',
			'follower_id' => 167,
			'follower_email' => 'demfollower@demo.test',
			'follower_name' => 'demfollower@demo.test',
			'confirm' => 1,
		);

	 	return $data;
	}

  }

endif; // End if class_exists check.