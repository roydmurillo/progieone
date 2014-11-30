<!-- additional scripts -->
<script type="text/javascript" src="<?php echo base_url(); ?>tinymce/tinymce.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/editor.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/startthread_scripts.js"></script>

<div class="forum_new_thread">
	
	<form method="POST">
	
		<h2 class="h2_title" style="width:100% !important">Start A New Thread</h2>
		
		<div >
		<div class="title_thread">Topic</div> 
		<input type="text" name="thread_title" id="thread_title" class="input_thread thread">
		</div>

		<div >
		<div class="title_thread">Select Thread Category</div> 
		<?php if($form_data){ ?>
			
			<select id="thread_category_id" name="thread_category_id" class="input_dropdown thread">
				<option value=""> - Select - </option>
				<?php 
					foreach($form_data->result() as $i){
						echo '<option value="'.$i->category_id.'"> '.$i->category_title.' </option>';												
					}
				?>
			</select>
		
		<?php } ?>	
		</div>
		
		<div >
			<div class="title_thread">Thread Message</div> 
			<div >
			<textarea name="thread_content" id="thread_content" class="content" style="height:300px;"></textarea>
			</div>
		</div>
		<?php
					// aps12
                    //$user_id = $this->function_users->get_user_fields("user_id");
                    $user_id = unserialize($this->native_session->get("user_info"));
					$user_id = $user_id["user_id"];
		?>
		<input name="thread_user_id" type="hidden" value="<?php echo $user_id; ?>"/>
		<input id="add_reset" type="button" class="css_btn_c0 btn btn-primary" onclick="reset_data()" value="Reset"/>
		<input id="post_submit_thread" class="css_btn_c0 btn btn-primary" type="button" value="Submit New Thread">
		<input name="redirect" type="hidden" value="<?php echo base_url() ?>forums/category/"/>
		<input id="submit_add_thread" name="submit_add_thread" type="submit" value="Submit New Thread" style="display:none">
	
	</form>

</div>
