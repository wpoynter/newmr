jQuery(document).ready(function(){
	setInterval(function(){
		var last = jQuery('.front-advert-container').children('div:last')[0];
		jQuery(last).hide();
		jQuery('.front-advert-container').prepend(jQuery(last));
		jQuery('.front-advert-container > .pos-3').switchClass('pos-3','oov',700);
		jQuery('.front-advert-container > .pos-2').switchClass('pos-2','pos-3',700);
		jQuery('.front-advert-container > .pos-1').switchClass('pos-1','pos-2',700,'swing',function(){
			jQuery(last).fadeIn(700);
		});
		jQuery(last).switchClass('oov','pos-1',0);
	},10000);
});