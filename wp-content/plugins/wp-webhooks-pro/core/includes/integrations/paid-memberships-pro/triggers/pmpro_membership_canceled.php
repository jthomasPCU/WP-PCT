<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'WP_Webhooks_Integrations_paid_memberships_pro_Triggers_pmpro_membership_canceled' ) ) :

 /**
  * Load the pmpro_membership_canceled trigger
  *
  * @since 4.2.2
  * @author Ironikus <info@ironikus.com>
  */
  class WP_Webhooks_Integrations_paid_memberships_pro_Triggers_pmpro_membership_canceled {

  /**
   * Register the actual functionality of the webhook
   *
   * @param mixed $response
   * @param string $action
   * @param string $response_ident_value
   * @param string $response_api_key
   * @return mixed The response data for the webhook caller
   */
    public function get_callbacks(){

        return array(
            array(
                'type' => 'action',
                'hook' => 'pmpro_after_change_membership_level',
                'callback' => array( $this, 'pmpro_after_change_membership_level_callback' ),
                'priority' => 20,
                'arguments' => 3,
                'delayed' => true,
            ),
        );
    }

    public function get_details(){

        $parameter = array(
            'user_id' => array( 'short_description' => __( '(Integer) The ID of the user that the membership was canceled of.', 'wp-webhooks' ) ),
            'cancel_level' => array( 'short_description' => __( '(Integer) The ID of the canceled level.', 'wp-webhooks' ) ),
            'user' => array( 'short_description' => __( '(Array) The full WordPress user data.', 'wp-webhooks' ) ),
        );

        $settings = array(
            'load_default_settings' => true,
            'data' => array(
                'wpwhpro_pmpro_trigger_on_membership_level' => array(
                    'id'		  => 'wpwhpro_pmpro_trigger_on_membership_level',
                    'type'		=> 'select',
                    'multiple'	=> true,
                    'choices'	  => array(),
                    'query'			=> array(
                        'filter'	=> 'helpers',
                        'args'		=> array(
                            'integration' => 'paid-memberships-pro',
                            'helper' => 'pmpro_helpers',
                            'function' => 'get_query_levels',
                        )
                    ),
                    'label'	   => __( 'Trigger on selected membership level', 'wp-webhooks' ),
                    'placeholder' => '',
                    'required'	=> false,
                    'description' => __( 'Select only the membership levels you want to fire the trigger on. You can also choose multiple ones. If none is selected, all are triggered.', 'wp-webhooks' )
                ),
            )
        );

        return array(
            'trigger'           => 'pmpro_membership_canceled',
            'name'              => __( 'Membership canceled', 'wp-webhooks' ),
            'sentence'              => __( 'a membership was canceled', 'wp-webhooks' ),
            'parameter'         => $parameter,
            'settings'          => $settings,
            'returns_code'      => $this->get_demo( array() ),
            'short_description' => __( 'This webhook fires as soon as a membership was canceled within Paid Memberships Pro.', 'wp-webhooks' ),
            'description'       => array(),
            'integration'       => 'paid-memberships-pro',
        );

    }

    /**
     * Triggers once a Paid Membership Pro membership was canceled
     *
     * @param int $level_id ID of the level changed to.
	 * @param int $user_id ID of the user changed to.
	 * @param int $cancel_level ID of the level being cancelled if specified.
     */
    public function pmpro_after_change_membership_level_callback( $level_id, $user_id, $cancel_level ){

        //Only continue if a cancelation is given
        if( ! is_numeric( $cancel_level ) ){
            return;
        }

        $webhooks = WPWHPRO()->webhook->get_hooks( 'trigger', 'pmpro_membership_canceled' );

        $payload = array(
            'user_id' => $user_id,
            'cancel_level' => $cancel_level,
            'user' => get_userdata( $user_id ),
        );

        $response_data_array = array();

        foreach( $webhooks as $webhook ){

            $webhook_url_name = ( is_array($webhook) && isset( $webhook['webhook_url_name'] ) ) ? $webhook['webhook_url_name'] : null;
            $is_valid = true;

            if( isset( $webhook['settings'] ) ){
                if( isset( $webhook['settings']['wpwhpro_pmpro_trigger_on_membership_level'] ) && ! empty( $webhook['settings']['wpwhpro_pmpro_trigger_on_membership_level'] ) ){
                    if( ! in_array( $cancel_level, $webhook['settings']['wpwhpro_pmpro_trigger_on_membership_level'] ) ){
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

        do_action( 'wpwhpro/webhooks/trigger_pmpro_membership_canceled', $payload, $response_data_array );
    }

    public function get_demo( $options = array() ) {

        $data = array (
            'user_id' => 122,
            'cancel_level' => 12,
            'user' => 
            array (
              'data' => 
              array (
                'ID' => '122',
                'user_login' => 'jon-doe',
                'user_pass' => '$P$BYHHFjHILOQENvBQKLWXXXXXXXX',
                'user_nicename' => 'jon-doe',
                'user_email' => 'jon@doe.test',
                'user_url' => '',
                'user_registered' => '2020-01-15 09:34:16',
                'user_activation_key' => '',
                'user_status' => '0',
                'display_name' => 'Jon Doe',
                'spam' => '0',
                'deleted' => '0',
              ),
              'ID' => 122,
              'caps' => 
              array (
                'author' => true,
              ),
              'cap_key' => 'wp_capabilities',
              'roles' => 
              array (
                0 => 'author',
              ),
              'allcaps' => 
              array (
                'upload_files' => true,
                'edit_posts' => true,
                'edit_published_posts' => true,
                'publish_posts' => true,
                'read' => true,
                'level_2' => true,
                'level_1' => true,
                'level_0' => true,
                'delete_posts' => true,
                'delete_published_posts' => true,
                'edit_blocks' => true,
                'publish_blocks' => true,
                'read_blocks' => true,
                'delete_blocks' => true,
                'delete_published_blocks' => true,
                'edit_published_blocks' => true,
                'create_blocks' => true,
                'edit_aggregator-records' => true,
                'edit_published_aggregator-records' => true,
                'delete_aggregator-records' => true,
                'delete_published_aggregator-records' => true,
                'publish_aggregator-records' => true,
                'groups_access' => true,
                'author' => true,
              ),
              'filter' => NULL,
            ),
        );

        return $data;
    }

  }

endif; // End if class_exists check.