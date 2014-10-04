<?php 
 $currency = $this->native_session->get("currency");
?>
        <nav class="navbar-default">
            <div class="container">
                    <a class="navbar-brand" href="<?php echo base_url();?>">CYBERWATCH CAFE</a>      	      	
                    <ul class="nav navbar-nav pull-right">
                        <li><a class="link" href="<?php echo base_url() ?>forums/" class="menu_a">FORUM</a></li>
                        <li><a class="btn btn-default navbar-btn" href="<?php echo base_url();?>secure/register">Create Account</a></li>      	
                        <li><a class="btn btn-default navbar-btn" href="<?php echo base_url();?>secure/sign-in">Login</a></li>       	
                    </ul>
            </div>
        </nav>
        <!--
    ==================================================================
    	MENU LINKS
    ==================================================================
    -->
    <nav class="navbar-inverse">
        <div class="container">
            <ul class="nav navbar-nav">
            <li class="top_menu" ><a href="<?php echo base_url() ?>mens-watches" class="menu_a">MEN'S</a>
		<div class="drop_nav">
			<div class="inner_drop"  style="min-width:230px;">
				<?php 		   
				   //dependent files
				   $data["type"] = "watch_men";
				   $this->load->module('function_dropdown');
				   $this->function_dropdown->view_template_dropdown($data); 
				
				?>			    
			</div>	
		</div>
	    </li>        	
            <li class="top_menu" ><a href="<?php echo base_url() ?>womens-watches" class="menu_a">WOMEN'S</a>
		<div class="drop_nav">
			 <div class="inner_drop"  style="min-width:230px;">
				<?php 		   
				   //dependent files
				   $data["type"] = "watch_women";
				   $this->load->module('function_dropdown');
				   $this->function_dropdown->view_template_dropdown($data); 
				
				?>			    
			</div>
		</div>
	    </li> 		
            <li class="top_menu" ><a href="<?php echo base_url() ?>kids-watches" class="menu_a">KID'S</a>
		<div class="drop_nav">
					 <div class="inner_drop"  style="min-width:230px;">
				<?php 		   
				   //dependent files
				   $data["type"] = "watch_kids";
				   $this->load->module('function_dropdown');
				   $this->function_dropdown->view_template_dropdown($data); 
				
				?>			    
				</div>
		</div>
	    </li> 		
            <li class="top_menu" ><a href="<?php echo base_url() ?>watch-categories" class="menu_a">CATEGORIES</a>
		<div class="drop_nav" style="height:500px !important; overflow:hidden;" >
			<div class="inner_drop" style=" min-width:320px; height:440px !important">
				<?php 		   
				   //dependent files
				   $data["type"] = "watch_category";
				   $this->load->module('function_dropdown');
				   $this->function_dropdown->view_template_dropdown($data); 
				
				?>			    
			</div>
		</div>
	    </li> 		
            <li class="top_menu" ><a href="<?php echo base_url() ?>watch-brands" class="menu_a">BRANDS</a>
		<div class="drop_nav">
		    
		</div>
	    </li> 		
            <li class="top_menu" ><a href="<?php echo base_url() ?>friends/" class="menu_a">CAFE FRIENDS</a>
		<div class="drop_nav">
		    
		</div>
	    </li> 		
		<input type="hidden" value="<?php echo base_url() ?>" id="base_loc">
            </ul>
        </div>
    </nav>
