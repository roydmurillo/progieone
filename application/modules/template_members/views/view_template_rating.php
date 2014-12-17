<link rel="stylesheet" href="<?php echo base_url(); ?>styles/scroll.css">
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/scroll.js"></script>

<!-- additional scripts -->
<style>
.star_rating{float:left; height:40px; margin:3px; width:40px; background:url(<?php echo base_url() ?>assets/images/star2.png) -8px -59px no-repeat;}
.star_rating:hover{cursor:pointer; cursor:hand}
#mce_55{float:left;}
</style>
<script type="text/javascript" src="<?php echo base_url(); ?>tinymce/tinymce.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/itemlist_scripts.js"></script>
<!-- content goes here -->
<?php $this->load->module("function_security"); 
      $this->load->module("function_country"); 
	  $type_initial = $this->function_security->encode("ajax_wishlist"); ?>
<input id="load_initial" type="hidden" value="<?php echo base_url() . $type_initial; ?>">

<!-- content goes here -->
<div id="homepage" style="margin-bottom:0px;">

		<div class="fleft" style="width:188px; background:ghostwhite; border:1px solid #CCC; min-height:100px; padding-bottom:12px; margin-right:12px; margin-bottom:20px">
				
				<div style="float:left; margin:19px 0px 0px 18px; width:150px; border:1px solid #CCC; overflow:hidden; height:150px; line-height:145px; background:white; text-align:center">
					<?php
						if($result[0]->user_avatar != ""){
						   $im = $result[0]->user_avatar;
						} else {
						   $im = base_url()."assets/images/avatar.jpg";
						} 
					?>
					<img src="<?php echo $im; ?>" style="max-width:150px; max-height:150px; vertical-align:middle;">
				</div>

				<div style="float:left; clear:both; color:#333; font-family:arial; margin:5px 20px;">
					<a style="color:#06C; font-weight:bold;" href="<?php echo base_url(); ?>member_profile/<?php echo $result[0]->user_name; ?>"><?php echo $result[0]->user_name; ?></a>
				</div>
				
				<div style="float:left; clear:both; margin:0px 20px;" class="flag flag-<?php echo strtolower($result[0]->user_country); ?>" title="<?php echo $this->function_country->get_country_name($result[0]->user_country); ?>"></div>

				<div style="float:left; clear:both; 
							margin:7px 20px; color: #777;
							font-family: arial;
							font-size: 11px;
							width: 150px;">
					<div style="float:left; clear:both; margin:5px 0px;width:200px;">Last login: <?php echo $this->function_forums->last_updated($result[0]->user_logged); ?></div>		
					<div style="float:left; clear:both; margin:0px 0px; width:200px;">Registered: <?php echo date("F j, Y", strtotime($result[0]->user_date)); ?></div>		

				</div>
				

				<?php
					if($result[0]->user_description !=""){
				?>
					<div id="desc_user" style="float:left; clear:both; 
								margin:12px 20px; color: #555;
								font-family: arial;
								font-size: 12px;
								width: 150px;
								overflow:auto;
								max-height:120px;
								min-height:50px;
								overflow-x: -moz-hidden-unscrollable;
								overflow-x: hidden;
								border-top: 1px solid #CCC;
								border-bottom: 1px solid #CCC;
								padding: 15px 0px 10px 0px;">
								
						<?php echo(trim($result[0]->user_description)); ?>
					</div>
				<?php } ?>

				<div style="float:left; clear:both; 
							margin:12px 20px; color: #555;
							font-family: arial;
							font-size: 13px;
							width: 150px;">
							
						<div id="refine_search" 
							 style="float:left; clear:both; 
							 margin:0px; color: #555;
							 font-family: arial;
							 font-size: 13px;
							 width: 150px;
							 overflow:hidden;">
							<div style="float: left;
										clear: both;
										width: 133px;
										text-align:center;
										padding: 7px;
										border: 1px solid #CCC;
										background: none repeat scroll 0% 0% #FFF;">
							Rating Votes			
							<?php
									for($x = 5; $x >= 1; $x--){?>
										<div style="float:left; clear:both; width:200px; margin-left:15px;">
											<?php 
											 $name = "count" . $x;
											 $htm = 0;
											 if($count1[0]->$name > 0){
												$htm = "<a href='".base_url()."member_profile/".$this->uri->segment(2)."/member_rating?rating=$x' style='text-decoration:underline'>".$count1[0]->$name."</a>";	
											 }
											 
											 echo $this->function_rating->display_stars($x) . "<div style='float:left; font-family:arial; margin:7px 5px'> = <b>" . $htm ."</b></div>";
											 ?>
										</div>					
									<?php
									}
							
							?>
							
							<a style='clear:both; float:left; margin-left:78px; font-size:12px;' href="<?php echo base_url()."member_profile/".$this->uri->segment(2)."/member_rating"; ?>">Show All</a>
							</div>	 
						</div>								

					
				</div>	

				<div style="float:left; clear:both; 
							margin:12px 20px; color: #555;
							font-family: arial;
							font-size: 13px;
							width: 150px;
							position:relative">
					<div style="float:left; clear:both; ">
						<a href="<?php echo base_url() ?>send_pm/<?php echo $result[0]->user_name; ?>" style="padding:5px 40px;" class="css_btn_c0">Send PM</a>
					</div>
					
		
				</div>								
				<div style="float:left; clear:both; 
							margin:0px 20px; color: #555;
							font-family: arial;
							font-size: 13px;
							width: 160px;
							overflow:hidden;
							margin-top:-12px;">
					
					<div style="float:left; clear:both; margin-top:12px; ">
						<a id="rate_show" href="#rate" style="padding: 5px 0px;
																		width: 145px;
																		text-align: center;" class="btn btn-primary">Rate This User</a>
					</div>
		
				</div>								

							
				
				
		</div>

		<div class="fleft" style="width:765px; margin-right:12px;">
		
		<div class="title_bar" style="width:755px; margin:0px 0px 10px 0px;">
			SELLER RATING
		</div>
		
		
		<div id="forum_content">

		<?php 
		
		if(!empty($ratings)){ ?>

			<?php if($submit_result != ""){	?>
				<div class="regular_register">
						<?php if(strpos($submit_result,"successfully") > -1 ) { ?>
							<i class="fa fa-check-circle"></i> <?php echo $submit_result; ?>
							</div>
						<?php } elseif(strpos($submit_result,"Error") > -1 ) { ?>
							<i class="fa fa-exclamation-triangle"></i> <?php echo $submit_result; ?>
							
						<?php } ?>
				</div>
			<?php } ?>	

			
				<?php

					  $check = 0;	
					  $ctr = 1;
						  $check++;
						  $u = 0;
						  foreach($ratings as $r){
								if($u == 0){
									$u = $r->rating_user_id;
								}	
								$user_info = $this->function_users->get_user_fields_by_id(array("user_name", "user_avatar"),$r->rating_rater_id);
								if(@$user_info["user_avatar"] != "") { 
									$img =  "<img style='max-width: 100px;
														max-height: 100px;
														vertical-align: middle;'
												  src='".$user_info["user_avatar"]."'>";
								} else { 
									$img =  "<img style='max-width: 100px;
														max-height: 100px;'
												  src='".base_url()."assets/images/avatar.jpg'>";
								}
								
								echo '<div class="forum_container" style="margin-bottom:15px !important">
									  <div class="forum_title" style="padding:0px 10px !important">
										<div class="div_td1" style="width:480px !important">
											Rated '.$this->function_forums->last_updated($r->rating_date).' 
										</div>
									   </div><!-- forum_title -->';
								echo "<div class='div_td_content' style='padding:0px !important; position:relative; min-height:160px; overflow:hidden;'>
											
											<div style='position:absolute;
														width: 100px;
														height: 100%;
														border-right: 1px solid #CCC;
														padding: 20px;
														left:0px;
														background:#fafafa'>
												
												<div style='float:left;
															clear: both;
															width: 100px;
															height: 100px;
															border: 1px solid #777;
															text-align: center;
															line-height: 95px;
															overflow: hidden;'>
															".$img."
												</div>
												<a style='float:left; color:#E56718; margin-top:8px' href='".base_url()."member_profile/".@$user_info["user_name"]."'>".@$user_info["user_name"]."</a>	 
											 
											
											</div>	
											
											<div style='min-height: 20px;
														margin-top:12px;
														clear:both;
														float:left;
														margin-left:160px;'>
														".$this->function_rating->display_stars($r->rating_rating)."
											</div>	
											<div style='float: left;
														width: 400px;
														margin-left:140px;
														height: 100%;
														padding: 20px;
														'>
														".$r->rating_comment."
											</div>									
									  </div>
							     </div>";
					
								$ctr++;
						  }
					  
					  
				?>	
			
			<?php
		
					  echo "<div class='pagination_links' style='float:left; clear:both; margin-top:20px; font-family:verdana; font-size:14px;'>";
					  if($links){
						  
						  echo $links;
					  }
					  echo "</div>";

				
			
			?>		   
		   
		   
		<?php
		} else {
			
			echo '<div id="total_message" 
					  style="float: left;
							height: 30px;
							line-height: 30px;
							color: red;
							width:580px;
							font-size: 12px;
							font-weight: bold;
							clear: both;
							font-family: arial;
							border: 1px solid #F00;
							padding: 5px 20px;
							margin: 5px 0px 12px 12px;
							background: none repeat scroll 0% 0% #FFFACD;">
						    0 Ratings Found on this user.
			       </div>';		
		
		} 

					  if($this->function_login->is_user_loggedin()){
					 		
					 		echo '<div id="rate_box" style="display:none; min-height:160px; margin-bottom:15px !important; width:610px; float:left; font-family:arial; margin:12px; border:1px solid #CCC; background:rgba(0,0,0,0.01)">';

								if($this->function_login->check_if_same_user($result[0]->user_id)){
									echo "<input type='hidden' value='1' id='same_user'>";
							    } else {
									
										$user_info = unserialize($this->native_session->get("user_info"));
										$ID = $user_info['user_id'];

										echo "<div style='padding:0px !important; width:100%;'>
												
												<div style='float: left;
															width: 400px;
															margin-left:10px;
															padding: 20px;
															margin-top:-12px;
															font-weight:bold;
															'>
															<form method='POST' action='".base_url()."member_profile/".$this->uri->segment(2)."/member_rating' >
															<a href='javascript:;' name='rate'></a>
															<h4 style='float:left; clear:both; color:#444'>SELECT RATING:</h4>
															
															<div style='float:left; clear:both; height:57px; background:white; padding:5px 12px; border:1px solid #CCC;'>
																<div class='star_rating'></div>
																<div class='star_rating'></div>
																<div class='star_rating'></div>
																<div class='star_rating'></div>
																<div class='star_rating'></div>
															</div>
															
															<input type='hidden' name='rated' value='".$result[0]->user_id."'>
															<input type='hidden' name='rater' value='".$ID."'>
															<input type='hidden' id='rating_count' name='rating_count'>
															
															<h4 style='float:left; clear:both; color:#444'>FEEDBACK MESSAGE:</h4>
															
															<textarea id='feedback' name='feedback' style='width:200px; float:left; clear:both; height:130px;'></textarea>
															
															<input id='submit_feedback' type='button' value='Submit Feedback' class='css_btn_c0' style='float:left; margin:12px 0px;'>
															<input id='cancel_feedback' type='button' value='Cancel' class='css_btn_c0' style='float:left; margin:12px 12px;'>
															<input type='submit' id='s_feed' name='submit_feedback' style='display:none'>
															</form>
												</div>									
										  </div>";
							    }

							echo "</div>";
					  } else {

							echo '<div id="total_message" 
								  style="float: left;
										height: 30px;
										line-height: 30px;
										color: red;
										width:580px;
										font-size: 12px;
										font-weight: bold;
										clear: both;
										font-family: arial;
										border: 1px solid #F00;
										padding: 5px 20px;
										margin: 0px 0px 22px 10px;
										background: none repeat scroll 0% 0% #FFFACD;">
										You must be logged in to be able to rate this user.
							   </div>';	
						 
					  }
		  
		?>
			
		</div>
  </div> 

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("#desc_user").mCustomScrollbar({
		 theme:"dark"}
	);
	jQuery("#rate_show").click(function(){
		if(jQuery("#rate_box").length > 0){
			if(jQuery("#same_user").length == 0){
				jQuery("#sending_feedback").hide();
				reset_data();
				jQuery("#rate_box").toggle();	
				jQuery(".star_rating").css('background-position','-8px -59px');
				if(jQuery(this).html() == "Rate This User"){
					jQuery(this).html("Hide Rating");
				} else {
					jQuery(this).html("Rate This User");
				}
			} else {
				alert("You cannot rate your own profile!");
			}
		} else {
			alert("You must be logged in to be able to rate this user!");
		}
	});	
	
	jQuery("#submit_feedback").click(function(){
		var err = "";
		if(jQuery(".counted").length == 0){
			err += "Star Rating is required!\n"
		}
		if(tinyMCE.get("feedback").getContent() == ""){
			err += "Feedback message is required!\n"
		}
		if(err != ""){
			alert(err);
		} else {
			jQuery("#rating_count").val(jQuery(".counted").length);
			jQuery("#s_feed").click();
		}

	});		
	jQuery("#cancel_feedback").click(function(){
		reset_data();
		jQuery(".star_rating").css('background-position','-8px -59px');
		jQuery("#rate_box").hide();	
		jQuery("#rate_show").html("Rate This User");
	});		
	jQuery(".star_rating").hover(function(){
		jQuery(this).css('background-position','-8px -5px');
		jQuery(this).addClass("counted");
		jQuery(this).prevAll(".star_rating").css('background-position','-8px -5px');
		jQuery(this).prevAll(".star_rating").addClass("counted");
		jQuery(this).nextAll(".star_rating").css('background-position','-8px -59px');
		jQuery(this).nextAll(".star_rating").removeClass("counted");
	});
});
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
	tinyMCE.get("feedback").setContent('');
}
jQuery(window).load(function(){reset_data();});
</script>