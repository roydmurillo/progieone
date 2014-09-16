<!-- additional scripts -->
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/beingwatched_scripts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/pagination4.js"></script>


<!-- content goes here -->
<?php $this->load->module("function_security"); 
	  $type_initial = $this->function_security->encode("load_being_watched");
	  $type_delete = $this->function_security->encode("delete_inquiry");
	  $type_open = $this->function_security->encode("update_open_inquiry");
	  $ajax = $this->function_security->encode("dashboard-ajax"); ?>
<input id="load_initial" type="hidden" value="<?php echo base_url(); ?>dashboard/<?php echo $ajax; ?>">
<input id="type_initial" type="hidden" value="<?php echo $type_initial; ?>">
<input id="type_delete" type="hidden" value="<?php echo $type_delete; ?>">
<input id="type_open" type="hidden" value="<?php echo $type_open; ?>">
<input id="base_url" type="hidden" value="<?php echo base_url(); ?>">



<!-- hdn -->
<?php
	if($this->uri->segment(4) == "page" && $this->uri->segment(5) != ""){
		if(preg_match("/^[0-9]+$/", $this->uri->segment(5))){
			echo "<input id='start' type='hidden' value='". $this->uri->segment(5) ."'>";
		} 
	} else {
		echo "<input id='start' type='hidden' value='0'>";
	}
?>
<div id="homepage">
		
 		<?php
    	//load sidebar left
		$this->load->module('template_sideleft_dashboard');
		$this->template_sideleft_dashboard->view_template_sideleft_dashboard(); 
		?>
        
		<div class="title_bar">
			ITEMS BEING WATCHED
		</div>
		
		<div id="inner_dashboard">
		
			<div id="inner_dashboard_tab">
				
				<a href="<?php echo base_url(); ?>dashboard/inquiry">
					<div class="<?php echo ($this->uri->segment(3) == "") ? "tab_inner_active":"tab_inner"; ?>"> 
						Inquiries
					</div>
				</a>
				
				<a href="<?php echo base_url(); ?>dashboard/inquiry/being_watched">
					<div class="<?php echo ($this->uri->segment(3) == "being_watched") ? "tab_inner_active":"tab_inner"; ?>"> 
						Being Watched
					</div>
				</a>
			
			</div>
			
			<div id="dashboard_content"><div id="loader"><div id="loader_inner"></div></div></div>
			
		
		</div>
        
</div>