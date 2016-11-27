<?php 
if ($this->dataSend) {
	$this->render("RecycleBinAfterSend.php");
	return;
}

?>

<script type="text/javascript">
<?php   if (is_user_logged_in()&&$_GET['payment']){ ?>
	jQuery(function($) {
	<?php 
	$form = Wpshop_Forms::getInstance()->getFormByName("wpshop-" . $_GET['payment']);
	global $current_user;
	

	
	foreach($form['fields'] as $field) {

	if ($field['type'] == "Name") {
			echo "$('[name=\"{$field['postName']}\"]').val('{$current_user->first_name} {$current_user->last_name}');";
		}
		if ($field['type'] == "Phone") {
			echo "$('[name=\"{$field['postName']}\"]').val('{$current_user->phone}');";
		}
		if ($field['type'] == "Address") {
			echo "$('[name=\"{$field['postName']}\"]').val('{$current_user->address}');";
		}
		if ($field['email']) {
			echo "$('[name=\"{$field['postName']}\"]').val('{$current_user->user_email}');";
		}
	}
	?>
	});
<?php  } ?>

<?php 
if (!empty($this->cartCols['name'])) echo " window.cart_col_name ='{$this->cartCols['name']}';\n";
if (!empty($this->cartCols['price'])) echo " window.cart_col_price ='{$this->cartCols['price']}';\n";
if (!empty($this->cartCols['count'])) echo " window.cart_col_count ='{$this->cartCols['count']}';\n";
if (!empty($this->cartCols['sum'])) echo " window.cart_col_sum ='{$this->cartCols['sum']}';\n";
if (!empty($this->cartCols['type'])) echo " window.cart_col_type ='{$this->cartCols['type']}';\n";

?>
jQuery(function()
{
	jQuery('.cform').prepend("<input type='hidden' name='payment' value='<?php  echo $_GET['payment'];?>'/>");
	
});
</script>



<div id="<?php  echo CART_ID;?>">
	<noscript><?php  echo __('You need activate support of JavaScript and Cookies in your browser.', 'wp-shop');?></noscript>
</div>

<?php 
//Подсчет количества общей суммы

$total = 0;
global $wpdb;
$param_sum = array(session_id());
$rows = $wpdb->get_results($wpdb->prepare("SELECT sum(selected_items_cost*selected_items_num) as total FROM {$wpdb->prefix}wpshop_selected_items WHERE selected_items_session_id='%s'",$param_sum));
foreach ($rows as $row) {
	$total = $row->total;
}

$yandex_num = get_option("wpshop.yandex_metrika");
if($yandex_num){
global $wpdb;
$param_yan = array(session_id());
$rows1 = $wpdb->get_results($wpdb->prepare("SELECT selected_items_item_id as id, selected_items_name as name, selected_items_cost as price, selected_items_num as quantity FROM {$wpdb->prefix}wpshop_selected_items WHERE selected_items_session_id='%s'",$param_yan));

$yandex_params= array(
	'order_id'=>time(),
	'order_price'=>$total,
	'goods'=>$rows1
);

$yandex = json_encode($yandex_params,JSON_NUMERIC_CHECK);

?>
<script type="text/javascript">
jQuery(function()
{
	
	jQuery('.cform').submit(function(e){
	  //Prevent form submit: e.preventDefault()
	  //Do whatever
	  yaCounter<?php echo $yandex_num;?>.reachGoal('wpshop_order_full',<?php echo $yandex;?>);
	});
});
</script>
<?php }//end of yandex ?>
<?php 
$can_do = true;
if (!empty($this->minzakaz))
{
	if ($total > 0 && $total < $this->minzakaz)
	{
		$can_do	= false;
	}
}

//Определение скидки.
$max_discount = 0;
if ($this->discount != '')
{
	foreach(explode("\r\n",$this->discount) as $value)
	{
		$q = explode(":",$value);
		if ($total > $q[0])
		{
			if ($max_discount < $q[1])
			{
				$max_discount = $q[1];
			}
		}
	}
	echo "<script type='text/javascript'>jQuery(document).ready(function(){
			window.__cart.discount = '" . str_replace("\r","",str_replace("\n",';',$this->discount)) . "';
			window.__cart.update();
	});</script>";
}

