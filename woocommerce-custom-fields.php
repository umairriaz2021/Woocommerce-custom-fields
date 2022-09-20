<?php
 /*
 Plugin Name: Woocommerce Custom Fields
 Plugin URI: https://www.pinease.com
 Description: Woocommerce Custom variation Fields set for all products
 Author Name: Pinease
 Author URI: https://www.pinease.com
 Version:1.0.0
 Text-domain: pinease
 */

 if(!defined('ABSPATH'))
 {
	 exit();
 }

if(!defined('PLUGIN_DIR'))
{
	define('PLUGIN_DIR',plugin_dir_path(__FILE__));
}
if(!defined('PLUGIN_URL'))
{
	define('PLUGIN_URL',plugins_url('/',__FILE__));
}

function pinease_register_activation_hook()
{
	 require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	 global $wpdb;
	 if(count($wpdb->get_var("SHOW TABLES LIKE 'wpa0_variant_products'")) == 0)
	 {
		 $sql = 'CREATE TABLE `wpa0_variant_products` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `product_id` int(11) DEFAULT NULL,
			  `part` varchar(100) DEFAULT NULL,
			  `inside_dimension` varchar(100) DEFAULT NULL,
			  `bord_grade` varchar(100) DEFAULT NULL,
			  `colour` varchar(100) DEFAULT NULL,
			  `qty_bundle` int(10) DEFAULT NULL,
			  `qty_bale` int(10) DEFAULT NULL,
			  `prices` text DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1';
		 
		 dbDelta($sql);
	 }
	
	//add menu page
	
}
register_activation_hook(__FILE__,'pinease_register_activation_hook');

function pinease_deactivation_hook()
{
	global $wpdb;
	$wpdb->query("DROP TABLE IF EXISTS wpa0_variant_products");
}
register_deactivation_hook(__FILE__,'pinease_deactivation_hook');

	add_action( 'admin_menu', 'pinease_add_submenu', 100 );
	function pinease_add_submenu()
	{
		add_submenu_page('edit.php?post_type=product', 'Variant Products','Variant Products', 'manage_woocommerce','variant-products','pinease_add_submenu_page');	
	}
	 
	function pinease_add_submenu_page()
	{
		include_once PLUGIN_DIR.'admin/views/product_variant.php';
	}


//variant products scripts
function pinease_admin_enqueue_scripts($slug)
{
	
	 if($slug === 'product_page_variant-products')
	 {
		 wp_enqueue_style('bootstrap','https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css',[],false,'all');
		 wp_enqueue_style('customcss',PLUGIN_URL.'assets/css/custom.css');
		 wp_enqueue_script('popperjs','https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js',['jquery'],false,true);
		 wp_enqueue_script('popperjs','https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js',['jquery'],false,true);
		 wp_enqueue_script('customjs',PLUGIN_URL.'assets/js/custom.js',['jquery'],false,true);
	 }
	elseif($slug === 'post-new.php' || $slug === 'post.php' )
	{
		wp_enqueue_style('customcss',PLUGIN_URL.'assets/css/custom.css');
	}
}
add_action('admin_enqueue_scripts','pinease_admin_enqueue_scripts');

function pinease_frontend_enqueue_scripts()
{
	 if(is_tax('product_cat'))
	 {
		
		 wp_enqueue_script('custom_js',PLUGIN_URL.'assets/js/custom.js',['jquery'],false,true);
		 wp_localize_script('custom_js',pineaseAjaxUrl,admin_url('admin-ajax.php'));
	 }
}
add_action('wp_enqueue_scripts','pinease_frontend_enqueue_scripts');

function pineaseUseAjax()
{
	include_once PLUGIN_DIR.'includes/ajax.php';
	wp_die();
}
add_action('wp_ajax_nopriv_library','pineaseUseAjax');
add_action('wp_ajax_library','pineaseUseAjax');


// // // 1. Add custom field input @ Product Data > Variations > Single Variation
// add_action( 'woocommerce_variation_options_pricing', 'bbloomer_add_custom_field_to_variations', 10, 3 );
 
