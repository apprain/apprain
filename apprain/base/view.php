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
 * @copyright  Copyright (c) 2010 appRain, Inc. (http://www.apprain.org)
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
 * http ://www.apprain.org/documents
 */
class appRain_Base_View extends appRain_Base_Objects {

    const STATUS_ACTIVE = 'Active';
    const STATUS_INACTIVE = 'Inactive';
    const VIEW = 'View';
    const BOOT_FILE = 'register';

    public $helper_path = "definition/helpers";
    private $listSingleTone = Array();

    /**
     * FUNCTION Called each time it activate
     */
    protected function init() {
        
    }

    /**
     * FUNCTION Called each time it installed
     */
    protected function init_on_install() {
        
    }

    /**
     * Function run on uninstall
     */
    protected function init_on_uninstall() {
        
    }

	public function Helper($name="Data"){
	
		$path = VIEW_PATH . DS . App::Config()->Setting('theme') . DS . $this->helper_path . DS . $name . SEXT;
		
		$path = strtolower($path);
		
		if(!file_exists($path)){
			return null;
		}

        return App::__pathToClass($path);

	}

}
