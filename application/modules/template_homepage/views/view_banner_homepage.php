<style>
.inactive{
	display:none;
	z-index:0;
}
.current{
	z-index:1;
}
</style>
<div id="home_banner">
	
    <div class="inside_banner">
    	
        <div class="left_arrow">
                 <a href="javascript:;"><img alt="previous" src="<?php echo base_url() ?>assets/images/prev.png" /></a>
        </div>
        
        <div id="inner_banner">
        	

            <div class="inner_banner inactive">
				
				<div class="images_banner">
                    <img alt="Deal of the day" src="<?php echo base_url() ?>assets/images/cwcafe_traffic.png" />
                    <img alt="Cyberwatchcafe" src="<?php echo base_url() ?>assets/images/cw2.png" style="width:160px; margin-left:-19px;" />
				</div>
				<div class="details_banner">
                	<h1 class="title_1">Get Traffic!</h1>
                	<h1 class="title_2">Advertise With Us!</h1>
                	<p class="msg_p">
						We like to help businesses from small, medium and large scale businesses to boost up their website traffic.
						We have website advertisement services that will help your businesses get additional traffic.
                    </p>
                    <a href="<?php echo base_url() ?>advertise" class="btn_lite css_btn_c0" style="padding:0px">READ MORE!</a>
                </div>
                            
            </div>	
            <div class="inner_banner current">
				
				<div class="images_banner">
                    <img alt="Deal of the Day" src="<?php echo base_url() ?>assets/images/cwcafe_about.png" />
                    <img alt="Cyberwatchcafe" src="<?php echo base_url() ?>assets/images/cw1.png" />
				</div> 
				<div class="details_banner">
                	<h1 class="title_1">Cyberwatchcafe</h1>
                	<h1 class="title_2">About Us</h1>
                	<p class="msg_p">
						Cyberwatchcafe is a place for all the watch enthusiast who wants to buy and sell brandnew and pre-owned watches.<br>
						We highly encourage watch enthusiast to become a member to our site and connect to other watch enthusiast all over the world.
						
 
                    </p>
                    <a href="<?php echo base_url() ?>about_us" class="btn_lite css_btn_c0" style="padding:0px">MORE ABOUT US!</a>
                </div>
                            
            </div>
            <div class="inner_banner inactive">
				
				<div class="images_banner">
                    <img alt="deal of the day" src="<?php echo base_url() ?>assets/images/cwcafe_member.png" style="float:left" />
                    <img alt="Cyberwatchcafe" src="<?php echo base_url() ?>assets/images/cw3.png" style="float:left; max-height:500px; width:180px; margin-left:-30px; margin-top:-35px;" />
				</div>
				<div class="details_banner">
                	<h1 class="title_1">You are Invited!</h1>
                	<h1 class="title_2">Be a Member</h1>
                	<p class="msg_p">
						Here at cyberwatchcafe, we highly encourage watch enthusiast to become part of our online community! You can register 
						for free and avail our website amenities that will help you buy and sell your watches and get more cafe friends at the
						same time!
                    </p>
                    <a href="<?php echo base_url() ?>secure/register" class="btn_lite css_btn_c0" style="padding:0px">REGISTER NOW!</a>
                </div>
                            
            </div>						
        
        </div>

        <div class="right_arrow">
                 <a href="javascript:;"><img alt="next" src="<?php echo base_url() ?>assets/images/next.png" /></a>
        </div>
    
    </div>

</div>
<script type="text/javascript">
jQuery(document).ready(function(){
	var tid = setInterval(swap, 5000);
	
	var animate = 0;
	
	function swap() {
		    animate = 1;
			var first = jQuery(".current");
			if(first.nextAll(".inner_banner").eq(0).length > 0){
				var next = first.nextAll(".inner_banner").eq(0);
			} else {
				var next = jQuery(".inner_banner:first");
			}
			if(next.length > 0){
				first.animate({opacity:0},1600,function(){
					
					first.removeClass("current");
					first.addClass("inactive");
				});
					next.css("opacity","0");
					next.addClass("current");
					next.removeClass("inactive");
					next.animate({opacity:1},2200,function(){animate = 0;});
			}
	}
	
	
	jQuery(".left_arrow").click(function(){
		if(animate == 0){
			animate = 1;	
			clearInterval(tid);
			var first = jQuery(".current");
			if(first.prevAll(".inner_banner").eq(0).length > 0){
				var next = first.prevAll(".inner_banner").eq(0);
			} else {
				var next = jQuery(".inner_banner:last");
			}
			if(next.length > 0){
				first.animate({opacity:0},1600,function(){
					first.removeClass("current");
					first.addClass("inactive");
					next.addClass("current");
				});
					next.css("opacity","0");
					next.removeClass("inactive");
					next.animate({opacity:1},2200,function(){animate = 0;});	
			}
			
		}
	});

	jQuery(".right_arrow").click(function(){
		if(animate == 0){
			animate = 1;		
			clearInterval(tid);
			var first = jQuery(".current");
			if(first.nextAll(".inner_banner").eq(0).length > 0){
				var next = first.nextAll(".inner_banner").eq(0);
			} else {
				var next = jQuery(".inner_banner:first");
			}
			if(next.length > 0){
				first.animate({opacity:0},1600,function(){
					first.removeClass("current");
					first.addClass("inactive");
					next.addClass("current");
				});
					next.css("opacity","0");
					next.removeClass("inactive");
					next.animate({opacity:1},2200,function(){animate = 0;});
			}
		}
	});	

});
</script>
