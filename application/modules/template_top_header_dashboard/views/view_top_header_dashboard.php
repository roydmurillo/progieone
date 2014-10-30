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

<header class="navbar-default">
            <div class="container">
                    <a class="navbar-brand" href="<?php echo base_url();?>/all-watches"><img src="<?php echo base_url();?>/assets/images/cw-logo.png" alt="cyberwatch cafe"/></a>      	      	
                    <ul class="nav navbar-nav pull-right">
<!--                        <li><a class="btn btn-sm btn-default" href="<?php echo base_url() ?>forums/">Forum</a></li>   -->
                        <li class="dropdown">
                            <a class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" href="#">My Account <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo base_url();?>dashboard/account">Admin</a></li>
                                <li><a href="<?php echo base_url();?>dashboard/messages">Inbox</a></li>
                                <li><a href="<?php echo base_url();?>dashboard/friends">Friends</a></li> 
                                <li><a href="<?php echo base_url() ?>dashboard/profile">Profile</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo base_url();?>dashboard/logout">Logout</a></li>       
                            </ul>
                        </li>      	
                        	
                    </ul>
            </div>
</header>


<?php 

$this->load->view('view_template_menu');
?>