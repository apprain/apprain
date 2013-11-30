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
 * Created a slide show specailly for whitecloud theme
 */
class Component_Updatemanager_Register extends appRain_Base_Component
{
    public function init(){
		
		$this->checkAutoUpdate();	
		
		App::Module('Hook')->setHookName('UI')
            ->setAction("register_notification")
            ->Register(get_class($this),"register_admin_notification");
						   
		App::Module('Hook')->setHookName('Controller')
            ->setAction("register_controller")
            ->Register(get_class($this),"register_controller");			
			
        App::Module('Hook')
            ->setHookName('InterfaceBuilder')
            ->setAction("update_definition")
            ->Register(get_class($this), "interfacebuilder_update_definition");			
			
		App::Module('Hook')
            ->setHookName('UI')
            ->setAction("admin_dashboard_A")
            ->Register(get_class($this),"add_dashboard_html");				
		
	}

    public function init_on_install(){}

    public function init_on_uninstall(){}

	public function register_admin_notification($e)
	{
		if(App::Config()->setting('update_manager_history_widget') != 'No'){
			return '';
		}
		$messages = Array();
		if( App::Config()->load('params')->get('controller') == 'admin' && 
			App::Config()->load('params')->get('action') == 'introduction' && 
			App::Component('Updatemanager')->Helper('Data')->checkNewUpdate() &&
			App::Config()->setting('update_manager_disable_notification') != 'Yes')
		{			
			$messages[] = array(
				App::Html()->linkTag(App::Config()->baseUrl("/updatemanager"),$this->__("New software update available (" . App::Config()->setting('last_ready_patch') . ")"))
			);
		}
		return $messages;
	}	
	
	public function register_controller()
    {
        $srcpaths = Array();
        $srcpaths[] =   array(
			'name'=>'updatemanager',
            'controller_path'=>$this->attachMyPath('controllers')
		);
		
        return $srcpaths;
    }	
	
	
    public function interfacebuilder_update_definition($send)
    {
        if (isset($send['component']['child'])) {
			
            $send['component']['child'][] = Array(
                "title" => "Update Manager",
                "items" => Array(
                    array(
                        "title" => "Preference",
                        "link" => "/updatemanager/history"
                    ),
                    array(
                        "title" => "Start Installation",
                        "link" => "/updatemanager"
                    )
                ),
				"adminicon" => Array(
					"type" => "filePath",
                    "location" => "/component/updatemanager/icon/logo.jpg"
				)
				
            );
            return $send;
        }
    }	
	
	public function checkAutoUpdate(){		
		App::Component('UpdateManager')->helper('Data')->checkAutoUpdate();
	}
	
	public function add_dashboard_html($send)
    {
		if(App::Config()->siteInfo('update_manager_history_widget') != 'No'){
			return App::Helper('Utility')
				->callElementByPath($this->attachMyPath('elements/dashboard.phtml')
			);
		}		
    }
}