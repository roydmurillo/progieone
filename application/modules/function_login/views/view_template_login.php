<img src='<?php echo base_url(); ?>assets/images/warning.png' alt='preload' style="display:none">
<div id="create_account">
	
	<div class="inner_acct">
		
		<?php if($error != ""){	?>
			<div class="regular_register" style="min-height:40px !important;margin: 0px 155px;">
					<img src='<?php echo base_url(); ?>assets/images/warning.png' alt='preload' style="float:left">
					<div style="float:left; margin-left:12px; margin-top:12px; color:red">
						<?php echo $error; ?>
					</div>									
						
			</div>
		<?php } ?>	
		
		<?php if($msg = $this->native_session->get("login_message")){	?>
			<div class="regular_register" style="min-height:40px !important; margin: 0px 155px;">
					<img src='<?php echo base_url(); ?>assets/images/warning.png' alt='preload' style="float:left">
					<div style="float:left; margin-left:12px; margin-top:12px; color:red">
						<?php echo $msg; ?>
					</div>									
			</div>
		<?php $this->native_session->delete("login_message"); } ?>	
		
		<div id="regular_register" style="min-height:40px !important; margin: 20px 155px; background:rgba(0,0,0,0.05); ">
			
			<h2 class="mtop0 mbottom">Member Signin</h2>
				
				<form method="POST">
				
				<div class="field">
					<div class="hdr">User Name * </div>
					<div class="hdr"><input class="inp" type="text" id="username" name="username" value="<?php if(isset($_POST["username"])) echo $_POST["username"]; ?>">
						<div class="remark" style="float: left;
						min-width: 160px;
						height: 32px;
						padding-left: 12px;
						line-height: 32px;
						vertical-align: middle;"></div>
					</div>
				</div>

				<div class="field">
					<div class="hdr" style="margin-top:20px">Password * </div>
					<div class="hdr"><input class="inp" type="password" name="password" value="<?php if(isset($_POST["password"])) echo $_POST["password"]; ?>"></div>
				</div>
				
				<div style="margin:50px auto 20px auto !important; width:200px;">
					<div class="hdr"><input class="css_btn_c0" style="margin-bottom: 20px; margin-top: 20px; width: 225px; margin-left: -12px;" type="submit" name="login_submit" value="Sign-In"></div>
				</div>
				
				</form>																	
		
		</div>
	
	</div>
	
</div>