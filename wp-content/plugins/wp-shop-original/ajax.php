<?php

add_action("wp_ajax_cart_remove", "wp_shop_original_cart_remove");
add_action("wp_ajax_nopriv_cart_remove", "wp_shop_original_cart_remove");
add_action("wp_ajax_cart_save", "wp_shop_original_cart_save");
add_action("wp_ajax_nopriv_cart_save", "wp_shop_original_cart_save");
add_action("wp_ajax_cart_load", "wp_shop_original_cart_load");
add_action("wp_ajax_nopriv_cart_load", "wp_shop_original_cart_load");
add_action("wp_ajax_set_currency", "wp_shop_original_set_currency");
add_action("wp_ajax_nopriv_set_currency", "wp_shop_original_set_currency");
add_action("wp_ajax_ajax_post", "wp_shop_original_ajax_post");
add_action("wp_ajax_nopriv_ajax_post", "wp_shop_original_ajax_post");
add_action("wp_ajax_delete_all", "wp_shop_original_delete_all");
add_action("wp_ajax_nopriv_delete_all", "wp_shop_original_delete_all");
add_action("wp_ajax_cart_promocode", "wp_shop_original_cart_promocode");
add_action("wp_ajax_nopriv_cart_promocode", "wp_shop_original_cart_promocode");

function wp_shop_original_ajax_post(){
	if ($_POST['act'] == 'price_options')
  {
	$under_title = sanitize_text_field($_POST['under_title']);
    update_option('wpshop_price_under_title', $under_title);
  }
	die();
}

function wp_shop_original_delete_all(){
	global $wpdb;
	$res = $wpdb->query("SET AUTOCOMMIT=0;");
	$res = $wpdb->query("SET FOREIGN_KEY_CHECKS=0;");
	$res = $wpdb->query("DROP TABLE {$wpdb->prefix}wpshop_orders;");
	$res = $wpdb->query("DROP TABLE {$wpdb->prefix}wpshop_ordered;");
	$res = $wpdb->query("DROP TABLE {$wpdb->prefix}wpshop_selected_items;");
	$res = $wpdb->query("DELETE FROM {$wpdb->prefix}posts WHERE post_type='wpshopcarts';");
	
	die();
} 

function wp_shop_original_cart_promocode(){
  global $wpdb;
  $wpshop_session_id	= session_id();
	$promocode = sanitize_text_field($_POST['promocode']);
  wp_reset_postdata();
	$wp_query_promo = new WP_Query(
    array(
        'post_type' => 'wpshop_promo',
        'posts_per_page' => -1 
    ) 
	);
	
	$find = false;
	
	if ($wp_query_promo->have_posts()): while ($wp_query_promo->have_posts()) : $wp_query_promo->the_post(); 
    $id = get_the_ID();
		$code = get_the_title($id)*1;
		$value = get_post_meta($id, 'wpshop_promo_value', true);
		$pers = get_post_meta($id, 'wpshop_promo_pers', true);
		/* $message_promo = get_post_meta($id, 'wpshop_promo_message', true); */
		$message_promo = apply_filters('the_content', get_post_field('post_content', $id));
		$active_promo = get_post_meta($id, 'wpshop_promo_active', true);
    
		if ($active_promo > 0){
      if ($code == $promocode) {
        if ($value) {
          
        }elseif($pers) {
		  $param_prom = array(session_id());
          $wpdb->get_results($wpdb->prepare("UPDATE {$wpdb->prefix}wpshop_selected_items SET selected_items_cost=selected_items_cost-(selected_items_cost*{$pers}/100) WHERE selected_items_session_id='%s' and selected_items_promo=0",$param_prom));
          if ($message_promo) {
            $message = $message_promo;
          }else {
            $message = __('Your promo discount '/*Ваша скидка по промокоду*/, 'wp-shop').$pers.'%';
          }
        }
		$param_prom1 = array($id,session_id());
        $wpdb->get_results($wpdb->prepare("UPDATE {$wpdb->prefix}wpshop_selected_items SET selected_items_promo=%d WHERE selected_items_session_id='%s'",$param_prom1));
        $find = true;
        
        update_post_meta($id, 'wpshop_promo_active', $active_promo-1);
      }
    } 
    
    if ($active_promo !=''&&$active_promo == 0) {
      if ($code == $promocode) {
        $message = __('Promocode already not active '/*Промокод больше не активен*/, 'wp-shop');
        $find = true;
      }
    } 
    
    if ($active_promo =='') {
      if ($code == $promocode) {
        if ($value) {
          
        }elseif($pers) {
		  $param_prom = array(session_id());
          $wpdb->get_results($wpdb->prepare("UPDATE {$wpdb->prefix}wpshop_selected_items SET selected_items_cost=selected_items_cost-(selected_items_cost*{$pers}/100) WHERE selected_items_session_id='%s' and selected_items_promo=0",$param_prom));
          if ($message_promo) {
            $message = $message_promo;
          }else {
            $message = __('Your promo discount '/*Ваша скидка по промокоду*/, 'wp-shop').$pers.'%';
          }
        }
		$param_prom1 = array($id,session_id());
        $wpdb->get_results($wpdb->prepare("UPDATE {$wpdb->prefix}wpshop_selected_items SET selected_items_promo=%d WHERE selected_items_session_id='%s'",$param_prom1));
        $find = true;
      }
    }
  endwhile; 
	endif;
	wp_reset_postdata();
	if ($find) {
		echo $message;
	}else {
		echo 'NO';
	}
	
	die();
}

