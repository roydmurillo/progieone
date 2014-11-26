<?php


if($item_list != ""){?>

	<div>
		
		<!-- content goes here -->
		<h2 class="h2_title">Watch Compare All</h2>
		
		<div id="single_content">
		
			<div id="scroll_content">

			<?php
			    $bool = array( 1 => "Yes", 0 => "No" );
				$gender = array( 1 => "Mens", 2 => "Womens" , 3 => "Unisex" );
				$whole = array( 1 => "Whole Watch", 0 => "Parts Only" );
				// parse data
				foreach($item_list as $i){
					$item_name = $i->item_name;
					$item_desc = $i->item_desc;
					$item_brand = $i->item_brand;  
					$item_category = $i->item_category_id; 
					$item_wholepart = $i->item_wholepart; 
					$item_gender = $i->item_gender;
					$item_certificate = $i->item_certificate;
					$item_box = $i->item_box;
					$item_year_model = $i->item_year_model;
					$item_images = unserialize($i->item_images);
//					$count = count($item_images) - 1;
//					$image = $item_images[rand(0,$count)];
					
								//if no image
//					if($image == "" || $image === false || empty($image)){
//						$image = base_url() . "assets/images/no-image.png";
//					} else {
//						if(strpos($image,"localhost") > -1){
//							$image = explode(".",$image);
//							$image = $image[0] . "_thumb." . $image[1];
//						} else {
//							$image = explode(".",$image);
//							$image = $image[0] ."." . $image[1] . "_thumb." . $image[2];
//						}
//					}

                    $no_image = base_url() . "assets/images/no-image.png";
                    $default_image = $no_image;
                    if(is_array($item_images)){
                        foreach ($item_images as $xx){
                            if($xx[0] == 1){
                                $default_image = $xx[1];
                            }

                            if($default_image == $no_image){
                                $default_image = $xx[1];
                            }

        //                    if(strpos($default_image,"localhost") > -1){
        //                        $default_image = explode(".",$default_image);
        //                        $default_image = $default_image[0] . "_thumb." . $default_image[1];
        //                    } else {
        //                        $default_image = explode(".",$default_image);
        //                        $default_image = $default_image[0] ."." . $default_image[1] . "_thumb." . $default_image[1];
        //                    }

                        }
                    }
					
					$item_price = $i->item_price;
					$item_id = $i->item_id;
					$item_folder = $i->item_folder;
					$item_kids = $i->item_kids;
					$item_shipping = $i->item_shipping;
					$item_movement = $i->item_movement;
					$item_case = $i->item_case;	
					$item_bracelet = $i->item_bracelet;	
					$item_condition = $i->item_condition;
					$item_desc = $i->item_desc;?>	
					
					<div class="watchlist-container col-xs-6">
						<div>
                                                   
                                                    <div class='watchlist-img-container' style="background:url('<?php echo $default_image; ?>') center center no-repeat; background-size:cover;"></div>
                                                    
						</div>
						<div >
							<b>Watch Name:</b><br><?php echo ucwords($item_name); ?>
						</div>
						<div >
							<b>Brand:</b><br><?php echo ucfirst($item_brand); ?>
						</div>				
						<div >
							<b>Movement:</b><br><?php echo ucfirst(str_replace("_"," ",$item_movement)); ?>
						</div>	
						<div >
							<b>Case Type:</b><br><?php echo ucfirst($item_case); ?>
						</div>	
						<div >
							<b>Bracelet Type:</b><br><?php echo ucfirst($item_bracelet); ?>
						</div>
						<div >
							<b>Year Model:</b><br><?php echo $item_year_model; ?>
						</div>	
						<div >
							<b>Condition:</b><br><?php echo ucfirst($item_condition); ?>
						</div>	
						<div >
							<b>Category:</b><br><?php echo ucfirst($this->function_category->get_category_fields("category_name",$item_category)); ?>
						</div>	
						<div >
							<b>Gender:</b><br><?php echo $gender[(int)$item_gender]; ?>
						</div>	
						<div >
							<b>For Kids:</b><br><?php echo $bool[(int)$item_kids]; ?>
						</div>	
						<div >
							<b>Whole Watch / Parts Only:</b><br><?php echo $whole[(int)$item_wholepart]; ?>
						</div>	
						<div >
							<b>Certificate:</b><br><?php echo $bool[(int)$item_certificate]; ?>
						</div>	
						<div >
							<b>Box:</b><br><?php echo $bool[(int)$item_box]; ?>
						</div>	
						<div >
							<b>Selling Price:</b><br><?php echo $item_price; ?>
						</div>	
						<div class="desc">
							<b>Description:</b><br><?php echo $item_desc; ?>
						</div>																																							
					</div>
				
				<?php
				}

			
			?>
			</div>
		
		</div>
		
			
	</div>

	<?php	
	} else {
		echo "<div class='no_data'>You have 0 watch items in your watchlist to compare.</div>";
	}
	
	?>		


				
