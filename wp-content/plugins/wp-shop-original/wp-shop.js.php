<?php 
header("Content-Type: content=text; charset=utf-8");

?>
var cart_reload_promo_text = '';
jQuery( document ).ready(function( $ ) {

  jQuery( "#wpshop_cart" ).on( "click","input#promocode_button_block",function() {
 
    promocode=jQuery("#promocode_block").val();
	
    jQuery.post( object_name.url+"/wp-admin/admin-ajax.php", { action: "cart_promocode",promocode:promocode})

    .done(function( data ) {
      cart_reload_promo_text = data;
      window.__cart.update();
    });
  });

});

var CURR = '&nbsp;';

var SPL =	'}{';

var cart_col_name = object_name.name;
var cart_col_price = object_name.price;
var cart_col_count = object_name.count;
var cart_col_sum = object_name.sum;
var cart_col_type = '';


function wshop(url,cart,win)
{
	var self = this;
	var _url = url; // url with hash of prodovator
	var gSellers = []; // global array for this class of sellers
	var _cart = cart;
	var _win = win;

	this.findElement = function(arr,id)
	{
		var result = -1;
		jQuery.each(arr, function(i,item)
		{
			if (item.id == id)
			{
				result = i;
				return;
			}
		});
		return result;
	}
}

function Cart(eid_mini, eid_cart)
{
	this.mini = document.getElementById(eid_mini);
	this.cart = document.getElementById(eid_cart);
	this.discount = 0;
	

	var OnUpdate = undefined;
	var wps = undefined;

	var CARTTHIS = this;


	this.init = function()
	{
		this.count = 0;
		this.a_id = new Array();
		this.a_key = new Array();
		this.a_name = new Array();
		this.a_href = new Array();
		this.a_num = new Array();
		this.a_cost = new Array();
		this.a_sklad = new Array();
		this.a_promo = new Array();
				
		this.promo_code = '';
		
		this.s_id = '';
		this.s_key = '';
		this.s_name = '';
		this.s_href = '';
		this.s_num = '';
		this.s_cost = '';
		this.s_sklad = '';
	}

	this.save = function()
	{
		jQuery.ajax({
			type: "POST",
			url: object_name.url+"/wp-admin/admin-ajax.php",
			data: {action:'cart_save',wpshop_id:this.s_id,wpshop_key:window.__cart.s_key,wpshop_name:window.__cart.s_name,wpshop_href:window.__cart.s_href,wpshop_cost:window.__cart.s_cost,wpshop_num:window.__cart.s_num,wpshop_sklad:window.__cart.s_sklad},
			success: function(t){ 
                            if (jQuery.trim(t) == "add") {
								if (object_name.show_panel==1){
									jQuery('<div id="wpshop_shadow_window"></div>').prependTo('body');
								
									if (object_name.yandex!= undefined){
										jQuery('<div id="wpshop_background_alert_put_to_cart"><div>'+object_name.success+'<div id="wpshop_alert_put_to_cart_buttons"><a class=\'wpshop-button\' onclick="document.location=\''+object_name.cartpage+'\'; yaCounter'+object_name.yandex+'.reachGoal(\'wpshop_popup\');">'+object_name.order+'</a> <a class=\'wpshop-button\' id="continueButton">'+object_name.cont+'</a></div></div></div>').prependTo('body');
									}else{
										jQuery('<div id="wpshop_background_alert_put_to_cart"><div>'+object_name.success+'<div id="wpshop_alert_put_to_cart_buttons"><a class=\'wpshop-button\' onclick="document.location=\''+object_name.cartpage+'\';">'+object_name.order+'</a> <a class=\'wpshop-button\' id="continueButton">'+object_name.cont+'</a></div></div></div>').prependTo('body');
									}
					
									jQuery('#continueButton').click(function() {
										jQuery('#wpshop_shadow_window').remove();
										jQuery('#wpshop_background_alert_put_to_cart').remove();
										return false;
									});
								}
								if (object_name.show_panel==2){
									window.location.href =object_name.cartpage;
								}
                            }
    			}
		});

	}

	this.closeShadowWindow = function() {


	}


	this.getTotalSum = function()
	{
		var total = 0;
		var i = 0;
		for (i = 0; i < this.count; i++)
		{
			t = parseFloat(this.a_cost[i]) * this.a_num[i];
			t = t.toFixed(2);
			t = t * 1;
			total += t;
		}

		var tmp = String(this.discount).split(";");
		var max_discount = 0;
		for (property in tmp)
		{
			var t = tmp[property].split(':');
			if (total > t[0])
			{
				if ((max_discount*1) < (t[1]*1))
				{
					max_discount = t[1];
				}

			}
		}
		total = (total / 100 * (100-max_discount)).toFixed(2);

		return total;
	}

	this.afterChange = function()
	{
		jQuery("[name='select_delivery']").change(function()
		{
			var deliveryCost = (jQuery(this).find('option:selected').attr('cost') * 1).toFixed(2);
			jQuery('#delivery_cost_value').html(deliveryCost);
			var all_price = jQuery('.all_price .rb_total strong').text()*1;
			var discount_row = jQuery('.discount_row .rb_total strong').text()*1;
			if(discount_row){var total_p = discount_row;}else{var total_p = all_price;}
     
			jQuery('#delivery_cost_total').html((total_p*1 + deliveryCost*1).toFixed(2));
			jQuery('#delivery_cost').css('display','table-row');
			jQuery('#delivery_cost').width(jQuery(".recycle_bin").width());
			jQuery(".cform input[name='delivery']").val(jQuery(this).find('option:selected').val());
		}).change();
	}
	
	this.afterChange1 = function()
	{
		if(jQuery('ul.custom_del').length != 0){
			
			var deliveryCost1 = (jQuery("ul.custom_del li.select").find('> a.info').attr('cost') * 1).toFixed(2);
			var deliveryName1 = jQuery("ul.custom_del li.select").find('> a.info').text();
			var deliveryLink1 = jQuery("ul.custom_del li.select").find('> a.info').attr('link');
			jQuery('#delivery_cost_value').html(deliveryCost1);
			jQuery('#delivery_name').html(deliveryName1);
			jQuery('#delivery_link').attr('href',deliveryLink1);
			jQuery('#delivery_cost #delivery_link').html('?');
			var all_price = jQuery('.all_price .rb_total strong').text()*1;
			var discount_row = jQuery('.discount_row .rb_total strong').text()*1;
			if(discount_row){var total_p = discount_row;}else{var total_p = all_price;}
     
			jQuery('#delivery_cost_total').html((total_p*1 + deliveryCost1*1).toFixed(2));
			jQuery('#delivery_cost').css('display','table-row');
			jQuery('#delivery_cost').width(jQuery(".recycle_bin").width());
			jQuery(".cform input[name='delivery']").val(deliveryName1);
      
       
			jQuery("ul.custom_del li > a.img, ul.custom_del li > a.info").click(function()
			{
				jQuery("ul.custom_del").find('li.select').removeClass('select');
				jQuery(this).parent("li").addClass('select');
				var deliveryCost2 = (jQuery("ul.custom_del li.select").find('> a.info').attr('cost') * 1).toFixed(2);
				var deliveryName2 = jQuery("ul.custom_del li.select").find('> a.info').text();
				var deliveryLink2 = jQuery("ul.custom_del li.select").find('> a.info').attr('link');
				jQuery('#delivery_cost_value').html(deliveryCost2);
				jQuery('#delivery_name').html(deliveryName2);
				jQuery('#delivery_link').attr('href',deliveryLink2);
				jQuery('#delivery_cost #delivery_link').html('?');
        
        jQuery('#delivery_cost_total').html((CARTTHIS.getTotalSum()*1 + deliveryCost2*1).toFixed(2));
				jQuery('#delivery_cost').css('display','table-row');
				jQuery('#delivery_cost').width(jQuery(".recycle_bin").width());
				jQuery(".cform input[name='delivery']").val(deliveryName2);
			});
			
			jQuery("#delivery_cost #delivery_link").click(function()
			{
				jQuery('<div id="wpshop_shadow_window"></div>').prependTo('body');
				jQuery('<div id="wpshop_modal"><div><div class="data"></div><a href="#" id="close">x</a></div></div>').prependTo('body');
				var deliveryLink = jQuery("ul.custom_del li.select").find('> a.info').attr('link');
				jQuery('.data').load( deliveryLink+" #main-content .load" );
				return false;
			});
			
			jQuery("ul.custom_del li .delivery_link_more").unbind().click(function() {
				jQuery('<div id="wpshop_shadow_window"></div>').prependTo('body');
				jQuery('<div id="wpshop_modal"><div><div class="data"></div><a href="#" id="close">x</a></div></div>').prependTo('body');
				var deliveryLink1 = jQuery(this).attr('href');
				jQuery('.data').load( deliveryLink1+" #main-content .load" );
				return false;
			});
			
			jQuery('body').on("click", "a#close", function() {
					jQuery('#wpshop_shadow_window').remove();
					jQuery('#wpshop_modal').remove();
					return false;
			});
		}
	} 

	this.update = function()
	{
        var $_GET = {};
        document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
		    function decode(s) {
		        return decodeURIComponent(s.split("+").join(' '));
		    }
		    $_GET[decode(arguments[1])] = decode(arguments[2]);
		});
		

		jQuery.ajax({
			type: "POST",
			url:object_name.url+"/wp-admin/admin-ajax.php",
			data: {action:'cart_load'},
			success: function(t){
							eval(t);
                            if (window.__cart.count)
				{
					window.__cart.content_mini = '<div class="wpshop_widget">';
					window.__cart.content_cart =
						'<table class="recycle_bin" id="recycle_bin" cellpadding="5" cellspacing="0" border="0">'+
						'<thead>'+
						'<tr>'+
						'<th></th>'+
						'<th class="name">' + window.cart_col_name + '</th>'+
						'<th class="type">' + window.cart_col_type + '</th>'+
						'<th class="cost">' + window.cart_col_price + ' ('+ CURR +')</th>'+
						'<th class="num">'+ window.cart_col_count + '</th>'+
						'<th class="total">' + window.cart_col_sum + ' ('+ CURR +')</th>'+
						'<th class="delete">&nbsp;</th>'+
						'</tr>'+
						'</thead>'+
						'<tbody>';

					var i, t,c, total,promo;
					
					for (i = 0, total = 0; i < window.__cart.count; i++)
					{
						t = parseFloat(window.__cart.a_cost[i]) * window.__cart.a_num[i];
						t = t.toFixed(2);
						t = t * 1;
            c = parseFloat(window.__cart.a_cost[i]);
            c = c.toFixed(2);
						c = c * 1;
            if(window.__cart.a_promo[i]!=0) {
              promo = parseFloat(window.__cart.a_promo[i]);
            } 
						total += t;
						if(window.__cart.a_sklad[i]>0){stock='<br>'+object_name.stock+window.__cart.a_sklad[i]+''+object_name.pcs;}else{stock='';}
						window.__cart.content_cart +=
							'<tr class="rb_item" valign="top" id="cart_tr_'+i+'">' +
'<td class="rb_img"><a href="'+ window.__cart.a_href[i] +'"><img src="'+ window.__cart.a_thumbnail[i] +'" style="width:50px;height:50px"/></a></td>' + 
							'<td class="rb_name"><a href="'+ window.__cart.a_href[i] +'">'+ window.__cart.a_name[i] +'</a></td>' + 
							'<td class="rb_type">'+ window.__cart.a_key[i] +'&nbsp;</td>' +
							'<td class="rb_cost">'+c+'</td>' +
							'<td class="rb_num"><a class="minus minus_'+i+'" href="javascript:void(null)" onmousedown="__cart.minus(\''+window.__cart.a_id[i]+'\', \''+window.__cart.a_key[i]+'\', 1,'+i+','+window.__cart.a_cost[i]+'); return false;">&minus;</a> <input type="text" value="'+ window.__cart.a_num[i] +'" size="3" class="input_'+i+'" maxlength="6" onchange="__cart.set(\''+window.__cart.a_id[i]+'\', \''+window.__cart.a_key[i]+'\', this.value,'+i+','+window.__cart.a_sklad[i]+','+window.__cart.a_cost[i]+'); return false;" onkeypress="WebForm_TextBoxKeyHandler(event);" /> <a class="plus plus_'+i+'" href="javascript:void(null)" onmousedown="__cart.plus(\''+window.__cart.a_id[i]+'\', \''+window.__cart.a_key[i]+'\', 1,'+i+','+window.__cart.a_sklad[i]+','+window.__cart.a_cost[i]+'); return false;">+</a>'+ stock +'</td>' +
							'<td class="rb_total">'+ t +'</td>' +
							'<td class="rb_delete"><a title="'+object_name.delet+'" href="javascript:void(null)" onclick="window.__cart.remove(\''+window.__cart.a_id[i]+'\', ' + i + '); return false;" style="text-decoration:none; color:#f00;">&times;</a></td>' +
							'</tr>';
					}
					
					total = total.toFixed(2)*1;

					window.__cart.content_cart +=
						'<tfoot>'+
						'<tr class="all_price">'+
						'<td colspan="5" align="right"><strong>'+object_name.total+'</strong></td>'+
						'<td class="rb_total cost"><strong>'+total+'</strong></td>'+
						'<td class="rb_delete"><a title="'+object_name.delet_all+'" href="javascript:void(null)"  onclick="if (confirm(\''+object_name.empty+'\')) __cart.reset(); return false;" style="text-decoration:none; color:#f00;">&times;</a></td>' +
						'</tr>';
					if (window.__cart.discount != 0 && window.__cart.discount != undefined)
					{
						var tmp = String(window.__cart.discount).split(";");
						var max_discount = 0;
						for (property in tmp)
						{
							var t = String(tmp[property]).split(':');

							if (total*1 > t[0])
							{
								if ((max_discount*1) < (t[1]*1))
								{
									max_discount = t[1];
								}

							}
						}

						if (max_discount > 0)
						{
							var price = (total / 100 * (100-max_discount)).toFixed(2);
							setcookie('wpshop_discount', max_discount, 0, '/');
							setcookie('wpshop_new_price', price, 0, '/');

						window.__cart.content_cart += '<tr class="discount_row">'+
						'<td colspan="5" align="right" ><strong>'+object_name.discont+' '+ max_discount + '%. '+object_name.full_total+'</strong></td>'+
						'<td class="rb_total cost"><strong>'+ price+'</strong></td>'+
						'<td class="rb_delete"></td>' +
						'</tr>';
						}
						else
						{
							setcookie('wpshop_discount', 0, 0, '/');
						}
					}


					window.__cart.content_cart +=
					"<tr style='display:none;text-align:right;margin-top:15px' id='delivery_cost'><td colspan='5' style='font-weight:bold'>"+object_name.price_full+" <span id='delivery_name'></span> (<span id='delivery_cost_value'></span> "+CURR+") <a id='delivery_link'></a></td><td id='delivery_cost_total' style='text-align:left;font-weight:bold'></td><td class='last_col_del'></td></tr>";
					if (object_name.promocode== 1){
						window.__cart.content_cart += "<tr><td colspan=7><input type=text value='' id='promocode_block' placeholder='Промокод' style='width:200px;'>&nbsp;<input type=button  id='promocode_button_block' value='Применить промокод' class='wpshop-button'></td></tr>";
					
						if (cart_reload_promo_text !=''&&cart_reload_promo_text !='NO'){
						  window.__cart.content_cart += "<tr><td colspan=7 style='color: green; font-weight: bold;'>"+cart_reload_promo_text+"</td></tr>";
						}
						if (cart_reload_promo_text =='NO'){
						  window.__cart.content_cart += "<tr><td colspan=7 style='color: green; font-weight: bold;'>"+object_name.wrong_promocode+"</td></tr>";
						}
						if(promo) {
							window.__cart.content_cart += "<tr><td colspan=7 style='color: red; font-weight: bold;'>"+object_name.your_promocode+window.__cart.promo_code+"</td></tr>";
						}  
					}
					
					window.__cart.content_cart +='</tfoot>'+'</table><a name="wp-shop_down"></a>';

					window.__cart.content_mini +=
						'<div class="wpshop_mini_count"><strong>'+object_name.items+'</strong> '+window.__cart.count+'</div>'+
						'<div class="wpshop_mini_sum"><strong>'+object_name.total_sum+'</strong> '+total+'&nbsp;'+CURR+'</div>'+
						'<div class="wpshop_mini_under"></div>'+
						'</div>';



					if (window.__cart.count && $_GET["step"]!='2' && $_GET["step"]!='3' && $_GET['payment'] == undefined && typeof $_GET['page_id'] === "undefined"){
						window.__cart.content_cart +=
						'<div><br><form method="GET" id="wpshop-form" >'+
							'<input type="hidden" name="step" value="'+object_name.user_in+'">';
              if (object_name.yandex!= undefined){
							window.__cart.content_cart +='<a class="wpshop-button" onclick="document.forms[\'wpshop-form\'].submit(); yaCounter'+object_name.yandex+'.reachGoal(\'wpshop_pre_order\');">'}else{
              window.__cart.content_cart +='<a class="wpshop-button" onclick="document.forms[\'wpshop-form\'].submit();">'
              }
              window.__cart.content_cart += object_name.submit+'</a>'+
							'<a class="wpshop-button" onclick="document.location = \''+object_name.return_link+'\';">'+object_name.cont_shop+'</a>'+
						'</form></div>';
					}					
					if (window.__cart.count && $_GET["step"]!='2' && $_GET["step"]!='3' && $_GET['payment'] == undefined && typeof $_GET['page_id'] !== "undefined"){
						window.__cart.content_cart +=
						'<div><br><form method="GET" id="wpshop-form" >'+
							'<a class="wpshop-button" onclick="document.location=\''+object_name.cartpage+'&step='+object_name.user_in+'\';">'+object_name.submit+'</a>'+
							'<a class="wpshop-button" onclick="document.location = \''+object_name.return_link+'\';">'+object_name.cont_shop+'</a>'+
						'</form></div>';
					}

				} else {
					window.__cart.content_mini = '<div class="minicart">'+object_name.is_empty+'</div>';
					window.__cart.content_cart = '<div class="minicart">'+object_name.is_empty+'</div>';
				}

				if (window.__cart.mini) {
					window.__cart.mini.innerHTML = window.__cart.content_mini;
				}
				if (window.__cart.cart) {
					window.__cart.cart.innerHTML = window.__cart.content_cart;
				}
				window.__cart.afterChange();
				window.__cart.afterChange1();

    		}
		});

	}

	this.reset = function()
	{
		this.is_empty = true;
		this.content_mini = '';
		this.content_cart = '';

		jQuery.ajax({
			type: "POST",
			url: object_name.url+"/wp-admin/admin-ajax.php?action=cart_remove",
			data: {action:'cart_remove',wpshop_id:-1},
			success: function(t){
				
				for (i=0; i<window.__cart.count; i++){
					document.getElementById('cart_tr_'+i).style.display = 'none';
				}
				document.getElementById('recycle_bin').style.display = 'none';
				
				
			}
		});
		
		
	}

	this.add = function(id, key, name, href, cost, num, cnt, sklad)
	{
		this.s_id = id;
		this.s_key = key;
		this.s_name = name;
		this.s_href = href;
		this.s_cost = cost;
		this.s_num = num;
		this.s_sklad = sklad;

		this.save();
		setTimeout(this.update, 1000);
	}

	this.remove = function(id, index)
	{
		jQuery("tr#cart_tr_" + index).hide();
		jQuery.ajax({
			type: "POST",
			url: object_name.url+"/wp-admin/admin-ajax.php?action=cart_remove",
			data: {action:'cart_remove',wpshop_id:id},
			success: function(t){
				document.getElementById('cart_tr_'+index).style.display = 'none';
    		}
		});
    var local_price = jQuery("tr#cart_tr_" + index).find(".rb_total").html();
    var local_price_all = jQuery(".recycle_bin > tfoot > tr.all_price > td.rb_total strong").html();
    jQuery(".recycle_bin > tfoot > tr.all_price > td.rb_total strong").html(local_price_all-local_price);
			var tmp1 = String(window.__cart.discount).split(";");
			var max_discount_n = 0;
			for (property in tmp1)
			{
				var ti = String(tmp1[property]).split(':');
				if ((local_price_all-local_price)*1 > ti[0])
				{
					if ((max_discount_n*1) < (ti[1]*1))
					{
						max_discount_n = ti[1];
					}
				}
			}
			
			if (max_discount_n*1 > 0)
			{	
				if(jQuery(".recycle_bin > tfoot > tr.discount_row").length>0){jQuery(".recycle_bin > tfoot > tr.discount_row").show();}else{
				jQuery(".recycle_bin > tfoot > tr.all_price").after('<tr class="discount_row">'+
						'<td colspan="5" align="right" ><strong>'+object_name.discont+' ' + max_discount_n + '%. '+object_name.full_total+'</strong></td>'+
						'<td class="rb_total cost"><strong></strong></td>'+
						'<td class="rb_delete"></td>' +
						'</tr>');
				}
				
				var price_n = ((local_price_all-local_price) / 100 * (100-max_discount_n)).toFixed(2);
				jQuery(".recycle_bin > tfoot > tr.discount_row > td.rb_total strong").html(price_n);
				jQuery(".recycle_bin > tfoot > tr.discount_row > td:first-child").html('<strong>'+object_name.discont+' ' + max_discount_n + '%. '+object_name.full_total+'</strong>');
				
			}else{jQuery(".recycle_bin > tfoot > tr.discount_row").hide();}
	}

	this.set = function(id, key, value,index,sklad,cost)
	{
		if ((sklad >= Math.abs(parseFloat(value)) || sklad == 0)&&Math.abs(parseFloat(value))>0){
		this.s_id = id;
		this.s_key = key;
		this.s_num = Math.abs(parseFloat(value));
		this.save();
		var res = parseFloat(value)*cost;
		jQuery(".input_" + index).parent().closest('tr').find(".rb_total").html(res);
		var all_sum = 0;
		jQuery("tbody tr.rb_item .rb_total").each(function(){
			all_sum += parseFloat(jQuery(this).text());
			return all_sum;
		}); 
		jQuery(".recycle_bin > tfoot > tr.all_price > td.rb_total strong").html(all_sum);
			var tmp1 = String(window.__cart.discount).split(";");
			var max_discount_n = 0;
			for (property in tmp1)
			{
				var ti = String(tmp1[property]).split(':');
				if (all_sum*1 > ti[0])
				{
					if ((max_discount_n*1) < (ti[1]*1))
					{
						max_discount_n = ti[1];
					}
				}
			}
			
			if (max_discount_n*1 > 0)
			{	
				if(jQuery(".recycle_bin > tfoot > tr.discount_row").length>0){jQuery(".recycle_bin > tfoot > tr.discount_row").show();}else{
				jQuery(".recycle_bin > tfoot > tr.all_price").after('<tr class="discount_row">'+
						'<td colspan="5" align="right" ><strong>'+object_name.discont+' ' + max_discount_n + '%. '+object_name.full_total+'</strong></td>'+
						'<td class="rb_total cost"><strong></strong></td>'+
						'<td class="rb_delete"></td>' +
						'</tr>');
				}
				
				var price_n = (all_sum / 100 * (100-max_discount_n)).toFixed(2);
				jQuery(".recycle_bin > tfoot > tr.discount_row > td.rb_total strong").html(price_n);
				jQuery(".recycle_bin > tfoot > tr.discount_row > td:first-child").html('<strong>'+object_name.discont+' ' + max_discount_n + '%. '+object_name.full_total+'</strong>');
				
			}else{jQuery(".recycle_bin > tfoot > tr.discount_row").hide();}
			
			
		
		var deliveryCost = (jQuery("select[name='select_delivery']").find('option:selected').attr('cost') * 1).toFixed(2);
		var deliveryCost1 = (jQuery("ul.custom_del li.select").find('> a.info').attr('cost') * 1).toFixed(2);
		
		if(jQuery("select[name='select_delivery']").length > 0) {
			if (price_n>0){
				var del_price = price_n*1 + deliveryCost*1; 
			}else{
				var del_price = all_sum*1 + deliveryCost*1; 
			}
			jQuery("#delivery_cost_total").text(del_price);
		}
		if(jQuery("ul.custom_del").length > 0) {
			if (price_n>0){
				var del_price = price_n*1 + deliveryCost1*1; 
			}else{
				var del_price = all_sum*1 + deliveryCost1*1; 
			}
			jQuery("#delivery_cost_total").text(del_price);
		}  
		
		//this.update();
		}else if(sklad > 0){ alert(object_name.stock_error);jQuery(".input_" + index).val(1);}
	}

	/**
	 * @since 17.04.2011 Вводится понятие индекса. Если он указан, то поиск элемента не делается.
	 */
	this.plus = function(id, key, value, index, sklad,cost)
	{
		if (sklad >= (jQuery(".input_" + index).val()*1+1) || sklad == 0){
		var sum = jQuery(".input_" + index).val()*1+1;
 		this.s_id = id;
		this.s_key = key;
		this.s_num = sum;
		this.s_name = '';
		this.s_href = '';
		this.s_cost = '';

		this.save();
		var res = (sum*cost).toFixed(2);
		jQuery(".minus_" + index).parent().closest('tr').find(".rb_total").html(res);
		var all_sum = 0;
		jQuery("tbody tr.rb_item .rb_total").each(function(){
			all_sum += parseFloat(jQuery(this).text());
			return all_sum;
		});
		jQuery(".recycle_bin > tfoot > tr.all_price > td.rb_total strong").html(all_sum);
			var tmp1 = String(window.__cart.discount).split(";");
			var max_discount_n = 0;
			for (property in tmp1)
			{
				var ti = String(tmp1[property]).split(':');
				if (all_sum*1 > ti[0])
				{
					if ((max_discount_n*1) < (ti[1]*1))
					{
						max_discount_n = ti[1];
					}
				}
			}
			
			if (max_discount_n*1 > 0)
			{	
				if(jQuery(".recycle_bin > tfoot > tr.discount_row").length>0){jQuery(".recycle_bin > tfoot > tr.discount_row").show();}else{
				jQuery(".recycle_bin > tfoot > tr.all_price").after('<tr class="discount_row">'+
						'<td colspan="5" align="right" ><strong>'+object_name.discont+' ' + max_discount_n + '%. '+object_name.full_total+'</strong></td>'+
						'<td class="rb_total cost"><strong></strong></td>'+
						'<td class="rb_delete"></td>' +
						'</tr>');
				}
				
				var price_n = (all_sum / 100 * (100-max_discount_n)).toFixed(2);
				jQuery(".recycle_bin > tfoot > tr.discount_row > td.rb_total strong").html(price_n);
				jQuery(".recycle_bin > tfoot > tr.discount_row > td:first-child").html('<strong>'+object_name.discont+' ' + max_discount_n + '%. '+object_name.full_total+'</strong>');
				
			}else{jQuery(".recycle_bin > tfoot > tr.discount_row").hide();}
			
			
		
		var deliveryCost = (jQuery("select[name='select_delivery']").find('option:selected').attr('cost') * 1).toFixed(2);
		var deliveryCost1 = (jQuery("ul.custom_del li.select").find('> a.info').attr('cost') * 1).toFixed(2);
		
		if(jQuery("select[name='select_delivery']").length > 0) {
			if (price_n>0){
				var del_price = price_n*1 + deliveryCost*1; 
			}else{
				var del_price = all_sum*1 + deliveryCost*1; 
			}
			jQuery("#delivery_cost_total").text(del_price);
		}
		if(jQuery("ul.custom_del").length > 0) {
			if (price_n>0){
				var del_price = price_n*1 + deliveryCost1*1; 
			}else{
				var del_price = all_sum*1 + deliveryCost1*1; 
			}
			jQuery("#delivery_cost_total").text(del_price);
		}  
		jQuery(".input_" + index).val(sum);
		}else if(sklad > 0){ alert(object_name.stock_error);}
	}

	this.minus = function(id, key, value, index,cost)
	{
 		var sum = jQuery(".input_" + index).val()-1;
        if (sum < 1) sum = 1;
        this.s_id = id;
		this.s_key = key;
		this.s_num =sum;
		this.s_name = '';
		this.s_href = '';
		this.s_cost = '';
		this.save();
		var res = (sum*cost).toFixed(2);
		jQuery(".minus_" + index).parent().closest('tr').find(".rb_total").html(res);
		var all_sum = 0;
		jQuery("tbody tr.rb_item .rb_total").each(function(){
			all_sum += parseFloat(jQuery(this).text());
			return all_sum;
		});
		jQuery(".recycle_bin > tfoot > tr.all_price > td.rb_total strong").html(all_sum);
			var tmp1 = String(window.__cart.discount).split(";");
			var max_discount_n = 0;
			for (property in tmp1)
			{
				var ti = String(tmp1[property]).split(':');
				if (all_sum*1 > ti[0])
				{
					if ((max_discount_n*1) < (ti[1]*1))
					{
						max_discount_n = ti[1];
					}
				}
			}
			
			if (max_discount_n*1 > 0)
			{	
				if(jQuery(".recycle_bin > tfoot > tr.discount_row").length>0){jQuery(".recycle_bin > tfoot > tr.discount_row").show();}else{
				jQuery(".recycle_bin > tfoot > tr.all_price").after('<tr class="discount_row">'+
						'<td colspan="5" align="right" ><strong>'+object_name.discont+' ' + max_discount_n + '%. '+object_name.full_total+'</strong></td>'+
						'<td class="rb_total cost"><strong></strong></td>'+
						'<td class="rb_delete"></td>' +
						'</tr>');
				}
				
				var price_n = (all_sum / 100 * (100-max_discount_n)).toFixed(2);
				jQuery(".recycle_bin > tfoot > tr.discount_row > td.rb_total strong").html(price_n);
				jQuery(".recycle_bin > tfoot > tr.discount_row > td:first-child").html('<strong>'+object_name.discont+' ' + max_discount_n + '%. '+object_name.full_total+'</strong>');
				
			}else{jQuery(".recycle_bin > tfoot > tr.discount_row").hide();}
			
			
		
		var deliveryCost = (jQuery("select[name='select_delivery']").find('option:selected').attr('cost') * 1).toFixed(2);
		var deliveryCost1 = (jQuery("ul.custom_del li.select").find('> a.info').attr('cost') * 1).toFixed(2);
		
		if(jQuery("select[name='select_delivery']").length > 0) {
			if (price_n>0){
				var del_price = price_n*1 + deliveryCost*1; 
			}else{
				var del_price = all_sum*1 + deliveryCost*1; 
			}
			jQuery("#delivery_cost_total").text(del_price);
		}
		if(jQuery("ul.custom_del").length > 0) {
			if (price_n>0){
				var del_price = price_n*1 + deliveryCost1*1; 
			}else{
				var del_price = all_sum*1 + deliveryCost1*1; 
			}
			jQuery("#delivery_cost_total").text(del_price);
		}  
		jQuery(".input_" + index).val(sum);
	}

	this.init();
	this.update();
}


