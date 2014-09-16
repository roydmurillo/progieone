<?php 

	$arr = array();
	$ctr = 0;
	
	if($category != false){
			
			echo "<div class='drop_container' style='width:270px !important; height:440px; overflow:hidden'>";
				
			foreach($category as $key => $name){
				
				// opening
				if($ctr == 0){
					echo "<div style='float:left; width:120px; margin-left:12px;'>";
				}
					echo  "<div class='drop_links'><a href='".base_url()."watch-categories?category=".$key ."'>" . $name . "</a></div>";
				    $ctr++;
					
				if($ctr == 14){
					$ctr == 0;
					echo "</div><div style='float:left; width:120px; margin-left:15px'>";
				}
					
				
			}

			//closing
			echo "</div></div>";
			echo "<div class='drop_container'>";
			
			echo "</div>";
			
	}

?>


