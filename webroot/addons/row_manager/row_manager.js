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
 * @copyright  Copyright (c) 2010 appRain, Team. (http://www.apprain.org)
 * @license    http://www.opensource.org/licenses/mit-license.php MIT license
 *
 * HELP
 *
 * Official Website
 * http://www.apprain.org/
 *
 * Download Link
 * http://www.apprain.org/download
 *
 * Documents Link
 * http ://www.apprain.org/general-help-center
 */

jQuery(document).ready(function() {

    var row_id;
    var deletemessage = "Are you sure to Delete?\n\nThere is currently a request to delete data from the sytem. You may can not undone.\n\nPress OK to continue, or Cancel to stay on same position.";

    if(jQuery('#checkall'))
    {
        jQuery('._deletebtn').live('click', function(e) {

            var myJSONtext = jQuery(this).attr('id');
            var opts = eval('(' + myJSONtext + ')');

            var ids = "";
            jQuery('.checkrow').each(function(key,obj){
                if(jQuery(obj).attr('checked'))
                {
                    ids += ((ids=="")?"":",") + jQuery(obj).val();
                }
            });

            if(ids!="")
            {
                if(confirm(deletemessage))
                {
                    jQuery.ajax({
                        url: siteInfo.baseUrl + "/common/deletegroup/" + opts.mode,
                         type: "POST",
                        data: ({'ids':'{' + ids + '}'}),
                        context: document.body,
                        success: function(){
                          location.reload();
                        }
                    });
                }
            }
        });
    }

	jQuery('.deleteinformatonset').live('click', function(e) {
		var name = jQuery(this).attr('title').split(',')[0];
		var id = jQuery(this).attr('title').split(',')[1];
		if(confirm(deletemessage)){
            jQuery.get(siteInfo.baseUrl + "/information/delete_row/" +  name + "/" + id, function(data) {
              location.reload();
            });
        }
    });	
	
    jQuery('.link_delete').live('click', function(e) {

        var model = jQuery(this).attr('title').split('_')[0];
        var id = jQuery(this).attr('title').split('_')[1];
        row_id = jQuery(this).closest("tr").get("id");

        var orginal_color = jQuery('#'+row_id).css('background-color');

        if(confirm(deletemessage)) {
            jQuery.get(siteInfo.baseUrl + "/common/delete_row/" +  model + "/" + id, function(data) {
                location.reload();
            });
        }        
    });

    jQuery('.delete_informationset_file').live('click', function (e) {
        if(confirm(deletemessage)){
            var thisobj = jQuery(this); 
            var obj = thisobj.closest('span');
            var crosssrc = thisobj.attr('src');
            thisobj.attr('src', siteInfo.baseUrl + '/images/loading.gif');
            jQuery.get(siteInfo.baseUrl + "/common/delete_row/delete_informationset_file/" + jQuery(this).attr('id'), function(data) {
                location.reload();
            });
        }
    });
});