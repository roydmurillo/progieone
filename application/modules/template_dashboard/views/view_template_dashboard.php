<?php 
    $user_id = unserialize($this->native_session->get("user_info"));
    $user_id = $user_id["user_id"];

    $user_info = $this->function_users->get_user_fields_by_id(array("user_phone", "is_show"),$user_id);
    echo "<script>var is_alert = false;</script>";
    if($user_info['user_phone'] != '' && $user_info['is_show'] == 0){
        echo "<script>is_alert = true;</script>";
    }
?>

<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jqplot.donutRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jqplot.highlighter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jqplot.caonvasAxisTickRenderer.min.js"></script>
<link rel="stylesheet" type="text/css" hrf="<?php echo base_url(); ?>styles/jquery.jqplot.min.css" />

<!-- additional scripts -->
<script type="text/javascript">
    if(is_alert === false){
        if(confirm('Phone No. not set do you want to update your profile?') === true){
            window.location = '<?php echo base_url().'dashboard/profile';?>';
        }
    }
	jQuery(document).ready(function(){
		jQuery(".inner_box").click(function(){
			window.location.href = jQuery(this).find(".link").val();
		});
	});
</script>

<!-- content goes here -->
<div id="homepage" class="clearfix">
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
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="panel panel-default">
                    <h2 class="panel-heading">Watchlist</h2>
                    <div class="panel-body">
                        <p>Current watch list: <span class="badge"><?php echo $current_watch_list;?></span></p>
                        <p>Current items for sale: <span class="badge"><?php echo $count_sell_items;?></span></p>
                        <a href="<?php echo base_url(); ?>dashboard/sell/new" title="post new item" class="btn btn-primary btn-green">sell an item</a>
                        <a href="<?php echo base_url(); ?>dashboard/sell/for_sale" title="view item list" class="btn btn-primary">view selling</a>
                        <a href="<?php echo base_url(); ?>dashboard/watchlist" title="view watch list" class="btn btn-primary">view watch list</a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="panel panel-default">
                    <h2 class="panel-heading">Messages</h2>
                    <div class="panel-body">
                        <p>Inbox: <span class="badge"><?php echo $message_count;?></span></p>
                        <p>Unread messages: <span class="badge"><?php echo $message_unread_count;?></span></p>
                        <a href="<?php echo base_url(); ?>dashboard/messages" title="read messages" class="btn btn-primary">read messages</a>
                        <a href="<?php echo base_url(); ?>dashboard/messages/create" title="create new message" class="btn btn-primary">create new message</a>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="panel panel-default">
                    <h2 class="panel-heading">Friends</h2>
                    <div class="panel-body">
                        <p>Current friends: <span class="badge"><?php echo $friends_count;?></span></p>
                        <p>Pending friend request: <span class="badge"><?php echo $count_friend_invites;?></span></p>
                        <a href="<?php echo base_url(); ?>dashboard/friends" title="view friend list" class="btn btn-primary">view friend list</a>
                        <a href="<?php echo base_url(); ?>dashboard/friends/activities" title="view friend updates" class="btn btn-primary">view updates</a>
                        <a href="<?php echo base_url(); ?>dashboard/friends/invites" title="view friend request" class="btn btn-primary">view request</a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="panel panel-default">
                    <h2 class="panel-heading">Forum</h2>
                    <div class="panel-body">
                        <p>Help or ask questions</p>
                        <a href="<?php echo base_url(); ?>forums" title="visit forum" class="btn btn-primary">visit forum</a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <h2 class="panel-heading">Ratings</h2>
                    <div class="panel-body ratings">
                        <p>Like: <span class="badge"><?php echo $count_watch_ratings_like;?></span></p>
                        <p>Dislike: <span class="badge"><?php echo $count_watch_ratings_dislike;?></span></p>
                    </div>
                </div>
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
