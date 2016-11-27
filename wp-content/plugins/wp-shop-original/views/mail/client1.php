<?php 

$message .="
<table style='width:100%'>
<tr style='background-color:#CCCCCC'>
<th>". __('Name', 'wp-shop')."</th><th>&nbsp;</th><th>" . __('Price', 'wp-shop') . "</th><th>" . __('Qty', 'wp-shop')."</th><th>" . __('Sum', 'wp-shop') . "</th></tr>";?>
<?php
$key = 0;
$price = 0;
foreach($this->order['offers'] as $offer)
{
	$price = round($offer['partnumber'] * $offer['price'],2);
	$itogo += $price;
	if ($key++ % 2) $color = "white";
	else $color = "#DDDDDD";
	$message .= "<tr style='background-color:{$color};'>
		<td><a href='".get_permalink($offer['post_id'])."'>{$offer['name']}</a></td>
		<td>{$offer['key']}</td>
		<td style='text-align:center'>{$offer['price']}</td>
		<td style='text-align:center'>{$offer['partnumber']}</td>
		<td style='text-align:center'>{$price}</td>
	</tr>";
}
?>
<?php $message .="<tr><td colspan='3'>" . __('Total:', 'wp-shop') . "</td><td>{$itogo}</td></tr>";?>
<?php 

if ($this->order['info']['discount'])
{
	$itogo = round($itogo - $itogo / 100 * $this->order['info']['discount'],2);
	$message .= "<tr><td colspan='3'>".__('Price with discount', 'wp-shop') . " ({$this->order['info']['discount']}%)</td><td>{$itogo}</td></tr>";
}

if ($this->order['info']['promo'])
{
	echo "<tr><td colspan='3'>".__('Promocode: ', 'wp-shop').$this->order['info']['promo']."</td></tr>";
}


$delivery = Wpshop_Delivery::getInstance()->getDelivery($this->order['info']['delivery']);
if ($delivery) {
	$itogo += $delivery->cost;
	$message .= "<tr><td colspan='3'>" . __("Delivery", "wp-shop") . " ({$delivery->name})</td><td>{$delivery->cost}</td></tr>";
}
?>
<?php $message .= "<tr><td colspan='3'>" . __('In all', 'wp-shop') . ":</td><td>{$itogo}</td></tr></table>";?>


<?php wp_reset_query();?>
<?php
		wp_reset_postdata();
		$wp_query_mail = new WP_Query(
		array(
				'post_type' => 'wpshop_client_mail',
				'post_status' => 'publish',
				'posts_per_page' => 1,
				'tax_query' => array(
					array(
						'taxonomy' => 'mail_type',
						'field' => 'name',
						'terms' => $this->order['info']['payment']
					)
				),
				'caller_get_posts'=> 1
				
			) 
		);	
		while ($wp_query_mail->have_posts()) : $wp_query_mail->the_post(); 
			
			
			$content = get_the_content();
			$content = str_replace( '[wpshop_email]', $this->order['info']['email'] , $content );
			$content = str_replace( '[wpshop_username]', $this->order['info']['username'] , $content );
			$content = str_replace( '[wpshop_order_id]', $this->id , $content );
			$content = str_replace( '[wpshop_orders]', $message , $content );
			$content = str_replace( '[wpshop_total]', $this->order['info']['total'] , $content );
			echo $content;
		endwhile;  
		wp_reset_postdata();

?>		
