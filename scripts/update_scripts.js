jQuery(document).ready(function() {
    function loader(){
        jQuery("#loader").css("opacity","0");
        jQuery("#loader").show();
        jQuery("#loader_inner").html("<img src='"+jQuery("#base_url").val()+"assets/images/loader.gif' style='position:fixed; top:50%; left:50%'>");
        jQuery("#loader").animate({opacity:1},500);
    }
    function unloader(){
            jQuery("#loader").animate({opacity:0},500);
            jQuery("#loader_inner").html("");
            jQuery("#loader").hide();
    }
    if(jQuery("#update_forsale").length > 0 ){
        jQuery("#update_forsale").click(function(){
			var err = "";
			if(jQuery(".item_parts").hasClass("is_visible")){
				if(jQuery("#item_parttype").val() == ""){
					err = err + "Parts / Accessories Type is a required field.\n";
				}
			}			
			if(jQuery("#item_brand").val() == ""){
				err = err + "Make is a required field.\n";
			}
			if(jQuery("#item_name").val() == ""){
				err = err + "Model Name is a required field.\n";
			}
			if(jQuery("#short_description").val() == ""){
				err = err + "Short description is a required field.\n";
			}
            if(jQuery("#item_price").val() == ""){
				err = err + "Must enter an item price value.\n";
			}
            if(jQuery("#item_condition").val() == ""){
				err = err + "Item Condition is a required field.\n";
			}
            if(jQuery("#item_category").val() == ""){
				err = err + "Category is a required field.\n";
			}
            if(jQuery("#item_wholepart").val() == "1"){
				if(jQuery("#item_gender").val() == ""){
					err = err + "Must select the appropriate gender.\n";
				}
				if(jQuery("#item_kids").val() == ""){
					err = err + "Must select if item is for kids.\n";
				}			
			}
			//===============================================
			// this can be optional if only itemparts is sold
			//===============================================
			if(jQuery("#item_wholepart").val() == "1"){
//				if(jQuery("#item_movement").val() == ""){
//					err = err + "Movement type is a required field.\n";
//				}	
//				if(jQuery("#item_case").val() == ""){
//					err = err + "Case type is a required field.\n";
//				}	
//				if(jQuery("#item_bracelet").val() == ""){
//					err = err + "Bracelet type is a required field.\n";
//				}
				if(jQuery("#item_case_width").val() == "" || jQuery("#item_case_width").val() == "0"){
					err = err + "Case width cannot be 0 or blanks.\n";
				}	
				if(jQuery("#item_case_thickness").val() == "" || jQuery("#item_case_thickness").val() == "0"){
					err = err + "Case thickness cannot be 0 or blanks.\n";
				}	
							
//				if(jQuery("#item_year_model").val() == ""){
//					err = err + "Year Model is a required field.\n";
//				} else {
//					if(jQuery("#item_year_model").val() < 1000 || jQuery("#item_year_model").val() > 2100){
//						err = err + "Year Model is invalid.\n";
//					} 
//				}
			}
						
				
			//===============================================
			// this can be optional if only itemparts is sold
			//===============================================
						
//			if(jQuery("#item_certificate").val() == ""){
//				err = err + "Must select the appropriate certificate.\n";
//			}	
//			if(jQuery("#item_box").val() == ""){
//				err = err + "Must select the appropriate box.\n";
//			}	
					
			if(tinyMCE.get('item_description').getContent() == ""){
				err = err + "Item description is required.\n";
			}	
			if(tinyMCE.get('item_shipping').getContent() == ""){
				err = err + "Item shipping is required.\n";
			}								
								
			if(err == ""){
				
				jQuery("#update_item").click();
				
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
			  		var ths = jQuery(this).parent().parent();
					var data_obj = {item_id:jQuery(this).prevAll(".item_id").val(), image_folder: jQuery(this).prevAll(".image_folder").val() , image: jQuery(this).prevAll(".actual_image").val()};
					data_obj = jQuery.toJSON(data_obj);
					loader();
					jQuery.ajax({
						type: "POST",
						url: jQuery("#load_initial").val(),
						cache: false,
						data: { type:jQuery("#type_delimg").val(), args:data_obj }
					}).done(function( msg ) {
						unloader();
						ths.hide("slow",function(){ths.remove()});
					});				
			  }
		});		

		jQuery('body').on('mouseover', '.img', function(){
			jQuery(this).find(".del_im").eq(0).show();
		});	
		jQuery('body').on('mouseout', '.img', function(){
			jQuery(this).find(".del_im").eq(0).hide();
		});	
        jQuery('body').on('click', '.set_as_default', function(){
            $.each($('.set_as_default'), function(key, value){
                $(this).text('set as default');
            });

            $(this).text('default');
            
            var data_obj = {item_id:jQuery(this).attr("data-id"), src: jQuery(this).attr("data-src")};
            data_obj = jQuery.toJSON(data_obj);
            jQuery.ajax({
                type: "POST",
                url: jQuery("#set_default_url").val(),
                cache: false,
                data: { type:jQuery("#type_setdefault").val(), args:data_obj}
            });

		});	
			
		
		jQuery('body').on('change', '#photoimg_add', function(){ 
				loader();
				jQuery("#imageform_add").ajaxForm({
					   data:{ type:jQuery("#type_addimg").val(), args: jQuery("#inserted_id").val()},
					   success: function(response){
							unloader();
							jQuery.trim(response);
							if(response.indexOf("Upload Error") > -1){
								alert(response);
							} else {
								jQuery("#added_images").html(response);
							}
					   }
				}).submit();		
		});
		jQuery("#item_price").autoNumeric('init',{aSep: ''});
//		jQuery(".validateYear").keydown(function(event) {
//			if (!((event.keyCode == 46 || 
//				event.keyCode == 8  || 
//				event.keyCode == 37 || 
//				event.keyCode == 39 || 
//				event.keyCode == 9) || 
//				(event.ctrlKey && event.keyCode == 86) ||  
//				jQuery(this).val().length < 4 &&
//				((event.keyCode >= 48 && event.keyCode <= 57) ||
//				(event.keyCode >= 96 && event.keyCode <= 105)))) {
//				event.preventDefault();
//				return false;
//			}
//		});		
		jQuery(".int").keydown(function(event) {
			if (!((event.keyCode == 46 || 
				event.keyCode == 8  || 
				event.keyCode == 37 || 
				event.keyCode == 39 || 
				event.keyCode == 9) || 
				(event.ctrlKey && event.keyCode == 86) ||  
				((event.keyCode >= 48 && event.keyCode <= 57) ||
				(event.keyCode >= 96 && event.keyCode <= 105)))) {
				event.preventDefault();
				return false;
			}
		});	
		
//		jQuery(".validateYear").change(function(event) {
//			var value =  $(this).val();
//			value = value.replace(/[^0-9]/g,'');
//			value = value.substr(0,4);
//			jQuery(this).val(value);
//		});			
});