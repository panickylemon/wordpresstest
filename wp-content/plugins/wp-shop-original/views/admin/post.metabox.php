<script type="text/javascript">
if (wpshopAdmin == undefined)
{
	var wpshopAdmin = new Wpshop_Admin_Post(<?php  echo $this->post_id;?>,'<?php  echo WPSHOP_URL;?>');
}
</script>
<table><tr><td>
<table id="post-metabox-table">
<thead>
	<tr>
		<th><div class="wpshop_animate_icon wpshop_plus_icon" onclick="javascript:wpshopAdmin.addCost();" title="Добавить"></div></th>
		<th>Наименование</th>
		<th>Цена</th>
		<th>В наличие</th>
	</tr>
</thead>
<tbody>
	<?php 
	foreach($this->goodData->getCosts() as $cost)
	{
		echo "<tr class='wpshop_tr_cost' meta_id='{$cost->id}'>";
		echo "<td><div class='wpshop_animate_icon wpshop_minus_icon' onclick='javascript:wpshopAdmin.deleteCost({$cost->id})' title='Удалить'></div></td>";
		echo "<td><input type='text' class='wpshop-name-meta' name='name_{$cost->id}' value=\"{$cost->name}\"/></td>";
		echo "<td><input type='text' class='wpshop-cost-meta' name='cost_{$cost->id}' value=\"{$cost->cost}\"/></td>";
		$countChecked = "";
		if ($cost->count > 0)
		{
			$countChecked = " checked";
		}
		echo "<td align='center'><input type='checkbox' name='sklad_{$cost->id}'{$countChecked} class='wpshop-count-meta'/></td>";
		echo "</tr>";
	}
	?>
	</tr>
</tbody>
</table>

<div style='margin:10px 0px;'>
<strong>Дополнительные свойства товара</strong>
<br/>
<textarea style="width:315px;height:130px;" name="meta_prop"><?php  echo $this->goodData->getProp();?></textarea>
</div>

<div style='margin:10px 0px;'>
<strong>Путь к картинке для Яндекс.Маркета</strong>
<br/>
<textarea style="width:315px;height:130px;" name="meta_yml_pic"><?php  echo $this->goodData->getYmlPic();?></textarea>
</div>
</td><td valign="top">
<div style='margin:5px 10px;'>
<strong>Краткое описание для витрины</strong>
<br/>
<textarea style="width:315px;height:130px;" name="meta_shorttext"><?php  echo $this->goodData->getShortText();?></textarea>
</div>
</td></tr></table>
<div>
	<input type="button" value="Сохранить" onclick="wpshopAdmin.saveMetaBox();" class="button"/>
</div>
