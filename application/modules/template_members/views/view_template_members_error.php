<script type="text/javascript" src="<?php echo base_url(); ?>scripts/json.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/item.js"></script>

<!-- content goes here -->
<?php $this->load->module("function_security"); 
	  $type_initial = $this->function_security->encode("validate_email");
	  $type_send = $this->function_security->encode("send_inquiry");
	  $ajax = $this->function_security->encode("dashboard-ajax"); ?>
<input id="load_initial" type="hidden" value="<?php echo base_url(); ?><?php echo $ajax; ?>">
<input id="type_initial" type="hidden" value="<?php echo $type_initial; ?>">
<input id="send_inquiry" type="hidden" value="<?php echo $type_send; ?>">
<input id="base_url" type="hidden" value="<?php echo base_url(); ?>">

<!-- content goes here -->
<div id="homepage" class="row">

		<div class="regular_register" style="min-height:40px !important;">
				<img src='<?php echo base_url(); ?>assets/images/warning.png' alt='preload' style="float:left">
				<div style="float:left; margin-left:12px; margin-top:12px; color:red">
					Member <?php echo $this->uri->segment(2); ?> does not exist!
				</div>									
					
		</div>
        
</div>