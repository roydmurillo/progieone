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
    
    $('#change_pass').click(function(){
        $('#myModal').modal('show');
    });

    $('#submit_change_pass').on('click',function(){

        if(validateEmail($('#email').val())){

            var data_obj = {email:jQuery('#email').val()};
            data_obj = jQuery.toJSON(data_obj);	
    
            jQuery.ajax({
                type: "POST",
                url: jQuery("#load_initial").val(),
                data: { type: jQuery("#type_initial").val(), args: data_obj },
                success : function(html){
                    $('#myModal').modal('hide');
                    alert(html);
                }
            });
        }
        else{
            alert('Email invalid');
        }
    });
//    $('#submit_change_pass').click(function(){
//        
//        if(validateEmail($('#email').val())){
//
//            var data_obj = {email:jQuery('#email').val()};
//            data_obj = jQuery.toJSON(data_obj);	
//    
//            jQuery.ajax({
//                type: "POST",
//                url: jQuery("#load_initial").val(),
//                data: { type: jQuery("#type_initial").val(), args: data_obj },
//                success : function(html){
//                    
//                }
//            });
//        }
//        else{
//            alert('Email invalid');
//        }
//    });
    
});