<!-- additional scripts -->
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/forum_scripts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/pagination.js"></script>

<div id="homepage">
        
		<div class="col-sm-9 col-md-10 main">
			<?php
				//this tab is for logged in users only
				// this is for new, popular, own threads only
				if($user_logged_in){ ?>
                    <div id="inner_dashboard_tab" class="btn-group">
                                        <a class="btn btn-default <?php echo ($this->uri->segment(2) == "") ? "active":"tab_inner"; ?>" href="<?php echo base_url(); ?>forums">
						Forums
					</a>
					<a class="btn btn-default <?php echo ($this->uri->segment(2) == "your/thread") ? "active":"tab_inner"; ?>" href="<?php echo base_url(); ?>forums/your_thread"> 
							Your Threads
					</a>
					<a class="btn btn-default <?php echo ($this->uri->segment(2) == "new") ? "active":"tab_inner"; ?>" href="<?php echo base_url(); ?>forums/new">
							New Threads
					</a>
					<a class="btn btn-default <?php echo ($this->uri->segment(2) == "popular") ? "active":"tab_inner"; ?>" href="<?php echo base_url(); ?>forums/popular">
							Popular Threads
					</a>
					<a class="btn btn-default <?php echo ($this->uri->segment(2) == "start_thread") ? "active":"tab_inner"; ?>" id="checkout" href="<?php echo base_url(); ?>forums/start_thread">
							Start a Thread
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