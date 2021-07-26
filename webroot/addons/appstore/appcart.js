/**
 * appRain v 0.1.x
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
var appcart =
        {
            _attributeerr: false,
            _minitem: 1,
            _maxqty: null,
            _buttonobj: null,
            _parentobj: null,
            _buttonref: '.add2cart-button',
            _parentref: '.add2cartwrapper',
            _unittref: '.add2cart-input',
            _productref: '.productid',
            tqtycartref: '#tqtycart',
            _messageref: 'cart-msg',
            _chkobtnref: '.checkout-button',
            _chkolink: '/checkout',
            _delay: 5000,
            _l_img: siteInfo.baseUrl + '/images/loading.gif',
            loading: function (ptr)
            {
                if (ptr) {
                    jQuery(appcart._parentobj).css('background', 'url(' + appcart._l_img + ') left top no-repeat');
                } else {
                    jQuery(appcart._parentobj).css('background', 'none');
                }
            },
            getUnitTotal: function ()
            {
                var _obj = jQuery(appcart._parentobj).children(appcart._unittref);

                var total = jQuery(_obj).val();

                if (total < appcart._minitem || isNaN(total))
                {
                    total = appcart._minitem;
                    jQuery(_obj).val(appcart._minitem);
                }

                return total;
            },
            getProdId: function ()
            {
                return  jQuery(appcart._parentobj).children(appcart._productref).val();
            },
            add2cart: function ()
            {
                if (appcart._attributeerr) {
                    alert('Please complete the attribute selection.');
                    return;
                }
                appcart._buttonobj = this;
                appcart._parentobj = jQuery(this).parent();
                appcart.loading(true);

                jQuery.ajax({
                    url: siteInfo.baseUrl + "/appstore/add2qcart/" + appcart.getProdId() + "/" + appcart.getUnitTotal() + "?ajax=true",
                    context: document.body,
                    type: 'POST',
                    data: jQuery('#checkattributeforvalue').serialize(),
                    success: function (responseTxt) {
                        var responseObj = eval('(' + responseTxt + ')');
                        if (responseObj._status == 'Redirect') {
                            window.location = responseObj._url;
                        } else {
                            jQuery(appcart.tqtycartref).text(responseObj.totalitem);
                            jQuery(appcart._parentobj).append('<h3 class="' + appcart._messageref + ' ' + ((responseObj._status == 'Error') ? 'cart-error-bg' : 'cart-success-bg') + '">' + responseObj._message + '</h3>');
                            appcart.checkoutbtn(responseObj._hastocheckout);
                            appcart.clearmsg(responseObj._status);
                            appcart.loading(false);
                        }
                    }
                });
            },
            checkoutbtn: function (F)
            {
                jQuery(appcart._chkobtnref).removeClass('hide');
                jQuery(appcart._chkobtnref).removeClass('visible');

                if (F)
                {
                    jQuery(appcart._chkobtnref).addClass('visible');
                } else
                {
                    jQuery(appcart._chkobtnref).addClass('hide');
                }
            },
            checkout: function ()
            {
                window.location = siteInfo.baseUrl + appcart._chkolink;
            },
            add2wishlist: function () {
                //alert(this);
                jQuery.ajax({
                    type: "POST",
                    url: siteInfo.baseUrl + "/game/getcontent/playgame"
                })
                        .done(function (data) {
                            jQuery('.modal-body').empty().append(data);
                            jQuery('.friendlist div a').click(function (evant) {
                                jQuery('#friendid').val(jQuery(this).attr('friendid'));
                            });
                        });
            },
            clearmsg: function ($flag)
            {
                if ($flag != 'Error') {
                    jQuery('.cart-msg').fadeOut(appcart._delay);
                }
            },
            init: function ()
            {
                jQuery('.add-to-wishlist').click(appcart.add2wishlist);
                jQuery(appcart._chkobtnref).click(appcart.checkout);
                jQuery(appcart._buttonref).click(appcart.add2cart);
            }
        }

jQuery(document).ready(appcart.init);


jQuery(document).ready(function () {

    jQuery('#checkattributeforvalue').submit(function (e) {
        e.preventDefault();
    });

    jQuery('.attributelblblock').click(function () {
        
        jQuery('.add2cart-button').prop( "disabled", false );
        var obj = this;
        var data = jQuery(this).attr('data');
        var dataObj = eval('(' + data + ')');
        var hiddenBox = '#hiddenbox_' + dataObj.key;
        //var prvVal = jQuery(hiddenBox).val();
        if (jQuery("#suggession").length < 1) {
            jQuery('body').prepend('<div id="suggession" class="fancybox-skin"></div>');
        }
        jQuery(hiddenBox).val(dataObj.value);
        jQuery('.message-attribute').html('');
        jQuery('#suggessionbody').html('');
        jQuery('#suggession').css('display', 'none');
        appcart._attributeerr = false;
        jQuery('.message-attribute').css('background', 'url(' + appcart._l_img + ') left top no-repeat');
        jQuery('.message-attribute').removeClass('success-attribute');
        jQuery('.message-attribute').removeClass('error-attribute');
        jQuery.ajax({
            url: jQuery('#checkattributeforvalue').attr('action') + '/' + dataObj.key,
            context: document.body,
            type: jQuery('#checkattributeforvalue').attr('method'),
            data: jQuery('#checkattributeforvalue').serialize(),
            success: function (responseTxt) {
                jQuery('.message-attribute').css('background', 'none');
                var responseObj = eval('(' + responseTxt + ')');
                if (responseObj.status == 'Success') {
                    jQuery(obj).parent('.attributelistbox').children('label').removeClass('checkedattribute');
                    jQuery(obj).addClass('checkedattribute');
                    appcart._maxqty = responseObj.maxqty;
                    jQuery('.productpricebox').html(responseObj.price);
                    jQuery('.productid').val(responseObj.id);
                    jQuery('.message-attribute').addClass('success-attribute');

                    var str = "Product has been selected ";
                    if (responseObj.maxqty != '') {
                        str += " (Available quantity " + responseObj.maxqty + ')';
                    }
                    jQuery('.message-attribute').html(str);
                } else {
                    appcart._attributeerr = true;
                    ;
                    jQuery(obj).parent('.attributelistbox').children('label').removeClass('checkedattribute');
                    jQuery(obj).addClass('checkedattribute');
                    jQuery('.message-attribute').addClass('error-attribute');
                    jQuery('.message-attribute').html(responseObj.message);

                    if (responseObj.suggession != '') {
                        var left = 0;
                        var top = 0;
                        var left = (jQuery(window).width() / 2) - (jQuery('#suggession').outerWidth() / 2);
                        var top = (jQuery(window).height() / 2) - (jQuery('#suggession').outerHeight() / 2);
                        jQuery('#suggession').css('display', 'block');
                        jQuery('#suggession').html(responseObj.suggession);
                        jQuery("#suggession").offset({top: top, left: left});
                    }
                    jQuery('.add2cart-button').prop( "disabled", true );
                }
                if (responseObj.presentationpox != '') {
                    jQuery('#productpresentation').html(responseObj.presentationpox);
                }
            }
        });
    });
});
		