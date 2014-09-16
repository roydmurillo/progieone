<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class function_currency extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
	}
    
	public function popular_array_currency(){
	
	}
	
	public function currency_dropdown(){
		
		$session_curr = $this->native_session->get("currency");
		
		$html = "";
		$arr = $this->array_currency();
		$popular = array("USD","EUR","JPY","GBP","CHF","CAD");
		
		foreach($popular as $p){
			
			if($session_curr == $p){
				$selected = "selected='selected'";
			} else {
				$selected = "";
			}
			
			$html .= "<option value='$p' $selected>".$this->get_name($p)."</option>";
		}
		
		$selected = "";
		
		$only_currency = $this->only_currencies();
		
		
		
		foreach($arr as $key => $val){
			
			if(!in_array($key, $popular)){
			
			  if (array_key_exists($key, $only_currency)) {	
				if($session_curr == $key){
					$selected = "selected='selected'";
				} else {
					$selected = "";
				}
				
				$html .= "<option value='$key' $selected>".$this->get_name($key)."</option>";
			  }
			}
			
		}
		
		return $html;
			
		
	}
	
	public function get_name($curr = NULL){
		
		$val = $this->array_currency($curr);
		
		if(!empty($val)){
			$val = explode(", ",$val[0]);
			return $curr ." - ". $val[0];
		}
		return false;
	}
	
	public function only_currencies(){
			$currencies = array(
				'ARS' => array(NULL,2,',','.',0),          //  Argentine Peso
				'AMD' => array(NULL,2,'.',',',0),          //  Armenian Dram
				'AWG' => array(NULL,2,'.',',',0),          //  Aruban Guilder
				'AUD' => array('AU$',2,'.',' ',0),          //  Australian Dollar
				'BSD' => array(NULL,2,'.',',',0),          //  Bahamian Dollar
				'BHD' => array(NULL,3,'.',',',0),          //  Bahraini Dinar
				'BDT' => array(NULL,2,'.',',',0),          //  Bangladesh, Taka
				'BZD' => array(NULL,2,'.',',',0),          //  Belize Dollar
				'BMD' => array(NULL,2,'.',',',0),          //  Bermudian Dollar
				'BOB' => array(NULL,2,'.',',',0),          //  Bolivia, Boliviano
				'BAM' => array(NULL,2,'.',',',0),          //  Bosnia and Herzegovina, Convertible Marks
				'BWP' => array(NULL,2,'.',',',0),          //  Botswana, Pula
				'BRL' => array('R$',2,',','.',0),          //  Brazilian Real
				'BND' => array(NULL,2,'.',',',0),          //  Brunei Dollar
				'CAD' => array('CA$',2,'.',',',0),          //  Canadian Dollar
				'KYD' => array(NULL,2,'.',',',0),          //  Cayman Islands Dollar
				'CLP' => array(NULL,0,'','.',0),           //  Chilean Peso
				'CNY' => array('CN&yen;',2,'.',',',0),          //  China Yuan Renminbi
				'COP' => array(NULL,2,',','.',0),          //  Colombian Peso
				'CRC' => array(NULL,2,',','.',0),          //  Costa Rican Colon
				'HRK' => array(NULL,2,',','.',0),          //  Croatian Kuna
				'CUC' => array(NULL,2,'.',',',0),          //  Cuban Convertible Peso
				'CUP' => array(NULL,2,'.',',',0),          //  Cuban Peso
				'CYP' => array(NULL,2,'.',',',0),          //  Cyprus Pound
				'CZK' => array('Kc',2,'.',',',1),          //  Czech Koruna
				'DKK' => array(NULL,2,',','.',0),          //  Danish Krone
				'DOP' => array(NULL,2,'.',',',0),          //  Dominican Peso
				'XCD' => array('EC$',2,'.',',',0),          //  East Caribbean Dollar
				'EGP' => array(NULL,2,'.',',',0),          //  Egyptian Pound
				'SVC' => array(NULL,2,'.',',',0),          //  El Salvador Colon
				'EUR' => array('&euro;',2,',','.',0),          //  Euro
				'GHC' => array(NULL,2,'.',',',0),          //  Ghana, Cedi
				'GIP' => array(NULL,2,'.',',',0),          //  Gibraltar Pound
				'GTQ' => array(NULL,2,'.',',',0),          //  Guatemala, Quetzal
				'HNL' => array(NULL,2,'.',',',0),          //  Honduras, Lempira
				'HKD' => array('HK$',2,'.',',',0),          //  Hong Kong Dollar
				'HUF' => array('HK$',0,'','.',0),           //  Hungary, Forint
				'ISK' => array('kr',0,'','.',1),           //  Iceland Krona
				'INR' => array('&#2352;',2,'.',',',0),          //  Indian Rupee ₹
				'IDR' => array(NULL,2,',','.',0),          //  Indonesia, Rupiah
				'IRR' => array(NULL,2,'.',',',0),          //  Iranian Rial
				'JMD' => array(NULL,2,'.',',',0),          //  Jamaican Dollar
				'JPY' => array('&yen;',0,'',',',0),           //  Japan, Yen
				'JOD' => array(NULL,3,'.',',',0),          //  Jordanian Dinar
				'KES' => array(NULL,2,'.',',',0),          //  Kenyan Shilling
				'KWD' => array(NULL,3,'.',',',0),          //  Kuwaiti Dinar
				'LVL' => array(NULL,2,'.',',',0),          //  Latvian Lats
				'LBP' => array(NULL,0,'',' ',0),           //  Lebanese Pound
				'LTL' => array('Lt',2,',',' ',1),          //  Lithuanian Litas
				'MKD' => array(NULL,2,'.',',',0),          //  Macedonia, Denar
				'MYR' => array(NULL,2,'.',',',0),          //  Malaysian Ringgit
				'MTL' => array(NULL,2,'.',',',0),          //  Maltese Lira
				'MUR' => array(NULL,0,'',',',0),           //  Mauritius Rupee
				'MXN' => array('MX$',2,'.',',',0),          //  Mexican Peso
				'MZM' => array(NULL,2,',','.',0),          //  Mozambique Metical
				'NPR' => array(NULL,2,'.',',',0),          //  Nepalese Rupee
				'ANG' => array(NULL,2,'.',',',0),          //  Netherlands Antillian Guilder
				'ILS' => array('&#8362;',2,'.',',',0),          //  New Israeli Shekel ₪
				'TRY' => array(NULL,2,'.',',',0),          //  New Turkish Lira
				'NZD' => array('NZ$',2,'.',',',0),          //  New Zealand Dollar
				'NOK' => array('kr',2,',','.',1),          //  Norwegian Krone
				'PKR' => array(NULL,2,'.',',',0),          //  Pakistan Rupee
				'PEN' => array(NULL,2,'.',',',0),          //  Peru, Nuevo Sol
				'UYU' => array(NULL,2,',','.',0),          //  Peso Uruguayo
				'PHP' => array(NULL,2,'.',',',0),          //  Philippine Peso
				'PLN' => array(NULL,2,'.',' ',0),          //  Poland, Zloty
				'GBP' => array('&pound;',2,'.',',',0),          //  Pound Sterling
				'OMR' => array(NULL,3,'.',',',0),          //  Rial Omani
				'RON' => array(NULL,2,',','.',0),          //  Romania, New Leu
				'ROL' => array(NULL,2,',','.',0),          //  Romania, Old Leu
				'RUB' => array(NULL,2,',','.',0),          //  Russian Ruble
				'SAR' => array(NULL,2,'.',',',0),          //  Saudi Riyal
				'SGD' => array(NULL,2,'.',',',0),          //  Singapore Dollar
				'SKK' => array(NULL,2,',',' ',0),          //  Slovak Koruna
				'SIT' => array(NULL,2,',','.',0),          //  Slovenia, Tolar
				'ZAR' => array('R',2,'.',' ',0),          //  South Africa, Rand
				'KRW' => array('&#8361;',0,'',',',0),           //  South Korea, Won ₩
				'SZL' => array(NULL,2,'.',', ',0),         //  Swaziland, Lilangeni
				'SEK' => array('kr',2,',','.',1),          //  Swedish Krona
				'CHF' => array('SFr ',2,'.','\'',0),         //  Swiss Franc 
				'TZS' => array(NULL,2,'.',',',0),          //  Tanzanian Shilling
				'THB' => array('&#3647;',2,'.',',',1),          //  Thailand, Baht ฿
				'TOP' => array(NULL,2,'.',',',0),          //  Tonga, Paanga
				'AED' => array(NULL,2,'.',',',0),          //  UAE Dirham
				'UAH' => array(NULL,2,',',' ',0),          //  Ukraine, Hryvnia
				'USD' => array('$',2,'.',',',0),          //  US Dollar
				'VUV' => array(NULL,0,'',',',0),           //  Vanuatu, Vatu
				'VEF' => array(NULL,2,',','.',0),          //  Venezuela Bolivares Fuertes
				'VEB' => array(NULL,2,',','.',0),          //  Venezuela, Bolivar
				'VND' => array('&#x20ab;',0,'','.',0),           //  Viet Nam, Dong ₫
				'ZWD' => array(NULL,2,'.',' ',0),          //  Zimbabwe Dollar
				);
			
			return $currencies;	
					
	}
	
	public function array_currency($curr = NULL){
		
		$currency = array();
		
		$currency["ALL"] = array("Albania, Leke", "4c, 65, 6b","sq_AL");
		$currency["AFN"] =  array("Afghanistan, Afghanis", "60b", "ar_AF");
		$currency["ARS"] =  array("Argentina, Pesos", "24", "es_AR");
		$currency["AWG"] =  array("Aruba, Guilders (also called Florins)", "192", "nl_AW");
		$currency["AUD"] =  array("Australia, Dollars", "24","en_AU");
		$currency["AZN"] =  array("Azerbaijan, New Manats", "43c, 430, 43d","az_AZ");
		$currency["BSD"] =  array("Bahamas, Dollars", "24", "en_US");
		$currency["BBD"] =  array("Barbados, Dollars", "24","en_US");
		$currency["BYR"] =  array("Belarus, Rubles", "70, 2e", "be_BY");
		$currency["BZD"] =  array("Belize, Dollars", "42, 5a, 24","en_US");
		$currency["BMD"] =  array("Bermuda, Dollars", "24","en_US");
		$currency["BOB"] =  array("Bolivia, Bolivianos", "24, 62", "es_BO");
		$currency["BAM"] =  array("Bosnia and Herzegovina, Convertible Marka", "4b, 4d", "es_BA");
		$currency["BWP"] =  array("Botswana, Pulas", "50", "en_BW", "bg_BW");
		$currency["BGN"] =  array("Bulgaria, Leva", "43b, 432", "bg_BG");
		$currency["BRL"] =  array("Brazil, Reais", "52, 24", "pt_BR");
		$currency["BND"] =  array("Brunei Darussalam, Dollars", "24");
		$currency["KHR"] =  array("Cambodia, Riels", "17db");
		$currency["CAD"] =  array("Canada, Dollars", "24","en_CA");
		$currency["KYD"] =  array("Cayman Islands, Dollars", "24","en_US");
		$currency["CLP"] =  array("Chile, Pesos", "24");
		$currency["CNY"] =  array("China, Yuan Renminbi", "a5");
		$currency["COP"] =  array("Colombia, Pesos", "24");
		$currency["CRC"] =  array("Costa Rica, Colón", "20a1");
		$currency["HRK"] =  array("Croatia, Kuna", "6b, 6e");
		$currency["CUP"] =  array("Cuba, Pesos", "20b1");
		$currency["CZK"] =  array("Czech Republic, Koruny", "4b, 10d");
		$currency["DKK"] =  array("Denmark, Kroner", "6b, 72");
		$currency["DOP"] =  array("Dominican Republic, Pesos", "52, 44, 24");
		$currency["XCD"] =  array("East Caribbean, Dollars", "24");
		$currency["EGP"] =  array("Egypt, Pounds", "a3");
		$currency["SVC"] =  array("El Salvador, Colones", "24");
		$currency["EEK"] =  array("Estonia, Krooni", "6b, 72");
		$currency["EUR"] =  array("Euro", "20ac");
		$currency["FKP"] =  array("Falkland Islands, Pounds", "a3");
		$currency["FJD"] =  array("Fiji, Dollars", "24");
		$currency["GHC"] =  array("Ghana, Cedis", "a2");
		$currency["GIP"] =  array("Gibraltar, Pounds", "a3");
		$currency["GTQ"] =  array("Guatemala, Quetzales", "51");
		$currency["GGP"] =  array("Guernsey, Pounds", "a3");
		$currency["GYD"] =  array("Guyana, Dollars", "24");
		$currency["HNL"] =  array("Honduras, Lempiras", "4c");
		$currency["HKD"] =  array("Hong Kong, Dollars", "24");
			$currency["HUF"] =  array("Hungary, Forint", "46, 74");
			$currency["ISK"] =  array("Iceland, Kronur", "6b, 72");
			$currency["INR"] =  array("India, Rupees", "20a8");
			$currency["IDR"] =  array("Indonesia, Rupiahs", "52, 70");
			$currency["IRR"] =  array("Iran, Rials", "fdfc");
			$currency["IMP"] =  array("Isle of Man, Pounds", "a3");
			$currency["ILS"] =  array("Israel, New Shekels", "20aa");
			$currency["JMD"] =  array("Jamaica, Dollars", "4a, 24");
			$currency["JPY"] =  array("Japan, Yen", "a5");
			$currency["JEP"] =  array("Jersey, Pounds", "a3");
			$currency["KZT"] =  array("Kazakhstan, Tenge", "43b, 432");
			$currency["KES"] =  array("Kenyan Shilling", "4b, 73, 68, 73");
			$currency["KGS"] =  array("Kyrgyzstan, Soms", "43b, 432");
			$currency["LAK"] =  array("Laos, Kips", "20ad");
			$currency["LVL"] =  array("Latvia, Lati", "4c, 73");
			$currency["LBP"] =  array("Lebanon, Pounds", "a3");
			$currency["LRD"] =  array("Liberia, Dollars", "24");
			$currency["LTL"] =  array("Lithuania, Litai", "4c, 74");
			$currency["MKD"] =  array("Macedonia, Denars", "434, 435, 43d");
			$currency["MYR"] =  array("Malaysia, Ringgits", "52, 4d");
			$currency["MUR"] =  array("Mauritius, Rupees", "20a8");
			$currency["MXN"] =  array("Mexico, Pesos", "24");
			$currency["MNT"] =  array("Mongolia, Tugriks", "20ae");
			$currency["MZN"] =  array("Mozambique, Meticais", "4d, 54");
			$currency["NAD"] =  array("Namibia, Dollars", "24");
			$currency["NPR"] =  array("Nepal, Rupees", "20a8");
			$currency["ANG"] =  array("Netherlands Antilles, Guilders (also called Florins)", "192");
			$currency["NZD"] =  array("New Zealand, Dollars", "24");
			$currency["NIO"] =  array("Nicaragua, Cordobas", "43, 24");
			$currency["NGN"] =  array("Nigeria, Nairas", "20a6");
			$currency["KPW"] =  array("North Korea, Won", "20a9");
			$currency["NOK"] =  array("Norway, Krone", "6b, 72");
			$currency["OMR"] =  array("Oman, Rials", "fdfc");
			$currency["PKR"] =  array("Pakistan, Rupees", "20a8");
			$currency["PAB"] =  array("Panama, Balboa", "42, 2f, 2e");
			$currency["PYG"] =  array("Paraguay, Guarani", "47, 73");
			$currency["PEN"] =  array("Peru, Nuevos Soles", "53, 2f, 2e");
			$currency["PHP"] =  array("Philippines, Pesos", "50, 68, 70");
			$currency["PLN"] =  array("Poland, Zlotych", "7a, 142");
			$currency["QAR"] =  array("Qatar, Rials", "fdfc");
			$currency["RON"] =  array("Romania, New Lei", "6c, 65, 69");
			$currency["RUB"] =  array("Russia, Rubles", "440, 443, 431");
			$currency["SHP"] =  array("Saint Helena, Pounds", "a3");
			$currency["SAR"] =  array("Saudi Arabia, Riyals", "fdfc");
			$currency["RSD"] =  array("Serbia, Dinars", "414, 438, 43d, 2e");
			$currency["SCR"] =  array("Seychelles, Rupees", "20a8");
			$currency["SGD"] =  array("Singapore, Dollars", "24");
			$currency["SBD"] =  array("Solomon Islands, Dollars", "24");
			$currency["SOS"] =  array("Somalia, Shillings", "53");
			$currency["ZAR"] =  array("South Africa, Rand", "52");
			$currency["KRW"] =  array("South Korea, Won", "20a9");
			$currency["LKR"] =  array("Sri Lanka, Rupees", "20a8");
			$currency["SEK"] =  array("Sweden, Kronor", "6b, 72");
			$currency["CHF"] =  array("Switzerland, Francs", "43, 48, 46");
			$currency["SRD"] =  array("Suriname, Dollars", "24");
			$currency["SYP"] =  array("Syria, Pounds", "a3");
			$currency["TWD"] =  array("Taiwan, New Dollars", "4e, 54, 24");
			$currency["THB"] =  array("Thailand, Baht", "e3f");
			$currency["TTD"] =  array("Trinidad and Tobago, Dollars", "54, 54, 24");
			$currency["TRY"] =  array("Turkey, Lira", "54, 4c");
			$currency["TRL"] =  array("Turkey, Liras", "20a4");
			$currency["TVD"] =  array("Tuvalu, Dollars", "24");
			$currency["UAH"] =  array("Ukraine, Hryvnia", "20b4");
			$currency["GBP"] =  array("United Kingdom, Pounds", "a3");
			$currency["USD"] =  array("United States of America, Dollars", "24","en_US");
			$currency["UYU"] =  array("Uruguay, Pesos", "24, 55");
			$currency["UZS"] =  array("Uzbekistan, Sums", "43b, 432");
			$currency["VEF"] =  array("Venezuela, Bolivares Fuertes", "42, 73");
			$currency["VND"] =  array("Vietnam, Dong", "20ab");
			$currency["YER"] =  array("Yemen, Rials", "fdfc");
			$currency["ZWD"] =  array("Zimbabwe, Zimbabwe Dollars", "5a, 24");
		
		
		if($curr == NULL){
		   
		   return $currency;
		   
		}
		
		return $currency[$curr];
			
	}

  public function getCurrencySymbol($currency = null) {
    $currencySymbol = '';
    // get the currency symbol
    $symbol = $this->array_currency($currency);

    // if many symbols are found, rebuild the full symbol
    $symbols = explode(', ', $symbol[1]);
    if(is_array($symbols)) {
      $symbol = "";
      foreach($symbols as $temp) {
        $symbol .= '&#x'.$temp.';';
        }
      }
    else {
      $symbol = '&#x'.$symbol.';';
      }
    return $symbol;
    }

        
		public function convertCurrency($amount, $from, $to){
			$url  = "https://www.google.com/finance/converter?a=$amount&from=$from&to=$to";
			$data = file_get_contents($url);
			preg_match("/<span class=bld>(.*)<\/span>/",$data, $converted);
			if($converted == "" || empty($converted) || $converted == false){
				return $this->convert_currency($amount,"USD",$to);	
			} else {
				$converted = preg_replace("/[^0-9.]/", "", $converted[1]);
				return round($converted, 3);
			}
		}

		function convert_currency($amount, $from, $to)
		{
			$url = 'http://finance.yahoo.com/d/quotes.csv?e=.csv&f=sl1d1t1&s='. $from . $to .'=X';
			$handle = @fopen($url, 'r');
			if ($handle)
			{
			$result = fgets($handle, 4096);
			fclose($handle);
			}
			$allData = explode(',',$result);
			$dollarValue = $allData[1];
			return round($dollarValue, 3);
		} 

		public function format($floatcurr)
		{
				$curr = $this->native_session->get("currency");	
				
				if($curr != "USD"){
					$floatcurr = $this->convertCurrency( $floatcurr,
                                                           "USD",
                                                           $curr);
				}
				
				$currencies = array(
				'ARS' => array(NULL,2,',','.',0),          //  Argentine Peso
				'AMD' => array(NULL,2,'.',',',0),          //  Armenian Dram
				'AWG' => array(NULL,2,'.',',',0),          //  Aruban Guilder
				'AUD' => array('AU$',2,'.',' ',0),          //  Australian Dollar
				'BSD' => array(NULL,2,'.',',',0),          //  Bahamian Dollar
				'BHD' => array(NULL,3,'.',',',0),          //  Bahraini Dinar
				'BDT' => array(NULL,2,'.',',',0),          //  Bangladesh, Taka
				'BZD' => array(NULL,2,'.',',',0),          //  Belize Dollar
				'BMD' => array(NULL,2,'.',',',0),          //  Bermudian Dollar
				'BOB' => array(NULL,2,'.',',',0),          //  Bolivia, Boliviano
				'BAM' => array(NULL,2,'.',',',0),          //  Bosnia and Herzegovina, Convertible Marks
				'BWP' => array(NULL,2,'.',',',0),          //  Botswana, Pula
				'BRL' => array('R$',2,',','.',0),          //  Brazilian Real
				'BND' => array(NULL,2,'.',',',0),          //  Brunei Dollar
				'CAD' => array('CA$',2,'.',',',0),          //  Canadian Dollar
				'KYD' => array(NULL,2,'.',',',0),          //  Cayman Islands Dollar
				'CLP' => array(NULL,0,'','.',0),           //  Chilean Peso
				'CNY' => array('CN&yen;',2,'.',',',0),          //  China Yuan Renminbi
				'COP' => array(NULL,2,',','.',0),          //  Colombian Peso
				'CRC' => array(NULL,2,',','.',0),          //  Costa Rican Colon
				'HRK' => array(NULL,2,',','.',0),          //  Croatian Kuna
				'CUC' => array(NULL,2,'.',',',0),          //  Cuban Convertible Peso
				'CUP' => array(NULL,2,'.',',',0),          //  Cuban Peso
				'CYP' => array(NULL,2,'.',',',0),          //  Cyprus Pound
				'CZK' => array('Kc',2,'.',',',1),          //  Czech Koruna
				'DKK' => array(NULL,2,',','.',0),          //  Danish Krone
				'DOP' => array(NULL,2,'.',',',0),          //  Dominican Peso
				'XCD' => array('EC$',2,'.',',',0),          //  East Caribbean Dollar
				'EGP' => array(NULL,2,'.',',',0),          //  Egyptian Pound
				'SVC' => array(NULL,2,'.',',',0),          //  El Salvador Colon
				'EUR' => array('&euro;',2,',','.',0),          //  Euro
				'GHC' => array(NULL,2,'.',',',0),          //  Ghana, Cedi
				'GIP' => array(NULL,2,'.',',',0),          //  Gibraltar Pound
				'GTQ' => array(NULL,2,'.',',',0),          //  Guatemala, Quetzal
				'HNL' => array(NULL,2,'.',',',0),          //  Honduras, Lempira
				'HKD' => array('HK$',2,'.',',',0),          //  Hong Kong Dollar
				'HUF' => array('HK$',0,'','.',0),           //  Hungary, Forint
				'ISK' => array('kr',0,'','.',1),           //  Iceland Krona
				'INR' => array('&#2352;',2,'.',',',0),          //  Indian Rupee ₹
				'IDR' => array(NULL,2,',','.',0),          //  Indonesia, Rupiah
				'IRR' => array(NULL,2,'.',',',0),          //  Iranian Rial
				'JMD' => array(NULL,2,'.',',',0),          //  Jamaican Dollar
				'JPY' => array('&yen;',0,'',',',0),           //  Japan, Yen
				'JOD' => array(NULL,3,'.',',',0),          //  Jordanian Dinar
				'KES' => array(NULL,2,'.',',',0),          //  Kenyan Shilling
				'KWD' => array(NULL,3,'.',',',0),          //  Kuwaiti Dinar
				'LVL' => array(NULL,2,'.',',',0),          //  Latvian Lats
				'LBP' => array(NULL,0,'',' ',0),           //  Lebanese Pound
				'LTL' => array('Lt',2,',',' ',1),          //  Lithuanian Litas
				'MKD' => array(NULL,2,'.',',',0),          //  Macedonia, Denar
				'MYR' => array(NULL,2,'.',',',0),          //  Malaysian Ringgit
				'MTL' => array(NULL,2,'.',',',0),          //  Maltese Lira
				'MUR' => array(NULL,0,'',',',0),           //  Mauritius Rupee
				'MXN' => array('MX$',2,'.',',',0),          //  Mexican Peso
				'MZM' => array(NULL,2,',','.',0),          //  Mozambique Metical
				'NPR' => array(NULL,2,'.',',',0),          //  Nepalese Rupee
				'ANG' => array(NULL,2,'.',',',0),          //  Netherlands Antillian Guilder
				'ILS' => array('&#8362;',2,'.',',',0),          //  New Israeli Shekel ₪
				'TRY' => array(NULL,2,'.',',',0),          //  New Turkish Lira
				'NZD' => array('NZ$',2,'.',',',0),          //  New Zealand Dollar
				'NOK' => array('kr',2,',','.',1),          //  Norwegian Krone
				'PKR' => array(NULL,2,'.',',',0),          //  Pakistan Rupee
				'PEN' => array(NULL,2,'.',',',0),          //  Peru, Nuevo Sol
				'UYU' => array(NULL,2,',','.',0),          //  Peso Uruguayo
				'PHP' => array(NULL,2,'.',',',0),          //  Philippine Peso
				'PLN' => array(NULL,2,'.',' ',0),          //  Poland, Zloty
				'GBP' => array('&pound;',2,'.',',',0),          //  Pound Sterling
				'OMR' => array(NULL,3,'.',',',0),          //  Rial Omani
				'RON' => array(NULL,2,',','.',0),          //  Romania, New Leu
				'ROL' => array(NULL,2,',','.',0),          //  Romania, Old Leu
				'RUB' => array(NULL,2,',','.',0),          //  Russian Ruble
				'SAR' => array(NULL,2,'.',',',0),          //  Saudi Riyal
				'SGD' => array(NULL,2,'.',',',0),          //  Singapore Dollar
				'SKK' => array(NULL,2,',',' ',0),          //  Slovak Koruna
				'SIT' => array(NULL,2,',','.',0),          //  Slovenia, Tolar
				'ZAR' => array('R',2,'.',' ',0),          //  South Africa, Rand
				'KRW' => array('&#8361;',0,'',',',0),           //  South Korea, Won ₩
				'SZL' => array(NULL,2,'.',', ',0),         //  Swaziland, Lilangeni
				'SEK' => array('kr',2,',','.',1),          //  Swedish Krona
				'CHF' => array('SFr ',2,'.','\'',0),         //  Swiss Franc 
				'TZS' => array(NULL,2,'.',',',0),          //  Tanzanian Shilling
				'THB' => array('&#3647;',2,'.',',',1),          //  Thailand, Baht ฿
				'TOP' => array(NULL,2,'.',',',0),          //  Tonga, Paanga
				'AED' => array(NULL,2,'.',',',0),          //  UAE Dirham
				'UAH' => array(NULL,2,',',' ',0),          //  Ukraine, Hryvnia
				'USD' => array('$',2,'.',',',0),          //  US Dollar
				'VUV' => array(NULL,0,'',',',0),           //  Vanuatu, Vatu
				'VEF' => array(NULL,2,',','.',0),          //  Venezuela Bolivares Fuertes
				'VEB' => array(NULL,2,',','.',0),          //  Venezuela, Bolivar
				'VND' => array('&#x20ab;',0,'','.',0),           //  Viet Nam, Dong ₫
				'ZWD' => array(NULL,2,'.',' ',0),          //  Zimbabwe Dollar
				);
			
				
				//rupees weird format
				if ($curr == "INR")
					$number = $this->formatinr($floatcurr);
				else 
					$number = number_format($floatcurr,$currencies[$curr][1],$currencies[$curr][2],$currencies[$curr][3]);
		
				//adding the symbol in the back
				if ($currencies[$curr][0] === NULL)
					$number.= ' '.$curr;
				elseif ($currencies[$curr][4]===1)
					$number.= $currencies[$curr][0];
				//normally in front
				else
					$number = $currencies[$curr][0].$number;
		
				return $number;
			}
		
			/**
			 * formats to indians rupees
			 * from http://www.joelpeterson.com/blog/2011/03/formatting-over-100-currencies-in-php/
			 * @param  float $input money
			 * @return string        formated currency
			 */
			public function formatinr($input){
				//CUSTOM FUNCTION TO GENERATE ##,##,###.##
				$dec = "";
				$pos = strpos($input, ".");
				if ($pos === false){
					//no decimals   
				} else {
					//decimals
					$dec = substr(round(substr($input,$pos),2),1);
					$input = substr($input,0,$pos);
				}
				$num = substr($input,-3); //get the last 3 digits
				$input = substr($input,0, -3); //omit the last 3 digits already stored in $num
				while(strlen($input) > 0) //loop the process - further get digits 2 by 2
				{
					$num = substr($input,-2).",".$num;
					$input = substr($input,0,-2);
				}
				return $num . $dec;
			}

      
		
        
}
