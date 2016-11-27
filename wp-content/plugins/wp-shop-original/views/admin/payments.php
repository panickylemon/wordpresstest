<style type='text/css'>
.postbox h3
{
	cursor: none;
}
</style>
<div class="wrap">
<h2><?php  _e('Payment methods', 'wp-shop'); /*Способы оплаты*/ ?></h2>
<form method="POST" class="payments">
<input type="hidden" name="update_payments" value="1"/>
		<div id="poststuff">
		<div class="postbox">
			<h3><?php  _e('Self-delivery', 'wp-shop'); /*Самовывоз*/ ?></h3>
			<div class="inside">
			<table cellpadding="2" cellspacing="2" style="width: 50%;float: left;min-width: 500px;">
				<tr>
					<td><?php  _e('Enable support for self-delivery from a store / office.', 'wp-shop'); /*Включить поддержку самовывоза из магазина/офиса.*/ ?></td>
					<?php $vizit_activate = $this->vizit['activate'] ? " checked" : "";?>
					<td><input type="checkbox" name="wpshop_payments_vizit[activate]"<?php  echo $vizit_activate;?>/></td>
				</tr>

				<tr>
					<td><?php  _e('Delivery', 'wp-shop'); /*Доставка*/ ?></td>
					<td>
					<?php 
						$i = 0;
						foreach($this->deliveries as $delivery)
						{
							$checked = "";
							if($this->vizit['delivery']){
							if (in_array($delivery->ID,$this->vizit['delivery']))
							{
								$checked = " checked";
							}
							}elseif($i==3){ $checked = " checked"; update_option("wpshop.payments.vizit",array('delivery' => array(2=>'vizit')));}
							echo "<input type='checkbox' name='wpshop_payments_vizit[delivery][]' value='{$delivery->ID}'{$checked}/> <label>{$delivery->name}</label><br/>";
							if(++$i == 5) break;
						}

					?>
					</td>
				</tr>
			</table>
			<div style="width: 50%;float: left;text-align: right;min-width: 500px;">
				<ins data-revive-zoneid="8" data-revive-id="03af71d0efe35b0d7d888949e681431d"></ins><script async src="https://wp-shop.ru/adv/www/delivery/asyncjs.php"></script>
			</div>
			</div>
		</div>
	</div>

	<div id="poststuff">
		<div class="postbox">
			<h3><?php  _e('Cash to courier', 'wp-shop'); /*Включить поддержку оплаты курьеру*/ ?></h3>
			<div class="inside">
			<table cellpadding="2" cellspacing="2" style="width: 50%;float: left;min-width: 500px;">
				<tr>
					<td><?php  _e('Enable support for payment to courier', 'wp-shop'); /*Включить поддержку оплаты курьеру*/ ?></td>
					<?php $cash_activate = $this->cash['activate'] ? " checked" : "";?>
					<td><input type="checkbox" name="wpshop_payments_cash[activate]"<?php  echo $cash_activate;?>/></td>
				</tr>
				<tr>
					<td><?php  _e('Delivery', 'wp-shop'); /*Доставка*/ ?></td>
					<td>
					<?php 
						$i = 0;
						foreach($this->deliveries as $delivery)
						{
							$checked = "";
							if($this->cash['delivery']){
							if (in_array($delivery->ID,$this->cash['delivery']))
							{
								$checked = " checked";
							}
							}elseif($i==3){ $checked = " checked"; update_option("wpshop.payments.cash",array('delivery' => array(2=>'vizit')));}
							echo "<input type='checkbox' name='wpshop_payments_cash[delivery][]' value='{$delivery->ID}'{$checked}/> <label>{$delivery->name}</label><br/>";
							if(++$i == 5) break;
						}

					?>
					</td>
				</tr>
			</table>
			<div style="width: 50%;float: left;text-align: right;min-width: 500px;">
				<ins data-revive-zoneid="9" data-revive-id="03af71d0efe35b0d7d888949e681431d"></ins><script async src="https://wp-shop.ru/adv/www/delivery/asyncjs.php"></script>
			</div>
			</div>
		</div>
	</div>
	<div id="poststuff">
		<div class="postbox">
			<h3><?php  _e('Cash on delivery (COD)', 'wp-shop'); /*Наложенный платеж*/ ?></h3>
			<div class="inside">
			<table cellpadding="2" cellspacing="2" style="width: 50%;float: left;min-width: 500px;">
				<tr>
					<td><?php  _e('Enable support for COD', 'wp-shop'); /*Включить поддержку наложного платежа*/ ?></td>
					<?php $post_activate = $this->post['activate'] ? " checked" : "";?>
					<td><input type="checkbox" name="wpshop_payments_post[activate]"<?php  echo $post_activate;?>/></td>
				</tr>
				<tr>
					<td><?php  _e('Delivery', 'wp-shop'); /*Доставка*/ ?></td>
					<td>
					<?php 
						$i = 0;
						foreach($this->deliveries as $delivery)
						{
							$checked = "";
							if($this->post['delivery']){
							if (in_array($delivery->ID,$this->post['delivery']))
							{
								$checked = " checked";
							}
							}elseif($i==3){ $checked = " checked"; update_option("wpshop.payments.post",array('delivery' => array(2=>'vizit')));}
							echo "<input type='checkbox' name='wpshop_payments_post[delivery][]' value='{$delivery->ID}'{$checked}/> <label>{$delivery->name}</label><br/>";
							if(++$i == 5) break;
						}

					?>
					</td>
				</tr>
			</table>
			<div style="width: 50%;float: left;text-align: right;min-width: 500px;">
				<ins data-revive-zoneid="10" data-revive-id="03af71d0efe35b0d7d888949e681431d"></ins><script async src="https://wp-shop.ru/adv/www/delivery/asyncjs.php"></script>
			</div>
			</div>
		</div>
	</div>

	<div id="poststuff">
		<div class="postbox">
			<h3><?php  _e('Your bank account details', 'wp-shop'); /*Ваши банковские реквизиты*/ ?></h3>
			<div class="inside">
			<table cellpadding="2" cellspacing="2" style="width: 50%;float: left;min-width: 500px;">
				<tr>
					<td ><?php  _e('Enable support of a payment through the bank', 'wp-shop'); /*Включить поддержку оплаты через банк*/ ?></td>
					<?php $bank_activate = $this->bank['activate'] ? " checked" : "";?>
					<td><input type="checkbox" name="wpshop_payments_bank[activate]"<?php  echo $bank_activate;?>/></td>
				</tr>
				<tr>
					<td><?php  _e('Delivery', 'wp-shop'); /*Доставка*/ ?></td>
					<td>
					<?php 
						$i = 0;
						foreach($this->deliveries as $delivery)
						{
							$checked = "";
							if($this->bank['delivery']){
							if (is_array($this->bank['delivery']) && in_array($delivery->ID,$this->bank['delivery']))
							{
								$checked = " checked";
							}
							}elseif($i==3){ $checked = " checked"; update_option("wpshop.payments.bank",array('delivery' => array(2=>'vizit')));}
							echo "<input type='checkbox' name='wpshop_payments_bank[delivery][]' value='{$delivery->ID}'{$checked}/> <label>{$delivery->name}</label><br/>";
							if(++$i == 5) break;
						}

					?>
					</td>
				</tr>
				<tr>
					<td>БИК</td>
					<td style="min-width:300px;"><input type="text" style="width:100%;"name="wpshop_payments_bank[bik]" value='<?php  echo $this->bank['bik'];?>'/></td>
				</tr>
				<tr>
					<td><?php  _e('Personal account', 'wp-shop'); /*Лицевой счет*/ ?></td>
					<td style="min-width:300px;"><input type="text" style="width:100%;" name="wpshop_payments_bank[ls]" value='<?php  echo $this->bank['ls'];?>'/></td>
				</tr>
				<tr>
					<td><?php  _e('Сorr. account', 'wp-shop'); /*Кор. счет*/ ?></td>
					<td style="min-width:300px;"><input type="text" style="width:100%;" name="wpshop_payments_bank[ks]" value='<?php  echo $this->bank['ks'];?>'/></td>
				</tr>
			</table>
			<div style="width: 50%;float: left;text-align: right;min-width: 500px;">
				<ins data-revive-zoneid="11" data-revive-id="03af71d0efe35b0d7d888949e681431d"></ins><script async src="https://wp-shop.ru/adv/www/delivery/asyncjs.php"></script>
			</div>
			</div>
		</div>
	</div>

	<div id="poststuff">
		<div class="postbox">
			<h3>Web-money</h3>
			<div class="inside">
			<table cellpadding="2" cellspacing="2" style="width: 50%;float: left;min-width: 500px;">
				<tr>
					<td><?php  _e('Enable support of a payment using Web-Money', 'wp-shop'); /*Включить поддержку оплаты по Web-Money*/ ?></td>
					<?php $wm_activate = $this->wm['activate'] ? " checked" : "";?>
					<td><input type="checkbox" name="wpshop_payments_wm[activate]"<?php  echo $wm_activate;?>/></td>
				</tr>
				<tr>
					<td><?php  _e('Delivery', 'wp-shop'); /*Доставка*/ ?></td>
					<td>
					<?php 
						$i = 0;
						foreach($this->deliveries as $delivery)
						{
							$checked = "";
							if($this->wm['delivery']){
							if (in_array($delivery->ID,$this->wm['delivery']))
							{
								$checked = " checked";
							}
							}elseif($i==3){ $checked = " checked"; update_option("wpshop.payments.wm",array('delivery' => array(2=>'vizit')));}
							echo "<input type='checkbox' name='wpshop_payments_wm[delivery][]' value='{$delivery->ID}'{$checked}/> <label>{$delivery->name}</label><br/>";
							if(++$i == 5) break;
						}

					?>
					</td>
				</tr>

				<tr>
					<td><?php  _e('Your WM-purse', 'wp-shop'); /*Ваш WM-Кошелек*/ ?></td>
					<td style="min-width:300px;"><input style="width:100%;" type="text" name="wpshop_payments_wm[wmCheck]" value="<?php  echo $this->wm['wmCheck'];?>"/></td>
				</tr>
				<tr>
					<td><?php  _e('Success URL', 'wp-shop'); ?></td>
					<td style="min-width:300px;"><input style="width:100%;" type="text" name="wpshop_payments_wm[successUrl]" value="<?php  echo $this->wm['successUrl'];?>"/></td>
				</tr>
				<tr>
					<td><?php  _e('Failed URL', 'wp-shop'); ?></td>
					<td style="min-width:300px;"><input style="width:100%;" type="text" name="wpshop_payments_wm[failedUrl]" value="<?php  echo $this->wm['failedUrl'];?>"/></td>
				</tr>
			</table>
			<div style="width: 50%;float: left;text-align: right;min-width: 500px;">
				<ins data-revive-zoneid="12" data-revive-id="03af71d0efe35b0d7d888949e681431d"></ins><script async src="https://wp-shop.ru/adv/www/delivery/asyncjs.php"></script>
			</div>
			</div>
		</div>
	</div>
	
	<div id="poststuff">
		<div class="postbox">
			<h3><?php  _e('Payment through the merchant', 'wp-shop');/* Оплата через шлюз */?></h3>
			<div class="inside">
			
			<table cellpadding="2" cellspacing="2" >
				<tr>
					<td><?php  _e('Enable support of Merchant', 'wp-shop'); /*Включить поддержку merchants*/ ?></td>
					<?php $merchant_activate = $this->merchant ? " checked" : "";?>
					<td><input type="checkbox" name="wpshop_merchant"<?php  echo $merchant_activate;?>/></td>
				</tr>
				
				<script>
					jQuery(function(){
						if (jQuery('.merchant_system').val() == 'ek') { 
							jQuery('.robokassa_n').hide();
							jQuery('.yandex_kassa_n').hide();
							jQuery('.ek_n').show();
						}
						
						if (jQuery('.merchant_system').val() == 'robokassa') { 
							jQuery('.ek_n').hide();
							jQuery('.yandex_kassa_n').hide();
							jQuery('.robokassa_n').show();
						}
						
						if (jQuery('.merchant_system').val() == 'yandex_kassa') { 
							jQuery('.ek_n').hide();
							jQuery('.robokassa_n').hide();
							jQuery('.yandex_kassa_n').show();
						}
						
						jQuery('.merchant_system').change(function(){
							if (jQuery(this).val() == 'ek') { 
								jQuery('.robokassa_n').hide();
								jQuery('.yandex_kassa_n').hide();
								jQuery('.ek_n').show();
							}
							
							if (jQuery(this).val() == 'robokassa') { 
								jQuery('.ek_n').hide();
								jQuery('.yandex_kassa_n').hide();
								jQuery('.robokassa_n').show();
							}
							
							if (jQuery(this).val() == 'yandex_kassa') { 
								jQuery('.ek_n').hide();
								jQuery('.robokassa_n').hide();
								jQuery('.yandex_kassa_n').show();
							}
						});
					});
				</script>
				
				<tr>
					<td><?php  _e('Select Merchant System', 'wp-shop'); /*Выбрать merchant system*/ ?></td>
					<td>
						<select name="wpshop_merchant_system" class="merchant_system">
							<option value='ek' <?php  if($this->merchant_system == 'ek'){ echo' selected="selected"';}?>><?php  _e('WalletOne', 'wp-shop');/* Единая касса */?></option>
							<option value='robokassa' <?php  if($this->merchant_system == 'robokassa'){ echo' selected="selected"';}?>><?php  _e('Robokassa', 'wp-shop');/* Робокасса */?></option>
							<option value='yandex_kassa' <?php  if($this->merchant_system == 'yandex_kassa'){ echo' selected="selected"';}?>><?php  _e('Yandex kassa', 'wp-shop');/* Робокасса */?></option>
						</select>
					</td>
				</tr>
				
				<!-- Настройки robokassa-->
				<table class="robokassa_n" style="width: 50%;float: left;min-width: 650px; display:none">
					<tr>
						<td><?php  _e('Delivery', 'wp-shop'); /*Доставка*/ ?></td>
						<td>
						<?php 
							$i = 0;
							foreach($this->deliveries as $delivery)
							{
								$checked = "";
								if($this->robokassa['delivery']){
								if (in_array($delivery->ID,$this->robokassa['delivery']))
								{
									$checked = " checked";
								}
								}elseif($i==3){ $checked = " checked"; update_option("wpshop.payments.robokassa",array('delivery' => array(2=>'vizit')));}
								echo "<input type='checkbox' name='wpshop_payments_robokassa[delivery][]' value='{$delivery->ID}'{$checked}/> <label>{$delivery->name}</label><br/>";
								if(++$i == 5) break;
							}
						?>
						</td>
					</tr>
					<tr>
						<td><?php  _e('Robokassa Login', 'wp-shop'); ?></td>
						<td style="min-width:300px;"><input type="text" style="width:100%;" name="wpshop_payments_robokassa[login]" value="<?php  echo $this->robokassa['login'];?>"/></td>
					</tr>
					<tr>
						<td><?php  _e('Robokassa pass 1', 'wp-shop'); /*Robokassa пароль 1*/ ?></td>
						<td style="min-width:300px;"><input type="text" style="width:100%;" name="wpshop_payments_robokassa[pass1]" value="<?php  echo $this->robokassa['pass1'];?>"/></td>
					</tr>
					<tr>
						<td><?php  _e('Robokassa pass 2', 'wp-shop'); /*Robokassa пароль 2*/ ?></td>
						<td style="min-width:300px;"><input style="width:100%;" type="text" name="wpshop_payments_robokassa[pass2]" value="<?php  echo $this->robokassa['pass2'];?>"/></td>
					</tr>
				</table>
				
				<!-- Настройки EK-->
				<table class="ek_n" style="width: 50%;float: left;min-width: 650px; display:none">
					<tr>
						<td>
							<table>
							<tr>
								<td><?php  _e('Delivery', 'wp-shop'); /*Доставка*/ ?></td>
								<td>
								<?php 
									$i = 0;
									foreach($this->deliveries as $delivery)
									{
										$checked = "";
										if($this->ek['delivery']){
										if (in_array($delivery->ID,$this->ek['delivery']))
										{
											$checked = " checked";
										}
										}elseif($i==3){ $checked = " checked"; update_option("wpshop.payments.ek",array('delivery' => array(2=>'vizit')));}
										echo "<input type='checkbox' name='wpshop_payments_ek[delivery][]' value='{$delivery->ID}'{$checked}/> <label>{$delivery->name}</label><br/>";
										if(++$i == 5) break;
									}

								?>
								</td>
							</tr>
							
							<tr>
								<td><?php  _e('Your WalletOne', 'wp-shop'); /*Ваш WalletOne*/ ?></td>
								<td style="min-width:300px;"><input style="width:100%;" type="text" name="wpshop_payments_ek[wmCheck]" value="<?php  echo $this->ek['wmCheck'];?>"/></td>
							</tr>
							
							<tr>
								<td><?php  _e('Currency', 'wp-shop'); /*Валюта*/ ?></td>
								<td>
									<?php 
										$currency = $this->ek['currency_ek'];
										if ($currency == '643') { $p1 = ' selected="selected"'; $p2 = ''; $p3 = ''; $p4 = ''; $p5 = ''; $p6 = ''; $p7 = ''; }
										if ($currency == '710') { $p1 = ''; $p2 = ' selected="selected"'; $p3 = ''; $p4 = ''; $p5 = ''; $p6 = ''; $p7 = ''; }
										if ($currency == '840') { $p1 = ''; $p2 = ''; $p3 = ' selected="selected"'; $p4 = ''; $p5 = ''; $p6 = ''; $p7 = ''; }
										if ($currency == '978') { $p1 = ''; $p2 = ''; $p3 = ''; $p4 = ' selected="selected"'; $p5 = ''; $p6 = ''; $p7 = ''; }
										if ($currency == '980') { $p1 = ''; $p2 = ''; $p3 = ''; $p4 = ''; $p5 = ' selected="selected"'; $p6 = ''; $p7 = ''; }
										if ($currency == '398') { $p1 = ''; $p2 = ''; $p3 = ''; $p4 = ''; $p5 = ''; $p6 = ' selected="selected"'; $p7 = ''; }
										if ($currency == '974') { $p1 = ''; $p2 = ''; $p3 = ''; $p4 = ''; $p5 = ''; $p6 = ''; $p7 = ' selected="selected"'; }
									?>
									<select name="wpshop_payments_ek[currency_ek]">
										<option value='643' <?php echo $p1?>><?php  _e('Russian Ruble', 'wp-shop'); /*Российские рубли*/ ?></option>
										<option value='710' <?php echo $p2?>><?php  _e('South African Rand', 'wp-shop'); /*Южно-Африканские ранды*/ ?></option>
										<option value='840' <?php echo $p3?>><?php  _e('USD', 'wp-shop'); /*Американские доллары*/ ?></option>
										<option value='978' <?php echo $p4?>><?php  _e('euro', 'wp-shop'); /*Евро*/ ?></option>
										<option value='980' <?php echo $p5?>><?php  _e('Ukrainian hryvnia', 'wp-shop'); /*Украинские гривны*/ ?></option>
										<option value='398' <?php echo $p6?>><?php  _e('Kazakhstani tenge', 'wp-shop'); /*Казахстанские тенге*/ ?></option>
										<option value='974' <?php echo $p7?>><?php  _e('Belarusian Ruble', 'wp-shop'); /*Белорусские рубли*/ ?></option>
									</select>
								</td>
							</tr>
							
							<tr>
								<td><?php  _e('Success URL', 'wp-shop'); ?></td>
								<td style="min-width:300px;"><input type="text" style="width:100%;" name="wpshop_payments_ek[successUrl]" value="<?php  echo $this->ek['successUrl'];?>"/></td>
							</tr>
							
							<tr>
								<td><?php  _e('Failed URL', 'wp-shop'); ?></td>
								<td style="min-width:300px;"><input style="width:100%;" type="text" name="wpshop_payments_ek[failedUrl]" value="<?php  echo $this->ek['failedUrl'];?>"/></td>
							</tr>
							</table>
						</td>
						<?php add_thickbox(); ?>
						<div id="my-content-id" style="display:none;">
							<img src="<?php echo WPSHOP_URL;?>/images/ek_reg.jpg" width="100%">
						</div>
						<td class="wpshop_information">
							<h3>Внимание, это важно! </h3>
							<p>код подключения к системе <strong>Единая Касса</strong></p>
							<h2>Ra2xrxrxy</h2>
							<p>Для правильной синхронизации данных с системой Единая Касса Вам нужно внести этот код в форму ругистрации аккаунта </p>
							<a href="#TB_inline?width=600&height=550&inlineId=my-content-id" class="thickbox">Подробнее...</a>
						</td>
					</tr>
				</table>
				
				<!-- Настройки yandex_kassa-->
				<table class="yandex_kassa_n" style="width: 50%;float: left;min-width: 650px; display:none">
					
					<tr>
						<td><?php  _e('Test paiments', 'wp-shop'); ?></td>
						<?php $yandex_test = $this->yandex_kassa['test'] ? " checked" : "";?>
						<td><input type="checkbox" name="wpshop_payments_yandex_kassa[test]"<?php  echo $yandex_test;?>/></td>
					</tr>
          
					<tr>
						<td><?php  _e('Delivery', 'wp-shop'); /*Доставка*/ ?></td>
						<td>
						<?php 
							$i = 0;
							foreach($this->deliveries as $delivery)
							{
								$checked = "";
								if($this->yandex_kassa['delivery']){
								if (in_array($delivery->ID,$this->yandex_kassa['delivery']))
								{
									$checked = " checked";
								}
								}elseif($i==3){ $checked = " checked"; update_option("wpshop.payments.yandex_kassa",array('delivery' => array(2=>'vizit')));}
								echo "<input type='checkbox' name='wpshop_payments_yandex_kassa[delivery][]' value='{$delivery->ID}'{$checked}/> <label>{$delivery->name}</label><br/>";
								if(++$i == 5) break;
							}

						?>
						</td>
					</tr>

					<tr>
						<td><?php  _e('Your Yandex kassa shop_id', 'wp-shop'); /*Ваш Yandex shop_id*/ ?></td>
						<td style="min-width:300px;"><input type="text" style="width:100%;" name="wpshop_payments_yandex_kassa[shopId]" value="<?php  echo $this->yandex_kassa['shopId'];?>"/></td>
					</tr>
					<tr>
						<td><?php  _e('Your Yandex kassa scid', 'wp-shop'); /*Ваш Yandex scid*/ ?></td>
						<td style="min-width:300px;"><input type="text" style="width:100%;" name="wpshop_payments_yandex_kassa[scid]" value="<?php  echo $this->yandex_kassa['scid'];?>"/></td>
					</tr>
					<tr>
						<td><?php  _e('Your Yandex kassa shopPassword', 'wp-shop'); /*Ваш Yandex shopPassword*/ ?></td>
						<td style="min-width:300px;"><input type="text" style="width:100%;" name="wpshop_payments_yandex_kassa[shopPassword]" value="<?php echo $this->yandex_kassa['shopPassword'];?>"/></td>
					</tr>
					
					<tr>
						<td><?php  _e('Success URL', 'wp-shop'); ?></td>
						<td style="min-width:300px;"><input type="text" style="width:100%;" name="wpshop_payments_yandex_kassa[successUrl]" value="<?php  echo $this->yandex_kassa['successUrl'];?>"/></td>
					</tr>
					<tr>
						<td><?php  _e('Failed URL', 'wp-shop'); ?></td>
						<td style="min-width:300px;"><input style="width:100%;" type="text" name="wpshop_payments_yandex_kassa[failedUrl]" value="<?php  echo $this->yandex_kassa['failedUrl'];?>"/></td>
					</tr>
					<tr>
						<td><?php  _e('Enable Sberbank online', 'wp-shop'); ?></td>
						<?php $yandex_sber = $this->yandex_kassa['sber'] ? " checked" : "";?>
						<td><input type="checkbox" name="wpshop_payments_yandex_kassa[sber]"<?php  echo $yandex_sber;?>/></td>
					</tr>
					<tr>
						<td><?php  _e('Enable Webmoney', 'wp-shop'); ?></td>
						<?php $yandex_webmoney = $this->yandex_kassa['webmoney'] ? " checked" : "";?>
						<td><input type="checkbox" name="wpshop_payments_yandex_kassa[webmoney]"<?php  echo $yandex_webmoney;?>/></td>
					</tr>    
					<tr>
						<td><?php  _e('Enable Qiwi', 'wp-shop'); ?></td>
						<?php $yandex_qiwi = $this->yandex_kassa['qiwi'] ? " checked" : "";?>
						<td><input type="checkbox" name="wpshop_payments_yandex_kassa[qiwi]"<?php  echo $yandex_qiwi;?>/></td>
					</tr>   
					<tr>
						<td><?php  _e('Enable Promsvyazbank', 'wp-shop'); ?></td>
						<?php $yandex_prom = $this->yandex_kassa['prom'] ? " checked" : "";?>
						<td><input type="checkbox" name="wpshop_payments_yandex_kassa[prom]"<?php  echo $yandex_prom;?>/></td>
					</tr>   
					<tr>
						<td><?php  _e('Enable MasterPass', 'wp-shop'); ?></td>
						<?php $yandex_master = $this->yandex_kassa['master'] ? " checked" : "";?>
						<td><input type="checkbox" name="wpshop_payments_yandex_kassa[master]"<?php  echo $yandex_master;?>/></td>
					</tr>   
					<tr>
						<td ><?php  _e('Enable Alfa Click', 'wp-shop'); ?></td>
						<?php $yandex_alfa = $this->yandex_kassa['alfa'] ? " checked" : "";?>
						<td><input type="checkbox" name="wpshop_payments_yandex_kassa[alfa]"<?php  echo $yandex_alfa;?>/></td>
					</tr>   
					<tr>
						<td ><?php  _e('Enable Doveritelniy payment', 'wp-shop'); ?></td>
						<?php $yandex_dover = $this->yandex_kassa['dover'] ? " checked" : "";?>
						<td><input type="checkbox" name="wpshop_payments_yandex_kassa[dover]"<?php  echo $yandex_dover;?>/></td>
					</tr>   
					<tr>
						<td ><?php  _e('Enable buy in credit', 'wp-shop'); ?></td>
						<?php $yandex_credit = $this->yandex_kassa['credit'] ? " checked" : "";?>
						<td><input type="checkbox" name="wpshop_payments_yandex_kassa[credit]"<?php  echo $yandex_credit;?>/></td>
					</tr>   
				</table>
			</table>
			<div style="width: 50%;float: left;text-align: right;min-width: 500px;">
				<ins data-revive-zoneid="13" data-revive-id="03af71d0efe35b0d7d888949e681431d"></ins><script async src="https://wp-shop.ru/adv/www/delivery/asyncjs.php"></script>
			</div>
			</div>
		</div>
	</div>
	
	
	<div id="poststuff">
		<div class="postbox">
			<h3>PayPal</h3>
			<div class="inside">
			<table cellpadding="2" cellspacing="2" style="width: 50%;float: left;min-width: 500px;">
				<tr>
					<td ><?php  _e('Enable PayPal', 'wp-shop'); ?></td>
					<?php $paypal_activate = $this->paypal['activate'] ? " checked" : "";?>
					<td><input type="checkbox" name="wpshop_payments_paypal[activate]"<?php  echo $paypal_activate;?>/></td>
				</tr>
				
				<tr>
					<td ><?php  _e('Test paiments', 'wp-shop'); ?></td>
					<?php $paypal_test = $this->paypal['test'] ? " checked" : "";?>
					<td><input type="checkbox" name="wpshop_payments_paypal[test]"<?php  echo $paypal_test;?>/></td>
				</tr>
				
				<tr>
					<td><?php  _e('Delivery', 'wp-shop'); /*Доставка*/ ?></td>
					<td>
					<?php 
						$i = 0;
						foreach($this->deliveries as $delivery)
						{
							$checked = "";
							if($this->paypal['delivery']){
							if (in_array($delivery->ID,$this->paypal['delivery']))
							{
								$checked = " checked";
							}
							}elseif($i==3){ $checked = " checked"; update_option("wpshop.payments.paypal",array('delivery' => array(2=>'vizit')));}
							echo "<input type='checkbox' name='wpshop_payments_paypal[delivery][]' value='{$delivery->ID}'{$checked}/> <label>{$delivery->name}</label><br/>";
							if(++$i == 5) break;
						}

					?>
					</td>
				</tr>
					
				<tr>
					<td><?php  _e('Saller Email', 'wp-shop'); /*Email продавца*/ ?></td>
					<td style="min-width:300px;"><input style="width:100%;" type="text" name="wpshop_payments_paypal[email]" value="<?php  echo $this->paypal['email'];?>"/></td>
				</tr>
				
				<tr>
					<td><?php  _e('Success URL', 'wp-shop'); /*Success URL*/ ?></td>
					<td style="min-width:300px;"><input style="width:100%;" type="text" name="wpshop_payments_paypal[success]" value="<?php  echo $this->paypal['success'];?>"/></td>
				</tr>
				
				<tr>
					<td><?php  _e('Currency', 'wp-shop'); /*Валюта*/ ?></td>
					<td>
						<?php 
							$currency = $this->paypal['currency_paypal'];
							if ($currency == 'USD') { $p1 = ' selected="selected"'; $p2 = ''; $p3 = '';}
							if ($currency == 'EUR') { $p1 = ''; $p2 = ' selected="selected"';$p3 = '';}
							if ($currency == 'RUB') { $p1 = ''; $p2 = '';$p3 = ' selected="selected"';}
						?>
						<select name="wpshop_payments_paypal[currency_paypal]">
							<option value='USD' <?php echo $p1?>><?php  _e('USD', 'wp-shop'); /*Американские доллары*/ ?></option>
							<option value='EUR' <?php echo $p2?>><?php  _e('euro', 'wp-shop'); /*Евро*/ ?></option>
							<option value='RUB' <?php echo $p3?>><?php  _e('Russian Ruble', 'wp-shop'); /*Российские рубли*/ ?></option>
						</select>
					</td>
				</tr>
			</table>
			<div style="width: 50%;float: left;text-align: right;min-width: 500px;">
				<ins data-revive-zoneid="14" data-revive-id="03af71d0efe35b0d7d888949e681431d"></ins><script async src="https://wp-shop.ru/adv/www/delivery/asyncjs.php"></script>
			</div>
			</div>
		</div>
	</div>
  
  <div id="poststuff">
		<div class="postbox">
			<h3>Simplepay</h3>
			<div class="inside">
			<table cellpadding="2" cellspacing="2" style="width: 50%;float: left;min-width: 500px;">
				<tr>
					<td ><?php  _e('Enable Simplepay', 'wp-shop'); ?></td>
					<?php $simplepay_activate = $this->simplepay['activate'] ? " checked" : "";?>
					<td><input type="checkbox" name="wpshop_payments_simplepay[activate]"<?php  echo $simplepay_activate;?>/></td>
				</tr>
				
				<tr>
					<td><?php  _e('Delivery', 'wp-shop'); /*Доставка*/ ?></td>
					<td>
					<?php 
						$i = 0;
						foreach($this->deliveries as $delivery)
						{
							$checked = "";
							if($this->simplepay['delivery']){
							if (in_array($delivery->ID,$this->simplepay['delivery']))
							{
								$checked = " checked";
							}
							}elseif($i==3){ $checked = " checked"; update_option("wpshop.payments.simplepay",array('delivery' => array(2=>'vizit')));}
							echo "<input type='checkbox' name='wpshop_payments_simplepay[delivery][]' value='{$delivery->ID}'{$checked}/> <label>{$delivery->name}</label><br/>";
							if(++$i == 5) break;
						}

					?>
					</td>
				</tr>
        
        <tr>
					<td><?php  _e('Outlet id', 'wp-shop'); /*Outlet id*/ ?></td>
					<td style="min-width:300px;"><input type="text" style="width:100%;" name="wpshop_payments_simplepay[outlet_id]" value="<?php  echo $this->simplepay['outlet_id'];?>"/></td>
				</tr>
				
				<tr>
					<td><?php  _e('Secure key', 'wp-shop'); /*Secure key*/ ?></td>
					<td style="min-width:300px;"><input type="text" style="width:100%;" name="wpshop_payments_simplepay[secure]" value="<?php  echo $this->simplepay['secure'];?>"/></td>
				</tr>
        
        <tr>
					<td><?php  _e('Currency', 'wp-shop'); /*Валюта*/ ?></td>
					<td>
						<?php 
							$currency = $this->simplepay['currency_simplepay'];
							if ($currency == 'USD') { $p1 = ' selected="selected"'; $p2 = ''; $p3 = '';}
							if ($currency == 'EUR') { $p1 = ''; $p2 = ' selected="selected"';$p3 = '';}
							if ($currency == 'RUB') { $p1 = ''; $p2 = '';$p3 = ' selected="selected"';}
						?>
						<select name="wpshop_payments_simplepay[currency_simplepay]">
							<option value='USD' <?php echo $p1?>><?php  _e('USD', 'wp-shop'); /*Американские доллары*/ ?></option>
							<option value='EUR' <?php echo $p2?>><?php  _e('euro', 'wp-shop'); /*Евро*/ ?></option>
							<option value='RUB' <?php echo $p3?>><?php  _e('Russian Ruble', 'wp-shop'); /*Российские рубли*/ ?></option>
						</select>
					</td>
				</tr>
					
			
			</table>
			</div>
		</div>
	</div>
  
  <div id="poststuff">
		<div class="postbox">
			<h3>Chronopay</h3>
			<div class="inside">
			<table cellpadding="2" cellspacing="2" style="width: 50%;float: left;min-width: 500px;">
			
				<script>
					jQuery(function(){
						jQuery('#chronopay').change(function(){
							if(jQuery(this).is(':checked')){
								window.open('http://wp-shop.ru/chronopay/');
							}
						});
							
						
					});
				</script>
				<tr>
					<td ><?php  _e('Enable Chronopay', 'wp-shop'); ?></td>
					<?php $chronopay_activate = $this->chronopay['activate'] ? " checked" : "";?>
					<td><input type="checkbox" id="chronopay" name="wpshop_payments_chronopay[activate]"<?php  echo $chronopay_activate;?>/></td>
				</tr>
				
				
				<tr>
					<td><?php  _e('Delivery', 'wp-shop'); /*Доставка*/ ?></td>
					<td>
					<?php 
						$i = 0;
						foreach($this->deliveries as $delivery)
						{
							$checked = "";
							if($this->chronopay['delivery']){
							if (in_array($delivery->ID,$this->chronopay['delivery']))
							{
								$checked = " checked";
							}
							}elseif($i==3){ $checked = " checked"; update_option("wpshop.payments.chronopay",array('delivery' => array(2=>'vizit')));}
							echo "<input type='checkbox' name='wpshop_payments_chronopay[delivery][]' value='{$delivery->ID}'{$checked}/> <label>{$delivery->name}</label><br/>";
							if(++$i == 5) break;
						}

					?>
					</td>
				</tr>
								
				<tr>
					<td ><p><strong>Важно!</strong> для учета номера заказа необходимо связаться с администрацией Сhronopay для подключения данной услуги. Только после этого активируйте ее в настройках оплаты вашего магазина.</p></td>
				</tr>
						
				<tr>
					<td ><?php  _e('Order_id enable', 'wp-shop');//Учитывать параметр order_id ?></td>
					<?php $chronopay_order = $this->chronopay['order'] ? " checked" : "";?>
					<td><input type="checkbox" name="wpshop_payments_chronopay[order]"<?php  echo $chronopay_order;?>/></td>
				</tr>
				
				<tr>
					<td><?php  _e('Product_id', 'wp-shop'); /*Product_id*/ ?></td>
					<td style="min-width:300px;"><input style="width:100%;" type="text" name="wpshop_payments_chronopay[product_id]" value="<?php  echo $this->chronopay[product_id];?>"/></td>
				</tr>
				
				<tr>
					<td><?php  _e('Success URL', 'wp-shop'); /*Success URL*/ ?></td>
					<td style="min-width:300px;"><input style="width:100%;" type="text" name="wpshop_payments_chronopay[success]" value="<?php  echo $this->chronopay['success'];?>"/></td>
				</tr>
        
				<tr>
					<td><?php  _e('Failed URL', 'wp-shop'); /*Failed URL*/ ?></td>
					<td style="min-width:300px;"><input style="width:100%;" type="text" name="wpshop_payments_chronopay[failed]" value="<?php  echo $this->chronopay['failed'];?>"/></td>
				</tr>
        
				<tr>
					<td><?php  _e('Password', 'wp-shop'); /*Пароль*/ ?></td>
					<td style="min-width:300px;"><input style="width:100%;" type="text" name="wpshop_payments_chronopay[sharedsec]" value="<?php  echo $this->chronopay['sharedsec'];?>"/></td>
				</tr>
        
      </table>
				<div style="width: 50%;float: left;text-align: right;min-width: 500px;">
					<ins data-revive-zoneid="15" data-revive-id="03af71d0efe35b0d7d888949e681431d"></ins><script async src="https://wp-shop.ru/adv/www/delivery/asyncjs.php"></script>
				</div>
			</div>
		</div>
	</div>
	
	<input type="submit" value="<?php  _e('Save', 'wp-shop'); /*Сохранить*/ ?>" class="button">
</form>
</div>