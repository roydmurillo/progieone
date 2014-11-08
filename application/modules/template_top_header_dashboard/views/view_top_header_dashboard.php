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
                <a class="navbar-brand mobile-center" href="<?php echo base_url();?>/all-watches"><img class="img-responsive" src="<?php echo base_url();?>/assets/images/cw-logo.png" alt="cyberwatch cafe"/></a>      	      	
                    <!--== desktop menu ==-->
                    <ul class="nav navbar-nav pull-right hidden-xs">
                        <li class="dropdown">
                            <a class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" href="#">My Account <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo base_url();?>dashboard/account">Admin</a></li>
                                <li><a href="<?php echo base_url();?>dashboard/messages">Inbox</a></li>
                                <li><a href="<?php echo base_url();?>dashboard/friends">Friends</a></li> 
                                <li><a href="<?php echo base_url() ?>dashboard/profile">Profile</a></li>
                                <li><a href="<?php echo base_url() ?>forums/">Forum</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo base_url();?>dashboard/logout">Logout</a></li>       
                            </ul>
                        </li>      	     	
                    </ul>
                    <!--== menu mobile ==-->
                    <div class="myaccount-btn visible-xs">my account <i class="fa fa-chevron-circle-up"></i></div>
                    <div class="myaccount-menu">
                        <ul>
                                <li><a href="<?php echo base_url();?>dashboard/account">Admin</a></li>
                                <li><a href="<?php echo base_url();?>dashboard/messages">Inbox</a></li>
                                <li><a href="<?php echo base_url();?>dashboard/friends">Friends</a></li> 
                                <li><a href="<?php echo base_url() ?>dashboard/profile">Profile</a></li>
                                <li><a href="<?php echo base_url() ?>forums/">Forum</a></li>
                                <li class="logout"><a href="<?php echo base_url();?>dashboard/logout">Logout</a></li>       
                        </ul>
                    </div>
            </div>
</header>


<?php 
$this->load->view('view_template_menu');
?>