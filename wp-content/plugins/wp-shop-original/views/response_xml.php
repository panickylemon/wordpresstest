<?php header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

<checkOrderResponse performedDatetime="<?php echo date('c'); ?>" code="<?php echo $code; ?>" invoiceId="<?php echo $_POST['invoiceId']; ?>" shopId="<?php echo $_POST['shopId']; ?>" />
