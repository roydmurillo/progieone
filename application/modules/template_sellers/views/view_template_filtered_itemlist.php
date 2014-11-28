<!-- content goes here -->
<img src='<?php echo base_url(); ?>assets/images/refine_loader.gif' style='display:none'>
<div id="homepage" class="row">

        <div class="fleft">
			<?php
            //load sidebar left
                $this->load->module('template_sideleft');
                $this->template_sideleft->view_sideleft_sellers(); 
            ?>
        </div>

		<div class="fleft" style="width:765px; margin-right:12px;">
			
			<?php
			$this->load->view('load_filtered_itemlist'); 
			?>

		</div>
        
</div>