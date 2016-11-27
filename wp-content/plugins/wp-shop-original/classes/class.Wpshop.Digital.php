<?php 

class Wpshop_Digital {
	public function __construct() {
		
		if (isset($_GET['wpdownload'])) {
			if (self::checkLink($_GET['wpdownload'],$_GET['order_id'])) {
				$order = self::getDigitalOrder(self::getAuthorized(),$_GET['wpdownload'],$_GET['order_id']);
				self::DecrementOrder($order);
				$digital_file = self::getDigitalLink($_GET['wpdownload']);
				header("Content-Disposition: attachment; filename=" . basename($digital_file));
				header("Content-Transfer-Encoding: binary");					
				$fp = fopen($digital_file,"rb");
				fpassthru($fp);
				
			} else {
				echo "Access denied";
			}
			exit();
		}
	}

	public static function DecrementOrder($ordered) {
		global $wpdb;
		if ($ordered->ordered_digit_count > 0) {
			$wpdb->query("UPDATE `{$wpdb->prefix}wpshop_ordered` SET ordered_digit_count = ordered_digit_count-1 WHERE ordered_id = $ordered->ordered_id");
		}
	}

	public static function getDigitalOrder($clientid,$postID,$order_id) {
		global $wpdb;
		
		if ($order_id == null){
			$param_digit = array($clientid,$postID);
			$rows = $wpdb->get_results($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}wpshop_orders` INNER JOIN `{$wpdb->prefix}wpshop_ordered` ON (ordered_pid = order_id) WHERE `client_id` = '%d' AND `ordered_page_id` = '%d'",$param_digit));
		}else {
			$param_digit1 = array($clientid,$postID,$order_id);
			$rows = $wpdb->get_results($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}wpshop_orders` INNER JOIN `{$wpdb->prefix}wpshop_ordered` ON (ordered_pid = order_id) WHERE `client_id` = '%d' AND `ordered_page_id` = '%d' AND `order_id` = %d",$param_digit1));
		}
		
		if (count($rows)) return current($rows);
		return false;
	}

	public static function checkLink($postID,$order_id = null) {
		$user_id = self::getAuthorized();
		if ($user_id) {
			$digital_file = self::getDigitalLink($postID);
			if (empty($digital_file)) return false;
			$order = self::getDigitalOrder($user_id,$postID,$order_id);
			if ($order->order_status != 1) return false;			
			if ($order->ordered_digit_count == -1 || $order->ordered_digit_count > 0) {
				if ($order->ordered_digit_count == -1) return true;
				if ($order->ordered_digit_live == -1) return true;
				$leftTime =  ($order->ordered_digit_live * 60 * 60) + $order->order_date - time(); 
				if ($leftTime > 0 ) return true;
				return false;
			}
			return false;
		}
		return false;
	}

	public static function getDigitalLink($postID) {
		return get_post_meta($postID,"digital_link",true);
	}

	public static function getAuthorized() {
		// Insert pluggable.php before calling get_currentuserinfo()
		require (ABSPATH . WPINC . '/pluggable.php');
		global $current_user;
		get_currentuserinfo();
		$user_id = $current_user->ID;
		if ($user_id) return $user_id;
		return false;
	}
}
