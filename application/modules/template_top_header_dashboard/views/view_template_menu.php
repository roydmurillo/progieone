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
            	
		<input type="hidden" value="<?php echo base_url() ?>" id="base_loc">
            </ul>
        </div>
    </nav>