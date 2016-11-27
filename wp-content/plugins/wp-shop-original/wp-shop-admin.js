function Wpshop_Admin_Post(post_id,plugin_url)
{
	this.plugin_url = plugin_url;
	this.post_id = post_id;
	this.addCost = function()
	{
		var max_id = 1;
		jQuery(".wpshop_tr_cost").each(function(index,obj)
		{
			var t = jQuery(obj).attr('meta_id');
			if (t > max_id) max_id = t;
		});
		max_id = max_id*1 + 1;
		jQuery('#post-metabox-table tbody').append("<tr class='wpshop_tr_cost' meta_id='"+max_id+"'><td><div class='wpshop_animate_icon wpshop_minus_icon' onclick='javascript:wpshopAdmin.deleteCost("+max_id+")' title='Удалить'></div></td><td><input type='text' class='wpshop-name-meta' name='name_" + max_id + "' value='A'/></td><td><input type='text' class='wpshop-cost-meta' name='cost_"+max_id+"' value='0'/></td><td align='center'><input type='checkbox' name='sklad_"+max_id+"' checked='checked' class='wpshop-count-meta'/></td></tr>");
		button_effect();
	}
	
	this.deleteCost = function(meta_id)
	{
		var AjaxData = {'wpshop-ajax':'delete-post-cost','post_id':this.post_id,'wpshop-meta-cost':{}};
		
		jQuery(".wpshop_tr_cost").each(function(index,obj)
		{
			if (jQuery(obj).attr('meta_id') == meta_id)
			{
				var t = jQuery(obj).find('.wpshop-name-meta').attr('name');
				AjaxData['wpshop-meta-cost'][index] = {name:{'meta_name':jQuery(obj).find('.wpshop-name-meta').attr('name'),'meta_value':jQuery(obj).find('.wpshop-name-meta').val()},
													  'cost':{'meta_name':jQuery(obj).find('.wpshop-cost-meta').attr('name'),'meta_value':jQuery(obj).find('.wpshop-cost-meta').val()},
													  'count': {'meta_name':jQuery(obj).find('.wpshop-count-meta').attr('name'),'meta_value':jQuery(obj).find('.wpshop-count-meta').val()}
													  };
				jQuery(obj).remove();
			}
		});
		
		
		jQuery.ajax({
			type: "POST",
			url: "/wp-admin/post.php",
			data: AjaxData,
			success: function(msg){

			}
		});
	}
	
	this.saveMetaBox = function()
	{
		var inside = jQuery('#wp-shop-p-metabox .inside');
		inside.prepend('<div id="wpshop-saving-box" style="position:absolute;width:'+inside.width()+'px;height:100%;'+inside.height()+'px;background:gray;opacity:0.3;padding-top:'+(inside.height()/2)+'px;text-align:center"><img src="'+this.plugin_url+'/images/loader-line.gif" border="0"/></div>');
		
		var AjaxData = {'wpshop-ajax':'save-post-data','post_id':this.post_id,'wpshop-meta-cost':{}};
		
		jQuery(".wpshop_tr_cost").each(function(index,obj)
		{
			// Оно же мета поле склада
			var count = 0;
			if (jQuery(obj).find('.wpshop-count-meta').attr("checked"))
			{
				count = 1;
			}
			
			
			var t = jQuery(obj).find('.wpshop-name-meta').attr('name');
			AjaxData['wpshop-meta-cost'][index] = {'name':{'meta_name':jQuery(obj).find('.wpshop-name-meta').attr('name'),'meta_value':jQuery(obj).find('.wpshop-name-meta').val()},
												   'cost':{'meta_name':jQuery(obj).find('.wpshop-cost-meta').attr('name'),'meta_value':jQuery(obj).find('.wpshop-cost-meta').val()},
												   'count':{'meta_name':jQuery(obj).find('.wpshop-count-meta').attr('name'),'meta_value':count}
												   };
		});
		
		AjaxData['wpshop-prop'] = jQuery("[name='meta_prop']").val();
		AjaxData['wpshop-yml_pic'] = jQuery("[name='meta_yml_pic']").val();
		AjaxData['wpshop-shorttext'] = jQuery("[name='meta_shorttext']").val();
		
		
		jQuery.ajax({
			type: "POST",
			url: "/wp-admin/post.php",
			data: AjaxData,
			success: function(msg)
			{
				alert("Сохранено");
			}
		});
		inside.children('#wpshop-saving-box').remove();
		return false;	
	}
	return this;
}


