<div class="wrap">
<h2><?php  echo _e("Delivery", 'wp-shop'); /*Доставка*/?></h2>
	<form action="<?php  echo $_SERVER['REQUEST_URI'];?>" method="post">
	<input type="hidden" name="update" value="1"/>
	<div id="poststuff">
		<div class="postbox">
			<h3><?php  _e('Country mail', 'wp-shop'); /*Почта по стране*/; ?></h3>
			<div class="inside">
			<table cellpadding="2" cellspacing="2">
				<tr>
					<td style='width:400px;'><?php  _e('Price', 'wp-shop'); /*Стоимость*/; ?></td>
					<td><input type="text" name="wpshop_delivery[postByCountry][cost]" value="<?php  echo $this->delivery['postByCountry']['cost']; ?>"/></td>
				</tr>
			</table>
			</div>
		</div>
	</div>

	<div id="poststuff">
		<div class="postbox">
			<h3><?php  _e('International mail', 'wp-shop'); /*Международная почта*/; ?></h3>
			<div class="inside">
			<table cellpadding="2" cellspacing="2">
				<tr>
					<td style='width:400px;'><?php  _e('Price', 'wp-shop'); /*Стоимость*/; ?></td>
					<td><input type="text" name="wpshop_delivery[postByWorld][cost]" value="<?php  echo $this->delivery['postByWorld']['cost']; ?>"/></td>
				</tr>
			</table>
			</div>
		</div>
	</div>

	<div id="poststuff">
		<div class="postbox">
			<h3><?php  _e('Express delivery', 'wp-shop'); /*Курьерская доставка*/; ?></h3>
			<div class="inside">
			<table cellpadding="2" cellspacing="2">
				<tr>
					<td style='width:400px;'><?php  _e('Price', 'wp-shop'); /*Стоимость*/; ?></td>
					<td><input type="text" name="wpshop_delivery[courier][cost]" value="<?php  echo $this->delivery['courier']['cost']; ?>"/></td>
				</tr>
			</table>
			</div>
		</div>

		<div class="postbox">
			<h3><?php  _e('A visit to the office', 'wp-shop'); /*Визит в офис*/; ?></h3>
			<div class="inside">
			<table cellpadding="2" cellspacing="2">
				<tr>
					<td style='width:400px;'><?php  _e('Price', 'wp-shop'); /*Стоимость*/; ?></td>
					<td><input type="text" name="wpshop_delivery[vizit][cost]" value="<?php  echo $this->delivery['vizit']['cost']; ?>"/></td>
				</tr>
			</table>
			</div>
		</div>
				
	</div>
	<input type="submit" value="<?php  _e('Save', 'wp-shop'); /*Сохранить*/; ?>" class="button">
	</form>
</div>