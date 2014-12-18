<script type="text/javascript" src="<?php echo base_url(); ?>tinymce/tinymce.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/json.js"></script>
<script type="text/javascript">
	function reset_data(){
		jQuery(".input").val('');
		jQuery(".input2").val('');
		jQuery(".input3").val('');
		jQuery(".input4").val('');
	}
</script>	
<style>
#filter_return{float:left; font-size:12px; font-family:Verdana; width:767px; border:1px dashed #CCC; border-left:none; border-right:none; height:30px; line-height:30px; vertical-align:middle; margin:0px 0px 10px 0px;}
#details_basic{
background: #fbfbfb; /* Old browsers */
width:563px !important;
border:1px solid #CCC; }
#send_pm{background:rgba(0,0,0,0.05) !important;}
</style>
<!-- content goes here -->
<?php $this->load->module("function_security"); 
	  $type_initial = $this->function_security->encode("captcha_email");
	  $type_message = $this->function_security->encode("send_contact_us_email");
	  $type_send = $this->function_security->encode("send_inquiry");
	  $ajax = $this->function_security->encode("dashboard-ajax"); ?>
<input id="load_initial" type="hidden" value="<?php echo base_url(); ?><?php echo $ajax; ?>">
<input id="type_initial" type="hidden" value="<?php echo $type_initial; ?>">
<input id="type_message" type="hidden" value="<?php echo $type_message; ?>">
<input id="send_inquiry" type="hidden" value="<?php echo $type_send; ?>">
<input id="base_url" type="hidden" value="<?php echo base_url(); ?>">

<!-- content goes here -->
<div id="contact">

 		<?php
//		if($this->function_login->is_user_loggedin()){
//    	  $this->load->module('template_sideleft_loggedin');
//		  $this->template_sideleft_loggedin->view_template_sideleft_loggedin(); 
//		} else {
//		  $this->load->module('template_sideleft');
//		  $this->template_sideleft->view_template_sideleft(); 
//		}
		?>
		<div class="body">
			<div>
					<!-- content goes here -->
					<?php if($this->native_session->get("message_contact_us")){	?>
						<div class="regular_register green-alert">
								<i class="fa fa-check-circle"></i> Your Inquiry was successfully sent! We will reply to you as soon as possible. Thank You!												
						</div>
					<?php $this->native_session->delete("message_contact_us");} ?>	
				<div>	
				</div>
					<div class="col-md-6 ma-t1em">
						<div class="panel panel-default">
                                                   <div class="panel-heading">Contact</div>
                                                <div class="panel-body">  
                                                   <p>Cyberwatchcafe is an ecommerce advertising website listings for watch enthusiasts. Feel free to drop us some email if you have inquiries and we will be glad to reply on your important questions.</p>
						   <form role="form" method="POST">
							<div class="form-group">
								<label for="sender_name">Name:</label>
								<input class="input1 form-control" type="text" name="sender_name" id="sender_name" placeholder="Your Name">
							</div>
							<div class="form-group">
								<label for="sender_email">Email:</label>
								<input class="input1 form-control"  type="text" name="sender_email" id="sender_email" placeholder="Your Email">
							</div>	
							<div class="form-group">
								<label for="sender_country">Country:</label>				
									<select class="input1 form-control"  id="sender_country" name="sender_country">
										<option value=""> -- Select Country --</option>
										<?php 
											
											$arr = $this->function_country->get_country_array();
											foreach($arr as $key => $val){
												
												echo "<option value='$key'>$val</option>";
												
											}								
										?>
									</select>											
							</div>

							<div class="form-group">
                                                            <label for="sender_subject">Subject:</label>
                                                            <input class="input1 form-control"  type="text" name="sender_subject" id="sender_subject" placeholder="Subject of Interest">
							</div>
							
							<div class="form-group">
                                                            <label for="sender_message">Message:</label>
                                                            <textarea class="form-control" row="3" id="sender_message" name="sender_message"></textarea>
							</div>

							<div class="form-group">
                                                            <label for="captcha_answer">Verify Captcha:</label>
                                                            <div>
								<?php
								        $this->load->module("function_captcha");
										$cap= $this->function_captcha->create_captcha();
										$image = $cap["captcha"];
										$key = $cap["key"];
										echo $image["image"];
								?>
									<div>
									    <input type="hidden" id="captcha_key" value="<?php echo $key; ?>">
                                                                            <input class="input1 form-control"  type="text" name="captcha_answer" id="captcha_answer" placeholder="Enter Captcha Code">
									</div>
                                                            </div>
							</div>							
							
							<div class="form-group">
								<input class='btn btn-default' type="button" onclick="reset_data()" value="Reset"/>
								<input id="submit_pm" class='btn btn-default' type="button" value="Send Message">
								<input id="submit_sendpm" name="submit_sendpm" type="submit" value="Submit Info" style="display:none">
							</div>
							<div id="remarks"></div>	
						</form>
                                            </div>	
                                            </div>
		</div>
