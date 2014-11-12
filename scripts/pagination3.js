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
	var data_obj = {start:parseInt(jQuery('#paginate_page').val()) + 1};
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
	var data_obj = {start:parseInt(jQuery('#paginate_page').val()) - 1};
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
	var data_obj = {start:jQuery(this).val()};
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
jQuery('body').on('click','.newpager',function(){
	var data_obj = {start:jQuery(this).text()};
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
            create_pager();
	});
});


$(document).ready(function(){
    create_pager();
});

function create_pager(){

    var count = $('#paginate_page')[0].childElementCount;

    var pager = '<ul class="pagination">';
    for(var x=1; x<=count; x++){
        if(x == 1){
            pager += '<li class="active"><a class="newpager" href="Javascript:;">' + x + '</a></li>';
        }
        else{
            pager += '<li><a class="newpager" href="Javascript:;">' + x + '</a></li>';
        }
    }
    pager +='</ul>';
    $('#divpager').html(pager);
}