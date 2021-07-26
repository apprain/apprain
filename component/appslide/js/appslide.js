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
var appslide =
{   
    _obj       :null,
    _ttime     :3000, 
    _data      :Array(),
    _l_img     :siteInfo.baseUrl + '/images/', 
    _l_obj     :'.apploader',
	_hkeys     :[],
	_currpos   :0,
	_auto      : true,
    show_img   :function(item)
                {
                    jQuery(item).fadeIn('slow');
                },
    chimg      :function(_obj)
                {
                    var g = true;
                    jQuery('.press-img-pan').children('img').each(function(index,item){
                        if(jQuery(item).attr('src').search(jQuery(_obj).attr('rel'))>0 && g){
                            g = false;
                            appslide.show_img(item);
                        }
                        else {
                            jQuery(item).css('display','none');
                        }
                    });
                },
    clrsec     :function()
                {
                    jQuery('.app-press-menu').children('a').each(function(index, item){
                        jQuery(item).removeClass('selected');  
                    })
                },
    loading    :function(ptr)
                {
					var arr = siteInfo.skinUrl.split('/');
				    var filename = 'loading.gif';//(arr[arr.length-1] == 'blackrain') ? 'load-b.gif' : 'load-w.gif';
                    if(ptr)jQuery(appslide._l_obj).css('background','url(' + appslide._l_img + filename + ') left top no-repeat');
                    else jQuery(appslide._l_obj).css('background','url()');
                },
    view       :function()
                {
                    appslide.movenext(this);
                    
					
                },
    movenext   :function(obj)
                {
                    appslide._obj = obj;
                    appslide._currpos = jQuery(appslide._obj).attr('longdesc')-1;
                    if( typeof appslide._data[jQuery(appslide._obj).attr('longdesc')] == 'undefined')
                    {
                        appslide.loading(true);
						jQuery.ajax({
							url: siteInfo.baseUrl + "/appslide/index/" + jQuery(obj).attr('longdesc'),
							context: document.body,
							success: function(responseTxt){
								appslide._data[jQuery(appslide._obj).attr('longdesc')] =responseTxt ;
                                appslide.chimg(appslide._obj);
                                appslide.clrsec();
								jQuery(appslide._obj).addClass('selected');
                                jQuery('.app-press-text').html(appslide._data[jQuery(appslide._obj).attr('longdesc')]);
                                appslide.loading(false);
							}
						});
                    }
                    else
                    {
                        appslide.chimg(appslide._obj);
                        appslide.clrsec();
                        jQuery(appslide._obj).addClass('selected');
                        jQuery('.app-press-text').html(appslide._data[jQuery(appslide._obj).attr('longdesc')]);
                    }                    
                },
    loadimage  :function(image)
                {
  			       jQuery('.press-img-pan').append('<img src="' + siteInfo.filemanagerUrl + '/' + image + '" class="img-thumbnail" style="display:none" />');
                },
    loop       :function(){
	                if(appslide._auto){
                        appslide.movenext(appslide._hkeys[appslide._currpos]);
						appslide._currpos = (appslide._currpos < appslide._hkeys.length) ? (appslide._currpos+1) : 0;
					}
					setTimeout('appslide.loop()', appslide._ttime);
	            },
    init       :function()
                {
					jQuery('.app-press-menu').children('a').each(function(index,item){
						appslide.loadimage(jQuery(item).attr('rel'));
						appslide._hkeys[index] = item;                        
						jQuery(appslide._hkeys[index]).click(appslide.view);
					}); 
					
					jQuery('.app-press-content').mouseover(function() {
						appslide._auto = false;
					}).mouseout(function(){
						appslide._auto = true;
					});

					setTimeout('appslide.loop()', appslide._ttime);
                }
}

jQuery(document).ready(appslide.init);