if ($total > 0) {

	if ($can_do)
	{
		if (function_exists("insert_cform") && ($this->cform !== false || $this->cform != ""))
		{
			if (count($this->payments))
			{

				?>
				
				<?php 

				if (is_user_logged_in()){
					//nothing
				}
				else{
					$just_registred_user_id	= 0;
					$wpshop_reg_error = '';
					$wpshop_auth_error = '';

					if (isset($_POST['wpshop_regiser_usr_btn'])){
						$wpshop_reg_mode = 1;
						$wpshop_style_reg = '';
						$wpshop_style_auth = 'style="display:none"';
					}else{
						$wpshop_reg_mode = 0;
						$wpshop_style_reg = 'style="display:none"';
						$wpshop_style_auth = '';
					}

					if (isset($_POST) and count($_POST)>0){
						if (isset($_POST['wpshop_regiser_usr_btn'])){
							// Register:
							$wpshop_user_name = htmlspecialchars(stripslashes($_POST['wpshop_user_name']));
							$wpshop_user_password = htmlspecialchars(stripslashes($_POST['wpshop_user_password']));
							$wpshop_user_email = htmlspecialchars(stripslashes($_POST['wpshop_user_email']));
							if (strlen($wpshop_user_name)<3 or strlen($wpshop_user_name)>16){
								$wpshop_reg_error .= _('Lenght of the login needs to be 3 to 16 characters.','wp-shop').'<br>';
							}
							if (strlen($wpshop_user_password)<3 or strlen($wpshop_user_password)>16){
								$wpshop_reg_error .= _('Lenght of the password needs to be 3 to 16 characters.','wp-shop').'<br>';
							}
							if (!preg_match("/^([a-zA-Z0-9])+([\.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)*\.([a-zA-Z]{2,6})$/", $wpshop_user_email)){
								$wpshop_reg_error .= _('Incorrect E-mail.','wp-shop').'<br>';
							}

							if (empty($wpshop_reg_error)){
								$user = array(
								    'user_login' => $wpshop_user_name,
								    'user_pass' => $wpshop_user_password,
								    'first_name' => '',
								    'last_name' => '',
								    'user_email' => $wpshop_user_email,
								    'role'=>'Customer'
								    );
								$just_registred_error = wp_insert_user($user);
								if (!is_wp_error($just_registred_error)){
									$just_registred_user_id = $just_registred_error;
									wp_new_user_notification( $just_registred_user_id, $wpshop_user_password );
									$wpshop_style_reg = 'style="display:none"';
									$wpshop_style_auth = '';
								}else{
									$wpshop_reg_error = $just_registred_error->get_error_message();
								}
							}
						}elseif($_POST['wpshop_auth_usr_btn']){
							$wpshop_user_name = htmlspecialchars(stripslashes($_POST['wpshop_user_name']));
							$wpshop_user_password = htmlspecialchars(stripslashes($_POST['wpshop_user_password']));
							$creds = array();
							$creds['user_login'] = $wpshop_user_name;
							$creds['user_password'] = $wpshop_user_password;
							$creds['remember'] = false;
							$user = wp_authenticate($wpshop_user_name, $wpshop_user_password);
							if ( is_wp_error($user) ){
								$wpshop_reg_error = $user->get_error_message();
							}
						}

					}else{
						$wpshop_user_name = '';
						$wpshop_user_password = '';
						$wpshop_user_email = '';
						$wpshop_reg_error = '';
					}

					if ($_GET['step']=='2'){
					?>
                <?php $hide_auth = get_option("wpshop.hide_auth");?>
                <?php if($hide_auth !='register'){ ?>
								<div class="wpshop-auth-site">
									<script type="text/javascript">
										function wpshop_reg_form(){
												jQuery('#wpshop-butt-1').hide();
												jQuery('#wpshop-butt-2').show();
												jQuery('#wpshop_txt_auth').hide();
												jQuery('#wpshop_txt_reg').show();
												jQuery('#wpshop-reg_email-txt').show();
												jQuery('#wpshop-reg_email-input').show();
										}
										function wpshop_auth_form(){
												jQuery('#wpshop-butt-1').show();
												jQuery('#wpshop-butt-2').hide();
												jQuery('#wpshop_txt_auth').show();
												jQuery('#wpshop_txt_reg').hide();
												jQuery('#wpshop-reg_email-txt').hide();
												jQuery('#wpshop-reg_email-input').hide();
										}
									</script>

									<div class="wpshop-auth-txt" id="wpshop_txt_auth" <?php  echo $wpshop_style_auth ?>><?php  _e('Checkout as a registered user:', 'wp-shop'); ?></div>
									<div class="wpshop-auth-txt" id="wpshop_txt_reg" <?php  echo $wpshop_style_reg ?>><?php  _e('Registration on the site:', 'wp-shop'); ?></div>
									<br>
									<?php 
										if (!empty($wpshop_reg_error)){
											echo '<div style="font-weight:bold; color:#b00">'.$wpshop_reg_error.'</div><br>';
										}elseif(!empty($wpshop_auth_error)){

											$wpshop_auth_error = str_replace('<a ', '<a target="_blank" ', $wpshop_auth_error);
											echo '<div style="font-weight:bold; color:#b00">'.$wpshop_auth_error.'</div><br>';
										}elseif($just_registred_user_id){
											echo '<div style="font-weight:bold; color:#b00">'.__('You have been successfull registered!','wp-shop').'</div><br>';
										}
										//$current_url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
										//echo wp_login_url($current_url);
									?>
									<form action="" method="post" id="wpshop_reg_user_form">
										<div>
											<label for="wpshop_user_name"><?php  _e('Login:', 'wp-shop'); ?></label>
										</div>
										<div>
											<input class="wpshop-name" type="text" name="wpshop_user_name" id="wpshop_user_name" value="<?php  echo $wpshop_user_name; ?>">
										</div>
										<div>
											<label for="wpshop_user_password"><?php  _e('Password', 'wp-shop'); ?>:</label>
										</div>
										<div>
											<input class="wpshop-password" type="password" name="wpshop_user_password" id="wpshop_user_password" value="<?php  echo $wpshop_user_password; ?>">
										</div>
										<div id="wpshop-reg_email-txt" <?php  echo $wpshop_style_reg ?>>
											<label for="wpshop_user_email">E-mail:</label>
										</div>
										<div id="wpshop-reg_email-input" <?php  echo $wpshop_style_reg ?>>
											<input class="wpshop-email" type="text" name="wpshop_user_email" id="wpshop_user_email" value="<?php  echo $wpshop_user_email; ?>">
										</div>
										<div id="wpshop-butt-1" <?php  echo $wpshop_style_auth ?>>
											<input class="wpshop-button1 wpshop-button-bg1" type="submit" name="wpshop_auth_usr_btn" value="<?php  _e('Enter', 'wp-shop'); ?>">
											<input class="wpshop-button2 wpshop-button-bg2" type="button" name="wpshop_regiser_usr_btn" value="<?php  _e('Register', 'wp-shop'); ?>" onclick="wpshop_reg_form()">
										</div>
										<div id="wpshop-butt-2" <?php  echo $wpshop_style_reg ?>>
											<input class="wpshop-button2 wpshop-button-bg1" type="submit" name="wpshop_regiser_usr_btn" value="<?php  _e('Register', 'wp-shop'); ?>">
											<input class="wpshop-button1 wpshop-button-bg2" type="button" name="wpshop_auth_usr_btn" value="<?php  _e('Enter', 'wp-shop'); ?>" onclick="wpshop_auth_form()">
										</div>
									</form>
								</div>
                <?php } ?>
                <?php if($hide_auth !='guest'){ ?>
								<div class="wpshop-auth-site">
									<div class="wpshop-auth-txt"><?php  _e('Or checkout as a guest', 'wp-shop'); ?></div><br>
									
									<form action="" method="get" id="wpshop_reg_user_form">
										<?php if($_GET['page_id']){?>
                      <input type="hidden" name="page_id" value="<?php echo $_GET['page_id'];?>">
                    <?php }?>
										<input type="hidden" name="step" value="3">
										<input type="submit" value="<?php  _e('Checkout as a guest', 'wp-shop'); ?>">
									</form>
									
								</div>
                <?php } ?>
 							
						<?php 
					}

                }
				if (isset($_GET['step']) and $_GET['step']=='2' && is_user_logged_in()) {
					echo "<script type='text/javascript'>document.location='/?step=3'</script>";
				}
				if (isset($_GET['step']) and $_GET['step']=='3'){

					if (!isset($_GET['payment']))
					{
					?>
					<div id='payments-table'>
						<h3 id='mode-paymets-title'>
							<?php  echo __('Select a payment method', 'wp-shop');?>:
						</h3>
						<ul>
							<?php 
							$robokassa = false;
							$wpshop_merchant_system = get_option("wpshop_merchant_system");
							$wpshop_merchant = get_option("wpshop_merchant");
							foreach($this->payments as $payment)
							{
								if ($payment->data['activate'] == true && $payment->merchant == false )
								{
									echo "<li>
											<a href='{$payment->data[cart_url]}&step=3&payment={$payment->paymentID}'><img src='".WPSHOP_URL."/images/payments/{$payment->picture}' title='{$payment->name}'/></a><br/>
											<a href='{$payment->data[cart_url]}&step=3&payment={$payment->paymentID}'>{$payment->name}</a>
										  </li>";
									
								}
							}
							
							foreach($this->payments as $payment)
							{
								if ($payment->merchant == true&&$wpshop_merchant)
								{
									if ($payment->paymentID == "robokassa"&& $wpshop_merchant_system =="robokassa")
									{ 
										$robokassa = $payment;
									}
									if ($payment->paymentID == "ek"&& $wpshop_merchant_system =="ek")
									{ 
										$ek = $payment;
									}
									if ($payment->paymentID == "yandex_kassa"&& $wpshop_merchant_system =="yandex_kassa")
									{ 
										$yandex_kassa = $payment;
									}
								}
							}
							
							?>
						</ul>
					</div>
					<?php  if ($yandex_kassa){?>
					<div id='payments-table'>
					<h3 id='mode-paymets-title'>
						<?php 
							echo __('Payment is made through a payment service Yandex kassa <br/> Small extra comission.', 'wp-shop'); //Оплата производится через платежный сервис RoboKassa.ru<br/> Взимается небольшая дополнительная комисcия.
						?>
					</h3>
					<ul>
						<li>
							<a href='<?php  echo "{$yandex_kassa->data[cart_url]}&step=3&payment={$yandex_kassa->paymentID}&paymentType=PC";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/yandexmoney.png' title=''/></a><br/>
							<a href='<?php  echo "{$yandex_kassa->data[cart_url]}&step=3&payment={$yandex_kassa->paymentID}&paymentType=PC";?>'><?php  echo __('Yandex - Money', 'wp-shop');?></a>
						</li>
						<li>
							<a href='<?php  echo "{$yandex_kassa->data[cart_url]}&step=3&payment={$yandex_kassa->paymentID}&paymentType=AC";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/mastercard.png' title=''/></a><br/>
							<a href='<?php  echo "{$yandex_kassa->data[cart_url]}&step=3&payment={$yandex_kassa->paymentID}&paymentType=AC";?>'><?php  echo __('Credit card', 'wp-shop');?></a>
						</li>
						<li>
							<a href='<?php  echo "{$yandex_kassa->data[cart_url]}&step=3&payment={$yandex_kassa->paymentID}&paymentType=GP";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/cashterminal.png' title=''/></a><br/>
							<a href='<?php  echo "{$yandex_kassa->data[cart_url]}&step=3&payment={$yandex_kassa->paymentID}&paymentType=GP";?>'><?php  echo __('Terminals', 'wp-shop');?></a>
						</li>
						<li>
							<a href='<?php  echo "{$yandex_kassa->data[cart_url]}&step=3&payment={$yandex_kassa->paymentID}&paymentType=MC";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/mts.png' title=''/></a><br/>
							<a href='<?php  echo "{$yandex_kassa->data[cart_url]}&step=3&payment={$yandex_kassa->paymentID}&paymentType=MC";?>'><?php  echo __('Mobile', 'wp-shop');?></a>
						</li>
						<?php if( $yandex_kassa->data['webmoney']){?>
									<li>
										<a href='<?php  echo "{$yandex_kassa->data[cart_url]}&step=3&payment={$yandex_kassa->paymentID}&paymentType=WM";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/wbmoney.png' title=''/></a><br/>
										<a href='<?php  echo "{$yandex_kassa->data[cart_url]}&step=3&payment={$yandex_kassa->paymentID}&paymentType=WM";?>'><?php  echo __('Webmoney', 'wp-shop');?></a>
									</li>
						<?php } ?>
						<?php if( $yandex_kassa->data['sber']){?>
									<li>
										<a href='<?php  echo "{$yandex_kassa->data[cart_url]}&step=3&payment={$yandex_kassa->paymentID}&paymentType=SB";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/sberonline.png' title=''/></a><br/>
										<a href='<?php  echo "{$yandex_kassa->data[cart_url]}&step=3&payment={$yandex_kassa->paymentID}&paymentType=SB";?>'><?php  echo __('Sberbank online', 'wp-shop');?></a>
									</li>
						<?php } ?>
						<?php if( $yandex_kassa->data['qiwi']){?>
									<li>
										<a href='<?php  echo "{$yandex_kassa->data[cart_url]}&step=3&payment={$yandex_kassa->paymentID}&paymentType=QW";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/qiwiwallet.png' title=''/></a><br/>
										<a href='<?php  echo "{$yandex_kassa->data[cart_url]}&step=3&payment={$yandex_kassa->paymentID}&paymentType=QW";?>'><?php  echo __('QIWI wallet', 'wp-shop');?></a>
									</li>
						<?php } ?>
						<?php if( $yandex_kassa->data['prom']){?>
									<li>
										<a href='<?php  echo "{$yandex_kassa->data[cart_url]}&step=3&payment={$yandex_kassa->paymentID}&paymentType=PB";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/psbretail.png' title=''/></a><br/>
										<a href='<?php  echo "{$yandex_kassa->data[cart_url]}&step=3&payment={$yandex_kassa->paymentID}&paymentType=PB";?>'><?php  echo __('Promsvyazbank', 'wp-shop');?></a>
									</li>
						<?php } ?>
						<?php if( $yandex_kassa->data['master']){?>
									<li>
										<a href='<?php  echo "{$yandex_kassa->data[cart_url]}&step=3&payment={$yandex_kassa->paymentID}&paymentType=MA";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/masterpass.png' title=''/></a><br/>
										<a href='<?php  echo "{$yandex_kassa->data[cart_url]}&step=3&payment={$yandex_kassa->paymentID}&paymentType=MA";?>'><?php  echo __('MasterPass', 'wp-shop');?></a>
									</li>
						<?php } ?>
						<?php if( $yandex_kassa->data['alfa']){?>
									<li>
										<a href='<?php  echo "{$yandex_kassa->data[cart_url]}&step=3&payment={$yandex_kassa->paymentID}&paymentType=AB";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/alfaclick.png' title=''/></a><br/>
										<a href='<?php  echo "{$yandex_kassa->data[cart_url]}&step=3&payment={$yandex_kassa->paymentID}&paymentType=AB";?>'><?php  echo __('Alfa-Click', 'wp-shop');?></a>
									</li>
						<?php } ?>
						<?php if( $yandex_kassa->data['dover']){?>
									<li>
										<a href='<?php  echo "{$yandex_kassa->data[cart_url]}&step=3&payment={$yandex_kassa->paymentID}&paymentType=QP";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/dover.png' title=''/></a><br/>
										<a href='<?php  echo "{$yandex_kassa->data[cart_url]}&step=3&payment={$yandex_kassa->paymentID}&paymentType=QP";?>'><?php  echo __('Doveritelniy payment', 'wp-shop');?></a>
									</li>
						<?php } ?>
						<?php if( $yandex_kassa->data['credit']){?>
									<li>
										<a href='<?php  echo "{$yandex_kassa->data[cart_url]}&step=3&payment={$yandex_kassa->paymentID}&paymentType=KV";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/kupi.png' title=''/></a><br/>
										<a href='<?php  echo "{$yandex_kassa->data[cart_url]}&step=3&payment={$yandex_kassa->paymentID}&paymentType=KV";?>'><?php  echo __('Buy in credit', 'wp-shop');?></a>
									</li>
						<?php } ?>
					</ul>
					</div>
					<?php }?>
					<?php  if ($robokassa){?>
					<div id='payments-table'>
					<h3 id='mode-paymets-title'>
						<?php 
							echo __('Payment is made through a payment service RoboKassa.ru <br/> Small extra comission.', 'wp-shop'); //Оплата производится через платежный сервис RoboKassa.ru<br/> Взимается небольшая дополнительная комисcия.
						?>
					</h3>
					<ul>
						<li>
							<a href='<?php  echo "{$robokassa->data[cart_url]}&step=3&payment={$robokassa->paymentID}&rk=yandex";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/yandexmoney.png' title=''/></a><br/>
							<a href='<?php  echo "{$robokassa->data[cart_url]}&step=3&payment={$robokassa->paymentID}&rk=yandex";?>'><?php  echo __('Yandex - Money', 'wp-shop');?></a>
						</li>
						<li>
							<a href='<?php  echo "{$robokassa->data[cart_url]}&step=3&payment={$robokassa->paymentID}&rk=card";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/visa.png' title=''/></a><br/>
							<a href='<?php  echo "{$robokassa->data[cart_url]}&step=3&payment={$robokassa->paymentID}&rk=card";?>'>Visa</a>
						</li>
						
						<li>
							<a href='<?php  echo "{$robokassa->data[cart_url]}&step=3&payment={$robokassa->paymentID}&rk=qiwi";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/qiwiwallet.png' title=''/></a><br/>
							<a href='<?php  echo "{$robokassa->data[cart_url]}&step=3&payment={$robokassa->paymentID}&rk=qiwi";?>'><?php  echo __('Terminals QIWI', 'wp-shop'); // Терминалы QIWI
							?></a>
						</li>
						
						<li>
							<a href='<?php  echo "{$robokassa->data[cart_url]}&step=3&payment={$robokassa->paymentID}&rk=wbmoney";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/wbmoney.png' title=''/></a><br/>
							<a href='<?php  echo "{$robokassa->data[cart_url]}&step=3&payment={$robokassa->paymentID}&rk=wbmoney";?>'>Web money</a>
						</li>
						
						<li>
							<a href='<?php  echo "{$robokassa->data[cart_url]}&step=3&payment={$robokassa->paymentID}&rk=cashterminal";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/cashterminal.png' title=''/></a><br/>
							<a href='<?php  echo "{$robokassa->data[cart_url]}&step=3&payment={$robokassa->paymentID}&rk=cashterminal";?>'><?php  echo __('Terminals', 'wp-shop'); // Терминалы?></a>
						</li>
						
						<li>
							<a href='<?php  echo "{$robokassa->data[cart_url]}&step=3&payment={$robokassa->paymentID}&rk=mobileretails";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/mobileretails.png' title=''/></a><br/>
							<a href='<?php  echo "{$robokassa->data[cart_url]}&step=3&payment={$robokassa->paymentID}&rk=mobileretails";?>'><?php  echo __('Mobile retails', 'wp-shop'); // Салоны связи?></a>
						</li>
						<li>
							<a href='<?php  echo "{$robokassa->data[cart_url]}&step=3&payment={$robokassa->paymentID}&rk=alfaclick";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/alfaclick.png' title=''/></a><br/>
							<a href='<?php  echo "{$robokassa->data[cart_url]}&step=3&payment={$robokassa->paymentID}&rk=alfaclick";?>'><?php  echo __('Alfa Click', 'wp-shop'); ?></a>
						</li>
						<li>
							<a href='<?php  echo "{$robokassa->data[cart_url]}&step=3&payment={$robokassa->paymentID}&rk=mts";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/mts.png' title=''/></a><br/>
							<a href='<?php  echo "{$robokassa->data[cart_url]}&step=3&payment={$robokassa->paymentID}&rk=mts";?>'><?php  echo __('MTS', 'wp-shop'); ?></a>
						</li>
						<li>
							<a href='<?php  echo "{$robokassa->data[cart_url]}&step=3&payment={$robokassa->paymentID}&rk=beeline";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/beeline.png' title=''/></a><br/>
							<a href='<?php  echo "{$robokassa->data[cart_url]}&step=3&payment={$robokassa->paymentID}&rk=beeline";?>'><?php  echo __('beeline', 'wp-shop'); ?></a>
						</li>
						<li>
							<a href='<?php  echo "{$robokassa->data[cart_url]}&step=3&payment={$robokassa->paymentID}&rk=mastercard";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/mastercard.png' title=''/></a><br/>
							<a href='<?php  echo "{$robokassa->data[cart_url]}&step=3&payment={$robokassa->paymentID}&rk=mastercard";?>'><?php  echo __('mastercard', 'wp-shop'); ?></a>
						</li>
						<li>
							<a href='<?php  echo "{$robokassa->data[cart_url]}&step=3&payment={$robokassa->paymentID}&rk=mailrumoney";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/mailrumoney.png' title=''/></a><br/>
							<a href='<?php  echo "{$robokassa->data[cart_url]}&step=3&payment={$robokassa->paymentID}&rk=mailrumoney";?>'><?php  echo __('mailrumoney', 'wp-shop'); ?></a>
						</li>
						<li>
							<a href='<?php  echo "{$robokassa->data[cart_url]}&step=3&payment={$robokassa->paymentID}&rk=walletone";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/walletone.png' title=''/></a><br/>
							<a href='<?php  echo "{$robokassa->data[cart_url]}&step=3&payment={$robokassa->paymentID}&rk=walletone";?>'><?php  echo __('Walletone', 'wp-shop'); ?></a>
						</li>
						
					</ul>
					</div>
					<?php }?>
					<?php  if ($ek){?>
					<div id='payments-table'>
					<h3 id='mode-paymets-title'>
						<?php  echo __('Payment is made through a payment service EK <br/> Small extra comission.', 'wp-shop');?>
					</h3>
					<ul>
						<li>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}&rk=VISA";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/visa.png' title=''/></a><br/>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}&rk=VISA";?>'><?php  echo __('visa', 'wp-shop'); 
							?></a>
						</li>
						<li>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}&rk=MasterCard";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/mastercard.png' title=''/></a><br/>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}&rk=MasterCard";?>'><?php  echo __('mastercard', 'wp-shop'); 
							?></a>
						</li>
						<li>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/sberonline.png' title=''/></a><br/>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}";?>'><?php  echo __('Sberbank-online', 'wp-shop'); 
							?></a>
						</li>
						<li>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}&rk=YandexMoneyRUB";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/yandexmoney.png' title=''/></a><br/>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}&rk=YandexMoneyRUB";?>'><?php  echo __('Yandex - Money', 'wp-shop'); 
							?></a>
						</li>
						<li>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}&rk=QiwiWalletRUB";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/qiwiwallet.png' title=''/></a><br/>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}&rk=QiwiWalletRUB";?>'><?php  echo __('Qiwi', 'wp-shop'); 
							?></a>
						</li>
						<li>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/psbretail.png' title=''/></a><br/>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}";?>'><?php  echo __('Promsvyazbank', 'wp-shop'); 
							?></a>
						</li>
						<li>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/alfaclick.png' title=''/></a><br/>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}";?>'><?php  echo __('Alfa-bank', 'wp-shop'); 
							?></a>
						</li>
						<li>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/privat24.png' title=''/></a><br/>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}";?>'><?php  echo __('Privat bank', 'wp-shop'); 
							?></a>
						</li>
						<li>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/russianpost.png' title=''/></a><br/>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}";?>'><?php  echo __('Post', 'wp-shop'); 
							?></a>
						</li>
						<li>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/lider.png' title=''/></a><br/>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}";?>'><?php  echo __('Leader', 'wp-shop'); 
							?></a>
						</li>
						<li>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}&rk=WalletOne";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/walletone.png' title=''/></a><br/>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}&rk=WalletOne";?>'><?php  echo __('WalletOne', 'wp-shop'); 
							?></a>
						</li>
						<li>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}&rk=BeelineRUB";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/beeline.png' title=''/></a><br/>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}&rk=BeelineRUB";?>'><?php  echo __('beeline', 'wp-shop'); 
							?></a>
						</li>
						<li>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}&rk=MtsRUB";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/mts.png' title=''/></a><br/>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}&rk=MtsRUB";?>'><?php  echo __('mts', 'wp-shop'); 
							?></a>
						</li>
						<li>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}&rk=MegafonRUB";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/megafon.png' title=''/></a><br/>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}&rk=MegafonRUB";?>'><?php  echo __('megafon', 'wp-shop'); 
							?></a>
						</li>
						<li>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/kievstar.png' title=''/></a><br/>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}";?>'><?php  echo __('Kievstar', 'wp-shop'); 
							?></a>
						</li>
						<li>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/euroset.png' title=''/></a><br/>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}";?>'><?php  echo __('Euroset', 'wp-shop'); 
							?></a>
						</li>
						<li>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/svyaznoy.png' title=''/></a><br/>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}";?>'><?php  echo __('Svyaznoy', 'wp-shop'); 
							?></a>
						</li>
						<li>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/unistream.png' title=''/></a><br/>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}";?>'><?php  echo __('Unistream', 'wp-shop'); 
							?></a>
						</li>
						<li>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/moneygram.png' title=''/></a><br/>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}";?>'><?php  echo __('Moneygram', 'wp-shop'); 
							?></a>
						</li>
						<li>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}&rk=LiqPayMoney";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/liqpaymoney.png' title=''/></a><br/>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}&rk=LiqPayMoney";?>'><?php  echo __('LiqPay', 'wp-shop'); 
							?></a>
						</li>
						<li>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}&rk=ZPaymentRUB";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/zpayment.png' title=''/></a><br/>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}&rk=ZPaymentRUB";?>'><?php  echo __('ZPayment', 'wp-shop'); 
							?></a>
						</li>
						<li>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}&rk=EasyPayBYR";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/easypay.png' title=''/></a><br/>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}&rk=EasyPayBYR";?>'><?php  echo __('EasyPay', 'wp-shop'); 
							?></a>
						</li>
						<li>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}&rk=BPayMDL";?>'><img src='<?php  echo WPSHOP_URL;?>/images/payments/bpay.png' title=''/></a><br/>
							<a href='<?php  echo "{$ek->data[cart_url]}&step=3&payment={$ek->paymentID}&rk=BPayMDL";?>'><?php  echo __('B-pay', 'wp-shop'); 
							?></a>
						</li>
						
					</ul>
					</div>
					<?php 
					}
					} else {					
						$this->render("RecycleBinPayment.php");
					}

				}

			}
			elseif ($_GET['step'] == 3 || ($_GET['step'] == 2 && !isset($_GET['payment'])))
			{			
				insert_cform($this->cform);
			}
		}
		else
		{
			echo '<div style="color:red">';
			_e('Error: Not installed cforms II.', 'wp-shop'); //Ошибка: Не установлен cforms II.
			echo '</div>';
		}
	}
	else
	{
		echo $this->minzakaz_info;
	}
}