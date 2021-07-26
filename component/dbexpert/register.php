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
 * http ://www.apprain.org/general-help-center
 */

/**
 * Developed by: Reazaul Karim
 *
 */
class Component_DBExpert_Register extends appRain_Base_Component
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
				'title' => 'Database Expert',
				'link' => '/dbexpert/imexport',
				
			);
            $send['developer']['child'][] = Array(
                "title"=>"Database Expert",
                "items"=>Array(
					array(
                        "title"=>"Database Expert",
                        "link"=>"/dbexpert/imexport"
                    )
                )
            );
            return $send;
        }
    }
	
    public function register_controller()
    {
        $srcpaths = Array();
        $srcpaths[] =   array(
            'name'=>'dbexpert',
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