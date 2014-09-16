// scroll
jQuery(window).scroll(function() {
	if (jQuery(window).scrollTop() > jQuery('#header_menu').offset().top) {
		jQuery("#top_bar_header_background").css({"position":"fixed", "box-shadow":"1px 1px 2px 1px #333","z-index":"99999"});
	} else {
		jQuery("#top_bar_header_background").css({"position":"fixed", "box-shadow":"1px 1px 2px 1px #333","z-index":"99999"});
	}
});