// function bbloomer_add_custom_field_to_variations( $loop, $variation_data, $variation ) {
// echo "<div class='form-field'>";   
// woocommerce_wp_text_input( array(
// 'id' => 'inside_dimension[' . $loop . ']',
// 'class' => 'short',
// 'label' => __( 'Inside Dimension', 'woocommerce' ),
// 'wrapper_class' => 'form-field form-row form-row-first',
// 'value' => get_post_meta( $variation->ID, 'inside_dimension', true )
//    ) );
	
// 	 woocommerce_wp_text_input( array(
// 'id' => 'board_grade[' . $loop . ']',
// 'class' => 'short',
// 'label' => __( 'Board Grade', 'woocommerce' ),
// 'wrapper_class' => 'form-field form-row form-row-last',
// 'value' => get_post_meta( $variation->ID, 'board_grade', true )
//    ) );
// echo "</div>";
	
// echo "<div class='form-field'>";
// 	 woocommerce_wp_text_input( array(
// 'id' => 'qty_per_bundle[' . $loop . ']',
// 'class' => 'short',
// 'label' => __( 'QTY PER BUNDLE', 'woocommerce' ),
// 'wrapper_class' => 'form-field form-row form-row-first',
// 'value' => get_post_meta( $variation->ID, 'qty_per_bundle', true ),
// 'type' => 'number'
//    ) );	
	
// 	 woocommerce_wp_text_input( array(
// 'id' => 'qty_per_bale[' . $loop . ']',
// 'class' => 'short',
// 'label' => __( 'QTY PER BALE', 'woocommerce' ),
// 'wrapper_class' => 'form-field form-row form-row-last',
// 'value' => get_post_meta( $variation->ID, 'qty_per_bale', true ),
// 'type' => 'number'
//    ) );	
	
// echo "</div>";
	
	

// echo "<div class='form-field'>";
// 	 woocommerce_wp_text_input( array(
// 'id' => 'colour[' . $loop . ']',
// 'class' => 'short',
// 'label' => __( 'Colour', 'woocommerce' ),
// 'wrapper_class' => 'form-field form-row form-row-first',
// 'value' => get_post_meta( $variation->ID, 'colour', true )
//    ) );	
	
// echo "</div>";
// }
// // 2. Save custom field on product variation save
// add_action( 'woocommerce_save_product_variation', 'bbloomer_save_custom_field_variations', 10, 2 );
 
// function bbloomer_save_custom_field_variations( $variation_id, $i ) {
//    $custom_field = $_POST['inside_dimension'][$i];
// 	$custom_field1 = $_POST['board_grade'][$i];
// 	$custom_field3 = $_POST['qty_per_bundle'][$i];
// 	$custom_field4 = $_POST['qty_per_bale'][$i];
// 	$custom_field2 = $_POST['colour'][$i];
	
//    if ( isset( $custom_field ) ) update_post_meta( $variation_id, 'inside_dimension', esc_attr( $custom_field ) );
//     if ( isset( $custom_field1 ) ) update_post_meta( $variation_id, 'board_grade', esc_attr( $custom_field1 ) );
// 	if ( isset( $custom_field3 ) ) update_post_meta( $variation_id, 'qty_per_bundle', esc_attr( $custom_field3 ));
// 	if ( isset( $custom_field3 ) ) update_post_meta( $variation_id, 'qty_per_bale', esc_attr( $custom_field4 ));
// 	if ( isset( $custom_field2 ) ) update_post_meta( $variation_id, 'colour', esc_attr( $custom_field2 ));
	
// }

// add_filter( 'woocommerce_available_variation', 'bbloomer_add_custom_field_variation_data' );
 
