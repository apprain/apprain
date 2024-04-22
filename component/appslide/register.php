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
 * Created a slide show specailly for whitecloud theme
 */
class Component_Appslide_Register extends appRain_Base_Component
{
    /**
     * Initialize the basic
     * Resource on load
     */
    public function init()
    {
        App::Module('Hook')
            ->setHookName('CSS')
            ->setAction("register_css_code")
            ->Register(get_class($this),"register_css_code");

        App::Module('Hook')
            ->setHookName('Javascript')
            ->setAction("register_javascript_code")
            ->Register(get_class($this),"register_javascript_code");

        App::Module('Hook')
            ->setHookName('UI')
            ->setAction("home_page_banner")
            ->Register(get_class($this),"add_html");

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

		App::Module('Hook')
            ->setHookName('Sitesettings')
            ->setAction("register_definition")
            ->Register(get_class($this), "register_sitesettings_defination");						
    }

    public function init_on_install(){}

    public function init_on_uninstall(){}

    public function register_css_code()
    {
		return App::Helper('Utility')->fetchFile($this->attachMyPath('css/no-bg.css'));
    }

    public function register_javascript_code()
    {
        return App::Helper('Utility')->fetchFile($this->attachMyPath('js/appslide.js'));
    }

    public function add_html($send)
    {
        $pressdata = App::InformationSet('appslide')->findAll();
        return App::Helper('Utility')->callElementByPath($this->attachMyPath('elements/appslide.phtml'),array('pressdata'=>$pressdata));
    }

    public function register_controller()
    {
        $srcpaths = Array();
        $srcpaths[] =   array(
            'name'=>'appSlide',
            'controller_path'=>$this->attachMyPath('controllers')
        );
        return $srcpaths;
    }

    public function interfacebuilder_update_definition($send)
    {
        if(isset($send['component']['child']))
        {
            $send['component']['child'][] = Array(
                "title"=>"App Slide",
                "items"=>Array(
					array(
                        "title"=>"Preference",
                        "link"=>"/admin/config/appslidesettings"
                    ),
                    array(
                        "title"=>"New Slide",
                        "link"=>"/information/manage/appslide/add"
                    ),
                    array(
                        "title"=>"Manage Slides",
                        "link"=>"/information/manage/appslide")
                    )
				);
            return $send;
        }
    }

    public function register_informationset_defination()
    {
        $srcpaths = Array();
        $srcpaths[] = array(
            'type'=>'appslide',
            'path'=>$this->attachMyPath('information_set/appslide.xml')
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