<?php
global $incart_lite_themename;
global $incart_lite_shortname;

if ( !class_exists( 'OT_Loader' )){	
	//THEME SHORTNAME	
	$incart_lite_shortname = 'incart-lite';	
	$incart_lite_themename = 'Incart Lite';	
	define('INCART_LITE_ADMIN_MENU_NAME','Incart Lite');
}

/***************** EXCERPT LENGTH ************/
function incart_excerpt_length($length) {
	return 50;
}
add_filter('excerpt_length', 'incart_excerpt_length');


/***************** READ MORE ****************/
function incart_excerpt_more( $more ) {
	return '...';
}
add_filter('excerpt_more', 'incart_excerpt_more');

/************* CUSTOM PAGE TITLE ***********/
add_filter( 'wp_title', 'incart_title' );
function incart_title($title)
{
	$incart_title = $title;
	if ( is_home() && !is_front_page() ) {
		$incart_title .= get_bloginfo('name');
	}

	if ( is_front_page() ){
		$incart_title .=  get_bloginfo('name');
		$incart_title .= ' | '; 
		$incart_title .= get_bloginfo('description');
	}

	if ( is_search() ) {
		$incart_title .=  get_bloginfo('name');
	}

	if ( is_author() ) { 
		global $wp_query;
		$curauth = $wp_query->get_queried_object();	
		$incart_title .= __('Author: ','incart-lite');
		$incart_title .= $curauth->display_name;
		$incart_title .= ' | ';
		$incart_title .= get_bloginfo('name');
	}

	if ( is_single() ) {
		$incart_title .= get_bloginfo('name');
	}

	if ( is_page() && !is_front_page() ) {
		$incart_title .= get_bloginfo('name');
	}

	if ( is_category() ) {
		$incart_title .= get_bloginfo('name');
	}

	if ( is_year() ) { 
		$incart_title .= get_bloginfo('name');
	}
	
	if ( is_month() ) {
		$incart_title .= get_bloginfo('name');
	}

	if ( is_day() ) {
		$incart_title .= get_bloginfo('name');
	}

	if (function_exists('is_tag')) { 
		if ( is_tag() ) {
			$incart_title .= get_bloginfo('name');
		}
		if ( is_404() ) {
			$incart_title .= get_bloginfo('name');
		}					
	}
	return $incart_title;
}

/**
 * SETS UP THE CONTENT WIDTH VALUE BASED ON THE THEME'S DESIGN.
 */

if ( ! isset( $content_width ) ){
    $content_width = 900;
}

/********************************************************
	#DEFINE REQUIRED CONSTANTS HERE# &
	#OPTIONAL: SET 'OT_SHOW_PAGES' FILTER TO FALSE#.
	#THIS WILL HIDE THE SETTINGS & DOCUMENTATION PAGES.#
*********************************************************/

//CHECK AND FOUND OUT THE THEME VERSION AND ITS BASE NAME

if(function_exists('wp_get_theme')){
    $skt_theme_data = wp_get_theme(get_option('template'));
    $skt_theme_version = $skt_theme_data->Version;  
} 

define( 'SKT_OPTS_FRAMEWORK_DIRECTORY_URI', trailingslashit(get_template_directory_uri() . '/SketchBoard/includes/') );	
define( 'SKT_OPTS_FRAMEWORK_DIRECTORY_PATH', trailingslashit(get_template_directory() . '/SketchBoard/includes/') );
define( 'INCART_LITE_THEME_VERSION',$skt_theme_version);	
	
add_filter( 'ot_show_pages', '__return_false' );

// REQUIRED: SET 'OT_THEME_MODE' FILTER TO TRUE.
add_filter( 'ot_theme_mode', '__return_true' );

// DISABLE ADD NEW LAYOUT SECTION FROM OPTIONS PAGE.
add_filter( 'ot_show_new_layout', '__return_false' );

// REQUIRED: INCLUDE OPTIONTREE.
require_once get_template_directory() . '/SketchBoard/includes/ot-loader.php';

// THEME OPTIONS
require_once get_template_directory() . '/SketchBoard/includes/options/theme-options.php';


/********************************************
	GET THEME OPTIONS VALUE FUNCTION
*********************************************/
function sketch_get_option( $option_id, $default = '' ){
	return ot_get_option( $option_id, $default = '' );
}

/*********************************************
*   LIMIT WORDS
*********************************************/
function incart_slider_limit_words($string, $word_limit) {
	$words = explode(' ', $string);
	return implode(' ', array_slice($words, 0, $word_limit));
}

/*--
WooCommerce Functions & Filters
--*/

//Remove wooCommerce prettyPhoto
global $woocommerce;
if($woocommerce) {
	function removeWooPrettyPhoto(){
		wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
	    wp_dequeue_script( 'prettyPhoto-init' );
		wp_dequeue_script( 'prettyPhoto' );
	}
	add_action( 'wp_enqueue_scripts', 'removeWooPrettyPhoto', 99 );
}

// Image sizes
global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) {
	add_action( 'init', 'skt_woocommerce_image_dimensions', 1 );
}
 
// Define image sizes 
function skt_woocommerce_image_dimensions() {
	$catalog = array(
		'width' => '600',	
		'height'	=> '600',	
		'crop'	=> 1 
	);
	$single = array(
		'width' => '600',	
		'height'=> '600',	
		'crop'	=> 1 
	);
	$thumbnail = array(
		'width' => '257',	
		'height'	=> '257',	
		'crop'	=> 1 
	);
	
	update_option( 'shop_catalog_image_size', $catalog ); // Product category thumbs
	update_option( 'shop_single_image_size', $single ); // Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail ); // Image gallery thumbs
}