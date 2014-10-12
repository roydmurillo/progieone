<style>
.inactive{
	display:none;
	z-index:0;
}
.current{
	z-index:1;
}
</style>
<div class="home-banner">
    
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
