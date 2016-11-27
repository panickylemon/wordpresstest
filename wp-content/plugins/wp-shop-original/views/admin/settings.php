<div class="wrap">
<h2><?php  _e('Settings of WP-Shop', 'wp-shop'); ?></h2>

<form method="post">
<input type="hidden" name="update_wpshop_settings" value="1"/>
<table>
	<tbody>
		<tr><td valign='top'>
		<div id="poststuff" class="narr"><div class="postbox">
			<h3><?php  echo __('Options:', 'wp-shop'); // Настройки
				?></h3>
			<div class="inside">
				<table style="width: 50%;float: left;min-width: 500px;">
					<tr>
						<td style="width:50%;">
							<label for="cssfile"><?php  echo __('Choose a style file', 'wp-shop'); // Выберите файл стилей
							?></label>
						</td>
						<td style="width:50%;">
							<select name="cssfile" style="width:150px">
								<?php  echo $this->file_list;?>
							</select>
              <a href="http://wp-shop.ru/wpshop-full-settings/id1" target="_blank" class="wpshop_admin_ask"><img src="<?php echo WPSHOP_URL.'/images/help_icon.png';?>"/></a>
						</td>
					</tr>
					<tr>
						<td style="width:50%;">
							<label for="cform"><?php  echo __('Available Forms', 'wp-shop'); // Доступные формы	?></label> 
						</td>
						<td style="width:50%;">
							<select name="cform" style="width:150px">
							<?php 
								foreach($this->cforms as $cform)
								{
									echo "<option value='{$cform['name']}'{$cform['selected']}>{$cform['name']}</option>";
								}
							?>
							</select>
              <a href="http://wp-shop.ru/wpshop-full-settings/id2" target="_blank" class="wpshop_admin_ask"><img src="<?php echo WPSHOP_URL.'/images/help_icon.png';?>"/></a>
							<?php  echo $this->formlistbox;?>
						</td>
					</tr>
					<tr>
					<?php $postion_sel = array();
					$postion_sel[$this->position] = 'selected';
					$position_select = "<select name='position' id='position'>
								<option value='top'{$postion_sel['top']}>".__('Up' /*Вверху*/, 'wp-shop')."</option>
								<option value='bottom'{$postion_sel['bottom']}>".__('Down' /*Внизу*/, 'wp-shop')."</option>
								</select>";
					?>
          
					<td><label for="position"><?php echo __('Location of price block', 'wp-shop'); /*Расположение блока цены: */
					?></label></td><td ><?php  echo $position_select;?>
          <a href="http://wp-shop.ru/wpshop-full-settings/id3" target="_blank" class="wpshop_admin_ask"><img src="<?php echo WPSHOP_URL.'/images/help_icon.png';?>"/></a></td>
					</tr>
					<tr>
					<td><label for="wp-shop_show-cost"><?php  echo __('Display price of goods in records and archives:', 'wp-shop'); /*Отображать цену товара в записях и архивах:*/
					?></label></td>
						<?php $showCostChecked = $this->showCost == 1 ? " checked" : ""; ?>
						<td colspan="2"><input type="checkbox" name="wp-shop_show-cost" id="wp-shop_show-cost"<?php  echo $showCostChecked;?>/>
            <a href="http://wp-shop.ru/wpshop-full-settings/id4" target="_blank" class="wpshop_admin_ask"><img src="<?php echo WPSHOP_URL.'/images/help_icon.png';?>"/></a></td>
					</tr>
					<tr>
						<td><label for="wpshop_payments_activate"><?php  _e('Show payment method', 'wp-shop'); /*Показывать способ оплаты:*/ ?></label></td>
						<?php $payments_activate = $this->payments_activate == 1 ? " checked" : ""; ?>
						<td><input type="checkbox" name="wpshop_payments_activate" id="wpshop_payments_activate"<?php  echo $payments_activate;?>/>
            <a href="http://wp-shop.ru/wpshop-full-settings/id5" target="_blank" class="wpshop_admin_ask"><img src="<?php echo WPSHOP_URL.'/images/help_icon.png';?>"/></a></td>
					</tr>
					<tr>
						<td><label for="wpshop_mail_activate"><?php  _e('Activate custom mail editor:', 'wp-shop'); /* Активировать редактор писем:*/ ?></label></td>
						<?php $mail_activate = $this->mail_activate == 1 ? " checked" : ""; ?>
						<td><input type="checkbox" name="wpshop_mail_activate" id="wpshop_mail_activate"<?php  echo $mail_activate;?>/>
            <a href="http://wp-shop.ru/wpshop-full-settings/id6" target="_blank" class="wpshop_admin_ask"><img src="<?php echo WPSHOP_URL.'/images/help_icon.png';?>"/></a></td>
					</tr>
					<tr>
						<td><label for="wpshop_show_panel"><?php  _e('The behavior of the buy button:', 'wp-shop'); /* Поведение кнопки купить :*/ ?></label></td>
						<td><?php 
								$show_panel_activate = $this->show_panel_activate;
								if ($show_panel_activate == 0) { $s1 = ' selected="selected"'; $s2 = ''; $s3 = '';}
								if ($show_panel_activate == 1) { $s1 = ''; $s2 = ' selected="selected"';$s3 = '';}
								if ($show_panel_activate == 2) { $s1 = ''; $s2 = '';$s3 = ' selected="selected"';}
							?>
							<select name="wpshop_show_panel" style="width:90%;"> 
								<option value=0 <?php echo $s1?>><?php  _e('Nothing to do', 'wp-shop'); ?></option>
								<option value=1 <?php echo $s2?>><?php  _e('Show the cart widget', 'wp-shop');  ?></option>
								<option value=2 <?php echo $s3?>><?php  _e('Move to cart page', 'wp-shop');  ?></option>
							</select>
						<a href="http://wp-shop.ru/wpshop-full-settings/id7" target="_blank" class="wpshop_admin_ask"><img src="<?php echo WPSHOP_URL.'/images/help_icon.png';?>"/></a></td>
					</tr>
					<!--сортировка цен-->
					<tr>
						<td><label for="wpshop_sort_price"><?php  _e('How to sort price:', 'wp-shop'); /* Как сортировать цены:*/ ?></label></td>
						<td><?php 
								$sort_price = $this->wpshop_sort_price_type;
								if ($sort_price == 0) { $t1 = ' selected="selected"'; $t2 = ''; $t3 = '';}
								if ($sort_price == 1) { $t1 = ''; $t2 = ' selected="selected"';$t3 = '';}
								if ($sort_price == 2) { $t1 = ''; $t2 = '';$t3 = ' selected="selected"';}
							?>
							<select name="wpshop_sort_price" style="width:90%;"> 
								<option value=0 <?php echo $t1?>><?php  _e('Sorting disabled', 'wp-shop'); ?></option>
								<option value=1 <?php echo $t2?>><?php  _e('Sorting in alphabetical order', 'wp-shop');  ?></option>
								<option value=2 <?php echo $t3?>><?php  _e('Sorting in reverse alphabetical order', 'wp-shop');  ?></option>
							</select>
						</td>
					</tr>
					<!--#сортировка цен-->
					<tr>
						<td><label for="wpshop_email"><?php  echo __('E-mail notification about shopping', 'wp-shop') /*E-mail уведомления о покупках*/ ?></label></td>
						<td><input style="width:90%;" type="text" name="wpshop_email" id="wpshop_email" value="<?php  echo esc_html($this->email);?>"/>
            <a href="http://wp-shop.ru/wpshop-full-settings/id8" target="_blank" class="wpshop_admin_ask"><img src="<?php echo WPSHOP_URL.'/images/help_icon.png';?>"/></a></td>
					</tr>
					<tr>
						<td><label for="wpshop_email_name"><?php  echo __('User name for E-mail notification', 'wp-shop') /*User name for E-mail*/ ?></label></td>
						<td><input type="text" style="width:90%;" name="wpshop_email_name" id="wpshop_email_name" value="<?php  echo esc_html($this->email_name);?>"/>
            <a href="http://wp-shop.ru/wpshop-full-settings/id9" target="_blank" class="wpshop_admin_ask"><img src="<?php echo WPSHOP_URL.'/images/help_icon.png';?>"/></a></td>
					</tr>
					<tr>
						<td><label for="wpshop_google_analytic"><?php  echo __('Tracking ID for E-commerce Google Analytics', 'wp-shop') /*Tracking ID*/ ?></label></td>
						<td><input type="text" style="width:90%;" name="wpshop_google_analytic" id="wpshop_google_analytic" value="<?php  echo $this->google_analytic;?>"/>
            <a href="http://wp-shop.ru/wpshop-full-settings/id10" target="_blank" class="wpshop_admin_ask"><img src="<?php echo WPSHOP_URL.'/images/help_icon.png';?>"/></a></td>
					</tr>
					<tr>
						<td><label for="wpshop_yandex_metrika"><?php  echo __('Tracking ID for E-commerce Yandex metrika', 'wp-shop') /*Tracking ID*/ ?></label></td>
						<td><input type="text" style="width:90%;" name="wpshop_yandex_metrika" id="wpshop_yandex_metrika" value="<?php  echo $this->yandex_metrika;?>"/>
            <a href="http://wp-shop.ru/wpshop-full-settings/id11" target="_blank" class="wpshop_admin_ask"><img src="<?php echo WPSHOP_URL.'/images/help_icon.png';?>"/></a></td>
					</tr>
					<tr>
						<td><label for="wpshop_partner_param"><?php  echo __('Partner id', 'wp-shop');?></label></td>
						<td><input type="text" style="width:90%;" name="wpshop_partner_param" id="wpshop_partner_param" value="<?php  echo $this->partner_param;?>"/>
            <a href="http://wp-shop.ru/wpshop-full-settings/id12" target="_blank" class="wpshop_admin_ask"><img src="<?php echo WPSHOP_URL.'/images/help_icon.png';?>"/></a></td>
					</tr>
					<tr>
						<td><label for="wpshop_google_analytic_cc"><?php  echo __('Currency for E-commerce Google Analytics', 'wp-shop') /*Currency*/ ?></label></td>
						<td>
							<?php 
								$currency = $this->google_analytic_cc;
								if ($currency == 'USD') { $p1 = ' selected="selected"'; $p2 = ''; $p3 = ''; $p4 = ''; $p5 = '';}
								if ($currency == 'EUR') { $p1 = ''; $p2 = ' selected="selected"';$p3 = ''; $p4 = ''; $p5 = '';}
								if ($currency == 'RUB') { $p1 = ''; $p2 = '';$p3 = ' selected="selected"'; $p4 = ''; $p5 = '';}
								if ($currency == 'UAH') { $p1 = ''; $p2 = '';$p3 = ''; $p4 = ' selected="selected"'; $p5 = '';}
								if ($currency == 'GBP') { $p1 = ''; $p2 = '';$p3 = ''; $p4 = ''; $p5 = ' selected="selected"';}
							?>
							<select name="wpshop_google_analytic_cc">
								<option value='USD' <?php echo $p1?>><?php  _e('USD', 'wp-shop'); /*Американские доллары*/ ?></option>
								<option value='EUR' <?php echo $p2?>><?php  _e('euro', 'wp-shop'); /*Евро*/ ?></option>
								<option value='RUB' <?php echo $p3?>><?php  _e('Russian Ruble', 'wp-shop'); /*Российские рубли*/ ?></option>
								<option value='UAH' <?php echo $p4?>><?php  _e('Ukrainian Hrivna', 'wp-shop'); /*Гривна*/ ?></option>
								<option value='GBP' <?php echo $p5?>><?php  _e('British Pounds', 'wp-shop'); /*Британские Фунты*/ ?></option>
							</select>
              <a href="http://wp-shop.ru/wpshop-full-settings/id13" target="_blank" class="wpshop_admin_ask"><img src="<?php echo WPSHOP_URL.'/images/help_icon.png';?>"/></a>
						</td>
					</tr>
          
					<tr>
						<td><label for="wpshop_hide_auth"><?php  echo __('Disable kind of authorization', 'wp-shop') /*Currency*/ ?></label></td>
						<td>
							<?php 
								$auth = $this->hide_auth;
								if ($auth == 'none') { $m1 = ' selected="selected"'; $m2 = ''; $m3 = '';}
								if ($auth == 'register') { $m1 = ''; $m2 = ' selected="selected"';$m3 = '';}
								if ($auth == 'guest') { $m1 = ''; $m2 = '';$m3 = ' selected="selected"';}
							?>
							<select name="wpshop_hide_auth" style="width:90%;"> 
								<option value='none' <?php echo $m1?>><?php  _e('no', 'wp-shop'); ?></option>
								<option value='register' <?php echo $m2?>><?php  _e('dissable register form', 'wp-shop');  ?></option>
								<option value='guest' <?php echo $m3?>><?php  _e('disable guest shoping', 'wp-shop');  ?></option>
							</select>
              <a href="http://wp-shop.ru/wpshop-full-settings/id14" target="_blank" class="wpshop_admin_ask"><img src="<?php echo WPSHOP_URL.'/images/help_icon.png';?>"/></a>
						</td>
					</tr>
					<tr>
						<script type="text/javascript">
						jQuery(document).ready(function()
						{
								jQuery('.wp-shop_delete_all').bind('click',function()
								{
									jQuery.post('<?php bloginfo('wpurl') ?>/wp-admin/admin-ajax.php', {action:'delete_all'},function(data, textStatus)
									{
										if (textStatus == "success")
										{
											alert('<?php  _e('Erase shop data', 'wp-shop'); /*Данные магазина очищены*/ ?>');
										}
									});
									return false;
								});
								
						});
						</script>
					
						<!--<td>
							<a href="" class="wp-shop_delete_all">Переустановка магазина</a>
						</td>-->
					</tr>
					<!--tr>
						<td><label for="wpshop_loginza_token_key_value"><?php  echo __('Loginza setting', 'wp-shop') ?></label></td>
						<td colspan="2">
							<table border="0" cellspacing="2" cellpadding="0">
							<tr><td><?php//  _e('Widget ID:');  ?></td><td><input type="text" style="width:250px" name="wpshop_loginza_widget_id" id="wpshop_loginza_widget_id" value="<?php//  echo $this->loginza_widget_id ?>"></td></tr>
							<tr><td><?php//  _e('Secret Key:'); ?></td><td><input type="text" style="width:250px" name="wpshop_loginza_secret_key" id="wpshop_loginza_secret_key" value="<?php // echo $this->loginza_secret_key ?>"></td></tr>
							</table>
						</td>
					</tr-->

					</table>
					<div style="width: 50%;float: left;text-align: right;min-width: 500px;">
						<ins data-revive-zoneid="1" data-revive-id="03af71d0efe35b0d7d888949e681431d"></ins><script async src="https://wp-shop.ru/adv/www/delivery/asyncjs.php"></script>
					</div>
					<div style="width: 50%;float: left;text-align: right;min-width: 500px;">
						<ins data-revive-zoneid="2" data-revive-id="03af71d0efe35b0d7d888949e681431d"></ins><script async src="https://wp-shop.ru/adv/www/delivery/asyncjs.php"></script>
					</div>
				</div>
			  </div>
		</div>


