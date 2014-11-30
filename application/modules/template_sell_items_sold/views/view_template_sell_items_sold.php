<!-- additional scripts -->
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/dashboard_scripts.js"></script>

<!-- content goes here -->
<input id="load_initial" type="hidden" value="<?php echo base_url() ?>dashboard/sell/items_sold/ajax">
<div id="homepage" class="clearfix">
		
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
				<a class="btn btn-default <?php echo ($this->uri->segment(3) == "item_sold") ? "active":"tab_inner"; ?>" href="<?php echo base_url(); ?>dashboard/sell/items_sold">
						Item's Sold
				</a>
				<a class="btn btn-default btn-green <?php echo ($this->uri->segment(3) == "new") ? "active":"tab_inner"; ?>" href="<?php echo base_url(); ?>dashboard/sell/new">
						Sell New Items
				</a>						
				<a class="btn btn-default btn-red" id="checkout" href="<?php echo base_url(); ?>dashboard/checkout">
						Checkout
				</a>	
			</div>
			<div id="dashboard_content">
							<div id="loader"><div id="loader_inner"></div></div>
			</div>
			
		</div>
        
</div>