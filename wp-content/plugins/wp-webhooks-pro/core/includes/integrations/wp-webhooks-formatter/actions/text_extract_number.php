<?php
if ( ! class_exists( 'WP_Webhooks_Integrations_wp_webhooks_formatter_Actions_text_extract_number' ) ) :

	/**
	 * Load the text_extract_number action
	 *
	 * @since 5.1
	 * @author Ironikus <info@ironikus.com>
	 */
	class WP_Webhooks_Integrations_wp_webhooks_formatter_Actions_text_extract_number {

	public function get_details(){

		$parameter = array(
			'value'		=> array( 
				'required' => true, 
				'label' => __( 'Value', 'wp-webhooks' ), 
				'short_description' => __( 'The string we are going to extract the numbers from.', 'wp-webhooks' ),
			),
			'return_all' => array( 
				'type' => 'select',
				'multiple' => false,
				'choices' => array(
					'yes' => array( 'label' => 'Yes' ),
					'no' => array( 'label' => 'No' ),
				),
				'default_value' => 'no',
				'label' => __( 'Return all numbers', 'wp-webhooks' ), 
				'short_description' => __( 'Define whether to extract only the first, or all numbers.', 'wp-webhooks' ),
			),
			'decimal_separator' => array( 
				'type' => 'select',
				'multiple' => false,
				'choices' => array(
					'point' => array( 'label' => 'point (.)' ),
					'comma' => array( 'label' => 'comma (,)' ),
				),
				'default_value' => 'point',
				'label' => __( 'Decimal separator', 'wp-webhooks' ), 
				'short_description' => __( 'Define the decimal separator of your given number.', 'wp-webhooks' ),
			),
		);

		$returns = array(
			'success'		=> array( 'short_description' => __( '(Bool) True if the action was successful, false if not. E.g. array( \'success\' => true )', 'wp-webhooks' ) ),
			'msg'		=> array( 'short_description' => __( '(string) A message with more information about the current request. E.g. array( \'msg\' => "This action was successful." )', 'wp-webhooks' ) ),
		);

		$returns_code = array (
			'success' => true,
			'msg' => 'The numbers have been successfully extracted.',
			'data' => 
			array (
			  0 => '89',
			  1 => '9',
			  2 => '22',
			  3 => '56.88',
			  4 => '89',
			),
		);

		return array(
			'action'			=> 'text_extract_number', //required
			'name'			   => __( 'Text extract number', 'wp-webhooks' ),
			'sentence'			   => __( 'extract one or multiple numbers from text', 'wp-webhooks' ),
			'parameter'		 => $parameter,
			'returns'		   => $returns,
			'returns_code'	  => $returns_code,
			'short_description' => __( 'Extract one or multiple numbers from a text value.', 'wp-webhooks' ),
			'description'	   => array(),
			'integration'	   => 'wp-webhooks-formatter',
			'premium'	   => true
		);


		}

		public function execute( $return_data, $response_body ){

			
			$return_args = array(
				'success' => false,
				'msg' => '',
			);

			$value = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'value' );
			$decimal_separator = sanitize_title( WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'decimal_separator' ) );
			$return_all = ( WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'return_all' ) === 'yes' ) ? true : false;

			if( empty( $value ) ){
				$return_args['msg'] = __( "Please set the value argument as it is required.", 'action-text_extract_number-error' );
				return $return_args;
			}

			if( empty( $decimal_separator ) ){
				$decimal_separator = 'point';
			}

			switch( $decimal_separator ){
				case 'comma': 
					$number_regex = '/\d+(\,\d+)?/';
					break;
				case 'point':
				default:
					$number_regex = '/\d+(\.\d+)?/';
			}

			preg_match_all( $number_regex, $value, $matches );

			$numbers = array();
			if( is_array( $matches ) && isset( $matches[0] ) && is_array( $matches[0] ) ){
				if( $return_all ){
					$numbers = $matches[0];
				} else {
					if( isset( $matches[0][0] ) ){
						$numbers = $matches[0][0];
					}
				}
			}

			$return_args['success'] = true;

			if( $return_all ){
				$return_args['msg'] = __( "The numbers have been successfully extracted.", 'action-text_extract_number-success' );
			} else {
				$return_args['msg'] = __( "The number has been successfully extracted.", 'action-text_extract_number-success' );
			}
			
			$return_args['data'] = $numbers;

			return $return_args;
	
		}

	}

endif; // End if class_exists check.