<div id="poststuff" class="narr">
	<div class="postbox">
		<h3><?php 
		_e('Link in format Yandex-XML. Enter it if the site in the Yandex.Market', 'wp-shop'); //Линк в формате Yandex-XML. Укажите его при публикации сайта в системе Yandex.Market
		?></h3>
		<div class="inside">
			<input type="text" readonly="readonly" value="<?php  echo $this->link_to_yml;?>" style="width:100%;" />
			<div style="width:100%;padding-top:10px">
				<?php 
				_e('This XML-file contains a list of items with not emptied price in your store.', 'wp-shop'); // Этот XML-файл содержит в себе список тех товаров Вашего магазина, у которых указана какая-либо цена
				echo ' ';
				_e('To exclude items from the list, add a custom field <code>noyml</code> with a value of 1.', 'wp-shop'); // Для того чтобы исключить товар из списка, добавьте произвольное поле <code>noyml</code> со значением 1
				echo ' ';
				_e('Read details about this option on the page: <a href="http://www.wp-shop.ru/yandex-market/" target="_blank">Publication items Yandex.market</a>', 'wp-shop'); // Подробнее об этой опции на этой странице - <a href="http://www.wp-shop.ru/yandex-market/" target="_blank">Публикация товаров в Яндекс.Маркете
				?>
			</div>
		</div>
	</div>
