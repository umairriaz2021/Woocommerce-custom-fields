<?php get_header(); ?>
<style>
.box_container {
    max-width: 100%;
    padding: 5% 5%;
}
.box_container h2 {
    color: #fff;
    font-size: 6rem;
    font-family: 'Montserrat';
    text-align: center;
    text-transform: uppercase;
    margin-bottom: 3%;
}
	.sideForm{
		padding:30px 0;
	}
.sideForm input[type="radio"] {
  opacity: 0;
  position: fixed;
  width: 0;
}
.sideForm label {
    display: inline-block;
    padding: 0 60px;
    border: 1px solid;
    border-color: #005c98;
    height: 40px;
    line-height: 38px;
    margin-right: 30px;
    border-radius: 8px;
    color: #005c98;
    font-weight: 600;
    text-transform: uppercase;
	cursor:pointer;
}
.sideForm input[type="radio"]:checked + label {
    background: #005c98;
    border-color: #005c98;
	color: #fff;
}
.sideForm .radio-toolbar input[type="radio"]:focus + label {
/*     border: 2px dashed #444; */
	 color: #005c98;
}
.sideForm label:hover {
      color: #fff;
    background: #005c98;
}
	.ptoduct-categories {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-around;
}
	.ptoduct-categories .upper_header {
    text-align: left;
	}
	.ptoduct-categories .selectCat label{
		margin:10px 10px;
	}
	.ptoduct-categories .selectCat {
    text-align: left;
    width: 60%;
}

.upper_header .sideForm input[type="radio"]:checked + label {
    background: #e4d224;
    border-color: #005c98;
    color: #000;
}
.upper_header .sideForm label:hover {
       color: #000;
   background: #e4d224;
}	
	.upper_header a i {
    font-size: 20px;
    margin-left: 10px;
}
	tbody#productData tr td:last-child {
    text-align: left;
}
	.remove_cart{
	padding: 0 30px;
    height: 30px;
    line-height: 28px;
/*     border-color: #1376BC; */
    background: #dc3545;
    color: #fff;
	}
</style>
<?php 
function getCartIds($id)
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
global $wpdb;

$tax_ids = $wpdb->get_results("SELECT term_taxonomy_id from wpa0_term_taxonomy where taxonomy = 'product_cat' AND parent = '41' ");
$childrens = [];
$children_ids = [];
if(sizeof($tax_ids) > 0)
{
	foreach($tax_ids as $key => $id)
	{
		  $id = $id->term_taxonomy_id;
		   array_push($childrens, get_term($id));
		  //$children = $wpdb->get_results("SELECT * wpa0_terms where term_id = $id");
		  
		  array_push($children_ids,get_term($id)->term_id);
	}
}
$data = $wpdb->get_results("SELECT object_id from wpa0_term_relationships where term_taxonomy_id = 41 ORDER BY `object_id` DESC");
$products = [];
if(sizeof($data) > 0 )
{
	foreach($data as $key => $ids)
	{
		array_push($products,get_post($ids->object_id)); 
	}
}


?>
<div class="box_container">

	
	<h2 class="text-outline">
	<?php echo get_queried_object()->name; ?>
</h2>
	<div class="ptoduct-categories">
<div class="upper_header">
	
			
<a class="product-cat active">All Categories <i class="fas fa-solid fa-sort-down"></i></a>
<?php if(get_queried_object()->term_id == 41): ?>
<div class="sideForm">
 
	 
	 <input type="radio" id="parent_cat" name="cat" data-id="<?= get_queried_object()->term_id; ?>" value="<?= strtolower(get_queried_object()->name); ?>">
    <label for="parent_cat"><?= get_queried_object()->name; ?></label>
	

	</div>
	</div>
<?php endif; ?>
	
<div class="sideForm selectCat">
 
	 <?php if(sizeof($childrens) > 0 ): foreach($childrens as $key => $term): ?>
	 
	 <input type="radio" id="<?= 'boxes_'.($key+1); ?>" name="boxes" data-id="<?= $term->term_id; ?>" value="<?= strtolower($term->name); ?>">
    <label for="<?= 'boxes_'.($key+1); ?>"><?= $term->name; ?></label>
	
 <?php endforeach; endif; ?>
	</div>

