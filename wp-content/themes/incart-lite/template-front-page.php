<?php
	get_header(); 
?>
<?php global $incart_lite_shortname; ?>

<!-- FEATURED BOX -->
<?php get_template_part( 'includes/front', 'mid-box' ); ?>	

<!-- PARALLAX BOX -->
<?php get_template_part( 'includes/front', 'parallax-section' ); ?>	

<!-- PRODUCTS BOX -->
<?php get_template_part( 'includes/front', 'woo-products' ); ?>	

<?php if(have_posts()) : ?>
	<?php while(have_posts()) : the_post(); ?>
		<div id="front-content-box" >
			<div class="container">
				<?php the_content(); ?>
			</div>
		</div>
	<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>