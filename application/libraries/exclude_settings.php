<?php
if ( ! defined('BASEPATH') )
    exit( 'No direct script access allowed' );

class exclude_settings
{

    public function excluded_user($user)
    {   
  		
		$excluded = array(  "cyber1cafe",
                                    "cheartco",);    
		
		if(in_array(strtolower($user),$excluded)){
		    return true;
		}
		
		return false; 
  
    }
	
	public function add_date_duration(){
	
	}
	
}
?>