<!-- additional scripts -->
<script type="text/javascript" src="<?php echo base_url(); ?>tinymce/tinymce.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/editor.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/thread_scripts.js"></script>
<div class="clearfix">
    <div class="forum_links col-sm-6">
        <?php $name_category = $this->function_forums->get_category_name_by_thread_id($this->uri->segment(3));
                      $url_category = $this->function_forums->clean_url($name_category);

                      $title = $this->function_forums->get_thread_fields_by_id("thread_title",$this->uri->segment(3));
                      $clean_title = $this->function_forums->clean_url($title);

                      // revoked data when wrong url is supplied
                      if( $clean_title != $this->uri->segment(4)) {
                                    $thread_data = ""; $form_data = "";
                      }
            ?>
            <a href="<?php echo base_url() ?>forums"  style="color:#E56718">Forums</a> › <a href="<?php echo base_url() ?>forums/category/<?php echo $url_category; ?>"  style="color:#E56718"><?php echo $name_category; ?></a> > <?php echo str_replace("-", " ",$this->uri->segment(4)); ?>
    </div>

    <?php
     if($this->function_login->is_user_loggedin() && $thread_data){
    ?>

    <div class="text-right col-sm-6">
        <a class="btn btn-primary" id="post_reply" href="javascript:;">Post a Reply</a>
    </div>
</div>
<div class="forum_reply">
	
	<form method="POST">
	
		<h2 class="h2_title" style="width:100% !important">Post Reply</h2>
		<textarea name="reply_content" id="reply" class="content" style="height:300px;"></textarea>
		<input id="add_reset" type="button" class="css_btn_c0" onclick="reset_data()" value="Reset"/>
		<input id="post_reply_button" class="css_btn_c0" type="button" value="Submit Reply">
		<input name="reply_thread_id" type="hidden" value="<?php echo (int)$this->uri->segment(3); ?>"/>
		<?php
					// aps12
                    //$user_id = $this->function_users->get_user_fields("user_id");
                    $user_id = unserialize($this->native_session->get("user_info"));
					$user_id = $user_id["user_id"];
		?>
		<input name="reply_user_id" type="hidden" value="<?php echo $user_id; ?>"/>
		<input name="reply_category_id" type="hidden" value="<?php echo $this->function_forums->get_thread_fields_by_id("thread_category_id",$this->uri->segment(3)); ?>"/>
		<input name="redirect" type="hidden" value="<?php echo base_url() ?>forums/thread/<?php echo $this->uri->segment(3); ?>/<?php echo $this->uri->segment(4); ?>"/>
		<input id="submit_add_reply" name="submit_add_reply" type="submit" value="Submit Info" style="display:none">
	
	</form>
	
	<a href="javascript:;" id="close_window">Go Back to Current Thread</a>

</div>


<?php } ?>

<div id="forum_content" class="ma-t1em">

	<?php
		  $check = 0;	
		  $ctr = 1;
	      if($thread_data && ($this->uri->segment(6) == "")){
			  $check++;
			  foreach($thread_data->result() as $r){
						
					$user_info = $this->function_users->get_user_fields_by_id(array("user_name", "user_avatar"),$r->thread_user_id);
					if($user_info["user_avatar"] != "") { 
						$img =  "<img style='max-width: 100px;
											max-height: 100px;
											vertical-align: middle;'
									  src='".$user_info["user_avatar"]."'>";
					} else { 
						$img =  "<img style='max-width: 100px;
											max-height: 100px;'
									  src='".base_url()."assets/images/avatar.jpg'>";
					}
					
					echo '<div class="forum_container" style="margin-bottom:15px !important">
						  <div class="forum_title clearfix" style="padding:0px 10px !important">
							<div class="div_td1">
								Posted '.$this->function_forums->last_updated($r->thread_date).' <span style="font-weight:normal !important; font-size:11px !important">( Thread Starter )</span>
							</div>
						</div><!-- forum_title -->';
					echo "<div class='div_td_content thread_start clearfix' >
								
								<div class='col-sm-3'>
									
									<div >
												".$img."
									</div>
									<a  href='".base_url()."member_profile/".$user_info["user_name"]."'>".$user_info["user_name"]."</a>	 
								 
								
								</div>	
								
								<div class='col-sm-9'>
									        ".$r->thread_content."
								</div>									
						  </div>
					</div>";
		
			  		$ctr++;
			  }
			  
		  } 		   	

	      if($form_data){
			  $check++;
			  foreach($form_data->result() as $r){
			  		$user_info = $this->function_users->get_user_fields_by_id(array("user_name", "user_avatar"),$r->reply_user_id);
					if($user_info["user_avatar"] != "") { 
						$img =  "<img style='max-width: 100px; max-height: 100px;' src='".$user_info["user_avatar"]."'>";
					} else { 
						$img =  "<img style='max-width: 100px; max-height: 100px;' src='".base_url()."assets/images/avatar.jpg'>";
					}
					
					echo '<div class="forum_container" style="margin-bottom:15px !important">
					 	  <div class="forum_title clearfix" style="padding:0px 10px !important;">
							<div class="div_td1">
								Posted '.$this->function_forums->last_updated($r->reply_date).'
							</div>
						</div><!-- forum_title -->';					
					echo "<div class='div_td_content clearfix' >
								
								<div class='col-sm-3'>
									
									<div>
												".$img."
									</div>
									<a  href='".base_url()."member_profile/".$user_info["user_name"]."'>".$user_info["user_name"]."</a>	 
								
								</div>	
								
								<div class='col-sm-9'>
									        ".$r->reply_content."
								</div>									
						  </div>
					</div>";
					
			  		$ctr++;
			  }
			  
		  } 
		  echo "<div class='pagination_links' >";
		  if($forum_links){
			  
			  $links = $forum_links->create_links();
            
			  echo $links;
		  }
		  echo "</div>";
		  
		  //no data found
		  if($check == 0){ ?>
				<div class="regular_register red-alert">
						<i class="fa fa-exclamation-triangle"></i> No Data was Found! Please check your URL
														
							
				</div>	
		  <?php				  
		  }
		  
	?>	
</div>