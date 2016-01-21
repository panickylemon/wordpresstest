<div id="full-division-box" class="skt-section">
	<div class="container full-content-box" >
		<div class="row-fluid">
			<div class="span12">
				<?php if(sketch_get_option($incart_lite_shortname.'_para_content_left')){ $_para_content_left = sketch_get_option($incart_lite_shortname.'_para_content_left'); } ?>
				<?php if(isset($_para_content_left)) { echo do_shortcode($_para_content_left);} ?>	
			</div>
		</div>
	</div>
</div>