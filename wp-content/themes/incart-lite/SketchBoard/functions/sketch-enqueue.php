<?php

global $incart_lite_themename;
global $incart_lite_shortname;

/************************************************
*  ENQUQUE CSS AND JAVASCRIPT
************************************************/
//ENQUEUE JQUERY 
function incart_script_enqueqe() {
	global $incart_lite_shortname;
	if(!is_admin()) {
		wp_enqueue_script('incart_componentssimple_slide', get_template_directory_uri() .'/js/custom.js',array('jquery'),'1.0',1 );
		wp_enqueue_script("comment-reply");
	}    
}
add_action('init', 'incart_script_enqueqe');

//ENQUEUE FRONT SCRIPTS
function incart_theme_stylesheet()
{
	global $incart_lite_themename;
	global $incart_lite_shortname;
	if ( !is_admin() ) 
	{
		$theme = wp_get_theme();
		wp_enqueue_script('incart_colorboxsimple_slide',get_template_directory_uri() .'/js/jquery.prettyPhoto.js',array('jquery'),true,'1.0');
		wp_enqueue_script('incart_hoverIntent', get_template_directory_uri().'/js/hoverIntent.js',array('jquery'),true,'1.0');
		wp_enqueue_script('incart_superfish', get_template_directory_uri().'/js/superfish.js',array('jquery'),true,'1.0');
		wp_enqueue_script('incart_AnimatedHeader', get_template_directory_uri().'/js/cbpAnimatedHeader.js',array('jquery'),true,'1.0');
		wp_enqueue_script('incart_easing_slide',get_template_directory_uri().'/js/jquery.easing.1.3.js',array('jquery'),'1.0',true);
		wp_enqueue_script('incart_waypoints',get_template_directory_uri().'/js/waypoints.js',array('jquery'),'1.0',true );
		
		wp_enqueue_style( 'incart-style', get_stylesheet_uri() );
		wp_enqueue_style('incart-animation-stylesheet', get_template_directory_uri().'/css/skt-animation.css', false, $theme->Version);
		wp_enqueue_style('incart-colorbox-theme-stylesheet', get_template_directory_uri().'/css/prettyPhoto.css', false, $theme->Version);
		wp_enqueue_style( 'incart-awesome-theme-stylesheet', get_template_directory_uri().'/css/font-awesome.css', false, $theme->Version);
		
		/*SUPERFISH*/
		wp_enqueue_style( 'incart-superfish-stylesheet', get_template_directory_uri().'/css/superfish.css', false, $theme->Version);
		wp_enqueue_style( 'incart-bootstrap-responsive-theme-stylesheet', get_template_directory_uri().'/css/bootstrap-responsive.css', false, $theme->Version);
		
		/*GOOGLE FONTS*/
		wp_enqueue_style( 'googleFontsRoboto','//fonts.googleapis.com/css?family=Roboto:400,300,400italic,500,700', false, $theme->Version);
		wp_enqueue_style( 'googleFontsLato','//fonts.googleapis.com/css?family=Lato:400,700', false, $theme->Version);
	}
}
add_action('wp_enqueue_scripts', 'incart_theme_stylesheet');

function incart_head() {
	global $incart_lite_shortname;
	$incart_favicon = "";
	$incart_meta = '<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">'."\n";

	if(sketch_get_option($incart_lite_shortname.'_favicon')) {
		$incart_favicon = esc_url(sketch_get_option($incart_lite_shortname.'_favicon','incart-lite'));
		$incart_meta .= "<link rel=\"shortcut icon\" type=\"image/x-icon\" href=\"$incart_favicon\"/>\n";
	}
	echo $incart_meta;

	if(!is_admin()) {
		require_once(get_template_directory().'/includes/incart-custom-css.php');
	}
}
add_action('wp_head', 'incart_head');