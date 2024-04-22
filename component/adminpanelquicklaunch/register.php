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
class Component_AdminpanelQuicklaunch_Register extends appRain_Base_Component {

    public function init() {

        App::Module('Hook')
                ->setHookName('controller')
                ->setAction("register_controller")
                ->Register(get_class($this), "register_controller");
				
        App::Module('Hook')
                ->setHookName('UI')
                ->setAction("adminpanel_toolbar_menu_bottom")
                ->Register(get_class($this), "adminpanel_toolbar_menu_bottom");


    }

    public function register_controller() {
        $srcpaths = Array();
        $srcpaths[] = array(
            'name' => 'adminpanelquicklaunch',
            'controller_path' => $this->attachMyPath('controllers')
        );
		
        return $srcpaths;
    }

    public function adminpanel_toolbar_menu_bottom() {

        return App::Helper('Utility')->callElementByPath($this->attachMyPath('elements/adminpanel_toolbar_menu_bottom.phtml'));
    }

    public function interfacebuilder_update_definition($send) {


        if (isset($send['admission']['child'])) {
            $send['admission']['parent']['action'] = '/membershipexchange/manageentries';

            foreach ($send['admission']['child'][3]['items'] as $key => $val) {
                if ($val['link'] == '/admission/manageentries') {
                    $send['admission']['child'][3]['items'][$key]['link'] = '/membershipexchange/manageentries';
                }
            }
            return $send;
        }
    }

}
