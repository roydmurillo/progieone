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
jQuery('body').on('click','.newpager',function(){

	var data_obj = {start:jQuery(this).text()};
    
    if(jQuery(this).text() == '<'){
        data_obj.start = selected_val - 1;
    }
    if(jQuery(this).text() == '>'){
        data_obj.start = parseInt(selected_val) + 1;
    }
    if(jQuery(this).text() == 'First'){
        data_obj.start = 1;
    }
    if(jQuery(this).text() == 'Last'){
        data_obj.start = count;
    }
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

var count = 0;
var selected_val = 0;
var from_val = 0;
var to_val = 0;
    
$(document).ready(function(){
    create_pager();
});

function create_pager(){

    count = $('#paginate_page option').length;
    selected_val = parseInt($('#paginate_page option:selected').val());
    from_val = selected_val - 2;
    to_val = selected_val + 2;
    var pager = '<ul class="pagination">';

    if(count > 3 && selected_val > 1){

        pager += '<li><a class="newpager" href="Javascript:;"><</a></li>';
    }
    if(from_val > 1){
        pager += '<li><a class="newpager" href="Javascript:;">First</a></li>';
    }
    
    for(var x=1; x<=count; x++){

        if(x >= from_val && x <= to_val){
            pager += '<li class="' + (selected_val == x ? 'active' : '') + '"><a class="newpager" href="Javascript:;">' + x + '</a></li>';
        }

    }

    if(selected_val < count){

        pager += '<li><a class="newpager" href="Javascript:;">></a></li>';
    }
    
    if(to_val < count){
        pager += '<li>&nbsp;<a class="newpager" href="Javascript:;">Last</a></li>';
    }
    
    pager +='</ul>';
    $('#divpager').html(pager);
}