jQuery(document).ready(function() {
	function ajax_load(data_obj){
        jQuery(".remark").show();
		jQuery(".remark").html("<img src='"+jQuery("#base_url").val()+"assets/images/ajax-loader.gif'>");
        jQuery.ajax({
            type: "POST",
            url: jQuery("#load_initial").val(),
            cache: false,
            data: { type: jQuery("#type_initial").val(), args: data_obj }
        }).done(function( msg ) {
            jQuery(".remark").html(msg);
        });
	}
    jQuery("#username").on("blur", function(){
		data_obj = jQuery(this).val();
        ajax_load(data_obj);
    });

});