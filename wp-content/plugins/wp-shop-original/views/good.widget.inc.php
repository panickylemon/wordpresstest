<div class="wpshop_bag <?php  echo $this->class;?>">
<input type='hidden' name="wpshop-good-title-<?php  echo $this->post->ID;?>" value='<?php  echo htmlspecialchars($this->post->post_title,ENT_QUOTES);?>'/>
	<div class="wpshop_buy">
		<table cellpadding="5" cellspacing="0" border="0" width="100%">
		<?php 
		$i = 0;
		foreach ($this->cost as $key => $val)
		{
			$i++;
			if ($this->sklad[$key] == "" || $this->sklad[$key] > 0)
			{
				$yandex_num = get_option("wpshop.yandex_metrika");
				if($yandex_num){$addClick = "addtocart('{$this->post->ID}', '{$key}', '".get_permalink($this->post->ID)."', '{$val}', document.getElementById('goods_count_{$this->post->ID}_{$i}').value, '{$i}','{$this->sklad[$key]}'); yaCounter{$yandex_num}.reachGoal('wpshop_click',{id:'{$this->post->ID}'}); return false;";}else{
				$addClick = "addtocart('{$this->post->ID}', '{$key}', '".get_permalink($this->post->ID)."', '{$val}', document.getElementById('goods_count_{$this->post->ID}_{$i}').value, '{$i}','{$this->sklad[$key]}'); return false;";}
				
				?>
				<tr class="line_<?php print $i; ?>">
					<?php  if (isset($this->columns['name'])){?>
					<td class="wpshop_caption">
						<a style="cursor: pointer" href="#" onclick="javascript:<?php  echo $addClick; ?>;" style="font-weight:bold;"><?php print $key; ?></a>
					</td>
					<?php  } ?>
					<?php  if (isset($this->columns['cost'])) { ?>
					<td class="wpshop_price">
						<?php  echo ($val . ' ' .CURR); ?>
					</td>
					<?php  } ?>
         
					<td class="wpshop_count">
						<input maxlength='4' type='text'  <?php if ($this->count[$key]>0){ echo "value='".$this->count[$key]."'";}else{echo "value='1'";}?> name='goods_count_<?php  echo "{$this->post->ID}_{$i}";?>' id='goods_count_<?php  echo "{$this->post->ID}_{$i}";?>' size='3' />
					</td>
					<td class="wpshop_button">
						<a href="#" onclick="<?php  echo $addClick; ?>" class="arrow_button" alt="<?php  echo __('Add', 'wp-shop'); /*Добавить*/ ?>" title="<?php  echo __('Order', 'wp-shop'); /*Заказать*/ ?>"></a>
					</td>
				</tr>
				<?php  if ($this->sklad[$key] > 0){?>
					<tr class="sklad">
						<td colspan="4">
						<?php 
							echo __('In stock ', 'wp-shop');
							echo ' '.$this->sklad[$key];
							echo __(' pcs.', 'wp-shop');
						?>
						</td>
					</tr>
				<?php }	?>
		<?php 
			}
			else
			{
				echo "<div class='empty_".$i." empty_shop'>";
				echo get_option("wpshop.good.noText");
				echo "</div>";
			}
		}
		?>
		</table>
	</div>
</div>
