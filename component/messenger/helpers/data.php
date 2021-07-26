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
 
class Component_Messenger_Helpers_Data extends appRain_Base_Objects
{   
	
	
	public function LiveStatus($formated=false){ 
		
		$time_diffirene = (time() - App::Config()->Setting('last_synced'));
		
		if($formated){
			if($time_diffirene < 5){
				return '<span style="color:green">LIVE</span>';
			}
			else{
				return '<span style="color:red">OFF LINE</span>';
			}
		}
		
		if($time_diffirene < 5){
			return "LIVE";
		}
		else{
			return "OFF-LINE";
		}
	}

}