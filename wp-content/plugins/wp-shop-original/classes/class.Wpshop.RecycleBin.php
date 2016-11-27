<?php 

class Wpshop_RecycleBin
{
	private $view;
	static private $instance = null;
	private $orderDataTmp = null;

	public function getLastOrder()
	{
		if ($this->orderDataTmp == null)
		{
			echo "no";
			//throw Exception("no saving order");
		}
		return $this->orderDataTmp;
	}

	static public function getInstance()
	{
		if (self::$instance == null)
		{
			self::$instance = new Wpshop_RecycleBin();
		}
		return self::$instance;
	}

	private function __construct()
	{
		$this->view = new Wpshop_View();
		add_filter('the_content', array(&$this,"recycleBinAction"));
	}

	/**
	 * Функция сохраняет заказ!!!
	 *
	 * @param array $orders заказы переданные в массиве
	 * @return boolean
	 */
	public function saveOrder(Array $orders) {
		global $wpdb;
		/**
		 * @todo Действие очищает корзину в обычном режиме
		 */
     
      
		if (!get_option("wpshop.payments.activate"))
		{
			$this->view->render('js.inc.clearCart.php');
		}
    
     
    
		$currentUser = wp_get_current_user();

		$status = 0;
		$wpdb->insert( "{$wpdb->prefix}wpshop_orders", array( 'order_date' => time(),'order_discount' => $orders['info']['discount'],
'order_payment' => $orders['info']['payment'],
															  'client_name' => $orders['info']['username'],
															  'client_email' => $orders['info']['email'],
															  'client_ip' => $orders['info']['ip'],
                                'client_id' => $currentUser->ID,
															  'order_status' => $status,
															  'order_delivery' => $orders['info']['delivery'],
															  'order_comment' => $orders['info']['comment'],
                                'order_promo' => $orders['info']['promo']
															  ),
													   array('%d','%d','%s','%s','%s','%s','%d','%d','%s','%s','%d') );


		$pid = $wpdb->insert_id;
         
		$this->orderDataTmp = $orders;
		$this->orderDataTmp['id'] = $pid;

		foreach($orders['orders'] as $order) {
			$digitCount = get_post_meta($order->selected_items_item_id,"digital_count",true);		
			if (empty($digitCount)) {
				$digitCount = -1;
			}
			$digitLive = get_post_meta($order->selected_items_item_id,"digital_live",true);
			if (empty($digitLive)) {
				$digitLive = -1;
			}			
			$wpdb->insert("{$wpdb->prefix}wpshop_ordered" , array( 'ordered_pid' => $pid, 'ordered_name' => $order->selected_items_name, 'ordered_cost' => $order->selected_items_cost,'ordered_count' => $order->selected_items_num,'ordered_key' => $order->selected_items_key,'ordered_page_id'=>$order->selected_items_item_id,'ordered_digit_count'=>$digitCount,'ordered_digit_live'=>$digitLive) , array( "%d" , "%s", "%f", "%d", "%s","%d","%d","%d"));
		}		
    
     if (get_option("wpshop.partner_param")){
      $partner_id = get_option("wpshop.partner_param");
      $ref= get_bloginfo('url');
      $ch = curl_init();  
      curl_setopt($ch, CURLOPT_URL, "http://partner.mbgenerator.ru/affiliate/goto_offer/{$partner_id}");
      curl_setopt($ch, CURLOPT_HEADER, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_REFERER, $ref);
        
      $response = curl_exec($ch);
      $info = curl_getinfo($ch);
      curl_close($ch);  
      $headers = array();

      $header_text = substr($response, 0, strpos($response, "\r\n\r\n"));

      foreach (explode("\r\n", $header_text) as $i => $line){
        if ($i === 0){
           $headers['http_code'] = $line;
        } else {
          list ($key, $value) = explode(': ', $line);
          $headers[$key] = $value;
        }
      }
      
      $location = explode("?h=", $headers["Location"]);
      $hesh = $location[1];
     
      $itogo = 0;
      foreach($orders['offers'] as $offer) {
        $price = round($offer['partnumber'] * $offer['price'],2);
        $itogo += $price;
      }
      if ($orders['info']['discount'])
      {
        $itogo = round($itogo - $itogo / 100 * $orders['info']['discount'],2);
      }
      $delivery = Wpshop_Delivery::getInstance()->getDelivery($orders['info']['delivery']);
      if ($delivery) {
        $itogo += $delivery->cost;
      } 
      
     
   
      $url = "http://partner.mbgenerator.ru/affiliate/track_by_hash/{$hesh}/{$pid}/{$itogo}/"; 
      $ch = curl_init();  
      curl_setopt($ch, CURLOPT_URL,$url); // set url to post to  
      curl_setopt($ch, CURLOPT_FAILONERROR, 1);  
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// allow redirects  
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable  
      curl_setopt($ch, CURLOPT_TIMEOUT, 3); // times out after 4s  
      curl_setopt($ch, CURLOPT_REFERER, $ref);
      $result = curl_exec($ch); // run the whole process 
      curl_close($ch);  
    }
    
		ob_start();
		$this->view->order = $orders;
		$this->view->id = $pid;
		$this->view->render("mail/admin.php");
		// отправка почты администратору
		$email = get_option("wpshop.email");
		$user_name = get_option("wpshop.email_name");
		if($user_name) {
			$email_result=$user_name.' <'.$email.'>';
		}else {
			$email_result=$email;
		}
		$siteurl = get_bloginfo('wpurl');
		wp_mail($email, __('New Order','wp-shop')." #{$pid} ".__('from site','wp-shop')." {$siteurl}", ob_get_clean(),"Content-type: text/html; charset=UTF-8
Reply-To: {$email_result}
From:{$email_result}");

		ob_start();
		$this->view->order = $orders;
		
    if (!get_option("wpshop.mail_activate")){
		$this->view->render("mail/client.php");
    }else{
      $this->view->render("mail/client1.php");
    }
		wp_mail($orders['info']['email'], "Re: ".__('Your order','wp-shop')."  #{$pid} ".__('from site','wp-shop')." {$siteurl}", ob_get_clean(),"Content-type: text/html; charset=UTF-8
Reply-To: {$email_result}
From: {$email_result}");

		if ($payment)
		{
			$this->paymentAction($payment);
		}
		return true;
	}

	public function recycleBinAction($content)
	{
		global $post;
		global $wpdb;
		$ses = session_id();
		if ($post->post_excerpt == "wm_success")
		{
			ob_start();
			$this->view->render("js.inc.clearCart.php");
			$content = $content . ob_get_clean();
		}
		
		if ($post->post_excerpt == "yandex_kassa_success")
		{
			ob_start();
			$this->view->render("js.inc.clearCart.php");
			$content = $content . ob_get_clean();
		}

		if ($post->post_excerpt == "robokassa_success")
		{
			ob_start();
			$this->view->render("js.inc.clearCart.php");
			$content = $content . ob_get_clean();
		}
		
		if ($post->post_excerpt == "ek_success")
		{
			ob_start();
			$this->view->render("js.inc.clearCart.php");
			$content = $content . ob_get_clean();
		}
    
    if ($post->post_excerpt == "simplepay_success")
		{
			ob_start();
			$this->view->render("js.inc.clearCart.php");
			$content = $content . ob_get_clean();
		}
		
		if ($post->post_excerpt == "chronopay_success")
		{
			ob_start();
			$this->view->render("js.inc.clearCart.php");
			$content = $content . ob_get_clean();
			
			$wpdb->query("DELETE FROM {$wpdb->prefix}wpshop_selected_items WHERE selected_items_session_id='{$ses}'");
		}
		$this->view->dataSend = Wpshop_Forms::isDataSend();

		$this->view->cartCols = array(
									'name' => get_post_meta($post->ID,'cart_col_name',true),
									'price' => get_post_meta($post->ID,'cart_col_price',true),
									'count' => get_post_meta($post->ID,'cart_col_count',true),
									'sum' => get_post_meta($post->ID,'cart_col_sum',true),
									'type' => get_post_meta($post->ID,'cart_col_type',true)
								);
		if (get_option('wpshop.payments.activate'))
		{
			$count = 0;
			$this->view->payments = Wpshop_Payment::getInstance()->getPayments();
			foreach($this->view->payments as $key => $value)
			{
				$this->view->payments[$key]->data = get_option("wpshop.payments.{$value->paymentID}");
				$query = new WP_Query( array( 'post_type' => 'wpshopcarts', 'posts_per_page' => -1));
				foreach($query->posts as $tutu)
				{
					if ($tutu->post_excerpt == $this->view->payments[$key]->paymentID)
					{
						$this->view->payments[$key]->data['cart_url'] = get_permalink($tutu->ID);
						break;
					}
				}
				
			}
		}

		$this->view->minzakaz = get_option('wpshop.cart.minzakaz');
		$this->view->discount = get_option('wpshop.cart.discount');
		$this->view->minzakaz_info = get_option('wpshop.cart.minzakaz_info');
		$this->view->cform = get_option('wp-shop_cform');
		$this->view->delivery = Wpshop_Delivery::getInstance()->getDeliveries();

		ob_start();
		if (Wpshop_Forms::isDataSend())
		{
			/** Получаем сделанный заказ */
			$this->view->order = Wpshop_RecycleBin::getInstance()->getLastOrder();

			/** Проверяем оплачено ли через Web-Money,EK, Robokassa и если да, то устанавливаем нужные переменные */
			if ($this->view->order['info']['payment'] == "wm")
			{
				$this->view->wm = get_option("wpshop.payments.wm");
			}
			if ($this->view->order['info']['payment'] == "yandex_kassa")
			{
				$this->view->yandex_kassa = get_option("wpshop.payments.yandex_kassa");
			}
			if ($this->view->order['info']['payment'] == "robokassa")
			{
				$this->view->robokassa = get_option("wpshop.payments.robokassa");
			}
			if ($this->view->order['info']['payment'] == "ek")
			{
				$this->view->ek = get_option("wpshop.payments.ek");
			}
			if ($this->view->order['info']['payment'] == "paypal")
			{
				$this->view->paypal = get_option("wpshop.payments.paypal");
			}
      if ($this->view->order['info']['payment'] == "simplepay")
			{
				$this->view->simplepay = get_option("wpshop.payments.simplepay");
			}
			if ($this->view->order['info']['payment'] == "chronopay")
			{
				$this->view->chronopay = get_option("wpshop.payments.chronopay");
			}
      
			$this->view->render("RecycleBinAfterSend.php");
		}
		else
		{
			
			$form = Wpshop_Forms::getInstance()->getFormByName($cform_name);
			$this->view->render("RecycleBin.php");
		}
		return str_replace(CART_TAG, ob_get_clean(), $content);
	}

	public function paymentAction($payment)
	{
		$totalSum = 0;
		foreach($this->orderDataTmp['offers'] as $good)
		{
			$totalSum += $good['price'];
		}

		if ($payment == "wm")
		{
			$this->view->payment_no = $this->orderDataTmp['id'];
			$this->view->amount = $totalSum;
			$this->view->render("wm.redirect.php");
		}
				
	}

	public static function getCformsName($POSTData) {
		if (isset($POSTData['payment']) && !empty($POSTData['payment'])) {
			$cform_name = "wpshop-" . $POSTData['payment'];
		} else {	
			$cform_name = get_option("wp-shop_cform");
		}
		return $cform_name;
	}

	public static function actionOrder($POSTData) {		
    
		$cform_name = self::getCformsName($POSTData);
		$orders = Wpshop_Orders::getCartOrders();
		
		/*@TODO проверить хранится ли скидка еще здесь*/		
		$discount = $_COOKIE['wpshop_discount'];
		$sum = 0;
    
		$allInfo = array();
    $promo = 0;
		foreach($orders as $key => $order) {
			$offers = &$allInfo['offers'][];
			$offers['name'] = $order->selected_items_name;
			$offers['price'] = $order->selected_items_cost;
			if ($order->selected_items_promo != 0){
				$promo = $order->selected_items_promo;
				$sum += round((100-$promo)*$order->selected_items_cost/100,2) * $order->selected_items_num;
			}else{
				$sum += $order->selected_items_cost * $order->selected_items_num;	
			}
			$offers['partnumber'] = $order->selected_items_num;
			$offers['key'] = $order->selected_items_key;
			$offers['post_id'] = $order->selected_items_item_id;
			//$offers['color'] = '';
			//$offers['size'] = '';
		}
		
		if (!empty($discount)) {
			$final = round((100-$discount)*$sum/100,2);
		}else {
			$final = round((100-$discount)*$sum/100,2);
		}

		// Отсюда начинаем работу с данными формы
		$allInfo['info'] = array();
		$allInfo['info']['payment'] = $POSTData['payment'];
    $allInfo['info']['promo'] = get_the_title($promo)*1;
		$allInfo['info']['ip'] = $_SERVER['REMOTE_ADDR'];
		$allInfo['info']['discount'] = $_COOKIE['wpshop_discount'];
		$allInfo['info']['delivery'] = $POSTData['delivery'];
		$allInfo['info']['total'] = $final;
		$allInfo['orders'] = $orders;
		
		$form = Wpshop_Forms::getInstance()->getFormByName($cform_name);

		$mainComment = "";

		foreach($form['fields'] as $field) {
			$mainComment .= "{$field['name']} - {$POSTData[$field['postName']]}\n";
			// Определяем E-mail
			if ($field['email']) {
				$allInfo['info']['email'] = $POSTData[$field['postName']];
			}

		/* 	if ($field['order']) {
				$POSTData[$field['postName']] = $final;
			} */

			if ($field['type'] == "Name") {
				$allInfo['info']['username'] = $POSTData[$field['postName']];
			}
			// Комментарий к заказу
			$allInfo['info']['comment'] = "";
			if ($field['type'] == '$textarea') {
				$allInfo['info']['comment'] = $POSTData[$field['postName']];
			}
			/**
			 * @todo отменить отправку кода с картинки и ненужные скрыте поля
			 */
			if ($field['name'] != Wpshop_Forms::getInstance()->getRightField() && $field['type'] != '$fieldsetstart' && $field['type'] != '$captcha') {
				$row = &$allInfo['cforms'][];
				$row['name'] = $field['name'];
				$row['value'] = $POSTData[$field['postName']];
			}
		}

		$allInfo['info']['comment'] = $mainComment;
    if (get_option("wpshop.partner_param")&&get_option("wpshop.partner_param")!=''){
      if ($allInfo['info']['total']){
        self::getInstance()->saveOrder($allInfo);
        return $POSTdata;
      } else {
        exit();
      }
		} else {
      self::getInstance()->saveOrder($allInfo);
      return $POSTdata;
    }
	}
}
