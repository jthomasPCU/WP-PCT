<?php
if ( ! class_exists( 'WP_Webhooks_Integrations_learndash_Actions_ld_lesson_incomplete' ) ) :

	/**
	 * Load the ld_lesson_incomplete action
	 *
	 * @since 4.3.2
	 * @author Ironikus <info@ironikus.com>
	 */
	class WP_Webhooks_Integrations_learndash_Actions_ld_lesson_incomplete {

	public function get_details(){

			$parameter = array(
				'user_id'		=> array( 'required' => true, 'short_description' => __( 'The user id (or user email) of the user you want to mark the lesson as incomplete.', 'wp-webhooks' ) ),
				'course_id'	=> array( 'required' => true, 'short_description' => __( 'The id of the course you want to set the lesson to incomplete.', 'wp-webhooks' ) ),
				'lesson_ids'	=> array( 'short_description' => __( 'Add the lesson IDs of the lessons you want to mark as incomplete. This argument accepts the value "all", a single lesson id, or a comma-separated string of course IDs.', 'wp-webhooks' ) ),
				'do_action'	  => array( 'short_description' => __( 'Advanced: Register a custom action after Webhooks Pro fires this webhook. More infos are in the description.', 'wp-webhooks' ) ),
			);

			$returns = array(
				'success'		=> array( 'short_description' => __( '(Bool) True if the action was successful, false if not. E.g. array( \'success\' => true )', 'wp-webhooks' ) ),
				'data'		=> array( 'short_description' => __( '(array) Further data about the fired triggers.', 'wp-webhooks' ) ),
				'msg'		=> array( 'short_description' => __( '(string) A message with more information about the current request. E.g. array( \'msg\' => "This action was successful." )', 'wp-webhooks' ) ),
			);

			ob_start();
		?>
<?php echo __( "This argument accepts the value 'all' to set all lessons as incomplete, a single lesson id, as well as multiple lesson ids, separated by commas (Multiple lesson ids will set all the lessons to completed for the given course of the specified user):", 'wp-webhooks' ); ?>
<pre>124,5741,23</pre>
		<?php
		$parameter['lesson_ids']['description'] = ob_get_clean();

			ob_start();
		?>
<?php echo __( "The <strong>do_action</strong> argument is an advanced webhook for developers. It allows you to fire a custom WordPress hook after the <strong>ld_lesson_incomplete</strong> action was fired.", 'wp-webhooks' ); ?>
<br>
<?php echo __( "You can use it to trigger further logic after the webhook action. Here's an example:", 'wp-webhooks' ); ?>
<br>
<br>
<?php echo __( "Let's assume you set for the <strong>do_action</strong> parameter <strong>fire_this_function</strong>. In this case, we will trigger an action with the hook name <strong>fire_this_function</strong>. Here's how the code would look in this case:", 'wp-webhooks' ); ?>
<pre>add_action( 'fire_this_function', 'my_custom_callback_function', 20, 1 );
function my_custom_callback_function( $return_args ){
	//run your custom logic in here
}
</pre>
<?php echo __( "Here's an explanation to each of the variables that are sent over within the custom function.", 'wp-webhooks' ); ?>
<ol>
	<li>
		<strong>$return_args</strong> (array)<br>
		<?php echo __( "All the values that are sent back as a response to the initial webhook action caller.", 'wp-webhooks' ); ?>
	</li>
</ol>
		<?php
		$parameter['do_action']['description'] = ob_get_clean();

		$returns_code = array(
			'success' => true,
			'msg' => 'The lessons have been successfully marked as icompleted.',
			'data' => 
			array (
			  'user_id' => 1,
			  'lesson_ids' => 
			  array (
				0 => '8055',
			  ),
			  'lessons_completed' => 
			  array (
			  ),
			  'lessons_incompleted' => 
			  array (
				'success' => false,
				'lessons' => 
				array (
				  8055 => 
				  array (
					'user_id' => 1,
					'course_id' => 8053,
					'lesson_id' => 8055,
					'response' => false,
					'incompleted_topics' => 
					array (
					  'success' => true,
					  'topics' => 
					  array (
						8075 => 
						array (
						  'user_id' => 1,
						  'course_id' => 8053,
						  'lesson_id' => 8055,
						  'topic_id' => 8075,
						  'response' => true,
						  'deleted_quiz_progress' => 
						  array (
						  ),
						),
					  ),
					),
					'deleted_quiz_progress' => 
					array (
					),
				  ),
				),
			  ),
			),
		);

		$description = array(
			'tipps' => array(
				__( 'If you do not set the <strong>lesson_ids</strong> argument (or you set its value to "all"), we will mark all lessons for the given course and user as incomplete.', 'wp-webhooks' ),
				__( 'Marking a lesson as incomplete will also set all of its topics to incomplete for the specified user.', 'wp-webhooks' ),
			),
		);

		return array(
			'action'			=> 'ld_lesson_incomplete', //required
			'name'			   => __( 'Mark lesson incomplete', 'wp-webhooks' ),
			'sentence'			   => __( 'mark a lesson as incomplete', 'wp-webhooks' ),
			'parameter'		 => $parameter,
			'returns'		   => $returns,
			'returns_code'	  => $returns_code,
			'short_description' => __( 'Mark one or multiple lessons of a course as incomplete for a user within Learndash.', 'wp-webhooks' ),
			'description'	   => $description,
			'integration'	   => 'learndash',
			'premium'		   => true,
		);


		}

		public function execute( $return_data, $response_body ){

			$ld_helpers = WPWHPRO()->integrations->get_helper( 'learndash', 'ld_helpers' );
			$return_args = array(
				'success' => false,
				'msg' => '',
				'data' => array(
					'user_id' => 0,
					'lesson_ids' => 0,
					'lessons_incompleted' => array(),
				),
			);

			$user_id		= WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'user_id' );
			$course_id		= intval( WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'course_id' ) );
			$lesson_ids		= WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'lesson_ids' );
			$do_action	  = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'do_action' );

			if( empty( $user_id ) || empty( $course_id ) ){
				$return_args['msg'] = __( "Please set the user_id and course_id arguments.", 'action-ld_lesson_incomplete-error' );
				return $return_args;
			}

			if( empty( $lesson_ids ) ){
				$lesson_ids = 'all';
			}

			if( is_numeric( $user_id ) ){
				$user_id = intval( $user_id );
			} elseif( ! empty( $user_id ) && is_email( $user_id ) ) {
				$user_data = get_user_by( 'email', $user_id );
				if( ! empty( $user_data ) && isset( $user_data->ID ) ){
					$user_id = $user_data->ID;
				}
			}

			$validated_lesson_ids = array();
			if( $lesson_ids === 'all' ){
				$validated_lesson_ids = 'all';
			} else {
				$validated_lesson_ids = array_map( "trim", explode( ',', $lesson_ids ) );
			}

			$lessons_incompleted = $ld_helpers->incomplete_lessons( $user_id, $course_id, $validated_lesson_ids );

			if( $lessons_incompleted ){
				$return_args['success'] = true;
				$return_args['msg'] = __( "The lessons have been successfully marked as icompleted.", 'action-ld_lesson_incomplete-success' );
				$return_args['data']['user_id'] = $user_id;
				$return_args['data']['lesson_ids'] = $validated_lesson_ids;
				$return_args['data']['lessons_incompleted'] = $lessons_incompleted;
			} else {
				$return_args['msg'] = __( "The lessons could not be fully marked as incompleted.", 'action-ld_lesson_incomplete-success' );
				$return_args['data']['user_id'] = $user_id;
				$return_args['data']['lesson_ids'] = $validated_lesson_ids;
				$return_args['data']['lessons_incompleted'] = $lessons_incompleted;
			}

			if( ! empty( $do_action ) ){
				do_action( $do_action, $return_args );
			}

			return $return_args;
	
		}

	}

endif; // End if class_exists check.