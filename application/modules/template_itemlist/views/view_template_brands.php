<!-- content goes here -->
<div id="homepage">

		<div class="container">
			<a href="" name="top_link"></a>
			<div class="title_bar">
				WATCH BRANDS
			</div>
			
			<div class="bgaps">
				
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
			
			<div >
			
			
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
					

                         					
						
						
						echo '<div class="brand-box col-xs-12">';
                                                echo '<p><a name="space'.$key.'" class"letter-link">'.$key.'</a></p>';
                                                        echo '<div class="row">';
							$v = trim($val,",");
							$v = explode(",",$val);
							
							foreach($v as $x){
								$data = explode("=",$x);
								@$n = $data[0];
								@$y = $data[1];
								
								echo "<a href='".base_url()."brands?brand=$n' class='col-xs-2'>$y</a>";
							}
                                                        echo "</div>";
						echo '<p><a href="#top_link" class="back-to-top">[ back to top ]</a></p>';	
						echo "</div>";
					
					
				}				

			?>
			
			</div>
			
		</div>
        
</div>