<div>
	<strong><a href="javascript:history.back()"> <- <?php  echo __("Back",'wp-shop');?></a></strong></div>
	<br/>
<div class="wrap">
	<form method="post">
	<div id="poststuff" class="metabox-holder" style="padding:0px;">
		<div id="side-sortables" class="meta-box-sortabless ui-sortable">
			<div id="sm_pnres" class="postbox">
			<h3 class="hndle"><span><?php  echo __("Done orders",'wp-shop');?> -> <?php  echo __("Order",'wp-shop');?> № <?php  echo $this->order->order_id;?></span></h3>
				<div class="inside">
					<div id="wpshop_order_info" style="margin-right:30px">
						<?php $tm = date("d.m.Y г. H:i:s",$this->order->order_date);?>
						<div><strong><?php  echo __("Date",'wp-shop');?>:</strong> <?php  echo $tm;?></div>

						<div><strong><?php  echo __("Client",'wp-shop');?>:</strong> <?php  echo $this->order->client_name;?></div>

						<?php 
						$clientID = $this->order->client_id;
						if (!Wpshop_Profile::isCurrentUserCustomer()) {
							$clientID = "<input type='text' value='{$this->order->client_id}' name='order[client_id]'/>";
						}
						?>

<div><strong><?php  echo __("ID",'wp-shop');?>:</strong> <?php  echo $clientID;?></div>						
			<div><strong><?php  echo __("E-mail",'wp-shop');?>:</strong> <a href="mailto:<?php  echo $this->order->client_email;?>"><?php  echo $this->order->client_email;?></a></div>
						<div><strong><?php  echo __("Payment method",'wp-shop');?>:</strong> <?php  echo $this->order->payment;?></div>
						<div><strong><?php  echo __("Delivery method",'wp-shop');?></strong> <?php 
						try
						{
							$delivery = Wpshop_Delivery::getInstance()->getDelivery($this->order->order_delivery)->name;
						}
						catch(Exception $e)
						{
							$delivery = __("not selected",'wp-shop');
						}
						echo $delivery;
						
						?></div>
						<div><strong><?php  echo __("Order status",'wp-shop');?>:</strong>
						<?php 
						if (Wpshop_Profile::isCurrentUserCustomer()) {
							$statuses = Wpshop_Orders::getInstance()->getStatuses();
							echo $statuses[$this->order->order_status];
						} else {
							echo "<select name='order[status]'>";
							foreach(Wpshop_Orders::getInstance()->getStatuses() as $key=>$status) {
								$selected = "";
								if ($this->order->order_status == $key) {
									$selected = " selected";
								}
								echo "<option value='{$key}'{$selected}>{$status}</option>";
							}						
							echo "</select>";
						}?>
						</div>
						<div><strong><?php  echo __("Client IP",'wp-shop');?>:</strong> <?php  echo $this->order->client_ip;?></div>			
					</div>
					
					<div style='padding:0 50px'>
						<div style = 'font-size:14px;font-weight:bold;'><?php  echo __("Order comment",'wp-shop');?></div>
						<textarea name='order[comment]' style='width:300px;height:200px'><?php  echo $this->order->order_comment;?></textarea>
					</div>
					<div style="clear: both;"></div>
					<input type="hidden" name="order[save]" value="1"/>
					<input type="submit" value='<?php  echo __("Save",'wp-shop');?>' class='button'/>
				</div>
			</div>
		</div>
	</div>


	<table cellpadding="0" cellspacing="5" border="0" class="widefat">
		<thead>
			<tr>
				<th style='width:20px'>№</th>
				<th><?php  echo __("Name",'wp-shop');?></th>
				<th>&nbsp;</th>
				<th style="text-align:center;"><?php  echo __("Count",'wp-shop');?></th>
				<th style="text-align:center;"><?php  echo __("Price",'wp-shop');?></th>
				<th style="text-align:center;"><?php  echo __("Total",'wp-shop');?></th>
			</tr>
		</thead>
		<tbody>
		<?php 
		$i = 0;
		$delivery = Wpshop_Delivery::getInstance()->getDelivery($this->order->order_delivery);
		$itogo = 0;
		foreach($this->ordered as $order) {
			$permalink = get_permalink($order->ordered_page_id);
			$i++;
			$total = $order->ordered_count * $order->ordered_cost;
			$itogo += $total;
			
			$lefttime = gmdate("H:i:s",($order->ordered_digit_live * 60 * 60) + $this->order->order_date - time()); 

			$is_digital = Wpshop_Digital::checkLink($order->ordered_page_id,$this->order->order_id);
			$link = "";

						
			if ($order->ordered_digit_count == -1) {
				$order->ordered_digit_count = "<span style='font-size:16px'>&#8734;</span>";
			}

			if ($order->ordered_digit_live == -1) {
				$lefttime = "<span style='font-size:16px'>&#8734;</span>";
			}

			if ($is_digital){
				$digital_link = get_option('home') . "?wpdownload=" . $order->ordered_page_id . "&order_id={$this->order->order_id}";
				$link = "<div><a href='{$digital_link}'><input type='button' value='".__("Download",'wp-shop')."' style='float:left;margin-right:5px'></a><div style='font-size:10px;line-height: 15px'>" . __("Left download",'wp-shop') .": <strong>{$order->ordered_digit_count}</strong><br/>" . __("Left time",'wp-shop') . ": {$lefttime}</div>";
			}

			echo "<tr><td>{$i}.</td><td><a href='{$permalink}'>{$order->ordered_name}</a> {$link}</td><td>{$order->ordered_key}</td>";
			echo "<td style='text-align:center;'>{$order->ordered_count}</td><td style='text-align:center'>{$order->ordered_cost}</td><td style='text-align:center'>{$total}</td></tr>";
		}
		?>
		</tbody>
		<tfoot>
			<tr><td colspan='5' style='text-align:right;font-weight:bold'><?php  echo __("Total",'wp-shop');?>:</td><td style='text-align:center;font-weight:bold'><?php  echo $itogo;?></td></tr>
			<?php  if (!empty($this->order->order_discount)) { 
			$discount = $itogo /100 * $this->order->order_discount;
			$itogo = $itogo - $discount;
			?>
			<tr><td colspan='5' style='text-align:right;font-weight:bold'><?php  echo __("Discount",'wp-shop');?> (<?php  echo $this->order->order_discount;?>%):</td><td style='text-align:center'>-<?php  echo $discount;?></td></tr>
			<?php  }?>
			<?php  if (!empty($delivery)) {
			$itogo = $itogo + $delivery->cost;
			?>
			<tr><td colspan='5' style='text-align:right;font-weight:bold'><?php  _e("Delivery",'wp-shop');?>: </td><td style='text-align:center'><?php  echo $delivery->cost;?></td></tr>
			<?php  } ?>
			<tr><td colspan='5' style='text-align:right;font-weight:bold'><?php  _e("In all",'wp-shop');?>: </td><td style='text-align:center;font-weight:bold'><?php  echo $itogo;?></td></tr>
      <?php  if (!empty($this->order->order_promo)) {?>
        <tr><td colspan='6' style='text-align:left;font-weight:bold; color:red;'><?php  _e("Promocode: ",'wp-shop');?><?php echo $this->order->order_promo;?></td></tr>
      <?php } ?>
		</tfoot>
	</table>
	</form>
</div>
