<script type="text/javascript" src="<?php echo base_url(); ?>tinymce/tinymce.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/editor3.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>styles/scroll.css">
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/scroll.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/json.js"></script>

<!-- content goes here -->
<?php $this->load->module("function_security"); 
	  $type_initial = $this->function_security->encode("validate_captcha");
	  $type_send = $this->function_security->encode("send_inquiry");
	  $ajax = $this->function_security->encode("dashboard-ajax"); ?>
<input id="load_initial" type="hidden" value="<?php echo base_url(); ?><?php echo $ajax; ?>">
<input id="type_initial" type="hidden" value="<?php echo $type_initial; ?>">
<input id="send_inquiry" type="hidden" value="<?php echo $type_send; ?>">
<input id="base_url" type="hidden" value="<?php echo base_url(); ?>">
<img src='<?php echo base_url(); ?>assets/images/warning.png' alt='preload' style="display:none">

<!-- content goes here -->
<div id="homepage">

		<div class="fleft" style="width:188px; background:ghostwhite; border:1px solid #CCC; min-height:100px; padding-bottom:12px; margin-right:12px;">
				
				<div style="float:left; margin:19px 0px 0px 18px; width:150px; border:1px solid #CCC; overflow:hidden; height:150px; line-height:140px; background:white; text-align:center">
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
							font-size: 12px;
							width: 150px;">
				
					<div style="float:left; clear:both; margin:5px 0px;">Last login: <?php echo $this->function_forums->last_updated($result[0]->user_logged); ?></div>		
					<div style="float:left; clear:both; margin:0px 0px;">Registered: <?php echo date("F j, Y", strtotime($result[0]->user_date)); ?></div>		
					
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
								padding: 15px 0px 0px;">
								
						<?php echo(trim($result[0]->user_description)); ?>
					</div>
				<?php } ?>

				<div style="float:left; clear:both; 
							margin:12px 20px; color: #555;
							font-family: arial;
							font-size: 13px;
							width: 150px;
							border-top:1px solid #CCC;
							border-bottom:1px solid #CCC">
							
					<?php echo $this->function_rating->get_stars($result[0]->user_id); ?>
					
					<div style="float:left; clear:both; margin:5px 0px;">
						<a href="<?php echo base_url() . "member_profile/" . $this->uri->segment(2)."/member_rating"; ?>">View User Ratings</a>
					</div>
					
				</div>	

				<div style="float:left; clear:both; 
							margin:12px 20px; color: #555;
							font-family: arial;
							font-size: 13px;
							width: 150px;">
					<div style="float:left; clear:both; ">
						<a href="<?php echo base_url() ?>send_pm/<?php echo $result[0]->user_name; ?>" style="padding:5px 40px;" class="css_btn_c0">Send PM</a>
					</div>
					
				</div>								
				
				
		</div>

		<div class="fleft" style="width:560px; margin-right:12px;">
		
			<div class="title_bar" style="width:755px; margin:0px 0px 10px 0px;">
				SEND PM
			</div>
			
			<?php 
			
			// check if login
			if($this->function_login->is_user_loggedin()){ 
				$user_id = unserialize($this->native_session->get("user_info"));
				$user_id = $user_id["user_id"];
				$username = $this->uri->segment(2);
				$this->db->where("user_name", $username);
				$recipient = $this->db->get("watch_users");
				$recipient = $recipient->result();
				
				if($this->function_login->check_if_same_user($result[0]->user_id)){

				?>
							
								<div class="regular_register" style="min-height:40px !important;">
											<img src='<?php echo base_url(); ?>assets/images/warning.png' alt='preload' style="float:left">
											<div style="float:left; margin-left:12px; margin-top:12px; color:red">
												 You are not allowed to send a messages to your own profile!
											</div>
								</div>
							
							<?php
				
				} else {
				
			?>

				<div id="dashboard_content">
				
					<!-- content goes here -->
					<?php if($this->native_session->get("message_pm")){	?>
						<div class="regular_register" style="min-height:40px !important;">
								<img src='<?php echo base_url(); ?>assets/images/check.png' alt='preload' style="float:left">
								<div style="float:left; margin-left:12px; margin-top:12px; color:red">
									Message was successfully sent!
								</div>									
									
						</div>
					<?php $this->native_session->delete("message_pm");} ?>	
					<div id="add_new_item">
						
						 
						 <div id="send_pm" style="float:left; padding:5px 50px; margin:10px 0px 20px 10px; border:1px solid #CCC;">  
						   <form method="POST">
							
							<div class="t_area" style="float:left; clear:both; margin-top:20px;">
								<div style="float:left; clear:both; font-family:arial; font-size:16px; font-weight:bold; color:#555; margin:5px 5px">Subject:</div><br>
								<div style="float:left; clear:both; margin-left:5px">
									<input type="text" name="message_title" id="subject" style="padding:5px; width:422px">
									<input type="hidden" value="<?php echo $user_id; ?>" name="message_user_id">
									<input type="hidden" value="<?php echo $recipient[0]->user_id; ?>" name="message_recipient_id">
								</div>
							</div>
							
							<div class="t_area" style="float:left; margin:20px 0px;clear:both;">
								<div style="float:left; clear:both; font-family:arial; font-size:16px; font-weight:bold; color:#555; margin:5px">Message:</div><br>
								<div style="float:left; clear:both; margin-left:5px">
									<textarea id="item_description" name="message_content" style="width:150%; height:300px;"></textarea>
								</div>
							</div>

							<div class="t_area" style="float:left; margin:20px 0px;clear:both;">
								<div style="float:left; clear:both; font-family:arial; font-size:16px; font-weight:bold; color:#555; margin:5px">Verify Captcha:</div><br>
								<div style="float:left; clear:both; margin-left:5px">
								<?php
								        $this->load->module("function_captcha");
										$cap= $this->function_captcha->create_captcha();
										$image = $cap["captcha"];
										$key = $cap["key"];
										echo $image["image"];
								?>
									<div style="float:left; clear:both; margin-left:0px">
									    <input type="hidden" id="captcha_key" value="<?php echo $key; ?>">
										<input class="input1"  type="text" id="captcha_answer" placeholder="Enter Captcha Code" style="padding:5px; width:349px">
									</div>
								</div>
							</div>							
							
							<div class="t_area" style="float:left; margin:10px 8px 20px 8px; clear:both;">
								<input class='css_btn_c0' type="button" onclick="reset_data()" value="Reset"/>
								<input id="submit_pm" class='css_btn_c0' type="button" value="Send Message">
								<input id="submit_sendpm" name="submit_sendpm" type="submit" value="Submit Info" style="display:none">
							</div>	
						</form>
						</div>
						
						</div><!-- add new item -->		
						<script type="text/javascript">
						jQuery(document).ready(function(){
							jQuery("#submit_pm").click(function(){
								var err = "";
								if(jQuery("#subject").val() == ""){
									err = "Subject is required.\n";
								}
								if(tinyMCE.get("item_description").getContent() == ""){
									err += "Message content is required.\n";
								}
								var data_obj = {captcha_answer:jQuery("#captcha_answer").val(),
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
										err += msg;
									}
									if(err != ""){
										alert(err);
									} else {
										jQuery("#submit_sendpm").click();
									}	
								});
								
							});
						});
						jQuery(window).load(function(){
							tinyMCE.get("item_description").setContent("");
						});
						</script>			
			
			<?php
				}
			} else { ?>
			
				<div class="regular_register" style="min-height:40px !important;">
							<img src='<?php echo base_url(); ?>assets/images/warning.png' alt='preload' style="float:left">
							<div style="float:left; margin-left:12px; margin-top:12px; color:red">
								 You need to be logged in to be able to send private message
							</div>
				</div>
			
			<?php
			}
			
			?>
			
		</div>
	</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("#desc_user").mCustomScrollbar({
		 theme:"dark"}
	);
});
</script>