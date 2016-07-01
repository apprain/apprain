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

/**
 * @author appRain Team
 * @version 0.1.0
 *
 * @tutorial
 * This class is extend to appRain_Base_Modules_Emailtemplate to overwrite
 * or add resource on that class
 *
 * @uses
 * App::Helper('EmailTemplate')
 *
 * @example
 *  $params = Array(
 *                  'Name'=>'Jhon Regan',
 *                  'Email'=>'info@example.com',
 *                  'Message'=>'My test message');
 *  $Obj = App::Helper('EmailTemplate')->setParameters($params);
 *
 *  // Optional Parameter
 *  // Default it pick information form site settings
 *  $Obj->setFrom(array('from@example.com','Site Administraotr'));
 *
 *  // Optional Parameter
 *  //Default it pick information form site settings
 *  $Obj->setTo(array('to@example.com','Pitter Lakeman'));
 *
 *    // Parse the email template and send it
 *    // Here Email template name: ContactUs
 *    // Set true to send mail automatically
 *    // Template information is available in
 *    // the object.
 *  $Obj->prepare('ContactUs',true);
 *
 * @link www.apprain.org/manual
 */
class Development_Helper_EmailTemplate extends appRain_Base_Modules_Emailtemplate
{
}
