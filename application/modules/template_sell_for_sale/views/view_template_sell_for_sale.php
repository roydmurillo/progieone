<!-- additional scripts -->
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/forsale_scripts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/pagination.js"></script>

<!-- content goes here -->
<?php $this->load->module("function_security"); 
	  $type_initial = $this->function_security->encode("for_sale_load_initial");
	  $type_delete = $this->function_security->encode("for_sale_delete_item");
	  $ajax = $this->function_security->encode("dashboard-ajax"); ?>
<input id="load_initial" type="hidden" value="<?php echo base_url(); ?>dashboard/<?php echo $ajax; ?>">
<input id="type_initial" type="hidden" value="<?php echo $type_initial; ?>">
<input id="type_delete" type="hidden" value="<?php echo $type_delete; ?>">
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
			SELL ITEMS
		</div>
		
		<div id="inner_dashboard">
		
			<div id="inner_dashboard_tab">
				
				<a href="<?php echo base_url(); ?>dashboard/sell/for_sale">
					<div class="tab_inner_active"> 
						Item Listings
					</div>
				</a>

				<a href="<?php echo base_url(); ?>dashboard/sell/new">
					<div class="tab_inner"> 
						Sell New Items
					</div>
				</a>				
                                <?php if($this->function_paypal->check_active()){ ?>
				<a id="checkout" href="<?php echo base_url(); ?>dashboard/checkout">
					<div class="tab_inner checkout"> 
						Checkout
					</div>
				</a>
                                <?php } ?>
			
			</div>
                    
			<div id="dashboard_content"><div id="loader"><div id="loader_inner"></div></div></div>
			
		
		</div>
        
</div>