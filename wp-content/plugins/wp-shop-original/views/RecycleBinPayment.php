<script type="text/javascript">
jQuery(function()
{
	jQuery(".cform").prepend("<input type='hidden' name='delivery' value=''/>");
	window.__cart.afterChange();
	window.__cart.afterChange1();
});
</script>
<br/>
<?php 
echo "<span class='choose_del'>";
echo __('Choose a delivery method:', 'wp-shop'); //Выберите способ доставки:
echo "</span>";
?>

<?php 
$user_delivery;
foreach($this->payments as $payment){
	if(in_array('user',$payment->data['delivery'])&& $payment->paymentID == $_GET['payment']){
		echo "<!--user_del-->";
		$user_delivery = 1;
	}
}

if ($user_delivery == 1){
	 wp_reset_query();
	$the_query_1 = new WP_Query(
	array(
		'post_type' => 'wpshop_user_delivery',
		'tax_query' => array(
			array(
				'taxonomy' => 'payment_del',
				'field' => 'name',
				'terms' => $_GET['payment']
			)
		),
		'caller_get_posts'=> 1,
		'post_status' => 'publish',
		'posts_per_page' => -1 
		) 
	);?>
	<?php  $firstPayment = null;?>
	<ul class="custom_del">
	<?php  while ( $the_query_1->have_posts() ) :  $the_query_1->the_post();
	$cost_del = get_post_meta(get_the_ID(), 'cost_del', true);
	$cost_link = get_permalink(get_the_ID());
	$thumbnail = wp_get_attachment_image_src ( get_post_thumbnail_id (get_the_ID()),full);
	$del_name = get_the_title();?>
	<?php  if ($firstPayment == null){
			$firstPayment = $del_name;
			echo "<li class='select'>";
			if( !empty ($thumbnail)){echo "<a cost='".$cost_del."' class='img'><img src='".$thumbnail[0]."' /></a><br>";}
			echo "<a cost='".$cost_del."' link='".$cost_link."' class='info'>".$del_name."</a>";
			echo "<br>";
			echo "<a href='".$cost_link."' class='delivery_link_more'>";
			_e('more...'/*Подробнее о доставке*/, 'wp-shop');
			echo "</a>";
			echo "</li>";
		}else{
			echo "<li>";
			if( !empty ($thumbnail)){echo "<a cost='".$cost_del."' class='img'><img src='".$thumbnail[0]."' /></a><br>";}
			echo "<a cost='".$cost_del."' link='".$cost_link."' class='info'>".$del_name."</a>";
			echo "<br>";
			echo "<a href='".$cost_link."' class='delivery_link_more'>";
			_e('more...'/*Подробнее о доставке*/, 'wp-shop');
			echo "</a>";
			echo "</li>";
		}
	endwhile;?>
	</ul>
	<div class="clear"></div>
	
	<?php   wp_reset_postdata();
}else{
?>	

<select name="select_delivery" class="select_delivery" >
	<?php 
	$firstPayment = null;
	foreach($this->delivery as $delivery)
	{
		foreach($this->payments as $payment)
		{
			if (in_array($delivery->ID,$payment->data['delivery']) && $payment->paymentID == $_GET['payment'])
			{
				if ($firstPayment == null)
				{
					$firstPayment = $delivery->ID;
					$selected = ' selected';
				}
				else
				{
					$selected = '';
				}
				echo "<option value='{$delivery->ID}' cost='{$delivery->cost}'{$selected}>{$delivery->name}</option>";
			}
		}
	}
	?>
</select>
<?php }?>
&nbsp;&nbsp;
<a class="del_cond" href="<?php  echo get_option('wpshop.cart.deliveyrCondition');?>"><?php 
	echo __('Delivery details', 'wp-shop'); // Подробнее о доставке
?></a>