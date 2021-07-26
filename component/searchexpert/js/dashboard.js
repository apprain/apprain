/**
 * appRain CMF
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.opensource.org/licenses/mit-license.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@apprain.com so we can send you a copy immediately.
 *
 * @copyright  Copyright (c) 2010 appRain, Inc. (http://www.apprain.com)
 * @license    http://www.opensource.org/licenses/mit-license.php MIT license
 *
 * HELP
 * 
 * Official Website 
 * http://www.apprain.com/
 *
 * Download Link
 * http://www.apprain.com/download
 *
 * Documents Link
 * http ://www.apprain.com/docs
 */
var dashboard =
{   
    _obj:null,
	
    clearall:function(){
		jQuery('#header').hide();
		
		var loc = window.location;
		
		if(window.location.href.substr(-18) == 'admin/introduction' || window.frameElement != null){
			jQuery('#left').hide();
		}
		if(window.frameElement != null){
			jQuery('#footer').hide();
		}
		
	},
	
	toggleall:function(){
		jQuery('#header').toggle();
		if(window.location.href.substr(-18) != 'admin/introduction' && window.frameElement == null ){
			
			jQuery('#left').show();
			jQuery('#footer').toggle();		
		}
	},
	
    init:function(){
				
		dashboard.clearall();

		jQuery(document).keydown(function(event) {
			if(event.keyCode == 113){
				dashboard.toggleall();
			}						
			if(event.keyCode == 115){
				window.location=siteInfo.baseUrl + '/admin/introduction';
			}
		});
	}
}

jQuery(document).ready(dashboard.init);