<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'WP_Webhooks_Integrations_learndash_Triggers_ld_topic_completed' ) ) :

 /**
  * Load the ld_topic_completed trigger
  *
  * @since 4.3.2
  * @author Ironikus <info@ironikus.com>
  */
  class WP_Webhooks_Integrations_learndash_Triggers_ld_topic_completed {

	public function get_callbacks(){

		return array(
			array(
				'type' => 'action',
				'hook' => 'learndash_topic_completed',
				'callback' => array( $this, 'learndash_topic_completed_callback' ),
				'priority' => 20,
				'arguments' => 1,
				'delayed' => true,
			),
		);
	}

	public function get_details(){

		$parameter = array(
			'user_id' => array( 'short_description' => __( '(Integer) The id of the user that completed the course.', 'wp-webhooks' ) ),
			'course_id' => array( 'short_description' => __( '(Integer) The ID of the related course.', 'wp-webhooks' ) ),
			'lesson_id' => array( 'short_description' => __( '(Integer) The ID of the related lesson.', 'wp-webhooks' ) ),
			'topic_id' => array( 'short_description' => __( '(Integer) The ID of the related topic.', 'wp-webhooks' ) ),
			'user' => array( 'short_description' => __( '(Array) Further details about the user.', 'wp-webhooks' ) ),
			'course' => array( 'short_description' => __( '(Array) All details of the course.', 'wp-webhooks' ) ),
			'lesson' => array( 'short_description' => __( '(Array) All details of the lesson.', 'wp-webhooks' ) ),
			'topic' => array( 'short_description' => __( '(Array) All details of the topic.', 'wp-webhooks' ) ),
			'progress' => array( 'short_description' => __( '(Array) An array containing further details of the progress.', 'wp-webhooks' ) ),
		);

		$settings = array(
			'load_default_settings' => true,
			'data' => array(
				'wpwhpro_learndash_trigger_on_courses' => array(
					'id'		  => 'wpwhpro_learndash_trigger_on_courses',
					'type'		=> 'select',
					'multiple'	=> true,
					'choices'	  => array(),
					'query'			=> array(
						'filter'	=> 'posts',
						'args'		=> array(
							'post_type' => 'sfwd-courses',
							'post_status' => 'publish',
						)
					),
					'label'	   => __( 'Trigger on selected courses', 'wp-webhooks' ),
					'placeholder' => '',
					'required'	=> false,
					'description' => __( 'Select only the courses you want to fire the trigger on. You can also choose multiple ones. If none is selected, all are triggered.', 'wp-webhooks' )
				),
			)
		);

		return array(
			'trigger'		   => 'ld_topic_completed',
			'name'			  => __( 'Topic completed', 'wp-webhooks' ),
			'sentence'			  => __( 'a topic was completed', 'wp-webhooks' ),
			'parameter'		 => $parameter,
			'settings'		  => $settings,
			'returns_code'	  => $this->get_demo( array() ),
			'short_description' => __( 'This webhook fires as soon as a topic was completed within LearnDash.', 'wp-webhooks' ),
			'description'	   => array(),
			'integration'	   => 'learndash',
			'premium'		   => false,
		);

	}

	/**
	 * Triggers once a topic was completed within LearnDash
	 *
	 * @param array $data Further information about the course and the user
	 */
	public function learndash_topic_completed_callback( $data ){

		$webhooks = WPWHPRO()->webhook->get_hooks( 'trigger', 'ld_topic_completed' );

		$payload = array(
			'user_id' => ( isset( $data['user'] ) && is_object( $data['user'] ) ) ? $data['user']->ID : 0,
			'course_id' => ( isset( $data['course'] ) && is_object( $data['course'] ) ) ? $data['course']->ID : 0,
			'lesson_id' => ( isset( $data['lesson'] ) && is_object( $data['lesson'] ) ) ? $data['lesson']->ID : 0,
			'topic_id' => ( isset( $data['topic'] ) && is_object( $data['topic'] ) ) ? $data['topic']->ID : 0,
		);
		$payload = array_merge( $payload, $data );

		$response_data_array = array();

		foreach( $webhooks as $webhook ){

			$webhook_url_name = ( is_array($webhook) && isset( $webhook['webhook_url_name'] ) ) ? $webhook['webhook_url_name'] : null;
			$is_valid = true;

			if( isset( $webhook['settings'] ) ){

				if( $is_valid && isset( $webhook['settings']['wpwhpro_learndash_trigger_on_courses'] ) && ! empty( $webhook['settings']['wpwhpro_learndash_trigger_on_courses'] ) ){
					if( ! in_array( $payload['course_id'], $webhook['settings']['wpwhpro_learndash_trigger_on_courses'] ) ){
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

		do_action( 'wpwhpro/webhooks/trigger_ld_topic_completed', $payload, $response_data_array );
	}

	public function get_demo( $options = array() ) {

		$data = array (
			'user_id' => 1,
			'course_id' => 8053,
			'lesson_id' => 8055,
			'topic_id' => 8075,
			'user' => 
			array (
			  'data' => 
			  array (
				'ID' => '1',
				'user_login' => 'admin',
				'user_pass' => '$P$B4B1t8fCUMzXXXXXXX7EbzY1',
				'user_nicename' => 'jondoe',
				'user_email' => 'jon@doe.test',
				'user_url' => '',
				'user_registered' => '2017-07-27 23:58:11',
				'user_activation_key' => '',
				'user_status' => '0',
				'display_name' => 'jondoe',
				'spam' => '0',
				'deleted' => '0',
				'membership_level' => 
				array (
				  'ID' => '1',
				  'id' => '1',
				  'subscription_id' => '6',
				  'name' => 'First Level',
				  'description' => 'This is a demo level',
				  'confirmation' => '',
				  'expiration_number' => '0',
				  'expiration_period' => '',
				  'allow_signups' => '1',
				  'initial_payment' => 0,
				  'billing_amount' => 0,
				  'cycle_number' => '0',
				  'cycle_period' => '',
				  'billing_limit' => '0',
				  'trial_amount' => 0,
				  'trial_limit' => '0',
				  'code_id' => '0',
				  'startdate' => '1626948898',
				  'enddate' => NULL,
				  'categories' => 
				  array (
				  ),
				),
				'membership_levels' => 
				array (
				  0 => 
				  array (
					'ID' => '1',
					'id' => '1',
					'subscription_id' => '6',
					'name' => 'First Level',
					'description' => 'This is a demo level',
					'confirmation' => '',
					'expiration_number' => '0',
					'expiration_period' => '',
					'initial_payment' => 0,
					'billing_amount' => 0,
					'cycle_number' => '0',
					'cycle_period' => '',
					'billing_limit' => '0',
					'trial_amount' => 0,
					'trial_limit' => '0',
					'code_id' => '0',
					'startdate' => '1626948898',
					'enddate' => NULL,
				  ),
				),
			  ),
			  'ID' => 1,
			  'caps' => 
			  array (
				'read' => true,
			  ),
			  'filter' => NULL,
			),
			'course' => 
			array (
				'ID' => 8053,
				'post_author' => '1',
				'post_date' => '2021-12-17 18:03:08',
				'post_date_gmt' => '2021-12-17 18:03:08',
				'post_content' => '<!-- wp:paragraph -->
			<p>Some course content</p>
			<!-- /wp:paragraph -->',
				'post_title' => 'Another Course',
				'post_excerpt' => '',
				'post_status' => 'publish',
				'comment_status' => 'closed',
				'ping_status' => 'closed',
				'post_password' => '',
				'post_name' => 'another-course',
				'to_ping' => '',
				'pinged' => '',
				'post_modified' => '2021-12-17 18:06:07',
				'post_modified_gmt' => '2021-12-17 18:06:07',
				'post_content_filtered' => '',
				'post_parent' => 0,
				'guid' => 'https://doe.test/?post_type=sfwd-courses&#038;p=8053',
				'menu_order' => 0,
				'post_type' => 'sfwd-courses',
				'post_mime_type' => '',
				'comment_count' => '0',
				'filter' => 'raw',
			),
			'lesson' => 
			array (
				'ID' => 8055,
				'post_author' => '1',
				'post_date' => '2021-12-17 18:05:44',
				'post_date_gmt' => '2021-12-17 18:05:44',
				'post_content' => '<!-- wp:paragraph -->
			<p>This is another demo lesson</p>
			<!-- /wp:paragraph -->',
				'post_title' => 'Demo Lesson 1',
				'post_excerpt' => '',
				'post_status' => 'publish',
				'comment_status' => 'closed',
				'ping_status' => 'closed',
				'post_password' => '',
				'post_name' => 'demo-lesson-1',
				'to_ping' => '',
				'pinged' => '',
				'post_modified' => '2021-12-17 18:06:26',
				'post_modified_gmt' => '2021-12-17 18:06:26',
				'post_content_filtered' => '',
				'post_parent' => 0,
				'guid' => 'https://doe.test?post_type=sfwd-lessons&#038;p=8055',
				'menu_order' => 1,
				'post_type' => 'sfwd-lessons',
				'post_mime_type' => '',
				'comment_count' => '0',
				'filter' => 'raw',
			),
			'topic' => 
			array (
				'ID' => 8075,
				'post_author' => '1',
				'post_date' => '2021-12-18 12:20:22',
				'post_date_gmt' => '2021-12-18 12:20:22',
				'post_content' => '',
				'post_title' => 'Demo Topic 1',
				'post_excerpt' => '',
				'post_status' => 'publish',
				'comment_status' => 'closed',
				'ping_status' => 'closed',
				'post_password' => '',
				'post_name' => 'demo-topic-1',
				'to_ping' => '',
				'pinged' => '',
				'post_modified' => '2021-12-18 12:20:37',
				'post_modified_gmt' => '2021-12-18 12:20:37',
				'post_content_filtered' => '',
				'post_parent' => 0,
				'guid' => 'https://doe.test/?post_type=sfwd-topic&#038;p=8075',
				'menu_order' => 0,
				'post_type' => 'sfwd-topic',
				'post_mime_type' => '',
				'comment_count' => '0',
				'filter' => 'raw',
			),
			'progress' => 
			array (
				'lessons' => 
				array (
				8055 => 0,
				8057 => 0,
				),
				'topics' => 
				array (
				8055 => 
				array (
					8075 => 1,
				),
				8057 => 
				array (
				),
				),
				'completed' => 1,
				'total' => 3,
				'last_id' => 8075,
				'status' => 'not_started',
			),
		  );

		return $data;
	}

  }

endif; // End if class_exists check.