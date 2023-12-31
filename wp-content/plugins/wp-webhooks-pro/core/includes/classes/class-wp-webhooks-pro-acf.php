<?php

/**
 * WP_Webhooks_Pro_ACF Class
 *
 * This class contains all of the Advanced Custom Fields related functions
 *
 * @since 3.0.8
 */

/**
 * The api class of the plugin.
 *
 * @since 3.0.8
 * @package WPWHPRO
 * @author Ironikus <info@ironikus.com>
 */
class WP_Webhooks_Pro_ACF {

  /**
		 * Merge the repeater meta data with the manage_acf_data argument
		 * 
		 * @since 5.2
		 *
		 * @param mixed $manage_acf_data
		 * @param mixed $meta_data
		 * @return array
		 */
		public function merge_repeater_meta_data( $manage_acf_data, $meta_data ){

			if( empty( $manage_acf_data ) ){
				$manage_acf_data = array(
					'update_field' => array()
				);
			} elseif( WPWHPRO()->helpers->is_json( $manage_acf_data ) ) {
				$manage_acf_data = json_decode( $manage_acf_data, true );
				
				if( ! isset( $manage_acf_data['update_field'] ) ){
					$manage_acf_data['update_field'] = array();
				}
			} elseif( is_array( $manage_acf_data ) ){
				if( ! isset( $manage_acf_data['update_field'] ) ){
					$manage_acf_data['update_field'] = array();
				}
			} else {

				//Don't merge anything if we cannot determine the format
				return $manage_acf_data;
			}

			if( WPWHPRO()->helpers->is_json( $meta_data ) ){
				$meta_data = json_decode( $meta_data, true );
			}
			
			if( ! empty( $meta_data ) && is_array( $meta_data ) ){

				$validated_meta_data = array();

				//Prepare format
				foreach( $meta_data as $meta_key => $meta_value ){
					$validated_meta_data[] = array(
						'selector' => $meta_key,
						'value' => $meta_value,
					);
				}

				$manage_acf_data['update_field'] = array_merge( $validated_meta_data, $manage_acf_data['update_field'] );
			}

			return $manage_acf_data;
		}

