
<br/>
<br/>
<div class="wrap">
<form method="POST">
<input type="hidden" name="update_payments" value="1"/>
	<div id="poststuff">
		<div class="postbox">
			<h3><?php  _e('User Profile', 'wp-shop'); /**/; ?></h3>
			<div class="inside">
			<table cellpadding="2" cellspacing="2">
				<tr>
					<td><?php  _e('Shipping Address:', 'wp-shop'); /*Адрес доставки:*/; ?> </td>
					<td><textarea name='client_address'></textarea></td>
				</tr>
				<tr>
					<td><?php  _e('Comment:', 'wp-shop'); /*Комментарий:*/; ?></td>
					<td><textarea name='client_comment'></textarea></td>
				</tr>
			</table>
			</div>
		</div>
	</div>
	<input type="submit" value="<?php  _e('Save', 'wp-shop'); /*Сохранить*/; ?>" class="button">
</form>
</div>