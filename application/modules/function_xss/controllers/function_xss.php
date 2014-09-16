<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class function_xss extends MX_Controller {
    
	public function __construct()
	{
	       parent::__construct();
        }

	/*===================================================================
	* name : check_data()
	* desc : validates data inputs
	* parm : n/a
	* return : dashboard
	*===================================================================*/        
	public function xss_this($data = NULL)
	{   
            
            // Fix &entity\n;
            $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
            $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
            $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
            $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

            // Remove any attribute starting with "on" or xmlns
            $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

            // Remove javascript: and vbscript: protocols
            $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
            $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
            $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

            // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
            $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
            $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
            $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

            // Remove namespaced elements (we do not need them)
            $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

            do
            {
                    // Remove really unwanted tags
                    $old_data = $data;
                    $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
            }
            while ($old_data !== $data);

            // we are done...
            return $this->HtmlEncode($data);

	}   
        
        public function set_unicode(){
            if(function_exists('mb_convert_encoding'))
            {
                    if(mb_internal_encoding() == "UTF-8")
                    {
                            return true;
                    }
            }            
            return false;
        }
        

	public function unichr($u)
	{
                
		if($this->$haveUnicode == true)
		{
			return mb_convert_encoding(pack("N",$u), 'UTF-8', 'UCS-4BE');
		}
		
		return chr($u);
	}
	
	public function uniord($u, $unicode)
	{
		if($unicode == true)
		{
			$c = unpack("N", mb_convert_encoding($u, 'UCS-4BE', 'UTF-8'));
			return $c[1];
		}
		
		return ord($u);
	}
	
	public function unicharat($str, $cnt, $unicode)
	{
		if($unicode == true)
		{
			return mb_substr($str, $cnt, 1);
		}
		
		return substr($str, $cnt, 1);
	}
	
	public function HtmlEncode($str, $default = '')
	{
            
                $unicode = $this->set_unicode();
            
		if(empty($str))
		{
			$str = $default;
		}
		
	 	settype($str, 'string');
		
		$out = '';
		$len = mb_strlen($str);
		
		// Allow: a-z A-Z 0-9 SPACE , .
		// Allow (dec): 97-122 65-90 48-57 32 44 46
		
		for($cnt = 0; $cnt < $len; $cnt++)
		{
			$c = $this->uniord($this->unicharat($str, $cnt,$unicode),$unicode);
			if( ($c >= 97 && $c <= 122) ||
				($c >= 65 && $c <= 90 ) ||
				($c >= 48 && $c <= 57 ) ||
				$c == 32 || $c == 44 || $c == 46 )
			{
				$out .= $this->unicharat($str, $cnt,$unicode);
			}
			else
			{
				$out .= "&#$c;";
			}
		}
		
		return $out;
	}

	public function HtmlAttributeEncode($str, $default = '')
	{
		if(empty($str))
		{
			$str = $default;
		}
		
	 	settype($str, 'string');
		
		$out = '';
		$len = mb_strlen($str);
		
		// Allow: a-z A-Z 0-9
		// Allow (dec): 97-122 65-90 48-57
		
		for($cnt = 0; $cnt < $len; $cnt++)
		{
			$c = $this->uniord($this->unicharat($str, $cnt));
			if( ($c >= 97 && $c <= 122) ||
				($c >= 65 && $c <= 90 ) ||
				($c >= 48 && $c <= 57 ) )
			{
				$out .= $this->unicharat($str, $cnt);
			}
			else
			{
				$out .= "&#$c;";
			}
		}
		
		return $out;
	}

	public function XmlEncode($str, $default = '')
	{
		if(empty($str))
		{
			$str = $default;
		}
		
	 	settype($str, 'string');
		
		$out = '';
		$len = mb_strlen($str);
		
		// Allow: a-z A-Z 0-9 SPACE , .
		// Allow (dec): 97-122 65-90 48-57 32 44 46
		
		for($cnt = 0; $cnt < $len; $cnt++)
		{
			$c = $this->uniord($this->unicharat($str, $cnt));
			if( ($c >= 97 && $c <= 122) ||
				($c >= 65 && $c <= 90 ) ||
				($c >= 48 && $c <= 57 ) ||
				$c == 32 || $c == 44 || $c == 46 )
			{
				$out .= $this->unicharat($str, $cnt);
			}
			else
			{
				$out .= "&#$c;";
			}
		}
		
		return $out;
	}

	public function XmlAttributeEncode($str, $default = '')
	{
		if(empty($str))
		{
			$str = $default;
		}
		
	 	settype($str, 'string');
		
		$out = '';
		$len = mb_strlen($str);
		
		// Allow: a-z A-Z 0-9
		// Allow (dec): 97-122 65-90 48-57
		
		for($cnt = 0; $cnt < $len; $cnt++)
		{
			$c = $this->uniord($this->unicharat($str, $cnt));
			if( ($c >= 97 && $c <= 122) ||
				($c >= 65 && $c <= 90 ) ||
				($c >= 48 && $c <= 57 ) )
			{
				$out .= $this->unicharat($str, $cnt);
			}
			else
			{
				$out .= "&#$c;";
			}
		}
		
		return $out;
	}
	
	public function JsString($str, $default = '')
	{
		if(empty($str))
		{
			$str = $default;
			
			if(empty($str))
			{
				return "''";
			}
		}
		
	 	settype($str, 'string');
		
		$out = "'";
		$len = mb_strlen($str);
		
		// Allow: a-z A-Z 0-9 SPACE , .
		// Allow (dec): 97-122 65-90 48-57 32 44 46
		
		for($cnt = 0; $cnt < $len; $cnt++)
		{
			$c = $this->uniord($this->unicharat($str, $cnt));
			if( ($c >= 97 && $c <= 122) ||
				($c >= 65 && $c <= 90 ) ||
				($c >= 48 && $c <= 57 ) ||
				$c == 32 || $c == 44 || $c == 46 )
			{
				$out .= $this->unicharat($str, $cnt);
			}
			elseif( $c <= 127 )
			{
				$out .= sprintf('\x%02X', $c);
			}
			else
			{
				$out .= sprintf('\u%04X', $c);
			}
		}
		
		return $out . "'";
	}
	
	public function VbsString($str, $default = '')
	{
		if(empty($str))
		{
			$str = $default;
			
			if(empty($str))
			{
				return '""';
			}
		}
		
	 	settype($str, 'string');
		
		$out = '';
		$inStr = false;
		$len = mb_strlen($str);
		
		// Allow: a-z A-Z 0-9 SPACE , .
		// Allow (dec): 97-122 65-90 48-57 32 44 46
		
		for($cnt = 0; $cnt < $len; $cnt++)
		{
			$c = $this->uniord($this->unicharat($str, $cnt));
			if( ($c >= 97 && $c <= 122) ||
				($c >= 65 && $c <= 90 ) ||
				($c >= 48 && $c <= 57 ) ||
				$c == 32 || $c == 44 || $c == 46 )
			{
				if(! $inStr)
				{
					$inStr = true;
					$out .= '&"';
				}
				
				$out .= $this->unicharat($str, $cnt);
			}
			else
			{
				if(! $inStr)
				{
					$out .= sprintf('&chrw(%d)', $c);
				}
				else
				{
					$out .= sprintf('"&chrw(%d)', $c);
					$inStr = false;
				}
			}
		}
		
		return ltrim($out, '&') . ($inStr ? '"' : '');
	}        
       
        
}
