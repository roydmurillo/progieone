  
        
        <header class="navbar-default">
            <div class="container">
                <a class="navbar-brand" href="<?php echo base_url();?>"><img src="<?php echo base_url();?>/assets/images/cw-logo.png" alt="cyberwatch cafe"/></a>      	      	
                    <ul class="nav navbar-nav pull-right">
                        <li><a class="btn btn-default btn-sm" href="<?php echo base_url();?>secure/register">Create Account</a></li>      	
                        <li><a class="btn btn-default btn-sm" href="<?php echo base_url();?>secure/sign-in">Login</a></li>       	
                    </ul>
            </div>
        </header>
    <?php 
        $this->load->view('view_template_menu');
        ?>
    