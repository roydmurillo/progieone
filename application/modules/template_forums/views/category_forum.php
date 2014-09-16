<div class="forum_links">
	<a href="<?php echo base_url() ?>forums" style="color:#E56718">Forums</a> › <?php echo str_replace("-", " ",$this->uri->segment(3)); ?>
</div>
<div class="forum_container">
	
	<div class="forum_title">
		
		<div class="div_td1" style="width:480px !important">
			
			Threads
			
		</div>
		<div class="div_td2">
			
			Reply Posts
			
		</div>		
		<div class="div_td3">
			
			Last Updated
			
		</div>						
			
	</div><!-- forum_title -->
	
	<?php
	      if($form_data){
			  $ctr = 1;
			  foreach($form_data->result() as $r){
			  		if ($ctr % 2 == 0) {
						$class="style='background:url(".base_url()."assets/images/even.png) repeat'";
					} else {
						$class='';
					}
				    $count = $this->function_forums->count_reply_by_thread($r->thread_id);
					(int)$count = (int)$count + 1;
					
					echo "<div class='div_td_content' $class>
					        <div class='f_info' style='min-height:30px !important; width:470px !important'>
					      		<div class='forum_t'><a href='".base_url()."forums/thread/$r->thread_id/".$this->function_forums->clean_url($r->thread_title)."'>".$r->thread_title."</a></div>
						  	</div>
			                <div class='f_info2' style='min-height:30px !important; width:250px !important'>
					      		<div class='forum_count'>".$count."</div>";
						  
						   echo "<div class='forum_updated'>".$this->function_forums->last_updated_by_thread($r->thread_id,$r->thread_user_id,$r->thread_date)."</div>";
						   echo "</div>
						  </div>";
			  		$ctr++;
			  }
			  
		  } else {
		  		
				echo "<div style='margin:12px 0px 0px 50px; color:red; float:left; font-family:verdana; font-size:14px'>No Thread Found.</div>";
		  	
		  }
	?>	
		
</div><!-- forum_container -->
	
	