function wp_shop_original_cart_remove(){
	global $wpdb;
	$wpshop_session_id	= session_id();
	$wpshop_id = $_POST['wpshop_id'];

	if ($wpshop_id=="-1"){ // Delete all selected items
		$param_remove = array(session_id());
		$res = $wpdb->get_results($wpdb->prepare("DELETE FROM {$wpdb->prefix}wpshop_selected_items WHERE selected_items_session_id='%s'",$param_remove));
	}else{
		// Delete 1 selected item
		$param_remove1 = array(session_id(),$wpshop_id);
		$res = $wpdb->get_results($wpdb->prepare("DELETE FROM {$wpdb->prefix}wpshop_selected_items WHERE selected_items_session_id='%s' and selected_items_id='%d'",$param_remove1));
	}
	die();
} 

function wp_shop_original_set_currency(){
	global $wpdb;
	$usd_opt = sanitize_text_field($_POST['usd']);
	$eur_opt = sanitize_text_field($_POST['eur']);
	update_option('wp-shop-usd',$usd_opt);
	update_option('wp-shop-eur',$eur_opt);

	$results=$wpdb->get_results("SELECT * FROM $wpdb->posts");

	foreach($results as $row)
	{
    $temp = get_post_custom($row->ID);
    
    foreach($temp as $key => $value)
    {
      if (preg_match('/usd_(\d+)/',$key,$ar))
      {
        $usd = get_post_meta($row->ID,"usd_{$ar[1]}",true);
        update_post_meta($row->ID,"cost_{$ar[1]}",$usd * $usd_opt) ;
      }
      if (preg_match('/eur_(\d+)/',$key,$ar))
      {
        $eur = get_post_meta($row->ID,"eur_{$ar[1]}",true);
        update_post_meta($row->ID,"cost_{$ar[1]}",$eur * $eur_opt);        
      }		
    }
  }
	die();
} 

