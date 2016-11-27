<?php get_header(); ?>
        
        <div class="content pull-left">
        	
        	<ul class="breadcrumb">
		       <?php the_breadcrumb(); ?>
	        </ul>
        	
        	<?php if (have_posts()) : ?>
  			<?php while (have_posts()) : the_post(); ?>
  				
        	<div class="post">
        		<h1><?php the_title(); ?></h1>
        		<div class="text">
        			
        			<?php the_content(); ?>
        				
        				<?php
							$posttags = get_the_tags();
							if ($posttags) { 
						?>
						<span class="label label-warning">Метки записи</span>
        				<div class="meta"><i class="icon-tags"></i>
						<?php foreach($posttags as $tag) {
							    $tag_links[] = '<a href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a>';
							    }
							     echo join( ', ', $tag_links );
								 echo "</div>";
							}
						?>
        			
        		</div>
        		
        		<hr />
        		
        		<?php comments_template(); ?>
        		
        	</div>
        	
        	<?php endwhile; /* rewind or continue if all posts have been fetched */ ?>
		  	<?php else : ?>
		  	<?php endif; ?>
        	
        	<hr />
        	
        </div>
        
        <?php get_sidebar(); ?>
		<?php get_footer(); ?>