<!--
    ==================================================================
    	MENU LINKS
    ==================================================================
    -->
    <nav class="navbar-inverse">
        <div class="visible-xs visible-sm menu-btn">Menu</div>
        <div class="container black-nav">
            <ul class="nav navbar-nav">
            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">MEN'S <span class="caret"></span></a>
				<?php 		   
				   //dependent files
				   $data["type"] = "watch_men";
				   $this->load->module('function_dropdown');
				   $this->function_dropdown->view_template_dropdown($data); 
				
				?>			    
	    </li>        	
            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">WOMEN'S <span class="caret"></span></a>
				<?php 		   
				   //dependent files
				   $data["type"] = "watch_women";
				   $this->load->module('function_dropdown');
				   $this->function_dropdown->view_template_dropdown($data); 
				
				?>			    
	    </li> 		
            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">KID'S <span class="caret"></span></a>
				<?php 		   
				   //dependent files
				   $data["type"] = "watch_kids";
				   $this->load->module('function_dropdown');
				   $this->function_dropdown->view_template_dropdown($data); 
				
				?>			    
	    </li> 		
            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">CATEGORIES <span class="caret"></span></a>		
				<?php 		   
				   //dependent files
				   $data["type"] = "watch_category";
				   $this->load->module('function_dropdown');
				   $this->function_dropdown->view_template_dropdown($data); 	
				?>	                     
	    </li> 		
            <li class="top_menu"><a href="<?php echo base_url() ?>watch-brands">BRANDS</a>
		<div class="drop_nav">
		    
		</div>
	    </li>
            <li class="top_menu"><a href="<?php echo base_url()?>">SEARCH</a>
	    </li>
            	
		<input type="hidden" value="<?php echo base_url() ?>" id="base_loc">
            </ul>
        </div>
    </nav>