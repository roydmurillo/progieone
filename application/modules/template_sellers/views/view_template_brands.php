<!-- content goes here -->
<div id="homepage" class="clearfix">

		<div class="fleft" style="width:824px; margin-left:70px;">
			<a href="" name="top_link"></a>
			<div class="title_bar" style="width:824px; margin-left:0px;">
				WATCH BRANDS
			</div>
			
			<div class="bgaps" style="float:left; margin-left:0px; margin-top:22px; padding:12px; border:1px solid #CCC; clear:both">
				
				<?php 
					$a = range('A', 'Z');
					foreach($a as $a){
						$array_names["$a"] = "";
						echo "<a href='#space$a' style='float:left; margin:2px 5px;'>$a</a>";
					}
					$array_names["0"] = "";
					$array_names["3"] = "";
					$array_names["8"] = "";
					echo "<a href='#space0' style='float:left; margin:2px 5px;'>0</a>";
					echo "<a href='#space3' style='float:left; margin:2px 5px;'>3</a>";
					echo "<a href='#space8' style='float:left; margin:2px 5px;'>8</a>";
				?>
				
			</div>
			
			<div style="float:left; margin-left:0px; clear:both; position:relative">
			
			
			<?php
				
				$this->load->module("function_brands");
				
				$array = $this->function_brands->watch_brands();
				
				$prev = "";
				
				foreach($array as $key => $val){
					
					$k = strtoupper($val[0]);
					if (array_key_exists($k,$array_names)){
						$array_names[$k] .= $key."=".$val . ",";
					}
				}
				
				foreach($array_names as $key => $val){
					

                         					
						echo '<a name="space'.$key.'" style="float:left; min-height:12px; font-size:20px; width:700px; padding:12px; margin:5px 0px; clear:both;">'.$key.'</a>';
						
						echo '<div style="float:left; min-height:12px; width:820px; padding:12px; margin:12px 0px; clear:both; position:relative; border:1px solid #CCC;">';
							$v = trim($val,",");
							$v = explode(",",$val);
							
							foreach($v as $x){
								$data = explode("=",$x);
								@$n = $data[0];
								@$y = $data[1];
								
								echo "<a href='".base_url()."brands?brand=$n' style='float:left; width:150px; font-family:arial; font-size:12px; overflow:hidden; margin:5px;'>$y</a>";
							}
						echo '<a href="#top_link" style="font-size:12px; font-family:tahoma; color:red; position:absolute; bottom:8px; right:8px">[ back to top ]</a>';	
						echo "</div>";
					
					
				}				

			?>
			
			</div>
			
		</div>
        
</div>