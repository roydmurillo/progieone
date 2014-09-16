jQuery(document).ready(function() {
	jQuery("#view_messages").click(function(){
		jQuery("#prev_message").toggle();
		jQuery("#latest_message").show();
		jQuery(".message_reply").hide();
	});
	jQuery("#send_reply").click(function(){
		jQuery(".message_reply").toggle();
		if ( jQuery(".message_reply").is(":visible") ) {
			jQuery("#latest_message").hide();
			jQuery("#prev_message").hide();
		} else { 
			jQuery("#latest_message").show();
		}
	});
	jQuery("#post_reply_button").click(function(){
		if(tinyMCE.get("message_content").getContent() == ""){
			alert("Your Messege must not be blanks.");		
		} else {
			jQuery("#submit_reply").click();
		}
	});
});