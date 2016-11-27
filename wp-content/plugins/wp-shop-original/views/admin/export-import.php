<style type="text/css">
dl.fields
{
	border: 1px solid #DDDDDD;
	padding: 5px;
}
dl.fields dt
{
	cursor: pointer;
	border: 1px solid #DDDDDD;
	margin: 5px;
	background: #EEEEEE;
}

h4
{
	margin: 5px 0px;
}

#dfTable tr
{
	cursor: pointer;
}
</style>
<div class="wrap">
	<h2><?php  _e("Advanced import/export", 'wp-shop'); /*Расширенный экспорт/импорт*/ ?></h2>
	<div id="poststuff">
		<div class="postbox" style="clear:both;overflow:hidden;">
			<h3><?php  _e('Exports', 'wp-shop'); /*Экспорт*/; ?></h3>
			<form action="<?php  echo $_SERVER['REQUEST_URI'];?>" method="post" >
				<div style="float:left;margin:15px;">
					<h4><?php  _e('Main fields', 'wp-shop'); /*Основные поля*/; ?></h4>
					<dl class="fields post_field">
						<?php 
						foreach ($this->postColumns as $col)
						{
							switch ($col->Field)
							{
								case 'ID': break;
								default: echo "<dt>{$col->Field}</dt>";
							}
						}
						?>
					</dl>
				</div>
				<div style="float:left;margin:15px;">
					<h4><?php  _e('Custom fields (meta)', 'wp-shop'); /*Произвольные поля (meta)*/; ?></h4>
					<dl class="fields meta_field">
						<?php 
						foreach ($this->metaKeys as $key)
						{
							if (strpos($key->meta_key, "goods_id") === FALSE && strpos($key->meta_key , "_") !== 0)
							{
								echo "<dt>{$key->meta_key}</dt>";
							}
						}
						?>
					</dl>
				</div>

				<div style="float:left;margin:15px;">
				<h4><?php  _e('The resulting fields', 'wp-shop'); /*Результирующие поля*/; ?></h4>
				<div id="resultFields">

				</div>
				<script type="text/javascript">
				var df = jQuery().jDymForm("#resultFields",
					[
						{name:"none", title:"", type:'hidden', value:"#", showHidden:true},
						{name:"fieldName", title:"", type:'text', readonly:true, uniq:true},
						{name:"fieldType", title:"", type:'hidden'},
					],
					{images:"<?php  echo WPSHOP_URL."/images";?>", showTitle:false}
				);
				jQuery(".post_field dt").click(function()
				{
					df.add({fieldName:jQuery(this).html(),fieldType:0});
				});

				jQuery(".meta_field dt").click(function()
				{
					df.add({fieldName:jQuery(this).html(),fieldType:1});
				});
				jQuery("#dfTable tbody").sortable();
				</script>
				</div>
				<div style="clear:both;"></div>
				<div style="margin:15px;">
					<input type="checkbox" name="include_cat" value="1"/> <?php  _e('Export categories', 'wp-shop'); /*Экспортировать категории*/; ?><br/>
					<input type="checkbox" name="include_tag" value="1"/> <?php  _e('Export tags', 'wp-shop'); /*Экспортировать метки*/; ?><br/><br/>
					<input type="submit" name="submit_wpshop_export" value="<?php  _e('Export', 'wp-shop'); /*Экспортировать*/; ?>" />
				</div>
				</form>
			</div>
	</div>
	<div id="poststuff">
		<div class="postbox">
			<h3><?php  _e('Import', 'wp-shop'); /*Импорт*/; ?></h3>
			<form action="<?php  echo $_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
				<input type="file" id="import" name="import" />
				<div class="submit"><input type="submit" name="submit_wpshop_import" value="<?php  _e('Import', 'wp-shop'); /*Импортировать*/; ?>" /></div>
			</form>
		</div>
	</div>
</div>