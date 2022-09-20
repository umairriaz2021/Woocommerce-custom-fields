<?php
function getCartId($id)
{
	if(!WC()->cart->is_empty())
	{
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			if($cart_item['product_id'] == $id)
			{
				$qty = $cart_item['quantity'];
			}
			
			}
	}
	return $qty;
}
if($_POST['param'] === 'add-to-cart')
{

 if(empty($_POST['quantity']))
 {
	 
	echo wp_send_json(['status'=>401,'qty'=>$_POST['quantity']]);
	
 }
else{
$product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
$quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);	
$passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);

	//$product_status = get_post_status($product_id);
	
if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity)) {
	
                do_action('woocommerce_ajax_added_to_cart', $product_id);

                if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
                    wc_add_to_cart_message(array($product_id => $quantity), true);
                
				}
				
				$data = ['status'=>200,'cart_url'=>wc_get_cart_url()];	
                //WC_AJAX::get_refreshed_fragments();
                echo wp_send_json($data);
				
            } else {

                $data = array(
					'status' => 400,
                    'error' => true,
                    'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id));

                echo wp_send_json($data);
         }
}


}

if($_POST['param'] === 'get_cat_products')
{
	
	
	$cat_id = absint($_POST['cat_id']);
 
	$args = [
    'post_type' => 'product',
    'tax_query' => [
        [
            'taxonomy' => 'product_cat',
            'terms' => $cat_id,
            'include_children' => false // Remove if you need posts from term 7 child terms
        ],
    ],
    // Rest of your arguments
];
	$products = get_posts($args);
	$output = '';
	if(count($products) > 0)
	{
		foreach($products as $key => $product)
		{
			 $class = (getCartId( $product->ID )) ? 'remove_cart' : 'table-add-cart';
			 $btn_name = (!getCartId( $product->ID )) ? 'Add' : 'Remove';
			 $output .= '<tr>';
			 $output .= '<td class="part-no" data-label="Part#"><a href="#" target="_blank" rel="noopener">'.$product->post_title.'</a></td>';
			 $output .= '<td class="box-size" data-label="Inside Dimension LxWxH">'.get_post_meta($product->ID,'inside_dimension',true).'</td>';
			 $output .= '<td data-label="Bord Grade">'.get_post_meta($product->ID,'board_grade',true).'</td>';
			 $output .= '<td data-label="Colour">'.get_post_meta($product->ID,'colour',true).'</td>';
			 $output .= '<td data-label="Qty Per Bundle">'.get_post_meta($product->ID,'qty_per_bundle',true).'</td>';
// 			 $output .= '<td data-label="Qty Per Bale">'.get_post_meta($product->ID,'qty_per_bale',true).'</td>';
			 $output .= '<td data-label="50" style="border-left:2px solid #cecece;"><span class="q-price" >'.get_post_meta($product->ID,'price_1',true).'</span></td>';
			 $output .= '<td data-label="200" style="border-right:2px solid #cecece;"><span class="q-price">'.get_post_meta($product->ID,'price_2',true).'</span></td>';
			 $output .= '<td data-label="500"><span class="q-price">'.get_post_meta($product->ID,'price_3',true).'</span></td>';
			 $output .= '<td data-label="1000" style="border-right:2px solid #cecece;"><span class="q-price">'.get_post_meta($product->ID,'price_4',true).'</span></td>';
			 $output .= '<td data-label="Add To Cart"><input id="quantity" class="qty" min="1" name="quantity" type="number" value="'.getCartId($product->ID).'" /><button class="'.$class.'" data-id="'.$product->ID.'">'.$btn_name.'</button></td>';
			 $output .= '</tr>';
		}
	}
	
	echo wp_send_json(['status'=>200,'output'=>$output]);
	
}

if($_POST['param'] === 'get_cat_by_parent_id')
{
	global $wpdb;
	$cat_id = absint($_POST['cat_id']);
	
	$data = $wpdb->get_results("SELECT object_id from wpa0_term_relationships where term_taxonomy_id = $cat_id ORDER BY `object_id` DESC");
		$products = [];
		if(sizeof($data) > 0 )
		{
			foreach($data as $key => $ids)
			{
				array_push($products,get_post($ids->object_id)); 
			}
		}
	
	$output = '';
	if(count($products) > 0)
	{
		foreach($products as $key => $product)
		{
			 $class = (getCartId( $product->ID )) ? 'remove_cart' : 'table-add-cart';
			 $btn_name = (!getCartId( $product->ID )) ? 'Add' : 'Remove';
			 $output .= '<tr>';
			 $output .= '<td class="part-no" data-label="Part#"><a href="#" target="_blank" rel="noopener">'.$product->post_title.'</a></td>';
			 $output .= '<td class="box-size" data-label="Inside Dimension LxWxH">'.get_post_meta($product->ID,'inside_dimension',true).'</td>';
			 $output .= '<td data-label="Bord Grade">'.get_post_meta($product->ID,'board_grade',true).'</td>';
			 $output .= '<td data-label="Colour">'.get_post_meta($product->ID,'colour',true).'</td>';
			 $output .= '<td data-label="Qty Per Bundle">'.get_post_meta($product->ID,'qty_per_bundle',true).'</td>';
// 			 $output .= '<td data-label="Qty Per Bale">'.get_post_meta($product->ID,'qty_per_bale',true).'</td>';
			 $output .= '<td data-label="50" style="border-left:2px solid #cecece;"><span class="q-price" >'.get_post_meta($product->ID,'price_1',true).'</span></td>';
			 $output .= '<td data-label="200" style="border-right:2px solid #cecece;"><span class="q-price">'.get_post_meta($product->ID,'price_2',true).'</span></td>';
			 $output .= '<td data-label="500"><span class="q-price">'.get_post_meta($product->ID,'price_3',true).'</span></td>';
			 $output .= '<td data-label="1000" style="border-right:2px solid #cecece;"><span class="q-price">'.get_post_meta($product->ID,'price_4',true).'</span></td>';
			 $output .= '<td data-label="Add To Cart"><input id="quantity" class="qty" min="1" name="quantity" type="number" value="'.getCartId($product->ID).'" /><button class="'.$class.'" data-id="'.$product->ID.'">'.$btn_name.'</button></td>';
			 $output .= '</tr>';
		}
	}
	
	echo wp_send_json(['status'=>200,'output'=>$output]);
	
}
 
if($_POST['param'] === 'remove_cart_item')
{
	$product_id = absint($_POST['id']);

	if(!WC()->cart->is_empty())
	{
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			if($cart_item['product_id'] == $product_id)
			{
				$check = WC()->cart->remove_cart_item($cart_item_key);
			}
			
			}
	}
	if($check)
	{
		echo wp_send_json(['status'=>200,'message'=>$check]);
	}
	else{
		echo wp_send_json(['status'=>400,'message'=>'error']);
	}
	
}