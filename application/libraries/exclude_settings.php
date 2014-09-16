<?php
if ( ! defined('BASEPATH') )
    exit( 'No direct script access allowed' );

class exclude_settings
{

    public function excluded_user($user)
    {   
  		
		$excluded = array("musicman",
						  "cyber1cafe",
						  "cheartco",
						  "alterbliss");    
		
		if(in_array(strtolower($user),$excluded)){
		    return true;
		}
		
		return false; 
  
    }
	
	public function add_date_duration(){
	
	}
	
}
?>