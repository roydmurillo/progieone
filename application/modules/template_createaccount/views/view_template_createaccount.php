<?php $this->native_session->force_regenerate_session(); ?>
<style>
.field{margin-left:125px;}
.hdr input {width:335px;}
#user_country {width:360px !important;}
input[type="checkbox"] {
    width:auto !important;
}

</style>
<!-- additional scripts -->
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/register_scripts.js"></script>

<!-- content goes here -->
<?php $this->load->module("function_security"); 
	  $type_initial = $this->function_security->encode("check_user_name");
	  $ajax = $this->function_security->encode("dashboard-ajax"); ?>
<input id="load_initial" type="hidden" value="<?php echo base_url(); ?><?php echo $ajax; ?>">
<input id="type_initial" type="hidden" value="<?php echo $type_initial; ?>">
<input id="base_url" type="hidden" value="<?php echo base_url(); ?>">
<!-- preload -->
<img src='<?php echo base_url(); ?>assets/images/ajax-loader.gif' alt='preload' style="display:none;">
<div id="create_account">
	
	<div class="inner_acct">
		
		<?php 
			if (strpos($remarks, "You are now Successfully Registered") === false) {
		?>
		
		<?php if($remarks != ""){ ?>
		<div id="regular_register" style="min-height:40px !important; margin:0px 155px;">
				
				<img src='<?php echo base_url(); ?>assets/images/warning.png' alt='preload' style="float:left">
				<div style="float: left; margin-left: 60px; color: red !important; width: 410px; text-align: center;">
					<?php echo $remarks; ?>
				</div>									
					
		</div>
		<?php } ?>
		
		<div id="regular_register" style="margin:10px 155px; background:rgba(0,0,0,0.05);">
			
			<h2 class="mtop0 mbottom">Create Your Account</h2>
				
				<form method="POST">
				
				<div class="field">
					<div class="hdr">User Name * </div>
					<div class="hdr"><input class="inp" type="text" id="username" name="username" value="<?php if(isset($_POST["username"])) echo $_POST["username"]; ?>">
						<div class="remark" style="float: left;
						min-width: 160px;
						height: 32px;
						padding-left: 12px;
						line-height: 32px;
						vertical-align: middle;
						display:none"></div>
					</div>
				</div>

				<div class="field">
					<div class="hdr" style="margin-top:20px">Password * </div>
					<div class="hdr"><input class="inp" type="password" name="password" value="<?php if(isset($_POST["password"])) echo $_POST["password"]; ?>"></div>
				</div>
				
				<div class="field">
					<div class="hdr" style="margin-top:20px">First Name * </div>
					<div class="hdr"><input class="inp" type="text" name="firstname" value="<?php if(isset($_POST["firstname"])) echo $_POST["firstname"]; ?>"></div>
				</div>

				<div class="field">
					<div class="hdr" style="margin-top:20px">Last Name *</div>
					<div class="hdr"><input class="inp" type="text" name="lastname" value="<?php if(isset($_POST["lastname"])) echo $_POST["lastname"]; ?>"></div>
				</div>			

				<div class="field">
					<div class="hdr" style="margin-top:20px">Email Address *</div>
					<div class="hdr"><input class="inp" type="text" name="email" value="<?php if(isset($_POST["email"])) echo $_POST["email"]; ?>"></div>
				</div>	
				<div class="field">
					<div class="hdr" style="margin-top:20px">Country *</div>
					<div class="hdr">
						<select id="user_country" name="user_country" style="width: 225px; padding: 7px;">
							<option value=""> -- Select Country --</option>
							<?php 
								
								$arr = $this->function_country->get_country_array();
								foreach($arr as $key => $val){
									
									echo "<option value='$key'>$val</option>";
									
								}
							
							?>
						</select>					
					</div>
				</div>

				<div class="field" style="margin-left:120">
					<div class="hdr" style="margin-top:20px">Verify Captcha *</div>
					<div class="hdr">
					<?php
							$this->load->module("function_captcha");
							$cap= $this->function_captcha->create_captcha_small();
							$image = $cap["captcha"];
							$key = $cap["key"];
							echo $image["image"];
					?>
						<div >
							<input type="hidden" name="captcha_key" value="<?php echo $key; ?>">
							<input class="inp"  type="text" name="captcha_answer" id="captcha_answer" placeholder="Enter Captcha Code" style="width:335px">
						</div>					
					</div>
				</div>	

				<div class="field">
					<div class="hdr" style="font-size:10px; margin:20px 0px">
						<input type="checkbox" name="terms_agreement" style="float:left; margin:0px 5px 0px 0px; padding:0px" value="1" <?php if(isset($_POST["terms_agreement"])) echo 'checked="checked"'; ?>> 
						<div style="float:left; margin:0px">I Accept the <a href="<?php echo base_url() ?>terms_and_conditions">Terms and Conditions</a></div>
					</div>
				</div>	

				<div style="margin:50px auto 20px auto !important; width:200px;">
					<div class="hdr"><input class="css_btn_c0" style="margin-bottom:20px; width: 220px; margin-bottom: 20px; margin-left: -12px;" type="submit" name="submit" value="Submit"></div>
				</div>
				
				</form>																	
		
		</div>
		
		<?php } else { ?>
		
		<div id="regular_register" style="min-height:40px !important; width:520px !important">
				
				<img src='<?php echo base_url(); ?>assets/images/check.png' alt='preload' style="float:left">
				<div style="float:left; margin-left:12px; margin-top:12px">
					<?php echo $remarks; ?>
				</div>									
					
		</div>
		
		<?php } ?>
	
	</div>
	
</div>