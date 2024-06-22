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
 
class Component_Homepress_Register extends appRain_Base_Component
{
    public function init()
    {
        App::Module('Hook')
            ->setHookName('InterfaceBuilder')
            ->setAction("update_definition")
            ->Register(get_class($this),"interfacebuilder_update_definition");

        App::Module('Hook')
            ->setHookName('InformationSet')
            ->setAction("register_definition")
            ->Register(get_class($this),"register_informationset_defination");
			
		App::Module('Hook')
            ->setHookName('Sitesettings')
            ->setAction("register_definition")
            ->Register(get_class($this), "register_sitesettings_defination");		

        /*App::Module('Hook')
            ->setHookName('UI')
            ->setAction("template_left_column_B")
            ->Register(get_class($this),"add_search_box");
			
		App::Module('Hook')
            ->setHookName('UI')
            ->setAction("template_right_column_A")
            ->Register(get_class($this),"add_search_box");*/
			
        App::Module('Hook')
            ->setHookName('UI')
            ->setAction("template_left_column_B")
            ->Register(get_class($this),"add_box_left_column");
			
        App::Module('Hook')
            ->setHookName('UI')
            ->setAction("template_right_column_B")
            ->Register(get_class($this),"add_box_right_column");
			
		App::Module('Hook')
            ->setHookName('UI')
            ->setAction("home_content_area_D")
            ->Register(get_class($this),"add_home_synopsis");	

		/*App::Module('Hook')
            ->setHookName('UI')
            ->setAction("template_right_column_A")
            ->Register(get_class($this),"add_quick_links");	*/		
    }

    public function init_on_install(){}

    public function init_on_uninstall(){}
	
	public function add_quick_links($send)
    {
        return App::Helper('Utility')
            ->callElementByPath(
                $this->attachMyPath('elements/quicklinks.phtml')
            );
    }

    public function add_home_synopsis($send)
    {
        $home_synopsis = App::InformationSet('homepress')->findAll("position not in ('template_left_column_A','template_right_column_A')");
		
        return App::Helper('Utility')
            ->callElementByPath(
                $this->attachMyPath('elements/press.phtml'),
                array('home_synopsis'=>$home_synopsis)
            );
    }
	
	public function add_search_box($send)
    {
		
        return App::Helper('Utility')
            ->callElementByPath(
                $this->attachMyPath('elements/add_search_box.phtml')
            );
    }

	public function add_box_left_column($send)
    {
        $home_synopsis = App::InformationSet('homepress')->findAll("position = 'template_left_column_A'");
		
        return App::Helper('Utility')
            ->callElementByPath(
                $this->attachMyPath('elements/box_left_column.phtml'),
                array('home_synopsis'=>$home_synopsis)
            );
    }
	
	public function add_box_right_column($send)
    {
        $right_boxes = App::InformationSet('homepress')->findAll("position = 'template_right_column_A'");
        return App::Helper('Utility')
            ->callElementByPath(
                $this->attachMyPath('elements/box_right_column.phtml'),
                array('right_boxes'=>$right_boxes)
            );
    }

    public function interfacebuilder_update_definition($send)
    {
        if(isset($send['component']['child']))
        {
            $send['component']['child'][] = Array(
                "title"=>$this->__("Home Press"),
                "items"=> Array(
					array(
                        "title"=>"Preference",
                        "link"=>"/admin/config/homepresssettings"
                    ),
                    array(
                        "title"=>"Add New Post",
                        "link"=>"/information/manage/homepress/add"
                    ),
                    array(
                        "title"=>"Manage Posts",
                        "link"=>"/information/manage/homepress"
                    )
                )
		);
            return $send;
        }
    }

    public function register_informationset_defination()
    {
        $srcpaths = Array();
        $srcpaths[] =   array(
            'type'=>'homepress',
            'path'=>$this->attachMyPath('information_set/homepress.xml')
        );
        return $srcpaths;
    }
	
    public function register_sitesettings_defination()
    {
        $srcpaths = Array();
        $srcpaths[] = $this->attachMyPath('sitesettings/settings.xml');

        return array(
            'filepaths' => $srcpaths
        );
    }	
}