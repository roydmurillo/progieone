  
        
        <header class="navbar-default">
            <div class="container">
                <a class="navbar-brand" href="<?php echo base_url();?>"><img src="<?php echo base_url();?>/assets/images/cw-logo.png" alt="cyberwatch cafe"/></a>      	      	
                    <ul class="nav navbar-nav pull-right">
                        <li><a class="btn btn-default btn-sm" href="<?php echo base_url();?>secure/register">Create Account</a></li>      	
                        <li><a class="btn btn-default btn-sm" href="<?php echo base_url();?>secure/sign-in">Login</a></li>       	
                    </ul>
            </div>
        </header>
    
    <!--
    ==================================================================
    	MENU LINKS
    ==================================================================
    -->
    <nav class="navbar-inverse">
        <div class="container">
            <ul class="nav navbar-nav">
            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">MEN'S</a>
				<?php 		   
				   //dependent files
				   $data["type"] = "watch_men";
				   $this->load->module('function_dropdown');
				   $this->function_dropdown->view_template_dropdown($data); 
				
				?>			    
	    </li>        	
            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">WOMEN'S</a>
				<?php 		   
				   //dependent files
				   $data["type"] = "watch_women";
				   $this->load->module('function_dropdown');
				   $this->function_dropdown->view_template_dropdown($data); 
				
				?>			    
	    </li> 		
            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">KID'S</a>
				<?php 		   
				   //dependent files
				   $data["type"] = "watch_kids";
				   $this->load->module('function_dropdown');
				   $this->function_dropdown->view_template_dropdown($data); 
				
				?>			    
	    </li> 		
            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">CATEGORIES</a>		
				<?php 		   
				   //dependent files
				   $data["type"] = "watch_category";
				   $this->load->module('function_dropdown');
				   $this->function_dropdown->view_template_dropdown($data); 	
				?>	                     
	    </li> 		
            <li class="top_menu"><a href="<?php echo base_url() ?>watch-brands" class="menu_a">BRANDS</a>
		<div class="drop_nav">
		    
		</div>
	    </li>
        <li class="top_menu"><a href="<?php echo base_url();?>" class="menu_a">SEARCH</a>
	    </li>
            	
		<input type="hidden" value="<?php echo base_url() ?>" id="base_loc">
            </ul>
        </div>
    </nav>  