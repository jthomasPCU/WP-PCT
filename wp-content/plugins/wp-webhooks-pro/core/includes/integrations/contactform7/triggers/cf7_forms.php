<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'WP_Webhooks_Integrations_contactform7_Triggers_cf7_forms' ) ) :

 /**
  * Load the cf7_forms trigger
  *
  * @since 4.1.0
  * @author Ironikus <info@ironikus.com>
  */
  class WP_Webhooks_Integrations_contactform7_Triggers_cf7_forms {

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
				'hook' => 'wpcf7_mail_sent',
				'callback' => array( $this, 'wpwh_wpcf7_mail_sent' ),
				'priority' => 10,
				'arguments' => 1,
				'delayed' => false,
			),
			array(
				'type' => 'filter',
				'hook' => 'wpcf7_skip_mail',
				'callback' => array( $this, 'wpwh_wpcf7_skip_mail' ),
				'priority' => 10,
				'arguments' => 2,
				'delayed' => false,
			),
		);
	}

	public function get_details(){

		$validated_payload = array(
			'form_id'   => __( "Form ID", 'wp-webhooks' ),
			'form_data' => __( "Form Post Data", 'wp-webhooks' ),
			'form_data_meta' => __( "Form Post Meta", 'wp-webhooks' ),
			'form_submit_data' => __( "Form Submit Data", 'wp-webhooks' ),
			'special_mail_tags' => __( "Special Mail Tags", 'wp-webhooks' ),
		);

		$parameter = array(
			'form_id'   => array( 'short_description' => __( 'The id of the form that the data comes from.', 'wp-webhooks' ) ),
			'form_data'   => array( 'short_description' => __( 'The post data of the form itself.', 'wp-webhooks' ) ),
			'form_data_meta'   => array( 'short_description' => __( 'The meta data of the form itself.', 'wp-webhooks' ) ),
			'form_submit_data'   => array( 'short_description' => __( 'The data which was submitted by the form. For more details, check the return code area.', 'wp-webhooks' ) ),
		);

		$description = array(
			'tipps' => array(
				__( "You can also make the temporary files from Contact Form 7 available for webhook calls. To do that, simply check out the settings of your added webhook endpoint. There you will find a feature called <strong>Preserve uploaded form files</strong>. It allows you to temporarily or permanently cache given files to make them available even after CF7 has deleted them from their structure.", 'wp-webhooks' ),
				__( "You can also rename the webhook keys within the request by defining an additional attribute within the contact form template. Here is an example:", 'wp-webhooks' ) . '<pre>add_action( \'wpcf7_mail_sent\', array( $this, \'wpwh_wpcf7_mail_sent\' ), 10, 1 );</pre>' . __( 'The above example changes the key within the payload from "your-email" to "new_key". To define it, simply set the argument "wpwhkey" and separate the new key using a double point (:)."', 'wp-webhooks' ),
			),
		);

		$settings = array(
			'load_default_settings' => true,
			'data' => array(
				'wpwhpro_cf7_forms' => array(
					'id'		  => 'wpwhpro_cf7_forms',
					'type'		=> 'select',
					'multiple'	=> true,
					'choices'	  => array(),
					'query'			=> array(
						'filter'	=> 'posts',
						'args'		=> array(
							'post_type' => 'wpcf7_contact_form',
							'post_status' => 'publish',
						)
					),
					'label'	   => __( 'Trigger on selected forms', 'wp-webhooks' ),
					'placeholder' => '',
					'required'	=> false,
					'description' => __( 'Select only the forms you want to fire the trigger on. You can also choose multiple ones. If none is selected, all are triggered.', 'wp-webhooks' )
				),
				'wpwhpro_cf7_forms_send_email' => array(
					'id'		  => 'wpwhpro_cf7_forms_send_email',
					'type'		=> 'checkbox',
					'default_value' => '',
					'label'	   => __( 'Don\'t send mail as usually', 'wp-webhooks' ),
					'placeholder' => '',
					'required'	=> false,
					'description' => __( 'Check the button if you don\'t want to send the contact form to the specified email as usual.', 'wp-webhooks' )
				),
				'wpwhpro_cf7_special_mail_tags' => array(
					'id'		  => 'wpwhpro_cf7_special_mail_tags',
					'type'		=> 'text',
					'default_value' => '',
					'label'	   => __( 'Add special mail tags', 'wp-webhooks' ),
					'placeholder' => '_post_id,_post_name',
					'required'	=> false,
					'description' => __( 'Comma-separate special mail tags. E.g.: For [_post_id] and [_post_name], simply add _post_id,_post_name. To use a custom key, simply add ":MYKEY" behind the tag. E.g: _post_id:post_id,_post_name:post_name', 'wp-webhooks' )
				),
				'wpwhpro_cf7_preserve_files' => array(
					'id'		  => 'wpwhpro_cf7_preserve_files',
					'type'		=> 'text',
					'default_value' => '',
					'label'	   => __( 'Preserve uploaded form files', 'wp-webhooks' ),
					'placeholder' => 'none',
					'required'	=> false,
					'description' => __( 'By default, files are automatically removed once the contact form was sent. Please set a number of the duration on how long the file should be preserved (In seconds). E.g. 180 is equal to three minutes. Type "0" to never delete them or "none" to not save them at all.', 'wp-webhooks' )
				),
				'wpwhpro_cf7_customize_payload' => array(
					'id'		  => 'wpwhpro_cf7_customize_payload',
					'type'		=> 'select',
					'multiple'	=> true,
					'choices'	  => $validated_payload,
					'label'	   => __( 'Cutomize your Payload', 'wp-webhooks' ),
					'placeholder' => '',
					'required'	=> false,
					'description' => __( 'Select wich of the fields shoud be send along within the Payload. If nothing is selected, all will be send along.', 'wp-webhooks' )
				),
			)
		);

		return array(
			'trigger'		   => 'cf7_forms',
			'name'			  => __( 'Form submitted', 'wp-webhooks' ),
			'sentence'			  => __( 'a form was submitted', 'wp-webhooks' ),
			'parameter'		 => $parameter,
			'settings'		  => $settings,
			'returns_code'	  => $this->get_demo( array() ),
			'short_description' => __( 'This webhook fires after one or multiple contact forms are sent.', 'wp-webhooks' ),
			'description'	   => $description,
			'callback'		  => 'test_cf7_forms',
			'integration'	   => 'contactform7'
		);

	}

	/**
	 * Filter the 'wpcf7_skip_mail' to skip if necessary
	 *
	 * @since 1.0.0
	 * @param bool $skip_mail
	 * @param object $contact_form - ContactForm Obj
	 */
	public function wpwh_wpcf7_skip_mail( $skip_mail, $contact_form ) {
		$form_id = $contact_form->id();
		$is_valid = $skip_mail;

		$webhooks = WPWHPRO()->webhook->get_hooks( 'trigger', 'cf7_forms' );
		foreach( $webhooks as $webhook ){

			if( isset( $webhook['settings'] ) ){
				if( isset( $webhook['settings']['wpwhpro_cf7_forms'] ) ){

					if( ! empty( $webhook['settings']['wpwhpro_cf7_forms'] ) ){

						//If a specific contact form is set, we only check against the set one
						if( in_array( $form_id, $webhook['settings']['wpwhpro_cf7_forms'] ) ){
							if( isset( $webhook['settings']['wpwhpro_cf7_forms_send_email'] ) && ! empty( $webhook['settings']['wpwhpro_cf7_forms_send_email'] ) ) {
								$is_valid = true;
							}
						}

					} else {

						//If no specific contact form is set, we check against all
						if( isset( $webhook['settings']['wpwhpro_cf7_forms_send_email'] ) && ! empty( $webhook['settings']['wpwhpro_cf7_forms_send_email'] ) ) {
							$is_valid = true;
						}

					}
				} else {

					//If no specific contact form is set, we check against all
					if( isset( $webhook['settings']['wpwhpro_cf7_forms_send_email'] ) && ! empty( $webhook['settings']['wpwhpro_cf7_forms_send_email'] ) ) {
						$is_valid = true;
					}
				}
			}
		}

		return $is_valid;
	}

	/**
	 * Post the data to the specified webhooks
	 *
	 * @since 1.0.0
	 * @param bool $skip_mail
	 * @param object $contact_form - ContactForm Obj
	 */
	public function wpwh_wpcf7_mail_sent( $contact_form ) {

		$form_helpers = WPWHPRO()->integrations->get_helper( 'contactform7', 'form_helpers' );

		$form_id = $contact_form->id();
		$response_data = array();
		$data_array = array(
			'form_id'   => $form_id,
			'form_data' => get_post( $form_id ),
			'form_data_meta' => get_post_meta( $form_id ),
			'form_submit_data' => $form_helpers->get_contact_form_data( $contact_form ),
			'special_mail_tags' => array(),
		);

		$sub_directory = 'form-' . intval( $form_id ) . '-';
		$starting_random = wp_generate_password( 12, false );
		while( is_dir( $form_helpers->get_upload_dir( false, $sub_directory . '/' . $starting_random ) ) ){
			$starting_random = wp_generate_password( 12, false );
		}
		$sub_directory .= $starting_random;

		$webhooks = WPWHPRO()->webhook->get_hooks( 'trigger', 'cf7_forms' );
		foreach( $webhooks as $webhook ){

			$webhook_url_name = ( is_array($webhook) && isset( $webhook['webhook_url_name'] ) ) ? $webhook['webhook_url_name'] : null;

			$is_valid = true;
			$mail_tags = array();
			$single_data_array = $data_array;

			if( isset( $webhook['settings'] ) ){
				if( isset( $webhook['settings']['wpwhpro_cf7_forms'] ) && ! empty( $webhook['settings']['wpwhpro_cf7_forms'] ) ){
					if( ! in_array( $form_id, $webhook['settings']['wpwhpro_cf7_forms'] ) ){
						$is_valid = false;
					}
				}
				
				//Add Custom Tags
				if( isset( $webhook['settings']['wpwhpro_cf7_special_mail_tags'] ) && ! empty( $webhook['settings']['wpwhpro_cf7_special_mail_tags'] ) ){
					$mail_tags = $form_helpers->validate_special_mail_tags( $webhook['settings']['wpwhpro_cf7_special_mail_tags'] );
					if( ! empty( $mail_tags ) ){
						$single_data_array['special_mail_tags'] = $mail_tags;
					}
				}
				
				//Manage the response data
				if( isset( $webhook['settings']['wpwhpro_cf7_customize_payload'] ) && ! empty( $webhook['settings']['wpwhpro_cf7_customize_payload'] ) ){
					$allowed_payload_fields =  $webhook['settings']['wpwhpro_cf7_customize_payload'];
					if( is_array( $allowed_payload_fields ) ){
						foreach( $single_data_array as $single_data_array_key => $single_data_array_val ){
							if( ! in_array( $single_data_array_key, $allowed_payload_fields ) ){
								unset( $single_data_array[ $single_data_array_key ] );
							}
						}
					}
				}

				//Manage the response data
				if( isset( $webhook['settings']['wpwhpro_cf7_preserve_files'] ) ){
					$preserve_files_duration =  $webhook['settings']['wpwhpro_cf7_preserve_files'];

					if( is_numeric( $preserve_files_duration ) && $preserve_files_duration !== 'none' ){
						$preserve_files_duration = intval( $preserve_files_duration );

						if( is_array( $single_data_array['form_submit_data'] ) ){
							foreach( $single_data_array['form_submit_data'] as $single_form_data_key => $single_form_data ){
								if( is_array( $single_form_data ) && isset( $single_form_data['file_name'] ) ){
									$path = $form_helpers->get_upload_dir( true, $sub_directory );

									$absolute_path = ( isset( $single_form_data['absolute_path'] ) && is_array( $single_form_data['absolute_path'] ) ) ? $single_form_data['absolute_path'][0] : $single_form_data['absolute_path'];

									//compatibility with the most recent loading structure of CF7
									$file_name = ( isset( $single_form_data['file_name'] ) ) ? $single_form_data['file_name'] : '';
									$file_name = ( empty( $file_name ) && isset( $absolute_path ) && ! empty( $absolute_path ) ) ? wp_basename( $absolute_path ) : $file_name;

									if( ! file_exists( $path . '/' . $file_name ) ){
										copy( $absolute_path, $path . '/' . $file_name );
										$single_data_array['form_submit_data'][ $single_form_data_key ] = array(
											'file_name' => $file_name,
											'file_url' => str_replace( ABSPATH, trim( home_url(), '/' ) . '/', $path . '/' . $file_name ),
											'absolute_path' => $path . '/' . $file_name,
										);

										if( $preserve_files_duration !== 0 ){
											$preserved_files = $form_helpers->get_preserved_files();
											$preserved_files[] = array(
												'time_created' => time(),
												'time_to_delete' => ( time() + $preserve_files_duration ),
												'file_path' => $path . '/' . $file_name,
											);
											$form_helpers->update_preserved_files( $preserved_files );
										}
										
									}
								}
							}
						}
					} else {
						if( is_array( $single_data_array['form_submit_data'] ) ){
							foreach( $single_data_array['form_submit_data'] as $single_form_data_key => $single_form_data ){
								if( is_array( $single_form_data ) && isset( $single_form_data['file_name'] ) ){
									$single_data_array['form_submit_data'][ $single_form_data_key ] = '';
								}
							}
						}
					}
				} else { //make sure if nothing was set, we remove it to not show temporary data
					if( is_array( $single_data_array['form_submit_data'] ) ){
						foreach( $single_data_array['form_submit_data'] as $single_form_data_key => $single_form_data ){
							if( is_array( $single_form_data ) && isset( $single_form_data['file_name'] ) ){
								$single_data_array['form_submit_data'][ $single_form_data_key ] = '';
							}
						}
					}
				}
			}

			if( $is_valid ){
				if( $webhook_url_name !== null ){
					$response_data[ $webhook_url_name ] = WPWHPRO()->webhook->post_to_webhook( $webhook, $single_data_array );
				} else {
					$response_data[] = WPWHPRO()->webhook->post_to_webhook( $webhook, $single_data_array );
				}
				
			}
		}

		do_action( 'wpwhpro/webhooks/trigger_cf7_forms', $form_id, $data_array, $response_data );
	}

	public function get_demo( $options = array() ) {

		$data = array(
			'form_id'   => 1,
			'form_data' => array(
				'ID' => 1,
				'post_author' => '1',
				'post_date' => '2018-11-06 14:19:18',
				'post_date_gmt' => '2018-11-06 14:19:18',
				'post_content' => 'THE FORM CONTENT',
				'post_title' => 'My form',
				'post_excerpt' => '',
				'post_status' => 'publish',
				'comment_status' => 'open',
				'ping_status' => 'open',
				'post_password' => '',
				'post_name' => 'my-form',
				'to_ping' => '',
				'pinged' => '',
				'post_modified' => '2018-11-06 14:19:18',
				'post_modified_gmt' => '2018-11-06 14:19:18',
				'post_content_filtered' => '',
				'post_parent' => 0,
				'guid' => 'https://mydomain.dev/?p=1',
				'menu_order' => 0,
				'post_type' => 'wpcf7_contact_form',
				'post_mime_type' => '',
				'comment_count' => '1',
				'filter' => 'raw',
			),
			'form_data_meta' => array(
				'my_first_meta_key' => 'MY second meta key value',
				'my_second_meta_key' => 'MY second meta key value',
			),
			'form_submit_data' => array(
				'your-name' => 'xxxxxx',
				'your-email' => 'xxxxxx',
				'your-message' => 'xxxxxx'
			),
			'special_mail_tags' => array(
				'custom_key' => 123,
				'another_key' => 'Hello there'
			)
		);

	  return $data;
	}

  }

endif; // End if class_exists check.