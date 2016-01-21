<?php 
/**
 * The template for displaying Error 404 page.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 */

get_header(); ?>
<?php global $incart_lite_shortname; ?>

<div class="page-content">
	<div class="container" id="error-404">
		<div class="row-fluid">
			<div id="content" class="span12">
				<div class="post">
					<div class="skepost _404-page">
						<div class="error-txt-first"><?php _e( 'OOPS !!!', 'incart-lite' ); ?></div>
						<div class="error-txt"><?php _e( '404', 'incart-lite' ); ?></div>
						<p><?php _e( 'Sorry, but the requested resource was not found on this site. Please try again or contact the administrator for assistance.', 'incart-lite' ); ?></p>
						<?php get_search_form(); ?>
					</div>
					<!-- post --> 
				</div>
				<!-- post -->
			</div>
			<!-- content --> 
		</div>
	</div>
</div>
<?php get_footer(); ?>