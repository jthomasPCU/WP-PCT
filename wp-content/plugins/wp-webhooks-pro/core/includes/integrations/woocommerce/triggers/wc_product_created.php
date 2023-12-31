<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'WP_Webhooks_Integrations_woocommerce_Triggers_wc_product_created' ) ) :

 /**
  * Load the wc_product_created trigger
  *
  * @since 4.3.2
  * @author Ironikus <info@ironikus.com>
  */
  class WP_Webhooks_Integrations_woocommerce_Triggers_wc_product_created {

	public function get_callbacks(){

		return array(
			array(
				'type' => 'action',
				'hook' => 'woocommerce_new_product',
				'callback' => array( $this, 'wc_product_created_callback' ),
				'priority' => 20,
				'arguments' => 1,
				'delayed' => true,
			),
			array(
				'type' => 'action',
				'hook' => 'woocommerce_new_product_variation',
				'callback' => array( $this, 'wc_product_created_callback' ),
				'priority' => 20,
				'arguments' => 1,
				'delayed' => true,
			),
		);
	}

	public function get_details(){

		$parameter = array(
			'custom' => array( 'short_description' => __( 'A custom data construct from your chosen Woocommerce API.', 'wp-webhooks' ) ),
		);

		$description = array(
			'tipps' => array(
				__( 'If the webhook does not work as expected due to an error like "woocommerce_rest_cannot_view", please adjust the user ID within the trigger settings.', 'wp-webhooks' ),
				__( 'You can fire this trigger as well on a specific Woocommerce API version. To do that, select a version within the webhook URL settings.', 'wp-webhooks' ),
				__( 'You can also set a custom secret key just as for the default Woocommerce webhooks. IF you do not set one, there will be one automatically generated.', 'wp-webhooks' ),
			)
		);

		$settings = array(
			'load_default_settings' => true,
			'data' => array(
				'wpwhpro_woocommerce_set_user' => array(
					'id'		  => 'wpwhpro_woocommerce_set_user',
					'type'		=> 'text',
					'label'	   => __( 'Set user id', 'wp-webhooks' ),
					'placeholder' => '',
					'required'	=> false,
					'description' => __( 'Set the numeric ID of a user that has permission to view the Woocommerce REST API. By default we try to locate the ID of the first admin user.', 'wp-webhooks' )
				),
				'wpwhpro_woocommerce_set_api_version' => array(
					'id'		  => 'wpwhpro_woocommerce_set_api_version',
					'type'		=> 'select',
					'multiple'	=> false,
					'choices'	  => array(),
					'query'			=> array(
						'filter'	=> 'helpers',
						'args'		=> array(
							'integration' => 'woocommerce',
							'helper' => 'wc_helpers',
							'function' => 'get_query_wc_api_versions',
						)
					),
					'label'	   => __( 'Set API version', 'wp-webhooks' ),
					'placeholder' => '',
					'required'	=> false,
					'default_value'	=> 'wp_api_v2',
					'description' => __( 'Select the Woocommerce API version you want to use for this request. By default, we use wp_api_v2', 'wp-webhooks' )
				),
				'wpwhpro_woocommerce_set_secret' => array(
					'id'		  => 'wpwhpro_woocommerce_set_secret',
					'type'		=> 'text',
					'label'	   => __( 'Set secret', 'wp-webhooks' ),
					'placeholder' => '',
					'required'	=> false,
					'description' => __( 'Set a custom secret that gets validated by Woocommerce, just as you know it from the default Woocommerce webhooks.', 'wp-webhooks' )
				),
			)
		);

		return array(
			'trigger'		   => 'wc_product_created',
			'name'			  => __( 'Product created', 'wp-webhooks' ),
			'sentence'			  => __( 'a product was created', 'wp-webhooks' ),
			'parameter'		 => $parameter,
			'settings'		  => $settings,
			'returns_code'	  => $this->get_demo( array() ),
			'short_description' => __( 'This webhook fires as soon as a product was created within Woocommerce.', 'wp-webhooks' ),
			'description'	   => $description,
			'integration'	   => 'woocommerce',
			'premium'		   => true,
		);

	}

	/**
	 * Triggers once a product was created
	 *
	 * @param mixed $arg
	 */
	public function wc_product_created_callback( $arg ){

		$webhooks = WPWHPRO()->webhook->get_hooks( 'trigger', 'wc_product_created' );
		$payload = array();
		$payload_track = array();

		$topic = 'product.created';
		$api_version = 'wp_api_v2';

		if( ! class_exists( 'WC_Webhook' ) ){
			return;
		}

		$wc_helpers = WPWHPRO()->integrations->get_helper( 'woocommerce', 'wc_helpers' );
		$post_id = ( is_numeric( $arg ) ) ? intval( $arg ) : 0;

		$wc_webhook = new WC_Webhook();
		$wc_webhook->set_name( 'wpwh-' . $topic );
		$wc_webhook->set_status( 'active' );
		$wc_webhook->set_topic( $topic );
		$wc_webhook->set_user_id( 0 );
		$wc_webhook->set_pending_delivery( false );
		#$wc_webhook->set_delivery_url(  );

		$response_data_array = array();

		foreach( $webhooks as $webhook ){

			$webhook_url_name = ( is_array($webhook) && isset( $webhook['webhook_url_name'] ) ) ? $webhook['webhook_url_name'] : null;
			$is_valid = true;

			if( isset( $webhook['settings'] ) ){

				if( $is_valid && isset( $webhook['settings']['wpwhpro_woocommerce_set_api_version'] ) && ! empty( $webhook['settings']['wpwhpro_woocommerce_set_api_version'] ) ){
					$api_version = $webhook['settings']['wpwhpro_woocommerce_set_api_version'];
				}

				if( $is_valid && isset( $webhook['settings']['wpwhpro_woocommerce_set_secret'] ) && ! empty( $webhook['settings']['wpwhpro_woocommerce_set_secret'] ) ){
					$wc_webhook->set_secret( $webhook['settings']['wpwhpro_woocommerce_set_secret'] );
				}

				if( $is_valid 
					&& isset( $webhook['settings']['wpwhpro_woocommerce_set_user'] ) 
					&& ! empty( $webhook['settings']['wpwhpro_woocommerce_set_user'] ) 
					&& is_numeric( $webhook['settings']['wpwhpro_woocommerce_set_user'] )
				){
					$wc_webhook->set_user_id( intval( $webhook['settings']['wpwhpro_woocommerce_set_user'] ) );
				}

				//Make sure we automatically prevent the webhook from firing twice due to the Woocommerce hook notation
				$webhook['settings']['wpwhpro_trigger_single_instance_execution'] = 1;
			} else {
				$webhook['settings'] = array(
					'wpwhpro_trigger_single_instance_execution' => 1,
				);
			}

			if( $is_valid ){

				//Maybe assign a default user ID of none hase been given
				if( ! $wc_webhook->get_user_id() ){
					$admin_id = $wc_helpers->get_first_admin_id();

					if( ! empty( $admin_id ) ){
						$wc_webhook->set_user_id( intval( $admin_id ) );
					}
				}

				$wc_webhook->set_api_version( $api_version );
				$payload = $wc_webhook->build_payload( $arg );

				//Append additional data
				if( ! empty( $post_id ) && is_array( $payload ) ){
					$payload['wpwh_meta_data'] = get_post_meta( $post_id );
					$payload['wpwh_tax_data'] = $wc_helpers->get_validated_taxonomies( $post_id );
				}

				//setup headers
				$headers	                                      = array();
				$headers['Content-Type']      		 = 'application/json';
				$headers['X-WC-Webhook-Source']      = home_url( '/' ); // Since 2.6.0.
				$headers['X-WC-Webhook-Topic']       = $wc_webhook->get_topic();
				$headers['X-WC-Webhook-Resource']    = $wc_webhook->get_resource();
				$headers['X-WC-Webhook-Event']       = $wc_webhook->get_event();
				$headers['X-WC-Webhook-Signature']   = $wc_webhook ->generate_signature( trim( wp_json_encode( $payload ) ) );
				$headers['X-WC-Webhook-ID']          = 0;
				$headers['X-WC-Webhook-Delivery-ID'] = 0;

				if( $webhook_url_name !== null ){
					$response_data_array[ $webhook_url_name ] = WPWHPRO()->webhook->post_to_webhook( $webhook, $payload, array( 'headers' => $headers ) );
					$payload_track[] = $payload;
				} else {
					$response_data_array[] = WPWHPRO()->webhook->post_to_webhook( $webhook, $payload, array( 'headers' => $headers ) );
				}
			}

		}

		do_action( 'wpwhpro/webhooks/trigger_wc_product_created', $payload, $response_data_array, $payload_track );
	}
	
	public function get_demo( $options = array() ) {

		$data = array (
			'id' => 8096,
			'name' => 'New demo product',
			'slug' => 'new-demo-product',
			'permalink' => 'https://yourdomain.test/product/new-demo-product/',
			'date_created' => '2021-12-28T06:39:17',
			'date_created_gmt' => '2021-12-28T06:39:17',
			'date_modified' => '2021-12-28T06:39:17',
			'date_modified_gmt' => '2021-12-28T06:39:17',
			'type' => 'simple',
			'status' => 'publish',
			'featured' => false,
			'catalog_visibility' => 'visible',
			'description' => '<p>This is a demo product description</p>
		  ',
			'short_description' => '<p>This is a short description</p>
		  ',
			'sku' => '',
			'price' => '5',
			'regular_price' => '10',
			'sale_price' => '5',
			'date_on_sale_from' => NULL,
			'date_on_sale_from_gmt' => NULL,
			'date_on_sale_to' => NULL,
			'date_on_sale_to_gmt' => NULL,
			'on_sale' => true,
			'purchasable' => true,
			'total_sales' => 0,
			'virtual' => true,
			'downloadable' => false,
			'downloads' => 
			array (
			),
			'download_limit' => -1,
			'download_expiry' => -1,
			'external_url' => '',
			'button_text' => '',
			'tax_status' => 'taxable',
			'tax_class' => '',
			'manage_stock' => false,
			'stock_quantity' => NULL,
			'in_stock' => true,
			'backorders' => 'no',
			'backorders_allowed' => false,
			'backordered' => false,
			'sold_individually' => false,
			'weight' => '',
			'dimensions' => 
			array (
			  'length' => '',
			  'width' => '',
			  'height' => '',
			),
			'shipping_required' => false,
			'shipping_taxable' => false,
			'shipping_class' => '',
			'shipping_class_id' => 0,
			'reviews_allowed' => true,
			'average_rating' => '0.00',
			'rating_count' => 0,
			'upsell_ids' => 
			array (
			),
			'cross_sell_ids' => 
			array (
			),
			'parent_id' => 0,
			'purchase_note' => '',
			'categories' => 
			array (
			  0 => 
			  array (
				'id' => 34,
				'name' => 'Uncategorized',
				'slug' => 'uncategorized',
			  ),
			),
			'tags' => 
			array (
			),
			'images' => 
			array (
			  0 => 
			  array (
				'id' => 0,
				'date_created' => '2021-12-28T06:39:17',
				'date_created_gmt' => '2021-12-28T06:39:17',
				'date_modified' => '2021-12-28T06:39:17',
				'date_modified_gmt' => '2021-12-28T06:39:17',
				'src' => 'https://yourdomain.test/wp-content/uploads/woocommerce-placeholder.png',
				'name' => 'Placeholder',
				'alt' => 'Placeholder',
				'position' => 0,
			  ),
			),
			'attributes' => 
			array (
			),
			'default_attributes' => 
			array (
			),
			'variations' => 
			array (
			),
			'grouped_products' => 
			array (
			),
			'menu_order' => 0,
			'price_html' => '<del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">&euro;</span>10.00</bdi></span></del> <ins><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">&euro;</span>5.00</bdi></span></ins>',
			'related_ids' => 
			array (
			  0 => 156,
			  1 => 659,
			  2 => 604,
			  3 => 658,
			  4 => 155,
			),
			'meta_data' => 
			array (
			  0 => 
			  array (
				'id' => 70958,
				'key' => 'wpwhpro_create_post_temp_status_jobs',
				'value' => 'draft',
			  ),
			),
			'_links' => 
			array (
			  'self' => 
			  array (
				0 => 
				array (
				  'href' => 'https://yourdomain.test/wp-json/wc/v2/products/8096',
				),
			  ),
			  'collection' => 
			  array (
				0 => 
				array (
				  'href' => 'https://yourdomain.test/wp-json/wc/v2/products',
				),
			  ),
			),
			'wpwh_meta_data' => 
			array (
				'_edit_lock' => 
				array (
				0 => '1641462455:1',
				),
				'_edit_last' => 
				array (
				0 => '1',
				),
				'total_sales' => 
				array (
				0 => '0',
				),
				'_tax_status' => 
				array (
				0 => 'taxable',
				),
				'_tax_class' => 
				array (
				0 => '',
				),
				'_manage_stock' => 
				array (
				0 => 'no',
				),
				'_backorders' => 
				array (
				0 => 'no',
				),
				'_sold_individually' => 
				array (
				0 => 'no',
				),
				'_virtual' => 
				array (
				0 => 'no',
				),
				'_downloadable' => 
				array (
				0 => 'no',
				),
				'_download_limit' => 
				array (
				0 => '-1',
				),
				'_download_expiry' => 
				array (
				0 => '-1',
				),
				'_stock' => 
				array (
				0 => NULL,
				),
				'_stock_status' => 
				array (
				0 => 'instock',
				),
				'_wc_average_rating' => 
				array (
				0 => '0',
				),
				'_wc_review_count' => 
				array (
				0 => '0',
				),
				'_product_version' => 
				array (
				0 => '6.0.0',
				),
			),
			'wpwh_tax_data' => 
			array (
				'product_cat' => 
				array (
				'demo-category' => 
				array (
					'term_id' => 79,
					'name' => 'Demo Category',
					'slug' => 'demo-category',
					'term_group' => 0,
					'term_taxonomy_id' => 79,
					'taxonomy' => 'product_cat',
					'description' => '',
					'parent' => 0,
					'count' => 0,
					'filter' => 'raw',
				),
				'demo-category-2' => 
				array (
					'term_id' => 80,
					'name' => 'Demo Category 2',
					'slug' => 'demo-category-2',
					'term_group' => 0,
					'term_taxonomy_id' => 80,
					'taxonomy' => 'product_cat',
					'description' => '',
					'parent' => 0,
					'count' => 0,
					'filter' => 'raw',
				),
				),
				'product_type' => 
				array (
				'simple' => 
				array (
					'term_id' => 21,
					'name' => 'simple',
					'slug' => 'simple',
					'term_group' => 0,
					'term_taxonomy_id' => 21,
					'taxonomy' => 'product_type',
					'description' => '',
					'parent' => 0,
					'count' => 5,
					'filter' => 'raw',
				),
				),
			),
		);

		return $data;
	}

  }

endif; // End if class_exists check.