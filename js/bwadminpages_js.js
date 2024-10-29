jQuery(document).ready(function(){
    jQuery('.bwap_content').first().slideDown('fast');
      
	jQuery('.bwap_button').on('click',function() {
		jQuery('.bwap_content').slideUp('fast');
        var sectionID = jQuery(this).attr("id");
        if (sectionID == 'section_last') {
            jQuery('#section_last').removeClass("section_last");
        } else {
            jQuery('#section_last').addClass("section_last");
        }
		jQuery(this).next('.bwap_content').slideDown('fast');
	});
});