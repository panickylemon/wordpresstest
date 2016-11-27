<?php 

class Wpshop_Admin
{
	private $view;
	private static $count_orders_on_page = 50;
	public function __construct()
	{
		wp_enqueue_script('wpshop-admin', WPSHOP_URL .'/wp-shop-admin.js',array('jquery','jquery-ui-position'));
		add_action('admin_menu', array(&$this,'adminMenu'));

		// so... update
		if (isset($_POST['update_wpshop_settings']))
		{
			$this->updateSettingsPage();
		}

		$this->view = new Wpshop_View();
	}

	public function adminMenu()
	{
		if (function_exists('add_menu_page'))
		{
			add_menu_page( __('WP Shop Settings', 'wp-shop') , __('WP Shop', 'wp-shop'), 'edit_pages', 'wpshop_main'/*,array(&$this,'settingsAction')*/);
			add_submenu_page('wpshop_main', __('WP Shop Settings', 'wp-shop'),	__('WP Shop Settings', 'wp-shop'),	'edit_pages', 'wpshop_settings',array(&$this,'settingsAction'));
			add_submenu_page('wpshop_main', __('WP Shop Orders', 'wp-shop'),	__('WP Shop Orders', 'wp-shop'),	'read', 'wpshop_orders',array(&$this,'ordersAction'));
			add_submenu_page('wpshop_main', __('WP Shop Payments', 'wp-shop'),	__('WP Shop Payments', 'wp-shop'),	'edit_pages', 'wpshop_payments',array(&$this,'paymentsAction'));

			$delivery = new Wpshop_Delivery();

			add_submenu_page('wpshop_main', __('WP Shop Deliveries', 'wp-shop'), __('WP Shop Deliveries', 'wp-shop'), 'edit_pages', 'wpshop_delivery',array($delivery,'deliveryAction'));
			
		}
	}

