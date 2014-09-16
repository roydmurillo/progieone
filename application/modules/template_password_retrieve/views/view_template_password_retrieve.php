<img src='<?php echo base_url(); ?>assets/images/warning.png' alt='preload' style="display:none">
<img src='<?php echo base_url(); ?>assets/images/check.png' alt='preload' style="display:none">
<div id="create_account">
	
	<div class="inner_acct">
		
		<?php if($error != ""){	?>
			<div class="regular_register" style="min-height:40px !important;">
					<?php if(strpos($error,"Success") > -1 ) { ?>
						<img src='<?php echo base_url(); ?>assets/images/check.png' alt='preload' style="float:left">
						<div style="float:left; margin-left:12px; margin-top:12px; color:red">
							<?php echo $error; ?>
						</div>
					<?php } elseif(strpos($error,"Error") > -1 ) { ?>
						<img src='<?php echo base_url(); ?>assets/images/warning.png' alt='preload' style="float:left">
						<div style="float:left; margin-left:12px; margin-top:12px; color:red">
							<?php echo $error; ?>
						</div>
					<?php } ?>
			</div>
		<?php } ?>	
		
		<div id="regular_register" style="min-height:40px !important">
			
			<h2 class="mtop0 mbottom">Retrieve Your Password</h2>
				
				<form method="POST">
				
					<div class="field">
						<div class="hdr">Type in your Username or Email * </div>
						<div class="hdr"><input class="inp" type="text" id="username_email" name="username_email" value="">
							<div class="remark" style="float: left;
							min-width: 160px;
							height: 32px;
							padding-left: 12px;
							line-height: 32px;
							vertical-align: middle;"></div>
						</div>
					</div>
					
					<div style="margin:50px auto 20px auto !important; width:200px;">
						<div class="hdr"><input class="css_btn_c0" style="margin-bottom: 20px; margin-top: 20px; width: 225px; margin-left: -12px;" type="submit" name="retrieve_password" value="Submit"></div>
					</div>
				
				</form>																	
		
		</div>
	
	</div>
	
</div>