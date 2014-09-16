<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class function_pagination extends MX_Controller {

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
        public function pagination($link = NULL, 
                                          $total = NULL, 
                                          $count_per_page = NULL, 
                                          $selected_page = 0 ){
                 
                 $html = "";
                 
                 if(($link == NULL || $link == "") || 
                    ($total == NULL ) ||
                    ($count_per_page == NULL || $count_per_page == "")) return "";

                    @$ceiling = ceil($total / $count_per_page);
                     
					     if($ceiling > 1){
                                      
                                      $html .= "<div style='padding:12px;float:left; clear:both'>";

                                      if(($ceiling - $selected_page) != ($ceiling - 1) && ($selected_page != 0)){
                                         $html .= "<a href='javascript:;' id='prev' style='margin:12px'>prev</a>";
                                      }

                                      $html .= "<select id='paginate_page' style='width:100px'>";

                                                for($x = 1; $x <= $ceiling; $x++){
                                                        //$start = $x - 1;
                                                        $start = $x;
                                                        if($x == $selected_page){
                                                            $sel = 'selected="selected"';
                                                        } else {
                                                            $sel = "";
                                                        }    
                                                        $html .= "<option value='".$start."' ".$sel.">".$x."</option>";
                                                }

                                      $html .= "</select>";

                                      if(($ceiling - $selected_page) != 0){
                                              $html .= "<a href='javascript:;' id='next' style='margin:12px'>next</a>";
                                      }

                                      $html .= "</div>";
                                      return $html;   
                         }

                 return "";

        }
        
}