</div>

<div id="poststuff" class="narr">
	<div class="postbox">
		<h3><?php  _e('Cart', 'wp-shop'); /*Опции минимального заказа:*/ ?></h3>
		<div class="inside">
			<table style="width: 50%;float: left;min-width: 650px;">
				<thead><th colspan=2 style='text-align:left;'><?php  _e('Options of minimum order:', 'wp-shop'); /*Опции минимального заказа:*/ ?></th></thead>
				<tbody>
				<tr>
					<td><?php  _e('The minimum sum of order:', 'wp-shop'); /*Минимальная сумма заказа:*/ ?></td>
					<td style="min-width: 350px;">
						<input style="width: 90%;" type='text' name='minzakaz' value='<?php  echo $this->minzakaz;?>'/><a href="http://wp-shop.ru/wpshop-full-settings/id16" target="_blank" class="wpshop_admin_ask"><img src="<?php echo WPSHOP_URL.'/images/help_icon.png';?>"/></a>
					</td>
				</tr>
				<tr>
					<td><?php  _e('Message to the buyer:', 'wp-shop'); /*Сообщение для покупателя:*/ ?></td>
					<td style="min-width: 350px;">
						<textarea name='minzakaz_info' style="width: 90%;"/><?php  echo $this->minzakaz_info;?></textarea><a href="http://wp-shop.ru/wpshop-full-settings/id17" target="_blank" class="wpshop_admin_ask"><img src="<?php echo WPSHOP_URL.'/images/help_icon.png';?>"/></a>
					</td>
				</tr>
				<tr>
					<td><?php  _e('Link to the condition of delivery:', 'wp-shop'); /*Линк на условие доставки:*/ ?></td>
					<td style="min-width: 350px;"><input type='text' name='deliveyrCondition' style="width: 90%;" value='<?php  echo $this->deliveyrCondition;?>'/><a href="http://wp-shop.ru/wpshop-full-settings/id18" target="_blank" class="wpshop_admin_ask"><img src="<?php echo WPSHOP_URL.'/images/help_icon.png';?>"/></a></td>
				</tr>
				<tr>
					<td><?php  _e('Link to the return to shopping:', 'wp-shop'); /*Линк для возврата к покупкам:*/ ?></td>
					<td style="min-width: 350px;"><input type='text' name='shopping_return_link' style="width: 90%;" value='<?php  echo $this->shopping_return_link;?>'/><a href="http://wp-shop.ru/wpshop-full-settings/id19" target="_blank" class="wpshop_admin_ask"><img src="<?php echo WPSHOP_URL.'/images/help_icon.png';?>"/></a></td>
				</tr>
				<tr>
					<td><?php  _e('Link to to the cart page:', 'wp-shop'); /*Линк к корзине:*/ ?></td>
					<td style="min-width: 350px;"><input type='text' name='cartpage_link' style="width: 90%;" value='<?php  echo $this->cartpage_link;?>'/><a href="http://wp-shop.ru/wpshop-full-settings/id20" target="_blank" class="wpshop_admin_ask"><img src="<?php echo WPSHOP_URL.'/images/help_icon.png';?>"/></a></td>
				</tr>
				<tr>
					<td><label for="wp-shop_promo_activate"><?php  echo __('Activate Promocodes:', 'wp-shop'); /*Активировать скидочную систему*/?></label></td>
					<?php $promoActiveChecked = $this->promoActive == 1 ? " checked" : ""; ?>
					<td colspan="2"><input type="checkbox" name="wp-shop_promo_activate" id="wp-shop_promo_activate"<?php  echo $promoActiveChecked;?>/><a href="http://wp-shop.ru/wpshop-full-settings/id21" target="_blank" class="wpshop_admin_ask"><img src="<?php echo WPSHOP_URL.'/images/help_icon.png';?>"/></a></td>
					</tr>
			</tbody>
			</table>
			<table style="width: 50%;float: left;min-width: 650px;">
				<tbody>
					<tr>
						<td><strong><?php  _e('Discount:', 'wp-shop'); /*Скидка:*/ ?></strong></td>
						<td style="min-width: 350px;">
							<input type="text" name="discount" value="<?php  echo $this->discount;?>" style='width:90%'/><a href="http://wp-shop.ru/wpshop-full-settings/id22" target="_blank" class="wpshop_admin_ask"><img src="<?php echo WPSHOP_URL.'/images/help_icon.png';?>"/></a>
						</td>
					</tr>
				</tbody>
			</table>
			</div>

		</div>
	</div>
