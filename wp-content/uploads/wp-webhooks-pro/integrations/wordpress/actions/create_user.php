<?php
if ( ! class_exists( 'WP_Webhooks_Integrations_wordpress_Actions_create_user' ) ) :

	/**
	 * Load the create_user action
	 *
	 * @since 4.1.0
	 * @author Ironikus <info@ironikus.com>
	 */
	class WP_Webhooks_Integrations_wordpress_Actions_create_user {

		function __construct(){
			$this->page_title   = WPWHPRO()->settings->get_page_title();
        }

		/*
	 * The core logic to handle the creation of a user
	 */
	public function get_details(){


		$parameter = array(
			'user_email'        => array( 'required' => true, 'short_description' => __( 'This field is required. Include the email for the user.', 'wp-webhooks' ) ),
			'first_name'        => array( 'short_description' => __( 'The first name of the user.', 'wp-webhooks' ) ),
			'last_name'         => array( 'short_description' => __( 'The last name of the user.', 'wp-webhooks' ) ),
			'nickname'          => array( 'short_description' => __( 'The nickname. Please note that the nickname will be sanitized by WordPress automatically.', 'wp-webhooks' ) ),
			'user_login'        => array( 'short_description' => __( 'A string with which the user can log in to your site.', 'wp-webhooks' ) ),
			'display_name'      => array( 'short_description' => __( 'The name that will be seen on the frontend of your site.', 'wp-webhooks' ) ),
			'user_nicename'     => array( 'short_description' => __( 'A URL-friendly name. Default is user\' username.', 'wp-webhooks' ) ),
			'description'       => array( 'short_description' => __( 'A description for the user that will be available on the profile page.', 'wp-webhooks' ) ),
			'rich_editing'      => array( 
				'type' => 'select',
				'choices' => array(
					'no' => array( 'label' => __( 'No', 'wp-webhooks' ) ),
					'yes' => array( 'label' => __( 'Yes', 'wp-webhooks' ) ),
				),
				'multiple' => false,
				'default_value' => 'no',
				'short_description' => __( 'Wether the user should be able to use the Rich editor. Set it to "yes" or "no". Default "no".', 'wp-webhooks' ),
			),
			'user_registered'   => array( 'short_description' => __( 'The date the user gets registered. Date structure: Y-m-d H:i:s', 'wp-webhooks' ) ),
			'user_url'          => array( 'short_description' => __( 'Include a website url.', 'wp-webhooks' ) ),
			'role'              => array(
				'short_description' => __( 'The main user role. If not set, default is subscriber.', 'wp-webhooks' ),
				'description' => __( "<p>The slug of the role. The default roles have the following slugs: </p>", 'wp-webhooks' ) . '<p><ul><li>administrator</li> <li>editor</li> <li>author</li> <li>contributor</li> <li>subscriber</li></ul></p>',
			),
			'additional_roles'  => array( 'short_description' => __( 'This allows to add multiple roles to a user.', 'wp-webhooks' ) ),
			'user_pass'         => array( 'short_description' => __( 'The user password. If not defined, we generate a 32 character long password dynamically.', 'wp-webhooks' ) ),
			'user_meta'  		=> array( 'short_description' => __( '<strong>DEPRECATED! Please use manage_meta_data instead.</strong>', 'wp-webhooks' ) ),
			'meta_update' => array( 
				'type' => 'repeater',
				'label' => __( 'Add/Update Meta', 'wp-webhooks' ),
				'short_description' => __( 'Update (or add) meta keys/values.', 'wp-webhooks' ),
			),
			'manage_meta_data' => array( 
				'label' => __( 'Manage Meta Data (Advanced)', 'wp-webhooks' ),
				'short_description' => __( 'In case you want to add more complex meta data, this field is for you. Check out some examples within our post meta blog post.', 'wp-webhooks' )
			),
			'acf_meta_update' => array( 
				'type' => 'repeater',
				'label' => __( 'Add/Update ACF Meta', 'wp-webhooks' ),
				'short_description' => __( 'Update (or add) Advanced Custom Fields meta keys/values.', 'wp-webhooks' ),
			),
			'manage_acf_data' => array( 
				'label' => __( 'Manage ACF Data (Advanced)', 'wp-webhooks' ),
				'short_description' => __( 'In case you want to add more complex Advanced Custom Fields data, this field is for you. Check out some examples within our post meta blog post.', 'wp-webhooks' )
			),
			'send_email'        => array(
				'type' => 'select',
				'choices' => array(
					'no' => array( 'label' => __( 'No', 'wp-webhooks' ) ),
					'yes' => array( 'label' => __( 'Yes', 'wp-webhooks' ) ),
				),
				'multiple' => false,
				'default_value' => 'no',
				'short_description' => __( 'Set this field to "yes" to send a email to the user with the data.', 'wp-webhooks' ),
				'description' => __( "In case you set the <strong>send_email</strong> argument to <strong>yes</strong>, we will send an email from this WordPress site to the user email, containing his login details.", 'wp-webhooks' )
			),
			'do_action'         => array( 'short_description' => __( 'Advanced: Register a custom action after the plugin fires this webhook.', 'wp-webhooks' ) )
		);

		ob_start();
		?>
<?php echo __( "This argument allows you to add or remove additional roles on the user. There are two possible ways of doing that:", 'wp-webhooks' ); ?>
<ol>
    <li>
        <strong><?php echo __( "String method", 'wp-webhooks' ); ?></strong>
        <br>
        <?php echo __( "This method allows you to add or remove the user roles using a simple string. To make it work, simply add the slug of the role and define the action (add/remove) after, separated by double points (:). If you want to add multiple roles, simply separate them with a semicolon (;). Please refer to the example down below.", 'wp-webhooks' ); ?>
        <pre>editor:add;custom-role:add;custom-role-1:remove</pre>
    </li>
    <li>
        <strong><?php echo __( "JSON method", 'wp-webhooks' ); ?></strong>
        <br>
        <?php echo __( "We also support a JSON formatted string, which contains the role slug as the JSON key and the action (add/remove) as the value. Please refer to the example below:", 'wp-webhooks' ); ?>
        <pre>{
  "editor": "add",
  "custom-role": "add",
  "custom-role-1": "remove"
}</pre>
    </li>
</ol>
		<?php
		$parameter['additional_roles']['description'] = ob_get_clean();

		ob_start();
		?>
<?php echo __( "This argument is specifically designed to add/update or remove user meta to your updated user.", 'wp-webhooks' ); ?>
                    <br>
                    <?php echo __( "To create/update or delete custom meta values, we offer you two different ways:", 'wp-webhooks' ); ?>
                    <ol>
                        <li>
                            <strong><?php echo __( "String method", 'wp-webhooks' ); ?></strong>
                            <br>
                            <?php echo __( "This method allows you to add/update or delete the user meta using a simple string. To make it work, separate the meta key from the value using a comma (,). To separate multiple meta settings from each other, simply separate them with a semicolon (;). To remove a meta value, simply set as a value <strong>ironikus-delete</strong>", 'wp-webhooks' ); ?>
                            <pre>meta_key_1,meta_value_1;my_second_key,ironikus-delete</pre>
                            <?php echo __( "<strong>IMPORTANT:</strong> Please note that if you want to use values that contain commas or semicolons, the string method does not work. In this case, please use the JSON method.", 'wp-webhooks' ); ?>
                        </li>
                        <li>
                        <strong><?php echo __( "JSON method", 'wp-webhooks' ); ?></strong>
                            <br>
                            <?php echo __( "This method allows you to add/update or remove the user meta using a JSON formatted string. To make it work, add the meta key as the key and the meta value as the value. To delete a meta value, simply set the value to <strong>ironikus-delete</strong>. Here's an example on how this looks like:", 'wp-webhooks' ); ?>
<pre>{
"meta_key_1": "This is my meta value 1",
"another_meta_key": "This is my second meta key!"
"third_meta_key": "ironikus-delete"
}</pre>
                        </li>
                    </ol>
                    <strong><?php echo __( "Advanced", 'wp-webhooks' ); ?></strong>: <?php echo __( "We also offer JSON to array/object serialization for single user meta values. This means, you can turn JSON into a serialized array or object.", 'wp-webhooks' ); ?>
                    <br>
                    <?php echo __( "As an example: The following JSON <code>{\"price\": \"100\"}</code> will turn into <code>O:8:\"stdClass\":1:{s:5:\"price\";s:3:\"100\";}</code> with default serialization or into <code>a:1:{s:5:\"price\";s:3:\"100\";}</code> with array serialization.", 'wp-webhooks' ); ?>
                    <ol>
                        <li>
                            <strong><?php echo __( "Object serialization", 'wp-webhooks' ); ?></strong>
                            <br>
                            <?php echo __( "This method allows you to serialize a JSON to an object using the default json_decode() function of PHP.", 'wp-webhooks' ); ?>
                            <br>
                            <?php echo __( "To serialize your JSON to an object, you need to add the following string in front of the escaped JSON within the value field of your single meta value of the user_meta argument: <code>ironikus-serialize</code>. Here's a full example:", 'wp-webhooks' ); ?>
<pre>{
"meta_key_1": "This is my meta value 1",
"another_meta_key": "This is my second meta key!",
"third_meta_key": "ironikus-serialize{\"price\": \"100\"}"
}</pre>
                            <?php echo __( "This example will create three user meta entries. The third entry has the meta key <strong>third_meta_key</strong> and a serialized meta value of <code>O:8:\"stdClass\":1:{s:5:\"price\";s:3:\"100\";}</code>. The string <code>ironikus-serialize</code> in front of the escaped JSON will tell our plugin to serialize the value. Please note that the JSON value, which you include within the original JSON string of the user_meta argument, needs to be escaped.", 'wp-webhooks' ); ?>
                        </li>
                        <li>
                            <strong><?php echo __( "Array serialization", 'wp-webhooks' ); ?></strong>
                            <br>
                            <?php echo __( "This method allows you to serialize a JSON to an array using the json_decode( \$json, true ) function of PHP.", 'wp-webhooks' ); ?>
                            <br>
                            <?php echo __( "To serialize your JSON to an array, you need to add the following string in front of the escaped JSON within the value field of your single meta value of the user_meta argument: <code>ironikus-serialize-array</code>. Here's a full example:", 'wp-webhooks' ); ?>
<pre>{
"meta_key_1": "This is my meta value 1",
"another_meta_key": "This is my second meta key!",
"third_meta_key": "ironikus-serialize-array{\"price\": \"100\"}"
}</pre>
                            <?php echo __( "This example will create three user meta entries. The third entry has the meta key <strong>third_meta_key</strong> and a serialized meta value of <code>a:1:{s:5:\"price\";s:3:\"100\";}</code>. The string <code>ironikus-serialize-array</code> in front of the escaped JSON will tell our plugin to serialize the value. Please note that the JSON value, which you include within the original JSON string of the user_meta argument, needs to be escaped.", 'wp-webhooks' ); ?>
                        </li>
                    </ol>
		<?php
		$parameter['user_meta']['description'] = ob_get_clean();

		ob_start();
		?>
<?php echo __( "This arguments accepts a JSON formatted string with the meta key as the key and the meta value as the value.", 'wp-webhooks' ); ?>
<br>
<pre>
{
	"meta_key": "Meta Value"
}
</pre>
		<?php
		$parameter['meta_update']['description'] = ob_get_clean();

		ob_start();
		?>
<?php echo __( "This argument integrates the full features of managing user related meta values.", 'wp-webhooks' ); ?>
<br>
<br>
<?php echo __( "<strong>Please note</strong>: This argument is very powerful and requires some good understanding of JSON. It is integrated with the commonly used functions for managing user meta within WordPress. You can find a list of all avaialble functions here: ", 'wp-webhooks' ); ?>
<ul>
    <li><strong>add_user_meta()</strong>: <a title="Go to WordPress" target="_blank" href="https://developer.wordpress.org/reference/functions/add_user_meta/">https://developer.wordpress.org/reference/functions/add_user_meta/</a></li>
    <li><strong>update_user_meta()</strong>: <a title="Go to WordPress" target="_blank" href="https://developer.wordpress.org/reference/functions/update_user_meta/">https://developer.wordpress.org/reference/functions/update_user_meta/</a></li>
    <li><strong>delete_user_meta()</strong>: <a title="Go to WordPress" target="_blank" href="https://developer.wordpress.org/reference/functions/delete_user_meta/">https://developer.wordpress.org/reference/functions/delete_user_meta/</a></li>
</ul>
<br>
<?php echo __( "Down below you will find a complete JSON example that shows you how to use each of the functions above.", 'wp-webhooks' ); ?>
<br>
<br>
<?php echo __( "We also offer JSON to array/object serialization for single user meta values. This means, you can turn JSON into a serialized array or object.", 'wp-webhooks' ); ?>
<br>
<?php echo __( "This argument accepts a JSON construct as an input. This construct contains each available function as a top-level key within the first layer and the assigned data respectively as a value. If you want to learn more about each line, please take a closer look at the bottom of the example.", 'wp-webhooks' ); ?>
<?php echo __( "Down below you will find a list that explains each of the top level keys.", 'wp-webhooks' ); ?>
<ol>
    <li>
        <strong><?php echo __( "add_user_meta", 'wp-webhooks' ); ?></strong>
		<pre>{
   "add_user_meta":[
      {
        "meta_key": "first_custom_key",
        "meta_value": "Some custom value"
      },
      {
        "meta_key": "second_custom_key",
        "meta_value": { "some_array_key": "Some array Value" },
        "unique": true
      }
    ]
}</pre>
        <?php echo __( "This key refers to the <strong>add_user_meta()</strong> function of WordPress:", 'wp-webhooks' ); ?> <a title="Go to WordPress" target="_blank" href="https://developer.wordpress.org/reference/functions/add_user_meta/">https://developer.wordpress.org/reference/functions/add_user_meta/</a>
        <br>
        <?php echo __( "In the example above, you will find two entries within the add_user_meta key. The first one shows the default behavior using only the meta key and the value. This causes the meta key to be created without checking upfront if it exists - that allows you to create the meta value multiple times.", 'wp-webhooks' ); ?>
        <br>
        <?php echo __( "As seen in the second entry, you will find a third key called <strong>unique</strong> that allows you to check upfront if the meta key exists already. If it does, the meta entry is neither created, nor updated. Set the value to <strong>true</strong> to check against existing ones. Default: false", 'wp-webhooks' ); ?>
        <br>
        <?php echo __( "If you look closely to the second entry again, the value included is not a string, but a JSON construct, which is considered as an array and will therefore be serialized. The given value will be saved to the database in the following format: <code>a:1:{s:14:\"some_array_key\";s:16:\"Some array Value\";}</code>", 'wp-webhooks' ); ?>
    </li>
    <li>
        <strong><?php echo __( "update_user_meta", 'wp-webhooks' ); ?></strong>
		<pre>{
   "update_user_meta":[
      {
        "meta_key": "first_custom_key",
        "meta_value": "Some custom value"
      },
      {
        "meta_key": "second_custom_key",
        "meta_value": "The new value",
        "prev_value": "The previous value"
      }
    ]
}</pre>
        <?php echo __( "This key refers to the <strong>update_user_meta()</strong> function of WordPress:", 'wp-webhooks' ); ?> <a title="Go to WordPress" target="_blank" href="https://developer.wordpress.org/reference/functions/update_user_meta/">https://developer.wordpress.org/reference/functions/update_user_meta/</a>
        <br>
        <?php echo __( "The example above shows you two entries for this function. The first one is the default set up thats used in most cases. Simply define the meta key and the meta value and the key will be updated if it does exist and if it does not exist, it will be created.", 'wp-webhooks' ); ?>
        <br>
        <?php echo __( "The third argument, as seen in the second entry, allows you to check against a previous value before updating. That causes that the meta value will only be updated if the previous key fits to whats currently saved within the database. Default: ''", 'wp-webhooks' ); ?>
    </li>
    <li>
        <strong><?php echo __( "delete_user_meta", 'wp-webhooks' ); ?></strong>
		<pre>{
   "delete_user_meta":[
      {
        "meta_key": "first_custom_key"
      },
      {
        "meta_key": "second_custom_key",
        "meta_value": "Target specific value"
      }
    ]
}</pre>
        <?php echo __( "This key refers to the <strong>delete_user_meta()</strong> function of WordPress:", 'wp-webhooks' ); ?> <a title="Go to WordPress" target="_blank" href="https://developer.wordpress.org/reference/functions/delete_user_meta/">https://developer.wordpress.org/reference/functions/delete_user_meta/</a>
        <br>
        <?php echo __( "Within the example above, you will see that only the meta key is required for deleting an entry. This will cause all meta keys on this post with the same key to be deleted.", 'wp-webhooks' ); ?>
        <br>
        <?php echo __( "The second argument allows you to target only a specific meta key/value combination. This gets important if you want to target a specific meta key/value combination and not delete all available entries for the given post. Default: ''", 'wp-webhooks' ); ?>
    </li>
</ol>
<strong><?php echo __( "Some tipps:", 'wp-webhooks' ); ?></strong>
<ol>
    <li><?php echo __( "You can include the value for this argument as a simple string to your webhook payload or you integrate it directly as JSON into your JSON payload (if you send a raw JSON response).", 'wp-webhooks' ); ?></li>
    <li><?php echo __( "Changing the order of the functions within the JSON causes the user meta to behave differently. If you, for example, add the <strong>delete_user_meta</strong> key before the <strong>update_user_meta</strong> key, the meta values will first be deleted and then added/updated.", 'wp-webhooks' ); ?></li>
    <li><?php echo __( "The webhook response contains a validted array that shows each initialized meta entry, as well as the response from its original WordPress function. This way you can see if the meta value was adjusted accordingly.", 'wp-webhooks' ); ?></li>
</ol>
		<?php
		$parameter['manage_meta_data']['description'] = ob_get_clean();

		//Remove if ACF isn't active
		if( ! WPWHPRO()->helpers->is_plugin_active( 'advanced-custom-fields' ) ){
			unset( $parameter['manage_acf_data'] );
		} else {
			ob_start();
		?>
<?php echo __( "This arguments accepts a JSON formatted string with the field key as the key and the ACF value as the value.", 'wp-webhooks' ); ?>
<br>
<pre>
{
	"meta_key": "Meta Value"
}
</pre>
		<?php
		$parameter['acf_meta_update']['description'] = ob_get_clean();

			ob_start();
			WPWHPRO()->acf->load_acf_description();
			$parameter['manage_acf_data']['description'] = ob_get_clean();
		}

		ob_start();
		?>
<?php echo __( "The do_action argument is an advanced webhook for developers. It allows you to fire a custom WordPress hook after the create_user action was fired.", 'wp-webhooks' ); ?>
<br>
<?php echo __( "You can use it to trigger further logic after the webhook action. Here's an example:", 'wp-webhooks' ); ?>
<br>
<br>
<?php echo __( "Let's assume you set for the <strong>do_action</strong> parameter <strong>fire_this_function</strong>. In this case, we will trigger an action with the hook name <strong>fire_this_function</strong>. Here's how the code would look in this case:", 'wp-webhooks' ); ?>
<pre>add_action( 'fire_this_function', 'my_custom_callback_function', 20, 4 );
function my_custom_callback_function( $user_data, $user_id, $user_meta, $update ){
    //run your custom logic in here
}
</pre>
<?php echo __( "Here's an explanation to each of the variables that are sent over within the custom function.", 'wp-webhooks' ); ?>
<ol>
    <li>
        <strong>$user_data</strong> (array)
        <br>
        <?php echo __( "Contains the data that is used to create the user.", 'wp-webhooks' ); ?>
    </li>
    <li>
        <strong>$user_id</strong> (integer)
        <br>
        <?php echo __( "Contains the user id of the newly created user. Please note that it can also contain a wp_error object since it is the response of the wp_insert_user() function.", 'wp-webhooks' ); ?>
    </li>
    <li>
        <strong>$user_meta</strong> (string)
        <br>
        <?php echo __( "Contains the unformatted user meta as you sent it over within the webhook request as a string.", 'wp-webhooks' ); ?>
    </li>
    <li>
        <strong>$update</strong> (bool)
        <br>
        <?php echo __( "This value will be set to 'false' for the create_user webhook.", 'wp-webhooks' ); ?>
    </li>
</ol>
		<?php
		$parameter['do_action']['description'] = ob_get_clean();

		$returns = array(
			'success'        => array( 'short_description' => __( '(Bool) True if the action was successful, false if not. E.g. array( \'success\' => true )', 'wp-webhooks' ) ),
			'data'        => array( 'short_description' => __( '(array) User related data as an array. We return the user id with the key "user_id" and the user data with the key "user_data". E.g. array( \'data\' => array(...) )', 'wp-webhooks' ) ),
			'msg'        => array( 'short_description' => __( '(string) A message with more information about the current request. E.g. array( \'msg\' => "This action was successful." )', 'wp-webhooks' ) ),
        );

		$returns_code = array(
			"success" => true,
			"msg" => "User successfully created.",
			"data" => array(
				"user_id" => 131,
				"user_data" => array(
					"user_email" => "demo_user@email.email",
					"role" => "subscriber",
					"nickname" => "nickname",
					"user_login" => "userlogin",
					"user_nicename" => "The Nice Name",
					"description" => "This is a user description",
					"rich_editing" => true,
					"user_registered" => "2020-12-11 14:10:10",
					"user_url" => "https://somedomain.com",
					"display_name" => "username",
					"first_name" => "Jon",
					"last_name" => "Doe",
					"user_pass" => "SomeCustomUserpass123",
					"additional_roles" => "author:add"
				),
				"manage_meta_data" => array(
					"success" => true,
					"msg" => "The meta data was successfully executed.",
					"data" => array(
						"add_user_meta" => array(
							array(
								"meta_key" => "first_custom_key",
								"meta_value" => "Some custom value",
								"unique" => false,
								"response" => 3446
							),
							array(
								"meta_key" => "second_custom_key",
								"meta_value" => array(
									"some_array_key" => "Some array Value"
								),
								"unique" => true,
								"response" => 3447
							)
						),
						"update_user_meta" => array(
							array(
								"meta_key" => "first_custom_key",
								"meta_value" => "Some custom value",
								"prev_value" => false,
								"response" => false
							),
							array(
								"meta_key" => "second_custom_key",
								"meta_value" => "The new value",
								"prev_value" => "The previous value",
								"response" => false
							)
						),
						"delete_user_meta" => array(
							array(
								"meta_key" => "first_custom_key",
								"meta_value" => "",
								"response" => true
							),
							array(
								"meta_key" => "second_custom_key",
								"meta_value" => "Target specific value",
								"response" => false
							)
						)
					)
				),
				"manage_acf_data" => array(
					"success" => true,
					"msg" => "The given ACF data has been successfully executed.",
					"data" => array(
						"delete_field" => array(
							array(
								"selector" => "demo_field",
								"response" => false
							)
						)
					)
				)
			)
		);

		$description = array(
			'tipps' => array(
				__( 'It is recommended to set the attribute <strong>user_login</strong> since this will be the name a user can log in with.', 'wp-webhooks' )
			)
		);

		return array(
			'action'            => 'create_user',
			'name'              => __( 'Create user', 'wp-webhooks' ),
			'sentence'              => __( 'create a user', 'wp-webhooks' ),
			'parameter'         => $parameter,
			'returns'           => $returns,
			'returns_code'      => $returns_code,
			'short_description' => __( 'Create a new user via webhooks.', 'wp-webhooks' ),
			'description'       => $description,
			'integration'       => 'wordpress',
			'premium' 			=> false,
		);

	}

		/**
		 * Create a user via a action call
		 *
		 * @param $update - Wether the user gets created or updated
		 */
		public function execute( $return_data, $response_body ){

			$update = false;
			$user_helpers = WPWHPRO()->integrations->get_helper( 'wordpress', 'user_helpers' );
			$return_args = array(
				'success' => false,
				'msg' => '',
				'data' => array(
					'user_id' => 0,
					'user_data' => array()
				)
			);

			$user_id            = intval( WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'user_id' ) );
			$nickname           = sanitize_text_field( WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'nickname' ) );
			$user_login         = sanitize_text_field( WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'user_login' ) );
			$user_nicename      = sanitize_text_field( WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'user_nicename' ) );
			$description        = sanitize_text_field( WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'description' ) );
			$user_registered    = sanitize_text_field( WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'user_registered' ) );
			$user_url           = sanitize_text_field( WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'user_url' ) );
			$display_name       = sanitize_text_field( WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'display_name' ) );
			$user_email         = sanitize_email( WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'user_email' ) );
			$first_name         = sanitize_text_field( WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'first_name' ) );
			$last_name          = sanitize_text_field( WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'last_name' ) );
			$role               = sanitize_text_field( WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'role' ) );
			$user_pass          = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'user_pass' );
			$do_action          = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'do_action' );

			$rich_editing     	= ( WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'rich_editing' ) == 'yes' ) ? true : false;
			$create_if_none     = ( WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'create_if_none' ) == 'yes' ) ? 'yes' : 'no';
			$send_email         = ( WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'send_email' ) == 'yes' ) ? 'yes' : 'no';
			$user_meta          = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'user_meta' );
			$meta_update		= WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'meta_update' );
			$manage_meta_data 	= WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'manage_meta_data' );
			$acf_meta_update 	= WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'acf_meta_update' );
			$manage_acf_data    = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'manage_acf_data' );
			$additional_roles   = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'additional_roles' );

			if( $update ){
				if ( empty( $user_email ) && empty( $user_id ) && empty( $user_login ) && $create_if_none == 'no' ) {
					$return_args['msg'] = __( "The email, user id or user login is required to update a user.", 'wp-webhooks' );

					return $return_args;
				}
			} else {
				if ( empty( $user_email ) ) {
					$return_args['msg'] = __( "An email is required to create a user.", 'wp-webhooks' );

					return $return_args;
				}
			}

			$user_data = array();

			if( $user_email ){
				$user_data['user_email'] = $user_email;
			}

			if( $update ){
				$user = '';

				//Prioritize the user id for checks
				if( ! empty( $user_id ) ){
					$user = get_user_by( 'id', $user_id );
				} elseif( ! empty( $user_email ) ){
					$user = get_user_by( 'email', $user_email );
				} elseif( ! empty( $user_login ) ){
					$user = get_user_by( 'login', $user_login );
				}

				if( ! empty( $user ) ){
					if( ! empty( $user->ID ) ){
						$user_data['ID'] = $user->ID;
					}
				}

				if( empty( $user_data['ID'] ) ){

					if( ! empty( $user_email ) ){

						$parse_filter_arg = ( $create_if_none == 'yes' ) ? true : false;
						$create_user_on_update = apply_filters( 'wpwhpro/run/create_action_user_on_update', $parse_filter_arg );
						if( empty( $create_user_on_update ) ){
							$return_args['msg'] = __( "User not found.", 'wp-webhooks' );

							return $return_args;
						} else {
							$update = false; // Set update to false to follow the default user creation

							//Auto generate on new user
							if( empty( $user_pass ) ){
								$user_data['user_pass'] = wp_generate_password( 32, true, false );
							}
						}
					} else {
						$return_args['msg'] = __( "User not found. Creating a new one is also not possible: Email is required.", 'wp-webhooks' );

						return $return_args;
					}

				}

			} else {
				$dynamic_user_login = apply_filters( 'wpwhpro/run/create_action_user_login', false );
				if ( empty( $user_login ) && $dynamic_user_login ) {
					$user_login = WPWHPRO()->helpers->create_random_unique_username( $user_email, 'user_' );
				}

				//Define on new user
				if( ! empty( $role ) ){
					$user_data['role'] = 'subscriber';
				}

				//Auto generate on new user
				if( empty( $user_pass ) ){
					$user_data['user_pass'] = wp_generate_password( 32, true, false );
				}
			}

			if( ! empty( $nickname ) ){
				$user_data['nickname'] = $nickname;
			}

			if( ! empty( $user_login ) ){
				$user_data['user_login'] = $user_login;
			} else {
				if( ! $update ){
					$user_data['user_login'] = sanitize_title( $user_email );
				}
			}

			if( ! empty( $user_nicename ) ){
				$user_data['user_nicename'] = $user_nicename;
			}

			if( ! empty( $description ) ){
				$user_data['description'] = $description;
			}

			if( ! empty( $rich_editing ) ){
				$user_data['rich_editing'] = $rich_editing;
			}

			if( ! empty( $user_registered ) ){
				$user_data['user_registered'] = $user_registered;
			}

			if( ! empty( $user_url ) ){
				$user_data['user_url'] = $user_url;
			}

			if( ! empty( $display_name ) ){
				$user_data['display_name'] = $display_name;
			}

			if( ! empty( $first_name ) ){
				$user_data['first_name'] = $first_name;
			}

			if( ! empty( $last_name ) ){
				$user_data['last_name'] = $last_name;
			}

			if( ! empty( $role ) ){
				$user_data['role'] = $role;
			}

			if( ! empty( $user_pass ) ){
				$user_data['user_pass'] = $user_pass;
			}

			//Add user meta using the official filter
			add_filter( 'insert_user_meta', array( $user_helpers, 'create_update_user_add_user_meta' ), 10, 2 );

			if( $update ){
				$user_id = wp_update_user( $user_data );
			} else {
				$user_id = wp_insert_user( $user_data );
			}

			remove_filter( 'insert_user_meta', array( $user_helpers, 'create_update_user_add_user_meta' ), 10 );

			if ( ! is_wp_error( $user_id ) && is_numeric( $user_id ) && ! empty( $user_id ) ) {

				//Keep the old meta for backwards compatibility
				if( ! empty( $user_meta ) ){
					$user_data['meta_data'] = $user_meta;
				}

				if( ! empty( $meta_update ) ){
					$manage_meta_data = $user_helpers->merge_repeater_meta_data( $manage_meta_data, $meta_update );
				}
 
				if( ! empty( $manage_meta_data ) ){
					$user_meta_data_response = $user_helpers->manage_user_meta_data( $user_id, $manage_meta_data );
				}

				$manage_acf_data_response = array();
				if( WPWHPRO()->helpers->is_plugin_active( 'advanced-custom-fields' ) ){

					if( ! empty( $acf_meta_update ) ){
						$manage_acf_data = WPWHPRO()->acf->merge_repeater_meta_data( $manage_acf_data, $acf_meta_update );
					}
					
					if( ! empty( ! empty( $manage_acf_data ) ) ){
						$manage_acf_data_response = WPWHPRO()->acf->manage_acf_meta( $user_id, $manage_acf_data, 'user' );
					}
					
				}

				//Manage user roles
				if( ! empty( $additional_roles ) ){

					$wpwh_current_user = new WP_User( $user_id );

					if( WPWHPRO()->helpers->is_json( $additional_roles ) ){

						$additional_roles_meta_data = json_decode( $additional_roles, true );
						foreach( $additional_roles_meta_data as $sarole => $sastatus ){

							switch( $sastatus ){
								case 'add':
									$wpwh_current_user->add_role( sanitize_text_field( $sarole ) );
								break;
								case 'remove':
									$wpwh_current_user->remove_role( sanitize_text_field( $sarole ) );
								break;
							}

						}

					} else {

						$additional_roles_data = explode( ';', trim( $additional_roles, ';' ) );
						foreach( $additional_roles_data as $single_additional_role ){

							$additional_roles_data = explode( ':', trim( $single_additional_role, ':' ) );
							if(
								! empty( $additional_roles_data )
								&& is_array( $additional_roles_data )
								&& ! empty( $additional_roles_data[0] )
								&& ! empty( $additional_roles_data[1] )
							){

								switch( $additional_roles_data[1] ){
									case 'add':
										$wpwh_current_user->add_role( sanitize_text_field( $additional_roles_data[0] ) );
									break;
									case 'remove':
										$wpwh_current_user->remove_role( sanitize_text_field( $additional_roles_data[0] ) );
									break;
								}

							}
						}

					}

				}

				//Map additional roles to user data
				$user_data['additional_roles'] = $additional_roles;

				if( $update ){
					$return_args['msg'] = __( "User successfully updated.", 'wp-webhooks' );
				} else {
					$return_args['msg'] = __( "User successfully created.", 'wp-webhooks' );
				}

				$return_args['success'] = true;
				$return_args['data']['user_id'] = $user_id;
				$return_args['data']['user_data'] = $user_data;

				if( ! empty( $manage_meta_data ) ){
					$return_args['data']['manage_meta_data'] = $user_meta_data_response;
				}

				if( WPWHPRO()->helpers->is_plugin_active( 'advanced-custom-fields' ) && ! empty( $manage_acf_data_response ) ){
					$return_args['data']['manage_acf_data'] = $manage_acf_data_response;
				}

				if( apply_filters( 'wpwhpro/run/create_action_user_email_notification', true ) && $send_email == 'yes' ){
					wp_new_user_notification( $user_id, null, 'both' );
				}
			} else {
				$return_args['msg'] = __( "An error occured while creating the user. Please check the response for more details.", 'wp-webhooks' );
				$return_args['data']['user_id'] = $user_id;
				$return_args['data']['user_data'] = $user_data;
			}

			if( ! empty( $do_action ) ){
				do_action( $do_action, $user_data, $user_id, $user_meta, $update );
			}

			return $return_args;
		}

	}

endif; // End if class_exists check.