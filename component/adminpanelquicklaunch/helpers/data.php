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
class Component_adminpanelquicklaunch_Helpers_Data extends appRain_Base_Objects {

    public function adminLinksIcon($fetchType = 'URL', $icon_path = null,$height=40) {


            if (empty($icon_path)) {
                $icon_path = '/themeroot/admin/images/icons/' . App::Helper('utility')->text2Normalize($childnode['title']) . '.jpg';
            }

            if (!file_exists(App::Config()->basedir($icon_path)) && !file_exists(App::Config()->rootDir($icon_path))) {
                $fetchType = 'URL';
                $icon_path = '/themeroot/admin/images/icons/info.jpg';
            }
        if (strtolower($fetchType) == 'url') {
            $icon = App::load("Helper/Html")->imgTag(App::Config()->baseurl($icon_path), null, array("height" => $height));
        } else {
            $icon = App::load("Helper/Html")->imgDTag(App::Config()->rootDir($icon_path), "/1/per", array("height" => $height));
        }

        return $icon;
    }

    public function listOfLinks($default = null) {

        $menulist = App::Config()->Setting('adminpanel_quick_launch');
        $menulist = (array) json_decode($menulist);


		if(!App::Module('Admin')->isSuper()){

			$DashBoardNAVs = App::Module('ACL')->readNAVAccess('full');
			$DashBoardNAVs = App::Module('ACL')->accessLinksOnly($DashBoardNAVs);
			
			if(is_array($DashBoardNAVs)){			
				
				$array = call_user_func_array('array_merge',$DashBoardNAVs);	
				
				foreach($menulist as $key=>$row){	
					if(!in_array($key,$array)){
						unset($menulist[$key]);
					}
				}
			}
		}
		
        return $menulist;
    }

}
