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
var appcheckout =
{
	_pprosref  :'.payment_method',
	_arpad     :'_add',
	_arref     :'.payment_method_add',
	selectOpt   :function()
				{
					jQuery(appcheckout._arref).css('display','none');
					var addref = '#' + jQuery(this).attr('id') + appcheckout._arpad;
					jQuery(addref).css('display','block');
				},
    init       :function()
                {
					jQuery(appcheckout._pprosref).click(appcheckout.selectOpt)
                }
}
jQuery(document).ready(appcheckout.init);