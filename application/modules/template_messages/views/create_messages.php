<script type="text/javascript" src="<?php echo base_url(); ?>scripts/json.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>tinymce/tinymce.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/editor3.js"></script>
<?php $this->load->module("function_security"); 
	  $type_update = $this->function_security->encode("load_contacts");
	  $type_check = $this->function_security->encode("check_email");
	  $ajax = $this->function_security->encode("dashboard-ajax"); ?>
<input id="load_initial" type="hidden" value="<?php echo base_url(); ?>dashboard/<?php echo $ajax; ?>">
<input id="type_contacts" type="hidden" value="<?php echo $type_update; ?>">
<input id="type_check" type="hidden" value="<?php echo $type_check; ?>">
<input id="base_url" type="hidden" value="<?php echo base_url(); ?>">
<div id="homepage" class="clearfix">
		
 		<?php
    	//load sidebar left
		$this->load->module('template_sideleft_dashboard');
		$this->template_sideleft_dashboard->view_template_sideleft_dashboard(); 
		?>
        <div class="col-sm-9 col-md-10 main">
                    <div id="inner_dashboard_tab" class="btn-group">		
				<a class="btn btn-default <?php echo ($this->uri->segment(3) == "") ? "active":"tab_inner"; ?>" href="<?php echo base_url(); ?>dashboard/messages">
						Inbox
				</a>
				<a class="btn btn-default <?php echo ($this->uri->segment(3) == "create") ? "active":"tab_inner checkout"; ?>" href="<?php echo base_url(); ?>dashboard/messages/create"> 
						Create Message
				</a>
			</div>
				<div id="dashboard_content">
					<!-- content goes here -->
					<h2 class="h2_title">Create New Message</h2>
					<?php if($this->native_session->get("message_sent")){	?>
						<div class="regular_register green-alert">
							<i class="fa fa-check-circle"></i> Message was successfully sent!
								
						</div>
					<?php $this->native_session->delete("message_sent");} ?>	
					<div id="add_new_item">
						
							<form method="POST">
							<table class="table_add">
								<tbody>
									<tr>
										<td><div class="title_thread">Message Title</div>
										<input type="text" value="" id="message_title" name="message_title" class="input"></td>
									</tr>	
									<tr>
										<td><div class="title_thread">Recipient's Username</div>
										<input type="hidden" id="message_recipient_id" name="message_recipient_id" value="">
										<?php
											// aps12
											//$user_id = $this->function_users->get_user_fields("user_id");
											$user_id = unserialize($this->native_session->get("user_info"));
											$user_id = $user_id["user_id"];
										?>
										<input type="hidden" name="message_user_id" id="message_user_id" value="<?php echo $user_id; ?>">
										<input type="text" name="message_recipient_name" id="message_recipient_name" class="input"><a href="javascript:;" id="select_contacts" ><img style="width:20px;height:20px;" src="<?php echo base_url(); ?>assets/images/contacts.png">select from contacts</a>
										<div id="contacts">
										<div>Loading...<img style="width:200px" src="<?php echo base_url() ?>assets/images/loader.gif"></div>
										</div>	
										</td>
									</tr>	
								</tbody>
							</table>
							
							<div class="t_area">
								<div class="title_thread">Watch Description</div>
								<div>
									<textarea id="item_description" name="message_content"></textarea>
								</div>
							</div>
							
							<input class='btn btn-danger' type="button" onclick="reset_data()" value="Reset"/>
							<input id="submit_new_message" class='btn btn-default btn-green' type="button" value="Submit Info">
							<input id="submit_message" name="submit_message" type="submit" value="Submit Info" style="display:none">
						</form>
						
						</div><!-- add new item -->				
	
				</div>
	
			</div>
		
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/createmessage_scripts.js"></script>
