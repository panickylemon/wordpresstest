<table class="vitrina_wrap" style="width:100%">
<?php 
$posts_per_page = $this->rowCount * $this->colCount;

if (isset($this->category))
{
	$selection = "cat={$this->category}";
}
else
{
	$selection = "tag={$this->tag}";
}

$query = new WP_Query("{$selection}&showposts={$posts_per_page}&paged={$this->page}");
$counter = 0;

while($query->have_posts())
{
	$query->the_post();
	$image = get_post_meta($query->post->ID,'pic',true);
	$short_text = get_post_meta($query->post->ID,'short_text',true);
	if (empty($short_text))
	{
		$short_text = "".mb_substr(strip_tags($query->post->post_content),0,$this->countSimbols)."...";
	}
	$buy_block = $this->shop->GetGoodWidget($query->post,null,array('name'=>true,'cost'=>true,'add'=>true));
	$detail = "<a href='" . get_permalink( $query->post->ID ) . "'>".__('Details' /*Подробнее*/, 'wp-shop')."</a>";

	if (($counter % $this->colCount) == 0) echo "<tr valign='top'>";
	echo "<td style='padding:0px;width:260px;'>";
	echo "<div class='vitrina_element' style='height:{$this->height}px;'>";
	echo "<div class='vitrina_header'><a href='".get_permalink( $query->post->ID )."'>".$query->post->post_title."</a></div>";
	echo "<div class='vitrina_image'>{$image}</div>";
	echo "<div class='shopwindow_content'>{$short_text}</div>";
	echo "<div class='vitrina_detail shopwindow_content' style='text-align:right'>{$detail}</div>";
	echo "<div align='center' style='margin-top:20px;'>{$buy_block}</div>";
	echo "</div>";
	echo "</td>";
	$counter++;
	if (($counter % $this->colCount) == 0) echo "</tr>";
}
wp_reset_query();

$was = false;
while(($counter % $this->colCount) != 0)
{
	echo "<td style='width:1%'></td>";
	$was = true;
	$counter++;
}
if ($was) echo"</tr>";
?>
</table>
<?php 
if ( $posts_per_page > 0 ) {
	$pages = array();

	for ($i = 0; $i < $query->found_posts/$posts_per_page; $i++)
	{
		if ($this->page == $i+1)
		{
			$pages[] = '<span>'.($i+1).'</span>';
		}
		else
		{
			$uri = $_SERVER["REQUEST_URI"];
			if (strpos($uri,'?') === false)
			{
				$separate = "?";
			}
			else
			{
				$separate = "&";
			}

			if (strpos($uri,'vpage') === false)
			{
				$url = "{$uri}{$separate}vpage=".($i+1);
			}
			else
			{
				$url = preg_replace("/vpage=(\d+)/","vpage=".($i+1),$uri);
			}
			$pages[] = "<a href='{$url}'>".($i+1)."</a>";
		}
	}
	echo "<div align='center' class='wpshop_pagg'>" . join('',$pages) . "</div>";
}
