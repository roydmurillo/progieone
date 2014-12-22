jQuery(document).ready(function() {
    $('#search_user').keyup(function(){
        
        var data_obj = {search_user:jQuery(this).val()};
		data_obj = jQuery.toJSON(data_obj);
        
        jQuery.ajax({
            type: "POST",
            url: jQuery("#load_initial").val(),
            cache: false,
            data: { type: jQuery("#type_search_user").val(), args: data_obj }
        }).done(function( msg ) {
            jQuery("#user_tbody").html(msg);
        });
    });
	
});