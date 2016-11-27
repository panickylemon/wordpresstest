<?php header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<paymentAvisoResponse performedDatetime="<?php echo esc_html(date('c')); ?>" code="<?php echo esc_html($code); ?>" invoiceId="<?php echo esc_html($_POST['invoiceId']); ?>" shopId="<?php echo esc_html($_POST['shopId']); ?>" />