</div>

<div id="poststuff" class="narr">
	<div class="postbox">
		<h3><?php  _e('Item', 'wp-shop'); /* Товар */ ?></h3>
		<div class="inside">
			<div>
				<div>
					<table style="width: 50%;float: left;min-width: 650px;">
					<tbody>
					<tr>
						<td><?php  _e('Currency:', 'wp-shop'); /*Валюта:*/ ?></td>
						<td style="min-width: 350px;"><input type="text" name='currency'  style="width: 90%;" value='<?php  echo $this->currency;?>'/><a href="http://wp-shop.ru/wpshop-full-settings/id23" target="_blank" class="wpshop_admin_ask"><img src="<?php echo WPSHOP_URL.'/images/help_icon.png';?>"/></a></td>
					</tr>
					<tr>
						<td><?php  _e('Text if the product is no longer available:', 'wp-shop'); /*Текст, если товара нет в наличие:*/ ?></td>
						<td style="min-width: 350px;"><textarea name='noGoodText' style="width: 90%; height:100px"><?php  echo $this->noGoodText;?></textarea><a href="http://wp-shop.ru/wpshop-full-settings/id24" target="_blank" class="wpshop_admin_ask"><img src="<?php echo WPSHOP_URL.'/images/help_icon.png';?>"/></a></td>
					</tr>
					</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<input type="submit" value="<?php  _e('Save', 'wp-shop'); /*Сохранить*/ ?>" class="button">

