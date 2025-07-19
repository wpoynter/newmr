jQuery(document).ready(function(){
	jQuery('.date-input').datepicker({ dateFormat: "dd-mm-yy" });
	
	/*jQuery('#event_pdf').focus(function() {
		formfield = jQuery('#event_pdf').attr('name');
		tb_show('', 'media-upload.php?type=file&amp;TB_iframe=true');
		return false;
	});

	window.send_to_editor = function(html) {
		imgurl = jQuery('img',html).attr('src');
		jQuery('#event_pdf').val(imgurl);
		tb_remove();
	}*/
});