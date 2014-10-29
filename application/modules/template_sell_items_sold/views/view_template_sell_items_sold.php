<!-- additional scripts -->
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/dashboard_scripts.js"></script>

<!-- content goes here -->
<input id="load_initial" type="hidden" value="<?php echo base_url() ?>dashboard/sell/items_sold/ajax">
<div id="homepage">
		
 		<?php
    	//load sidebar left
		$this->load->module('template_sideleft_dashboard');
		$this->template_sideleft_dashboard->view_template_sideleft_dashboard(); 
		?>
        <div class="col-sm-9 col-md-10 main">
		<div class="title_bar">
			SELL ITEMS
		</div>
            <div id="inner_dashboard_tab" class="btn-group">
				<a class="btn btn-default" href="<?php echo base_url(); ?>dashboard/sell/for_sale">
					<div class="tab_inner"> 
						Item Listings
					</div>
				</a>	
				<a class="btn btn-default" href="<?php echo base_url(); ?>dashboard/sell/items_sold">
					<div class="tab_inner_active"> 
						Item's Sold
					</div>
				</a>
				<a class="btn btn-default" href="<?php echo base_url(); ?>dashboard/sell/new">
					<div class="tab_inner"> 
						Sell New Items
					</div>
				</a>						
				<a class="btn btn-default" id="checkout" href="<?php echo base_url(); ?>dashboard/checkout">
					<div class="tab_inner checkout"> 
						Checkout
					</div>
				</a>	
			</div>
			<div id="dashboard_content">
							<div id="loader"><div id="loader_inner"></div></div>
			</div>
			
		</div>
        
</div>