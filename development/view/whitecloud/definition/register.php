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
 * obtain it through the world-wide-web, please Send an email
 * to license@apprain.com so we can Send you a copy immediately.
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
class Development_View_Whitecloud_Definition_Register extends appRain_Base_View
{
	
	public function before_theme_load($Send=null){

		if($Send->layout == 'admin'){
			return;
		}

		if(App::Config()->isPageView()){
			$Send->layout = App::Config()->Setting('site_pageview_layout','right_column_layout');
		}
	}
	
	public function after_theme_load($Send=null){}	
	
	public function before_theme_install($Send=null){}
	
	public function after_theme_installed($Send=null){}

	public function on_theme_removed($Send=null){}
}
