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
 * http ://www.apprain.com/docs
 */

/**
 * Developed by: Reazaul Karim
 *
 */
class Component_AppEditor_Register extends appRain_Base_Component
{
    public function init()
	{
        App::Module('Hook')
            ->setHookName('InterfaceBuilder')
            ->setAction("update_definition")
            ->Register(get_class($this),"interfacebuilder_update_definition");
			
        App::Module('Hook')
            ->setHookName('Controller')
           ->setAction("register_controller")
           ->Register(get_class($this),"register_controller");
		   
        App::Module('Hook')
            ->setHookName('Helper')
            ->setAction("register_helper")
            ->Register(get_class($this),"register_helper");		   
    }

    public function init_on_install(){}

    public function init_on_uninstall(){}
	
    public function interfacebuilder_update_definition($send)
    {
		
        if(isset($send['developer']['child']))
        {
			$send['developer']['parent']['submenu'][] = array(
				'title' => 'App Editor',
				'link' => '/appeditor',
				
			);
            return $send;
        }
    }
	
    public function register_controller()
    {
        $srcpaths = Array();
        $srcpaths[] =   array(
            'name'=>'appeditor',
            'controller_path'=>$this->attachMyPath('controllers')
        );
        return $srcpaths;
    }
	
	public function register_helper()
    {
        $srcpaths = Array();
        $srcpaths[] =   array(
			'name'=>'Data',
            'path'=>$this->attachMyPath('helpers/data.php')
		);
        return $srcpaths;
    }
}