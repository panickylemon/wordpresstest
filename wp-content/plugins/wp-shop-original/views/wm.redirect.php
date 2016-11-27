<form id=pay name=pay method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp">
<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="<?php  echo $this->amount;?>">
<input type="hidden" name="LMI_PAYMENT_DESC" value="Order #<?php  echo $this->payment_no;?>">
<input type="hidden" name="LMI_PAYMENT_NO" value="<?php  echo $this->payment_no;?>">
<input type="hidden" name="LMI_PAYEE_PURSE" value="<?php  echo get_option('wpshop.payments.wm.wmCheck');?>">
<input type="hidden" name="LMI_SIM_MODE" value="0">
</form>
<script type='text/javascript'>
jQuery(function()
{
	jQuery("#pay").submit();
});
</script>