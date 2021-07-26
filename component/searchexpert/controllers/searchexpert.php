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
class searchexpertController extends appRain_Base_Core
{
    public $name = 'SearchExpert';
	public $Admin = array();
    public function __preDispatch()
    {
		
    }

    public function indexAction($scheme=null){
	}
    public function doAction($scheme=null){

        $searchrole = App::InformationSet('searchrole')->findByName($scheme);
//pre(substr($searchrole['location'],0,strpos($searchrole['location'],'|')));
        $this->setAdminTab(substr($searchrole['location'],0,strpos($searchrole['location'],'|')));        
        
        $list['data']=array();
        
        if(isset($this->get['src'])){
            $list = App::Component('SearchExpert')->Helper('Data')->getSearchRecords($searchrole);
        }
        
        $this->set('searchrole',$searchrole);
        $this->set('scheme',$scheme);
        $this->set('list',$list);
    }
    
    public function manageroleAction(){
        $this->setAdminTab('component'); 
        
    }
    
    public function windowAction($scheme=null,$point=null,$select=null){
    
        $this->layout = 'admin';
        $this->set('admin_content_clear_length', true);
        $this->set('admin_content_full_length', true);
        $this->set('disable_admin_header', true);
        $this->set('disable_admin_footer', true);
        
        $searchrole = App::InformationSet('searchrole')->findByName($scheme);       
        
        $list['data']=array();        
        if(isset($this->get['src'])){
            $list = App::Component('SearchExpert')->Helper('Data')->getSearchRecords($searchrole,$select);
        }
        
        $this->set('searchrole',$searchrole);
        $this->set('scheme',$scheme);
        $this->set('list',$list);
        $this->set('point',$point);
        $this->set('select',$select);
        
    }
}
