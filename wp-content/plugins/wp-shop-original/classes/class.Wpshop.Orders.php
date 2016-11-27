<?php 
class Wpshop_Orders
{
	private static $instance = null;
	private $statuses = array();

	private function __construct()
	{
		$this->statuses[0] = __('New', 'wp-shop'); // Новый
		$this->statuses[1] = __('Paid', 'wp-shop'); // Оплачено
		$this->statuses[2] = __('Cancelled', 'wp-shop'); // Отменено
		$this->statuses[3] = __('In the process', 'wp-shop'); // В обработке
		$this->statuses[4] = __('Delivered', 'wp-shop'); // Доставлено
		$this->statuses[5] = __('Archive', 'wp-shop'); // Архив
	}

	public static function getInstance()
	{
		if (self::$instance == null)
		{
			self::$instance = new Wpshop_Orders();
		}
		return self::$instance;
	}

	public function getStatuses()
	{
		return $this->statuses;
	}

	public function getStatus($id)
	{
		if (isset($this->statuses[$id]))
		{
			return $this->statuses[$id];
		}
		throw new Exception("The status with id {$id} not found.");
	}

	public function save($id,$data)
	{
		global $wpdb;
		$wpdb->update($wpdb->prefix."wpshop_orders", $data, array('order_id' => $id),array("%s"),array("%s"));
	}

	static public function setStatus($order_id,$status)
	{
		global $wpdb;
		$wpdb->update($wpdb->prefix."wpshop_orders", array('order_status'=>$status), array('order_id' => $order_id),array("%d"),array("%d"));
		$google = get_option("wpshop.google_analytic");
		if ($status == 1 && !empty($google)){
			$order = new Wpshop_Order($order_id);
			$full_price = $order->getTotalSum();
			$product = $order->getOrderItems($order_id);
			$delivery = $order->getDelivery();
			$data = array(
						  'info' => $product,
						  'price' => $full_price, // the price
						  't_num' => $order_id,
						  'shiping' => $delivery->cost
						);
			gaBuildHit( 'ecommerce', $data);	
		}
	}

	static public function getCartOrders() {
		global $wpdb;
		$rows = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wpshop_selected_items WHERE selected_items_session_id='".session_id()."'");
		return $rows;
	}
	
	static public function getStatus_order($order_id) {
		global $wpdb;
		$status = $wpdb->get_results("SELECT order_status FROM {$wpdb->prefix}wpshop_orders WHERE order_id='{$order_id}'");
		return $status;
	}
}
