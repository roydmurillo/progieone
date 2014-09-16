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
    jQuery("body").on('click','.sort', function(){
		var data_obj = {start:jQuery("#start").val(), sortmode:jQuery(this).attr('class'), show_entry:jQuery("#show_entry").val()};
		data_obj = jQuery.toJSON(data_obj);
        ajax_load(data_obj);
    });	
    jQuery("body").on('click','#filter_status', function(){
		jQuery(".status").toggle();
		jQuery(".status2").toggle();
    });	
    jQuery("body").on('change','#show_entry', function(){
		var data_obj = {start:jQuery("#start").val(), search_item:jQuery("#search_item").val(), show_entry:jQuery("#show_entry").val(), filter_type: jQuery("#filter_type").val() };
		data_obj = jQuery.toJSON(data_obj);
        ajax_load(data_obj);
    });		
	jQuery("body").on("click","#select_all", function(){
		if(jQuery(this).prop("checked")){
			jQuery(".select_item").prop("checked",true);
		} else {
			jQuery(".select_item").prop("checked",false);
		}
	});	
	jQuery("body").on("click","#hide_view_message", function(){
		jQuery(".h2_title").html("Your Items Being Watched");
		jQuery("#view_message").hide();
		jQuery("#inquiry_container").show();
	});	

	jQuery("body").on("click","#mailto", function(){
		var winmail = window.open(jQuery("#mail_info").val());
	});		

	jQuery("body").on("click","#delete_inq", function(){
		var data = "";
		jQuery(".select_item:checked").each(function(){
			data += "-" + jQuery(this).prevAll(".inquiry_id").eq(0).val();
		});
		if(data == ""){
			alert("Please select at least one message to delete.");
		} else {
			var r=confirm("You are about to delete selected inquiries. Proceed?");
			if (r==true){
				loader();
				jQuery.ajax({
					type: "POST",
					url: jQuery("#load_initial").val(),
					cache: false,
					data: { type: jQuery("#type_delete").val(), args:data}
				}).done(function() {
					unloader();
					var res = data.split("-"); 
					var i;
					for (i = 0; i < res.length; i++) {
						if(res[i]!=""){
							var parent = jQuery("#inquiry_id" + res[i]).parents("tr");
							parent.hide(500,function(){parent.remove()});
						}
					}
				});	
			}		
		}
	});	
			
});