</div>
</div>
</div>
<script type="text/javascript">
// JavaScript Document
// Strips HTML and PHP tags from a string 
// returns 1: 'Kevin <b>van</b> <i>Zonneveld</i>'
// example 2: strip_tags('<p>Kevin <img src="someimage.png" onmouseover="someFunction()">van <i>Zonneveld</i></p>', '<p>');
// returns 2: '<p>Kevin van Zonneveld</p>'
// example 3: strip_tags("<a href='http://kevin.vanzonneveld.net'>Kevin van Zonneveld</a>", "<a>");
// returns 3: '<a href='http://kevin.vanzonneveld.net'>Kevin van Zonneveld</a>'
// example 4: strip_tags('1 < 5 5 > 1');
// returns 4: '1 < 5 5 > 1'
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
    return str;
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
		  o.content = strip_tags( o.content,'<b><u><i><p>' );
		
		  // remove all tags => plain text
		  //o.content = strip_tags( o.content,'' );
		}

});

function reset_data(){
	tinyMCE.get("sender_message").setContent('');
	jQuery(".input1").val("");
	jQuery("#recaptcha_reload").click();
}
jQuery(window).load(function(){reset_data();});

jQuery(document).ready(function(){
	jQuery("#submit_pm").click(function(){
		jQuery("#remarks").html("Sending inquiry...");
		var error = "";
		if(jQuery("#sender_name").val() == ""){
			error += "Your name must not be equal to blanks.\n";
		}
		if(jQuery("#sender_country").val() == ""){
			error += "You must select a country.\n";
		}	
		if(jQuery("#sender_subject").val() == ""){
			error += "Your subject must not be equal to blanks.\n";
		} else {
			var msg = jQuery("#subject_message").val();
			var pattern = /^[a-zA-Z0-9 "!?.-]+$/g;
			if( !pattern.test( msg ) ) {
				error += "Invalid characters are not allowed on subject.\n";
			} 
		}	
		if(tinyMCE.get("sender_message").getContent() == ""){
			error += "Your message must not be equal to blanks.\n";
		}		
		if(jQuery("#sender_email").val() == ""){
			error += "Your email must not be equal to blanks.\n";
			if(error !=""){
				jQuery("#remarks").html("");
				alert(error);
			}
		} else {
			var data_obj = {email:jQuery("#sender_email").val(), 
							captcha_answer:jQuery("#captcha_answer").val(),
							captcha_key:jQuery("#captcha_key").val()};
			data_obj = jQuery.toJSON(data_obj);
			jQuery.ajax({
				type: "POST",
				url: jQuery("#load_initial").val(),
				cache: false,
				data: { type: jQuery("#type_initial").val(), args: data_obj }
			}).done(function( msg ) {
				// temporary internet down
				if(msg != ""){
					error += msg;
				}
				if(error !=""){
					jQuery("#recaptcha_reload").click();
					jQuery("#remarks").html("");
					alert(error);
				} else {
					jQuery("#submit_sendpm").click();
				}
			});		
		}		
	});

});
</script>

