<?php
if ( ! class_exists( 'WP_Webhooks_Integrations_shortcoder_Actions_sc_edit_shortcode' ) ) :

	/**
	 * Load the sc_edit_shortcode action
	 *
	 * @since 6.0
	 * @author Ironikus <info@ironikus.com>
	 */
	class WP_Webhooks_Integrations_shortcoder_Actions_sc_edit_shortcode {

		public function get_details() {


			$parameter = array(
				'shortcode_id'                     => array(
					'required'          => true,
					'label'             => __( 'Shortcode id', 'wp-webhooks' ),
					'short_description' => __( '(Integer) "The shorcode id to edit.', 'wp-webhooks' ),
				),
				'shortcode_author'                 => array(
					'label'             => __( 'Shortcode author', 'wp-webhooks' ),
					'short_description' => __( '(Mixed) "The shorcode author argument accepts either the user ID, or the email address of an existing user. In case you choose the email adress, we try to match it with the users on your WordPress site. In case we couldn\'t find a user for the given email, we leave the field empty.', 'wp-webhooks' ),
				),
				'name'                             => array(
					'label'             => __( 'Name', 'wp-webhooks' ),
					'short_description' => __( '(String) The shortcode name you would like to insert. Example [sc name="second"][/sc].', 'wp-webhooks' ),
				),
				'editor'                           => array(
					'label'             => __( 'Switch editor', 'wp-webhooks' ),
					'type'              => 'select',
					'default_value'     => 'code',
					'choices'           => array(
						'text'   => array( 'label' => __( 'Text editor', 'wp-webhooks' ) ),
						'visual' => array( 'label' => __( 'Visual editor', 'wp-webhooks' ) ),
						'code'   => array( 'label' => __( 'Code editor', 'wp-webhooks' ) ),
					),
					'short_description' => __( '(String) Switch the content editor.', 'wp-webhooks' ),
				),
				'content'                          => array(
					'label'             => __( 'Content', 'wp-webhooks' ),
					'short_description' => __( '(String) The content of the shortcode. You can use different dynamic parameters like date, custom fields, WordPress information.', 'wp-webhooks' ),
				),
				'tags'                             => array(
					'label'             => __( 'Tags', 'wp-webhooks' ),
					'short_description' => __( '(String) Tags to add. You can seperate tags with commas.', 'wp-webhooks' ),
				),
				'display_name'                     => array(
					'label'             => __( 'Display name', 'wp-webhooks' ),
					'short_description' => __( '(String) The name you want to display while it\'s listed.', 'wp-webhooks' ),
				),
				'description'                      => array(
					'label'             => __( 'Description', 'wp-webhooks' ),
					'short_description' => __( '(String) Set the description for identification.', 'wp-webhooks' ),
				),
				'disable_shortcode'                => array(
					'label'             => __( 'Temporarily disable shortcode.', 'wp-webhooks' ),
					'type'              => 'select',
					'default_value'     => 'no',
					'choices'           => array(
						'yes' => array( 'label' => __( 'Yes', 'wp-webhooks' ) ),
						'no'  => array( 'label' => __( 'No', 'wp-webhooks' ) ),
					),
					'short_description' => __( '(String) Select this to disable the shortcode from executing in all places where it used.', 'wp-webhooks' ),
				),
				'disable_shortcode_administrators' => array(
					'label'             => __( 'Disable shortcode for administrators', 'wp-webhooks' ),
					'type'              => 'select',
					'default_value'     => 'no',
					'choices'           => array(
						'yes' => array( 'label' => __( 'Yes', 'wp-webhooks' ) ),
						'no'  => array( 'label' => __( 'No', 'wp-webhooks' ) ),
					),
					'short_description' => __( '(String) Select to disable the shortcode from executing for administrators.', 'wp-webhooks' ),
				),
				'execute_devices'                  => array(
					'label'             => __( 'Execute shortcode on devices', 'wp-webhooks' ),
					'type'              => 'select',
					'default_value'     => 'all',
					'choices'           => array(
						'all'          => array( 'label' => __( 'All devices', 'wp-webhooks' ) ),
						'desktop_only' => array( 'label' => __( 'Desktop only', 'wp-webhooks' ) ),
						'mobile_only'  => array( 'label' => __( 'Mobile only', 'wp-webhooks' ) ),
					),
					'short_description' => __( '(String) Select the devices where the shortcode should be executed. Note: If any caching plugin is used, a separate caching for desktop and mobile might be required.', 'wp-webhooks' ),
				),
			);

			$returns = array(
				'success' => array( 'short_description' => __( '(Bool) True if the action was successful, false if not. E.g. array( \'success\' => true )', 'wp-webhooks' ) ),
				'msg'     => array( 'short_description' => __( '(String) Further information about the action.', 'wp-webhooks' ) ),
				'data'    => array( 'short_description' => __( '(Array) Further information about the shortcode.', 'wp-webhooks' ) ),
			);

			$returns_code = array(
				'success' => true,
				'msg'     => 'The shortcode has been updated.',
				'data'    =>
				array(
					'shortcode_id'             => 170,
					'shortcode_data' =>
					array(
						'ID'         => 170,
						'tax_input'  =>
						array(
							'sc_tag' =>
							array(
								0 => 'new',
								1 => 'common',
								2 => 'thing',
							),
						),
						'meta_input' =>
						array(
							'_sc_editor'      => 'visual',
							'_sc_description' => 'Test description',
						),
					),
				),
			);

			return array(
				'action'            => 'sc_edit_shortcode', // required
				'name'              => __( 'Edit shortcode', 'wp-webhooks' ),
				'sentence'          => __( 'edit a shortcode', 'wp-webhooks' ),
				'parameter'         => $parameter,
				'returns'           => $returns,
				'returns_code'      => $returns_code,
				'short_description' => __( 'Edit a shortcode within Shortcoder.', 'wp-webhooks' ),
				'description'       => array(),
				'integration'       => 'shortcoder',
				'premium'           => true,
			);

		}

		public function execute( $return_data, $response_body ) {

			$return_args = array(
				'success' => false,
				'msg'     => '',
				'data'    => array(),
			);

			$shortcode_id                     = intval( WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'shortcode_id' ) );
			$shortcode_author                 = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'shortcode_author' );
			$name                             = sanitize_title( WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'name' ) );
			$editor                           = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'editor' );
			$content                          = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'content' );
			$tags                             = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'tags' );
			$display_name                     = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'display_name' );
			$description                      = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'description' );
			$disable_shortcode                = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'disable_shortcode' );
			$disable_shortcode_administrators = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'disable_shortcode_administrators' );
			$execute_devices                  = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'execute_devices' );

			$shortcode_data = array();

			if ( ! empty( $shortcode_id ) ) {
				$shortcode = get_post( $shortcode_id );
			}

			if ( ! empty( $shortcode ) ) {
				$shortcode_data['ID'] = $shortcode->ID;
			} else {
				$return_args['msg'] = __( 'No shortcode found', 'wp-webhooks' );
				return $return_args;
			}

			if ( $shortcode->post_type != SC_POST_TYPE ) {
				$return_args['msg'] = __( 'Error getting a wrong post type.', 'wp-webhooks' );
				return $return_args;
			}

			if ( ! empty( $shortcode_author ) ) {
				$shortcode_data['shortcode_author'] = WPWHPRO()->helpers->serve_user_id( $shortcode_author );
			}

			if ( ! empty( $display_name ) ) {
				$shotrcode_data['post_title'] = $display_name;
			}

			if ( ! empty( $name ) ) {
				$shotrcode_data['post_name'] = $name;
			}

			if ( ! empty( $content ) ) {
				$shortcode_data['post_content'] = $content;
			}

			$sc_tags = array();

			if ( ! empty( $tags ) ) {
				$sc_tags                               = preg_split ('/(\s*,*\s*)*,+(\s*,*\s*)*/', $tags);
				$shortcode_data['tax_input']['sc_tag'] = $sc_tags;
			}

			if ( ! empty( $editor ) ) {
				$shortcode_data['meta_input']['_sc_editor'] = $editor;
			}

			if ( ! empty( $description ) ) {
				$shortcode_data['meta_input']['_sc_description'] = $description;
			}

			if ( ! empty( $disable_shortcode ) ) {
				$shortcode_data['meta_input']['_sc_disable_sc'] = $disable_shortcode;
			}

			if ( ! empty( $disable_shortcode_administrators ) ) {
				$shortcode_data['meta_input']['_sc_disable_admin'] = $disable_shortcode_administrators;
			}

			if ( ! empty( $execute_devices ) ) {
				$shortcode_data['meta_input']['_sc_allowed_devices'] = $execute_devices;
			}

			$shortcode_id = wp_update_post(
				$shortcode_data,
				true
			);

			if ( ! empty( $sc_tags ) ) {
				wp_set_object_terms( $shortcode_id, $sc_tags, 'sc_tag' );
			}

			if ( ! is_wp_error( $shortcode_id ) && is_numeric( $shortcode_id ) ) {
				$return_args['success']                = true;
				$return_args['msg']                    = __( 'The shortcode has been updated.', 'wp-webhooks' );
				$return_args['data']['shortcode_id']   = $shortcode_id;
				$return_args['data']['shortcode_data'] = $shortcode_data;
			} else {
				$return_args['msg']                    = __( 'Error creating a shortcode.', 'wp-webhooks' );
				$return_args['data']['shortcode_id']   = $shortcode_id;
				$return_args['data']['shortcode_data'] = $shortcode_data;
			}

			return $return_args;

		}

	}

endif; // End if class_exists check.