function wp_shop_original_cart_save(){
	
	$wpshop_session_id	= session_id();
	$wpshop_item_id		= $_POST['wpshop_id'];
	$wpshop_key		= $_POST['wpshop_key'];
	$wpshop_name		= $_POST['wpshop_name'];
	$wpshop_href		= $_POST['wpshop_href'];
	$wpshop_cost		= $_POST['wpshop_cost'];
	$wpshop_num		= intval($_POST['wpshop_num']);
	$wpshop_sklad		= intval($_POST['wpshop_sklad']);
  
	#$wpshop_session_id	or die();
	#$wpshop_item_id		or die();
	#$wpshop_key			or die();
	#$wpshop_name		or die();
	#$wpshop_href		or die();
	#$wpshop_cost		or die();
	#$wpshop_num			or die();
	
	global $wpdb;
	$params = array(session_id(),$wpshop_item_id);
	$rows = $wpdb->get_results($wpdb->prepare( "SELECT count(*) as cnt FROM {$wpdb->prefix}wpshop_selected_items WHERE selected_items_session_id='%s' AND selected_items_id=%d", $params));
	$row = $rows[0];
	if ($row->cnt>0){
		$params_up = array($wpshop_num,session_id(),$wpshop_item_id);
		$wpdb->get_results($wpdb->prepare("UPDATE {$wpdb->prefix}wpshop_selected_items SET selected_items_num='%d' WHERE selected_items_session_id='%s' AND selected_items_id=%d",$params_up));
		echo 'edit';
	}else{
		$data = array(
		
			'selected_items_session_id'	=> $wpshop_session_id,
			'selected_items_item_id'	=> $wpshop_item_id,
			'selected_items_key'		=> $wpshop_key,
			'selected_items_name'		=> $wpshop_name,
			'selected_items_href'		=> $wpshop_href,
			'selected_items_cost'		=> $wpshop_cost,
			'selected_items_num'		=> $wpshop_num,
			'selected_items_sklad'		=> $wpshop_sklad
		);
		$wpdb->insert($wpdb->prefix.'wpshop_selected_items', $data);
		echo 'add';
	}
  die();
	
}

function wp_shop_original_cart_load(){
	global $wpdb;
	$params_load = array(session_id());
	$rows = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}wpshop_selected_items WHERE selected_items_session_id='%s'",$params_load));
	$n=0;
	$promo = 0;
	echo "window.__cart.a_thumbnail = [];\n";
	foreach ($rows as $row){
		echo "window.__cart.a_id[$n]   = \"$row->selected_items_id\";";
		echo "window.__cart.a_key[$n]  = \"$row->selected_items_key\";";
		echo "window.__cart.a_name[$n] = \"$row->selected_items_name\";";
		echo "window.__cart.a_href[$n] = \"$row->selected_items_href\";";
		echo "window.__cart.a_cost[$n] = \"$row->selected_items_cost\";";
		echo "window.__cart.a_num[$n]  = \"$row->selected_items_num\";";
		echo "window.__cart.a_sklad[$n]  = \"$row->selected_items_sklad\";";
		echo "window.__cart.a_promo[$n]  = \"$row->selected_items_promo\";";

		if($row->selected_items_promo !=0) {
			$promo = $row->selected_items_promo;
		}
		
		$thumbnail = get_post_meta($row->selected_items_item_id,'Thumbnail',true);
		$thumbnail1 = wp_get_attachment_url( get_post_thumbnail_id($row->selected_items_item_id) );
		if (!$thumbnail&&$thumbnail1) {
			$thumbnail = wp_get_attachment_url( get_post_thumbnail_id($row->selected_items_item_id) );
		}
		if (!$thumbnail&&!$thumbnail1) {
			$fetch_content = get_post($row->selected_items_item_id);
			$content_to_search_through = $fetch_content->post_content;
			$first_img = ”;
			ob_start();
			ob_end_clean();
			$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content_to_search_through, $matches);
			$first_img = $matches[1][0];

			if(empty($first_img)) {
				$first_img = “”;
			}
			$thumbnail = $first_img;
		}

		echo "window.__cart.a_thumbnail[$n]  = \"" . $thumbnail ."\";";
		echo "";
		$n++;
	}
	echo "window.__cart.count = $n;";
	
	if($promo !=0){
		$code = get_the_title($promo)*1;
		$value = get_post_meta($promo, 'wpshop_promo_value', true);
		$pers = get_post_meta($promo, 'wpshop_promo_pers', true);
		$message_promo = get_post_meta($promo, 'wpshop_promo_message', true);
		  
		echo "window.__cart.promo_code = \"$code\";";
		echo "window.__cart.promo_value = \"$value\";";
		echo "window.__cart.promo_pers = \"$pers\";";
		echo "window.__cart.promo_message = \"$message_promo\";";
	
	}
	//var_dump($rows);

	
  die();
}
?>