// JavaScript Document

//@media (min-width:320px) { /* smartphones, iPhone, portrait 480x320 phones */ }
//@media (min-width:481px) { /* portrait e-readers (Nook/Kindle), smaller tablets @ 600 or @ 640 wide. */ }
//@media (min-width:641px) { /* portrait tablets, portrait iPad, landscape e-readers, landscape 800x480 or 854x480 phones */ }
//@media (min-width:961px) { /* tablet, landscape iPad, lo-res laptops ands desktops */ }
//@media (min-width:1025px) { /* big landscape tablets, laptops, and desktops */ }
//@media (min-width:1281px) { /* hi-res laptops and desktops */ }

function layoutHandler(){
	var styleLink = document.getElementById("pagestyle");
	if(window.innerWidth >= 320 && window.innerWidth <= 480){
		styleLink.setAttribute("href", "./wp-content/themes/ganoderma/styles/ganocare_320.css");
	} else if(window.innerWidth >= 481 && window.innerWidth <= 640){
		styleLink.setAttribute("href", "./wp-content/themes/ganoderma/styles/ganocare_481.css");
	} else if(window.innerWidth >= 768 && window.innerWidth <= 799){
	    styleLink.setAttribute("href", "./wp-content/themes/ganoderma/styles/ganocare_768.css");
	} else if(window.innerWidth >= 800 && window.innerWidth <= 979){
	    styleLink.setAttribute("href", "./wp-content/themes/ganoderma/styles/ganocare_800.css");
	} else if(window.innerWidth >= 980 && window.innerWidth < 1000){
	    styleLink.setAttribute("href", "./wp-content/themes/ganoderma/styles/ganocare_980.css");
	} else if(window.innerWidth >= 1000){
	    styleLink.setAttribute("href", "");
	}
}
window.onresize = layoutHandler;
layoutHandler();

jQuery(window).scroll(function() {
   if(jQuery(window).scrollTop() + jQuery(window).height() == jQuery(document).height()) {
       //alert("bottom!");
   }
});