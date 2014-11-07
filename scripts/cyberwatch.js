// JavaScript Document
jQuery(document).ready(function(){
	
	jQuery(".top_menu").hover(function(){
			if(jQuery(this).find("a").html() == "CAFE FRIENDS" || 
			   jQuery(this).find("a").html() == "FORUM"){
				    jQuery(this).find(".drop_nav").css("left","");
					jQuery(this).find(".drop_nav").css("right","0px");
			} else {
				    jQuery(this).find(".drop_nav").css("right","");
					jQuery(this).find(".drop_nav").css("left","0px");
			}
			jQuery(this).find(".drop_nav").show();
		},function(){
			jQuery(this).find(".drop_nav").hide();
		}
	);
	
	jQuery(".drop_currency, #dp_currency").click(function(){
		jQuery("#currency_converter").toggle();
	});
	jQuery("#convert").click(function(){
		jQuery("#currency_converter").hide();
		window.location.href = jQuery("#base_loc").val() + "?currency=" + jQuery("#val_currency").val();
	});	
        
        // scroll fix
        var scrolled=0;
            $('.ww-tabs').on('click','a',function(e){
                $('.ww-tab-container > .ww-tab-panel').removeClass('active');
                var x = $(this).attr('href');
                $(x).addClass('active');
                scrolled = scrolled - 300;

                $(".fix").animate({
                    scrollTop: scrolled
                });//
            });
            
            
            var t = $("header").offset().top;
            
            $(document).scroll(function(){
                
                if($(this).scrollTop() > 400)
                {   
                   $('.ww-tabs').css('margin-top','287px');
                   $('.home-search').addClass('fix-search');
                   $('.fix, .fix .btn').addClass('fix-bg');
                   
                }else{
                   $('.ww-tabs').css('margin-top','120px');
                   $('.home-search').removeClass('fix-search');
                   $('.fix, .fix .btn').removeClass('fix-bg');
                }
            });
            
            $('.filter-btn').on('click',function(){
              $('.desktop-sidebar').addClass('go-mobile');    
              $('.desktop-sidebar').fadeIn();  
              $('.dim').addClass('dimmer');
            });
            $('.dim').on('click',function(){
               $('.desktop-sidebar').removeClass('go-mobile');
               $('.dim').removeClass('dimmer');
            });
            $('.menu-btn').on('click',function(){
                $('.black-nav').toggle(function(){
                    $('.menu-btn').css('background-color','black');
                });
            });
            $('.myaccount-btn').on('click',function(){
                $('.myaccount-menu').toggle(function(){
                    $('.myaccount-btn').css('background-color','black');
                });
            });
            
        
//	
//	jQuery("#search_button").click(function(){
//	
//		var loc = jQuery("#base_loc").val() + "search?srch=";
//		
//		var srch = jQuery("#search_cyberwatch").val();
//		
//		window.location.href = loc + srch;
//	
//	});
	
});

//jQuery(window).scroll(function() {
//	if (jQuery(window).scrollTop() > jQuery('#header_menu').offset().top) {
//		jQuery("#top_bar_header_background").css({"position":"fixed", "box-shadow":"1px 1px 2px 1px #333","z-index":"99999"});
//	} else {
//		jQuery("#top_bar_header_background").css({"position":"", "box-shadow":"","z-index":""});
//	}
//});

