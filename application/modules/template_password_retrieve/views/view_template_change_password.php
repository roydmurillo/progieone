
<div id="create_account">
	
	<div class="inner_acct">
		
		<?php if($error != ""){	?>
			<div class="regular_register">
					<?php if(strpos($error,"successfully") > -1 ) { ?>
						<i class="fa fa-check-circle"></i>
						<div>
							<?php echo $error; ?>
						</div>
					<?php } elseif(strpos($error,"Error") > -1 ) { ?>
						<i class="fa fa-exclamation-triangle"></i>
						<div>
							<?php echo $error; ?>
						</div>
					<?php } ?>
			</div>
		<?php } ?>	
		
		<div id="regular_register">
			
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