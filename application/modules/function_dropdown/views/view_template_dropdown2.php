<style>
.drop_links .all{color:darkorange !important;}
.drop_links a:hover,.drop_links .all:hover{color:#000 !important;}
</style>
<?php 

	$arr = array();
	$ctr = 0;
	
	if($category != false){
			
			
			echo "<ul class='dropdown-menu' role='menu'>";
				
			foreach($category as $key => $val){
				
				if($type == "male"){
					echo  "<li><a href='".base_url()."mens-watches?brand=".$key."'>" . $val . "</a></li>";
				}
				if($type == "female"){
					echo  "<li><a href='".base_url()."womens-watches?brand=".$key."'>" . $val . "</a></li>";
				}
				if($type == "kids"){
					echo  "<li><a href='".base_url()."kids-watches?brand=".$key."'>" . $val . "</a></li>";
				}

			}
			
			if($type=="male"){
				echo  "<li><a class='all' href='".base_url()."mens-watches/'>View All Mens Watches</a></li>";
			}
			if($type=="female"){
				echo  "<li><a class='all' href='".base_url()."womens-watches/'>View All Womens Watches</a></li>";
			}
			if($type=="kids"){
				echo  "<li><a class='all' href='".base_url()."kids-watches/'>View All Kids Watches</a></li>";
			}
			echo "</ul>";

	}

?>


