<img src='<?php echo base_url(); ?>assets/images/warning.png' alt='preload' style="display:none">
<img src='<?php echo base_url(); ?>assets/images/check.png' alt='preload' style="display:none">
<div id="create_account">
	
	<div class="inner_acct">
		
		<?php if($error != ""){	?>
			<div class="regular_register" style="min-height:40px !important;">
					<?php if(strpos($error,"successfully") > -1 ) { ?>
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
			
			<h2 class="mtop0 mbottom">Change Your Password</h2>
				
				<form method="POST">
				
					<div class="field">
					    <input type="hidden" name="uid" value="<?php echo $user_id; ?>">
						<div class="hdr">Type in your New Password * </div>
						<div class="hdr">
							<input class="inp" type="password" name="new_password" value="">
						</div>
					</div>
					
					<div class="field">
						<div class="hdr">Retype New Password * </div>
						<div class="hdr">
							<input class="inp" type="password" name="retype_new_password" value="">
						</div>
					</div>
					
					<div style="margin:50px auto 20px auto !important; width:200px;">
						<div class="hdr"><input class="css_btn_c0" style="margin-bottom: 20px; margin-top: 20px; width: 225px; margin-left: -12px;" type="submit" name="change_password" value="Submit"></div>
					</div>
				
				</form>																	
		
		</div>
	
	</div>
	
</div>