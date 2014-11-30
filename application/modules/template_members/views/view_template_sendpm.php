<script type="text/javascript" src="<?php echo base_url(); ?>tinymce/tinymce.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/editor3.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>styles/scroll.css">
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/scroll.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/json.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/ratings.js"></script>

<!-- content goes here -->
<?php $this->load->module("function_security"); 
	  $type_initial = $this->function_security->encode("validate_captcha");
	  $type_send = $this->function_security->encode("send_inquiry");
	  $ajax = $this->function_security->encode("dashboard-ajax"); 
          $type_rating = $this->function_security->encode("cyber_rating");
?>
<input id="load_initial_rating" type="hidden" value="<?php echo base_url() . $ajax; ?>">
<input id="load_initial" type="hidden" value="<?php echo base_url(); ?><?php echo $ajax; ?>">
<input id="type_initial" type="hidden" value="<?php echo $type_initial; ?>">
<input id="send_inquiry" type="hidden" value="<?php echo $type_send; ?>">
<input id="type_rating" type="hidden" value="<?php echo $type_rating; ?>">
<input id="base_url" type="hidden" value="<?php echo base_url(); ?>">
<img src='<?php echo base_url(); ?>assets/images/warning.png' alt='preload' style="display:none">

<!-- content goes here -->
<div id="homepage" class="clearfix">

		<div class="col-sm-3 col-md-2 sidebar" >
				
                    <div id="avatar" class="dashboard_avatar">
					<?php
						if($result[0]->user_avatar != ""){
						   $im = $result[0]->user_avatar;
						} else {
						   $im = base_url()."assets/images/avatar.jpg";
						} 
					?>
					
                                        <div class="profile-photo" style="background:url('<?php echo $im ?>') center center no-repeat; background-size:cover;"></div>
				

				<div >
					<a  href="<?php echo base_url(); ?>member_profile/<?php echo $result[0]->user_name; ?>"><?php echo $result[0]->user_name; ?></a>
				</div>
				

				<div >
					<div >Last login: <?php echo $this->function_forums->last_updated($result[0]->user_logged); ?></div>		
					<div >Registered: <?php echo date("F j, Y", strtotime($result[0]->user_date)); ?></div>							
				</div>
				

				<?php
					if($result[0]->user_description !=""){
				?>
					<div id="desc_user" >
								
						<?php echo(trim($result[0]->user_description)); ?>
					</div>
				<?php } ?>

				<div >
							
					<?php // echo $this->function_rating->get_stars($result[0]->user_id); ?>
					<?php

                                            $this->load->module("function_ratings");
                                            $ret_count = $this->function_ratings->get_count_all_rating($result[0]->user_id);
                                            $single_rating = $this->function_ratings->get_single_ratings($result[0]->user_id);
                                            $like_flag = $ret_count['ok'] == 1 ? 1 : 0;
                                            $dislike_flag = $ret_count['no'] == 1 ? 1 : 0;
                                        ?>
					<div >
<!--                                            <a href="<?php // echo base_url() . "member_profile/" . $this->uri->segment(2)."/member_rating"; ?>">View User Ratings</a>-->
                                            <input type="hidden" id="uid" value="<?php echo $result[0]->user_id; ?>">
                                            <a href="Javascript:;" class="cyberlike" data-count="<?php echo $ret_count['ok'];?>"><i class="fa fa-thumbs-o-up"></i></a><span class="badge">&nbsp;<?php echo $ret_count['ok'];?></span>&nbsp;
                                            <a href="Javascript:;" class="cyberdislike" data-count="<?php echo $ret_count['no'];?>"><i class="fa fa-thumbs-o-down"></i></a><span class="badge">&nbsp;<?php echo $ret_count['no'];?></span></div>
					</div>
					
				</div>	

<!--				<div >
					<div>
						<a href="<?php echo base_url() ?>send_pm/<?php echo $result[0]->user_name; ?>" class="btn btn-primary">Send message</a>
					</div>
					
				</div>								-->
				
				
		</div>

		<div class="col-sm-9 col-md-10 main">
		
			<div class="title_bar">
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
						
						 
                                            <div id="send_pm" class="col-xs-12">  
						   <form method="POST">
							
							<div class="t_area" >
								<div >Subject:</div>
								<div >
									<input type="text" name="message_title" id="subject" style="padding:5px; width:422px">
									<input type="hidden" value="<?php echo $user_id; ?>" name="message_user_id">
									<input type="hidden" value="<?php echo $recipient[0]->user_id; ?>" name="message_recipient_id">
								</div>
							</div>
							
							<div class="t_area" >
								<div >Message:</div>
								<div >
									<textarea id="item_description" name="message_content"></textarea>
								</div>
							</div>

							<div class="t_area" >
								<div >Verify Captcha:</div>
								<div>
								<?php
								        $this->load->module("function_captcha");
										$cap= $this->function_captcha->create_captcha();
										$image = $cap["captcha"];
										$key = $cap["key"];
										echo $image["image"];
								?>
									<div >
									    <input type="hidden" id="captcha_key" value="<?php echo $key; ?>">
										<input class="input1"  type="text" id="captcha_answer" placeholder="Enter Captcha Code">
									</div>
								</div>
							</div>							
							
							<div class="t_area">
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
							<div>
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