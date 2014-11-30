<script type="text/javascript" src="<?php echo base_url(); ?>tinymce/tinymce.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/editor3.js"></script>
<input id="base_url" type="hidden" value="<?php echo base_url(); ?>">
<div id="homepage" class="clearfix">
		
 		<?php
    	//load sidebar left
		$this->load->module('template_sideleft_dashboard');
		$this->template_sideleft_dashboard->view_template_sideleft_dashboard(); 
		
		$user_id = unserialize($this->native_session->get("user_info"));
		$user_id = $user_id["user_id"];
		
		$u = $this->function_users->get_user_fields_by_id(array("user_fname","user_lname","user_email","user_country","user_description"),$user_id);
		
		echo "<input type='hidden' id='u_desc' value='".trim($u["user_description"])."'>";							
		
		?>
                <div class="col-sm-9 col-md-10 main">
                        <div class="title_bar">
                                PROFILE INFORMATION
                        </div>



<!--                            <div id="inner_dashboard_tab">

                                    <a href="javascript:;">
                                            <div class="tab_inner_active"> 
                                                    Edit Profile
                                            </div>
                                    </a>


                            </div>-->

                                    <div id="dashboard_content">

                                            <!-- content goes here -->
                                            
                                            <?php if($this->native_session->get("update_profile")){	?>
                                                    <div class="green-alert">
                                                                    
                                                                    <div >
                                                                            Your profile was successfully updated!
                                                                    </div>									

                                                    </div>
                                            <?php $this->native_session->delete("update_profile");} ?>	
                                            <?php if($this->native_session->get("update_profile_error")){	?>
                                            <div class='red-alert'>

                                                            
                                                            <div >
                                                                    <?php 
                                                                    $remarks = $this->native_session->get("update_profile_error");
                                                                    echo $remarks; ?>
                                                            </div>									

                                            </div>
                                            <?php $this->native_session->delete("update_profile_error");} ?>						
                                            <div id="add_new_item">

                                                        <h2><u>Basic Information</u></h2>

                                                            <form method="POST">
                                                            <table class="table_add">
                                                                    <tbody>
                                                                            <tr>
                                                                                    <td><div class="title_thread">First Name</div>
                                                                                    <input type="text" value="<?php echo $u["user_fname"]; ?>" id="user_fname" name="user_fname" class="input"></td>
                                                                            </tr>	
                                                                            <tr>
                                                                                    <td><div class="title_thread">Last Name</div>
                                                                                    <input type="text" value="<?php echo $u["user_lname"]; ?>" id="user_lname" name="user_lname" class="input"></td>
                                                                            </tr>	
                                                                            <tr>
                                                                                    <td><div class="title_thread">Email Address</div>
                                                                                    <input type="hidden" name="original_email" value="<?php echo $u["user_email"]; ?>">
                                                                                    <input type="text" value="<?php echo $u["user_email"]; ?>" id="user_email" name="user_email" class="input"></td>
                                                                            </tr>	

                                                                            <tr>
                                                                                    <td><div class="title_thread">Country</div>
                                                                                    <select id="user_country" name="user_country">
                                                                                            <option value=""> -- Select Country --</option>
                                                                                            <?php 

                                                                                                    $arr = $this->function_country->get_country_array();
                                                                                                    foreach($arr as $key => $val){

                                                                                                            $s = "";
                                                                                                            if($u["user_country"] == $key){
                                                                                                                    $s = 'selected="selected"';
                                                                                                            }

                                                                                                            echo "<option value='$key' $s>$val</option>";

                                                                                                    }

                                                                                            ?>
                                                                                    </select>
                                                                                    </td>
                                                                            </tr>		
                                                                    </tbody>
                                                            </table>

                                                            <h2><u>Change Password (optional)</u></h2>

                                                            <table class="table_add">
                                                                    <tbody>
                                                                            <tr>
                                                                                    <td><div class="title_thread">Old Password</div>
                                                                                    <input type="password" value="" id="user_password" name="user_password" class="input"></td>
                                                                            </tr>	
                                                                            <tr>
                                                                                    <td><div class="title_thread">New Password</div>
                                                                                    <input type="password" value="" id="new_password1" name="user_password1" class="input"></td>
                                                                            </tr>	
                                                                            <tr>
                                                                                    <td><div class="title_thread">Retype New Password</div>
                                                                                    <input type="password" value="" id="new_password2" name="user_password2" class="input"></td>
                                                                            </tr>	
                                                                    </tbody>
                                                            </table>

                                                            <div class="t_area" >
                                                                    <div class="title_thread" >Add Self/Store Description(optional)</div>
                                                                    <div>
                                                                            <textarea id="item_description" name="user_description" ></textarea>
                                                                    </div>
                                                            </div>

                                                            <input class='btn btn-primary' type="button" onclick="reset_data()" value="Reset"/>
                                                            <input id="submit_new_message" class='btn btn-default btn-red' type="button" value="Submit Info">
                                                            <input id="submit_message" name="submit_profile_change" type="submit" value="Submit Info" style="display:none">
                                                    </form>

                                                    </div><!-- add new item -->				

                                    </div>

                            </div>
                </div>
		
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("#submit_new_message").click(function(){
		var err = "";
		if(jQuery("#user_fname").val() == ""){
			err = "First Name is required.\n";
		}
		if(jQuery("#user_lname").val() == ""){
			err += "Last Name is required.\n";
		}
		if(jQuery("#user_email").val() == ""){
			err += "Email is required.\n";
		}		
		if(jQuery("#user_country").val() == ""){
			err += "Country is required.\n";
		}
		
		if(err != ""){
			alert(err);
		} else {
			jQuery("#submit_message").click();
		}		
		
	});
});
jQuery(window).load(function(){
	tinyMCE.get("item_description").setContent(jQuery("#u_desc").val());
});
</script>
