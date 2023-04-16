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

class Component_Pagemanager_Register extends appRain_Base_Component
{
    public function init()
    {
		App::Module('Hook')
			->setHookName('URIManager')
			->setAction("on_initialize")
			->Register(get_class($this), "register_appstore_newrole");
    
        App::Module('Hook')
            ->setHookName('InterfaceBuilder')
            ->setAction("register_definition")
            ->Register(get_class($this),"register_interface_builder_defination");		
    }

    public function init_on_install()
    {
    }

    public function init_on_uninstall()
    {
    }
	
	public function register_interface_builder_defination()
    {
        $srcpaths = Array();
        $srcpaths[] = $this->attachMyPath('interface_builder/menu.xml');
        return array('filepaths'=>$srcpaths);
    }
	
	 public function register_appstore_newrole($def = null) {

		$DataList = App::Model('Page')->findAll("rendertype='smart_h_link'");
		
		foreach($DataList['data'] as $row){
			$def['pagerouter'][] = array(
				"actual" => Array("page", "view",$row['name']),
				"virtual" => Array($row['name'])
			);
		}
	
		return $def;
	 }
}