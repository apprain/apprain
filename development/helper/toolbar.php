<?php
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
 * @copyright  Copyright (c) 2010 appRain, Inc. (http://www.apprain.org)
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
 * http ://www.apprain.org/documents
 */

/**
 * @author appRain Team
 * @version 0.1.0
 *
 * @tutorial
 * This class is extend to appRain_Base_Modules_Toolbar to overwrite
 * or add resource on that class
 *
 * @uses
 * App::Helper('Toolbar')
 *
 * @example
 * App::Helper('Toolbar')->setTitle("Account Information")->setBtnBack()->Render(array('code'=>'member_account_view_top'));
 *
 * @link www.apprain.org/manual
 */
class Development_Helper_Toolbar extends appRain_Base_Modules_Toolbar
{
}