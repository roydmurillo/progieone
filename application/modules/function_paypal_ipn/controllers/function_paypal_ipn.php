<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class function_paypal_ipn extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
               $this->load->module("function_paypal");
               $this->function_paypal->set_paypal();
	}

        
        public function initialize_ipn(){
				
				//load paypal settings
   				$this->load->library("paypal_settings");
                
                # setup receiver
                define("RECEIVER_EMAIL", $this->paypal_settings->business_email());
                
                # debug setup
                define("DEBUG", 0);
				
				
                # Set to 0 once you're ready to go live
			   if($this->paypal_settings->environment() == "sandbox"){
	                define("USE_SANDBOX", 1);
			   } elseif($this->paypal_settings->environment() == "live"){
	                define("USE_SANDBOX", 0);
			   }
                
                $this->write_to_dummy($_POST);

                # run
                $this->run_ipn(DEBUG, USE_SANDBOX, RECEIVER_EMAIL);
                
                
        }
        
        public function write_to_dummy($POST){
            
                $details = "";
                foreach($POST as $key => $val){
                    $details .= $key . " = " . $val ."\n";
                }

                $this->db->set("txn_details", $details);
                $this->db->insert("watch_transactions_dummy");            
        }
        
	/*===================================================================
	* name : run ipn()
	* desc : main ipn receiver
	* parm : $type = function type
        *        $args = arguments
	* return : dashboard
	*===================================================================*/        
        public function run_ipn($DEBUG, $USE_SANDBOX, $RECEIVER_EMAIL)
	{

                # set request post data
                $req = $this->post_data($_POST);

                # get ipn data callback
                $this->setup_curl_obj($DEBUG, $USE_SANDBOX, $req, $RECEIVER_EMAIL);

                
	}   

	/*===================================================================
	* name : post_data()
	* desc : setups post data for callback request
	* parm : 
	* return : 
	*===================================================================*/         
        public function post_data($POST){
                
                if ($_SERVER['REQUEST_METHOD'] != "POST") die ("No Post Variables");
                $req = 'cmd=_notify-validate';
                foreach ($POST as $key => $value) {
                    $value = urlencode(stripslashes($value));
                    $req .= "&$key=$value";
                }
                return $req;
            
        }

	/*===================================================================
	* name : setup_curl_obj()
	* desc : setups curl object
	* parm : 
	* return : 
	*===================================================================*/         
        public function setup_curl_obj($DEBUG, $USE_SANDBOX, $req, $r_email){
            
                /*
                 *  Check if sandbox or not
                 *  Without this step anyone can fake IPN data
                 */
                if($USE_SANDBOX == true) {
                        $paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
                } else {
                        $paypal_url = "https://www.paypal.com/cgi-bin/webscr";
                }

                /*
                 *  Process Curl to send to paypal
                 *  this is to get a new post from paypal for verification
                 *  if the data will match from the first post data
                 */
                $ch = curl_init($paypal_url);
                if ($ch == FALSE) return FALSE;
                curl_setopt($ch, CURLOPT_URL,$paypal_url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded", "Content-Length: " . strlen($req)));
                curl_setopt($ch, CURLOPT_HEADER , 0);   
                curl_setopt($ch, CURLOPT_VERBOSE, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                $curl_result = @curl_exec($ch);
                $curl_err = curl_error($ch);
                curl_close($ch);
                
                /*
                 *  if the result from curl matches the latter POST data,
                 *  data is verified and ready for processing
                 */
                if (strpos($curl_result, "VERIFIED") !== false) {
                        $this->process_post_data($r_email);
                        if($DEBUG == true) {
                                $this->log_err(date('[Y-m-d H:i e] '). "Verified IPN: $req ");
                        }
                } elseif (strpos($curl_result, "INVALID") !== false) {
                        if($DEBUG == true) {
                                $this->log_err(date('[Y-m-d H:i e] '). "Invalid IPN: $req");
                        }
                }                
            
        }            
        
        public function log_err($err){
            
            echo "<script>console.log('".$err."')</script>";
            
        }

	/*===================================================================
	* name : process_post_data()
	* desc : this is for processing post data from paypal
	* parm : 
	* return : 
	*===================================================================*/         
        public function process_post_data($receiver_email=""){
                
                /*
                 * check whether the transaction is always valid
                 * - this will check transaction ID if used
                 * - Check the right items being paid
                 * - Check whether the gross amount is the same
                 * - Check the receiver email if this is the business email
                 */
                if($this->valid_transaction($receiver_email,$_POST)){

                        /*
                         *  update transaction table
                         *  this will always update even transactions is not successful for
                         *  data check
                         */
                        if($this->update_transaction_table()){  
                            
                            /*
                             * update transaction to items table only when transaction is complete
                             * this will prevent users to extend expiry date when not completed
                             */
                            $this->load->module("function_items");
                            $this->function_items->update_transactions($_POST["custom"]);  
                        }
                }  
        }
        
        public function valid_transaction($receiver_email_main,$POST){
                    
                    $error_details = "";
                    $this->load->module("function_items");
                    $error = 0;                      
                    
                    /*
                     * check whether the transaction is always valid
                     * transaction ID will be checked in transaction table
                     * transaction ID should not exist with the same payment status
                     */                   
                    $error += $this->check_transaction_id($POST["txn_id"]);
                    if($error > 0){
                        $error_details .= "Transaction Id " . $POST["txn_id"] . " was already used.\n";
                    }          
                    
                    /*
                     * check whether the receiver email is the same with the business email
                     */                   
                    if($POST["receiver_email"] != $receiver_email_main){
                        $error ++;
                        $error_details .= "Receiver Email " . $POST["receiver_email"] . " is not equal to " . $receiver_email_main  . "\n";
                    }

                    # check that payment_amount/payment_currency are correct
                    $ctr = 1;
                    $array_name = array();
                    for($ctr = 1; $ctr <= 1000; $ctr++){
                            if(isset($POST["item_name$ctr"])){
                                $array_name[] = $POST["item_name$ctr"];
                            } else {
                                $ctr = 1001;
                            }
                    }
                    
                    $paypal = $this->native_session->get("paypal");
                    
                    #expand items customs with uid
                    $c = explode("=",$POST["custom"]);
                    $custom = trim($c[0], ",");
                    $custom = explode(",", $custom);
                    
                    (float)$amount = 0.00;
                    $array_paid_name = array();
                    foreach($custom as $c){
                        $data = explode("-", $c);
                        (float)$amount += ((int)$data[1] * $paypal["price"]);
                        $array_paid_name[] = $this->function_items->get_item_fields("item_name", $data[0]);
                    }
                    
                    #check if same items
                    $array_paid_name = array_map('strtolower', $array_paid_name);
                    $array_name = array_map('strtolower', $array_name);
                    if($array_paid_name != $array_name){
                        $error++;
                        $error_details .= "Item Names does not Match. \n";                    
                    }
                    
                    #check if mcgross is equal to actual paid
                    if(trim((string)$POST["mc_gross"]) != trim((string)$amount)){
                        $error++;
                        $error_details .= "Mc Gross " . $POST["mc_gross"] .  " is not equal to " . $amount  . "\n";
                    }
                    
                    if($error > 0){
                        // not in post items
                        $this->db->set("err_txn_id", $POST["txn_id"]);
                        $this->db->set("err_details", $error_details);
                        $this->db->insert('watch_transaction_error');
                        
                        return false;
                    }
                    
                    return true;
            
        }
        
        public function check_transaction_id($txn_id){
                     
                    $this->db->where('txn_txn_id', $txn_id);
                    $this->db->from('watch_transactions');
                    $count = $this->db->count_all_results();
                    
                    if($count > 0){
                        return 1;
                    }
                    
                    return 0;
            
        }
        

        
        public function update_transaction_table(){
                
                $this->load->module("function_users");

                $data_arr = array("payer_email",
                                  "first_name",
                                  "last_name",
                                  "payment_date",
                                  "mc_gross",
                                  "mc_currency",
                                  "receiver_email",
                                  "payment_type",
                                  "payment_status",
                                  "txn_type",
                                  "payer_status",
                                  "address_street",
                                  "address_city",
                                  "address_state",
                                  "address_zip",
                                  "address_country",
                                  "address_status",
                                  "notify_version",
                                  "verify_sign",
                                  "payer_id",
                                  "mc_currency",
                                  "mc_fee");

                $insert = array();
                foreach($data_arr as $d){
                    $name = "txn_" . $d;
                    $insert[$name] = $_POST[$d];
                }

                // assign posted variables to local variables
                $txn_id = $_POST['txn_id'];
                $c = explode("=",$_POST["custom"]);
                $custom = trim($c[0], ",");
                
                // not in post items
                $insert["txn_txn_id"] = $txn_id;

                $insert["txn_payer_id"] = $c[1];

                $insert["txn_productid_quantity"] = $custom;

                $insert["txn_created"] = date("Y-m-d H:i:s");

                $this->db->insert('watch_transactions', $insert); 
                        
                // do this for completed status
                $folder = $this->function_users->get_user_fields_by_id("user_folder",(int)$c[1]);
                $this->create_remark_file($folder);
				
				//add activity
				$activity = array( "activity" => "sell",
									"items" => $custom);
									
				$this->load->module("function_activity");					
				$this->function_activity->add_activity($activity);
				
                if($_POST["payment_status"] == "Completed"){
                    return true;
                } 
                
                return false;
            
        }
        
        public function data_dump($details){
                $this->db->set("err_txn_id", 9999);
                $this->db->set("err_details", $details);
                $this->db->insert('watch_transaction_error');
        }
        
        // create a text file
        public function create_remark_file($folder){
                $file = $folder ."/checkout_status.txt";
                file_put_contents($file, trim($_POST["payment_status"]));
                //echo file_get_contents('file.txt'); // bar
        }        
        
        public function checkout_view($data){
            
            //load header
            $this->load->module('template_header');
            $this->template_header->index($data); 		

            $this->load->view("checkout_complete");

            //load footer
            $this->load->module('template_footer');
            $this->template_footer->index(); 
            
        }
        
        
        
}
