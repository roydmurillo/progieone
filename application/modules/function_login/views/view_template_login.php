<img src='<?php echo base_url(); ?>assets/images/warning.png' alt='preload' style="display:none">
<div id="create_account">
	
	<div class="inner_acct">
		
		<?php if($error != ""){	?>
			<p class="alert alert-danger"><?php echo $error; ?></p>
		<?php } ?>	
		
		<?php if($msg = $this->native_session->get("login_message")){	?>
			<div class="regular_register green-alert">
					<i class="fa fa-check-circle"></i> <?php echo $msg; ?>								
			</div>
		<?php $this->native_session->delete("login_message"); } ?>	
                <div class="col-md-6">
                    <div class="panel panel-default">
                            <div class="panel-heading">Members login</div>
                            <div class="panel-body">	
                            <form role="form" method="POST">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input class="form-control" type="text" id="username" name="username" placeholder="username" value="<?php if(isset($_POST["username"])) echo $_POST["username"]; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input class="form-control"  id="password" type="password" name="password" placeholder="password" value="<?php if(isset($_POST["password"])) echo $_POST["password"]; ?>">
                                    </div>
                                    <button class="btn btn-default" type="submit" name="login_submit">login</button>
                            </form>	
                            </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                            <div class="panel-heading">Create Account</div>
                            <div class="panel-body">	
                                <p>Not yet a member?</p>
                                <a class="btn btn-default" href="<?php echo base_url();?>secure/register">Create Account</a>
                            </div>
                    </div>
                </div>        
	
	</div>
	
</div>