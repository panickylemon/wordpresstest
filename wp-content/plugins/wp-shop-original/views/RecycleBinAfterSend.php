<?php 
$last = Wpshop_RecycleBin::getInstance()->getLastOrder();
$order = new Wpshop_Order($this->order['id']);
$ordered_products = $order->getOrderItemsFull($this->order['id']);
if ($ordered_products){
foreach($ordered_products as $product) {
	$product['count'];
	$meta = get_post_custom($product['post_id']);
	foreach ($meta as $key => $val)
	{
		if ( preg_match('/^cost_(\d+)/i', $key, $m) )
		{
			$costs[$m[1]] = $val[0];
		}
			
	}
	
	if (count($costs) > 0)
	{
		
		foreach ($costs as $key => $val)
		{
			$val_r = round($val,2);
			$key_order='';
			if ($product['cost']==$val_r)
			{
				$key_order=$key;
				$name='sklad_'.$key_order;
				$old = get_post_meta( $product['post_id'],$name, true );
        if($old){
				$new = (int)$old - $product['count'];
				update_post_meta($product['post_id'],$name,$new); 
        }
			}
			
		}
		
	}
}
}
		
if ($this->order['info']['payment'] == "wm") {

?>
<form action="https://merchant.webmoney.ru/lmi/payment.asp" method="POST">
	<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="<?php  echo $order->getTotalSum();?>"/>
	<input type="hidden" name="LMI_PAYMENT_DESC_BASE64" value="<?php  echo base64_encode(__('Order', 'wp-shop')." #{$this->order['id']} ".__('from site', 'wp-shop')." {$_SERVER['HTTP_HOST']}");?>"/>
	<input type="hidden" name="LMI_PAYEE_PURSE" value="<?php  echo $this->wm['wmCheck'];?>"/>
	<input type="hidden" name="LMI_SUCCESS_URL" value="<?php  echo $this->wm['successUrl'];?>"/>
	<input type="hidden" name="LMI_FAIL_URL" value="<?php  echo $this->wm['failedUrl'];?>"/>
	<input type="hidden" name="LMI_RESULT_URL" value="<?php  echo bloginfo('wpurl')."/?wmResult=1&order_id={$this->order['id']}";?>"/>
	<input type="submit" class=\"wpshop-button\" value="<?php  echo __('Pay WM', 'wp-shop'); // Оплатить WM ?>"/>
</form>
<?php 
} elseif ($this->order['info']['payment'] == "yandex_kassa") {
?>
<form action="https://<?php if($this->yandex_kassa['test']==true){echo 'demo';}?>money.yandex.ru/eshop.xml" method="POST" id="payment_form">
	<input type="hidden" name="shopId" value="<?php  echo $this->yandex_kassa['shopId'];?>" />
	<input type="hidden" name="scid" value="<?php  echo $this->yandex_kassa['scid'];?>" />
	<input type="hidden" name="sum" value="<?php  echo $order->getTotalSum();?>" />
	<input type="hidden" name="customerNumber" value="<?php echo $this->order['id'];?>" />
	<input type="hidden" name="orderNumber" value="<?php echo $this->order['id'];?>" />
	<input type="hidden" name="custom" value="<?php echo session_id();?>" />
	<input type="hidden" name="cps_email" value="<?php echo $order->getOrderEmail();?>" />
	<input type="hidden" name="shopSuccessURL" value="<?php echo $this->yandex_kassa['successUrl'];?>" />
	<input type="hidden" name="shopFailURL" value="<?php echo $this->yandex_kassa['failedUrl'];?>" />
	<input type="hidden" name="paymentType" value="<?php echo $_GET['paymentType'];?>" />
	<input type="hidden" name="cms_name" value="wordpress_wp-shop-original" />
	<input type="submit" class=\"wpshop-button\" value="<?php  echo __('Pay Yandex kassa', 'wp-shop'); // Оплатить Yandex касса ?>"/>
</form>
<?php 
}elseif($this->order['info']['payment'] == "robokassa"){

// регистрационная информация (логин, пароль #1)
// registration info (login, password #1)
$mrh_login = $this->robokassa['login'];
$mrh_pass1 = $this->robokassa['pass1'];

// номер заказа
// number of order
$inv_id = $this->order['id'];

// описание заказа
// order description
$inv_desc = urlencode(__('Order', 'wp-shop')." #{$this->order['id']} ".__('from site', 'wp-shop')." {$_SERVER['HTTP_HOST']}.");

// сумма заказа
// sum of order
$out_summ = $order->getTotalSum();

// тип товара
// code of goods
$shp_item = 1;

// предлагаемая валюта платежа
// default payment e-currency
$in_curr = "PCR";

// язык
// language
$culture = "ru";

// кодировка
// encoding
$encoding = "utf-8";

// формирование подписи
// generate signature
$crc  = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:Shp_item=$shp_item");

// HTML-страница с кассой
// ROBOKASSA HTML-page
print "<script language=JavaScript ".
      "src='https://auth.robokassa.ru/Merchant/PaymentForm/FormMS.js?".
//      "src='https://test.robokassa.ru/Handler/MrchSumPreview.ashx?".
      "MrchLogin=$mrh_login&OutSum=$out_summ&InvId=$inv_id&IncCurrLabel=$in_curr".
      "&Desc=$inv_desc&SignatureValue=$crc&Shp_item=$shp_item".
      "&Culture=$culture&Encoding=$encoding'></script>";

?>
<?php 
}elseif($this->order['info']['payment'] == "ek"){
$fields = array(); 

// Добавление полей формы в ассоциативный массив
$fields["WMI_MERCHANT_ID"]    = $this->ek['wmCheck'];
$fields["WMI_PAYMENT_AMOUNT"] = $order->getTotalSum();
$fields["WMI_CURRENCY_ID"]    = $this->ek['currency_ek'];
$fields["WMI_PAYMENT_NO"]     = $this->order['id'];
$fields["WMI_DESCRIPTION"]    = __('Order', 'wp-shop')." #{$this->order['id']} ".__('from site', 'wp-shop')." {$_SERVER['HTTP_HOST']}.";
$fields["WMI_SUCCESS_URL"]    = $this->ek['successUrl'];
$fields["WMI_FAIL_URL"]       = $this->ek['failedUrl'];
$fields["SESSION_USER"]       = session_id();

//Если требуется задать только определенные способы оплаты, раскоментируйте данную строку и перечислите требуемые способы оплаты.
// if (isset($_GET['rk'])){$fields["WMI_PTENABLED"] = $_GET['rk'];} 

// Формирование HTML-кода платежной формы

print "<form action=\"https://merchant.w1.ru/checkout/default.aspx\" method=\"POST\">";

foreach($fields as $key => $val)
{
    if (is_array($val))
       foreach($val as $value)
       {
     print "<input type=\"hidden\" name=\"$key\" value=\"$value\"/>";
       }
    else	    
       print "<input type=\"hidden\" name=\"$key\" value=\"$val\"/>";
}
$button_name = __('Pay EK', 'wp-shop');// Оплатить в Единой кассе
print "<input type=\"submit\" class=\"wpshop-button\" value=\"".$button_name."\"/></form>";
?>

<?php 
}elseif($this->order['info']['payment'] == "simplepay"){

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function makeSigStr ( $strScriptName, array $arrParams, $strSecretKey ) {
  unset($arrParams['sp_sig']);
  
  ksort($arrParams);

  array_unshift($arrParams, $strScriptName);
  array_push   ($arrParams, $strSecretKey);

  return join(';', $arrParams);
}

$fields = array(); 

// Добавление полей формы в ассоциативный массив
$fields["sp_outlet_id"]    = $this->simplepay['outlet_id'];
$fields["sp_order_id"] = $this->order['id'];
$fields["sp_partner_id"]    = '18';
$fields["sp_amount"]     = $order->getTotalSum();
$fields["sp_description"]    = __('Order', 'wp-shop')." #{$this->order['id']} ".__('from site', 'wp-shop')." {$_SERVER['HTTP_HOST']}.";
$fields["sp_user_params"]    =  session_id();
$fields["sp_currency"]       = $this->simplepay['currency_simplepay'];
$fields["sp_salt"]       = rand(21,43433);
$fields["sp_user_ip"] = get_client_ip();
$fields["sp_user_name"] = $this->order['info']['username'];
$fields["sp_user_contact_email"] = $this->order['info']['email'];

$sp_sig_before  = makeSigStr('payment',$fields,$this->simplepay['secure']);
$fields["sp_sig"] =  md5($sp_sig_before);
print_r($fields["order"]);
?>

<form action="https://api.simplepay.pro/sp/payment" method="POST"> 
   
    <?php foreach($fields as $key => $val)
    {
    if (is_array($val))
       foreach($val as $value)
       {
     print "<input type=\"hidden\" name=\"$key\" value=\"$value\"/>";
       }
    else	    
       print "<input type=\"hidden\" name=\"$key\" value=\"$val\"/>";
    }?>
    <input type="submit" class=\"wpshop-button\" value="<?php  echo __('Pay Simplepay', 'wp-shop'); // Оплатить через Simplepay ?>"/>
  </form>

<?php 
} elseif($this->order['info']['payment'] == "paypal"){

$fields = array(); 

// Добавление полей формы в ассоциативный массив

$fields["cmd"]         = '_cart';
$fields["upload"] 	   = 1;
$fields["business"]    = $this->paypal['email'];
$fields["amount_1"]      = $order->getTotalSum();
$text = __('Order', 'wp-shop')." #{$this->order['id']} ".__('from site', 'wp-shop')." {$_SERVER['HTTP_HOST']}.";
$convertedText = mb_convert_encoding($text, 'utf-8', mb_detect_encoding($text));
$fields["item_name_1"]      = $convertedText;
$fields["currency_code"] 	   = $this->paypal['currency_paypal'];
$fields["no_shipping"] 	   = 1;
$fields["invoice"] 	   = $this->order['id'];
$fields["custom"] 	   = session_id();
$fields["return"] 	   = $this->paypal['success'];
$fields["notify_url"] 	   = 'http://'.$_SERVER['HTTP_HOST'];
// Формирование HTML-кода платежной формы
if($this->paypal['test']==true){print "<form action=\"https://www.sandbox.paypal.com/cgi-bin/webscr\" method=\"post\" accept-charset=\"UTF-8\">";}
else{ print "<form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" accept-charset=\"UTF-8\">";}

foreach($fields as $key => $val)
{
    if (is_array($val))
       foreach($val as $value)
       {
     print "<input type=\"hidden\" name=\"$key\" value=\"$value\"/>";
       }
    else	    
       print "<input type=\"hidden\" name=\"$key\" value=\"$val\"/>";
}

print "<input type=\"image\" value=\"PayPal\" src=\"https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif\" alt=\"Submit button\" align=\"left\" style=\"margin-right:7px;\" /></form>";

} elseif($this->order['info']['payment'] == "chronopay"){
if($this->chronopay['order']==true){
$sign = md5($this->chronopay['product_id'].'-'.$order->getTotalSum().'-'.$this->order['id'].'-'.$this->chronopay['sharedsec']);}else{
$sign = md5($this->chronopay['product_id'].'-'.$order->getTotalSum().'-'.$this->chronopay['sharedsec']);
}
?>
  <form action="https://payments.chronopay.com/" method="POST"> 
    <input type="hidden" name="product_id" value="<?php  echo $this->chronopay['product_id'];?>" /> 
    <input type="hidden" name="product_price" value="<?php  echo $order->getTotalSum();?>" />
    <input type="hidden" name="order_id" value="<?php echo $this->order['id'];?>" />     
    <input type="hidden" name="cs1" value="<?php echo session_id();?>" /> 
    <input type="hidden" name="cb_type" value="P" />
    <input type="hidden" name="cb_url" value="<?php echo 'http://'.$_SERVER['HTTP_HOST'];?>" /> 
    <input type="hidden" name="success_url" value="<?php  echo $this->chronopay['success'];?>" /> 
    <input type="hidden" name="decline_url" value="<?php  echo $this->chronopay['failed'];?>" /> 
    <input type="hidden" name="sign" value="<?php echo $sign; ?>" /> 
    <input type="submit" class=\"wpshop-button\" value="<?php  echo __('Pay Chronopay', 'wp-shop'); // Оплатить через ChronoPay ?>"/>
  </form>
<?php  } else {?>
<script type="text/javascript">
jQuery(document).ready(function()
{
	window.__cart.reset();
});
</script>
<?php  }?>