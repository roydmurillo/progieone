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
        <div class="col-sm-9 col-md-10 main">	
            <div id="inner_dashboard_tab" class="btn-group">
                <a class="btn btn-default <?php echo ($this->uri->segment(3) == "for_sale") ? "active":"tab_inner"; ?>" href="<?php echo base_url(); ?>dashboard/sell/for_sale">
						Item Listings
				</a>
				<a class="btn btn-default btn-green <?php echo ($this->uri->segment(3) == "new") ? "active":"tab_inner"; ?>" href="<?php echo base_url(); ?>dashboard/sell/new">
						Sell New Items
				</a>				
                                <?php if($this->function_paypal->check_active()){ ?>
				<a class="btn btn-default btn-red <?php echo ($this->uri->segment(2) == "checkout") ? "active":"tab_inner"; ?>" id="checkout" href="<?php echo base_url(); ?>dashboard/checkout">
						Checkout
				</a>
                                <?php } ?>
			</div>                  
            <div id="dashboard_content"><?php 
                $this->load->module("function_items");
                $data['main_page'] = $this->function_items->for_sale_load_initial_new();?>
            </div>
		</div>
        
</div>