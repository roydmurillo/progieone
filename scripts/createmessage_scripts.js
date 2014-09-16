jQuery(document).ready(function() {
	jQuery("#select_contacts").click(function(){
		jQuery("#contacts").show();
		var data_obj = {ud:jQuery("#message_user_id").val()};
		data_obj = jQuery.toJSON(data_obj);
        jQuery.ajax({
            type: "POST",
            url: jQuery("#load_initial").val(),
            cache: false,
            data: { type: jQuery("#type_contacts").val(), args: data_obj }
        }).done(function( msg ) {
			jQuery("#contacts").html(msg);
        });		
	});
	jQuery("body").on("click",".contact_info",function(){
		jQuery("#message_recipient_id").val(jQuery(this).find(".recipient").val());
		jQuery("#message_recipient_name").val(jQuery(this).find(".recipient_name").html());
		jQuery("#contacts").hide();
	});
	jQuery("#submit_new_message").click(function(){
		var error ="";
		if(jQuery("#message_title").val() == ""){
			error += "Message title must not be equal to blanks!\n";
		} 

		if(jQuery("#message_recipient_name").val() == ""){
			error += "Recipient must not be equal to blanks!\n";
		} 
		if(tinyMCE.get("item_description").getContent() == ""){
			error += "Your message must not be equal to blanks!\n";
		}
		
		if(jQuery("#message_recipient_name").val() != ""){
			var data_obj = {u:jQuery("#message_recipient_name").val()};
			data_obj = jQuery.toJSON(data_obj);
			jQuery.ajax({
				type: "POST",
				url: jQuery("#load_initial").val(),
				cache: false,
				data: { type: jQuery("#type_check").val(), args: data_obj }
			}).done(function( msg ) {
				if(msg == "0"){
					error += "Recipient username does not exist!\n";
				} else {
					jQuery("#message_recipient_id").val(msg);
				}
				if(error != ""){
					alert(error);
				} else {
					jQuery("#submit_message").click();
				}
			});		
		}
		
	});
});