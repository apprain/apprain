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
class Development_View_Bootstrap_Definition_Register extends appRain_Base_Objects
{
	const SLIDESHOWNAME = 'appslide';
	public function before_theme_install($send=null){}
	
	public function after_theme_installed($send=null){	
		if(App::Module('Component')->exists(self::SLIDESHOWNAME)){
			if(App::Component(self::SLIDESHOWNAME)->status() == appRain_Base_Modules_component::INACTIVE){
				App::Component(self::SLIDESHOWNAME)->chnageStatus();
			}
			App::Config()->setSiteInfo('appslidesettings_displaymode','ajaxbased');
		}
	}

	public function on_theme_removed($send=null){}
}
