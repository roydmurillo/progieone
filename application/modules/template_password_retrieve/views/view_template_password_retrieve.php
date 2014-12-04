
<div id="create_account">
	
	<div class="inner_acct">
		
		<?php if($error != ""){	?>
			<div class="regular_register">
					<?php if(strpos($error,"Success") > -1 ) { ?>
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
		
		<div id="regular_register" >
			
			<h2 class="mtop0 mbottom">Retrieve Your Password</h2>
				
				<form method="POST">
				
					<div class="field">
						<div class="hdr">Type in your Username or Email * </div>
						<div class="hdr"><input class="inp" type="text" id="username_email" name="username_email" value="">
							<div class="remark" ></div>
						</div>
					</div>
					
					<div>
						<div class="hdr"><input class="css_btn_c0" type="submit" name="retrieve_password" value="Submit"></div>
					</div>
				
				</form>																	
		
		</div>
	
	</div>
	
</div>