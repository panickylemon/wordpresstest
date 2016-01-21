<?php 
/**
 * The Template for displaying all single posts.
 */

get_header(); ?>

<?php global $incart_lite_shortname; ?>
<div class="main-wrapper-item">
<?php if(have_posts()) : ?>
<?php while(have_posts()) : the_post(); ?>
	<div class="bread-title-holder">
		<div class="bread-title-bg-image full-bg-breadimage-fixed"></div>
		<div class="container">
			<div class="row-fluid">
				<div class="container_inner clearfix">
					<h1 class="title"><?php the_title(); ?></h1>
					<?php
						if ((class_exists('incart_breadcrumb_class'))) { $incart_breadcumb->custom_breadcrumb(); }
					?>
				</div>
			</div>
		</div>
	</div>

<div class="container post-wrap">
	<div class="row-fluid">
		<div id="container" class="span8">
			<div id="content">  
					<div class="post" id="post-<?php the_ID(); ?>">
						
						<?php if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it. ?>
						<div class="featured-image-shadow-box">
							<?php the_post_thumbnail('full'); ?>
						</div>
						<?php } ?>

						<div class="bread-title">
							<h1 class="title">
								<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
							</h1>
							<div class="clearfix"></div>
						</div>

						<div class="skepost-meta clearfix">
							<span class="date"><?php _e('On','incart-lite');?> <?php the_time('F j, Y') ?></span><?php _e(',','incart-lite');?>
							<span class="author-name"><?php _e('Posted by ','incart-lite'); the_author_posts_link(); ?> </span><?php _e(',','incart-lite');?>
							<?php if (has_category()) { ?><span class="category"><?php _e('In ','incart-lite');?><?php the_category(','); ?></span><?php _e(',','incart-lite');?><?php } ?>
							<?php the_tags('<span class="tags">By ',',','</span> ,'); ?>
							<span class="comments"><?php _e('With ','incart-lite');?><?php comments_popup_link(__('No Comments ','incart-lite'), __('1 Comment ','incart-lite'), __('% Comments ','incart-lite')) ; ?></span>
						</div>
						<!-- skepost-meta -->

						<div class="skepost">
							<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'incart-lite' ) ); ?>
							<?php wp_link_pages(__('<p><strong>Pages:</strong> ','incart-lite'), '</p>', __('number','incart-lite')); ?>
						</div>
						<!-- skepost -->

						<div class="navigation"> 
							<span class="nav-previous"><?php previous_post_link( __('&larr; %link','incart-lite')); ?></span>
							<span class="nav-next"><?php next_post_link( __('%link &rarr;','incart-lite')); ?></span> 
						</div>
						<div class="clearfix"></div>
						<div class="comments-template">
							<?php comments_template( '', true ); ?>
						</div>
					</div>
				<!-- post -->
				<?php endwhile; ?>
				<?php else :  ?>

				<div class="post">
					<h2><?php _e('Not Found','incart-lite'); ?></h2>
				</div>
				<?php endif; ?>
			</div><!-- content --> 
		</div><!-- container --> 

		<!-- Sidebar -->
		<div id="sidebar" class="span3">
			<?php get_sidebar(); ?>
		</div>
		<!-- Sidebar --> 

	</div>
 </div>
</div>
<?php get_footer(); ?>