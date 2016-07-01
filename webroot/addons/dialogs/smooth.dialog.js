jQuery(document).ready(function () {
    jQuery("#dialog").dialog({
        autoOpen: false
    });

    jQuery("#dialog-open").click(function () {
        jQuery("#dialog").dialog("open");
        return false;
    });

    jQuery("#dialog-modal").dialog({
        autoOpen: false,
		width:500,
        //height: 140,
		title:jQuery('#dialog-modal-open').attr('title'),
        modal: true
    });

    jQuery("#dialog-modal-open").click(function () {
        jQuery("#dialog-modal").dialog("open");
        return false;
    });

    jQuery("#dialog-message").dialog({
        autoOpen: false,
        modal: true,
        buttons: {
            Ok: function () {
                jQuery(this).dialog('close');
            }
        }
    });

    jQuery("#dialog-message-open").click(function () {
        jQuery("#dialog-message").dialog("open");
        return false;
    });

    jQuery("#dialog-confirm").dialog({
        autoOpen: false,
        resizable: false,
        height: 140,
        modal: true,
        buttons: {
            'Delete all items': function () {
                jQuery(this).dialog('close');
            },
            Cancel: function () {
                jQuery(this).dialog('close');
            }
        }
    });

    jQuery("#dialog-confirm-open").click(function () {
        jQuery("#dialog-confirm").dialog("open");
        return false;
    });
	
	jQuery("#app-help-dialog-modal").dialog({
		title:'appRain Help',
		autoOpen:false,
		width:700,
		modal:true,
        buttons:{
		    Ok:function () {
                jQuery(this).dialog('close');
            },
            'No! I need more help':function () {
                jQuery(this).dialog('close');
				window.location = 'http://www.apprain.org/ticket';
            }

        },
        close:function () {
          jQuery("#app-help-dialog-modal-inner").html('');
        }		
	});
			
	jQuery(".apphelp").click(function () {
		jQuery('#app-help-dialog-modal-inner').html('loading...');
		jQuery("#app-help-dialog-modal").dialog("open");
		jQuery.get(siteInfo.baseUrl + '/admin/apphelps/' + jQuery(this).attr('id'), function(data) {
			jQuery("#app-help-dialog-modal-inner").html(data);
		});
		return false;
	});
	
    jQuery("#dialog-form").dialog({
        autoOpen: false,
        height: 300,
        width: 350,
        modal: true,
        buttons: {
            'Create an account': function () {
                jQuery(this).dialog('close');
            },
            Cancel: function () {
                jQuery(this).dialog('close');
            }
        },
        close: function () {
            allFields.val('').removeClass('ui-state-error');
        }
    });
	
	jQuery("#app-help-dialog-modal").dialog({
		title:'appRain Help',
		autoOpen:false,
		width:700,
		modal:true,
        buttons:{
		    Ok:function () {
                jQuery(this).dialog('close');
            },
            'No! I need more help':function () {
                jQuery(this).dialog('close');
				window.location = 'http://www.apprain.org/ticket';
            }

        },
        close:function () {
          jQuery("#app-help-dialog-modal-inner").html('');
        }		
	});
			
	jQuery(".apphelp").click(function () {
		jQuery('#app-help-dialog-modal-inner').html('loading...');
		jQuery("#app-help-dialog-modal").dialog("open");
		jQuery.get(siteInfo.baseUrl + '/admin/apphelps/' + jQuery(this).attr('id'), function(data) {
			jQuery("#app-help-dialog-modal-inner").html(data);
		});
		return false;
	});
	
    jQuery("#dialog-form-open").click(function () {
        jQuery("#dialog-form").dialog("open");
        return false;
    });
	
        jQuery("#help-dialog-modal").dialog({
            title :'appRain Help',
            autoOpen: false,
            width:500,
            modal: true
        });
        // Display Modal
        jQuery("#help-dialog-modal-open").click(function () {
            jQuery("#help-dialog-modal").dialog("open");
            return false;
        });
        // Switch Page
        jQuery('#Content_id').change(function(){
            if( this.value != ''){
                window.location = siteInfo.baseUrl + '/page/manage/update/' + this.value;
            }
        });	
		
		 jQuery('#Snip_id').change(function(){
            if( this.value != ''){
                window.location = siteInfo.baseUrl + '/page/manage-snip/update/' + this.value;
            }
        });	
});

function chnageState(id){
	if(confirm('Refresh the page?')){
		window.location = siteInfo.baseUrl + '/page/manage/ues/' + id;
	}
}