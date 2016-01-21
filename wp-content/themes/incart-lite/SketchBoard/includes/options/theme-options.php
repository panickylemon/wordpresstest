<?php
global $incart_lite_themename;
global $incart_lite_shortname;

/**
 * Initialize the options before anything else. 
 */
add_action( 'admin_init', 'incart_lite_theme_options', 1 );

/**
 * Theme Mode demo code of all the available option types.
 *
 * @return    void
 *
 * @access    private
 * @since     2.0
 */
function incart_lite_theme_options() {

global $incart_lite_themename;
global $incart_lite_shortname;
  
   /**
    * Get a copy of the saved settings array. 
    */
	$saved_settings = get_option( 'option_tree_settings', array() );

	// If using image radio buttons, define a directory path
	$imagepath  =  get_template_directory_uri() . '/images/';
	$sktsiteurl = home_url('/');
	$sktsitenm  = get_bloginfo('name');
	
	// BACKGROUND DEFAULTS
	$background_defaults = array(
		'background-color'     => '#000000',
		'background-image'     => '',
		'background-repeat'    => 'repeat-y',
		'background-position'  => 'center top',
		'background-attachment'=>'fixed' 
	);
	
  /**
   * Create a custom settings array that we pass to 
   * the OptionTree Settings API Class.
   */
  $custom_settings = array(
    'contextual_help' => array(
		'content'       => array( 
			array(
				'id'        => 'general_help',
				'title'     => 'General',
				'content'   => __('<p>Help content goes here!</p>','incart-lite')
			)
		),
		'sidebar'     => __('<p>Sidebar content goes here!</p>','incart-lite')
		),
		'sections'        => array(
			array(
				'title'   => __( 'General Settings', 'incart-lite' ),
				'id'      => 'general_default'
			),			
			array(
				'title'   => __( 'Header Settings', 'incart-lite' ),
				'id'      => 'header_settings'
			), 
			array(      
				'title'   => __( 'Top Bar Settings', 'incart-lite' ),
				'id'      => 'head_topbar_settings'
			), 			
			array(
				'title'   => __( 'Blog Settings', 'incart-lite' ),
				'id'      => 'blog_settings'
			), 
			array(
				'title'   => __( 'Home Page Featured Section', 'incart-lite' ),
				'id'      => 'home_feature_settings'
			), 		
			array(
				'title'   => __( 'Home Page Parallax Section', 'incart-lite' ),
				'id'      => 'home_parallax_settings'
			), 		
			array(      
				'title'   => __( 'Footer Settings', 'incart-lite' ),
				'id'      => 'footer_section'
			),			
		),
		
		'settings'        => array(

		//==================================================================
		// GENERAL SETTINGS SECTION STARTS =================================
		//==================================================================
		
		array(
			'id'          => 'incart_welcome_speach',
			'label'       => __('Welcome to Incart','incart-lite'),
			'desc'        => __('<h1>Welcome to Incart Lite</h1>
			<p>Thank you for using Incart Lite. Get started below and go through the left tabs to set up your website.</p>','incart-lite'),
			'std'         => '',
			'type'        => 'textblock',
			'section'     => 'general_default',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'class'       => ''
		),
		array(
			'label'       => __( 'Color Scheme', 'incart-lite'),
			'id'          => $incart_lite_shortname.'_colorpicker',
			'type'        => 'colorpicker',
			'desc'        => __('Set color scheme','incart-lite'),
			'std'         => '#1abc9c',
			'section'     => 'general_default'
		),
		array(
			'label'       => __( 'Upload Favicon', 'incart-lite'),
			'id'          => $incart_lite_shortname.'_favicon',
			'type'        => 'upload',
			'desc'        => __('This creates a custom favicon for your website.','incart-lite'),
			'std'         => '',
			'section'     => 'general_default'
		),
		
		
		
		//------ END GENERAL SETTINGS SECTION ------------------------------
		
					
		//==================================================================
		// HEADER SETTINGS SECTION STARTS ==================================
		//==================================================================
		
		array(
			'label'       => __( 'Change Logo', 'incart-lite'),
			'id'          => $incart_lite_shortname.'_logo_img',
			'type'        => 'upload',
			'desc'        => __('This creates a custom logo for your website.','incart-lite'),
			'std'         => '',
			'section'     => 'header_settings'
		),
		array(
			'label'       => __( 'Home page Image', 'incart-lite'),
			'id'          => $incart_lite_shortname.'_frontslider_stype',
			'type'        => 'upload',
			'desc'        => __('Choose image for home page. Size: Width 1600px and Height 500px.','incart-lite'),
			'std'         => '',
			'section'     => 'header_settings'
		),
		array(
			'id'          => $incart_lite_shortname.'_logo_alt',
			'label'       => __( 'Logo ALT Text', 'incart-lite'),
			'desc'        => __('Enter logo image alt attribute text.','incart-lite'),
			'std'         => __('Incart Theme','incart-lite'),
			'type'        => 'text',
			'section'     => 'header_settings'
		),	
		array(
			'id'          => $incart_lite_shortname.'_moblie_menu',
			'label'       => __( 'Mobile Menu Activate Width', 'incart-lite'),
			'desc'        => __( 'Layout width after which mobile menu will get activated', 'incart-lite' ),
			'std'         => '1025',
			'type'        => 'numeric-slider',
			'section'     => 'header_settings',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '100,1180,1'
		),
				
		//------ END HEADER SETTINGS SECTION -------------------------------
		
				//==================================================================
		// HEADER TOP BAR SETTINGS SECTION STARTS ==========================
		//==================================================================
		
		array(
			'id'          => $incart_lite_shortname.'_head_topbar',
			'label'       => __('Header Top Bar', 'incart-lite'),
			'desc'        => __('On/Off header top bar.', 'incart-lite'),
			'type'        => 'on-off',
			'std'         => 'on',
			'section'     => 'head_topbar_settings'
		),
		array(
			'id'          => 'head_social_icons',
			'label'       => __('Social Follow Icons','incart-lite'),
			'desc'        => __('<h2><b>Social Follow Icons</b></h2>
			<p>Add your social profile URL( eg: <b>http://facebook.com/user</b> )</p>','incart-lite'),
			'std'         => '',
			'type'        => 'textblock',
			'condition'   => $incart_lite_shortname.'_head_topbar:is(on)',
			'section'     => 'head_topbar_settings',
		),
	  	array(
			'label'       => __('Facebook Link','incart-lite'),
			'id'          => $incart_lite_shortname.'_fbook_link',
			'type'        => 'text',
			'desc'        => __('Enter Facebook Link.','incart-lite'),
			'std'         => '#',
			'condition'   => $incart_lite_shortname.'_head_topbar:is(on)',
			'section'     => 'head_topbar_settings'
		),
		array(
			'label'       => __('Twitter Link','incart-lite'),
			'id'          => $incart_lite_shortname.'_twitter_link',
			'type'        => 'text',
			'desc'        => __('Enter Twitter link.','incart-lite'),
			'std'         => '#',
			'condition'   => $incart_lite_shortname.'_head_topbar:is(on)',
			'section'     => 'head_topbar_settings'
		),
		array(
			'label'       => __('Google Plus ID','incart-lite'),
			'id'          => $incart_lite_shortname.'_gplus_link',
			'type'        => 'text',
			'desc'        => __('Enter Google plus Id.','incart-lite'),
			'std'         => '#',
			'condition'   => $incart_lite_shortname.'_head_topbar:is(on)',
			'section'     => 'head_topbar_settings'
		),
		array(
			'label'       => __('Linkedin Link','incart-lite'),
			'id'          => $incart_lite_shortname.'_linkedin_link',
			'type'        => 'text',
			'desc'        => __('Enter Linkedin link.','incart-lite'),
			'std'         => '#',
			'condition'   => $incart_lite_shortname.'_head_topbar:is(on)',
			'section'     => 'head_topbar_settings'
		),	
		array(
			'label'       => __('Pinterest Link','incart-lite'),
			'id'          => $incart_lite_shortname.'_pinterest_link',
			'type'        => 'text',
			'desc'        => __('Enter Pinterest link.','incart-lite'),
			'std'         => '#',
			'condition'   => $incart_lite_shortname.'_head_topbar:is(on)',
			'section'     => 'head_topbar_settings'
		),	
		array(
			'label'       => __('Flickr Link','incart-lite'),
			'id'          => $incart_lite_shortname.'_flickr_link',
			'type'        => 'text',
			'desc'        => __('Enter Flickr link.','incart-lite'),
			'std'         => '#',
			'condition'   => $incart_lite_shortname.'_head_topbar:is(on)',
			'section'     => 'head_topbar_settings'
		),
		array(
			'label'       => __('Dribbble Link','incart-lite'),
			'id'          => $incart_lite_shortname.'_dribbble_link',
			'type'        => 'text',
			'desc'        => __('Enter Dribbble link.','incart-lite'),
			'std'         => '#',
			'condition'   => $incart_lite_shortname.'_head_topbar:is(on)',
			'section'     => 'head_topbar_settings'
		),
		array(
			'label'       => __('Contact Number','incart-lite'),
			'id'          => $incart_lite_shortname.'_topbar_contact',
			'type'        => 'text',
			'desc'        => __('Enter Contact Number.','incart-lite'),
			'std'         => '1+555-240-7980',
			'condition'   => $incart_lite_shortname.'_head_topbar:is(on)',
			'section'     => 'head_topbar_settings'
		),
		
		//------ END SOCIAL LINKS SETTINGS SECTION -------------------------
		
		//==================================================================
		// BLOG SETTINGS SECTION STARTS ====================================
		//==================================================================	

		array(
			'id'          => $incart_lite_shortname.'_blogpage_heading',
			'label'       => __( 'Enter Blog Page Title', 'incart-lite'),
			'desc'        => __('Enter Blog Page Title text.','incart-lite'),
			'std'         => 'Blog',
			'type'        => 'text',
			'section'     => 'blog_settings'
		),
			
		//------ END BLOG SETTINGS SECTION ---------------------------------
		
		//==================================================================
		// HOME FEATURED SETTINGS SECTION STARTS ========================s======
		//==================================================================	
		
		array(
			'label'       => __( 'First Featured Box Image Path (size: width * height (263px * 369px) )', 'incart-lite'),
			'id'          => $incart_lite_shortname.'_fb1_first_part_image',
			'type'        => 'upload',
			'desc'        => __('Upload image for first featured box.','incart-lite'),
			'std'         => '',
			'section'     => 'home_feature_settings'
		),
		array(
			'id'          => $incart_lite_shortname.'_featured_title1',
			'label'       => __( 'First Featured Image Title', 'incart-lite'),
			'desc'        => __('Enter logo image alt attribute text.','incart-lite'),
			'std'         => 'Incart Theme',
			'type'        => 'text',
			'section'     => 'home_feature_settings'
		),
		array(
			'id'          => $incart_lite_shortname.'_fb1_first_part_link',
			'label'       => __( 'First Featured Box Link', 'incart-lite'),
			'desc'        => __('Enter link for first featured box.','incart-lite'),
			'std'         => '',
			'type'        => 'text',
			'section'     => 'home_feature_settings'
		),
		array(
			'label'       => __( 'Second Featured Box Image Path (size: width * height (263px * 369px) )', 'incart-lite'),
			'id'          => $incart_lite_shortname.'_fb2_second_part_image',
			'type'        => 'upload',
			'desc'        => __('Upload image for second featured box.','incart-lite'),
			'std'         => '',
			'section'     => 'home_feature_settings'
		),
			array(
				'id'          => $incart_lite_shortname.'_featured_title2',
				'label'       => __( 'Second Featured Image Title', 'incart-lite'),
				'desc'        => __('Enter logo image alt attribute text.','incart-lite'),
				'std'         => 'Incart Theme',
				'type'        => 'text',
				'section'     => 'home_feature_settings'
			),
		array(
			'id'          => $incart_lite_shortname.'_fb2_second_part_link',
			'label'       => __( 'Second Featured Box Link', 'incart-lite'),
			'desc'        => __('Enter link for second featured box.','incart-lite'),
			'std'         => '',
			'type'        => 'text',
			'section'     => 'home_feature_settings'
		),
		array(
			'label'       => __( 'Third Featured Box Image Path (size: width * height (263px * 369px) )', 'incart-lite'),
			'id'          => $incart_lite_shortname.'_fb3_third_part_image',
			'type'        => 'upload',
			'desc'        => __('Upload image for third featured box.','incart-lite'),
			'std'         => '',
			'section'     => 'home_feature_settings'
		),
		array(
			'id'          => $incart_lite_shortname.'_featured_title3',
			'label'       => __( 'Third Featured Image Title', 'incart-lite'),
			'desc'        => __('Enter logo image alt attribute text.','incart-lite'),
			'std'         => 'Incart Theme',
			'type'        => 'text',
			'section'     => 'home_feature_settings'
		),
		array(
			'id'          => $incart_lite_shortname.'_fb3_third_part_link',
			'label'       => __( 'Third Featured Box Link', 'incart-lite'),
			'desc'        => __('Enter link for third featured box.','incart-lite'),
			'std'         => '',
			'type'        => 'text',
			'section'     => 'home_feature_settings'
		),
		//------ END HOME FEATURED SETTINGS SECTION ---------------------
		
		//==================================================================
		// PARALLAX SETTINGS SECTION STARTS ==================================
		//==================================================================

		array(
			'label'       => __( 'Parallax Section Background Image (size: width * height (1600x * 1000px) )', 'incart-lite'),
			'id'          => $incart_lite_shortname.'_fullparallax_image',
			'type'        => 'upload',
			'desc'        => __('Upload background image for parallax section.','incart-lite'),
			'std'         => '',
			'section'     => 'home_parallax_settings'
		),
		array(
			'label'       => __('Parallax Section Content','incart-lite'),
			'id'          => $incart_lite_shortname.'_para_content_left',
			'type'        => 'textarea',
			'desc'        => __('Enter content for parallax section','incart-lite'),
			'std'         => '',
			'section'     => 'home_parallax_settings'
		),
		
		
		//------ END PARALLAX SETTINGS SECTION -------------------------------
		
		//==================================================================
		// FOOTER SETTINGS SECTION STARTS ==================================
		//==================================================================
		
		array(
			'label'       => __('Copyright Text','incart-lite'),
			'id'          => $incart_lite_shortname.'_copyright',
			'type'        => 'textarea',
			'desc'        => __('You can use HTML for links etc..','incart-lite'),
			'std'         => 'Copyright text here',
			'section'     => 'footer_section'
		),		
				
		//------ END FOOTER SETTINGS SECTION ------------------------------	
		
    )
  );
  
  /* allow settings to be filtered before saving */
  $custom_settings = apply_filters( 'option_tree_settings_args', $custom_settings );
  
  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( 'option_tree_settings', $custom_settings ); 
  }
  
}

?>