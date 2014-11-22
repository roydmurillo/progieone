jQuery(document).ready(function() {
	jQuery("body").on("click", ".item_title", function(){ 
        loader();
        jQuery.ajax({
            type: "POST",
            url: jQuery("#load_initial").val(),
            cache: false,
            data: { type: jQuery("#type_single").val(), args: jQuery(this).prevAll(".uid").val() }
        }).done(function( msg ) {
			var active = jQuery("#all_watchlist");
			active.addClass("tab_inner");
			active.removeClass("tab_inner_active");
			var htm ='<a id="View Details" href="javascript:;"><div class="tab_inner_active">View Details</div></a>';
			jQuery("#inner_dashboard_tab").append(htm);
			jQuery("#single_item").show();
            unloader();
            jQuery("#dashboard_content").html(msg);
			jQuery(".desc").mCustomScrollbar({
				theme:"dark",
				 scrollButtons:{
					enable:true
				}}
			);
        });
	});
	jQuery("body").on("click", ".remove_watchlist", function(){ 
		var ths = jQuery(this);
		jQuery(this).parents(".item").hide("slow",
  		    function(){
				var data_obj = {item:ths.attr("data-itemid"),
				                user:jQuery("#ud").val()};
				data_obj = jQuery.toJSON(data_obj);
				jQuery.ajax({
					type: "POST",
					url: jQuery("#load_initial").val(),
					cache: false,
					data: { type: jQuery("#type_delete").val(), args: data_obj }
				}).done(function( msg ) {
					var data_obj2 = {start:jQuery("#start").val()};
					data_obj2 = jQuery.toJSON(data_obj2);
					ajax_load(data_obj2);
				});
			}
		);
	});
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
            create_pager();
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
//    if(jQuery("#load_initial").val() != ""){
//		var data_obj = {start:jQuery("#start").val()};
//		data_obj = jQuery.toJSON(data_obj);
//        ajax_load(data_obj);
//    }
    jQuery("body").on('click','#filter_status', function(){
		jQuery(".status2").toggle();
    });	
    jQuery("body").on('click','#compare_watch', function(){
		var selected = "";
		jQuery(".sel_compare").each(function(){
			if(jQuery(this).prop("checked") == true){
				selected += "-" + jQuery(this).prevAll(".uid").val();
			}
		});
		selected = selected.substring(1);
		if(selected != "" && selected.indexOf("-") > -1){
			loader();
			jQuery.ajax({
				type: "POST",
				url: jQuery("#load_initial").val(),
				cache: false,
				data: { type: jQuery("#type_compare").val(), args: selected }
			}).done(function( msg ) {
				unloader();
				jQuery("#dashboard_content").html(msg);
				jQuery(".desc").mCustomScrollbar({
					theme:"dark",
					 scrollButtons:{
						enable:true
					}}
				);				
			});
		} else {
			alert("Please select at least two watch items to compare!");
		}
    });	
    jQuery("body").on('click','#search_dashboard_items_button', function(){
		var data_obj = {start:jQuery("#start").val(), search_item:jQuery("#search_dashboard_items").val(), show_entry:jQuery("#show_entry").val(), filter_type: jQuery("#filter_type").val()};
		data_obj = jQuery.toJSON(data_obj);
        ajax_load(data_obj);
    });	
    jQuery("body").on('change','#show_entry', function(){
		var data_obj = {start:jQuery("#start").val(), search_item:jQuery("#search_item").val(), show_entry:jQuery("#show_entry").val(), filter_type: jQuery("#filter_type").val() };
		data_obj = jQuery.toJSON(data_obj);
        ajax_load(data_obj);
    });					
});