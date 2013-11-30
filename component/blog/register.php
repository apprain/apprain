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

class Component_blog_Register extends appRain_Base_Component
{
    public function init()
    {
        App::Module('Hook')
            ->setHookName('CSS')
            ->setAction("register_css_code")
            ->Register(get_class($this),"register_css_code");

        App::Module('Hook')
            ->setHookName('Controller')
            ->setAction("register_controller")
            ->Register(get_class($this),"register_controller");

        App::Module('Hook')
            ->setHookName('InformationSet')
            ->setAction("register_definition")
            ->Register(get_class($this),"register_informationset_defination");

        App::Module('Hook')
            ->setHookName('CategorySet')
            ->setAction("register_definition")
            ->Register(get_class($this),"register_categoryset_defination");

        App::Module('Hook')
            ->setHookName('InterfaceBuilder')
            ->setAction("register_definition")
            ->Register(get_class($this),"register_interface_builder_defination");

        App::Module('Hook')
            ->setHookName('Sitemenu')
            ->setAction("register_sitemenu")
            ->Register(get_class($this),"register_sitemenu");

        App::Module('Hook')
            ->setHookName('URIManager')
            ->setAction("on_initialize")
            ->Register(get_class($this),"register_newrole");

        App::Module('Hook')
            ->setHookName('Helper')
            ->setAction("register_helper")
            ->Register(get_class($this),"register_helper");
			
		App::Module('Hook')
            ->setHookName('UI')
            ->setAction("home_content_area_C")
            ->Register(get_class($this),"add_html");	
			
		/*App::Module('Hook')
            ->setHookName('UI')
            ->setAction("admin_dashboard_C")
            ->Register(get_class($this),"add_dashboard_html");	*/
			
		App::Module('Hook')->setHookName('Model')
            ->setAction("register_model")
			->Register(get_class($this),"register_model");		

        App::Module('Hook')
            ->setHookName('Sitesettings')
            ->setAction("register_definition")
            ->Register(get_class($this), "register_sitesettings_defination");			
    }

    public function init_on_install()
    {
        $this->autoRegisterAdminTopNav('blog');

        App::PageManager()->setTitle('Blog')->LoadInDB('blog');
    }

    public function init_on_uninstall()
    {
    }

    public function register_css_code()
    {
        return App::Helper('Utility')->fetchFile($this->attachMyPath('css/styles.css'));
    }

    public function register_controller()
    {
        $srcpaths = Array();
        $srcpaths[] =   array(
			'name'=>'Blog',
            'controller_path'=>$this->attachMyPath('controllers')
		);
        return $srcpaths;
    }

	public function register_model()
    {
        $srcpaths = Array();
		$srcpaths[] =   array(
			'name'=>'BlogComment',
            'model_path'=>$this->attachMyPath('models')
		);

        return $srcpaths;
    }
	
    public function register_informationset_defination()
    {
        $srcpaths = Array();
        $srcpaths[] =   array(
			'type'=>'blogpost',
            'path'=>$this->attachMyPath('information_set/blogpost.xml')
		);
        return $srcpaths;
    }

    public function register_categoryset_defination()
    {
        $srcpaths = Array();
        $srcpaths[] =   array(
			'type'=>'blog-cat',
            'path'=>$this->attachMyPath('category_set/blog-cat.xml')
		);
        return $srcpaths;
    }

    public function register_interface_builder_defination()
    {
        $srcpaths = Array();
        $srcpaths[] = $this->attachMyPath('interface_builder/blog.xml');
        return array('filepaths'=>$srcpaths);
    }

    public function register_sitemenu($send)
    {
        $menu = Array();
        $menu[] = Array(App::Helper('Config')->baseurl("/blog"),'Blog','blog');
        return $menu;
    }

    public function register_newrole($def=null)
    {
        $def['pagerouter'][] = array("actual"=>Array("blog","index"),"virtual"=>Array("blog"));
        $def['pagerouter'][] = array("actual"=>Array("blog","index","bycat"),"virtual"=>Array("blog-by-cat"));
        $def['pagerouter'][] = array("actual"=>Array("blog","index","bypost"),"virtual"=>Array("blog-by-post"));
        $def['pagerouter'][] = array("actual"=>Array("blog","submitcomment"),"virtual"=>Array("blog-comment-submission"));
        $def['pagerouter'][] = array("actual"=>Array("blog","managecomment"),"virtual"=>Array("manage-comments"));		

        return $def;
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
	
    public function add_html($send)
    {
		if( App::Config()->setting('blogsettings_homepage_updates','Yes') == 'Yes'){
			$post = App::InformationSet('blogpost')->findAll('1 limit 0,' . App::Config()->setting('blogsettings_homepage_limit',3));
			$comments = App::Model('blogComment')->findAll("status='Active' order by id desc  limit 0," . App::Config()->setting('blogsettings_homepage_limit',3));
			return App::Helper('Utility')
				->callElementByPath(
					$this->attachMyPath('elements/updates.phtml'),
					array('post'=>$post,'comments'=>$comments)
			);
		}	
    }	
    public function add_dashboard_html($send)
    {
        /*$post = App::InformationSet('blogpost')->findAll('1 limit 0,3');
		$comments = App::Model('blogComment')->findAll("type='blog' and status='Active' order by id desc  limit 0," . App::Config()->setting('blogsettings_homepage_limit',3));
		
        return App::Helper('Utility')
            ->callElementByPath(
                $this->attachMyPath('elements/dashboard.phtml'),
                array('post'=>$post,'comments'=>$comments)
        );*/
		
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