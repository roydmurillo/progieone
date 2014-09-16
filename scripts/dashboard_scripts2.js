jQuery(document).ready(function() {
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
        loader();
        jQuery.ajax({
            type: "POST",
            url: jQuery("#load_initial").val(),
            cache: false,
            data: { type: "load_initial", args:"" }
        }).done(function( msg ) {
            unloader();
            jQuery("#dashboard_content").html(msg);
        });
    }
    if(jQuery("#update_forsale").length > 0 ){
        jQuery("#update_forsale").click(function(){
			var err = "";
			if(jQuery("#item_brand_id").val() == ""){
				err = err + "Make is a required field.\n";
			}
			if(jQuery("#item_name").val() == ""){
				err = err + "Model Name is a required field.\n";
			}
			if(jQuery("#item_year_model").val() == ""){
				err = err + "Year Model is a required field.\n";
			} else {
				if(jQuery("#item_year_model").val() < 1000 || jQuery("#item_year_model").val() > 2100){
					err = err + "Year Model is invalid.\n";
				} 
			}
			if(jQuery("#item_category").val() == ""){
				err = err + "Category is a required field.\n";
			}			
			if(jQuery("#item_gender").val() == ""){
				err = err + "Must select the appropriate gender.\n";
			}
			if(jQuery("#item_certificate").val() == ""){
				err = err + "Must select the appropriate certificate.\n";
			}						
			if(jQuery("#item_certificate").val() == ""){
				err = err + "Must select the appropriate certificate.\n";
			}	
			if(jQuery("#item_box").val() == ""){
				err = err + "Must select the appropriate box.\n";
			}	
			if(jQuery("#item_price").val() == ""){
				err = err + "Must enter an item price value.\n";
			}		
			if(tinyMCE.get('item_description').getContent() == ""){
				err = err + "Item description is required.\n";
			}					
								
			if(err == ""){
				loader();
				jQuery.ajax({
					type: "POST",
					url: jQuery("#update_watch").val(),
					cache: false,
					data: { item_id: jQuery("#item_id").val(),
							item_name: jQuery("#item_name").val(), 
							item_brand_id: jQuery("#item_brand_id").val(),
							item_year_model: jQuery("#item_year_model").val(),
							item_category_id: jQuery("#item_category").val(),
							item_gender: jQuery("#item_gender").val(),
							item_certificate: jQuery("#item_certificate").val(),
							item_box: jQuery("#item_box").val(),
							item_price: jQuery("#item_price").val(),
							item_desc: tinyMCE.get('item_description').getContent()
							}
				}).done(function( msg ) {
					unloader();
					var r=confirm("You have successfully updated this item.\n Go back to for sale items?");
					if (r==true)
					  {
						window.location.href = jQuery("#base_url").val() + "dashboard/sell/";
					  }					
				});
			} else {
				alert("The Following Errors must be addressed:\n\n" + err);
			}
		});
    }
	
		jQuery('body').on('click', '#upload_item_images', function(){
			if(jQuery('.ad_im').length != 4){
				jQuery("#photoimg_add").click();
			} else {
				var r=confirm("You have reached the maximum numbers of image per watch item.\n Proceed to checkout?");
				if (r==true)
				  {
					window.location.href = jQuery("#base_url").val() + "dashboard/sell/checkout";
				  }
			}
		});

		jQuery('body').on('click', '.del_im', function(){
			var r=confirm("You are about to delete an image.\n Proceed to delete?");
			if (r==true)
			  {	
			  		var ths = jQuery(this).parent();
					loader();
					jQuery.ajax({
						type: "POST",
						url: jQuery("#delete_image").val(),
						cache: false,
						data: { item_id:jQuery(this).prevAll(".item_id").val(), image_folder: jQuery(this).prevAll(".image_folder").val() , image: jQuery(this).prevAll(".actual_image").val()  }
					}).done(function( msg ) {
						unloader();
						ths.hide("slow");
					});				
			  }
		});		

		jQuery('body').on('mouseover', '.img', function(){
			jQuery(this).find(".del_im").eq(0).show();
		});	
		jQuery('body').on('mouseout', '.img', function(){
			jQuery(this).find(".del_im").eq(0).hide();
		});	
			
		
		jQuery('body').on('change', '#photoimg_add', function(){ 
				loader();
				jQuery("#imageform_add").ajaxForm({
					   data:{ inserted_id:jQuery("#inserted_id").val()},
					   target: '#added_images',
					   success: function(){
							unloader();
					   }
				}).submit();		
		});
});