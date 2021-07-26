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

class Component_searchExpert_Register extends appRain_Base_Component
{
    public function init()
    {    
	
        App::Module('Hook')
			->setHookName('URIManager')
			->setAction("on_initialize")
			->Register(get_class($this),"register_search_newrole");
            
        App::Module('Hook')
            ->setHookName('Controller')
            ->setAction("register_controller")
            ->Register(get_class($this),"register_controller");
            
        App::Module('Hook')
            ->setHookName('InterfaceBuilder')
            ->setAction("update_definition")
            ->Register(get_class($this),"interfacebuilder_update_definition");    
            
        App::Module('Hook')
            ->setHookName('InformationSet')
            ->setAction("register_definition")
            ->Register(get_class($this),"register_informationset_defination");
            
       App::Module('Hook')->setHookName('Addon')
            ->setAction("register_addon")
            ->Register(get_class($this),"register_addon_defination"); 
			
		App::Module('Hook')
            ->setHookName('UI')
            ->setAction("product_input_src_control")
            ->Register(get_class($this),"add_html");
			
		if(App::Config()->Setting('appsearch_dashboard','Disabled') == 'Enabled'){
			App::Module('Hook')
					->setHookName('UI')
					->setAction("admin_dashboard_B")
					->Register(get_class($this),"add_dashboard");	
		}		
		if(App::Config()->Setting('appsearch_shortcut','Disabled') == 'Enabled'){
		
			App::Module('Hook')
				->setHookName('CSS')
				->setAction("register_css_code")
				->Register(get_class($this),"register_css_code");
				
			App::Module('Hook')
				->setHookName('Javascript')
				->setAction("register_javascript_code")
				->Register(get_class($this),"register_javascript_code");	
		}
			
		App::Module('Hook')
            ->setHookName('Sitesettings')
            ->setAction("register_definition")
            ->Register(get_class($this), "register_sitesettings_defination");
	
    }
	
	public function register_sitesettings_defination()
    {
        $srcpaths = Array();
        $srcpaths[] = $this->attachMyPath('sitesettings/settings.xml');

        return array(
            'filepaths' => $srcpaths
        );
    }

	public function register_javascript_code()
    {
        return App::Helper('Utility')->fetchFile($this->attachMyPath('js/dashboard.js'));
    }
	
	public function register_css_code()
    {
		return App::Helper('Utility')->fetchFile($this->attachMyPath('css/dashboard.css'));
    }
	
	public function add_html($send)
    {
	    return ' ' . App::Html()->linkTag(
			'javascript:void(0)',App::Html()->imgTag(App::Config()->baseUrl('/images/admin/view.gif'), null, array("height"=>25)),
			array(
				'point'=> $send['point'],
				'lookfor' => $send['lookfor'],
				'select' => $send['select'],
				'class' => 'app_search_control'
			)
		);
    }
	
	public function add_dashboard($send)
    {
		$list = App::InformationSet('searchrole')->findAll("status='Active' and location='dashboard' and smode in('link','popup-link')");	
	    return App::Helper('Utility')->callElementByPath($this->attachMyPath('elements/dashboard.phtml'),array('data'=>$list));
    }
	
    public function init_on_install()
    {
    }

    public function init_on_uninstall()
    {
    }
    
    public function register_addon_defination()
    {
        $srcpaths = Array();
        $srcpaths[] =   array(
			'type'=>'appsearch',
            'path'=>$this->attachMyPath('addons/appsearch.xml')
		);
        return $srcpaths;
    }
    
    public function register_controller()
    {
        $srcpaths = Array();
        $srcpaths[] =   array(
			'name'=>'searchExpert',
            'controller_path'=>$this->attachMyPath('controllers')
		);
        return $srcpaths;
    }
    
    public function register_search_newrole($def=null)
    {

       /* $def['pagerouter'][] = array(
			"actual"=>Array("searchexpert","index"),
			"virtual"=>Array("searchexpert")
		);*/
        $def['pagerouter'][] = array(
			"actual"=>Array("searchexpert","window"),
			"virtual"=>Array("search-window")
		);
        $def['pagerouter'][] = array(
			"actual"=>Array("searchexpert","managerole"),
			"virtual"=>Array("manage-search-role")
		);		

        return $def;    
    }
    
    public function interfacebuilder_update_definition($send)
    {
        $list = App::InformationSet('searchrole')->findAll("status='Active' and smode='search-window'");
		
        foreach($list['data'] as $role){
            $niddle = explode('|',$role['location']);
            if(isset($niddle[0]) && isset($niddle[1])){
                if(isset($send[$niddle[0]])){
                    foreach($send[$niddle[0]]['child'] as $key=>$row){
                        if($row['title'] == $niddle[1]){
                            array_unshift(
                                $send[$niddle[0]]['child'][$key]['items'],
                                array('title'=>$role['title'],'link'=>'/searchexpert/do/' . strtolower($role['name']))
                            );
                         }
                    }
                }
            }
        }
                
        if(isset($send['component']['child']))
        {
            $send['component']['child'][] = Array(
                "title"=>"Search Manager",
                "items"=>Array(					
                    array(
                        "title"=>"Create New Role",
                        "link"=>"/information/manage/searchrole/add"
                    ),
                    array(
                        "title"=>"Manage Roles",
                        "link"=>"/information/manage/searchrole"
                    ),
                    array(
                        "title"=>"Preferences",
                        "link"=>"/admin/config/appsearch"
                    )					
                ),
                "adminicon" => array("type"=>"filePath",'location'=>'/component/appslide/icon/logo.jpg')
            );
        }

        return $send;
    }
    
    public function register_informationset_defination()
    {
        $srcpaths = Array();
        $srcpaths[] = array(
            'type'=>'searchrole',
            'path'=>$this->attachMyPath('information_set/searchrole.xml')
        );
        return $srcpaths;
    }
}