// function bbloomer_add_custom_field_variation_data( $variations ) {
//    $variations['inside_dimension'] = '<div class="woocommerce_custom_field">Inside Dimension: <span>' . get_post_meta( $variations[ 'variation_id' ], 'inside_dimension', true ) . '</span></div>';
//    $variations['board_grade'] = '<div class="woocommerce_custom_field">Board Grade: <span>' . get_post_meta( $variations[ 'variation_id' ], 'board_grade', true ) . '</span></div>';
// 	$variations['qty_per_bundle'] = '<div class="woocommerce_custom_field">QTY PER BUNDLE: <span>' . get_post_meta( $variations[ 'variation_id' ], 'qty_per_bundle', true ) . '</span></div>';
//    $variations['qty_per_bale'] = '<div class="woocommerce_custom_field">QTY PER BUNDLE: <span>' . get_post_meta( $variations[ 'variation_id' ], 'qty_per_bale', true ) . '</span></div>';
//    $variations['colour'] = '<div class="woocommerce_custom_field">Colour: <span>' . get_post_meta( $variations[ 'variation_id' ], 'colour', true ) . '</span></div>';
   
// 	return $variations;
// }
//Create Custom Product Tab

// Creates the admin panel tab
// Add custom product setting tab
function filter_woocommerce_product_data_tabs( $default_tabs ) {
    $default_tabs['boxes'] = array(
        'label'     => __( 'Boxes', 'woocommerce' ),
        'target'    => 'my_custom_tab_data',
        'priority'  => 100,
        'class'     => array()
    );

    return $default_tabs;
}
add_filter( 'woocommerce_product_data_tabs', 'filter_woocommerce_product_data_tabs'); 

// Contents custom product setting tab
function action_woocommerce_product_data_panels() {
    // Note the 'id' attribute needs to match the 'target' parameter set above
    echo '<div id="my_custom_tab_data" class="panel">';

    // Add field
  echo "<div class='form-field'>";   
woocommerce_wp_text_input( array(
'id' => 'inside_dimension',
'class' => 'short',
'label' => __( 'Inside Dimension', 'woocommerce' ),
	'placeholder' => 'Inside Dimension',
'wrapper_class' => 'form-row colHalf form-row-first',
'value' => get_post_meta(get_the_ID(),'inside_dimension',true)
   ) );
	
	 woocommerce_wp_text_input( array(
'id' => 'board_grade',
'class' => 'short',
'label' => __( 'Board Grade', 'woocommerce' ),
'placeholder' => 'Board Grade',
'wrapper_class' => 'form-row colHalf form-row-last',
'value' => get_post_meta(get_the_ID(),'board_grade',true)

   ) );
echo "</div>";
 
echo "<div class='form-field'>";
	 woocommerce_wp_text_input( array(
'id' => 'qty_per_bundle',
'class' => 'short',
'label' => __( 'QTY PER BUNDLE', 'woocommerce' ),
'wrapper_class' => 'form-row colHalf form-row-first',
'placeholder' => 'QTY PER BUNDLE',		 
'type' => 'number',
'value' => get_post_meta(get_the_ID(),'qty_per_bundle',true)
   ) );	
	
	 woocommerce_wp_text_input( array(
'id' => 'qty_per_bale',
'class' => 'short',
'label' => __( 'QTY PER BALE', 'woocommerce' ),
'wrapper_class' => 'form-row colHalf form-row-last',
'placeholder' => 'QTY PER BALE',
'type' => 'number',
'value' => get_post_meta(get_the_ID(),'qty_per_bale',true)
   ) );	
	
echo "</div>";
	
echo "<div class='form-field'>";
	 woocommerce_wp_text_input( array(
'id' => 'price_1',
'class' => 'short',
'label' => __( 'Price 1', 'woocommerce' ),
'wrapper_class' => 'form-row colAll form-row-first',
'placeholder' => 'Price 1',		 
'type' => 'number',
'custom_attributes' => array(
                'step' => 'any'
            ),
'value' => get_post_meta(get_the_ID(),'price_1',true)
   ) );	
	
	 woocommerce_wp_text_input( array(
'id' => 'price_2',
'class' => 'short',
'label' => __( 'Price 2', 'woocommerce' ),
'wrapper_class' => 'form-row colAll form-row-last',
'placeholder' => 'Price 2',
'type' => 'number',
'custom_attributes' => array(
                'step' => 'any'
            ),
'value' => get_post_meta(get_the_ID(),'price_2',true)
   ) );	
	
	 woocommerce_wp_text_input( array(
'id' => 'price_3',
'class' => 'short',
'label' => __( 'Price 3', 'woocommerce' ),
'wrapper_class' => 'form-row colAll form-row-first',
'placeholder' => 'Price 3',
'type' => 'number',
'custom_attributes' => array(
                'step' => 'any'
            ),
'value' => get_post_meta(get_the_ID(),'price_3',true)
   ) );	
	
	 woocommerce_wp_text_input( array(
'id' => 'price_4',
'class' => 'short',
'label' => __( 'Price 4', 'woocommerce' ),
'wrapper_class' => 'form-row colAll form-row-last',
'placeholder' => 'Price 4',
'type' => 'number',
'custom_attributes' => array(
                'step' => 'any'
            ),
'value' => get_post_meta(get_the_ID(),'price_4',true)
   ) );
	
echo "</div>";
echo "<div class='form-field'>";   
woocommerce_wp_text_input( array(
'id' => 'price_5',
'class' => 'short',
'label' => __( 'Price 5', 'woocommerce' ),
	'placeholder' => 'Price 5',
'wrapper_class' => 'form-row colHalf form-row-first',
'custom_attributes' => array(
                'step' => 'any'
            ),
'value' => get_post_meta(get_the_ID(),'price_5',true)
   ) );
	
	 woocommerce_wp_text_input( array(
'id' => 'colour',
'class' => 'short',
'label' => __( 'Colour', 'woocommerce' ),
'placeholder' => 'Colour',
'wrapper_class' => 'form-row colHalf form-row-last',
'custom_attributes' => array(
                'step' => 'any'
            ),
'value' => get_post_meta(get_the_ID(),'colour',true)

   ) );
echo "</div>";		

	
echo "</div>";
////end Fields


    echo '</div>';
}
add_action( 'woocommerce_product_data_panels', 'action_woocommerce_product_data_panels');

