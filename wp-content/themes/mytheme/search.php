<?php get_header(); ?>

        <div class="content pull-left">
        	
        	<h2>Вы искали "<?php the_search_query(); ?>"</h2>
        	<form role="search" method="get" id="searchform" class="form-search" action="http://2videos.ru/">
				<div class="input-append">
					<input type="text" value="" name="s" id="s" class="search-query" placeholder="Попробовать еще раз" />
					<button type="submit" class="btn">Искать</button>
				</div>
			</form>
			
			<hr />
        	
        	<?php if (have_posts()) : ?>
        		<h2>Результаты поиска: </h2>
  			<?php while (have_posts()) : the_post(); ?>
        	
        	<div class="post clearfix">
        		<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> <span><i class="icon-comment"></i> <?php comments_popup_link('0', '1', '%'); ?></span></h1>
        		<div class="image">
	        		<?php 
						if ( function_exists( 'add_theme_support' ) )
					 	the_post_thumbnail( array(250,9999), array('class' => 'img-polaroid') ); 
					?>
				</div>
        		<div class="text">
        			
        			<?php the_excerpt(); ?>
        			
        			<a href="<?php the_permalink(); ?>" class="btn btn-success">Читать полностью</a>
        		</div>
        	</div>
        	
        	<hr />
        	
        	<?php endwhile; /* rewind or continue if all posts have been fetched */ ?>
			<?php else : ?>
				<div class="alert alert-error">Поиск не дал результатов. Попробуйте ввести другую поисковую фразу!</div>
			<?php endif; ?>
        	
        </div>
        
<?php get_sidebar(); ?>
<?php get_footer(); ?>