<?php 
/*
 Plugin Name: WP-Shop
 Plugin URI: http://www.wp-shop.ru
 Description: Интернет-магазин для WordPress.
 Author: www.wp-shop.ru
 Version: 3.5.5
 Author URI: http://www.wp-shop.ru
 */


//error_reporting(E_ALL);
//ini_set("display_errors", 1);


if (!session_id()) { session_start(); }

define( 'WPSHOP_DIR', dirname(realpath(__FILE__)));
define( 'WPSHOP_URL', plugins_url("",__FILE__) );
define( 'WPSHOP_CLASSES_DIR' , WPSHOP_DIR ."/classes");
define( 'WPSHOP_VIEWS_DIR' , WPSHOP_DIR ."/views");
define( 'WPSHOP_DATA_DIR', WPSHOP_DIR ."/data");
define( 'WPSHOP_THEME_TEMPLATE_DIR', get_template_directory() . "/wpshop" );

define( 'CURR_BEFORE',	'&nbsp;' );
define( 'CART_ID',		'wpshop_cart' );
define( 'MINICART_ID',	'wpshop_minicart' );
define( 'CART_TAG',		'[cart]' );
define( 'MINICART_TAG',	'[minicart]' );
define( 'SPL', '}{' );
require_once(dirname(__FILE__) . '/ajax.php');
function wpshopAutoload($ClassName)
{	$class = array();
	preg_match("/Wpshop_(\S+)/",$ClassName,$class);
	$file = WPSHOP_CLASSES_DIR."/class.Wpshop.{$class[1]}.php";
	if (file_exists($file))
	{
		require_once($file);
	}
}

spl_autoload_register('wpshopAutoload');

$WpShopBoot = new Wpshop_Boot();
function wpshop_plugin_activate() {
	$installer = new Wpshop_Installer();
}
register_activation_hook( __FILE__, 'wpshop_plugin_activate' );
function wpshop_init_lang(){
	load_plugin_textdomain('wp-shop', false, dirname(plugin_basename(__FILE__)).'/languages');
}

