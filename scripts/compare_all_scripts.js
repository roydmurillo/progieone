jQuery(document).ready(function() {
	function ajax_load(data_obj){
        loader();
        jQuery.ajax({
            type: "POST",
            url: jQuery("#load_initial").val(),
            cache: false,
            data: { type: jQuery("#type_initial").val(), args: data_obj }
        }).done(function( msg ) {
            unloader();
            jQuery("#dashboard_content").html(msg);
			jQuery("#scroll_content").mCustomScrollbar({
				 theme:"dark",
				 scrollButtons:{
					enable:true
				}}
			);
			jQuery(".desc").mCustomScrollbar({
				theme:"dark",
				 scrollButtons:{
					enable:true
				}}
			);
        });
	}
    function loader(){
        jQuery("#loader").css("opacity","0");
        jQuery("#loader").show();
        jQuery("#loader_inner").html("<img src='"+jQuery("#base_url").val()+"assets/images/loader.gif' style='margin:200px auto 0px 280px'>");
        jQuery("#loader").animate({opacity:1},500);
    }
    function unloader(){
            jQuery("#loader").animate({opacity:0},500);
            jQuery("#loader_inner").html("");
            jQuery("#loader").hide();
    }
//    if(jQuery("#load_initial").val() != ""){
//		var data_obj = {start:jQuery("#start").val()};
//		data_obj = jQuery.toJSON(data_obj);
//        ajax_load(data_obj);
//    }
		
});