jQuery(document).ready(function() {
jQuery("#description").show();	
var native_width = 0;
	var native_height = 0;

	//Now the mousemove function
	jQuery("#image_viewer").mousemove(function(e){

			//This will create a new image object with the same image as that in #image_view
			//We cannot directly get the dimensions from #image_view because of the 
			//width specified to 200px in the html. To get the actual dimensions we have
			//created this image object.
			var image_object = new Image();
			image_object.src = jQuery("#image_view").attr("src");
			
			//This code is wrapped in the .load function which is important.
			//width and height of the object would return 0 if accessed before 
			//the image gets loaded.
			native_width = image_object.width;
			native_height = image_object.height;
			
			//x/y coordinates of the mouse
			//This is the position of #image_viewer with respect to the document.
			var magnify_offset = jQuery("#image_view").offset();
			//We will deduct the positions of #image_viewer from the mouse positions with
			//respect to the document to get the mouse positions with respect to the 
			//container(#image_viewer)
			var mx = e.pageX - magnify_offset.left;
			var my = e.pageY - magnify_offset.top;
			
			//Finally the code to fade out the glass if the mouse is outside the container
			if(mx < jQuery("#image_view").width() && my < jQuery("#image_view").height() && mx > 0 && my > 0)
			{
				jQuery(".large").fadeIn(100);
			}
			else
			{
				jQuery(".large").hide();
			}
			if(jQuery(".large").is(":visible"))
			{
				//The background position of .large will be changed according to the position
				//of the mouse over the #image_view image. So we will get the ratio of the pixel
				//under the mouse pointer with respect to the image and use that to position the 
				//large image inside the magnifying glass
				var rx = Math.round(mx/jQuery("#image_view").width()*native_width - jQuery(".large").width()/2)*-1;
				var ry = Math.round(my/jQuery("#image_view").height()*native_height - jQuery(".large").height()/2)*-1;
				var bgp = rx + "px " + ry + "px";
				
				//Time to move the magnifying glass with the mouse
				var px = mx - jQuery(".large").width()/2;
				var py = my - jQuery(".large").height()/2;
				//Now the glass moves with the mouse
				//The logic is to deduct half of the glass's width and height from the 
				//mouse coordinates to place it with its center at the mouse coordinates
				
				//If you hover on the image now, you should see the magnifying glass in action
				jQuery(".large").css({left: px, top: py, backgroundPosition: bgp});
			}

	})	
   jQuery(".thumb_image").hover(function(){
	    jQuery(".large").hide();
		var source = jQuery(this).find("img").attr("src");
		jQuery("#image_view").attr("src",source);
		jQuery(".large").css('background-image', 'url(' + source + ')');
	});
	
	jQuery("body > :not(#image_view)").hover(function() {
      	jQuery(".large").hide();
    });
	jQuery("body > :not(#main_wristwatch_container)").hover(function() {
      	jQuery(".large").hide();
    });
	jQuery(".dtab").click(function() {
		jQuery(".large").hide();
		jQuery(".dtab").removeClass("dtab_active");
		jQuery(this).addClass("dtab_active");
		var id = jQuery(this).attr("id");
		id = id.replace("tab_", "#");
		jQuery(".inner_details_cont").hide();
		jQuery(id).show();
		jQuery('html, body').animate({
        	scrollTop: jQuery("#contact_seller").offset().top
    	}, 500);
    });	
	jQuery(".dtab,.details_container,#brief_container,.desc5,.title5").hover(function() {
		jQuery(".large").hide();
    });		
	jQuery("#contact_seller").click(function(){
		jQuery(".dtab").removeClass("dtab_active");
		jQuery("#tab_contact").addClass("dtab_active");
		jQuery(".inner_details_cont").hide();
		jQuery("#contact").show();
		jQuery("#contact_name").focus();
		jQuery('html, body').animate({
        	scrollTop: jQuery(".dtab").offset().top
    	}, 500);
	});
	jQuery(window).scroll(function() {
      	jQuery(".large").hide();
    });		
	jQuery("#reset").click(function(){
		jQuery(".inp_public").val("");
	});
	jQuery("#send_message").click(function(){
		jQuery("#submit_message").html("Sending inquiry...");
		var error = "";
		if(jQuery("#contact_name").val() == ""){
			error += "Your name must not be equal to blanks.\n";
		}
		if(jQuery("#contact_country").val() == ""){
			error += "You must select a country.\n";
		}	
		if(jQuery("#contact_message").val() == ""){
			error += "You message must not be equal to blanks.\n";
		} else {
			var msg = jQuery("#contact_message").val();
			var pattern = /^[a-zA-Z0-9 "!?.-]+$/g;
			if( !pattern.test( msg ) ) {
				error += "Invalid characters are not allowed on message.\n";
			} 
		}			
		if(jQuery("#contact_email").val() == ""){
			error += "Your email must not be equal to blanks.\n";
			if(error !=""){
				jQuery("#submit_message").html("");
				alert(error);
			}
		} else {
			var data_obj = {email:jQuery("#contact_email").val(), 
							captcha_answer:jQuery("#captcha_answer").val(),
							captcha_key:jQuery("#captcha_key").val()};
			data_obj = jQuery.toJSON(data_obj);
			jQuery.ajax({
				type: "POST",
				url: jQuery("#load_initial").val(),
				cache: false,
				data: { type: jQuery("#type_initial").val(), args: data_obj }
			}).done(function( msg ) {
				// temporary internet down
				if(msg != ""){
					error += msg;
				}
				if(error !=""){
					jQuery("#recaptcha_reload").click();
					jQuery("#submit_message").html("");
					alert(error);
				} else {
					var data_obj = {name:jQuery("#contact_name").val(),
					        item:jQuery("#contact_item").val(),
							oid:jQuery("#oid").val(),
						    token:jQuery("#token").val(),
						    email:jQuery("#contact_email").val(),
							country:jQuery("#contact_country").val(),
							message:jQuery("#contact_message").val()};
							data_obj = jQuery.toJSON(data_obj);
					jQuery.ajax({
						type: "POST",
						url: jQuery("#load_initial").val(),
						cache: false,
						data: { type: jQuery("#send_inquiry").val(), args: data_obj }
					}).done(function( msg ) {
						jQuery("#recaptcha_reload").click();
						jQuery("#submit_message").html("");
						alert(msg);	
					});							

				}
			});		
		}		
	});
	jQuery("#add_friend").click(function(){
		var ths = jQuery(this);
		ths.html("<span style='color:red'>Adding...</span>");
		jQuery.ajax({
			type: "POST",
			url: jQuery("#load_initial").val(),
			cache: false,
			data: { type: jQuery("#type_friend").val(), args: jQuery("#uid").val() }
		}).done(function( msg ) {
			ths.html("Add as Friend");
			alert(msg);
		});		
	});
	jQuery("#tab_watchlist").click(function(){
		var ths = jQuery(this).html();
		jQuery.trim(ths);
		if(ths.indexOf("In Watchlist") > -1){
			alert("This watch item is already in your watchlist.");		
		} else {
			var this_elem = jQuery(this); 
			this_elem.html("Adding...");
			jQuery.ajax({
				type: "POST",
				url: jQuery("#load_initial").val(),
				cache: false,
				data: { type: jQuery("#type_watchlist").val(), args: jQuery("#item_i").val() }
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
});