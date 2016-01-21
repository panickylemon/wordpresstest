<?php global $incart_lite_shortname; ?>
<?php  
	$_featured_title1 ='';
	$_featured_title2 ='';
	$_featured_title3 ='';
	if(sketch_get_option($incart_lite_shortname.'_featured_title1')){ $_featured_title1 = sketch_get_option($incart_lite_shortname.'_featured_title1'); } 
	if(sketch_get_option($incart_lite_shortname.'_featured_title2')){ $_featured_title2 = sketch_get_option($incart_lite_shortname.'_featured_title2'); } 
	if(sketch_get_option($incart_lite_shortname.'_featured_title3')){ $_featured_title3 = sketch_get_option($incart_lite_shortname.'_featured_title3'); } 
?>
<div id="featured-box" class="skt-section">
	<div class="container">
		<div class="mid-box-mid row-fluid"> 
			<!-- Featured Box 1 -->
			<div class="mid-box span4 fade_in_hide element_fade_in">
				<div class="skt-iconbox iconbox-top">		
					<div class="iconbox-icon skt-animated small-to-large skt-viewport">	
						<a href="<?php if(sketch_get_option($incart_lite_shortname."_fb1_first_part_link")) { echo esc_url(sketch_get_option($incart_lite_shortname."_fb1_first_part_link")); }?>" title="Img">
								<img class="skin-bg" src="<?php if(sketch_get_option($incart_lite_shortname.'_fb1_first_part_image')) { echo sketch_get_option($incart_lite_shortname.'_fb1_first_part_image','incart-lite'); } else { echo get_template_directory_uri().'/images/Feature-image-01.png'; }  ?>" alt="boximg"/>  
								<span class="iconboxhover"></span>
						</a>
					</div>		
					<div class="iconbox-content">		
						<h4><a href="<?php if(sketch_get_option($incart_lite_shortname."_fb1_first_part_link")) { echo esc_url(sketch_get_option($incart_lite_shortname."_fb1_first_part_link")); } ?>" title="<?php if($_featured_title1) { echo $_featured_title1; } ?>"><?php if($_featured_title1) { echo $_featured_title1; } ?></a><br /><hr></h4>
					</div>
					<div class="clearfix"></div>	
				</div>
			</div>
			<!-- Featured Box 2 -->
			<div class="mid-box span4 fade_in_hide element_fade_in">
				<div class="skt-iconbox iconbox-top">		
					<div class="iconbox-icon skt-animated small-to-large skt-viewport">	
						<a href="<?php if(sketch_get_option($incart_lite_shortname."_fb2_second_part_link")) { echo esc_url(sketch_get_option($incart_lite_shortname."_fb2_second_part_link")); }?>" title="Img">
								<img class="skin-bg" src="<?php if(sketch_get_option($incart_lite_shortname.'_fb2_second_part_image')) { echo sketch_get_option($incart_lite_shortname.'_fb2_second_part_image','incart-lite'); } else { echo get_template_directory_uri().'/images/Feature-image-02.png'; }  ?>" alt="boximg"/>
								<span class="iconboxhover"></span>
						</a>
					</div>
					<div class="iconbox-content">		
						<h4><a href="<?php if(sketch_get_option($incart_lite_shortname."_fb2_second_part_link")) { echo esc_url(sketch_get_option($incart_lite_shortname."_fb2_second_part_link")); }?>" title="<?php if($_featured_title2) { echo $_featured_title2; } ?>"><?php if($_featured_title2) { echo $_featured_title2; } ?></a><br /><hr></h4>
					</div>
					<div class="clearfix"></div>	
				</div>
			</div>
			<!-- Featured Box 3 -->
			<div class="mid-box span4 fade_in_hide element_fade_in">
				<div class="skt-iconbox iconbox-top">		
					<div class="iconbox-icon skt-animated small-to-large skt-viewport">	
						<a href="<?php if(sketch_get_option($incart_lite_shortname."_fb3_third_part_link")) { echo esc_url(sketch_get_option($incart_lite_shortname."_fb3_third_part_link")); } ?>" title="Img">
								<img class="skin-bg" src="<?php if(sketch_get_option($incart_lite_shortname.'_fb3_third_part_image')) { echo sketch_get_option($incart_lite_shortname.'_fb3_third_part_image','incart-lite'); } else { echo get_template_directory_uri().'/images/Feature-image-03.png'; } ?>" alt="boximg"/>
								<span class="iconboxhover"></span>
						</a>
					</div>
					<div class="iconbox-content">		
						<h4><a href="<?php if(sketch_get_option($incart_lite_shortname."_fb3_third_part_link")) { echo esc_url(sketch_get_option($incart_lite_shortname."_fb3_third_part_link")); } ?>" title="<?php if($_featured_title3) { echo $_featured_title3; } ?>"><?php if($_featured_title3) { echo $_featured_title3; } ?></a><br /><hr></h4>
					</div>
					<div class="clearfix"></div>	
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>