</td>
<td valign='top' style="width:320px;padding:10px 10px">
<div id="poststuff" class="metabox-holder" style="padding:0px; min-width: 300px;">
	<div id="side-sortables" class="meta-box-sortabless ui-sortable">
		<div id="sm_pnres" class="postbox">
		<h3 class="hndle"><span><?php  _e('Information from the WP-Shop developers', 'wp-shop'); /*Информация от разработчиков WP-Shop*/ ?></span></h3>
			<div class="inside">
				<div>
					<ins data-revive-zoneid="3" data-revive-id="03af71d0efe35b0d7d888949e681431d"></ins><script async src="https://wp-shop.ru/adv/www/delivery/asyncjs.php"></script>
				</div>
				
				<div>
					<ins data-revive-zoneid="4" data-revive-id="03af71d0efe35b0d7d888949e681431d"></ins><script async src="https://wp-shop.ru/adv/www/delivery/asyncjs.php"></script>
				</div>

				<ul>
					<li><?php  _e('<strong>Authors of the plugin:</strong> Alexander Kuznetsov, Abramov Kirill', 'wp-shop'); /*<strong>Авторы плагина:</strong> Кузнецов Александр, Бобко Игорь, Макарьин Сергей */ ?></li>
					<li><?php  _e('<strong>The Website plugin:</strong> <a href="http://www.wp-shop.ru/" target="_blank">www.wp-shop.ru</a>', 'wp-shop'); /*<strong>Сайт плагина:</strong> <a href="http://www.wp-shop.ru/" target="_blank">www.wp-shop.ru</a>*/ ?></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<div id="poststuff" class="metabox-holder" style="padding:0px; min-width: 300px;">
	<div id="side-sortables" class="meta-box-sortabless ui-sortable">
		<div id="sm_pnres" class="postbox">
			<h3 class="hndle"><span><?php  _e('META-box for display a price list', 'wp-shop'); /*META-поле для вывода в прайс-листах*/ ?></span><a href="http://wp-shop.ru/wpshop-full-settings/id25" target="_blank" class="wpshop_admin_ask"><img src="<?php echo WPSHOP_URL.'/images/help_icon.png';?>"/></a></h3>
			<div class="inside" id="price_option_window">
			<script type="text/javascript">
				jQuery(document).ready(function()
				{
						jQuery('#price_submit').bind('click',function()
						{
							jQuery.post('<?php bloginfo('wpurl') ?>/wp-admin/admin-ajax.php',{action:'ajax_post',act:'price_options',under_title:jQuery("[name='under_title']").val()},function(data, textStatus)
							{
								if (textStatus == "success")
								{
									alert('<?php  _e('Done', 'wp-shop'); /*Готово*/ ?>');
								}
							},'html');
					});
				});
				</script>
				<div><p><?php  _e('Here you can specify the name of an additional <code>post_meta</​​code>, which you want to display in pricelists', 'wp-shop'); /*Здесь можно указать наименование дополнительного <code>post_meta</code>, которое Вы хотите показывать в прайслистах.*/ ?></p></div>
				<br/>
				<input type='text' name="under_title" value="<?php  echo $this->opt_under_title;?>">
				<div class="submit"><input id="price_submit" type='button' value="<?php  _e('Save', 'wp-shop'); /*Сохранить*/ ?>"></div>
			</div>
		</div>
	</div>
