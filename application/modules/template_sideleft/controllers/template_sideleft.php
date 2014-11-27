<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_sideleft extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
		   $this->load->module("function_category");

	}
        
	public function view_template_sideleft()
	{

		$this->load->module("function_login");
		$validate = $this->function_login->check_data();
		if($validate != ""){
			$data["error"] = $validate;
		} else {
			$data["error"] = "";
		}
		$this->load->view('view_sideleft',$data);

	}

	public function view_template_filtered_sideleft()
	{
		
		$data["refine"] = $this->filter_data();
		
		$this->load->view('view_template_filtered_sideleft', $data);

	}
	public function view_sideleft_sellers()
	{
		
		$data["refine"] = $this->filter_data2();
		$data["refine_rating"] = $this->filter_data_rating();
		
		$this->load->view('view_sideleft_sellers', $data);

	}	
	
	public function filter_data(){
		
		$this->load->module("template_itemlist");
		$string = $this->template_itemlist->process_uri_segment();
		return $string;
	
	}
	public function filter_data2(){
		
		$this->load->module("template_sellers");
		$string = $this->template_sellers->process_uri_segment();
		return $string;
	
	}
	
	public function filter_data_rating(){
		
		$this->load->module("template_sellers");
		$string = $this->template_sellers->process_uri_segment_rating();
		return $string;
	
	}		
	
	public function ajax_refine_search(){
		
		$where_string = trim($_POST["args"]);
		$url = trim($_POST["url"]);
		$get = trim($_POST["get"]);
		$uri_process = trim($_POST["uri_process"]);
		$GET = $this->parse_get_values($get);
		
		$this->load->module("function_brands");
		$htm = "";
		
		if($where_string != ""){
			$where_string .= " AND item_paid = 1 
							   AND item_days > 0
							   AND item_expire > CURDATE()";
		} else {
			$where_string .=  "item_paid = 1 
							   AND item_days > 0
							   AND item_expire > CURDATE()";
		}
		
		$query ="select 
				(SELECT group_concat(DISTINCT item_gender) FROM watch_items WHERE $where_string) as item_gender,
				(SELECT group_concat(DISTINCT item_brand) FROM watch_items WHERE $where_string) as item_brand,
				(SELECT group_concat(DISTINCT item_category_id) FROM watch_items WHERE $where_string) as item_category,
				(SELECT group_concat(DISTINCT item_case) FROM watch_items WHERE $where_string) as item_case,
				(SELECT group_concat(DISTINCT item_bracelet) FROM watch_items WHERE $where_string) as item_bracelet,
				(SELECT group_concat(DISTINCT item_condition) FROM watch_items WHERE $where_string) as cond";

		$brands = $this->db->query($query);
		
		if($brands->num_rows() > 0){
			$htm .= "<div>";

		if($get != "" && $uri_process == "data"){
			   ?>
			   <div>
					Selected Filters
			   </div> 
			   <?php
			   if(strpos($get,",") > -1){	
					$new = explode(",", $get);
					foreach($new as $n1){
						$n1 = explode("+",$n1);
						$this->display_properties($n1);																																									
					}
			   } else {
						$n1 = explode("+",$get);
						$this->display_properties($n1);																																						
			   }
			}
			$data = $brands->result();			
			//gender
			$htm .= "<div>Gender</div>";
                        
			$main_url = $this->reconstruct_url($uri_process,$url,$GET,"gender");
			$brands = explode(",",$data[0]->item_gender);
			$htm .= "<ul class='list-unstyled'>";
			$gender_arr = array(1 => "Mens", 2 => "Womens", 3 => "Unisex");
			foreach($brands as $b){
                            $htm .= "<li>";
				@$nam = $gender_arr[(int)$b];
				@$htm .= "<a  href='".$main_url.$b."'>".$nam."</a>";
                            $htm .= "</li>";
			}
			$htm .= "</ul>";					
                        
			// brands
			$htm .= "<div>Brands</div>";
			$main_url = $this->reconstruct_url($uri_process,$url,$GET,"brand");
			$brands = explode(",",$data[0]->item_brand);
			$htm .= "<ul class='list-unstyled'>";
			$count = count($brands);
			$ctr = 1;
			foreach($brands as $b){
                                $htm .= "<li>";
				if($ctr == 7){
					@$htm .= "<a id='show_more_brands' style=' ' href='javascript:;'>more brands [+]</a>";
					$htm .= "<div id='more_brands' style='float:left; clear:both; display:none'>";
				}
				if($ctr >= 7){
				    @$htm .= "<a   href='".$main_url.$b."'>".$this->function_brands->watch_brands($b)."</a>";
				} else {
				    @$htm .= "<a   href='".$main_url.$b."'>".$this->function_brands->watch_brands($b)."</a>";
				}
				$ctr++;
                                $htm .= "</li>";
			}
			if($ctr > 7){
				@$htm .= "<a id='show_less_brands' style=' ' href='javascript:;'>less brands [-]</a>";
				$htm .= "</div>";
			}
			$htm .= "</ul>";

			$htm .= "<div>Categories</div>";
			$main_url = $this->reconstruct_url($uri_process,$url,$GET,"category");
			$brands = explode(",",$data[0]->item_category);
			$htm .= "<ul class='list-unstyled'>";
			foreach($brands as $b){
                                $htm .= "<li>";
				@$nam = $this->function_category->get_category_fields("category_name", $b);
				@$htm .= "<a   href='".$main_url.$b."'>".$nam."</a>";
                                $htm .= "</li>";
			}
			$htm .= "</ul>";

			$htm .= "<div>Case Type</div>";
			$main_url = $this->reconstruct_url($uri_process,$url,$GET,"case_type");
			$brands = explode(",",$data[0]->item_case);
			$htm .= "<ul class='list-unstyled'>";
			foreach($brands as $b){
                            $htm .= "<li>";
				@$nam = ucfirst($b);
				@$htm .= "<a   href='".$main_url.$b."'>".$nam."</a>";
                            $htm .= "</li>";
			}
			$htm .= "</ul>";

			$htm .= "<div>Bracelet Type</div>";
			$main_url = $this->reconstruct_url($uri_process,$url,$GET,"bracelet_type");
			$brands = explode(",",$data[0]->item_case);
			$htm .= "<ul class='list-unstyled'>";
			foreach($brands as $b){
                            $htm .= "<li>";
				@$nam = ucfirst($b);
				@$htm .= "<a   href='".$main_url.$b."'>".$nam."</a>";
                            $htm .= "</li>";
			}
			$htm .= "</ul>";

			$htm .= "<div>Condition</div>";
			$main_url = $this->reconstruct_url($uri_process,$url,$GET,"condition");
			$brands = explode(",",$data[0]->cond);
			$htm .= "<ul class='list-unstyled'>";
			foreach($brands as $b){
                            $htm .= "<li>";
				@$nam = str_replace("_"," ",ucfirst($b));
				@$htm .= "<a   href='".$main_url.$b."'>".$nam."</a>";
                            $htm .= "</li>";
			}			
			$htm .= "</ul>";
			
			$htm .= "<div>Price Range</div>";
			$htm .= "<div style=' ' href='".$main_url.$b."'>
                                    <div class='form-group'>
                                        <label for='min_price'>Min Price</label>
                                        <input class='form-control' type='text' id='min_price' class='int' value=''>
                                    </div>
                                    <div class='form-group'>
                                        <label for='max_price'>Max Price </label>
                                        <input class='form-control' type='text' id='max_price' class='int' value=''>
                                    </div>
                                    <input type='button' id='filter_price' class='btn btn-success' value='Filter Price' style='margin-top:5px;'>
				</div>";
		}

		$htm .="</div>";
		
		exit($htm);
	
	}

	public function ajax_refine_search_sellers(){
		
		$this->load->module("function_country");
		$this->load->module("function_rating");
		//$where_string = trim($_POST["refine_rating"]);
		$where_string = trim($_POST["args"]);
		$url = trim($_POST["url"]);
		$get = trim($_POST["get"]);
		$uri_process = trim($_POST["uri_process"]);
		$GET = $this->parse_get_values($get);
		
		$htm = "";
		
		if($where_string != ""){
			$where_string .= " AND user_activated = user_activation";
		} else {
			$where_string .=  "user_activated = user_activation";
		}
		
		$query ="select 
				(SELECT group_concat(DISTINCT user_country) FROM watch_users WHERE $where_string) as user_country";

		$users = $this->db->query($query);
		
		if($users->num_rows() > 0){
			$htm .= "<div style='float: left;
								width: 203px;
								margin: 0px;
								padding: 10px 0px;'>";

		if($get != "" && $uri_process == "data"){
			   $ctr = 1;
			   if(strpos($get,",") > -1){	
					$new = explode(",", $get);
					foreach($new as $n1){
						if($ctr == 1){
					   ?>
					   <div style='float:left; clear:both; font-family:arial; width:195px; font-size:14px; padding:5px 0px 5px 9px; background:#444; font-weight:bold; color:#FFF'>
							Selected Filters
					   </div> 
					   <?php						
						}
						$n1 = explode("+",$n1);
						$this->display_properties($n1);																																									
						$ctr++;
					}
			   } else {
					   if(strpos($get,"per_page") > -1){
					   } else {
					   ?>
					   <div style='float:left; clear:both; font-family:arial; width:195px; font-size:14px; padding:5px 0px 5px 9px; background:#444; font-weight:bold; color:#FFF'>
							Selected Filters
					   </div> 
					   <?php
					    $n1 = explode("+",$get);
						$this->display_properties($n1);																																						
					   }
			   }
			}
								

			// brands
			$htm .= "<div  >Country</div>";
			$data = $users->result();
			$main_url = $this->reconstruct_url_sellers($uri_process,$url,$GET,"country");
			$users = explode(",",$data[0]->user_country);
			$htm .= "<div  >";
			$count = count($users);
			$ctr = 1;
			foreach($users as $b){
				if($ctr == 20){
					@$htm .= "<a id='show_more_brands' style=' ' href='javascript:;'>more country [+]</a>";
					$htm .= "<div id='more_brands' style='float:left; clear:both; display:none'>";
				}
				if($ctr >= 20){
				    @$htm .= "<a   href='".$main_url.$b."'>".$this->function_country->get_country_name($b)."</a>";
				} else {
				    @$htm .= "<a   href='".$main_url.$b."'>".$this->function_country->get_country_name($b)."</a>";
				}
				$ctr++;
			}
			if($ctr > 7){
				@$htm .= "<a id='show_less_brands' style=' ' href='javascript:;'>less brands [-]</a>";
				$htm .= "</div>";
			}
			$htm .= "</div>";

			$count1 = 0;
             // get total count
			$query = "SELECT SUM(user_rating = 5) AS count5
						 , SUM(user_rating = 4) AS count4
						 , SUM(user_rating = 3) AS count3
						 , SUM(user_rating = 2) AS count2
						 , SUM(user_rating = 1) AS count1
						 , SUM(user_rating = 0) AS count0
					FROM watch_users WHERE $where_string";
			$total1 = $this->db->query($query);
			if($total1->num_rows() > 0){
					$count1 = $total1->result();
				 
			} 
			
			$main_url = $this->reconstruct_url_sellers($uri_process,$url,$GET,"rating");
			$htm .= "<div  >Member Rating</div>";
			$htm .= "<div style=' ; margin-top:12px;'>";

					for($x = 5; $x >= 0; $x--){
						$htm .= '<div style="float:left; clear:both; width:200px; margin-left:12px;">';
							 $name = "count" . $x;
							 $h = 0;
							 if($count1[0]->$name > 0){
								$h = "<a href='".$main_url.$x."' style='text-decoration:underline'>".$count1[0]->$name."</a>";	
							 }
							 
							 $htm .= $this->function_rating->display_stars($x) . "<div style='float:left; font-family:arial; margin:7px 5px'> = <b>" . $h ."</b></div>";
						$htm .= '</div>';					
					
					}

						
			$htm .= "		</div>";
		}

		$htm .="</div>";
		
		exit($htm);
	
	}	
	
	public function parse_get_values($get){
		
		$arr = array();
		
		if($get != ""){
		$get = explode(",",$get);
		foreach($get as $g){
			
			$v = explode("+",$g);
			$arr[$v[0]] = $v[1];
			
		}
		}
		return $arr;
	
	}
	
	public function reconstruct_url($uri_process, $url,$GET,$remove){
		
		$new_get = array();
		$n_get = "";
		foreach($GET as $key => $val){
			if($key != $remove && $key != "per_page"){
				$new_get[] = $key ."=".$val;
			}
		}
		if(count($new_get) > 0){
			$n_get = implode("&",$new_get);
		}
		
		if($n_get != ""){
		  $n_get .= "&$remove=";
		} else {
		  $n_get = "$remove=";
		}
		
		if($uri_process == "no_data"){
			return base_url()."all-watches" ."?$remove=";
		}
		
		return $url ."?".$n_get;
	
	}

	public function reconstruct_url_sellers($uri_process, $url,$GET,$remove){
		
		$new_get = array();
		$n_get = "";
		foreach($GET as $key => $val){
			if($key != $remove){
				$new_get[] = $key ."=".$val;
			}
		}
		if(count($new_get) > 0){
			$n_get = implode("&",$new_get);
		}
		
		if($n_get != ""){
		  $n_get .= "&$remove=";
		} else {
		  $n_get = "$remove=";
		}
		
		if($uri_process == "no_data"){
			return base_url()."sellers" ."?$remove=";
		}
		
		return $url ."?".$n_get;
	
	}	
	
	public function display_properties($n1){
		if($n1[0] == "brand" && $n1[1] != ""){
			?>
			<div >
				<input type="hidden" class="filter_type" value="brand">
				<a href="javascript:;" class="delete_filter" style=" ">remove</a>
				<b>Brand:</b>
				<div  >
					<?php echo $this->function_brands->watch_brands($n1[1]); ?>
				</div>
			</div>			
			<?php
		}
		elseif($n1[0] == "category" && $n1[1] != ""){
			?>
			<div>
				<input type="hidden" class="filter_type" value="category">
				<a href="javascript:;" class="delete_filter" style=" ">remove</a>
				<b>Category:</b>
				<div  >
					<?php echo $this->function_category->get_category_fields("category_name", $n1[1]); ?>
				</div>
			</div>			
			<?php
		}	
		elseif($n1[0] == "case_type" && $n1[1] != ""){
			?>
			<div>
				<input type="hidden" class="filter_type" value="case_type">
				<a href="javascript:;" class="delete_filter" style=" ">remove</a>
				<b>Case Type:</b>
				<div  >
					<?php echo ucfirst($n1[1]); ?>
				</div>
			</div>			
			<?php
		}
		elseif($n1[0] == "bracelet_type" && $n1[1] != ""){
			?>
			<div  >
				<input type="hidden" class="filter_type" value="bracelet_type">
				<a href="javascript:;" class=""delete_filter style=" ">remove</a>
				<b>Case Type:</b>
				<div  >
					<?php echo ucfirst($n1[1]); ?>
				</div>
			</div>			
			<?php
		}	
		elseif($n1[0] == "condition" && $n1[1] != ""){
			?>
			<div  >
				<input type="hidden" class="filter_type" value="condition">
				<a href="javascript:;" class="delete_filter" style=" ">remove</a>
				<b>Condition:</b>
				<div  >
					<?php echo ucfirst($n1[1]); ?>
				</div>
			</div>			
			<?php
		}
		elseif($n1[0] == "min_price" && $n1[1] != ""){
			?>
			<div  >
				<input type="hidden" class="filter_type" value="min_price">
				<a href="javascript:;" class="delete_filter" style=" ">remove</a>
				<b>Min Price:</b>
				<div  >
					<?php echo $n1[1]; ?>
				</div>
			</div>			
			<?php
		}	
		elseif($n1[0] == "max_price" && $n1[1] != ""){
			?>
			<div  >
				<input type="hidden" class="filter_type" value="max_price">
				<a href="javascript:;" class="delete_filter" style=" ">remove</a>
				<b>Max Price:</b>
				<div  >
					<?php echo $n1[1]; ?>
				</div>
			</div>			
			<?php
		}
		elseif($n1[0] == "s"){
			?>
			<div  >
				<input type="hidden" class="filter_type" value="s">
				<a href="javascript:;" class="delete_filter" style=" ">remove</a>
				<b>Search:</b>
				<div  >
					<?php 
					if($n1[1] == ""){
						echo "No String Search";
					} else {
						echo $n1[1];
					}?>
				</div>
			</div>			
			<?php
		}
		elseif($n1[0] == "year_model" && $n1[1] != ""){
			?>
			<div  >
				<input type="hidden" class="filter_type" value="year_model">
				<a href="javascript:;" class="delete_filter" style=" ">remove</a>
				<b>Year Model:</b>
				<div  >
					<?php echo $n1[1]; ?>
				</div>
			</div>			
			<?php
		}	
		elseif($n1[0] == "gender" && $n1[1] != ""){
			?>
			<div  >
				<input type="hidden" class="filter_type" value="gender">
				<a href="javascript:;" class="delete_filter" style=" ">remove</a>
				<b>Gender:</b>
				<div  >
					<?php 
					$gender = array("1" => "Mens", "2" => "Womens", "3" => "Unisex");
					echo $gender[(string)$n1[1]]; ?>
				</div>
			</div>			
			<?php
		}
		elseif($n1[0] == "kids" && $n1[1] != ""){
			?>
			<div  >
				<input type="hidden" class="filter_type" value="kids">
				<a href="javascript:;" class="delete_filter" style=" ">remove</a>
				<b>For Kids:</b>
				<div  >
					<?php 
					$g = array("1" => "Yes", "0" => "No");
					echo $g[(string)$n1[1]]; ?>
				</div>
			</div>			
			<?php
		}	
		elseif($n1[0] == "certificate" && $n1[1] != ""){
			?>
			<div  >
				<input type="hidden" class="filter_type" value="certificate">
				<a href="javascript:;" class="delete_filter" style=" ">remove</a>
				<b>With Certificate:</b>
				<div  >
					<?php 
					$g = array("1" => "Yes", "0" => "No");
					echo $g[(string)$n1[1]]; ?>
				</div>
			</div>			
			<?php
		}										
		elseif($n1[0] == "box" && $n1[1] != ""){
			?>
			<div  >
				<input type="hidden" class="filter_type" value="box">
				<a href="javascript:;" class="delete_filter" style=" ">remove</a>
				<b>With Box:</b>
				<div  >
					<?php 
					$g = array("1" => "Yes", "0" => "No");
					echo $g[(string)$n1[1]]; ?>
				</div>
			</div>			
			<?php
		}	
		elseif($n1[0] == "case_width" && $n1[1] != ""){
			?>
			<div  >
				<input type="hidden" class="filter_type" value="case_width">
				<a href="javascript:;" class="delete_filter" style=" ">remove</a>
				<b>Case Width:</b>
				<div  >
					<?php 
					echo $n1[1]; ?> mm
				</div>
			</div>			
			<?php
		}										
		elseif($n1[0] == "case_thickness" && $n1[1] != ""){
			?>
			<div  >
				<input type="hidden" class="filter_type" value="case_thickness">
				<a href="javascript:;" class="delete_filter" style=" ">remove</a>
				<b>Case Thickness:</b>
				<div  >
					<?php 
					echo $n1[1]; ?> mm
				</div>
			</div>			
			<?php
		}
		elseif($n1[0] == "item_type" && $n1[1] != ""){
			?>
			<div  >
				<input type="hidden" class="filter_type" value="item_type">
				<a href="javascript:;" class="delete_filter" style=" ">remove</a>
				<b>Item Type:</b>
				<div  >
					<?php 
					echo ucfirst($n1[1]); ?> & Accessories
				</div>
			</div>			
			<?php
		}	
		elseif($n1[0] == "part_type" && $n1[1] != ""){
			?>
			<div  >
				<input type="hidden" class="filter_type" value="part_type">
				<a href="javascript:;" class="delete_filter" style=" ">remove</a>
				<b>Part Type:</b>
				<div  >
					<?php 
					echo ucfirst($n1[1]); ?> 
				</div>
			</div>			
			<?php
		}
		elseif($n1[0] == "country" && $n1[1] != ""){
			?>
			<div  >
				<input type="hidden" class="filter_type" value="country">
				<a href="javascript:;" class="delete_filter" style=" ">remove</a>
				<b>Country:</b>
				<div  >
					<?php 
					echo $this->function_country->get_country_name($n1[1]); ?> 
				</div>
			</div>			
			<?php
		}	
		elseif($n1[0] == "rating" && $n1[1] != ""){
			?>
			<div  >
				<input type="hidden" class="filter_type" value="rating">
				<a href="javascript:;" class="delete_filter" style=" ">remove</a>
				<b>Rating:</b>
				<div  >
					<?php 
					echo $n1[1] . " stars"; ?> 
				</div>
			</div>			
			<?php
		}
		elseif($n1[0] == "user" && $n1[1] != ""){
			?>
			<div  >
				<input type="hidden" class="filter_type" value="user">
				<a href="javascript:;" class="delete_filter" style=" ">remove</a>
				<b>User Name:</b>
				<div  >
					<?php 
					echo $n1[1]; ?> 
				</div>
			</div>			
			<?php
		}																						

	}

}
