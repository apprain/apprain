var appsearch = {   
    _obj:null,
    _point:null,
    _lookfor:null,
    _select:null,
    showsearchbox:function(){
		
		jQuery('.ui-dialog-title').html(jQuery(this).attr('title'));
		
		appsearch._mode = jQuery(this).attr('mode');
		appsearch._point = jQuery(this).attr('point');
		appsearch._lookfor = jQuery(this).attr('lookfor');		
		appsearch._select = jQuery(this).attr('select');
		
		if(appsearch._mode=='popup-link'){			
			var src = jQuery(this).attr('location');
		}
		else if(appsearch._mode=='link'){
			window.location = jQuery(this).attr('location');
			
			return;
		}
		else{
			//var src = siteInfo.baseUrl + '/search-window/' + appsearch._lookfor + '/' + appsearch._point + '/' + appsearch._select;
			var src = siteInfo.baseUrl + '/searchexpert/window/' + appsearch._lookfor + '/' + appsearch._point + '/' + appsearch._select;
		}
		
		
		var dv = jQuery('#'+appsearch._point).val();
		if(src.indexOf('?') > 0){
			jQuery('#app-search-dialog-modal-inner').html('<iframe width="100%" height="500" scrolling="auto" src="' + src + '&src=Search&__dv=' + dv + '"></iframe>');
		}
		else{
			jQuery('#app-search-dialog-modal-inner').html('<iframe width="100%" height="500" scrolling="auto" src="' + src + '?src=Search&__dv=' + dv + '"></iframe>');
		}
		
		
		jQuery("#app-search-dialog-modal").dialog("open");
				
		
    },
    init:function(){

		if(window.frameElement != null ){
		
			jQuery('#right').css('margin-right','10px');
			jQuery('#header').hide();
			jQuery('#left').hide();
			jQuery('#footer').hide();		
		}
		
        var obj = jQuery(".app_search_control");
        if(obj.length > 0){ 
            jQuery('body').append('<div id="app-search-dialog-modal"><div id="app-search-dialog-modal-inner"></div></div>');        
            jQuery("#app-search-dialog-modal").dialog({
                title:'Search',
                autoOpen:false,
                height:(jQuery(window).height())*(0.90),
                width:(jQuery(window).width())*(0.90),
                modal:true,
                buttons:{}
            });
            jQuery(".app_search_control").click(appsearch.showsearchbox);
        }
    }
}

  



jQuery(document).ready(
    
    appsearch.init
 );