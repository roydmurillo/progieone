function reset_data(){
	tinyMCE.get("reply").setContent('');
}

jQuery(document).ready(function() {
	
	jQuery("#post_reply").click(function(){
		jQuery(this).parent().nextAll(".forum_reply").eq(0).toggle();
		jQuery("#forum_content").toggle();
	});

	jQuery("#close_window").click(function(){
		jQuery(".forum_reply").toggle();
		jQuery("#forum_content").toggle();
	});
	
	jQuery("#post_reply_button").click(function(){
		
		if(tinyMCE.get("reply").getContent() == ""){
			alert("You must provide a reply message in the message box before submitting.");
		} else {
			jQuery("#submit_add_reply").click();
		}
		
	});
		
});

jQuery(window).load(function(){reset_data();});