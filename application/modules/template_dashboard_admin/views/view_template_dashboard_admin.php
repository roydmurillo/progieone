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
<div id="homepage"class="row">
		
 		<?php
    	//load sidebar left
		$this->load->module('template_sideleft_dashboard');
		$this->template_sideleft_dashboard->view_template_sideleft_dashboard(); 

		?>
    <div class="col-sm-9 col-md-10 main">
		<div class="title_bar">
			Settings
		</div>
		
		<div id="inner_dashboard">
                        
                        <?php
                        
                        $p = $this->native_session->get("paypal");

                        ?>

                        <div class="paypal-settings settings-wrapper"> 
					<div class="box_title">
						Paypal Settings
					</div>
					<table>
						<tr>
							<td>
                                                            <a class="a_dash" href="javascript:;" title="View all your items in watchlist">
                                                                <input class="p_activated" type="radio" value="1" <?php echo ($p["activate"] == "1") ? "checked": ""; ?> name="paypal_active"> Turn On Paypal
                                                            </a> &nbsp;
                                                            <a class="a_dash" href="javascript:;" title="Browse all latest watches">
                                                                <input  class="p_activated" type="radio" value="0" <?php echo ($p["activate"] == "0") ? "checked": ""; ?> name="paypal_active"> Turn On Free Listing
                                                            </a> 
                                                        </td>
						</tr>
						
                                                
					</table>
                                        <div class="">
                                            <table class="global-price-list-adjustment">
                                                    <tr id="prce" <?php echo ($p["activate"] == "0") ? "style='display:none;'" : ""; ?>>
                                                        <td><label for="paypal_price">Price Per Item:</label></td>
                                                        <td><input type="input" id="paypal_price" value="<?php echo $p["price"]; ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label>Days:</label></td>
                                                        <td><input type="input" id="days" value="<?php echo $p["days"]; ?>"></td>
                                                    </tr>
                                                    <tr class="last-update">
                                                        <td>Last Updated:</td>
                                                        <td> <?php echo date("l jS \of F Y h:i:s A", strtotime($p["date"])); ?></td>
                                                    </tr>                                                    
                                            </table>
                                               
                                            <input type="button" id="submit_changes" class="btn btn-success" value="Save Changes">
                                            <div id="remarks"></div>
                                            
                                            <div id="desc1" style=" <?php echo ($p["activate"] == "1") ? "display:block;" : "display:none;"; ?>">
                                                
                                                This setting is for Paypal price per item and how many days is being covered from the price.
                                                
                                            </div>
                                            
                                            <div id="desc2" style=" <?php echo ($p["activate"] == "0") ? "display:block;" : "display:none;"; ?>">
                                                
                                                This setting is for how many days a free item will be activated.
                                                
                                            </div>
                                            
                                        </div>    

			</div>
                   
    
                    <div class="settings-wrapper"> 
                        <div class="box_title">
                                Registered Users
                        </div>
                           <div class="row">
                               <div class="col-sm-6"> 
                                  Total:
                               </div>
                               <div class="col-sm-6">
                                <?php 
                                $q = $this->db->query("SELECT COUNT(1) as total FROM watch_users");
                                if($q->num_rows() > 0){
                                    $q = $q->result();
                                    echo $q[0]->total . " User/s";
                                }
                                ?>
                               </div>
                           </div>    
                    </div>
                    <div class="settings-wrapper">
                        <div class="box_title">
                                User Settings
                        </div>
                           <table class="table table-striped" width="100%" border="1">
                                <?php 
                                if($users){
                                ?>
                               <thead>
                                   <th>Name</th>
                                   <th>Username</th>
                                   <th>Email</th>
                                   <th>Action</th>
                                   <th>Price</th>
                                </thead>
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
                                            <td><label id="user_price<?php echo $fields['user_id']?>"><?php echo $fields['paypal_price']?></label></td>
                                        </tr>
                                <?php
                                    }
                                ?>       
                           </table>
			</div>
		</div>
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
                            $('#user_price' + $(dis).attr('data-userid')).text($(dis).val());
                        });
                    }
                });
       });
        
</script>
