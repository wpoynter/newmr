var initalSidebarTop = 100000;
var initalSidebarLeft;

// var resize = function() {
// 	var mainHeight = jQuery(window).height() - 
// 			jQuery('header#masthead').height() - 
// 			jQuery('footer#mastfoot').height() -
// 			(jQuery('#wpadminbar').height() === null ? 0 : jQuery('#wpadminbar').height());
// 	jQuery('div#main').css('min-height',String(mainHeight)+'px');
// 	if (initalSidebarTop + jQuery("#sidebar").height() < jQuery(window).height()) {
// 		jQuery("#sidebar").css({
// 			position: 'fixed',
// 			top: jQuery("#sidebar").offset().top + 'px',
// 			left: String(jQuery("#content").offset().left + jQuery("#content").outerWidth(true)) + 'px'
// 		});
// 	}
// };

// jQuery(document).ready(function(){
// 	if (jQuery('#sidebar').length > 0) {
// 		initalSidebarTop = jQuery("#sidebar").offset().top;
// 		initalSidebarLeft = jQuery("#sidebar").offset().left;
// 	}
// 	resize();
// 	jQuery(window).resize(function(){
// 		resize();
// 	});
// 	jQuery(".post .entry-excerpt").dotdotdot({
// 		watch: true,
// 		height: 100,
// 	});
// 	jQuery(".post-type-archive-person #content").masonry({
// 		columnWidth: 360,
// 		itemSelector: 'article',
// 		gutter: 30,
// 		stamp: "header"
// 	});
// });