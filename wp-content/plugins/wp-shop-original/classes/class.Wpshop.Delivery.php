<?php 

class Wpshop_Delivery_Data
{
	public $ID;
	public $cost;
	public $name;
}


class Wpshop_Delivery
{
	private static $instance = null;
	private $view;
	private $deliveries;
	public function __construct()
	{
		$deliv = get_option("wpshop.delivery");


		$this->deliveries[0] = new  Wpshop_Delivery_Data();
		$this->deliveries[0]->ID = "postByCountry";
		$this->deliveries[0]->name = __('Mail delivery across the country', 'wp-shop'); // Доставка почтой по стране
		$this->deliveries[0]->cost = $deliv['postByCountry']['cost'];

		$this->deliveries[1] = new  Wpshop_Delivery_Data();
		$this->deliveries[1]->ID = "postByWorld";
		$this->deliveries[1]->name = __('International mail delivery', 'wp-shop'); // Международная доставка почтой
		$this->deliveries[1]->cost = $deliv['postByWorld']['cost'];

		$this->deliveries[2] = new  Wpshop_Delivery_Data();
		$this->deliveries[2]->ID = "courier";
		$this->deliveries[2]->name = __('Delivery by courier', 'wp-shop'); // Доставка курьером
		$this->deliveries[2]->cost = $deliv['courier']['cost'];

		$this->deliveries[3] = new  Wpshop_Delivery_Data();
		$this->deliveries[3]->ID = "vizit";
		$this->deliveries[3]->name = __('A visit to the office', 'wp-shop'); // Визит в офис
		$this->deliveries[3]->cost = $deliv['vizit']['cost'];
		
		$this->deliveries[4] = new  Wpshop_Delivery_Data();
		$this->deliveries[4]->ID = "user";
		$this->deliveries[4]->name = __('User delivery', 'wp-shop'); // Пользовательская доставка
		wp_reset_postdata();
		$wp_query_user = new WP_Query(
		array(
				'post_type' => 'wpshop_user_delivery',
				'post_status' => 'publish',
				'posts_per_page' => -1 
			) 
		);
		$i = 5;
		while ($wp_query_user->have_posts()) : $wp_query_user->the_post(); 
			$cost_del = get_post_meta(get_the_ID(), 'cost_del', true);
			$del_name = get_the_title();
			$this->deliveries[$i] = new  Wpshop_Delivery_Data();
			$this->deliveries[$i]->ID = $del_name;
			$this->deliveries[$i]->name = $del_name;
			$this->deliveries[$i]->cost = $cost_del;
			$i++;
		endwhile; 
		wp_reset_postdata();
	}

	public static function getInstance()
	{
		if (self::$instance == null)
		{
			self::$instance = new Wpshop_Delivery();
		}
		return self::$instance;
	}

	public function deliveryAction()
	{
		if (isset($_POST['update']))
		{
			update_option("wpshop.delivery",$_POST['wpshop_delivery']);
		}


		$this->view = new Wpshop_View();
		$this->view->delivery = get_option("wpshop.delivery");
		$this->view->render('admin/delivery.php');
	}

	public function getDeliveries()
	{
		return $this->deliveries;
	}

	public function getDelivery($id)
	{
		foreach($this->deliveries as $delivery)
		{
			if ($delivery->ID == $id)
			{
				return $delivery;
			}
		}
		return null;
	}

}
