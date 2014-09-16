<style>
.drop_links .all{color:darkorange !important;}
.drop_links a:hover,.drop_links .all:hover{color:#000 !important;}
</style>
<?php 

	$arr = array();
	$ctr = 0;
	
	if($category != false){
			
			
			echo "<div class='drop_container'>";
				
			foreach($category as $key => $val){
				
				if($type == "male"){
					echo  "<div class='drop_links'><a class='w90' href='".base_url()."mens-watches?brand=".$key."'>" . $val . "</a></div>";
				}
				if($type == "female"){
					echo  "<div class='drop_links'><a class='w90' href='".base_url()."womens-watches?brand=".$key."'>" . $val . "</a></div>";
				}
				if($type == "kids"){
					echo  "<div class='drop_links'><a class='w90' href='".base_url()."kids-watches?brand=".$key."'>" . $val . "</a></div>";
				}

			}
			
			if($type=="male"){
				echo  "<div class='drop_links'><a class='w90 all' href='".base_url()."mens-watches/'>View All Mens Watches</a></div>";
			}
			if($type=="female"){
				echo  "<div class='drop_links'><a class='w90 all' href='".base_url()."womens-watches/'>View All Womens Watches</a></div>";
			}
			if($type=="kids"){
				echo  "<div class='drop_links'><a class='w90 all' href='".base_url()."kids-watches/'>View All Kids Watches</a></div>";
			}
			echo "</div>";

	}

?>