	/**
	 *
	 */
	public function ordersAction()
	{
		global $wpdb;
		$post = $_GET;

		if (isset($_POST['mass_action']))
		{
			if( is_array($_POST['order_check'])) {
				foreach($_POST['order_check'] as $order_id)
				{
					Wpshop_Orders::setStatus($order_id,$_POST['orders_status']);
					//$wpdb->query("DELETE FROM `{$wpdb->prefix}wpshop_ordered` WHERE `ordered_pid` = {$order_id}");
					//$wpdb->query("DELETE FROM `{$wpdb->prefix}wpshop_orders` WHERE `order_id` = {$order_id}");
					
				}
			}
		}



		// List orders
		$id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : null;
		if (isset($_GET['act']) && $_GET['act'] == "edit")
		{
			if (!empty($id))
			{
				if (isset($_POST['order']['save']))
				{
					$data = array();
					$data['order_status'] = $_POST['order']['status'];
					$data['order_comment'] = $_POST['order']['comment'];
					$data['client_id'] = $_POST['order']['client_id'];
					Wpshop_Orders::getInstance()->save($id,$data);
					$google = get_option("wpshop.google_analytic");
					if ($data['order_status'] == 1 && !empty($google) ){
						$order = new Wpshop_Order($id);
						$full_price = $order->getTotalSum();
						$product = $order->getOrderItems($id);
						$delivery = $order->getDelivery();
						$data = array(
									  'info' => $product,
									  'price' => $full_price, // the price
									  't_num' => $id,
									  'shiping' => $delivery->cost
									);
						gaBuildHit( 'ecommerce', $data);
					}
				}
				$user = wp_get_current_user();
		
				if (array_key_exists('Customer',$user->allcaps) && !array_key_exists('Merchant',$user->allcaps)) {
					$condition = " AND client_id = {$user->data->ID}";
				}
				
				$this->view->order =  $wpdb->get_row("SELECT * FROM `{$wpdb->prefix}wpshop_orders` WHERE `order_id` = '{$id}' {$condition}");
				if($this->view->order){
					$param_order = array($id);
					$this->view->ordered = $wpdb->get_results($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}wpshop_ordered` WHERE `ordered_pid` = '%d'",$param_order));
				}
				$payment = Wpshop_Payment::getInstance()->getPaymentByID($this->view->order->order_payment);
				if ($payment)
				{
					$this->view->order->payment = $payment->name;
				}
				else
				{
					$this->view->order->payment = "";
				}
				if($this->view->order->order_id){
					$this->view->render("admin/orders.order.php");
				}else{
					echo "<script>window.location = 'wp-admin/admin.php?page=wpshop_orders'</script>";
				}
				return;
			}
		}

		if (isset($_GET['act']) && $_GET['act'] == "delete" && !empty($id))
		{
			$wpdb->query("DELETE FROM `{$wpdb->prefix}wpshop_ordered` WHERE `ordered_pid` = {$id}");
			$wpdb->query("DELETE FROM `{$wpdb->prefix}wpshop_orders` WHERE `order_id` = {$id}");
		}

		$this->view->page['current'] = empty($_GET['num_page']) ? 1 : $_GET['num_page'];
		$from = ($this->view->page['current']-1) * self::$count_orders_on_page;

		$sqlFilter = '';
		if (isset($post['filter_payment']) && $post['filter_payment']!='')
		{
			$sqlFilter .= " AND `order_payment` = '{$post['filter_payment']}' ";
		}

		if (isset($post['filter_status']) && $post['filter_status']!=-1)
		{
			$sqlFilter .= " AND `order_status` = '{$post['filter_status']}' ";
		}
		// не показывать по дефолту архив
		if (!isset($post['filter_status']) || $post['filter_status'] != 5)
		{
			$sqlFilter .= " AND `order_status` <> '5' ";
		}

		if (isset($post['filter_delivery']) && $post['filter_delivery'] != -1 )
		{
			$sqlFilter .= " AND `order_delivery` = '{$post['filter_delivery']}' ";
		}

		$date = array();
		$date['min']['timestamp'] = $wpdb->get_var("SELECT MIN(`order_date`) FROM `{$wpdb->prefix}wpshop_orders`");
		$date['min']['en'] = date("Y-m-d",$date['min']['timestamp']);
		$date['min']['ru'] = date("d.m.Y",$date['min']['timestamp']);
		$date['max']['timestamp'] = $wpdb->get_var("SELECT MAX(`order_date`) FROM `{$wpdb->prefix}wpshop_orders`");
		$date['max']['en'] = date("Y-m-d",$date['max']['timestamp']);
		$date['max']['ru'] = date("d.m.Y",$date['max']['timestamp']);

		if (isset($post['filter_date_from']))
		{
			try
			{
				$this->view->filter_date_from = Wpshop_Utils::checkDate('ru',$post['filter_date_from']);
				$sqlFilter .= " AND `order_date` >= '" . strtotime(Wpshop_Utils::checkDate('en',$post['filter_date_from'])) . "' ";
			}
			catch(Exception $e)
			{
				$this->view->filter_date_from = $date['min']['ru'];
			}
		}
		else
		{
			$this->view->filter_date_from = $date['min']['ru'];
		}

		if (isset($post['filter_date_to']))
		{
			try
			{
				$this->view->filter_date_to = Wpshop_Utils::checkDate('ru',$post['filter_date_to']);
				$sqlFilter .= " AND `order_date` <= '" . strtotime(Wpshop_Utils::checkDate('en',$post['filter_date_to']). " 23:59:59") . "' ";
			}
			catch(Exception $e)
			{
				$this->view->filter_date_to = $date['max']['ru'];
			}
		}
		else
		{
			$this->view->filter_date_to = $date['max']['ru'];
		}

		/*Сообщает о новом пользователе*/
		$user = wp_get_current_user();
		
		if (array_key_exists('Customer',$user->allcaps) && !array_key_exists('Merchant',$user->allcaps)) {
			$condition = " AND client_id = {$user->data->ID}";
		}

		$this->view->orders = $wpdb->get_results("SELECT SQL_CALC_FOUND_ROWS * FROM `{$wpdb->prefix}wpshop_orders` WHERE 1 {$condition}{$sqlFilter} ORDER BY `order_date` DESC LIMIT {$from},".self::$count_orders_on_page);
		$this->view->post = $post;
		$this->view->page['count'] = ceil($wpdb->get_var("SELECT FOUND_ROWS();") / self::$count_orders_on_page);
		$this->view->render("admin/orders.php");
	}

	public function settingsAction()
	{
		global $wpdb;		
		if (!get_option("wpshop.cartpage")) {
			$rows = current($wpdb->get_results("SELECT * FROM `{$wpdb->prefix}posts` WHERE post_content LIKE '%[cart]%'"));
			if ($rows) {			
				update_option("wpshop.cartpage",get_permalink($rows->ID));
			}
		}		


		$cform = get_option('wp-shop_cform');
		$css = get_option('wp-shop_cssfile');

		$this->view->usd_cur = get_option('wp-shop-usd');
		$this->view->eur_cur = get_option('wp-shop-eur');
		$this->view->payments_activate = get_option('wpshop.payments.activate');
    
		$this->view->mail_activate = get_option('wpshop.mail_activate');
		$this->view->show_panel_activate = get_option('wpshop.show_panel');
		$this->view->wpshop_sort_price_type = get_option('wpshop.sort_price');

		$this->view->opt_under_title = get_option('wpshop_price_under_title');
		$this->view->position = get_option('wp-shop_position');
		$this->view->showCost = get_option('wp-shop_show-cost');
    $this->view->promoActive = get_option('wp-shop_promo_active');
    
		$this->view->f_order = __('Order', 'wp-shop');
		$this->view->discount = get_option('wpshop.cart.discount');
		$this->view->minzakaz = get_option('wpshop.cart.minzakaz');
		$this->view->minzakaz_info = get_option('wpshop.cart.minzakaz_info');
		$this->view->deliveyrCondition = get_option('wpshop.cart.deliveyrCondition','#');
		$this->view->shopping_return_link = get_option('wpshop.cart.shopping_return_link','#');
		$this->view->email = get_option("wpshop.email");
		$this->view->email_name = get_option("wpshop.email_name");
		$this->view->google_analytic = get_option("wpshop.google_analytic");
    $this->view->partner_param = get_option("wpshop.partner_param");
		$this->view->yandex_metrika = get_option("wpshop.yandex_metrika");
		$this->view->google_analytic_cc = get_option("wpshop.google_analytic_cc");
		$this->view->hide_auth = get_option("wpshop.hide_auth");
		$this->view->noGoodText = get_option("wpshop.good.noText");
		$this->view->currency = get_option("wpshop.currency");
		$this->view->cartpage_link = get_option("wpshop.cartpage",'{sitename}/cart');
		//$this->view->loginza_widget_id = get_option("wpshop.loginza.widget_id");
		//$this->view->loginza_secret_key = get_option("wpshop.loginza.secret_key");


		$cforms = Wpshop_Forms::getInstance()->getForms();
		$this->view->cforms = array();
		foreach($cforms as $i => $value)
		{
			if ($cforms[$i]['name'] == $cform)
			{
				$cforms[$i]['selected'] = 'selected="selected"';
			}
			else
			{
				$cforms[$i]['selected'] = '';
			}
			$this->view->cforms[] = $cforms[$i];
		}

		$file_list = '';
		$dir = WPSHOP_DIR . "/styles/";

		if ($dh = opendir($dir))
		{
			while (($file = readdir($dh)) !== false)
			{
				if ($file != '.' AND $file != '..')
				{
					$current_file = "{$dir}{$file}";
					if (is_file($current_file))
					{
						$selected = '';
						if ($css == $file)
						{
							$selected = " selected";
						}
						$file_list .= "<option value=\"{$file}\"$selected>{$file}</option>";
					}
				}
			}
		}
		$this->view->file_list = $file_list;
		$this->view->link_to_yml = get_option('siteurl') . "/?wpshop_yml";

		$this->view->render("admin/settings.php");
	}


	public function updateSettingsPage()
	{
		update_option("wp-shop_cssfile",$_POST['cssfile']);
		
		$wpshop_partner_param = sanitize_text_field($_POST['wpshop_partner_param']);
		update_option("wpshop.partner_param",$wpshop_partner_param);
		
		update_option("wp-shop_cform",$_POST['cform']);
		update_option("wp-shop_position",$_POST['position']);
		
		$discount = sanitize_text_field($_POST['discount']);
		update_option("wpshop.cart.discount",$discount);
		
		$email = sanitize_email($_POST['wpshop_email']);
		update_option("wpshop.email",$email);
		
		$email_name = sanitize_text_field($_POST['wpshop_email_name']);
		update_option("wpshop.email_name",$email_name);
		
		$wpshop_google_analytic = sanitize_text_field($_POST['wpshop_google_analytic']);
		update_option("wpshop.google_analytic",$wpshop_google_analytic);
		
		$wpshop_yandex_metrika = sanitize_text_field($_POST['wpshop_yandex_metrika']);
		update_option("wpshop.yandex_metrika",$wpshop_yandex_metrika);
		
		update_option("wpshop.google_analytic_cc",$_POST['wpshop_google_analytic_cc']);
		
		update_option("wpshop.hide_auth",$_POST['wpshop_hide_auth']);
		
		update_option("wpshop.show_panel",$_POST['wpshop_show_panel']);
		
		update_option("wpshop.sort_price",$_POST['wpshop_sort_price']);
		
		
		$deliveyrCondition = sanitize_text_field($_POST['deliveyrCondition']);
		update_option("wpshop.cart.deliveyrCondition",$deliveyrCondition);
		
		$shopping_return_link = sanitize_text_field($_POST['shopping_return_link']);
		update_option("wpshop.cart.shopping_return_link",$shopping_return_link);
		
		$minzakaz = sanitize_text_field($_POST['minzakaz']);
		update_option("wpshop.cart.minzakaz",$minzakaz);
		
		$currency = strip_tags($_POST['currency'],'<span></span><em></em><p></p><a></a><strong></strong><br>');
		update_option("wpshop.currency",$currency);
		
		$noGoodText = strip_tags($_POST['noGoodText'],'<span></span><em></em><p></p><a></a><strong></strong><br>');
		update_option("wpshop.good.noText",$noGoodText);
		
		$minzakaz_info = sanitize_text_field($_POST['minzakaz_info']);
		update_option("wpshop.cart.minzakaz_info",$minzakaz_info);
		
		
		
		$cartpage_link = sanitize_text_field($_POST['cartpage_link']);
		update_option("wpshop.cartpage",$cartpage_link);
		
		//update_option("wpshop.loginza.widget_id",$_POST['wpshop_loginza_widget_id']);
		//update_option("wpshop.loginza.secret_key",$_POST['wpshop_loginza_secret_key']);

		if (isset($_POST['wpshop_payments_activate']))
		{
			update_option("wpshop.payments.activate",1);
		}
		else
		{
			update_option("wpshop.payments.activate",0);
		}
    
    if (isset($_POST['wpshop_mail_activate']))
		{
			update_option("wpshop.mail_activate",1);
		}
		else
		{
			update_option("wpshop.mail_activate",0);
		}
		
	if (isset($_POST['wp-shop_show-cost']))
		{
			update_option("wp-shop_show-cost",1);
		}
		else
		{
			update_option("wp-shop_show-cost",0);
		}
    
    if (isset($_POST['wp-shop_promo_activate']))
		{
			update_option("wp-shop_promo_active",1);
		}
		else
		{
			update_option("wp-shop_promo_active",0);
		}
	}

	public function paymentsAction()
	{
		if (isset($_POST['update_payments']))
		{
			$this->updatePayments();
		}
		$this->view->wm = get_option("wpshop.payments.wm");
		$this->view->yandex_kassa = get_option("wpshop.payments.yandex_kassa");
		$this->view->merchant = get_option("wpshop_merchant");
		$this->view->merchant_system = get_option("wpshop_merchant_system");
		$this->view->cforms = Wpshop_Forms::getInstance()->getForms();
		$this->view->cash = get_option("wpshop.payments.cash");
		$this->view->robokassa = get_option("wpshop.payments.robokassa");
		$this->view->paypal = get_option("wpshop.payments.paypal");
    $this->view->simplepay = get_option("wpshop.payments.simplepay");
    $this->view->chronopay = get_option("wpshop.payments.chronopay");
		$this->view->vizit = get_option("wpshop.payments.vizit");
		$this->view->post = get_option("wpshop.payments.post");
		$this->view->ek = get_option("wpshop.payments.ek");
		$this->view->deliveries = Wpshop_Delivery::getInstance()->getDeliveries();

		//Новая схема, сохранения данных, берем и кладем опции использую обыкновенных массивы
		$this->view->bank = get_option("wpshop.payments.bank");


		$this->view->render("admin/payments.php");
	}
	
	public function updatePayments()
	{
		//merchant
		if (!isset($_POST['wpshop_merchant']))
		{
			$_POST['wpshop_merchant'] = 0;
		}
		update_option("wpshop_merchant",$_POST['wpshop_merchant']);
		
		//merchant_sys
		update_option("wpshop_merchant_system",$_POST['wpshop_merchant_system']);
		
		//Web money
		if (!isset($_POST['wpshop_payments_wm']['activate']))
		{
			$_POST['wpshop_payments_wm']['activate'] = 0;
		}
		update_option("wpshop.payments.wm",$_POST['wpshop_payments_wm']);
		
		//yandex_kassa
		if (!isset($_POST['wpshop_payments_yandex_kassa']['activate']))
		{
			$_POST['wpshop_payments_yandex_kassa']['activate'] = 0;
		}
		update_option("wpshop.payments.yandex_kassa",$_POST['wpshop_payments_yandex_kassa']);

		//Наложный платеж
		if (!isset($_POST['wpshop_payments_cash']['activate']))
		{
			$_POST['wpshop_payments_cash']['activate'] = 0;
		}
		update_option("wpshop.payments.cash",$_POST['wpshop_payments_cash']);


		//Банк
		if (!isset($_POST['wpshop_payments_bank']['activate']))
		{
			$_POST['wpshop_payments_bank']['activate'] = 0;
		}
		update_option("wpshop.payments.bank",$_POST['wpshop_payments_bank']);

		//Робокасса
		update_option("wpshop.payments.robokassa",$_POST['wpshop_payments_robokassa']);

		//PayPal
		if (!isset($_POST['wpshop_payments_paypal']['activate']))
		{
			$_POST['wpshop_payments_paypal']['activate'] = 0;
		}
		update_option("wpshop.payments.paypal",$_POST['wpshop_payments_paypal']);
    
    //Simplepay
		if (!isset($_POST['wpshop_payments_simplepay']['activate']))
		{
			$_POST['wpshop_payments_simplepay']['activate'] = 0;
		}
		update_option("wpshop.payments.simplepay",$_POST['wpshop_payments_simplepay']);
    
    //Chronopay
		if (!isset($_POST['wpshop_payments_chronopay']['activate']))
		{
			$_POST['wpshop_payments_chronopay']['activate'] = 0;
		}
		update_option("wpshop.payments.chronopay",$_POST['wpshop_payments_chronopay']);
		
		//PayPal
		if (!isset($_POST['wpshop_payments_paypal']['test']))
		{
			$_POST['wpshop_payments_paypal']['test'] = 0;
		}
		update_option("wpshop.payments.paypal",$_POST['wpshop_payments_paypal']);
    
    //Simplepay
		if (!isset($_POST['wpshop_payments_simplepay']['test']))
		{
			$_POST['wpshop_payments_simplepay']['test'] = 0;
		}
		update_option("wpshop.payments.simplepay",$_POST['wpshop_payments_simplepay']);
		
		//Chronopay
		if (!isset($_POST['wpshop_payments_chronopay']['order']))
		{
			$_POST['wpshop_payments_chronopay']['order'] = 0;
		}
		update_option("wpshop.payments.chronopay",$_POST['wpshop_payments_chronopay']);
		
		//EK
		update_option("wpshop.payments.ek",$_POST['wpshop_payments_ek']);

		//Наложный платеж
		if (!isset($_POST['wpshop_payments_vizit']['activate']))
		{
			$_POST['wpshop_payments_vizit']['activate'] = 0;
		}
		update_option("wpshop.payments.vizit",$_POST['wpshop_payments_vizit']);

		//Визит в наш офис
		if (!isset($_POST['wpshop_payments_post']['activate']))
		{
			$_POST['wpshop_payments_post']['activate'] = 0;
		}
		update_option("wpshop.payments.post",$_POST['wpshop_payments_post']);
	}
}
