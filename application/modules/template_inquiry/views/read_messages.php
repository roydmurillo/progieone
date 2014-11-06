<script type="text/javascript" src="<?php echo base_url(); ?>tinymce/tinymce.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/editor3.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/read_scripts.js"></script>
<div id="homepage">
		
 		<?php
    	//load sidebar left
		$this->load->module('template_sideleft_dashboard');
		$this->template_sideleft_dashboard->view_template_sideleft_dashboard(); 
		?>
        
		<div class="title_bar">
			MESSAGES
		</div>
		
		<div id="inner_dashboard">
		
			<div id="inner_dashboard_tab">
				
				<a href="<?php echo base_url(); ?>dashboard/messages">
					<div class="<?php echo ($this->uri->segment(3) == "") ? "tab_inner_active":"tab_inner"; ?>"> 
						Inbox
					</div>
				</a>
				
				<a href="<?php echo base_url(); ?>dashboard/messages/create">
					<div class="<?php echo ($this->uri->segment(3) == "create") ? "tab_inner_active":"tab_inner checkout"; ?>"> 
						Create Message
					</div>
				</a>
				
				<a href="<?php echo base_url(); ?>dashboard/messages/create">
					<div class="tab_inner_active"> 
						Message Details
					</div>
				</a>				
			
			</div>
			
			<div id="dashboard_content">
			
			<!-- content goes here -->
			<h2 class="h2_title">Read Message</h2>

			<div style="float: left;
						font-family: arial;
						font-size: 14px;
						margin: 2px 0px 20px;
						width: 500px;
						min-height: 20px;">
				<a id="send_reply" class="css_btn_c0" href="javascript:;" style="float:left; padding:5px 9px !important">Send a Reply</a>
				<a id="view_messages" class="css_btn_c0" href="javascript:;" style="float:left; margin-left:12px;  padding:5px 9px !important">View Full Messages</a>
			</div>
			
			<div class="message_reply">
				
				<form method="POST">
				
					<h2 class="h2_title" style="width:100% !important">Post Reply</h2>
					<textarea name="message_content" id="message_content" class="content" style="height:300px;"></textarea>
					<input id="add_reset" type="button" class="css_btn_c3" onclick="reset_data()" value="Reset"  style="padding: 3px 18px !important;"/>
					<input id="post_reply_button" class="css_btn_c3" type="button" value="Submit Reply" style="padding: 3px 18px !important;">
					<input name="message_recipient_id" type="hidden" value="<?php echo $message_prev['message_user_id'] ?>"/>
					<input name="message_title" type="hidden" value="<?php echo $message_prev['message_title'] ?>"/>
					<?php
					// aps12
                    //$user_id = $this->function_users->get_user_fields("user_id");
                    $user_id = unserialize($this->native_session->get("user_info"));
					$user_id = $user_id["user_id"];
					?>
					<input name="message_user_id" type="hidden" value="<?php echo $user_id; ?>"/>
					<input name="message_parent_id" type="hidden" value="<?php echo $message_prev['message_parent_id'] ?>"/>
					<input id="submit_reply" name="submit_reply" type="submit" value="Submit Info" style="display:none">
				
				</form>
				
				<a href="javascript:;" id="close_window">Go Back to Current Thread</a>
			
			</div>

				<?php
					  echo "<div id='prev_message' style='display:none'>";
					  $check = 0;	
					  $ctr = 1;
		
					  if(!empty($message_prev)){
						  $parent_id = $message_prev['message_parent_id'];
						  $date = $message_prev['message_date'];
						  
						  $where = "message_parent_id = $parent_id AND message_date < '$date'";
						  $this->db->where($where,null,false);  	
						  $this->db->order_by("message_date","asc");
						  $message_info_parent = $this->db->get("watch_messages");  	
							
						  if($message_info_parent->num_rows() > 0){
							  $check++;
							  foreach($message_info_parent->result() as $r){
										
									$user_info = $this->function_users->get_user_fields_by_id(array("user_name", "user_avatar"),$r->message_user_id);
									if($user_info["user_avatar"] != "") { 
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
											<div class="div_td1">
												Sent '.$this->function_forums->last_updated($r->message_date).' 
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
													<a style='float:left; color:#E56718; margin-top:8px' href='".base_url()."member_profile/".$user_info["user_name"]."'>".$user_info["user_name"]."</a>	 
												 
												
												</div>	
												
												<div style='float: left;
															width: 400px;
															margin-left:140px;
															height: 100%;
															padding: 20px;
															'>
															".$r->message_content."
												</div>									
										  </div>
									</div>";
						
									$ctr++;
							  }
							  
						  } 	
					  }
					  echo "</div><div id='latest_message'>";
					  if($message_info){
						  $check++;
						  foreach($message_info as $r){
									
								$user_info = $this->function_users->get_user_fields_by_id(array("user_name", "user_avatar"),$r->message_user_id);
								if($user_info["user_avatar"] != "") { 
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
											Sent '.$this->function_forums->last_updated($r->message_date).' 
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
												<a style='float:left; color:#E56718; margin-top:8px' href='".base_url()."member_profile/".$user_info["user_name"]."'>".$user_info["user_name"]."</a>	 
											 
											
											</div>	
											
											<div style='float: left;
														width: 400px;
														margin-left:140px;
														height: 100%;
														padding: 20px;
														'>
														".$r->message_content."
											</div>									
									  </div>
								</div>";
					
								$ctr++;
						  }
						  
					  } 
					  
					  echo "</div>";		   	
				
				?>			
			
			</div>
			
		
		</div>
        
</div>