function wpshop_init_signon(){
	if (isset($_POST['wpshop_auth_usr_btn'])){
		$wpshop_user_name = htmlspecialchars(stripslashes($_POST['wpshop_user_name']));
		$wpshop_user_password = htmlspecialchars(stripslashes($_POST['wpshop_user_password']));
		$creds = array();
		$creds['user_login'] = $wpshop_user_name;
		$creds['user_password'] = $wpshop_user_password;
		$creds['remember'] = false;
		$secure_cookie = 0;
		//$user = wp_signon($creds, true);
		$user = wp_authenticate($wpshop_user_name, $wpshop_user_password);
		if ( is_wp_error($user) ){
			//echo $user->get_error_message();
		}elseif($_GET['page_id']){
			wp_set_auth_cookie($user->ID, $creds['remember'], $secure_cookie);
			do_action('wp_login', $user->user_login, $user);
			$full_path=get_option("wpshop.cartpage",'{sitename}/cart');
			header("Location: ".$full_path."&step=3");
			exit;
		}else{
			wp_set_auth_cookie($user->ID, $creds['remember'], $secure_cookie);
			do_action('wp_login', $user->user_login, $user);
			header("Location: ?step=3");
			exit;
		}
	}
	
if ( is_user_logged_in() ) {
	global $current_user;
	
	$user_roles = $current_user->roles;
	$user_role = array_shift($user_roles);
	
	if ( $user_role =='Customer'|| current_user_can( 'manage_options' ) || $user_role =='Merchant') {
	if ( in_array('Customer', $current_user->roles)) {
		function remove_profile_submenu() {
			remove_menu_page('index.php');
		}
		add_action('admin_head', 'remove_profile_submenu');
		
		function profile_redirect() {
			$result = stripos($_SERVER['REQUEST_URI'], 'index.php');
			if ($result!==false) {
				wp_redirect(get_option('siteurl') . '/wp-admin/profile.php');
			}
		}
	 	add_action('admin_menu', 'profile_redirect');
	}
	} else { 
		function remove_menus_shop(){
			remove_menu_page('wpshop_main');      
		}
		add_action( 'admin_menu', 'remove_menus_shop' );
	}
}

function ipstenu_admin_bar_add() {
	global $wp_admin_bar;
	global $current_user;
	
	if (  in_array('Customer', $current_user->roles )) {
		if( !is_admin()){
			$wp_admin_bar->add_menu(array('parent'=>false,'id'=>'site-name', 'href'=>get_home_url().'/wp-admin/profile.php'));
			$wp_admin_bar->remove_menu('dashboard');
		}
	}
}

add_action( 'wp_before_admin_bar_render', 'ipstenu_admin_bar_add' );
	
	// elseif (isset($_POST['token'])){
		// $wpshop_loginza_token_key_value = preg_replace('`[^a-z^0-9]+`i', '', $_POST['token']);
		// $wpshop_loginza_widget_id = get_option("wpshop.loginza.widget_id");
		// $wpshop_loginza_secret_key = get_option("wpshop.loginza.secret_key");
		// $wpshop_loginza_api_signature = md5($wpshop_loginza_token_key_value.$wpshop_loginza_secret_key);
		// $checkurl = 'http://loginza.ru/api/authinfo?token='.$wpshop_loginza_token_key_value.'&id='.$wpshop_loginza_widget_id.'&sig='.$wpshop_loginza_api_signature;
		// $data = file_get_contents($checkurl);
		// $json_data = json_decode($data, true);
		//var_dump($json_data);
		// if (isset($json_data) and isset($json_data['error_message'])){
			//echo '<p>'.$json_data['error_message'].'</p>';
		// }elseif (isset($json_data)){
			// $wpshop_user_password = md5(rand(0,50000).$user.rand(0,50000));
			//$wpshop_user_password = 'wpshop';
			// $wpshop_user_email = '';
			// $secure_cookie = 0;
			// $wpshop_user_name = 'wpshop'.$wpshop_loginza_token_key_value;
			// $wpshop_user_email = 'wpshop'.$wpshop_loginza_token_key_value.'@'.$_SERVER['HTTP_HOST'];
			// $wpshop_user_first_name = '';
			// if (isset($json_data['first_name'])){
				// $wpshop_user_first_name = $json_data['first_name'];
			// }elseif (isset($json_data['name']['first_name'])){
				// $wpshop_user_last_name = $json_data['name']['first_name'];
			// }
			// $wpshop_user_last_name = '';
			// if (isset($json_data['last_name'])){
				// $wpshop_user_last_name = $json_data['last_name'];
			// }elseif (isset($json_data['name']['last_name'])){
				// $wpshop_user_last_name = $json_data['name']['last_name'];
			// }
			// if ($user_id = username_exists($wpshop_user_name)){				$user = get_userdata($user_id);
				// $user = wp_authenticate($wpshop_user_name);
			// }else{				$user = array(
				    // 'user_login' => $wpshop_user_name,
				    // 'user_pass' => $wpshop_user_password,
				    // 'first_name' => $wpshop_user_first_name,
				    // 'last_name' => $wpshop_user_last_name,
				    // 'user_email' => $wpshop_user_email,
				    // 'display_name' => $json_data['identity'],
				    // 'user_nicename' => $json_data['identity'],
				    // 'user_url ' => $json_data['provider'],
				    // );
				// $just_registred_error = wp_insert_user($user);
				// $user = wp_authenticate($wpshop_user_name, $wpshop_user_password);
			// }
			// if ( is_wp_error($user) ){
				// echo $user->get_error_message();
			// }else{
				// wp_set_auth_cookie($user->ID, 1, $secure_cookie);
				// do_action('wp_login', $user->user_login, $user);
			// }
		// }
	// }
	
}

add_action( 'init', 'wpshop_init_signon', 7);


