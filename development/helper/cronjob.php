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
 * Execute scheduler job automatically. To execute these function
 * We have to setup cron.php(location: webroot) in global scheduler
 * like cron tab.
 *
 * This class is extend to appRain_Base_Modules_Date to overwrite
 * or add resource on that class
 *
 * @uses
 * App::Helper('Cronjob')
 *
 * @example
 */
// 	/**
//  	 * An Example funcntion
//  	 * Assign A fix time to run
//  	 *
//  	 * @schedule [07:00-8:00 12:00-13:00 18:00-20:30]
//  	 */
//  	 protected function testFx3Job()
//  	 {
//  	 }
//
//		 /**
//		  * An Example funcntion
//		  * on each time Cron Job run
//		  *
//		  * @schedule [*]
//		  */
// 	 protected function testFx1JOb()
// 	 {
//  	 }
// @link www.apprain.org/manual
class Development_Helper_Cronjob extends appRain_Base_Modules_Cronjob
{
		 /**
	  * An Example funcntion
	  * on each time Cron Job run
	  *
	  * @schedule [*]
	  */
	 protected function testFx1JOb()
	 {
			echo 'START';
			$obj = App::__obj('appRain_Base_Modules_Definition');
			$obj->parseComponentList();
			App::Component('Billspay')->init();
			App::Component('Billspay')->Helper('Contract')->ProcessByAdjustList();
			echo 'DONE';
			$to      = 'info@apprain.com';
			$subject = 'the cron';
			$message = 'done';
			$headers = 'From: info@apprain.com' . "\r\n" .
				'Reply-To: info@apprain.com' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();

			mail($to, $subject, $message, $headers);
 	 }
}