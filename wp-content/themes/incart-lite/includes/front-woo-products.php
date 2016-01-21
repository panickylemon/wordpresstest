<?php
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
global $incart_lite_shortname;

?>
<div id="woo-product-division-box" class="skt-section">
	<div class="container">
		<div class="row-fluid">
				<?php echo do_shortcode("[recent_products per_page='4' columns='4']"); ?>
		</div>
	</div>
</div>
<?php } ?>