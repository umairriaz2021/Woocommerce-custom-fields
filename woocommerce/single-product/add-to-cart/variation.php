<?php
/**
 * Single variation display
 *
 * This is a javascript-based template for single variations (see https://codex.wordpress.org/Javascript_Reference/wp.template).
 * The values will be dynamically replaced after selecting attributes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.5.0
 */

defined( 'ABSPATH' ) || exit;

?>
<script type="text/template" id="tmpl-variation-template">
	<div class="woocommerce-variation-description">{{{ data.variation.variation_description }}}</div>
	<div class="woocommerce-variation-price">{{{ data.variation.price_html }}}</div>
	<div class="woocommerce-variation-inside_dimension">{{{ data.variation.inside_dimension}}}</div>
	<div class="woocommerce-variation-board_grade">{{{ data.variation.board_grade}}}</div>
	<div class="woocommerce-variation-qty_per_bundle">{{{ data.variation.qty_per_bundle}}}</div>
	<div class="woocommerce-variation-qty_per_bale">{{{ data.variation.qty_per_bale}}}</div>
	<div class="woocommerce-variation-colour">{{{ data.variation.colour}}}</div>
	<div class="woocommerce-variation-availability">{{{ data.variation.availability_html }}}</div>
</script>
<script type="text/template" id="tmpl-unavailable-variation-template">
	<p><?php esc_html_e( 'Sorry, this product is unavailable. Please choose a different combination.', 'woocommerce' ); ?></p>
</script>
