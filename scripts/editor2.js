// JavaScript Document
function strip_tags (str, allowed_tags)
{

    var key = '', allowed = false;
    var matches = [];    var allowed_array = [];
    var allowed_tag = '';
    var i = 0;
    var k = '';
    var html = ''; 
    var replacer = function (search, replace, str) {
        return str.split(search).join(replace);
    };
    // Build allowes tags associative array
    if (allowed_tags) {
        allowed_array = allowed_tags.match(/([a-zA-Z0-9]+)/gi);
    }
    str += '';

    // Match tags
    matches = str.match(/(<\/?[\S][^>]*>)/gi);
    // Go through all HTML tags
    for (key in matches) {
        if (isNaN(key)) {
                // IE7 Hack
            continue;
        }

        // Save HTML tag
        html = matches[key].toString();
        // Is tag not in allowed list? Remove from str!
        allowed = false;

        // Go through all allowed tags
        for (k in allowed_array) {            // Init
            allowed_tag = allowed_array[k];
            i = -1;

            if (i != 0) { i = html.toLowerCase().indexOf('<'+allowed_tag+'>');}
            if (i != 0) { i = html.toLowerCase().indexOf('<'+allowed_tag+' ');}
            if (i != 0) { i = html.toLowerCase().indexOf('</'+allowed_tag)   ;}

            // Determine
            if (i == 0) {                allowed = true;
                break;
            }
        }
        if (!allowed) {
            str = replacer(html, "", str); // Custom replace. No regexing
        }
    }
    return str.replace(/[&\/\\#,+()$~%.'":*?<>{}=;[]|]/g,' ');
}
tinymce.init({
		selector: "textarea",
		plugins: [
				"advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
				"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
				"table contextmenu directionality emoticons template textcolor paste textcolor"
		],

		fontsize_formats: "8px 9px 10px 11px 12px 13px 14px 15px 16px 17px 18px",		
	toolbar1: "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | cut copy paste | searchreplace | ltr rtl | spellchecker",
	toolbar2: "bullist numlist | outdent indent blockquote | undo redo | forecolor backcolor emoticons",

		menubar: false,
		toolbar_items_size: 'small',

		style_formats: [
				{title: 'Bold text', inline: 'b'},
				{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
				{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
				{title: 'Example 1', inline: 'span', classes: 'example1'},
				{title: 'Example 2', inline: 'span', classes: 'example2'},
				{title: 'Table styles'},
				{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
		],

		templates: [
				{title: 'Test template 1', content: 'Test 1'},
				{title: 'Test template 2', content: 'Test 2'}
		],
		
		paste_preprocess : function(pl, o) {
		  //example: keep bold,italic,underline and paragraphs
		  //o.content = strip_tags( o.content,'<b><u><i><p>' );
		
		  // remove all tags => plain text
		  o.content = strip_tags( o.content,'' );
		}
});
function reset_data(){
	jQuery(".input").val('');
	tinyMCE.get("item_description").setContent('');
	tinyMCE.get("item_shipping").setContent('');
//	var yearnow = new Date().getFullYear();
//	jQuery("#item_year_model").val(yearnow);
}
jQuery(window).load(function(){
	tinyMCE.get("item_description").setContent(jQuery("#i_desc").html(),{format : 'raw'});
	tinyMCE.get("item_shipping").setContent(jQuery("#i_ship").html(),{format : 'raw'});
});