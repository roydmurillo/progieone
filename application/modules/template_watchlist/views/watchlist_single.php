<?php
$item_id = $_POST["args"];
$this->db->where("item_id",$item_id);
$items = $this->db->get("watch_items");
$bool = array( 1 => "Yes", 0 => "No" );
$gender = array( 1 => "Mens", 2 => "Womens" , 3 => "Unisex" );
$whole = array( 1 => "Whole Watch", 0 => "Parts Only" );

if($item_data != ""){?>

	<div style="float:left; width:770px; min-height:500px;">
		
		<!-- content goes here -->
		<h2 class="h2_title" style="margin-top:0px !important;">Watch Item Description</h2>
		
		<div id="single_content" style="float:left; width:100%; min-height:500px">
		
			<div style="float:left; width:120px; margin-left:12px; min-height:500px;">
				
				<div style="float:left; margin:0px; clear:both; width:100%; height:20px; text-align:center; padding:50px 0px; font-size:12px">
				
				</div>
				<div class="bglight" style="float:left; margin:0px; clear:both; width:100px; height:20px; text-align:center; padding:20px 12px; font-size:12px">
					Model Name
				</div>
				<div class="bglight" style="float:left; margin:0px; clear:both; width:100px; height:20px; text-align:center; padding:20px 12px; font-size:12px">
					Brand
				</div>
				<div class="bglight" style="float:left; margin:0px; clear:both; width:100px; height:20px; text-align:center; padding:20px 12px; font-size:12px">
					Movement
				</div>
				<div class="bglight" style="float:left; margin:0px; clear:both; width:100px; height:20px; text-align:center; padding:20px 12px; font-size:12px">
					Case Type
				</div>
				<div class="bglight" style="float:left; margin:0px; clear:both; width:100px; height:20px; text-align:center; padding:20px 12px; font-size:12px">
					Bracelet Type
				</div>
				<div class="bglight" style="float:left; margin:0px; clear:both; width:100px; height:20px; text-align:center; padding:20px 12px; font-size:12px">
					Case Width
				</div>
				<div class="bglight" style="float:left; margin:0px; clear:both; width:100px; height:20px; text-align:center; padding:20px 12px; font-size:12px">
					Case Thickness
				</div>				
				<div class="bglight" style="float:left; margin:0px; clear:both; width:100px; height:20px; text-align:center; padding:20px 12px; font-size:12px">
					Year Model
				</div>								
				<div class="bglight" style="float:left; margin:0px; clear:both; width:100px; height:20px; text-align:center; padding:20px 12px; font-size:12px">
					Item Condition
				</div>	
				<div class="bglight" style="float:left; margin:0px; clear:both; width:100px; height:20px; text-align:center; padding:20px 12px; font-size:12px">
					Category
				</div>	
				<div class="bglight" style="float:left; margin:0px; clear:both; width:100px; height:20px; text-align:center; padding:20px 12px; font-size:12px">
					Gender
				</div>	
				<div class="bglight" style="float:left; margin:0px; clear:both; width:100px; height:20px; text-align:center; padding:20px 12px; font-size:12px">
					For Kids
				</div>
				<div class="bglight" style="float:left; margin:0px; clear:both; width:100px; height:20px; text-align:center; padding:20px 12px; font-size:12px">
					Whole Watch / Parts Only
				</div>
				<div class="bglight" style="float:left; margin:0px; clear:both; width:100px; height:20px; text-align:center; padding:20px 12px; font-size:12px">
					With Certificate
				</div>
				<div class="bglight" style="float:left; margin:0px; clear:both; width:100px; height:20px; text-align:center; padding:20px 12px; font-size:12px">
					With Box
				</div>	
				<div class="bglight" style="float:left; margin:0px; clear:both; width:100px; height:20px; text-align:center; padding:20px 12px; font-size:12px">
					Classified Price
				</div>	
				<div class="bglight" style="float:left; margin:0px; clear:both; width:100px; height:20px; text-align:center; padding:46px 12px; font-size:12px">
					Description
				</div>																																								

			</div>

			<div style="float:left; width:508px; margin-left:10px; min-height:500px;">
			
			
			<?php
			
			if($items->num_rows() > 0){
				$item_data = $items->result();
				// parse data
				foreach($item_data as $i){
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
					$count = count($item_images) - 1;
					$image = $item_images[rand(0,$count)];
					
								//if no image
					if($image == "" || $image === false || empty($image)){
						$image = base_url() . "assets/images/no-image.png";
					} else {
						if(strpos($image,"localhost") > -1){
							$image = explode(".",$image);
							$image = $image[0] . "_thumb." . $image[1];
						} else {
							$image = explode(".",$image);
							$image = $image[0] ."." . $image[1] . "_thumb." . $image[2];
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
					$item_case_width = $i->item_case_width;	
					$item_case_thickness = $i->item_case_thickness;	
					$item_condition = $i->item_condition;
					$item_desc = $i->item_desc;?>	
					
					<div style="float:left; width:200px; margin:0px; font-family:arial;">
						<div style="float:left; margin:0px; clear:both; width:100%; height:120px; text-align:center; font-size:12px">
								
								<div style="margin:-5px 12px 12px; border:1px solid #CCC; line-height:117px; float:left; overflow:hidden; height:120px; width:200px; text-align:center">
									<img src="<?php echo $image; ?>" style="max-height:120px; max-width:150px; line-height:100px; vertical-align:middle;">
								</div>
							
						</div>
						<div style="float:left; margin:0px; clear:both; width:100%; height:46px; text-align:center; padding:5px 12px; font-size:12px; border:2px solid #FFF; background:ghostwhite">
							<?php echo ucwords($item_name); ?>
						</div>
						<div style="float:left; margin:0px; clear:both; width:100%; height:46px; text-align:center; padding:5px 12px; font-size:12px; border:2px solid #FFF; background:ghostwhite">
							<?php echo ucfirst($item_brand); ?>
						</div>				
						<div style="float:left; margin:0px; clear:both; width:100%; height:46px; text-align:center; padding:5px 12px; font-size:12px; border:2px solid #FFF; background:ghostwhite">
							<?php echo ucfirst(str_replace("_"," ",$item_movement)); ?>
						</div>	
						<div style="float:left; margin:0px; clear:both; width:100%; height:46px; text-align:center; padding:5px 12px; font-size:12px; border:2px solid #FFF; background:ghostwhite">
							<?php echo ucfirst($item_case); ?>
						</div>	
						<div style="float:left; margin:0px; clear:both; width:100%; height:46px; text-align:center; padding:5px 12px; font-size:12px; border:2px solid #FFF; background:ghostwhite">
							<?php echo ucfirst($item_bracelet); ?>
						</div>	
						<div style="float:left; margin:0px; clear:both; width:100%; height:46px; text-align:center; padding:5px 12px; font-size:12px; border:2px solid #FFF; background:ghostwhite">
							<?php echo $item_case_width; ?> mm
						</div>	
						<div style="float:left; margin:0px; clear:both; width:100%; height:46px; text-align:center; padding:5px 12px; font-size:12px; border:2px solid #FFF; background:ghostwhite">
							<?php echo $item_case_thickness; ?> mm
						</div>	
						<div style="float:left; margin:0px; clear:both; width:100%; height:46px; text-align:center; padding:5px 12px; font-size:12px; border:2px solid #FFF; background:ghostwhite">
							<?php echo $item_year_model; ?>
						</div>	
						<div style="float:left; margin:0px; clear:both; width:100%; height:46px; text-align:center; padding:5px 12px; font-size:12px; border:2px solid #FFF; background:ghostwhite">
							<?php echo ucfirst($item_condition); ?>
						</div>	
						<div style="float:left; margin:0px; clear:both; width:100%; height:46px; text-align:center; padding:5px 12px; font-size:12px; border:2px solid #FFF; background:ghostwhite">
							<?php echo ucfirst($this->function_category->get_category_fields("category_name",$item_category)); ?>
						</div>	
						<div style="float:left; margin:0px; clear:both; width:100%; height:46px; text-align:center; padding:5px 12px; font-size:12px; border:2px solid #FFF; background:ghostwhite">
							<?php echo $gender[(int)$item_gender]; ?>
						</div>	
						<div style="float:left; margin:0px; clear:both; width:100%; height:46px; text-align:center; padding:5px 12px; font-size:12px; border:2px solid #FFF; background:ghostwhite">
							<?php echo $bool[(int)$item_kids]; ?>
						</div>	
						<div style="float:left; margin:0px; clear:both; width:100%; height:46px; text-align:center; padding:5px 12px; font-size:12px; border:2px solid #FFF; background:ghostwhite">
							<?php echo $whole[(int)$item_wholepart]; ?>
						</div>	
						<div style="float:left; margin:0px; clear:both; width:100%; height:46px; text-align:center; padding:5px 12px; font-size:12px; border:2px solid #FFF; background:ghostwhite">
							<?php echo $bool[(int)$item_certificate]; ?>
						</div>	
						<div style="float:left; margin:0px; clear:both; width:100%; height:46px; text-align:center; padding:5px 12px; font-size:12px; border:2px solid #FFF; background:ghostwhite">
							<?php echo $bool[(int)$item_box]; ?>
						</div>	
						<div style="float:left; margin:0px; clear:both; width:100%; height:46px; text-align:center; padding:5px 12px; font-size:12px; border:2px solid #FFF; background:ghostwhite">
							<?php echo $item_price; ?>
						</div>
						<div class="desc" style="float:left; margin:0px; clear:both; width:100%; height:100px; overflow:auto; text-align:center; padding:5px 12px; font-size:12px; border:2px solid #FFF; background:ghostwhite">
							<?php echo $item_desc; ?>
						</div>																																													
					</div>
				
				<?php
				}
			}
			
			?>
							

			
			</div>
		
		</div>
		
			
	</div>

<?php
}
?>
		


				
