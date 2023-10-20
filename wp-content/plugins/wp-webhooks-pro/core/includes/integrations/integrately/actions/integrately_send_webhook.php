<?php
if ( ! class_exists( 'WP_Webhooks_Integrations_integrately_Actions_integrately_send_webhook' ) ) :

	/**
	 * Load the integrately_send_webhook action
	 *
	 * @since 5.0
	 * @author Ironikus <info@ironikus.com>
	 */
	class WP_Webhooks_Integrations_integrately_Actions_integrately_send_webhook {

		public function get_details(){

				//These are the main arguments the user can use to input. You should always grab them within your action function.
			$parameter = array(
				'url'	   => array( 
					'required' => true, 
					'multiple' => true, 
					'label' => __( 'Integrately "Webhook" URL', 'wp-webhooks' ), 
					'short_description' => __( '(string) The URL you want to send the data to from the "Webhook / API" integration from within Integrately.', 'wp-webhooks' ), 
				),
				'method'	=> array( 
					'label' => __( 'Request method', 'wp-webhooks' ), 
					'default_value' => 'POST', 
					'type' => 'select', 
					'choices' => array(
						'POST' => array( 'label' => 'POST' ),
						'GET' => array( 'label' => 'GET' ),
						'HEAD' => array( 'label' => 'HEAD' ),
						'PUT' => array( 'label' => 'PUT' ),
						'DELETE' => array( 'label' => 'DELETE' ),
						'TRACE' => array( 'label' => 'TRACE' ),
						'OPTIONS' => array( 'label' => 'OPTIONS' ),
						'PATCH' => array( 'label' => 'PATCH' ),
					), 
					'short_description' => __( '(string) The request type used to send the request.', 'wp-webhooks' ),
				),
				'headers'	   => array( 
					'type' => 'repeater', 
					'multiple' => true, 
					'label' => __( 'Headers', 'wp-webhooks' ), 
					'short_description' => __( '(string) A JSON formatted string containing further header details.', 'wp-webhooks' ),
				),
				'raw_body'	   => array(
					'label' => __( 'Raw body (Payload data)', 'wp-webhooks' ), 
					'short_description' => __( '(string) The raw body. If this argument is set, the "Body" argument is ignored.', 'wp-webhooks' ),
				),
				'body'	   => array( 
					'type' => 'repeater', 
					'variable' => false, 
					'multiple' => true, 
					'label' => __( 'Body (Payload data)', 'wp-webhooks' ), 
					'short_description' => __( '(string) A JSON formatted string containing further payoad data.', 'wp-webhooks' ),
				),
				'timeout'	=> array( 
					'label' => __( 'Timeout', 'wp-webhooks' ), 
					'short_description' => __( '(integer) Filters the timeout value for an HTTP request. Default: 5', 'wp-webhooks' ),
				),
				'redirection'	=> array( 
					'label' => __( 'Allowed redirects', 'wp-webhooks' ), 
					'short_description' => __( '(integer) Filters the number of redirects allowed during an HTTP request. Default 5', 'wp-webhooks' ),
				),
				'httpversion'	=> array( 
					'label' => __( 'HTTP version', 'wp-webhooks' ), 
					'short_description' => __( '(string) Filters the version of the HTTP protocol used in a request. Default: 1.0', 'wp-webhooks' ),
				),
				'user-agent'	=> array( 
					'label' => __( 'User agent', 'wp-webhooks' ), 
					'short_description' => __( '(string) Filters the user agent value sent with an HTTP request.', 'wp-webhooks' ),
				),
				'blocking'	=> array( 
					'type' => 'select', 
					'default_value' => 'yes', 
					'label' => __( 'Wait for response', 'wp-webhooks' ), 
					'choices' => array( 
						'yes' => __( 'Yes', 'wp-webhooks' ),
						'no' => __( 'No', 'wp-webhooks' ),
					), 
					'short_description' => __( '(bool) Filter whether to wait for a response of the recipient or not. Default: yes', 'wp-webhooks' ) 
				),
				'reject_unsafe_urls'	=> array( 
					'type' => 'select', 
					'default_value' => 'no',
					'label' => __( 'Reject unsafe URLs', 'wp-webhooks' ), 
					'choices' => array( 
						'yes' => __( 'Yes', 'wp-webhooks' ),
						'no' => __( 'No', 'wp-webhooks' ),
					), 'short_description' => __( '(string) Filters whether to pass URLs through wp_http_validate_url() in an HTTP request. Default: no', 'wp-webhooks' ) ),
				'sslverify'	=> array( 
					'type' => 'select', 
					'default_value' => 'yes', 
					'label' => __( 'Verify SSL', 'wp-webhooks' ), 
					'choices' => array( 
						'yes' => __( 'Yes', 'wp-webhooks' ),
						'no' => __( 'No', 'wp-webhooks' ),
					), 'short_description' => __( '(string) Validates the senders SSL certificate before sending the data. Default: yes', 'wp-webhooks' ) ),
				'limit_response_size'	=> array( 
					'label' => __( 'Limit response size', 'wp-webhooks' ), 
					'short_description' => __( '(integer) Limit the response size of the data coming back from the recpient. Default: null', 'wp-webhooks' ),
				),
				'cookies'	   => array( 
					'type' => 'repeater', 
					'multiple' => true, 
					'label' => __( 'Cookies', 'wp-webhooks' ), 
					'short_description' => __( '(string) A JSON formatted string containing additional cookie data.', 'wp-webhooks' ),
				),
				'do_action'	=> array( 
					'label' => __( 'Custom WordPress action', 'wp-webhooks' ), 
					'short_description' => __( 'Advanced: Register a custom action after the webhook fires.', 'wp-webhooks' ),
				),
			);

			//This is a more detailed view of how the data you sent will be returned.
			$returns = array(
				'success'		=> array( 'short_description' => __( '(Bool) True if the action was successful, false if not. E.g. array( \'success\' => true )', 'wp-webhooks' ) ),
				'msg'		=> array( 'short_description' => __( '(string) A message with more information about the current request. E.g. array( \'msg\' => "This action was successful." )', 'wp-webhooks' ) ),
				'data'		=> array( 'short_description' => __( '(array) Further details about the sent data.', 'wp-webhooks' ) ),
			);

			ob_start();
			?>
			<?php echo __( "The header argument accepts a JSON formatted string, containing additional header information. Down below you will find an example using two simple header settings:", 'wp-webhooks' ); ?>
			<pre>{
  "Content-Type": "application/json",
  "Custom-Header": "Some demo header"
}</pre>
			<?php
			$parameter['headers']['description'] = ob_get_clean();

			ob_start();
			?>
			<?php echo __( "The body argument accepts a JSON formatted string, containing your main information. Down below you will find an example for the body:", 'wp-webhooks' ); ?>
			<pre>{
  "user-email": "jon@doe.test",
  "user-name": "Jon Doe"
}</pre>
			<?php
			$parameter['body']['description'] = ob_get_clean();

			ob_start();
			?>
			<?php echo __( "The cookies argument accepts a JSON formatted string, containing further cookie information. Down below you will find an example for the body:", 'wp-webhooks' ); ?>
			<pre>{
  "test-cookie": "The Test Cookie"
}</pre>
			<?php
			$parameter['cookies']['description'] = ob_get_clean();

			ob_start();
		?>
<?php echo __( "This argument allows you to change the mehtod of this request. Default is POST.", 'wp-webhooks' ); ?>
		<?php
		$parameter['method']['description'] = ob_get_clean();

			ob_start();
		?>
<?php echo __( "This argument allows you to either send the request synchronously (waiting for a response) or asynchronously (response will be empty).", 'wp-webhooks' ); ?>
		<?php
		$parameter['blocking']['description'] = ob_get_clean();

			ob_start();
		?>
<?php echo __( "Set this argument to false to use unsafe looking URLs like zfvshjhfbssdf.szfdhdf.com.", 'wp-webhooks' ); ?>
		<?php
		$parameter['reject_unsafe_urls']['description'] = ob_get_clean();

			ob_start();
		?>
<?php echo __( "Set this argument to no to use unverified SSL connections for this URL.", 'wp-webhooks' ); ?>
		<?php
		$parameter['sslverify']['description'] = ob_get_clean();

			ob_start();
		?>
<?php echo __( "The <strong>do_action</strong> argument is an advanced webhook for developers. It allows you to fire a custom WordPress hook after the <strong>integrately_send_webhook</strong> action was fired.", 'wp-webhooks' ); ?>
<br>
<?php echo __( "You can use it to trigger further logic after the webhook action. Here's an example:", 'wp-webhooks' ); ?>
<br>
<br>
<?php echo __( "Let's assume you set for the <strong>do_action</strong> parameter <strong>fire_this_function</strong>. In this case, we will trigger an action with the hook name <strong>fire_this_function</strong>. Here's how the code would look in this case:", 'wp-webhooks' ); ?>
<pre>add_action( 'fire_this_function', 'my_custom_callback_function', 20, 3 );
function my_custom_callback_function( $check, $arguments, $return_args ){
	//run your custom logic in here
}
</pre>
<?php echo __( "Here's an explanation to each of the variables that are sent over within the custom function.", 'wp-webhooks' ); ?>
<ol>
	<li>
		<strong>$check</strong> (bool)<br>
		<?php echo __( "Returns the HTTP object if the request was successful - WP Error or false if not.", 'wp-webhooks' ); ?>
	</li>
	<li>
		<strong>$arguments</strong> (array)<br>
		<?php echo __( "The arguments used to send the HTTP request.", 'wp-webhooks' ); ?>
	</li>
	<li>
		<strong>$return_args</strong> (array)<br>
		<?php echo __( "Contains the response data of the request.", 'wp-webhooks' ); ?>
	</li>
</ol>
		<?php
		$parameter['do_action']['description'] = ob_get_clean();

			$returns_code = array (
				'success' => true,
				'msg' => 'The webhook request was sent successfully.',
				'data' => 
				array (
				  'success' => true,
				  'msg' => '',
				  'headers' => 
				  array (
					'date' => 'Thu, 24 Mar 2022 12:49:48 GMT',
					'content-type' => 'application/json; charset=utf-8',
					'content-length' => '29',
					'cf-ray' => '6f0f8xxxxxxxxxxx',
					'strict-transport-security' => 'max-age=31536000; includeSubDomains; preload',
					'cf-cache-status' => 'DYNAMIC',
					'expect-ct' => 'max-age=604800, report-uri="https://report-uri.cloudflare.com/cdn-cgi/beacon/expect-ct"',
					'x-content-type-options' => 'nosniff',
					'x-frame-options' => 'SAMEORIGIN',
					'x-ig-balancer' => 'true',
					'x-permitted-cross-domain-policies' => 'none',
					'x-powered-by' => 'ARR/3.0',
					'x-rate-limit-limit' => '300s',
					'x-rate-limit-remaining' => '999',
					'x-rate-limit-reset' => '2022-03-24T12:50:00.0000000Z',
					'x-runtime' => '56',
					'x-runtime-action' => '55',
					'x-xss-protection' => '1;mode=block',
					'report-to' => '{"endpoints":[{"url":"https:\\/\\/a.nel.cloudflare.com\\/report\\/v3?s=xxxxxxxxxxxx"}],"group":"cf-nel","max_age":604800}',
					'nel' => '{"success_fraction":0,"report_to":"cf-nel","max_age":604800}',
					'vary' => 'Accept-Encoding',
					'server' => 'cloudflare',
				  ),
				  'cookies' => 
				  array (
				  ),
				  'method' => '',
				  'content_type' => 'application/json; charset=utf-8',
				  'code' => 200,
				  'origin' => '',
				  'query' => '',
				  'content' => 
				  array (
					'success' => true,
					'message' => '',
				  ),
				  'response' => 
				  array (
					'code' => 200,
					'message' => 'OK',
				  ),
				  'filename' => NULL,
				  'http_response' => 
				  array (
					'data' => NULL,
					'headers' => NULL,
					'status' => NULL,
				  ),
				),
			);

			return array(
				'action'			=> 'integrately_send_webhook',
				'name'			  => __( 'Send data to Integrately webhook', 'wp-webhooks' ),
				'sentence'			  => __( 'send data to the Integrately webhook integration', 'wp-webhooks' ),
				'parameter'		 => $parameter,
				'returns'		   => $returns,
				'returns_code'	  => $returns_code,
				'short_description' => __( 'This webhook action allows you to send data to the "Webhook / API" integration of Integrately from your WordPress website.', 'wp-webhooks' ),
				'description'	   => array(),
				'integration'	   => 'integrately',
				'premium' 			=> false,
			);

		}

		public function execute( $return_data, $response_body ){

			$return_args = array(
				'success' => false,
				'msg' => '',
				'data' => array()
			);

			$url	 = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'url' );
			$headers	 = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'headers' );
			$raw_body	 = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'raw_body' );
			$body	 = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'body' );
			$cookies	 = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'cookies' );
			$method	 = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'method' );
			$timeout	 = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'timeout' );
			$redirection	 = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'redirection' );
			$httpversion	 = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'httpversion' );
			$blocking	 = ( WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'blocking' ) === 'no' ) ? false : true;
			$user_agent	 = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'user-agent' );
			$sslverify	 = ( WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'sslverify' ) === 'no' ) ? false : true;
			$reject_unsafe_urls	 = ( WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'reject_unsafe_urls' ) === 'no' ) ? false : true;
			$limit_response_size	 = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'limit_response_size' );
			$do_action		  = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'do_action' );

			if( empty( $url ) ){
				$return_args['msg'] = __( "Please set the url argument.", 'action-integrately_send_webhook-failure' );
				return $return_args;
			}

			$arguments = array(
				'blocking' => $blocking,
				'sslverify' => $sslverify,
				'headers' => array(
					'content-type' => 'application/json'
				),
			);

			if( ! empty( $headers ) ){
				if( is_array( $headers ) || is_object( $headers ) ){

					foreach( $headers as $header_key => $header_data ){

						//sanitize based on HTTP/2
						$header_key = strtolower( $header_key );
						
						$arguments['headers'][ $header_key ] = $header_data;
					}

				} elseif( WPWHPRO()->helpers->is_json( $headers ) ){
					$validated_headers = json_decode( $headers, true );
					if( is_array( $validated_headers ) && ! empty( $validated_headers ) ){

						foreach( $validated_headers as $header_key => $header_value ){

							//sanitize based on HTTP/2
							$header_key = strtolower( $header_key );

							$arguments['headers'][ $header_key ] = $header_value;
						}
						
					}
				}
			}

			if( ! empty( $raw_body ) ){
				$arguments['body'] = $raw_body;
			} else {
				if( ! empty( $body ) ){
					if( is_array( $body ) || is_object( $body ) ){
						$arguments['body'] = $body;
					} elseif( WPWHPRO()->helpers->is_json( $body ) ){
						$arguments['body'] = json_decode( $body, true );
					}
				}
			}

			if( ! empty( $cookies ) ){
				if( is_array( $cookies ) || is_object( $cookies ) ){
					$arguments['cookies'] = $cookies;
				} elseif( WPWHPRO()->helpers->is_json( $cookies ) ){
					$arguments['cookies'] = json_decode( $cookies, true );
				}
			}

			if( ! empty( $sslverify ) ){
				$arguments['sslverify'] = $sslverify;
			}

			if( ! empty( $method ) ){
				$arguments['method'] = $method;
			}

			if( ! empty( $timeout ) ){
				$arguments['timeout'] = $timeout;
			}

			if( ! empty( $redirection ) ){
				$arguments['redirection'] = $redirection;
			}

			if( ! empty( $httpversion ) ){
				$arguments['httpversion'] = $httpversion;
			}

			if( ! empty( $user_agent ) ){
				$arguments['user-agent'] = $user_agent;
			}

			if( ! empty( $reject_unsafe_urls ) ){
				$arguments['reject_unsafe_urls'] = $reject_unsafe_urls;
			}

			if( ! empty( $limit_response_size ) ){
				$arguments['limit_response_size'] = $limit_response_size;
			}	

			$response = WPWHPRO()->http->send_http_request( $url, $arguments );

			if( $response['success'] ){
				$return_args['data'] = $response;	

				$return_args['msg'] = __( "The webhook request was sent successfully.", 'action-integrately_send_webhook-success' );
				$return_args['success'] = true;
			} else {
				$return_args['msg'] = __( "An error occured while sending the webhook request.", 'action-integrately_send_webhook-success' );
				$return_args['data'] = $response;
			}

			if( ! empty( $do_action ) ){
				do_action( $do_action, $response, $arguments, $return_args );
			}

			return $return_args;
	
		}

	}

endif; // End if class_exists check.