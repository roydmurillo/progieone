<?php 

	$arr = array();
	$ctr = 0;
	
	if($category != false){
			
			echo "<ul class='dropdown-menu' role='menu'>";
				
			foreach($category as $key => $name){
				
				// opening
				if($ctr == 0){
					//echo "<div style='float:left; width:120px; margin-left:12px;'>";
				}
                                        
					echo  "<li><a href='".base_url()."watch-categories?category=".$key ."'>" . $name . "</a></li>";
				    $ctr++;
					
				if($ctr == 14){
					$ctr == 0;
					//echo "</div><div style='float:left; width:120px; margin-left:15px'>";
				}
					
				
			}
                        
                        echo "</ul>";
			
	}

?>


