<?php
/**
* The Header for our theme.
*/
?><!DOCTYPE html>
<?php global $incart_lite_shortname, $incart_lite_themename; ?>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<!--[if IE 9]>
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<![endif]-->
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<?php wp_head(); ?>
	
</head>
<body <?php body_class(); ?> >
	<div id="wrapper" class="skepage">
	<?php if(sketch_get_option($incart_lite_shortname.'_head_topbar')){ $_head_topbar = sketch_get_option($incart_lite_shortname.'_head_topbar'); } else {$_head_topbar ='';} ?> 
	<?php if($_head_topbar == 'on') { ?>
	<div id="header-top" class="clearfix">
		<div class="container">      
			<div class="row-fluid"> 
				<div class="span5">
					<!-- Social Links Section -->
					<div class="social_icon">
						<ul class="clearfix">
							<?php if(sketch_get_option($incart_lite_shortname.'_fbook_link')){?><li class="fb-icon"><a target="_blank" href="<?php echo esc_url(sketch_get_option($incart_lite_shortname.'_fbook_link','incart-lite')); ?>"><span class="fa fa-facebook" title="Facebook"></span></a></li><?php } ?>
							<?php if(sketch_get_option($incart_lite_shortname.'_twitter_link')){?><li class="tw-icon"><a target="_blank" href="<?php echo esc_url(sketch_get_option($incart_lite_shortname.'_twitter_link','incart-lite')); ?>"><span class="fa fa-twitter" title="Twitter"></span></a></li><?php } ?>
							<?php if(sketch_get_option($incart_lite_shortname.'_gplus_link')){ ?><li class="gplus-icon"><a target="_blank" href="<?php echo esc_url(sketch_get_option($incart_lite_shortname.'_gplus_link','incart-lite')); ?>"><span class="fa fa-google-plus" title="Google Plus"></span></a></li><?php } ?>
							<?php if(sketch_get_option($incart_lite_shortname.'_pinterest_link')){ ?><li class="pinterest-icon"><a target="_blank" href="<?php echo esc_url(sketch_get_option($incart_lite_shortname.'_pinterest_link','incart-lite')); ?>"><span class="fa fa-pinterest" title="Pinterest"></span></a></li><?php } ?>
							<?php if(sketch_get_option($incart_lite_shortname.'_linkedin_link')){ ?><li class="linkedin-icon"><a target="_blank" href="<?php echo sketch_get_option($incart_lite_shortname.'_linkedin_link','incart-lite'); ?>"><span class="fa fa-linkedin" title="Linkedin"></span></a></li><?php } ?>
							<?php if(sketch_get_option($incart_lite_shortname.'_foursquare_link')){ ?><li class="foursquare-icon"><a target="_blank" href="<?php echo esc_url(sketch_get_option($incart_lite_shortname.'_foursquare_link','incart-lite')); ?>"><span class="fa fa-foursquare" title="Foursquare"></span></a></li><?php } ?>
							<?php if(sketch_get_option($incart_lite_shortname.'_flickr_link')){ ?><li class="flickr-icon"><a target="_blank" href="<?php echo esc_url(sketch_get_option($incart_lite_shortname.'_flickr_link','incart-lite')); ?>"><span class="fa fa-flickr" title="Flickr"></span></a></li><?php } ?>
							<?php if(sketch_get_option($incart_lite_shortname.'_youtube_link')){ ?><li class="youtube-icon"><a target="_blank" href="<?php echo esc_url(sketch_get_option($incart_lite_shortname.'_youtube_link','incart-lite')); ?>"><span class="fa fa-youtube-play" title="Youtube"></span></a></li><?php } ?>
						</ul>
					</div>
					<!-- Social Links Section -->
				</div>
				<div class="span3">
					<!-- Top Contact Info -->
					<div class="topbar_info">
						<?php if(sketch_get_option($incart_lite_shortname.'_topbar_contact')){?><i class="fa fa-phone"></i><span class="head-phone"><a href="tel:<?php echo esc_attr(sketch_get_option($incart_lite_shortname.'_topbar_contact','incart-lite')); ?>"><?php echo esc_attr(sketch_get_option($incart_lite_shortname.'_topbar_contact','incart-lite')); ?></a></span><?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
		<div id="header" class="skehead-headernav clearfix">
			<div class="glow">
				<div id="skehead">
					<div class="container">      
						<div class="row-fluid">      
							<!-- #logo -->
							<div id="logo" class="span4">
								<?php if(sketch_get_option($incart_lite_shortname."_logo_img")){ ?>
									<a href="<?php echo home_url('/'); ?>" title="<?php bloginfo('name'); ?>" ><img class="logo" src="<?php echo esc_url(sketch_get_option($incart_lite_shortname."_logo_img")); ?>" alt="<?php echo esc_attr(sketch_get_option($incart_lite_shortname."_logo_alt")); ?>" /></a>
								<?php } else{ ?>
								<!-- #description -->
								<div id="site-title" class="logo_desp">
									<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php bloginfo('name') ?>" ><?php bloginfo('name'); ?></a> 
									<div id="site-description"><?php bloginfo( 'description' ); ?></div>
								</div>
								<!-- #description -->
								<?php } ?>
							</div>
							<!-- #logo -->
							
							<!-- .top-nav-menu --> 
							<div class="top-nav-menu span8"> 
								<div class="top-nav-menu ">
									<?php 
										if( function_exists( 'has_nav_menu' ) && has_nav_menu( 'Header' ) ) {
											wp_nav_menu(array( 'container_class' => 'ske-menu', 'container_id' => 'skenav', 'menu_id' => 'menu-main','theme_location' => 'Header' )); 
										} else {
									?>
									<div class="ske-menu" id="skenav">
										<ul id="menu-main" class="menu">
											<?php wp_list_pages('title_li=&depth=0'); ?>
										</ul>
									</div>
									<?php } ?>
								</div>
							</div>
							<!-- .top-nav-menu --> 
						</div>
					</div>
				</div>
				<!-- #skehead -->
			</div>
			<!-- glow --> 
		</div>
		
								
		<div class="header-clone"></div>
<!-- #header -->
<!-- header image section -->
  <?php $classes = get_body_class(); ?>
  <?php if(in_array('front-page',$classes)) {  include("includes/front-header-image-section.php");} ?>
<div id="main" class="clearfix">