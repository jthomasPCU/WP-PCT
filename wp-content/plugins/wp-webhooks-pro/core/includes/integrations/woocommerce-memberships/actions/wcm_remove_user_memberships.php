<?php
if ( ! class_exists( 'WP_Webhooks_Integrations_woocommerce_memberships_Actions_wcm_remove_user_memberships' ) ) :

	/**
	 * Load the wcm_remove_user_memberships action
	 *
	 * @since 4.3.7
	 * @author Ironikus <info@ironikus.com>
	 */
	class WP_Webhooks_Integrations_woocommerce_memberships_Actions_wcm_remove_user_memberships {

	public function get_details(){

			$parameter = array(
				'membership_ids'	=> array( 'required' => true, 'short_description' => __( 'The membership IDs of the memberships you want to delete. You can also use single user membership IDs.', 'wp-webhooks' ) ),
				'user'		=> array( 'required' => true, 'short_description' => __( 'A user ID or user email in case you want to remove all memberships for a user.', 'wp-webhooks' ) ),
				'do_action'	  => array( 'short_description' => __( 'Advanced: Register a custom action after Webhooks Pro fires this webhook. More infos are in the description.', 'wp-webhooks' ) )
			);

			$returns = array(
				'success'		=> array( 'short_description' => __( '(Bool) True if the action was successful, false if not. E.g. array( \'success\' => true )', 'wp-webhooks' ) ),
				'data'		=> array( 'short_description' => __( '(array) Further data about the fired actions.', 'wp-webhooks' ) ),
				'msg'		=> array( 'short_description' => __( '(string) A message with more information about the current request. E.g. array( \'msg\' => "This action was successful." )', 'wp-webhooks' ) ),
			);

			ob_start();
		?>
<?php echo __( "In case you want to remove multiple user memberships from a user, you can either comma-separate them like <code>2,3,12,44</code>, or you can add them via a JSON construct:", 'wp-webhooks' ); ?>
<pre>{
  23,
  3,
  44
}</pre>
<?php echo __( "Set this argument to <strong>all</strong> to delete all active memberships for a user. This requires to also set the user argument.", 'wp-webhooks' ); ?>
		<?php
		$parameter['membership_ids']['description'] = ob_get_clean();

			ob_start();
		?>
<?php echo __( "The <strong>do_action</strong> argument is an advanced webhook for developers. It allows you to fire a custom WordPress hook after the <strong>wcm_remove_user_memberships</strong> action was fired.", 'wp-webhooks' ); ?>
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

		$returns_code = array (
			'success' => true,
			'msg' => 'The user memberships have been successfully removed.',
			'data' => 
			array (
			  'membership_id' => 0,
			  'membership_ids' => 9145,
			  'user_id' => 0,
			  'product_id' => 0,
			  'order_id' => 0,
			  'deleted_memberships' => 
			  array (
				9145 => 
				array (
				  'success' => true,
				  'user_id' => 0,
				  'membership_id' => 9145,
				  'response' => 
				  array (
					'ID' => 9145,
					'post_author' => '79',
					'post_date' => '2022-03-11 08:28:06',
					'post_date_gmt' => '2022-03-11 08:28:06',
					'post_content' => '',
					'post_title' => '',
					'post_excerpt' => '',
					'post_status' => 'wcm-active',
					'comment_status' => 'open',
					'ping_status' => 'closed',
					'post_password' => 'um_622b0816055e6',
					'post_name' => '9145',
					'to_ping' => '',
					'pinged' => '',
					'post_modified' => '2022-03-11 08:28:06',
					'post_modified_gmt' => '2022-03-11 08:28:06',
					'post_content_filtered' => '',
					'post_parent' => 9143,
					'guid' => 'https://yourdomain.test/?post_type=wc_user_membership&p=9145',
					'menu_order' => 0,
					'post_type' => 'wc_user_membership',
					'post_mime_type' => '',
					'comment_count' => '0',
					'filter' => 'raw',
				  ),
				),
			  ),
			),
		);

		return array(
			'action'			=> 'wcm_remove_user_memberships', //required
			'name'			   => __( 'Remove user memberships', 'wp-webhooks' ),
			'sentence'			   => __( 'remove one or multiple user memberships', 'wp-webhooks' ),
			'parameter'		 => $parameter,
			'returns'		   => $returns,
			'returns_code'	  => $returns_code,
			'short_description' => __( 'Remove one or multiple user memberships within "WooCommerce Memberships".', 'wp-webhooks' ),
			'description'	   => array(),
			'integration'	   => 'woocommerce-memberships',
			'premium'	   	=> true,
		);


		}

		public function execute( $return_data, $response_body ){

			$return_args = array(
				'success' => false,
				'msg' => '',
				'data' => array(
					'membership_id' => 0,
					'membership_ids' => 0,
					'user_id' => 0,
					'product_id' => 0,
					'order_id' => 0,
				)
			);

			$membership_ids = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'membership_ids' );
			$user = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'user' );
			$do_action	  = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'do_action' );

			if( empty( $membership_ids ) ){
				$return_args['msg'] = __( "Please set the membership_ids argument.", 'action-wcm_remove_user_memberships-error' );
				return $return_args;
			}

			$user_id = 0;

            if( ! empty( $user ) && is_numeric( $user ) ){
                $user_id = intval( $user );
            } elseif( ! empty( $user ) && is_email( $user ) ) {
                $user_data = get_user_by( 'email', $user );
                if( ! empty( $user_data ) && isset( $user_data->ID ) && ! empty( $user_data->ID ) ){
                    $user_id = $user_data->ID;
                }
            }

			$deleted_memberships = array();
			$memberships = array();
			if( $membership_ids === 'all' ){

				if( empty( $user_id ) ){
					$return_args['msg'] = __( "We could not find a user for your given user id.", 'action-wpfs_add_tags-error' );
					return $return_args;
				}

				$user_memberships = wc_memberships_get_user_memberships( $user_id );

				if( ! empty( $user_memberships ) ){
					foreach ( $user_memberships as $membership ) {
						$membership_id = $membership->get_id();
						$memberships[ $membership_id ] = intval( $membership_id );
					}
				}

			} else {
				$memberships_array = array_map( "trim", explode( ',', $membership_ids ) );
				foreach( $memberships_array as $sugk => $sugv ){

					$membership_id = intval( $sugv );
					$membership_post_type = get_post_type( $membership_id );

					//Abort if the ID doesnt belong to any of the given types
					if( $membership_post_type !== 'wc_user_membership' && $membership_post_type !== 'wc_membership_plan' ){
						continue;
					}

					if( ! empty( $membership_id ) ){
						if( $membership_post_type === 'wc_membership_plan' ){
							$user_memberships = wc_memberships_get_user_memberships( $user_id );

							if( ! empty( $user_memberships ) ){
								foreach ( $user_memberships as $membership ) {
									$user_membership_id = intval( $membership->get_id() );
									$user_membership_plan_id = intval( $membership->get_plan_id() );

									if( $user_membership_plan_id === $membership_id ){
										$memberships[ $user_membership_id ] = intval( $user_membership_id );
									}
									
								}
							}
						} else {
							$memberships[ $membership_id ] = $membership_id;
						}
					}
					
				}
			}

			foreach( $memberships as $single_membership_id ){

				$check = wp_delete_post( $single_membership_id );

				if( $check ){
					$deleted_memberships[ $single_membership_id ] = array(
						'success' => true,
						'user_id' => $user_id,
						'membership_id' => $single_membership_id,
						'response' => $check,
					);
				}
				
			}
			
			if( $deleted_memberships ){
				$return_args['success'] = true;
				$return_args['msg'] = __( "The user memberships have been successfully removed.", 'action-wcm_remove_user_memberships-success' );
				$return_args['data']['deleted_memberships'] = $deleted_memberships;
				$return_args['data']['membership_ids'] = $membership_ids;
				$return_args['data']['user_id'] = $user_id;
			} else {
				$return_args['msg'] = __( "No memberships have been removed", 'action-wcm_remove_user_memberships-success' );
				$return_args['data']['deleted_memberships'] = $deleted_memberships;
				$return_args['data']['membership_ids'] = $membership_ids;
				$return_args['data']['user_id'] = $user_id;
			}
			

			if( ! empty( $do_action ) ){
				do_action( $do_action, $return_args );
			}

			return $return_args;
	
		}

	}

endif; // End if class_exists check.