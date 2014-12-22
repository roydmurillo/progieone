<script type="text/javascript" src="<?php echo base_url(); ?>scripts/json.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/register_scripts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/global.js"></script>

<?php $this->load->module("function_security"); 
    $type_initial = $this->function_security->encode("change_pass");
    $ajax = $this->function_security->encode("dashboard-ajax");
?>
<input id="load_initial" type="hidden" value="<?php echo base_url(); ?><?php echo $ajax; ?>">
<input id="type_initial" type="hidden" value="<?php echo $type_initial; ?>">
<input id="base_url" type="hidden" value="<?php echo base_url(); ?>">

<img src='<?php echo base_url(); ?>assets/images/warning.png' alt='preload' style="display:none">
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Change Password</h4>
      </div>
      <div class="modal-body">
          <p>Email : <input type="text" id="email"> </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="submit_change_pass">Ok</button>
      </div>
    </div>
  </div>
</div>
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
                            <div class="hdr clearfix">
                                    <div style="float:left; margin:0px"><a id="change_pass" href="Javascript:;">Change Password</a></div>
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