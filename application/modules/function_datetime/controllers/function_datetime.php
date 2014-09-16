<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class function_datetime extends MX_Controller {

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
	public function time_diff($date)
	{
		
		$start = new DateTime('now');
		$end = new DateTime($date);
		$time_to_convert = $start->format('U') - $end->format('U');
		
		$y = 0;
		$m = 0;
		$d = 0;
		$h = 0;
		$i = 0;
		$s = 0;

        $FULL_YEAR = 60*60*24*365.25;
        $FULL_MONTH = 60*60*24*(365.25/12);
        $FULL_DAY = 60*60*24;
        $FULL_HOUR = 60*60;
        $FULL_MINUTE = 60;
        $FULL_SECOND = 1;

		// $time_to_convert = 176559;
        $seconds = 0;
        $minutes = 0;
        $hours = 0;
        $days = 0;
        $months = 0;
        $years = 0;

        while($time_to_convert >= $FULL_YEAR) {
            $years ++;
            $time_to_convert = $time_to_convert - $FULL_YEAR;
        }

        while($time_to_convert >= $FULL_MONTH) {
            $months ++;
            $time_to_convert = $time_to_convert - $FULL_MONTH;
        }

        while($time_to_convert >= $FULL_DAY) {
            $days ++;
            $time_to_convert = $time_to_convert - $FULL_DAY;
        }

        while($time_to_convert >= $FULL_HOUR) {
            $hours++;
            $time_to_convert = $time_to_convert - $FULL_HOUR;
        }

        while($time_to_convert >= $FULL_MINUTE) {
            $minutes++;
            $time_to_convert = $time_to_convert - $FULL_MINUTE;
        }
		
		$arr = array();
        $seconds = $time_to_convert; // remaining seconds
        $arr['y'] = $years;
        $arr['m'] = $months;
        $arr['d'] = $days;
        $arr['h'] = $hours;
        $arr['i'] = $minutes;
        $arr['s'] = $seconds;
		
		return $arr;

	}
        
}
