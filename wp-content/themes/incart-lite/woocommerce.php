<?php 
/**
* The template for displaying woocommerce pages.
*
* This is the template that displays all pages by default.
* Please note that this is the WordPress construct of pages and that other
* 'pages' on your WordPress site will use a different template.
*
*/
get_header(); 
?>
<?php
//change to 4 columsn per row when using sidebar
if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 3; // 3 products per row
	}
}
?>

<?php global $incart_lite_shortname; ?>

<div class="main-wrapper-item"> 

		<div class="bread-title-holder">
			<div class="bread-title-bg-image full-bg-breadimage-fixed"></div>
			<div class="container">
				<div class="row-fluid">
					<div class="container_inner clearfix">
						<h1 class="title"><?php if(class_exists( 'Woocommerce' ) && is_woocommerce() ) { woocommerce_page_title(); } ?></h1>
						<?php
							if ((function_exists('woocommerce_breadcrumb'))) {
								$args = array(
										'delimiter'  =>  '<span class="skt-breadcrumbs-separator"> / </span>',
										'wrap_before'  => '<section class="cont_nav"><div class="cont_nav_inner"><p>',
										'wrap_after' => '</p></div></section>',
										'before'   => '&nbsp;',
										'after'   => '&nbsp;'
									);
								woocommerce_breadcrumb($args);
							}
						 ?>
					</div>
				</div>
			</div>
		</div>	
	
	<div class="page-content woo-three-col default-pagetemp shop-template">
	
		<div class="container post-wrap">
			<div class="row-fluid">
				<div id="content" class="span8">
						<?php woocommerce_content(); ?>
				</div><!--/span8-->
							
				<div id="sidebar" class="span3">
					<?php get_sidebar('shoppage'); ?>
				</div><!--/span3--><div class="clearfix"></div>
							
			</div><!-- row-fluid -->
		</div><!-- container post-wrap -->
		
	</div><!-- page-content -->
</div><!-- main-wrapper-item -->
<?php get_footer(); ?>