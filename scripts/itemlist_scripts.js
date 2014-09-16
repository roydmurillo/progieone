jQuery(document).ready(function() {
	
	jQuery(".add_wishlist").click(function(){
		var ths = jQuery(this).html();
		jQuery.trim(ths);
		if(ths.indexOf("In") > -1){
			alert("This watch item is already in your watchlist.");		
		} else {
			var this_elem = jQuery(this); 
			this_elem.html("Adding...");
			jQuery.ajax({
				type: "POST",
				url: jQuery("#load_initial").val(),
				cache: false,
				data: { iid: jQuery(this).prevAll(".item").val() }
			}).done(function( msg ) {
				if(msg.indexOf("logged") > -1){
					this_elem.html("Add to Wishlist");
					alert(msg);
				} else {
				  this_elem.html("In Watchlist");
				}
			});
		}
	});
	
	jQuery(".iteminfo").mouseover(function(){
		jQuery(".item_seller").hide();
		jQuery(this).find(".item_seller").show();
	});	
	jQuery(".iteminfo").mouseout(function(){
		jQuery(".item_seller").hide();
	});		
	
	jQuery(".list_a").click(function(){
		
	});
	jQuery(".list_b").hover(function(){
		
	});
	
});