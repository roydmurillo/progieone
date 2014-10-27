<script type="text/javascript" src="<?php echo base_url(); ?>scripts/json.js"></script>

<?php $this->load->module("function_security"); 
	  $type_add = $this->function_security->encode("update_paypal");
      $type_single = $this->function_security->encode("update_single_paypal");
	  $ajax = $this->function_security->encode("dashboard-ajax"); ?>
<input id="load_initial" type="hidden" value="<?php echo base_url(); ?>dashboard/<?php echo $ajax; ?>">
<input id="type_update" type="hidden" value="<?php echo $type_add; ?>">
<input id="type_single" type="hidden" value="<?php echo $type_single; ?>">
<input id="base_url" type="hidden" value="<?php echo base_url(); ?>">

<!-- content goes here -->
<div id="homepage">
		
 		<?php
    	//load sidebar left
		$this->load->module('template_sideleft_dashboard');
		$this->template_sideleft_dashboard->view_template_sideleft_dashboard(); 

		?>
        
		<div class="title_bar">
			ADMINISTRATOR DASHBOARD
		</div>
		
		<div id="inner_dashboard" style="margin-left: 15px !important; width: 760px !important">
                        
                        <?php
                        
                        $p = $this->native_session->get("paypal");

                        ?>

                        <div style="float: left;
                                    box-shadow: 0px 0px 3px 0px #CCC;
                                    border: 1px solid #999;
                                    height: 300px;
                                    margin: 5px;
                                    position: relative;
                                    width:748px;"> 
					<div class="box_title">
						<div class="inner_title" style="margin-left:16px">Paypal Settings</div>
					</div>
					<table style="margin:12px; float:left;">
						<tr>
							<td><a style="width:170px" class="a_dash" href="javascript:;" title="View all your items in watchlist">
                                                                <label><input class="p_activated" type="radio" value="1" <?php echo ($p["activate"] == "1") ? "checked": ""; ?> name="paypal_active">Turn On Paypal</label>
                                                            </a></td>
						</tr>
						<tr>
							<td><a style="width:170px" class="a_dash" href="javascript:;" title="Browse all latest watches">
                                                                <label><input  class="p_activated" type="radio" value="0" <?php echo ($p["activate"] == "0") ? "checked": ""; ?> name="paypal_active">Turn On Free Listing</a></label></td>
						</tr>
                                                
					</table>
                                        <div style="float:left; margin:12px; width:450px; height:200px; border:1px solid #CCC; padding:5px; position:relative">
                                            <table style="margin-left:12px; float:left; clear:both;">
                                                    <tr id="prce" <?php echo ($p["activate"] == "0") ? "style='display:none;'" : ""; ?>>
                                                        <td>Price Per Item:<br>
                                                            <input type="input" id="paypal_price" value="<?php echo $p["price"]; ?>" style="width:200px; padding:5px 12px"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Days:<br>
                                                            <input type="input" id="days" value="<?php echo $p["days"]; ?>" style="width:200px; padding:5px 12px"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Last Updated:<br>
                                                            <div><?php echo date("l jS \of F Y h:i:s A", strtotime($p["date"])); ?></div></td>
                                                    </tr>                                                    
                                            </table>
                                               
                                            <input type="button" id="submit_changes" class="css_btn_c0" style="float:left; margin:12px 14px; padding:5px 26px;" value="Save Changes">
                                            <div id="remarks" style="float:left; margin:15px 0px 0px 0px; height:30px;width:100px; color:red"></div>
                                            
                                            <div id="desc1" style=" <?php echo ($p["activate"] == "1") ? "display:block;" : "display:none;"; ?>position:absolute; right:12px; top:12px; width:100px;height:100px; color:#555;">
                                                
                                                This setting is for Paypal price per item and how many days is being covered from the price.
                                                
                                            </div>
                                            
                                            <div id="desc2" style=" <?php echo ($p["activate"] == "0") ? "display:block;" : "display:none;"; ?>position:absolute; right:12px; top:12px; width:100px;height:100px; color:#555;">
                                                
                                                This setting is for how many days a free item will be activated.
                                                
                                            </div>
                                            
                                        </div>    

			</div>
                   
    
                       <div style="float: left;
                                    box-shadow: 0px 0px 3px 0px #CCC;
                                    border: 1px solid #999;
                                    height: 200px;
                                    margin: 5px;
                                    position: relative;
                                    width:748px;"> 
					<div class="box_title">
						<div class="inner_title" style="margin-left:16px">Registered Users</div>
					</div>
                           <div style="float:left; margin:12px 20px; width:300px; background:lightblue; height:100px; border:1px solid #555;">
                               <h3 style="float:left; margin:12px; font-famiy:arial; ">Total Registered Users:</h3>
                               <div style="float:left; margin: 0px 20px; clear:both; font-size:20px; color:brown">
                               <?php 
                               $q = $this->db->query("SELECT COUNT(1) as total FROM watch_users");
                               if($q->num_rows() > 0){
                                   $q = $q->result();
                                   echo $q[0]->total . " User/s";
                               }
                               ?>
                               </div>
                               
                           </div>    
                           <div style="float:left; margin:12px 20px; width:300px; background:lightblue; height:100px; border:1px solid #555;">
                               <h3 style="float:left; margin:12px; font-famiy:arial; ">Online Users in the last 24 hours:</h3>
                               <div style="float:left; margin: 0px 20px; clear:both; font-size:20px; color:brown">
                               <?php 
                               $q = $this->db->query("SELECT COUNT(1) as total FROM watch_users WHERE user_logged >= NOW() - INTERVAL 1 DAY;");
                               if($q->num_rows() > 0){
                                   $q = $q->result();
                                   echo $q[0]->total . " User/s Online";
                               }
                               ?>
                               </div>
                               
                           </div> 

                           <table width="100%" border="1">
                                <?php 
                                if($users){
                                ?>
                               <tr>
                                   <td>Name</td>
                                   <td>Username</td>
                                   <td>Email</td>
                                   <td>Action</td>
                               </tr>
                                <?php
                                }
                                    foreach ($users as $nkey1 => $fields){
                                        
                                ?>
                                        <tr>
                                            <td><?php echo ucfirst($fields['user_fname']).' '. ucfirst($fields['user_lname']);?></td>
                                            <td><?php echo ucfirst($fields['user_name'])?></td>
                                            <td><?php echo ucfirst($fields['user_email'])?></td>
                                            <td>
                                                <input type="hidden" id="userid<?php echo $fields['user_id']?>" class="paypal_price" data-userid="<?php echo $fields['user_id']?>" data-listid="<?php echo $fields['user_listprice_id']?>" value="<?php echo $fields['paypal_price']?>">
                                                <a href="Javascript:;" class="userpaypal" id="userpaypal<?php echo $fields['user_id']?>" data-bond="<?php echo $fields['user_id']?>">price</a>
                                                <a href="Javascript:;" class="userdelete" id="userdelete<?php echo $fields['user_id']?>" data-bond="<?php echo $fields['user_id']?>"> | delete</a>
                                                <a href="Javascript:;" class="userblock" id="userblock<?php echo $fields['user_id']?>" data-bond="<?php echo $fields['user_id']?>"> | block</a>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                ?>
                                    
                                
                           </table>

			</div>
                        <!-- 
                        <div style="float: left;
                                    box-shadow: 0px 0px 3px 0px #CCC;
                                    border: 1px solid #999;
                                    height: 250px;
                                    margin: 5px;
                                    position: relative;
                                    width:748px;"> 
					<div class="box_title">
						<div class="inner_title" style="margin-left:16px">Reported Items</div>
					</div>


			</div>
                        -->
		
		</div>
        
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>autonumeric/autoNumeric.js"></script>
<!-- additional scripts -->
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery("#paypal_price").autoNumeric('init',{aSep: ''});
        
                jQuery(".p_activated").click(function(){
                    if(jQuery(this).val() == "1"){
                        jQuery("#prce").show();
                        jQuery("#desc1").show();
                        jQuery("#desc2").hide();
                    } else {
                        jQuery("#prce").hide();
                        jQuery("#desc1").hide();
                        jQuery("#desc2").show();                        
                    }
                });
                jQuery("#submit_changes").click(function(){
                    jQuery("#remarks").html("saving changes pls wait...");
                    
                    if(jQuery("#prce").is(":visible")){
                        var activated = "1";
                        var data_obj = {activated:activated, price:jQuery("#paypal_price").val(), days: jQuery("#days").val()};
			data_obj = jQuery.toJSON(data_obj);
                    } else {
                        var activated = "0";
                        var data_obj = {activated:activated, days: jQuery("#days").val()};
			data_obj = jQuery.toJSON(data_obj);
                    }
                    
                    jQuery.ajax({
                            type: "POST",
                            url: jQuery("#load_initial").val(),
                            cache: false,
                            data: { type:jQuery("#type_update").val(), args:data_obj }
                    }).done(function( msg ) {
                            jQuery("#remarks").html("Successfully Updated!");
                    });
                });
                
                $('.userpaypal').click(function(){
                    
                    var eventtrig = $(this).attr('data-bond');
                    var obj = $('#userid' + eventtrig);
                    
                    if(obj.attr('type') == 'hidden'){
                        obj.attr('type', 'text');
                        $('#userpaypal' + eventtrig).css('display', 'none');
                        $('#userdelete' + eventtrig).css('display', 'none');
                        $('#userblock' + eventtrig).css('display', 'none');
                    }
                });

                $('.userdelete').click(function(){
                    alert('b');
                });

                $('.userblock').click(function(){
                    alert('c');
                });
                
                $('.paypal_price').keydown(function(evt){
                    evt = evt.which || evt.keyCode
                    var dis = this;
                    if(evt == 13){

                        var data_obj = {user_id : $(dis).attr('data-userid'), listprice : $(dis).val(), listid : $(dis).attr('data-listid')}
                        data_obj = $.toJSON(data_obj);

                        jQuery.ajax({
                            type: "POST",
                            url: jQuery("#load_initial").val(),
                            cache: false,
                            data: { type:jQuery("#type_single").val(), args:data_obj }
                        }).done(function( msg ) {
                            $(dis).attr('type', 'hidden');
                            $('#userpaypal' + $(dis).attr('data-userid')).css('display', '');
                            $('#userdelete' + $(dis).attr('data-userid')).css('display', '');
                            $('#userblock' + $(dis).attr('data-userid')).css('display', '');
                        });
                    }
                });
       });
        
</script>
