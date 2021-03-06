<script type="text/javascript" src="<?php echo base_url(); ?>scripts/json.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/administrator.js"></script>

<?php $this->load->module("function_security"); 
    $type_add = $this->function_security->encode("update_paypal");
    $type_single = $this->function_security->encode("update_single_paypal");
    $type_delete = $this->function_security->encode("delete_user");
    $ajax = $this->function_security->encode("dashboard-ajax");
    $type_search_user = $this->function_security->encode("search_user");
?>
<input id="load_initial" type="hidden" value="<?php echo base_url(); ?>dashboard/<?php echo $ajax; ?>">
<input id="type_update" type="hidden" value="<?php echo $type_add; ?>">
<input id="type_single" type="hidden" value="<?php echo $type_single; ?>">
<input id="type_delete" type="hidden" value="<?php echo $type_delete; ?>">
<input id="type_search_user" type="hidden" value="<?php echo $type_search_user; ?>">
<input id="base_url" type="hidden" value="<?php echo base_url(); ?>">

<!-- content goes here -->
<div id="homepage">
		
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
                                            <div class="global-price-list-adjustment">
                                                    <div id="prce" <?php echo ($p["activate"] == "0") ? "style='display:none;'" : ""; ?>>
                                                        <div><label for="paypal_price">Price Per Item:</label></div>
                                                        <div><input type="input" id="paypal_price" value="<?php echo $p["price"]; ?>"></div>
                                                    </div>
                                                    <div>
                                                        <div><label>Days:</label></div>
                                                        <div><input type="input" id="days" value="<?php echo $p["days"]; ?>"></div>
                                                    </div>
                                                    <div class="last-update">
                                                        <div><label>Last Updated:</label></div>
                                                        <div> <?php echo date("l jS \of F Y h:i:s A", strtotime($p["date"])); ?></div>
                                                    </div>                                                    
                                            </div>
                                               
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
                                $q = $this->db->query("SELECT COUNT(1) as total FROM watch_users where is_deleted = '0' ");
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
                                Total listing Monthly
                        </div>
                        <table class="table table-striped" width="100%" border="1">
                            <tr>
                                <td>Date</td>
                                <td>Count</td>
                                <td>Amount</td>
                            </tr>
                            
                                <?php if($listing){
                                    $total_amount = 0;
                                    $total_count = 0;
                                    foreach ($listing as $nkey1 => $val){
                                        $total_amount += $val['amount'];
                                        $total_count += $val['count'];
                                ?>
                                        <tr>
                                            <td><?php echo $nkey1?></td>
                                            <td><?php echo $val['count']?></td>
                                            <td><?php echo $val['amount']?></td>    
                                        </tr>
                                <?php
                                    }
                                ?>
                                        <tr>
                                            <td>Total :</td>
                                            <td><?php echo $total_count?></td>
                                            <td><?php echo $total_amount?></td>
                                        </tr>
                                <?php }else{?>
                                        <tr>
                                            <td colspan="2">no record(s) found.</td>
                                        </tr>
                                <?php }?>
                        </table>
                    </div>
                    <div class="settings-wrapper">
                        <div class="box_title">
                                User Settings
                                <input type="text" id="search_user" placeholder="Input keyword">
                        </div>
                           <table class="table table-striped hidden-xs hidden-sm" width="100%" border="1">
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
                                <tbody id="user_tbody">
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
                                            </td>
                                            <td><label id="user_price<?php echo $fields['user_id']?>"><?php echo $fields['paypal_price']?></label></td>
                                        </tr>
                                <?php
                                    }
                                ?> 
                                </tbody>
                           </table>
                            <div class="user-settings hidden-lg hidden-md">
                                <figure class="thumbnail">

                                    <div class=''>  

                                        <?php
                                        
                                            foreach ($users as $nkey1 => $fields){

                                        ?>
                                                <div class="user-loop">
                                                    <div><strong>name:</strong> <?php echo ucfirst($fields['user_fname']).' '. ucfirst($fields['user_lname']);?></div>
                                                    <div><strong>username:</strong> <?php echo ucfirst($fields['user_name'])?></div>
                                                    <div><strong>email:</strong> <?php echo ucfirst($fields['user_email'])?></div>
                                                    <div>
                                                        <input type="hidden" id="mobileuserid<?php echo $fields['user_id']?>" class="paypal_price" data-userid="<?php echo $fields['user_id']?>" data-listid="<?php echo $fields['user_listprice_id']?>" value="<?php echo $fields['paypal_price']?>">
                                                        <a href="Javascript:;" class="userpaypal" id="mobileuserpaypal<?php echo $fields['user_id']?>" data-bond="<?php echo $fields['user_id']?>">price</a>
                                                        <a href="Javascript:;" class="userdelete" id="mobileuserdelete<?php echo $fields['user_id']?>" data-bond="<?php echo $fields['user_id']?>"> | delete</a>
                                                    </div>
                                                    <div><label id="mobileuser_price<?php echo $fields['user_id']?>"><?php echo $fields['paypal_price']?></label></div>
                                                </div>
                                        <?php
                                            }
                                        ?>    
                                    </div>
                                </figure>
                            </div>

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
                
                $('#user_tbody').on('click', '.userpaypal', function(){
                    
                    var eventtrig = $(this).attr('data-bond');
                    var obj = $('#userid' + eventtrig);
                    
                    if(obj.attr('type') == 'hidden'){
                        obj.attr('type', 'text');
                        $('#userpaypal' + eventtrig).css('display', 'none');
                        $('#userdelete' + eventtrig).css('display', 'none');
                    }
                });

                $('.user-loop').on('click', '.userpaypal', function(){
                    
                    var eventtrig = $(this).attr('data-bond');
                    var obj = $('#mobileuserid' + eventtrig);
                    
                    if(obj.attr('type') == 'hidden'){
                        obj.attr('type', 'text');
                        $('#mobileuserpaypal' + eventtrig).css('display', 'none');
                        $('#mobileuserdelete' + eventtrig).css('display', 'none');
                    }
                });

                $('#user_tbody').on('click' ,'.userdelete' ,function(){
                    if(confirm('Are you sure you want to delete this user?') == true){
                        
                        var data_obj = {user_id : $(this).attr('data-bond')}
                        data_obj = $.toJSON(data_obj);
                        dis = this
                        jQuery.ajax({
                            type: "POST",
                            url: jQuery("#load_initial").val(),
                            cache: false,
                            data: { type:jQuery("#type_delete").val(), args:data_obj }
                        }).done(function( msg ) {
                            $(dis).parent().parent().remove();
                            alert('user successfully deleted.');
                        });
                    }
                });

                $('.user-loop').on('click' ,'.userdelete' ,function(){
                    if(confirm('Are you sure you want to delete this user?') == true){
                        
                        var data_obj = {user_id : $(this).attr('data-bond')}
                        data_obj = $.toJSON(data_obj);
                        dis = this
                        jQuery.ajax({
                            type: "POST",
                            url: jQuery("#load_initial").val(),
                            cache: false,
                            data: { type:jQuery("#type_delete").val(), args:data_obj }
                        }).done(function( msg ) {
                            $(dis).parent().parent().remove();
                            alert('user successfully deleted.');
                        });
                    }
                });
                
                $('#user_tbody').on('keydown' , '.paypal_price', function(evt){
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

                $('.user-loop').on('keydown' , '.paypal_price', function(evt){
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
                            $('#mobileuserpaypal' + $(dis).attr('data-userid')).css('display', '');
                            $('#mobileuserdelete' + $(dis).attr('data-userid')).css('display', '');
                            $('#mobileuser_price' + $(dis).attr('data-userid')).text($(dis).val());
                        });
                    }
                });
       });
        
</script>
