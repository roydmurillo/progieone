<?php
	if(!$this->native_session->get("user_name")){
		//$this->load->module("function_users");
        //aps12
		$info = unserialize($this->native_session->get("user_info"));
		//$info = $this->function_users->get_user_fields(array("user_name"));
		$this->native_session->set("user_name", $info["user_name"]);
	}
	$currency = $this->native_session->get("currency");
?>

<nav class="navbar-default">
            <div class="container">
                    <a class="navbar-brand" href="<?php echo base_url();?>">CYBERWATCH CAFE</a>      	      	
                    <ul class="nav navbar-nav pull-right">
                        <li><a class="link" href="<?php echo base_url() ?>forums/">FORUM</a></li>
                        <li><a class="link" href="<?php echo base_url();?>dashboard/messages">My Messages</a></li>
                        <li><a class="link" href="<?php echo base_url();?>dashboard/friends">Friend Updates</a></li>
                        <li><a class="btn btn-default navbar-btn" href="<?php echo base_url();?>dashboard/account">My Account</a></li>      	
                        <li><a class="btn btn-default navbar-btn" href="<?php echo base_url();?>dashboard/logout">Logout</a></li>       	
                    </ul>
            </div>
</nav>
