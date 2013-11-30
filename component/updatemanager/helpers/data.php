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
 * @copyright  Copyright (c) 2010 appRain, Team. (http://www.apprain.com)
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

class Component_updatemanager_Helpers_Data extends appRain_Base_Objects
{
	const REPO_URI = 'http://www.apprain.com/download';
	const REPO_CHECK_URI = 'http://www.apprain.com/resource/checkpatch';
	
	public function checkNewUpdate(){
		$last_ready_patch = App::Config()->setting('last_ready_patch');
		$last_update_patch = App::Config()->setting('last_update_patch');
		
		if($last_ready_patch != $last_update_patch){
			return true;
		}
		else {
			return false;
		}
	}
	
	public function checkAutoUpdate(){

		$todate = date('Y-m-d');
		$checkupdate_duration = App::Config()->setting('checkupdate_duration','1');
		if( $checkupdate_duration != 0){
			$last_check_date = App::Config()->setting('last_check_date','1971-12-16');
			$last_ready_patch = App::Config()->setting('last_ready_patch');
			$diff = abs(strtotime($todate) - strtotime($last_check_date));
			$diff = $diff/(60*60*24);
			if($diff >= $checkupdate_duration){

				$new_ready_patch = @file_get_contents(App::Config()->setting('checkupdate_repo_uri',self::REPO_CHECK_URI));

				if(strlen($new_ready_patch) > 50){
					$new_ready_patch = '';
				}
				
				if( $last_ready_patch != $new_ready_patch){
					App::Config()->setSiteInfo('last_ready_patch',trim($new_ready_patch));				
				}
				App::Config()->setSiteInfo('last_check_date',$todate);		
			}				
		}		
		
	}
	
}