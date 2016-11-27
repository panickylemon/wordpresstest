<table>
<!--thead>
<tr style="background-color:#CCCCCC">
	<th>Поле</th>
	<th>Значение</th>
</tr>
</thead-->
<?php 
foreach($this->order['cforms'] as $value)
{
	echo "<tr><td>{$value['name']}</td><td>{$value['value']}</td></tr>";
}
?>
</table>

<br/><br/>
<table style="width:100%">
<tr style="background-color:#CCCCCC">
	<th><?php  _e('Name', 'wp-shop'); /*Наименование*/; ?></th>
	<th>&nbsp;</th>
	<th><?php  _e('Price', 'wp-shop'); /*Цена*/; ?></th>
	<th><?php  _e('Qty', 'wp-shop'); /*Кол-во*/; ?></th>
	<th><?php  _e('Sum', 'wp-shop'); /*Сумма*/; ?></th>
</tr>
<?php 
$key = 0;
$price = 0;
foreach($this->order['offers'] as $offer)
{

$price = round($offer['partnumber'] * $offer['price'],2);
	$itogo += $price;
	if ($key++ % 2) $color = "white";
	else $color = "#DDDDDD";
	echo "<tr style='background-color:{$color};'>
		<td><a href='".get_permalink($offer['post_id'])."'>{$offer['name']}</a></td>
		<td style='text-align:center'>{$offer['key']}</td>
		<td style='text-align:center'>{$offer['price']}</td>
		<td style='text-align:center'>{$offer['partnumber']}</td>
		<td style='text-align:center'>{$price}</td>
	</tr>";
}
?>
<tr><td colspan='3'><?php  _e('Total:', 'wp-shop'); /*Итого:*/; ?></td><td><?php  echo $itogo;?></td></tr>
<?php 

if ($this->order['info']['discount'])
{
	$itogo = round($itogo - $itogo / 100 * $this->order['info']['discount'],2);
	echo "<tr><td colspan='3'>".__('Discount price', 'wp-shop') . " ({$this->order['info']['discount']}%)</td><td>{$itogo}</td></tr>";
}

if ($this->order['info']['promo'])
{
	echo "<tr><td colspan='3'>".__('Promocode: ', 'wp-shop').$this->order['info']['promo']."</td></tr>";
}

$delivery = Wpshop_Delivery::getInstance()->getDelivery($this->order['info']['delivery']);
if ($delivery)
{
	$itogo += $delivery->cost;
	echo "<tr><td colspan='3'>".__('Delivery', 'wp-shop') ." ({$delivery->name})</td><td>{$delivery->cost}</td></tr>";
}
?>
<tr>
	<td colspan='3'><?php  _e('In all', 'wp-shop'); /*Всего*/; ?></td>
	<td><?php  echo $itogo;?></td>
</tr>
</table>
