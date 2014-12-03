<div class="forum_container">
	
	<div class="forum_title clearfix">
		<div class="hidden-xs">
		<div class="col-sm-8">
			
			Threads
			
		</div>
		<div class="col-sm-2">
			
			Reply Posts
			
		</div>		
		<div class="col-sm-2">
			
			Last Updated
			
		</div>
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
					$category_name = $this->function_forums->get_category_name_by_thread_id($r->thread_id);
					$clean_url = $this->function_forums->clean_url($category_name);
					
					echo "<div class='div_td_content clearfix' $class>
					        <div class='col-sm-8'>
					      		<div class='forum_t'><a href='".base_url()."forums/thread/$r->thread_id/".$this->function_forums->clean_url($r->thread_title)."'>".$r->thread_title."</a></div>
						  		<div class='forum_d'>Posted at <a style='color:#3e6876' href='".base_url()."forums/category/$clean_url/'>$category_name</a></div>
						  	</div>
			                <div class='col-sm-4'>
					      		<div class='col-sm-6'>".$count."</div>";
						  
						   echo "<div class='ol-sm-6'>".$this->function_forums->last_updated_by_thread($r->thread_id,$r->thread_user_id,$r->thread_date)."</div>";
						   echo "</div>
						  </div>";
					
			  		$ctr++;
			  }
			  
		  } else {
		  		
				echo "<div >No Thread Found.</div>";
		  	
		  }
		  
	?>	
		
</div><!-- forum_container -->

<?php
		  echo "<div class='pagination_links'>";
		  if($forum_links){
			  
			  echo $forum_links;
		  }
		  echo "</div>";
?>
	
	
