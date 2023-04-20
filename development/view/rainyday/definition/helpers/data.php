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

 
class Development_View_Rainyday_Definition_Helpers_Data extends appRain_Collection {
	
	public function PrintCallBackMenus(){
		$External_Menu_List =  $this->siteMenuClear()->siteMenuRender('ARRAY');
		foreach($External_Menu_List as $menu){
			echo '<li class="nav-item">' . App::Html()->linkTag($menu[0],$menu[1],array("class"=>"nav-link")) . "</li>";
		}
	}
	
}