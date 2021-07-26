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
 
/**
 * Register Component Resources 
 */
class Component_Appreport_Register extends appRain_Base_Component
{
    public function init()
    {
		## Register Controller 
		App::Module('Hook')
			->setHookName('Controller')
            ->setAction("register_controller")
			->Register(get_class($this),"register_controller");

		## Register CategorySet	
		App::Module('Hook')
			->setHookName('CategorySet')
			->setAction("register_definition")
			->Register(get_class($this),"register_categoryset_defination");
		   
		## Update Admin Panel Menues		
		/*App::Module('Hook')
			->setHookName('InterfaceBuilder')
		   ->setAction("update_definition")
		   ->Register(get_class($this),"interfacebuilder_update_definition");*/

		## Register Model for Database work	
		App::Module('Hook')
			->setHookName('Model')
            ->setAction("register_model")
            ->Register(get_class($this),"register_model");	
			
		## Register Admin Panel Menues	
		App::Module('Hook')->setHookName('InterfaceBuilder')
                           ->setAction("register_definition")
                           ->Register(get_class($this),"register_interface_builder_defination");	

		## Register ACL Options in Administrator 
		## Manage section
        $this->register_detail_acl_definition();
    }

    public function init_on_install()
    {
		// Auto Register the top NAV
        $this->autoRegisterAdminTopNav('appreport');
    }

    public function init_on_uninstall(){}

    public function register_detail_acl_definition(){
	
		// Add ACL Global flag fiels 
		/*App::Module('ACL')->register(
            array('appreportdictionary'=>'Dictionary Of Reports'),
            array(
                'globalaccess'=>array(
                    'title'=>'Global Access',
                    'inputtype'=>'checkboxTag',
                    'options' => array('view'=>'View','edit'=>'Edit','delete'=>'Delete'),
                    'defaultvalue'=>'view'
                )
            )
        );*/
		
		// Find All Reports
		$Groups = App::CategorySet('appreportgroup')->findAll();		
		// Create Access By Reports
		$Groupsacl = array();
		foreach($Groups['data'] as $row){

			$Groupsacl[$row['id']] = array(
				'title'=>'',
                'inputtype'=>'checkboxTag',				
                'options' => array('Yes'=>$row['title']),
                'defaultvalue'=>'No'
			);			
		}
		
		App::Module('ACL')->register(
            array('appreportoperation'=>'Report Operation Access'),$Groupsacl
        );
    }

	public function register_controller()
    {
		// Register Controllers
        $srcpaths = Array();
        $srcpaths[] =   array(
			'name'=>'appreport',
            'controller_path'=>$this->attachMyPath('controllers')
		);
        return $srcpaths;
    }

	public function register_categoryset_defination()
    {
        $srcpaths = Array();
        $srcpaths[] =   array(
			'type'=>'appreportgroup',
            'path'=>$this->attachMyPath('category_set/appreportgroup.xml')
		);
        return $srcpaths;
    }
	
	public function interfacebuilder_update_definition($send)
    {
		// Update Left Menu
        if(isset($send['component']['child'])) {
            $send['component']['child'][] = Array(
				"title"=>"Dictionary of Reports",
				"items"=>Array(
					array("title"=>"Create New","link"=>"/appreport/manage/update/add"),
					array("title"=>"Manage Reports","link"=>"/appreport/manage/")
				),
				"adminicon" => array("type"=>"filePath",'location'=>'/component/appreport/icon/logo.jpg'));
            return $send;
        }
    }

	public function register_model()
    {
		// Register Report Model
        $srcpaths = Array();
        $srcpaths[] =   array(
			'name'=>'AppReportCode',
            'model_path'=>$this->attachMyPath('models')
		);
        return $srcpaths;
    }	
	
	public function register_interface_builder_defination()
    {
		// Register Top Menu
        $srcpaths = Array();
        $srcpaths[] = $this->attachMyPath('interface_builder/settings.xml');
        return array('filepaths'=>$srcpaths);
    }	
}