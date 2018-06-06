jQuery(document).foundation();

jQuery(document).ready(function(){
	jQuery('#filters select').on('change', function(){
		jQuery('#filters').trigger('submit');
	});
	/*var isTouch = (('ontouchstart' in window) || (navigator.msMaxTouchPoints > 0));
	if (isTouch) {
		//console.log("touch");
		jQuery('.film div.href .box').dblclick(function(event) {
			event.preventDefault();
			window.location.href = jQuery(this).parent().data("href");
		});

		jQuery('.film div.href').click(function(event) {
			event.preventDefault();
		});
	} else {
		//console.log("no-touch");
		jQuery('.film div.href').click(function(event) {
			event.preventDefault();
			window.location.href = jQuery(this).data("href");
		});
	}*/

	jQuery('.film span').click(function(event) {
		jQuery(this).parent().children().children(".box").toggleClass("active");
		jQuery(this).toggleClass("active");
	});
	jQuery('a.viewmore').click(function(event) {
		event.preventDefault(); 
		var counter = 0;
		jQuery(".film.hidden").each(function() {
			counter = counter +1;
			jQuery(this).removeClass("hidden");
			if(jQuery(".film.hidden").length == 0) jQuery('a.viewmore').css("opacity", "0");
			if(counter == 48) return false;
		});
	});
});
