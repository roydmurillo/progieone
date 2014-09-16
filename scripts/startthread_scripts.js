function reset_data(){
	jQuery(".thread").val('');
	tinyMCE.get("thread_content").setContent('');
}

jQuery(document).ready(function() {
	
	jQuery("#post_submit_thread").click(function(){
		
		var error = "";
		
		if(jQuery("#thread_title").val() == ""){
			error += "Thread Title must not be blanks.\n"; 
		}
		
		if(jQuery("#thread_category_id").val() == ""){
			error += "Thread Category must be selected.\n"; 
		}
		
		if(tinyMCE.get("thread_content").getContent() == ""){
			error += "You must provide a reply message in the message box before submitting.";
		} 
		
		if(error != ""){
			alert(error);
		} else {
			jQuery("#submit_add_thread").click();
		}
		
	});
		
});

jQuery(window).load(function(){reset_data();});