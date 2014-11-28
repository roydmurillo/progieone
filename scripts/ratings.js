jQuery(document).ready(function() {
    
    $('.cyberlike').on('click', function(){
            rating('ok');
    });
    $('.cyberdislike').on('click', function(){
            rating('no');
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