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
 * @copyright  Copyright (c) 2010 appRain, Inc. (http://www.apprain.com)
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
 * http ://www.apprain.com/documents
 */
 
 
class adminpanelquicklaunchController extends appRain_Base_Core {

    public $name = 'Adminpanelquicklaunch';

    public function __preDispatch() {
        $this->Admin = App::Module('Admin')->thisAdminInfo();
        $this->setAdminTab('developer');
    }

    public function indexAction() {
        
    }

    public function configureAction($id = null) {

        if (!empty($this->post)) {
            $array = array();
            $menulist = App::Config()->Setting('adminpanel_quick_launch');
            if (!empty($menulist)) {
                $array = (array) json_decode($menulist);
            }
            if(empty($this->post['title'])){
                if(isset($array[$this->post['mylink']])){
                    unset($array[$this->post['mylink']]);
                }
            }
            else{
                $array[$this->post['mylink']] = $this->post;
            }
            $str = json_encode($array);
            App::Config()->setSiteInfo('adminpanel_quick_launch', $str);
            echo '{"status":"Success"}';
            exit;
        }
    }

}
