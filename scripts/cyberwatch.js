// JavaScript Document
jQuery(document).ready(function(){
	
	jQuery(".top_menu").hover(function(){
			if(jQuery(this).find("a").html() == "CAFE FRIENDS" || 
			   jQuery(this).find("a").html() == "FORUM"){
				    jQuery(this).find(".drop_nav").css("left","");
					jQuery(this).find(".drop_nav").css("right","0px");
			} else {
				    jQuery(this).find(".drop_nav").css("right","");
					jQuery(this).find(".drop_nav").css("left","0px");
			}
			jQuery(this).find(".drop_nav").show();
		},function(){
			jQuery(this).find(".drop_nav").hide();
		}
	);
	
	jQuery(".drop_currency, #dp_currency").click(function(){
		jQuery("#currency_converter").toggle();
	});
	jQuery("#convert").click(function(){
		jQuery("#currency_converter").hide();
		window.location.href = jQuery("#base_loc").val() + "?currency=" + jQuery("#val_currency").val();
	});	
//	
//	jQuery("#search_button").click(function(){
//	
//		var loc = jQuery("#base_loc").val() + "search?srch=";
//		
//		var srch = jQuery("#search_cyberwatch").val();
//		
//		window.location.href = loc + srch;
//	
//	});
	
});

jQuery(window).scroll(function() {
	if (jQuery(window).scrollTop() > jQuery('#header_menu').offset().top) {
		jQuery("#top_bar_header_background").css({"position":"fixed", "box-shadow":"1px 1px 2px 1px #333","z-index":"99999"});
	} else {
		jQuery("#top_bar_header_background").css({"position":"", "box-shadow":"","z-index":""});
	}
});