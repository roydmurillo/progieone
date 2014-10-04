<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jqplot.donutRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jqplot.highlighter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jqplot.canvasAxisTickRenderer.min.js"></script>
<link rel="stylesheet" type="text/css" hrf="<?php echo base_url(); ?>styles/jquery.jqplot.min.css" />

<!-- additional scripts -->
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery(".inner_box").click(function(){
			window.location.href = jQuery(this).find(".link").val();
		});
	});
</script>

<!-- content goes here -->
<div id="homepage" class="row">
<?php
		$week_number = date("W");
		$year = date("Y");
		$month = date("F");
		$arr = array();
		$country = "";
		//
		// this is for viewing views
		//
		for($day=1; $day<=7; $day++)
		{
			$dy = date('d', strtotime($year."W".$week_number.$day))."\n";
			$date1 = date("Y-m-d H:i:s", strtotime($year."W".$week_number.$day))."\n";

			$dy = (int)$dy;

			if($day == 1) {
				 $first = $dy;
				 $first_date = $date1;
			}
			
			if($day == 7) {
				$last = $dy;
				$last_date = $date1;
			}
			

			
			echo "<input type='hidden' id='day".$day."' value='$dy'>";
			$arr[(int)$dy] = 0;
			$arr2[(int)$dy] = 0;
		}
		$result = $this->function_views->get_item_views();
		if($result){
			foreach($result as $r){
				$arr[(int)date('d',strtotime($r->view_date))]++; 
				$country = $country ."-". $r->view_country;
			}
			foreach($arr as $key => $val){
				echo "<input type='hidden' class='view".$key."' value='$val'>";
			}
		}

		//
		// this is for viewing inquiries
		//
		$result = $this->template_inquiry->get_item_inquiry();
		$country2 = "";
		if($result){
			foreach($result as $r){
				$arr2[(int)date('d',strtotime($r->inquiry_date))]++; 
				$country2 = $country2 ."-". $r->inquiry_country;
			}
			foreach($arr2 as $key => $val){
				echo "<input type='hidden' class='inquiry".$key."' value='$val'>";
			}
		}
		
		//new threads per week
		$total_count = 1;
		$total = $this->db->query("SELECT COUNT(1) as total FROM watch_forum_thread
								   WHERE thread_date >= '$first_date' AND thread_date <= '$last_date'");
		if($total->num_rows() > 0){
			foreach($total->result() as $t){
				if($t->total != 0){
					$total_count = $t->total;
				}
			} 
		}   
		echo "<input type='hidden' id='new_thread1' value='$total_count'>";		
		
		// get total count for popular
		$total_count = 1;
		$total = $this->db->query("SELECT COUNT(1) as total FROM watch_forum_reply WHERE reply_date >= '$first_date' AND reply_date <= '$last_date'");
		if($total->num_rows() > 0){
			foreach($total->result() as $t){
				if($t->total != 0){
					$total_count = $t->total;
				}
			} 
		}   
		echo "<input type='hidden' id='popular_thread1' value='$total_count'>";	

		
		// get total count your thread
		$user_id = unserialize($this->native_session->get("user_info"));
		$user_id = $user_id["user_id"];
		$total_count = 0;
		$total = $this->db->query("SELECT COUNT(1) as total FROM watch_forum_thread
								   WHERE thread_user_id = $user_id
								   AND thread_date >= '$first_date' AND thread_date <= '$last_date'");
		if($total->num_rows() > 0){
			foreach($total->result() as $t){
				if($t->total != 0){
					$total_count = $t->total;
				}
			} 
		}   
		echo "<input type='hidden' id='your_thread1' value='$total_count'>";
				

?>
		
 		<?php
                //load sidebar left
		$this->load->module('template_sideleft_dashboard');
		$this->template_sideleft_dashboard->view_template_sideleft_dashboard(); 

		?>
    <div class="col-sm-9 col-md-10 main">
		
		<div id="inner_dashboard" style="margin-left: 15px !important; width: 760px !important">
                    
			<div class="inner_box"> 
			    <input type="hidden" class="link" value="<?php echo base_url(); ?>dashboard/watchlist">
					<div class="box_title">
						<img class="icon_inner img_title" src="<?php echo base_url(); ?>assets/images/list.png"><div class="inner_title">Watchlist</div>
					</div>
					<table>
						<tr>
							<td><a class="a_dash" href="<?php echo base_url(); ?>dashboard/watchlist" title="View all your items in watchlist">Browse Your Watchlist</a></td>
						</tr>
						<tr>
							<td><a class="a_dash" href="<?php echo base_url(); ?>dashboard/watchlist/compare" title="Browse all latest watches">Compare Watchlist</a></td>
						</tr>
					</table>
					<div class="chart_info">Latest on Your Watchlist</div>
					<div class="chart">
					
						<?php
						    // aps12
							//$user_id = $this->function_users->get_user_fields("user_id");
							$user_id = unserialize($this->native_session->get("user_info"));
							$userid = $user_id["user_id"];
							
							$result = $this->db->query("SELECT * FROM watch_watchlist WHERE watchlist_user_id = $userid ORDER By watchlist_Date DESC LIMIT 1");
							
							if($result->num_rows() > 0){
							
								$r = $result->result();
								
								$this->db->where("item_id",$r[0]->watchlist_item_id);
								$item = $this->db->get("watch_items");
								$i = $item->result();
								$images = unserialize($i[0]->item_images);
								
								$img = $images[rand(0, count($images) - 1)];
								
								echo "<div style='float:left;width:100%; height:100%'>
										<div style='float:left; margin-left:12px; overflow:hidden; width:80px; height:80px; text-align:center; line-height:75px; background:white; border:1px solid #CCC'>
											<img src='$img' style='max-height:80px; max-width:80px; vertical-align:middle'>
										</div>
										<div style='float:left; width:93px; height:110px; overflow:hidden; margin-left:8px; font-size:13px; font-family:arial; '><b>Watch Name:</b><br>".
											@$i[0]->item_name
										."</div>
									  </div>";
							} else {
							echo "<div style='float:left;width:100%; height:100%'>
									<div style='float:left; width:193px; color:red; height:110px; margin-left:15px; font-size:13px; font-family:arial; '>
										You have 0 items in your watchlist.
									</div>
								  </div>";							
							}
						?>
						
						

					</div>
			</div>
			<div class="inner_box"> 
			    <input type="hidden" class="link" value="<?php echo base_url(); ?>dashboard/messages">
				<div class="box_title">
					<img class="icon_inner img_title" src="<?php echo base_url(); ?>assets/images/mail.png"><div class="inner_title">Messages</div>
				</div>
				<table>
					<tr>
						<td><a class="a_dash" href="<?php echo base_url(); ?>dashboard/messages/" title="View Inbox Messages">Message Inbox</a></td>
					</tr>
					<tr>
						<td><a class="a_dash" href="<?php echo base_url(); ?>dashboard/messages/create" title="Create New Message">Create New Message</a></td>						
					</tr>
				</table>
					<div class="chart_info">Latest On Your Inbox</div>
					<div class="chart">
					
						<?php
							//aps12
							//$userid = $this->function_users->get_user_fields("user_id");

							$str = "Select * From watch_messages 
											 Where message_date In(
												Select Max(message_date)
												From watch_messages
												WHERE  message_recipient_id = $userid
												Group By message_parent_id
											) AND message_recipient_id = $userid AND message_trash <> '1' ORDER BY message_date DESC LIMIT 1";
						
							$query = $this->db->query($str);							
							
							if($query->num_rows() > 0){
								$result = $query->result();
								$user_info = $this->function_users->get_user_fields_by_id(array("user_name","user_avatar"),$result[0]->message_user_id);
								if($user_info["user_avatar"] != ""){
								   $im = $user_info["user_avatar"];
								} else {
								   $im = base_url()."assets/images/avatar.jpg";
								} 
								echo "<div style='float:left;width:100%; height:100%'>
										<div style='float:left; margin-left:12px; overflow:hidden; width:80px; height:80px; text-align:center; line-height:75px; background:white; border:1px solid #CCC'>
											<img src='".$im."' style='max-height:80px; max-width:80px; vertical-align:middle'>
										</div>
										<div style='float:left; width:93px; height:120px; margin-left:8px; font-size:13px; font-family:arial;'><b>From:</b><br>".
											$user_info["user_name"]
										."<br><br><b>Subject:</b><br>".substr($result[0]->message_title,0,30)."...</div>
									  </div>";								
							} else {
							echo "<div style='float:left;width:100%; height:100%'>
									<div style='float:left; width:193px; color:red; height:120px; margin-left:25px; font-size:13px; font-family:arial; '>
										You have 0 messages.
									</div>
								  </div>";								
							}
						?>

					</div>
			</div>
			<div class="inner_box"> 
			    <input type="hidden" class="link" value="<?php echo base_url(); ?>dashboard/sell">
				<div class="box_title">
					<img class="icon_inner img_title" src="<?php echo base_url(); ?>assets/images/sell.png"><div class="inner_title">Sell Watch Items</div>
				</div>
				<table>
					<tr>
						<td><a class="a_dash" href="<?php echo base_url(); ?>dashboard/sell/for_sale" title="View all Items Sold">Item Listings</a></td>
					</tr>
					<tr>
						<td><a class="a_dash" href="<?php echo base_url(); ?>dashboard/sell/new" title="Add new Watch to Sell">Sell New Watch</a></td>
					</tr>
                                        <?php if($this->function_paypal->check_active()){ ?>
					<tr>
						<td><a class="a_dash" href="<?php echo base_url(); ?>dashboard/checkout" title="Checkout Watch Items">Checkout</a></td>
					</tr>	
                                        <?php } ?>
				</table>
				<div class="chart_info">Weekly View Count<br><?php echo date("F") ." ".trim($first)." - ". trim($last).", " . date("Y");  ?></div>
				<div class="chart_origin">
					Origin of Views<br>
					<?php 
					    if($country){
							$country = trim($country,"-");
							$country = explode("-", $country);
							$check = array();
							$ctr=1;
							foreach($country as $c){
								if(!in_array($c, $check) && $ctr <= 12){
									$check[] = $c;
									echo "<div class='flag flag-".strtolower($c)."' style='margin:2px;' title='".$this->function_country->get_country_name($c)."'></div>";
								}
								$ctr++;
							}
						} else {
							echo "<span style='color:red'>You have 0 weeky views.</span>";
						}
					?>
					
				
				</div>
				<div id="chart1" class="chart"></div>
			</div>
			<div class="inner_box"> 
   			    <input type="hidden" class="link" value="<?php echo base_url(); ?>dashboard/inquiry">
				<div class="box_title">
					<img class="icon_inner img_title" src="<?php echo base_url(); ?>assets/images/inquiry.png"><div class="inner_title">Inquiry</div>
				</div>
				<table>
					<tr>
						<td><a class="a_dash" href="<?php echo base_url(); ?>dashboard/inquiry" title="View all Watches Bought">Inquiries To Your Watches</a></td>
					</tr>
					<tr>
						<td><a class="a_dash" href="<?php echo base_url(); ?>dashboard/inquiry/being_watched" title="View all Watches Bought">Your Items Being Watch</a></td>
					</tr>					
				</table>
				<div class="chart_info">Weekly Inquiry Count<br><?php echo date("F") ." ".trim($first)." - ". trim($last).", " . date("Y");  ?></div>
					<div class="chart_origin">
					Origin of Inquiries<br>
					<?php 
						if($country2){
						$country2 = trim($country2,"-");
						$country2 = explode("-", $country2);
						$check = array();
						$ctr=1;
						foreach($country2 as $c){
							if(!in_array($c, $check) && $ctr <= 12){
								$check[] = $c;
								echo "<div class='flag flag-".strtolower($c)."' style='margin:2px;' title='".$this->function_country->get_country_name($c)."'></div>";
							}
							$ctr++;
						}
						} else {
							echo "<span style='color:red'>You have 0 weekly inquiries.</span>";
						}
					?>
				</div>
				<div id="chart2" class="chart"></div>
			</div>
			<div class="inner_box"> 
   			    <input type="hidden" class="link" value="<?php echo base_url(); ?>dashboard/friends">
				<div class="box_title">
					<img class="icon_inner img_title" src="<?php echo base_url(); ?>assets/images/friends.png"><div class="inner_title">Friends</div>
				</div>	
				<table>
					<tr>
						<td><a class="a_dash" href="<?php echo base_url(); ?>dashboard/friends" title="View all your items in watchlist">Browse all Friends</a></td>
					</tr>
					<tr>
						<td><a class="a_dash" href="<?php echo base_url(); ?>dashboard/friends/activities" title="Browse all latest watches">View Recent Activities</a></td>
					</tr>
					<tr>
						<td><a class="a_dash" href="<?php echo base_url(); ?>dashboard/friends/invites" title="View all your friend invites.">Friend Invites</a></td>
					</tr>
				</table>
				<div class="chart_info">Latest Friend Invites:</div>
				<div class="chart" style="height:160px !important; bottom:-17px !important">
				
				<?php
				// latest friend invite
				$invite = $this->db->query("SELECT friend_user_id FROM watch_friends WHERE friend_friend_id = $userid AND friend_accepted = 0 LIMIT 1");
				if($invite->num_rows() > 0){
					$invite = $invite->result();
					$ui = $this->function_users->get_user_fields_by_id(array("user_name","user_avatar"),$invite[0]->friend_user_id);
						if($ui["user_avatar"] != ""){
						   $im = $ui["user_avatar"];
						} else {
						   $im = base_url()."assets/images/avatar.jpg";
					    } 
					
					echo "<div style='float:left;width:100%; height:100%; margin-left:12px;'>
							<div style='float:left; margin-left:12px; overflow:hidden; width:80px; height:80px; text-align:center; line-height:75px; background:white; border:1px solid #CCC'>
								<img src='".$im."' style='max-height:80px; max-width:80px; vertical-align:middle'>
							</div>
							<div style='float:left; width:93px; height:120px; margin-left:8px; font-size:13px; font-family:arial;'><b>From:</b><br>".
								$ui["user_name"]
							."<br><br></div>
						  </div>";
										
				} else {
					echo "<div style='float:left;width:100%; height:100%; margin-left:12px;'>
						<div style='float:left; width:193px; color:red; height:110px; margin-left:15px; font-size:13px; font-family:arial; '>
							You have 0 friend invitations.
						</div>
					  </div>";	
				
				}
				
				?>
				
				
				</div>				
			</div>
			<div class="inner_box"> 
   			    <input type="hidden" class="link" value="<?php echo base_url(); ?>forums">
				<div class="box_title">
					<img class="icon_inner img_title" src="<?php echo base_url(); ?>assets/images/forum.png"><div class="inner_title">Forums</div>
				</div>	
				<table>
					<tr>
						<td><a class="a_dash" href="<?php echo base_url(); ?>forums/your_thread" title="View All Your Threads">
						<div class="square" style="background:#eaa228"></div>Your Threads</a></td>
					</tr>
					<tr>
						<td><a class="a_dash" href="<?php echo base_url(); ?>forums/popular" title="Browse Popular Threads">
						<div class="square" style="background:#579575; margin-bottom:10px !important;"></div>Popular Threads</a></td>
					</tr>
					<tr>
						<td><a class="a_dash" href="<?php echo base_url(); ?>forums/new" title="Browse Latest Threads">
						<div class="square" style="background:#c5b47f"></div>New Threads</a></td>
					</tr>	
					<tr>
						<td><a class="a_dash" href="<?php echo base_url(); ?>forums/start_thread" title="Start a New Thread">Start a New Thread</a></td>
					</tr>	
				</table>
				<div class="chart_info">Weekly Forum Activities<br><?php echo date("F") ." $first-$last, " . date("Y");  ?></div>
				<div id="forum" class="chart" style="height:160px !important; bottom:-17px !important"></div>
			</div>
		
		</div>
    </div>
</div>

<!-- additional scripts -->
<script type="text/javascript">
	jQuery(document).ready(function(){
        jQuery.jqplot.config.enablePlugins = true;
        var s1 = [jQuery(".view"+jQuery("#day1").val()).val(), jQuery(".view"+jQuery("#day2").val()).val(), jQuery(".view"+jQuery("#day3").val()).val(), jQuery(".view"+jQuery("#day4").val()).val(),jQuery(".view"+jQuery("#day5").val()).val(),jQuery(".view"+jQuery("#day6").val()).val(),jQuery(".view"+jQuery("#day7").val()).val()];
        var ticks = [jQuery("#day1").val(), jQuery("#day2").val(), jQuery("#day3").val(), jQuery("#day4").val(), jQuery("#day5").val(), jQuery("#day6").val(), jQuery("#day7").val()];
        plot1 = jQuery.jqplot('chart1', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !jQuery.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:jQuery.jqplot.AxisRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: jQuery.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                }
            },
            highlighter: { show: false }
        });
     
        jQuery('#chart1').bind('jqplotDataClick',
            function (ev, seriesIndex, pointIndex, data) {
                jQuery('#info1').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
            }
        );

       var s2 = [jQuery(".inquiry"+jQuery("#day1").val()).val(), jQuery(".inquiry"+jQuery("#day2").val()).val(), jQuery(".inquiry"+jQuery("#day3").val()).val(), jQuery(".inquiry"+jQuery("#day4").val()).val(),jQuery(".inquiry"+jQuery("#day5").val()).val(),jQuery(".inquiry"+jQuery("#day6").val()).val(),jQuery(".inquiry"+jQuery("#day7").val()).val()];
       plot1 = jQuery.jqplot('chart2', [s2], {
            animate: !jQuery.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:jQuery.jqplot.AxisRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: jQuery.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                }
            },
            highlighter: { show: false }
        });
     
        jQuery('#chart2').bind('jqplotDataClick',
            function (ev, seriesIndex, pointIndex, data) {
                jQuery('#info2').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
            }
        );	
	
  var s1 = [['2',0],['YourThread',parseInt(jQuery("#your_thread1").val())], ['NewThread',parseInt(jQuery("#new_thread1").val())], ['PopularThread',parseInt(jQuery("#popular_thread1").val())]];
         
    var plot8 = $.jqplot('forum', [s1], {
        grid: {
            drawBorder: false,
            drawGridlines: false,
            shadow:false
        },
        axesDefaults: {
             
        },
        seriesDefaults:{
            renderer:$.jqplot.PieRenderer,
            rendererOptions: {
                showDataLabels: true
            }
        },
        legend: {
            show: false,
            rendererOptions: {
                numberRows: 1
            },
            location: 's'
        }
    }); 
		
	});
</script>
