/**
 * @author WP Shop Team
 * @version 0.1
 * Depends:
 *	jquery.js jquery.ui.core.min.js jquery.effects.core.min.js
 */

jQuery.fn.jDymForm = function(parent,elements,options)
{
	this.pID = parent;
	this.lastid = 0;
	this.elements = elements;
	// Setting Default options
	this.options = {images:'img',showTitle:true};
	var THIS = this;
	
	this.images = {};

	this.deleteHook = 0;
	
	this.init = function()
	{		
		/** Проверка опций */
		if (options != undefined)
		{
			if (options.images != undefined)
			{
				this.options.images = options.images;
			}
			if (options.showTitle != undefined)
			{
				this.options.showTitle = options.showTitle;
			}
		}
		
		/** Загрузка иображений плагины */
		this.images.plus = new Image();
		this.images.plus.src = this.options.images + '/plus_icon.gif';
		this.images.minus = new Image();
		this.images.minus.src = this.options.images + '/minus_icon.gif';
		
		/** Строим таблицу */
		var template = "<table id='dfTable'><thead>";
		
		if (this.options.showTitle)
		{
			//Generating header
			template = template + "<thead>";
			for (key in this.elements)
			{
				template = template + "<th>" + this.elements[key].title + "</th>";
			}
			template = template + '<th><div id="dfAddButton" class="df_animate_icon"  style="background-color: #C4D2E1; background-image: url('+this.images.plus.src+'); height: 17px; width: 17px;"/></th></thead>';
		}
		
		template = template + '<tbody></tbody></table>';
		jQuery(this.pID).html(template);
		/** Конец постройке таблицы*/
		
		jQuery("#dfTable #dfAddButton").click(function()
		{
			THIS.add();
		});
		this.button_effect();
	}
	
	this.add = function(values)
	{
		this.lastid++;
		var tr = "<tr id='_dfe" + this.lastid + "'>";
		for (key in this.elements)
		{
			var currentValue;
			if (values != undefined && this.elements[key].name in values)
			{
				currentValue = values[this.elements[key].name];
				if (this.elements[key].uniq != undefined && this.elements[key].uniq)
				{
					var error = false;
					jQuery("#dfTable tbody tr").each(function(index,obj)
					{
						if (jQuery(obj).find("[name='"+THIS.elements[key].name+"\[\]']").val() == currentValue)
						{
							error = true;
							return;
						}
					});
					if (error)
					{
						alert("Поле с таким значение уже присутствует");
						return false;
					}
				}
			}
			else
			{
				currentValue = undefined;
			}
			tr = tr + "<td>" + this.generateInput(this.elements[key],currentValue) + "</td>";
		}
		tr = tr + '<td><div class="df_animate_icon df_delete_tr"  style="background-color: #C4D2E1; background-image: url('+this.images.minus.src+'); height: 17px; width: 17px;"/></td>';
		
		jQuery(this.pID + " #dfTable tbody").append(tr);
		this.button_effect();
		return this.lastid;
	}
	
	// this method may be done more effectly.
	this.generateInput = function(data,currentValue)
	{
		var obj;
		if (data.type == "text")
		{
			var value = '';
			if (currentValue != undefined)
			{
				value = currentValue;
			}
			else if (data.value != undefined)
			{
				value = data.value;
			}
			obj = jQuery("<input type='text' value=\""+value+"\"/>");
			
			if (data.readonly != undefined && data.readonly)
			{
				obj.attr("readonly","readonly");
			}
		}
		
		if (data.type == "select")
		{
			obj = jQuery("<select/>");
			if (data.items instanceof Array)
			for (i in data.items)
			{
				obj.append("<option value='"+data.items[i].value+"'>"+data.items[i].text+"</option>");
			}
		}
		var value = '';		
		if (data.type == "hidden")
		{
			if (currentValue != undefined)
			{
				value = currentValue;
			}
			else if (data.value != undefined)
			{
				value = data.value;
			}
			var dom = "<input type='hidden' value='"+value+"' />";
			obj = jQuery(dom);
		}
		
		if (data.name != undefined)
		{
			obj.attr('name',data.name + "[]");
		}
		
		var Return = jQuery("<div></div>").append(obj);
		
		if (data.showHidden != undefined && data.showHidden)
		{
			Return.append(value);
		}
		return Return.html();
	}
	
	this.button_effect = function()
	{
		/** Анимируем кнопку добавить */
		jQuery(".df_animate_icon").hover(function()
		{
			if (jQuery.effects != undefined)
			{
				jQuery(this).animate({"background-color": '#6B8DB1'}, 200 );
			}
			else
			{
				jQuery(this).css("background-color", '#6B8DB1');
			}
		},
		function()
		{
			if (jQuery.effects!= undefined)
			{
				jQuery(this).animate({"background-color": '#C4D2E1'}, 200 );
			}
			else
			{
				jQuery(this).css("background-color", '#C4D2E1');
			}
		});

		jQuery(".df_delete_tr").click(function()
		{
			if (THIS.deleteHook)
			{
				THIS.deleteHook();
			}
			jQuery(this).closest("tr").remove();	
		});		
	}
	this.init();
	return this;
}