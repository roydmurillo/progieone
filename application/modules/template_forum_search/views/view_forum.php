<!-- additional scripts -->
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/forum_scripts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/pagination.js"></script>

<div id="homepage" class="clearfix">
        
		<div class="title_bar">
			FORUM OVERVIEW
		</div>
		
		<div id="inner_dashboard">
			
			<?php 
			    
				//this tab is for logged in users only
				// this is for new, popular, own threads only
				
				if($user_logged_in){ ?>
			
				<div id="inner_dashboard_tab">
					
					<a href="<?php echo base_url(); ?>forums">
						<div class="<?php echo ($this->uri->segment(2) == "") ? "tab_inner_active":"tab_inner"; ?>"> 
							Forums
						</div>
					</a>
					
					<a href="<?php echo base_url(); ?>forums/your_thread">
						<div class="<?php echo ($this->uri->segment(2) == "your_thread") ? "tab_inner_active":"tab_inner"; ?>"> 
							Your Threads
						</div>
					</a>
	
					<a href="<?php echo base_url(); ?>forums/new">
						<div class="<?php echo ($this->uri->segment(2) == "new") ? "tab_inner_active":"tab_inner"; ?>"> 
							New Threads
						</div>
					</a>	
					
					<a href="<?php echo base_url(); ?>forums/popular">
						<div class="<?php echo ($this->uri->segment(2) == "popular") ? "tab_inner_active":"tab_inner"; ?>"> 
							Popular Threads
						</div>
					</a>									
	
					<a id="checkout" href="<?php echo base_url(); ?>forums/start_thread">
						<div class="<?php echo ($this->uri->segment(2) == "start_thread") ? "tab_inner_active":"tab_inner checkout"; ?>" style="width:120px !important"> 
							Start a Thread
						</div>
					</a>				
				
				</div>
			
			<?php } ?>
			
			<div id="dashboard_content" style="<?php echo ($this->function_login->is_user_loggedin()) ? "margin-top:20px":"margin-top:-12px" ?>">
				
				<?php
					
					$data["form_data"] = $forum_data;
					if(!$forum_type){
						$this->load->view("main_forum",$data);
					} else {
						
						$function_view = $forum_type . "_forum";
						$this->load->view($function_view,$data);
					}					
				?>			
			
			</div>
		
		</div>
        
</div>