<?php
if ( ! defined('BASEPATH') )
    exit( 'No direct script access allowed' );

class paypal_settings
{

    public function environment()
    {   
        $environment = "live"; // live environment
        //$environment = "sandbox"; // the sandbox environment
        
        return $environment;

    }

    public function business_email()
    {
		//live
		$business_email = "admin@cyberwatchcafe.com";
		// test
        //$business_email = "sandbox_business1@yahoo.com"; //sandbox business email
        //$business_email = "anwars_paypal12-facilitator@yahoo.com"; //sandbox business email
        return $business_email;
    }

    public function token()
    {
        //sandbox token
        //$token = "4wrLY_iwbn6B21i9mBQrajhdaRRt6Y5AQ_rm0WiLvPhkrR4nR7FNWiBs9u0";
		$token = "ur_8GQ3qqbQ0ND8WqYdIrRwbgWAJis9xzFHVBD5H2hp-_ipU4VA3b875d7i";
        return $token;
        
    }
	
}
?>