	/**
	 * Add ACF specific fields using only acf features
	 *
	 * @param integer $object_id - the id of the given user
	 * @param array $meta_acf - the custom acf construct 
	 * @param integer $type - leave it at false if you want to trigger the logic on posts, otherwise customize it
	 * @return void
	 */
	public function manage_acf_meta( $object_id, $meta_acf, $type = false ){
		$return = array(
			'success' => false,
			'msg' => '',
			'data' => array(),
		);

		$options_type = array(
		'option',
		'options',
		);

		if( empty( $object_id ) && ! in_array( $type, $options_type ) ){
			$return['msg'] = __( 'No object id was given.', 'wp-webhooks' );
			return $return;
		}

		if( empty( $meta_acf ) ){
			$return['msg'] = __( 'The meta_acf argument cannot be empty.', 'wp-webhooks' );
			return $return;
		}

		if( is_string( $meta_acf ) && WPWHPRO()->helpers->is_json( $meta_acf ) ){
			$meta_acf = json_decode( $meta_acf, true );
		}

		
		if( empty( $meta_acf ) || ! is_array( $meta_acf ) ){
			$return['msg'] = __( 'There was an issue decoding the meta_acf JSON.', 'wp-webhooks' );
			return $return;
        }

        //ACF required a definition based on the object type within the $object_id
        if( ! empty( $type ) ){
          if( in_array( $type, $options_type ) ){
            $validated_object_id = sanitize_title( $type );
          } else {
            $validated_object_id = sanitize_title( $type ) . '_' . intval( $object_id );
          }
            
        } else {
            $validated_object_id = intval( $object_id );
        }

		foreach( $meta_acf as $function => $data ){
			switch( $function ){
				case 'add_row':

					$return['data']['add_row'] = array();

					foreach( $data as $add_row_key => $add_row_data ){
						if( isset( $add_row_data['selector'] ) && isset( $add_row_data['value'] ) ){

							$ignore_empty = ( isset( $add_row_data['ignore_empty'] ) && ! empty( $add_row_data['ignore_empty'] ) ) ? true : false;

							if( ! $ignore_empty || $ignore_empty && ! empty( $add_row_data['value'] ) ){

								//loop through the array if given and clean empty row values
								if( $ignore_empty && is_array( $add_row_data['value'] ) ){
									
									foreach( $add_row_data['value'] as $svk => $svv ){
										if( empty( $add_row_data['value'][ $svk ] ) ){
											unset( $add_row_data['value'][ $svk ] );
										}
									}

									if( empty( $add_row_data['value'] ) ){
										continue;
									}
								}

								$return_add_row = add_row( $add_row_data['selector'], $add_row_data['value'], $validated_object_id );
							} else {
								continue;
							}

							$return['data']['add_row'][ $add_row_key ] = array(
								'selector' => $add_row_data['selector'],
								'value' => $add_row_data['value'],
								'response' => $return_add_row,
								'ignore_empty' => $ignore_empty,
							);
						}
					}
					
				break;
				case 'add_sub_row':

					$return['data']['add_sub_row'] = array();

					foreach( $data as $add_sub_row_key => $add_sub_row_data ){
						if( isset( $add_sub_row_data['selector'] ) && isset( $add_sub_row_data['value'] ) ){

							$ignore_empty = ( isset( $add_sub_row_data['ignore_empty'] ) && ! empty( $add_sub_row_data['ignore_empty'] ) ) ? true : false;

							if( ! $ignore_empty || $ignore_empty && ! empty( $add_sub_row_data['value'] ) ){

								//loop through the array if given and clean empty row values
								if( $ignore_empty && is_array( $add_sub_row_data['value'] ) ){
									foreach( $add_sub_row_data['value'] as $svk => $svv ){
										if( empty( $add_sub_row_data['value'][ $svk ] ) ){
											unset( $add_sub_row_data['value'][ $svk ] );
										}
									}

									if( empty( $add_sub_row_data['value'] ) ){
										continue;
									}
								}

								$return_add_sub_row = add_sub_row( $add_sub_row_data['selector'], $add_sub_row_data['value'], $validated_object_id );
							} else {
								continue;
							}

							$return['data']['add_sub_row'][ $add_sub_row_key ] = array(
								'selector' => $add_sub_row_data['selector'],
								'value' => $add_sub_row_data['value'],
								'response' => $return_add_sub_row,
								'ignore_empty' => $ignore_empty,
							);
						}
					}

				break;
				case 'delete_field':

					$return['data']['delete_field'] = array();

					foreach( $data as $delete_field_key => $delete_field_data ){
						if( isset( $delete_field_data['selector'] ) ){
							$return_delete_field = delete_field( $delete_field_data['selector'], $validated_object_id );

							$return['data']['delete_field'][ $delete_field_key ] = array(
								'selector' => $delete_field_data['selector'],
								'response' => $return_delete_field,
							);
						}
					}

				break;
				case 'delete_row':

					$return['data']['delete_row'] = array();

					foreach( $data as $delete_row_key => $delete_row_data ){
						if( isset( $delete_row_data['selector'] ) && isset( $delete_row_data['row'] ) ){
							$return_delete_row = delete_row( $delete_row_data['selector'], $delete_row_data['row'], $validated_object_id );

							$return['data']['delete_row'][ $delete_row_key ] = array(
								'selector' => $delete_row_data['selector'],
								'row' => $delete_row_data['row'],
								'response' => $return_delete_row,
							);
						}
					}

				break;
				case 'delete_sub_field':

					$return['data']['delete_sub_field'] = array();

					foreach( $data as $delete_sub_field_key => $delete_sub_field_data ){
						if( isset( $delete_sub_field_data['selector'] ) ){
							$return_delete_sub_field = delete_sub_field( $delete_sub_field_data['selector'], $validated_object_id );

							$return['data']['delete_sub_field'][ $delete_sub_field_key ] = array(
								'selector' => $delete_sub_field_data['selector'],
								'response' => $return_delete_sub_field,
							);
						}
					}

				break;
				case 'delete_sub_row':

					$return['data']['delete_sub_row'] = array();

					foreach( $data as $delete_sub_row_key => $delete_sub_row_data ){
						if( isset( $delete_sub_row_data['selector'] ) && isset( $delete_sub_row_data['row'] ) ){
							$return_delete_sub_row = delete_sub_row( $delete_sub_row_data['selector'], $delete_sub_row_data['row'], $validated_object_id );

							$return['data']['delete_sub_row'][ $delete_sub_row_key ] = array(
								'selector' => $delete_sub_row_data['selector'],
								'row' => $delete_sub_row_data['row'],
								'response' => $return_delete_sub_row,
							);
						}
					}

				break;
				case 'update_field':

					$return['data']['update_field'] = array();

					foreach( $data as $update_field_key => $update_field_data ){
						if( isset( $update_field_data['selector'] ) && isset( $update_field_data['value'] ) ){

							$ignore_empty = ( isset( $update_field_data['ignore_empty'] ) && ! empty( $update_field_data['ignore_empty'] ) ) ? true : false;

							if( ! $ignore_empty || $ignore_empty && ! empty( $update_field_data['value'] ) ){
								$return_update_field = update_field( $update_field_data['selector'], $update_field_data['value'], $validated_object_id );
							} else {
								continue;
							}

							$return['data']['update_field'][ $update_field_key ] = array(
								'selector' => $update_field_data['selector'],
								'value' => $update_field_data['value'],
								'response' => $return_update_field,
								'ignore_empty' => $ignore_empty,
							);
						}
					}

				break;
				case 'update_row':

					$return['data']['update_row'] = array();

					foreach( $data as $update_row_key => $update_row_data ){
						if( isset( $update_row_data['selector'] ) && isset( $update_row_data['row'] ) && isset( $update_row_data['value'] ) ){

							$ignore_empty = ( isset( $update_row_data['ignore_empty'] ) && ! empty( $update_row_data['ignore_empty'] ) ) ? true : false;

							if( ! $ignore_empty || $ignore_empty && ! empty( $update_row_data['value'] ) ){

								//loop through the array if given and clean empty row values
								if( $ignore_empty && is_array( $update_row_data['value'] ) ){
									foreach( $update_row_data['value'] as $svk => $svv ){
										if( empty( $update_row_data['value'][ $svk ] ) ){
											unset( $update_row_data['value'][ $svk ] );
										}
									}

									if( empty( $add_sub_row_data['value'] ) ){
										continue;
									}
								}

								$return_update_row = update_row( $update_row_data['selector'], $update_row_data['row'], $update_row_data['value'], $validated_object_id );
							} else {
								continue;
							}

							$return['data']['update_row'][ $update_row_key ] = array(
								'selector' => $update_row_data['selector'],
								'row' => $update_row_data['row'],
								'value' => $update_row_data['value'],
								'response' => $return_update_row,
								'ignore_empty' => $ignore_empty,
							);
						}
					}

				break;
				case 'update_sub_field':

					$return['data']['update_sub_field'] = array();

					foreach( $data as $update_sub_field_key => $update_sub_field_data ){
						if( isset( $update_sub_field_data['selector'] ) && isset( $update_sub_field_data['value'] ) ){

							$ignore_empty = ( isset( $update_sub_field_data['ignore_empty'] ) && ! empty( $update_sub_field_data['ignore_empty'] ) ) ? true : false;

							if( ! $ignore_empty || $ignore_empty && ! empty( $update_sub_field_data['value'] ) ){
								$return_update_sub_field = update_sub_field( $update_sub_field_data['selector'], $update_sub_field_data['value'], $validated_object_id );
							} else {
								continue;
							}

							$return['data']['update_sub_field'][ $update_sub_field_key ] = array(
								'selector' => $update_sub_field_data['selector'],
								'value' => $update_sub_field_data['value'],
								'response' => $return_update_sub_field,
								'ignore_empty' => $ignore_empty,
							);
						}
					}

				break;
				case 'update_sub_row':

					$return['data']['update_sub_row'] = array();

					foreach( $data as $update_sub_row_key => $update_sub_row_data ){
						if( isset( $update_sub_row_data['selector'] ) && isset( $update_sub_row_data['row'] ) && isset( $update_sub_row_data['value'] ) ){

							$ignore_empty = ( isset( $update_sub_row_data['ignore_empty'] ) && ! empty( $update_sub_row_data['ignore_empty'] ) ) ? true : false;

							if( ! $ignore_empty || $ignore_empty && ! empty( $update_sub_row_data['value'] ) ){

								//loop through the array if given and clean empty row values
								if( $ignore_empty && is_array( $update_sub_row_data['value'] ) ){
									foreach( $update_sub_row_data['value'] as $svk => $svv ){
										if( empty( $update_sub_row_data['value'][ $svk ] ) ){
											unset( $update_sub_row_data['value'][ $svk ] );
										}
									}

									if( empty( $add_sub_row_data['value'] ) ){
										continue;
									}
								}

								$return_update_sub_row = update_sub_row( $update_sub_row_data['selector'], $update_sub_row_data['row'], $update_sub_row_data['value'], $validated_object_id );
							} else {
								continue;
							}

							$return['data']['update_sub_row'][ $update_sub_row_key ] = array(
								'selector' => $update_sub_row_data['selector'],
								'row' => $update_sub_row_data['row'],
								'value' => $update_sub_row_data['value'],
								'response' => $return_update_sub_row,
								'ignore_empty' => $ignore_empty,
							);
						}
					}

				break;
			}
		}

		$return['success'] = true;
		$return['msg'] = __( 'The given ACF data has been successfully executed.', 'wp-webhooks' );

		return $return;
	}

public function load_acf_description( $deprecated = '' ){
?>
<h5><?php echo __( "manage_acf_data", 'wp-webhooks' ); ?></h5>
<?php echo __( "This argument integrates this endpoint with ", 'wp-webhooks' ); ?><a target="_blank" title="Advanced Custom Fields" href="https://www.advancedcustomfields.com/">Advanced Custom Fields</a>.
<p class="text-secondary">
  <strong><?php echo __( "Important:", 'wp-webhooks' ); ?></strong> <?php echo __( "We created a meta value generator that helps you to get started using this argument. You will find the generator here within the ACF section:", 'wp-webhooks' ); ?> <a target="_blank" title="<?php echo __( "Advanced Custom Fields Meta value generator", 'wp-webhooks' ); ?>" href="https://wp-webhooks.com/blog/how-to-update-custom-post-meta-values-with-wp-webhooks/">https://wp-webhooks.com/blog/how-to-update-custom-post-meta-values-with-wp-webhooks/</a>.
</p>
<br>
<br>
<?php echo __( "<strong>Please note</strong>: This argument is very powerful and requires some good understanding of JSON. It is integrated with all Update functions offered by ACF. You can find a list of all update functions here: ", 'wp-webhooks' ); ?>
<a href="https://www.advancedcustomfields.com/resources/#functions" target="_blank">https://www.advancedcustomfields.com/resources/#functions</a>
<br>
<?php echo __( "Down below you will find some examples that show you how to use each of the functions.", 'wp-webhooks' ); ?>
<br>
<br>
<?php echo __( "This argument accepts a validated JSON construct as an input. This construct contains each available function within its top layers and the assigned data respectively as a value. If you want to learn more about each line, please take a closer look at the bottom of the example.", 'wp-webhooks' ); ?>
<br>
<?php echo __( "Down below you will find a list that explains each of the top level keys including an example.", 'wp-webhooks' ); ?>
<ol>
    <li>
        <strong><?php echo __( "add_row", 'wp-webhooks' ); ?></strong>
        <br>
        <?php echo __( "This key refers to the <strong>add_row()</strong> function of ACF:", 'wp-webhooks' ); ?> <a title="Go to Advanced Custom Fields" target="_blank" href="https://www.advancedcustomfields.com/resources/add_row">https://www.advancedcustomfields.com/resources/add_row</a>
<pre>
{
    "add_row": [
      {
        "selector": "demo_repeater",
        "value": {
          "demo_repeater_field": "This is the first text",
          "demo_repeater_url": "https://someurl1.com"
        },
		"ignore_empty": false
      },
      {
        "selector": "demo_repeater",
        "value": {
          "demo_repeater_field": "This is the second text",
          "demo_repeater_url": "https://someurl2.com"
        },
		"ignore_empty": false
      }
    ]
}
</pre>
        <?php echo __( "The example value for this key above shows you on how you can add multiple keys and values using the <strong>add_row()</strong> function. To make it work, you can add an array within the given construct, using the <strong>selector</strong> key for the key of the repeater field and the <strong>value</strong> key for the actual row data. Please note that the value for the row data must be an array using the seen JSON notation (Do not simply include a string). The value for the given example will add a new row to the <strong>demo_repeater_content</strong> repeater field which includes a sub field called <strong>demo_repeater_child_field</strong> and another sub field called <strong>demo_repeater_child_url</strong>.", 'wp-webhooks' ); ?>
		<br>
		<?php echo __( "You can also define the ignore_empty key. If set to true, empty values for the value key are ignored. This includes: '', false, null, 0", 'wp-webhooks' ); ?>
	</li>
    <li>
        <strong><?php echo __( "add_sub_row", 'wp-webhooks' ); ?></strong>
        <br>
        <?php echo __( "This key refers to the <strong>add_sub_row()</strong> function of ACF:", 'wp-webhooks' ); ?> <a title="Go to Advanced Custom Fields" target="_blank" href="https://www.advancedcustomfields.com/resources/add_sub_row">https://www.advancedcustomfields.com/resources/add_sub_row</a>
<pre>
{
    "add_sub_row": [
      {
        "selector": [
          "demo_repeater_content", 1, "sub_repeater"
        ],
        "value": {
          "sub_repeater_field": "Sub Repeater Text Value"
        },
		"ignore_empty": false
      }
    ]
}
</pre>
        <?php echo __( "Within the example above, you will see how you can add a row to a sub row (e.g. if the repeater field as also a repeater field). The <strong>selector</strong> key can contain a string or an array that determins the exact position of the sub row. You can see the value for the <strong>selector</strong> key as a mapping to the sub row. The <strong>value</strong> key can contain a string or an array, depending on the choice of the field.", 'wp-webhooks' ); ?>
		<br>
		<?php echo __( "You can also define the ignore_empty key. If set to true, empty values for the value key are ignored. This includes: '', false, null, 0", 'wp-webhooks' ); ?>
	</li>
    <li>
        <strong><?php echo __( "delete_field", 'wp-webhooks' ); ?></strong>
        <br>
        <?php echo __( "This key refers to the <stro>delete_field()</strong> function of ACF:", 'wp-webhooks' ); ?> <a title="Go to Advanced Custom Fields" target="_blank" href="https://www.advancedcustomfields.com/resources/delete_field">https://www.advancedcustomfields.com/resources/delete_field</a>
<pre>
{
    "delete_field": [
      {
        "selector": "demo_field"
      }
    ]
}
</pre>
        <?php echo __( "To delete a field, you can use the same notation as seen above in the example. Simply add another row to the JSON including the field name, of the field you want to delete, into the <strong>selector</strong> key. This will cause the field to be deleted. You can also use this function to clear repeater fields.", 'wp-webhooks' ); ?>
    </li>
    <li>
        <strong><?php echo __( "delete_row", 'wp-webhooks' ); ?></strong>
        <br>
        <?php echo __( "This key refers to the <strong>delete_row()</strong> function of ACF:", 'wp-webhooks' ); ?> <a title="Go to Advanced Custom Fields" target="_blank" href="https://www.advancedcustomfields.com/resources/delete_row/">https://www.advancedcustomfields.com/resources/delete_row/</a>
<pre>
{
    "delete_row": [
      {
        "selector": "demo_repeater_row",
        "row": 2
      }
    ]
}
</pre>
        <?php echo __( "The example above shows that the logic is going to delete the second row for the <strong>demo_repeater_content</strong> repeater field. You can also see that we send over the numeric value for the row which is required by ACF.", 'wp-webhooks' ); ?>
    </li>
    <li>
        <strong><?php echo __( "delete_sub_field", 'wp-webhooks' ); ?></strong>
        <br>
        <?php echo __( "This key refers to the <strong>delete_sub_field()</strong> function of ACF:", 'wp-webhooks' ); ?> <a title="Go to Advanced Custom Fields" target="_blank" href="https://www.advancedcustomfields.com/resources/delete_sub_field/">https://www.advancedcustomfields.com/resources/delete_sub_field/</a>
<pre>
{
    "delete_sub_field": [
      {
        "selector": [
          "demo_repeater", 2, "sub_repeater", 2, "sub_repeater_field"
        ]
      }
    ]
}
</pre>
        <?php echo __( "This allows you to delete a specific field within a repeater, flexible content or sub-repeater, etc.. To make it work, you must need to set the <strong>selector</strong> key as an array containing the given mapping of the field you'd like to delete. The example deletes a fiel of a sub-repeater.", 'wp-webhooks' ); ?>
    </li>
    <li>
        <strong><?php echo __( "delete_sub_row", 'wp-webhooks' ); ?></strong>
        <br>
        <?php echo __( "This key refers to the <strong>delete_sub_row()</strong> function of ACF:", 'wp-webhooks' ); ?> <a title="Go to Advanced Custom Fields" target="_blank" href="https://www.advancedcustomfields.com/resources/delete_sub_row/">https://www.advancedcustomfields.com/resources/delete_sub_row/</a>
<pre>
{
    "delete_sub_row": [
      {
        "selector": [
          "demo_repeater", 2, "sub_repeater"
        ],
        "row": 2
      }
    ]
}
</pre>
        <?php echo __( "Delete the whole row of a sub-repeater field or flexible content. For the <strong>selector</strong> key you must define an array (as seen in the example) that contains the exact mapping of the repeater/flexible field you want to target. As for the <strong>row</strong> key, you must set the number of the row you want to delete.", 'wp-webhooks' ); ?>
    </li>
    <li>
        <strong><?php echo __( "update_field", 'wp-webhooks' ); ?></strong>
        <br>
        <?php echo __( "This key refers to the <strong>update_field()</strong> function of ACF:", 'wp-webhooks' ); ?> <a title="Go to Advanced Custom Fields" target="_blank" href="https://www.advancedcustomfields.com/resources/update_field">https://www.advancedcustomfields.com/resources/update_field</a>
<pre>
{
    "update_field":[
      {
        "selector": "first_custom_key",
        "value": "Some custom value",
		"ignore_empty": false
      },
      {
        "selector": "second_custom_key",
        "value": { "some_array_key": "Some array Value" },
		"ignore_empty": false
      } 
    ]
}
</pre>
        <?php echo __( "The example value for this key above shows you on how you can add multiple keys and values using the <strong>update_field()</strong> function. To make it work, you can add an array within the given construct, using the <strong>selector</strong> key for the post meta key and the <strong>value</strong> key for the actual value. The example also shows on how you can include an array. To make that work, you can simply create a sub entry for the value instead of a simple string as seen in the second example.", 'wp-webhooks' ); ?>
		<br>
		<?php echo __( "You can also define the ignore_empty key. If set to true, empty values for the value key are ignored. This includes: '', false, null, 0", 'wp-webhooks' ); ?>
	</li>
    <li>
        <strong><?php echo __( "update_row", 'wp-webhooks' ); ?></strong>
        <br>
        <?php echo __( "This key refers to the <strong>update_row()</strong> function of ACF:", 'wp-webhooks' ); ?> <a title="Go to Advanced Custom Fields" target="_blank" href="https://www.advancedcustomfields.com/resources/update_row">https://www.advancedcustomfields.com/resources/update_row</a>
<pre>
{
    "update_row":[
      {
        "selector": "demo_repeater",
        "row": 2,
        "value": {
          "demo_repeater_field": "New Demo Text",
          "demo_repeater_url": "https://somenewurl.com"
        },
		"ignore_empty": false
      }
    ]
}
</pre>
        <?php echo __( "Using the update_row() function, you can update specific or all fields of that given row. To do so, simply define the repeater/flexible content field name afor the <strong>selector</strong> key, the row number for the <strong>row</strong> key and for the <strong>value</strong> key the array containing all of your required fields you want to update.", 'wp-webhooks' ); ?>
		<br>
		<?php echo __( "You can also define the ignore_empty key. If set to true, empty values for the value key are ignored. This includes: '', false, null, 0", 'wp-webhooks' ); ?>
	</li>
    <li>
        <strong><?php echo __( "update_sub_field", 'wp-webhooks' ); ?></strong>
        <br>
        <?php echo __( "This key refers to the <strong>update_sub_field()</strong> function of ACF:", 'wp-webhooks' ); ?> <a title="Go to Advanced Custom Fields" target="_blank" href="https://www.advancedcustomfields.com/resources/update_sub_field">https://www.advancedcustomfields.com/resources/update_sub_field</a>
<pre>
{
    "update_sub_field":[
      {
        "selector": [
          "demo_repeater", 2, "sub_repeater", 1, "sub_repeater_field"
        ],
        "value": "Some New Text",
		"ignore_empty": false
      }
    ]
}
</pre>
        <?php echo __( "Use this function if your goal is to update a specific, nested field within a repeater/flexible content. As for the <strong>selector</strong> key, you need to set an array containing the exact mapping position to target the exact field you would like to update. As for the <strong>value</strong>, you can define the content of the field.", 'wp-webhooks' ); ?>
		<br>
		<?php echo __( "You can also define the ignore_empty key. If set to true, empty values for the value key are ignored. This includes: '', false, null, 0", 'wp-webhooks' ); ?>
	</li>
    <li>
        <strong><?php echo __( "update_sub_row", 'wp-webhooks' ); ?></strong>
        <br>
        <?php echo __( "This key refers to the <strong>update_sub_row()</strong> function of ACF:", 'wp-webhooks' ); ?> <a title="Go to Advanced Custom Fields" target="_blank" href="https://www.advancedcustomfields.com/resources/update_sub_row">https://www.advancedcustomfields.com/resources/update_sub_row</a>
<pre>
{
    "update_sub_row":[
      {
        "selector": [
          "demo_repeater", 2, "sub_repeater"
        ],
        "row": 2,
        "value": {
          "sub_repeater_field": "Updated Sub Row Text"
        },
		"ignore_empty": false
      }
    ]
}
</pre>
        <?php echo __( "With this function, you can update a whole row within a repeater/flecible content field. To make it work, please define for the <strong>selector</strong> key an array contianing the exact mapping to target the row you want to update. For the <strong>row</strong> key, please specify the row within the sub field. As for the <strong>value</strong>, please include an array containing all single fields you would like to update.", 'wp-webhooks' ); ?>
		<br>
		<?php echo __( "You can also define the ignore_empty key. If set to true, empty values for the value key are ignored. This includes: '', false, null, 0", 'wp-webhooks' ); ?>
    </li>
</ol>
<strong><?php echo __( "Some tipps:", 'wp-webhooks' ); ?></strong>
<ol>
    <li>
        <?php echo __( "You can combine all of the functions within a single JSON such as:", 'wp-webhooks' ); ?>
<pre>
{
    "update_field": {},
    "update_row": {},
    "update_sub_field": {},
    "update_sub_row": {}
}
</pre>
    </li>
    <li><?php echo __( "You can include the value for this argument as a simple string to your webhook payload or you integrate it directly as JSON into your JSON payload (if you send a raw JSON response).", 'wp-webhooks' ); ?></li>
    <li><?php echo __( "Changing the order of the functions within the JSON causes the added values behave differently. If you, for example, add the <strong>delete_field</strong> key before the <strong>update_field</strong> key, the fields will first be deleted and then added/updated.", 'wp-webhooks' ); ?></li>
    <li><?php echo __( "The webhook response contains a validted array that shows each initialized meta entry, as well as the response from its original ACF function. This way you can see if the meta value was adjusted accordingly.", 'wp-webhooks' ); ?></li>
</ol>
<hr>
<?php
}

}