function woocommerce_product_custom_fields_save($post_id)
{
    // Custom Product Text Field
    $inside_dimension = $_POST['inside_dimension'];
    if (!empty($inside_dimension))
        update_post_meta($post_id, 'inside_dimension', esc_attr($inside_dimension));
// Custom Product Number Field
    $board_grade = $_POST['board_grade'];
    if (!empty($board_grade))
        update_post_meta($post_id, 'board_grade', esc_attr($board_grade));
// Custom Product Textarea Field
	
    $qty_per_bundle = $_POST['qty_per_bundle'];
    if (!empty($qty_per_bundle))
        update_post_meta($post_id, 'qty_per_bundle', esc_html($qty_per_bundle));
	 $qty_per_bale = $_POST['qty_per_bale'];
    if (!empty($qty_per_bale))
        update_post_meta($post_id, 'qty_per_bale', esc_html($qty_per_bale));
	$price1 = $_POST['price_1'];
	if (!empty($price1))
        update_post_meta($post_id, 'price_1', esc_html($price1));
	$price2 = $_POST['price_2'];
	if (!empty($price2))
        update_post_meta($post_id, 'price_2', esc_html($price2));
	$price3 = $_POST['price_3'];
	if (!empty($price3))
        update_post_meta($post_id, 'price_3', esc_html($price3));
	$price4 = $_POST['price_4'];
	if(!empty($price4))
        update_post_meta($post_id, 'price_4', esc_html($price4));
	$price5 = $_POST['price_5'];
	if(!empty($price5))
        update_post_meta($post_id, 'price_5', esc_html($price5));
	$colour = $_POST['colour'];
	if (!empty($colour))
        update_post_meta($post_id, 'colour', esc_html($colour));
}

add_action('woocommerce_process_product_meta', 'woocommerce_product_custom_fields_save');