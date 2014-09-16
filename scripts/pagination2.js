// JavaScript Document
function loader2(){
	jQuery('#loader').css('opacity','0');
	jQuery('#loader').show();
	jQuery('#loader_inner').html('<img src=\"'+jQuery('#base_url').val()+'assets/images/loader.gif\" style=\"margin:200px auto 0px 280px\">');
	jQuery('#loader').animate({opacity:1},500);
}
function unloader2(){
		jQuery('#loader').animate({opacity:0},500);
		jQuery('#loader_inner').html('');
		jQuery('#loader').hide();
}                            
jQuery('body').on('click','#next',function(){
	var data_obj = {start:parseInt(jQuery('#paginate_page').val()) + 1, search_item:jQuery("#search_item").val(), show_entry:jQuery("#show_entry_message").val()};
	data_obj = jQuery.toJSON(data_obj);		
	loader2();
	jQuery.ajax({
			type: 'POST',
			url: jQuery('#load_initial').val(),
			cache: false,
			data: { type: jQuery("#type_initial").val(), args: data_obj }
		}).done(function( msg ) {
			unloader2();
			jQuery('#dashboard_content').html(msg);
	});
});
jQuery('body').on('click','#prev',function(){
	var data_obj = {start:parseInt(jQuery('#paginate_page').val()) - 1, search_item:jQuery("#search_item").val(), show_entry:jQuery("#show_entry_message").val()};
	data_obj = jQuery.toJSON(data_obj);	
	loader2();
	jQuery.ajax({
			type: 'POST',
			url: jQuery('#load_initial').val(),
			cache: false,
			data: { type: jQuery("#type_initial").val(), args: data_obj }
		}).done(function( msg ) {
			unloader2();
			jQuery('#dashboard_content').html(msg);
	});
});                            
jQuery('body').on('change','#paginate_page',function(){
	var data_obj = {start:jQuery(this).val(), search_item:jQuery("#search_item").val(), show_entry:jQuery("#show_entry_message").val()};
	data_obj = jQuery.toJSON(data_obj);	
	loader2();
	jQuery.ajax({
			type: 'POST',
			url: jQuery('#load_initial').val(),
			cache: false,
			data: { type: jQuery("#type_initial").val(), args: data_obj }
		}).done(function( msg ) {
			unloader2();
			jQuery('#dashboard_content').html(msg);
	});
});