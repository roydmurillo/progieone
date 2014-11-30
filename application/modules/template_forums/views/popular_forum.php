<div class="forum_container">
	
	<div class="forum_title clearfix">
		
		<div class="div_td1">
			
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
					
				    //$count = $this->function_forums->count_reply_by_thread($r->reply_thread_id);
					$title = $this->function_forums->get_thread_fields_by_id("thread_title",$r->reply_thread_id);
					$category_name = $this->function_forums->get_category_name_by_thread_id($r->reply_thread_id);
					$clean_url = $this->function_forums->clean_url($category_name);
					
					echo "<div class='div_td_content clearfix' $class>
					        <div class='f_info' >
					      		<div class='forum_t'><a href='".base_url()."forums/thread/$r->reply_thread_id/".$this->function_forums->clean_url($title)."'>".$title."</a></div>
						  		<div class='forum_d'>Posted at <a style='color:#3e6876' href='".base_url()."forums/category/$clean_url/'>$category_name</a></div>
						  	</div>
                                                <div class='f_info2' >
					      		<div class='forum_count'>".$r->total."</div>";
						  
						   echo "<div class='forum_updated'>".$this->function_forums->last_updated_by_thread($r->reply_thread_id,$r->reply_user_id,$r->reply_date)."</div>";
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
		  echo "<div class='pagination_links' >";
		  if($forum_links){
			  
			  echo $forum_links;
		  }
		  echo "</div>";
?>
	
	
