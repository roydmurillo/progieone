jQuery(document).ready(function() {
    
    $('.cyberlike').on('click', function(){
        if(confirm('You are about to like this profile') == true){
            rating('ok');
        }
    });
    $('.cyberdislike').on('click', function(){
        if(confirm('You are about to dislike this profile?') == true){
            rating('no');
        }
    });
    $('#contact_seller_phone').on('click', function(){
        $(this).val($(this).attr('data-phone'));
    });

	function rating(type){
        var uid = $('#uid').val();
        var data_obj = {};
        data_obj.rating = type;
        data_obj.user_rated = uid;
        data_obj = jQuery.toJSON(data_obj);
        
        jQuery.ajax({
            type: "POST",
            url: jQuery("#load_initial_rating").val(),
            cache: false,
            data: { type: jQuery("#type_rating").val(), args: data_obj }
        });
	}
    
    function set_rating(){
        
    }
});