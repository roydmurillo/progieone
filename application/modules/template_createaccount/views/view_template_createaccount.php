<?php $this->native_session->force_regenerate_session(); ?>
<style>
.field{margin-left:125px;}
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
		<div class="text-center" >
                    <div class="alert alert-danger">
					<?php echo $remarks; ?>
                    </div>												
		</div>
		<?php } ?>
            <div class="col-md-6">
            <div class="panel panel-default">
			<div class="panel-heading">Create Account</div>
                        <div class="panel-body">
                            <form role="form" method="POST">
				<div class="form-group">
					<label for="username">Username</label>
					<input class="form-control" type="text" id="username" name="username"  value="<?php if(isset($_POST["username"])) echo $_POST["username"]; ?>">
				</div>
				<div class="form-group">
                                    <label for="password">Password</label>
					<input class="form-control"  id="password" type="password" name="password"  value="<?php if(isset($_POST["password"])) echo $_POST["password"]; ?>">
				</div>
				<div class="form-group">
					<label for="first">First Name</label>
                                <input class="form-control" type="text" id="first" name="firstname"  value="<?php if(isset($_POST["firstname"])) echo $_POST["firstname"]; ?>">
				</div>
				<div class="form-group">
					<label for="last">Last Name</label>
                                        <input class="form-control" type="text" id="last" name="lastname"  value="<?php if(isset($_POST["lastname"])) echo $_POST["lastname"]; ?>">
				</div>			
				<div class="form-group">
					<label for="email">Email Address</label>
					<input class="form-control" type="text" id="email" name="email" value="<?php if(isset($_POST["email"])) echo $_POST["email"]; ?>">
				</div>	
				<div class="form-group">
					<label for="user_country">Country</label>
                                            <select id="user_country" name="user_country" class="form-control">
						<option value=""> -- Select Country --</option>
							<?php 
                                                            $arr = $this->function_country->get_country_array();
								foreach($arr as $key => $val){
									echo "<option value='$key'>$val</option>";
							}?>
                                            </select>					
				</div>
				<div class="form-group">
					<label>Verify Captcha</label>
					<div class="hdr">
					<?php
							$this->load->module("function_captcha");
							$cap= $this->function_captcha->create_captcha_small();
							$image = $cap["captcha"];
							$key = $cap["key"];
							echo $image["image"];
					?>
						<div>
							<input type="hidden" name="captcha_key" value="<?php echo $key; ?>">
							<input class="inp"  type="text" name="captcha_answer" id="captcha_answer" placeholder="Enter Captcha Code">
						</div>					
					</div>
				</div>	

				<div class="form-group">
					<div class="hdr clearfix">
						<input type="checkbox" name="terms_agreement" style="float:left; margin:0px 5px 0px 0px; padding:0px" value="1" <?php if(isset($_POST["terms_agreement"])) echo 'checked="checked"'; ?>> 
						<div style="float:left; margin:0px">I Accept the <a href="<?php echo base_url() ?>terms_and_conditions">Terms and Conditions</a></div>
					</div>
				</div>	
                                <button class="btn btn-default" type="submit" name="submit">Create</button>
                               </form> 
                        </div>
		</div>
            </div>
            <div class="col-md-6">
                    <div class="panel panel-default">
                            <div class="panel-heading">Login</div>
                            <div class="panel-body">	
                                <p>Already a member?</p>
                                <p>login and enjoy!</p>
                                <a class="btn btn-default" href="<?php echo base_url();?>secure/sign-in">Sign in</a>
                            </div>
                    </div>
                </div> 
		<?php } else { ?>
		
		<div id="regular_register">
				
				<i class="fa fa-check-circle"></i>
				<div style="float:left; margin-left:12px; margin-top:12px">
					<?php echo $remarks; ?>
				</div>									
					
		</div>
		
		<?php } ?>
	
</div>
</div>