</div>
<div id="poststuff" class="metabox-holder" style="padding:0px; min-width: 300px;">
	<div id="side-sortables" class="meta-box-sortabless ui-sortable">
		<div id="sm_pnres" class="postbox">
			<h3 class="hndle"><span><?php  _e('Currency update.', 'wp-shop'); /*Обновление по валюте.*/ ?></span><a href="http://wp-shop.ru/wpshop-full-settings/id26" target="_blank" class="wpshop_admin_ask"><img src="<?php echo WPSHOP_URL.'/images/help_icon.png';?>"/></a></h3>
			<div class="inside">
				<script type="text/javascript">
				jQuery(document).ready(function()
				{
						jQuery('#update_currency').bind('click',function()
						{
							jQuery.post('<?php bloginfo('wpurl') ?>/wp-admin/admin-ajax.php', {action:'set_currency',usd:jQuery("[name='usd']").val(),eur:jQuery("[name='eur']").val()},function(data, textStatus)
							{
								if (textStatus == "success")
								{
									alert('<?php  _e('Done', 'wp-shop'); /*Готово*/ ?>');
								}
							});

						});
				});
				</script>
				<div>USD - <input type='input' value="<?php  echo $this->usd_cur;?>" name="usd"></div>
				<div>EUR - <input type='input' value="<?php  echo $this->eur_cur;?>" name="eur"></div>
				<br/>
				<div>
					<input type='button' value="<?php  _e('Update', 'wp-shop'); /*Обновить*/ ?>" id="update_currency">
				</div>
			</div>
		</div>
	</div>


	</td>
</tr>
</tbody>
</table>
</form>
</div>
