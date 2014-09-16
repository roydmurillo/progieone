jQuery(document).ready(function() {
	function ajax_load(data_obj){
        loader();
        jQuery.ajax({
            type: "POST",
            url: jQuery("#load_initial").val(),
            cache: false,
            data: { type: jQuery("#type_initial").val(), args: data_obj }
        }).done(function( msg ) {
            unloader();
            jQuery("#dashboard_content").html(msg);
        });
	}
    function loader(){
        jQuery("#loader").css("opacity","0");
        jQuery("#loader").show();
        jQuery("#loader_inner").html("<img src='"+jQuery("#base_url").val()+"assets/images/loader.gif' style='margin:200px auto 0px 280px'>");
        jQuery("#loader").animate({opacity:1},500);
    }
    function unloader(){
            jQuery("#loader").animate({opacity:0},500);
            jQuery("#loader_inner").html("");
            jQuery("#loader").hide();
    }
    if(jQuery("#load_initial").val() != ""){
		var data_obj = {start:jQuery("#start").val()};
		data_obj = jQuery.toJSON(data_obj);
        ajax_load(data_obj);
    }
	jQuery('body').on('click', '.remove_friend', function(){
		var ths = jQuery(this);
		var r=confirm("You are about to remove "+jQuery(this).prevAll(".item_title").html().trim()+" from your friend's list.\n Proceed?");
		if (r==true){
			loader();
			var data_obj = {friend:jQuery(this).prevAll(".uid").eq(0).val(), user:jQuery("#current_u").val()};
			data_obj = jQuery.toJSON(data_obj);			
			jQuery.ajax({
				type: "POST",
				url: jQuery("#load_initial").val(),
				cache: false,
				data: { type: jQuery("#type_delete").val(), args:data_obj }
			}).done(function( msg ) {
				unloader();
				ths.parents(".iteminfo").hide(1000);				
			});	
		}
	});		

    jQuery("body").on('click','#search_dashboard_items_button', function(){
		var data_obj = {start:jQuery("#start").val(), search_item:jQuery("#search_dashboard_items").val(), show_entry:jQuery("#show_entry").val(), filter_type: jQuery("#filter_type").val()};
		data_obj = jQuery.toJSON(data_obj);
        ajax_load(data_obj);
    });	
    jQuery("body").on('click','#filter_status', function(){
		jQuery(".status").toggle();
		jQuery(".status2").toggle();
    });	
    jQuery("body").on('change','#filter_type', function(){
		var data_obj = {start:jQuery("#start").val(), search_item:jQuery("#search_item").val(), show_entry:jQuery("#show_entry").val(), filter_type: jQuery("#filter_type").val() };
		data_obj = jQuery.toJSON(data_obj);
        ajax_load(data_obj);
    });	
    jQuery("body").on('change','#show_entry', function(){
		var data_obj = {start:jQuery("#start").val(), search_item:jQuery("#search_item").val(), show_entry:jQuery("#show_entry").val(), filter_type: jQuery("#filter_type").val() };
		data_obj = jQuery.toJSON(data_obj);
        ajax_load(data_obj);
    });		
    jQuery("body").on('click','.accept_invite', function(){
		var ths = jQuery(this);
		var data_obj = {friend:jQuery(this).prevAll(".uid").eq(0).val(), user:jQuery("#current_u").eq(0).val(), user_name:jQuery(this).prevAll(".item_title").eq(0).html() };
		data_obj = jQuery.toJSON(data_obj);
        loader();
        jQuery.ajax({
            type: "POST",
            url: jQuery("#load_initial").val(),
            cache: false,
            data: { type: jQuery("#type_invite").val(), args: data_obj }
        }).done(function( msg ) {
			var parent = ths.parents(".iteminfo");
			parent.hide("slow",function(){parent.remove()});
            unloader();
            alert(msg)
        });		
    });		
	
});