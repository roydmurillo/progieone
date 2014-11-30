<div id="homepage" class="clearfix">
		
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
			
			</div>
			
			<div id="dashboard_content">
				<div class="regular_register" style="min-height:40px !important; float:left;">
						<img src='<?php echo base_url(); ?>assets/images/warning.png' alt='preload' style="float:left">
						<div style="float:left; margin-left:12px; margin-top:12px; color:red">
							No Message was Found. Please Correct your URL.
						</div>									
				</div>
			</div>
		
		</div>	

        
</div>