function addtocart(id, key, href, cost, num, cnt, sklad)
{
  if (num <=0){num=1;}
	var result = sklad - num;
	if(sklad==''||result>=0){
	var name = jQuery("[name='wpshop-good-title-" + id + "']").val();
	if (name == null){var name = jQuery('a.custom_add_'+ cnt).attr('name');}
	var properties = [];
	jQuery('#wpshop_property_'+id).find('input,select,textarea').each(function(index,obj)
	{
		properties.push(jQuery(obj).attr('name') + ': ' + jQuery(obj).val());
	});



	if (properties.length > 0)
	{
		name = name + '<br/>(' + properties.join(', ') + ')';
	}


	var jWpField = jQuery('[for="wpshop-wpfield"]');

	if (jWpField.html() != null)
	{
		if (jQuery('#wpshop-wpfield').val().length > 0)
		{
			var wpfield = jWpField.html() + ": " + jQuery('#wpshop-wpfield').val();
			name = name + "<br/>" + wpfield;
		}
	}

	var t = jQuery('[name="goods_count_' + id + "_" + cnt + '"]');
	window.__cart.add(id, key, name, href, cost, num, t.val(),sklad);
	}else{alert(object_name.stock_error);}
}

function button_effect()
{
	jQuery(".wpshop_animate_icon").mouseover(function()
	{
		jQuery(this).animate({"background-color": '#6B8DB1'}, 200 );
	});

	jQuery(".wpshop_animate_icon").mouseout(function()
	{
		jQuery(this).animate({"background-color": '#C4D2E1'}, 200 );
	});
}

function WebForm_TextBoxKeyHandler(event) {
	if (event.keyCode == 13) {
	var target;

	target = event.srcElement;
	if ((typeof(target) != "undefined") && (target != null)) {
	if (typeof(target.onchange) != "undefined") {
	target.onchange();
	event.cancelBubble = true;
	if (event.stopPropagation) event.stopPropagation();
	return false;
	}
	}
	}
	return true;
}


jQuery(function()
{
	if (jQuery('.wpshop_bag').find('.wpshop_good_price').css('display') == 'none')
	{
		jQuery('.wpshop_bag').hover(
		function()
		{
			jQuery(this).find('.wpshop_good_price').css('display','block');
		},
		function()
		{
			jQuery(this).find('.wpshop_good_price').css('display','none');
		});
	}

	button_effect();


});

//----------

