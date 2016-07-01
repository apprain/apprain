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
var appForm = {
    _validation:{},
    _fromTClass:".app_form",
    _appOptions:[
        {
            "_formClass":'.app_form',
            "_validation":{
                "_errBg":'#FC8785',
                "_dflBg":'#00FF00',
                "_autoSubmit":true,
                "_errorMark":"inline"
            },
            "_ajax":{
                "_enabled":false,
                "_debug":false,
                "_autoHide":false,
                "_messageElement":".message",
                "_loaderElement":".message",
                "_loadingImg":siteInfo.baseUrl + '/images/loading.gif'
            }
        }
    ],
    _ajax:{},
    _currentForm:null,
    _error:false,
    _errLog:Array(),
    check:function (e) {
        appForm._currentForm = this;
        appForm.preset();
        appForm.validate();
		
        if (!appForm._validation._autoSubmit || appForm._error || appForm._ajax._enabled) {

            if (!appForm._error && appForm._ajax._enabled) {
                appAjax.execute();
            }
            e.preventDefault();
        }
    },
    reset:function () {
        appForm._errLog = Array();
    },
    addToErrLog:function (_obj, msg) {
        appForm._errLog.push((jQuery(_obj).attr('longdesc') ? jQuery(_obj).attr('longdesc') : msg));
    },
    notEmpty:function (_obj) {
        if (jQuery(_obj).val() == "") {
            appForm.addToErrLog(_obj, 'This field can not be left empty');
        }
    },
    notDefault:function (_obj) {
        if (jQuery(_obj).val() == jQuery(_obj).defaultValue()) {
            appForm.addToErrLog(_obj, 'This field can not be left empty');
        }
    },
    email:function (_obj) {
        if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(jQuery(_obj).val()))) {
            appForm.addToErrLog(_obj, 'Please enter a valid Email Address');
        }
    },
    password:function (_obj) {
        var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])/;
        
        if (!re.test(jQuery(_obj).val()) || jQuery(_obj).val().length < 8) {
            appForm.addToErrLog(_obj, 'Enter a valid Password (Length 8 and conbination A-Za-z0-9)');
        }
    },
    alphaNumeric:function (_obj) {
        var re = /^[\w ]+jQuery/;
        if (!re.test(jQuery(_obj).val())) {
            appForm.addToErrLog(_obj, 'Aplha numeric value required');
        }
    },
    isNumber:function (_obj) {
        if (isNaN(jQuery(_obj).val()) || jQuery(_obj).val() == '') {
            appForm.addToErrLog(_obj, 'Please enter a valid numeric vlaue.');
        }
    },
    displayErr:function (_obj, errFlag) {
        if (errFlag) {
            appForm._error = true;
            if (appForm._validation._errorMark == 'background') {
                jQuery(_obj).css('background-color', appForm._validation._errBg);
            }
            else if (appForm._validation._errorMark == 'inline') {
                jQuery('<span>').append(appForm._errLog.join(","))
                    .addClass('inlineerror')
                    .appendTo(jQuery(_obj).parent());
            }
            else {
                jQuery(_obj).css('border', '1px solid ' + appForm._validation._errBg);
            }
        }
        else {
            if (appForm._validation._errorMark == 'background'){
				jQuery(_obj).css('background-color', appForm._validation._dflBg);
			}
            else if (appForm._validation._errorMark == 'border'){
				jQuery(_obj).css('border', '1px solid ' + appForm._validation._dflBg);
			}
        }
    },
    validate:function () {
        jQuery(appForm._currentForm).find('.inlineerror').remove();
        appForm._error = false;
        jQuery(appForm._currentForm).find('input[type=password],input[type=text],textarea,select').each(function (index, _obj) {
            if (
                (_obj.offsetHeight > 0 || jQuery(_obj).hasClass('richtexteditor'))
                    && !jQuery(_obj).hasClass("skipcheckvalidation")
                    && !jQuery(_obj).attr('disabled')
                    && !jQuery(_obj).attr('readonly')
                ) {
                appForm.reset();
                if (jQuery(_obj).hasClass("check_notempty")) {
                    appForm.notEmpty(_obj);
                }
                if (jQuery(_obj).hasClass("check_notdefault")) {
                    appForm.notDefault(_obj);
                }
                if (jQuery(_obj).hasClass("check_email")) {
                    appForm.email(_obj);
                }
                if (jQuery(_obj).hasClass("check_password")) {
                    appForm.password(_obj);
                }
                if (jQuery(_obj).hasClass("check_isnumber")) {
                    appForm.isNumber(_obj);
                }
                if (jQuery(_obj).hasClass("check_alphanumeric")) {
                    appForm.alphaNumeric(_obj);
                }
                if (appForm._errLog.length > 0)appForm.displayErr(_obj, true);
                else appForm.displayErr(_obj, false);
            }
        });
    },
    addtoQueue:function (obj) {
        if (typeof obj == 'undefined') return;
        appForm._appOptions[appForm._appOptions.length] = obj;
    },
    preset:function () {
	
        jQuery(appForm._appOptions).each(function (k, obj) {
		
            if (obj._formClass != '.app_form') {				
				if(
					(
						(obj._formClass.substr(0,1) == '#') 
						&& 
						(obj._formClass.substr(1,obj._formClass.length) == jQuery(appForm._currentForm).attr('id'))
					) 
					|| 
					(jQuery(appForm._currentForm).hasClass(obj._formClass.substr(1,obj._formClass.length)))
					|| 
					(obj._formClass.substr(0,1) != '#' && obj._formClass.substr(0,1) != '.' )
				){
					 appForm._validation = obj._validation;
                    appForm._ajax = obj._ajax;
				}				
            }
            else {		
                appForm._validation = obj._validation;
                appForm._ajax = obj._ajax;
            }
        });
    }
}
var appAjax = {
        loadingImage:function (flag) {
			
            if (flag == 'show') {
                jQuery(appForm._ajax._loaderElement).html('&nbsp;');
                jQuery(appForm._ajax._loaderElement).css('background', 'url(' + appForm._ajax._loadingImg + ') no-repeat');
            }
            else{
				jQuery(appForm._ajax._loaderElement).css('background-image', 'none');
			}
        },
        execute:function () {
            appAjax.loadingImage('show');
            jQuery.ajax({
                url:jQuery(appForm._currentForm).attr('action'),
                context:document.body,
                type:jQuery(appForm._currentForm).attr('method'),
                data:jQuery(appForm._currentForm).serialize(),
                success:function (responseTxt) {
                    appAjax.loadingImage('off');
                    if (appForm._ajax._debug) {
                        alert(responseTxt);
                    }
                    var responseObj = eval('(' + responseTxt + ')');
                    if (responseObj._status.toLocaleLowerCase() == 'prompt' || responseObj._status.toLocaleLowerCase() == 'alert') {
                        alert(responseObj._message);
                        if (appForm._ajax._autoHide)jQuery(appForm._currentForm).fadeOut();
                    }
                    else if (responseObj._status.toLocaleLowerCase() == 'redirect') {
                        window.location = responseObj._location;
                    }
                    else {
                        jQuery(appForm._ajax._messageElement).html(responseObj._message);

                        if (appForm._ajax._autoHide && responseObj._status.toLocaleLowerCase() != 'error')jQuery(appForm._currentForm).fadeOut();
                    }
                }
            });
        }
    }
    ;
(function ($) {
    $.extend($.fn, {
        appForm:function (obj) {
            appForm.addtoQueue(obj);
            jQuery(this).live('submit', appForm.check);
        }
    });
})(jQuery);