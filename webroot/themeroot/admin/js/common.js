jQuery(document).ready(function () {
	jQuery('.widget-closer').live('click', function(e) {
		if(confirm('Close the widget? \n Click "Ok" to hide or "Cancel" to keep same.')){
            jQuery.get(siteInfo.baseUrl + "/developer/closewidget/" +  jQuery(this).attr('id').substr(7,jQuery(this).attr('id').length), function(data) {
			   location.reload();
            });
        }
    });	
});