<!-- <a class="product-cat" href="#">4 Inch</a>
<a class="product-cat" href="#">5 Inch</a>
<a class="product-cat" href="#">6 Inch</a>
<a class="product-cat" href="#">7 Inch</a> -->
</div>
<table class="products-list">
<thead>
<tr>
<th rowspan="2" class="part-no" scope="col">Part#</th>
<th rowspan="2" class="box-size" scope="col">Inside Dimension
LxWxH</th>
<th rowspan="2" class="grade" scope="col">Bord Grade</th>
<th rowspan="2" class="colour" scope="col">Colour</th>
<th rowspan="2" class="qty-bundle" scope="col">Qty Per
Bundle</th>
<!-- <th rowspan="2" class="qty-bale" scope="col">Qty Per
Case</th> -->
<th colspan="4" style="border:2px solid #ccc;">Prices per Box</th>

<th rowspan="2" class="add-cart">Add to Cart</th>
</tr>
<tr>
<th class="price" scope="col" style="border-left:2px solid #cecece;">50</th>
<th class="price" scope="col" style="border-right:2px solid #cecece;">200</th>
<th class="price" scope="col">500</th>
<th class="price" scope="col" style="border-right:2px solid #cecece;">1000</th>
</tr>
</thead>
<tbody id="productData">
<?php   if(count($products) > 0): foreach($products as $key => $product): ?>
<tr>
<td class="part-no" data-label="Part#"><a href="#" target="_blank" rel="noopener"><?= $product->post_title; ?></a></td>
<td class="box-size" data-label="Inside Dimension LxWxH"><?= get_post_meta($product->ID,'inside_dimension',true); ?></td>
<td data-label="Bord Grade"><?=  get_post_meta($product->ID,'board_grade',true); ?></td>
<td data-label="Colour"><?=  get_post_meta($product->ID,'colour',true); ?></td>
<td data-label="Qty Per Bundle"><?=  get_post_meta($product->ID,'qty_per_bundle',true); ?></td>
<!-- <td data-label="Qty Per Bale"><?php  /*get_post_meta($product->ID,'qty_per_bale',true);*/ ?></td> -->
<td data-label="50" style="border-left:2px solid #cecece;"><span class="q-price" ><?=  get_post_meta($product->ID,'price_1',true); ?></span></td>
<td data-label="200" style="border-right:2px solid #cecece;"><span class="q-price"><?=  get_post_meta($product->ID,'price_2',true); ?></span></td>
<td data-label="500"><span class="q-price"><?=  get_post_meta($product->ID,'price_3',true); ?></span></td>
<td data-label="1000" style="border-right:2px solid #cecece;"><span class="q-price"><?=  get_post_meta($product->ID,'price_4',true); ?></span></td>
<td data-label="Add To Cart"><input id="quantity" class="qty" min="1" name="quantity" type="number" value="<?= getCartIds($product->ID); ?>" /><button class=" <?php echo (getCartIds( $product->ID )) ? 'remove_cart' : 'table-add-cart'; ?>" data-id="<?=  $product->ID; ?>"><?php echo (!getCartIds( $product->ID )) ? 'Add' : 'Remove'; ?></button><span class="showPreloader"></span></td>
</tr>
<?php endforeach; endif; ?>	
<!-- <tr>
<td class="part-no" data-label="Part#"><a href="https://websitedesignincanada.ca/boxfinder/product/w100404/" target="_blank" rel="noopener">W100405</a></td>
<td class="box-size" data-label="Inside Dimension LxWxH">10 x 4 x 4</td>
<td data-label="Bord Grade">32C</td>
<td data-label="Colour">Kraft</td>
<td data-label="Qty Per Bundle">25</td>
<td data-label="Qty Per Bale">1875</td>
<td data-label="1" style="border-left:2px solid #cecece;"><span class="q-price" >.51</span></td>
<td data-label="125" style="border-right:2px solid #cecece;"><span class="q-price">.51</span></td>
<td data-label="250"><span class="q-price">.51</span></td>
<td data-label="500"><span class="q-price">.51</span></td>
<td data-label="750" style="border-right:2px solid #cecece;"><span class="q-price">.51</span></td>
<td data-label="Add To Cart"><input id="quantity" min="1" name="quantity" type="number" value="25" /><button class="table-add-cart" data-id="999">Add</button></td>
</tr> -->
<!-- <tr>
<td class="part-no" data-label="Part#"><a href="https://websitedesignincanada.ca/boxfinder/product/w100406/" target="_blank" rel="noopener">W100406</a></td>
<td class="box-size" data-label="Inside Dimension LxWxH">10 x 4 x 4</td>
<td data-label="Bord Grade">32C</td>
<td data-label="Colour">Kraft</td>
<td data-label="Qty Per Bundle">25</td>
<td data-label="Qty Per Bale">1875</td>
<td data-label="1" style="border-left:2px solid #cecece;"><span class="q-price">.51</span></td>
<td data-label="125" style="border-right:2px solid #cecece;"><span class="q-price">.51</span></td>
<td data-label="250"><span class="q-price">.51</span></td>
<td data-label="500"><span class="q-price">.51</span></td>
<td data-label="750" style="border-right:2px solid #cecece;"><span class="q-price">.51</span></td>
<td data-label="Add To Cart"><input id="quantity" min="1" name="quantity" type="number" value="25" /><button class="table-add-cart" data-id="1001">Add</button></td>
</tr> -->
<!-- <tr>
<td class="part-no" data-label="Part#"><a href="https://websitedesignincanada.ca/boxfinder/product/w100407/" target="_blank" rel="noopener">W100407</a></td>
<td class="box-size" data-label="Inside Dimension LxWxH">10 x 4 x 4</td>
<td data-label="Bord Grade">32C</td>
<td data-label="Colour">Kraft</td>
<td data-label="Qty Per Bundle">25</td>
<td data-label="Qty Per Bale">1875</td>
<td data-label="1" style="border-left:2px solid #cecece;"><span class="q-price">.51</span></td>
<td data-label="125" style="border-right:2px solid #cecece;"><span class="q-price">.51</span></td>
<td data-label="250"><span class="q-price">.51</span></td>
<td data-label="500"><span class="q-price">.51</span></td>
<td data-label="750" style="border-right:2px solid #cecece;"><span class="q-price">.51</span></td>
<td data-label="Add To Cart"><input id="quantity" min="1" name="quantity" type="number" value="25" /><button class="table-add-cart" data-id="1002">Add</button></td>
</tr> -->
<!-- <tr>
<td class="part-no" data-label="Part#"><a href="https://websitedesignincanada.ca/boxfinder/product/w100408/" target="_blank" rel="noopener">W100408</a></td>
<td class="box-size" data-label="Inside Dimension LxWxH">10 x 4 x 4</td>
<td data-label="Bord Grade">32C</td>
<td data-label="Colour">Kraft</td>
<td data-label="Qty Per Bundle">25</td>
<td data-label="Qty Per Bale">1875</td>
<td data-label="1" style="border-left:2px solid #cecece;"><span class="q-price">.51</span></td>
<td data-label="125" style="border-right:2px solid #cecece;"><span class="q-price">.51</span></td>
<td data-label="250"><span class="q-price">.51</span></td>
<td data-label="500"><span class="q-price">.51</span></td>
<td data-label="750" style="border-right:2px solid #cecece;"><span class="q-price">.51</span></td>
<td data-label="Add To Cart"><input id="quantity" min="1" name="quantity" type="number" value="25" /><button class="table-add-cart" data-id="1003">Add</button></td>
</tr> -->
<!-- <tr>
<td class="part-no" data-label="Part#"><a href="https://websitedesignincanada.ca/boxfinder/product/w100409/" target="_blank" rel="noopener">W100409</a></td>
<td class="box-size" data-label="Inside Dimension LxWxH">10 x 4 x 4</td>
<td data-label="Bord Grade">32C</td>
<td data-label="Colour">Kraft</td>
<td data-label="Qty Per Bundle">25</td>
<td data-label="Qty Per Bale">1875</td>
<td data-label="1" style="border-left:2px solid #cecece;"><span class="q-price">.51</span></td>
<td data-label="125" style="border-right:2px solid #cecece;"><span class="q-price">.51</span></td>
<td data-label="250"><span class="q-price">.51</span></td>
<td data-label="500"><span class="q-price">.51</span></td>
<td data-label="750" style="border-right:2px solid #cecece;"><span class="q-price">.51</span></td>
<td data-label="Add To Cart"><input id="quantity" min="1" name="quantity" type="number" value="25" /><button class="table-add-cart" data-id="1004">Add</button></td>
</tr> -->
<!-- <tr>
<td class="part-no" data-label="Part#"><a href="https://websitedesignincanada.ca/boxfinder/product/w100410/" target="_blank" rel="noopener">W100410</a></td>
<td class="box-size" data-label="Inside Dimension LxWxH">10 x 4 x 4</td>
<td data-label="Bord Grade">32C</td>
<td data-label="Colour">Kraft</td>
<td data-label="Qty Per Bundle">25</td>
<td data-label="Qty Per Bale">1875</td>
<td data-label="1" style="border-left:2px solid #cecece;"><span class="q-price">.51</span></td>
<td data-label="125" style="border-right:2px solid #cecece;"><span class="q-price">.51</span></td>
<td data-label="250"><span class="q-price">.51</span></td>
<td data-label="500"><span class="q-price">.51</span></td>
<td data-label="750" style="border-right:2px solid #cecece;"><span class="q-price">.51</span></td>
<td data-label="Add To Cart"><input id="quantity" min="1" name="quantity" type="number" value="25" /><button class="table-add-cart" data-id="1005">Add</button></td>
</tr> -->
<!-- <tr>
<td class="part-no" data-label="Part#"><a href="https://websitedesignincanada.ca/boxfinder/product/w100411/" target="_blank" rel="noopener">W100411</a></td>
<td class="box-size" data-label="Inside Dimension LxWxH">10 x 4 x 4</td>
<td data-label="Bord Grade">32C</td>
<td data-label="Colour">Kraft</td>
<td data-label="Qty Per Bundle">25</td>
<td data-label="Qty Per Bale">1875</td>
<td data-label="1" style="border-left:2px solid #cecece;"><span class="q-price">.51</span></td>
<td data-label="125" style="border-right:2px solid #cecece;"><span class="q-price">.51</span></td>
<td data-label="250"><span class="q-price">.51</span></td>
<td data-label="500"><span class="q-price">.51</span></td>
<td data-label="750" style="border-right:2px solid #cecece;"><span class="q-price">.51</span></td>
<td data-label="Add To Cart"><input id="quantity" min="1" name="quantity" type="number" value="25" /><button class="table-add-cart" data-id="1006">Add</button></td>
</tr> -->
<!-- <tr>
<td class="part-no" data-label="Part#"><a href="https://websitedesignincanada.ca/boxfinder/product/w100412/" target="_blank" rel="noopener">W100412</a></td>
<td class="box-size" data-label="Inside Dimension LxWxH">10 x 4 x 4</td>
<td data-label="Bord Grade">32C</td>
<td data-label="Colour">Kraft</td>
<td data-label="Qty Per Bundle">25</td>
<td data-label="Qty Per Bale">1875</td>
<td data-label="1" style="border-left:2px solid #cecece;"><span class="q-price">.51</span></td>
<td data-label="125" style="border-right:2px solid #cecece;"><span class="q-price">.51</span></td>
<td data-label="250"><span class="q-price">.51</span></td>
<td data-label="500"><span class="q-price">.51</span></td>
<td data-label="750" style="border-right:2px solid #cecece;"><span class="q-price">.51</span></td>
<td data-label="Add To Cart"><input id="quantity" min="1" name="quantity" type="number" value="25" /><button class="table-add-cart" data-id="1008">Add</button></td>
</tr> -->
</tbody>
</table>
</div>

<?php get_footer(); ?>