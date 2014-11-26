<?php
if ( ! defined('BASEPATH') )
    exit( 'No direct script access allowed' );

class native_session
{
    public function __construct()
    {
       // ini_set('session.cookie_lifetime',12*60*60);
	    //session_name("CWCAFE");
        //session_start();
        //$this->regenerateId();
		//SessionManage::sessionStart('InstallationName');
		//SessionManage::sessionStart('Blog_myBlog', 0, '/myBlog/', 'www.site.com');
	    $this->sessionStart('CYBERWATCHCAFE', 0, '/', '', null);
            $this->new_regenerate_session();
    }

	public function sessionStart($name, $limit = 0, $path = '/', $domain = null, $secure = null)
	{
		// Set the cookie name
		session_name($name);
	
		// Set SSL level
		$https = isset($secure) ? $secure : isset($_SERVER['HTTPS']);
	
		// Set session cookie options
		session_set_cookie_params($limit, $path, $domain, $https, true);
		session_start();
	
		// Make sure the session hasn't expired, and destroy it if it has
		if($this->validateSession())
		{
			// Check to see if the session is new or a hijacking attempt
			if(!$this->preventHijacking())
			{
				// Reset session data and regenerate id
				$_SESSION = array();
				$_SESSION['IPaddress'] = $_SERVER['REMOTE_ADDR'];
				$_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
				$this->regenerateSession();
	
			// Give a 5% chance of the session id changing on any request
			}elseif(rand(1, 100) <= 5){
				$this->regenerateSession();
			}
		}else{
			$_SESSION = array();
			session_destroy();
			session_start();
		}
	}

	public function validateSession()
	{
		if( isset($_SESSION['OBSOLETE']) && !isset($_SESSION['EXPIRES']) )
			return false;
	
		if(isset($_SESSION['EXPIRES']) && $_SESSION['EXPIRES'] < time())
			return false;
	
		return true;
	}

	public function preventHijacking()
	{
		// old setup			
		//		if(!isset($_SESSION['IPaddress']) || !isset($_SESSION['userAgent']))
		//			return false;
		//	
		//		if ($_SESSION['IPaddress'] != $_SERVER['REMOTE_ADDR'])
		//			return false;
		//	
		//		if( $_SESSION['userAgent'] != $_SERVER['HTTP_USER_AGENT'])
		//			return false;
		//	
		//		return true;
		
		// add aol users
		$aolProxies = array('195.93.', '205.188', '198.81.', '207.200', '202.67.', '64.12.9');
		if(!isset($_SESSION['IPaddress']) || !isset($_SESSION['userAgent']))
			return false;


		if( $_SESSION['userAgent'] != $_SERVER['HTTP_USER_AGENT']
			&& !( strpos($_SESSION['userAgent'], ÔTridentÕ) !== false
				&& strpos($_SERVER['HTTP_USER_AGENT'], ÔTridentÕ) !== false))
		{
			return false;
		}

		$sessionIpSegment = substr($_SESSION['IPaddress'], 0, 7);

		$remoteIpHeader = isset($_SERVER['HTTP_X_FORWARDED_FOR'])
			? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];

		$remoteIpSegment = substr($remoteIpHeader, 0, 7);

		if($_SESSION['IPaddress'] != $remoteIpHeader
			&& !(in_array($sessionIpSegment, $aolProxies) && in_array($remoteIpSegment, $aolProxies)))
		{
			return false;
		}

		if( $_SESSION['userAgent'] != $_SERVER['HTTP_USER_AGENT'])
			return false;

		return true;

	}
	
	public function force_regenerate_session(){
	
		// Create new session without destroying the old one
		@session_regenerate_id(true);
	
	}

    public function set( $key, $value )
    {
        $_SESSION[$key] = $value;
    }

    public function get( $key )
    {
        return isset( $_SESSION[$key] ) ? $_SESSION[$key] : false;
    }

    public function regenerateSession()
    {
		// If this session is obsolete it means there already is a new id
		if(isset($_SESSION['OBSOLETE']) || isset($_SESSION['OBSOLETE']) == true)
			return;
	
		// Set current session to expire in 10 seconds
		$_SESSION['OBSOLETE'] = true;
		$_SESSION['EXPIRES'] = time() + 10;
	
		// Create new session without destroying the old one
		session_regenerate_id(false);
	
		// Grab current session ID and close both sessions to allow other scripts to use them
		$newSession = session_id();
		session_write_close();
	
		// Set session ID to the new one, and start it back up again
		session_id($newSession);
		session_start();
	
		// Now we unset the obsolete and expiration values for the session we want to keep
		unset($_SESSION['OBSOLETE']);
		unset($_SESSION['EXPIRES']);
    }

    public function delete( $key )
    {
        unset( $_SESSION[$key] );
    }
    
    public function destroy()
    {
        session_destroy();
    }
    
    public function new_regenerate_session(){
        
        if(isset($_SESSION['verified'])){
            $new_session = $_SESSION;
            unset($_SESSION);

            foreach ($new_session as $nkey=>$session){
                $_SESSION[$nkey] = $session;
            }
        }
        
        return true;
    }
            
}
?>