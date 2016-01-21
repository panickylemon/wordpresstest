<?php
/**
* The template for displaying the footer.
*
* Contains footer content and the closing of the
* #main and #page div elements.
*
*/
global $incart_lite_shortname;
?>
	<div class="clearfix"></div>
</div>
<!-- #main --> 

<!-- #footer -->
<div id="footer" class="skt-section">
	<div class="container">
		<div class="row-fluid">
			<div class="second_wrapper">
				<?php dynamic_sidebar( 'Footer Sidebar' ); ?>
				<div class="clearfix"></div>
			</div><!-- second_wrapper -->
		</div>
	</div>

	<div class="third_wrapper">
		<div class="container">
			<div class="row-fluid">
				<?php $sktURL = 'http://www.sketchthemes.com/'; ?>
				<div class="copyright span6 alpha omega"> <?php echo stripslashes(sketch_get_option($incart_lite_shortname."_copyright")); ?></div>
				<div class="owner span6 alpha omega"><?php _e('Incart by ','incart-lite'); ?><a href="<?php echo $sktURL; ?>" title="Sketch Themes"><?php _e('SketchThemes','incart-lite'); ?></a></div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div><!-- third_wrapper --> 
</div>
<!-- #footer -->

</div>
<!-- #wrapper -->
	<a href="JavaScript:void(0);" title="Back To Top" id="backtop"></a>
	<?php wp_footer(); ?>
	
</body>
</html>