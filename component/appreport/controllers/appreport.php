<?php
/**
 * appRain v 0.1.x
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
class appreportController extends appRain_Base_Core
{
    public $name = 'Appreport';
	
	public function __preDispatch(){
		
	}
	
    public function indexAction()
    {
	}
	
	public function manageAction($action='view',$id=null){

		$this->setAdminTab('appreport');	
		$this->addons = array('row_manager');
		$adminInfo = App::Module('Admin')->thisAdminInfo();		
		
		if($action == 'delete'){
			App::Module('Notification')->Push("Delete has been disabled",'Warning');
			$this->redirect("/appreport/manage");
			exit;
		}
		
		if(!empty($this->data)){
			if(isset($this->data['AppReportCode']['groups']['checkbox'])){
				
				$this->data['AppReportCode']['groups'] = implode(',',$this->data['AppReportCode']['groups']['checkbox']);
			}
			
		    $this->data['AppReportCode']['adminid'] = $adminInfo['id'];
			$this->data['AppReportCode']['dated'] = App::Helper('Date')->getDate('Y-m-d H:i:s');	
			$obj = App::Model('AppReportCode')->Save($this->data);
			pr($this->data);
			pre($obj);
			if(!isset($this->data['AppReportCode']['id']) || $this->data['AppReportCode']['id'] ==''){
				echo App::Load("Module/Cryptography")
					->jsonEncode(array("_status" =>"Redirect","_location"=>App::Config()->baseUrl("/appreport/manage/update/" . $obj->getId())));
			}
			else {
				echo App::Load("Module/Cryptography")
					->jsonEncode(array("_status" =>"Success","_message"=>'<strong style="color:green">Report Saved Successfully</strong>'));
			}
			exit;
		}		
		$this->setRptId($id);
		$this->set('action',$action);
	}
	
	public function executorAction($gid=null){
		
		$this->setAdminTab('appreport');
		
		$this->setGroupId($gid);
		
		if(!isset($gid)){
			$groups = App::Component('appReport')->Helper('Data')->ReportCategories();
			$GroupList = array();
			foreach($groups as $key=>$row){
				if(App::Module('ACL')->setGroupName('appreportoperation')->hasAccess($row['id'],'Yes')){  
					$GroupList[] = $row;
				}
			}
			if(count($GroupList) == 1){
				$this->redirect("/appreport/executor/{$GroupList[0]['id']}");
				exit;
			}
			
			$this->set('GroupList',$GroupList);
		}
		
	}
	
	public function executeAction($id){		
	
		$this->setAdminTab('appreport');
		
		$this->set('admin_content_full_length',true);		
        $this->set('admin_content_clear_length',true);
        $this->set('disable_admin_header',true);
        $this->set('disable_admin_footer',true);
		
		$post_session_track = null;
		if(!empty($this->data)){
			$post_session_track = time();
			App::Session()->Write("p_{$post_session_track}",serialize($_POST));
		}
		
        $AppReport = App::Model('Appreportcode')->findById($id);
		
		$this->set('post_session_track',$post_session_track);
		$this->set('AppReport',$AppReport);
	    $this->setRptId($id);
		
		
	}
	
	public function downloadAction($id=null,$o=null,$post_trac=null,$jsonpost=null){	
	
		if(isset(App::Config()->get['param'])){
			App::Config()->post = App::Config()->get['param'];
		}
		else{
			$post = App::Session()->Read("p_{$post_trac}");
			if(!empty($post)){
				$_POST = unserialize($post);
				App::Config()->post = unserialize($post);
			}
		}
		App::Component('appReport')->Helper('Download')->ReportById($id,$o);		
		exit;
	}
	
	private function SaveMyCode($content=null,$id=null){
		$this->setAdminTab('appreport');
		$path = COMPONENT_PATH . DS . 'appreport' . DS . 'data' . DS ;
		$filename=time() . '.arbt';		
		if(!empty($id)){
			$row = App::Model('AppReportCode')->findById($id);
			$filename= empty($row['code']) ? $filename : $row['code'];
		}	
		
		App::Utility()->savefilecontent("{$path}{$filename}",$content);		
		
		return $filename;		
	}
	
	
	public function updatecodeAction($id=null){
		$this->setAdminTab('appreport');
		$this->addons = array('ace');
		$this->set('admin_content_full_length',true);		
        $this->set('admin_content_clear_length',true);

		if(!empty($this->post)){
			$filename = $this->SaveMyCode($this->post['content'],$id);
			App::Model('AppReportCode')->setId($id)->setCode($filename)->Save();
			echo 'Report has been submitted successfully';
			exit;
		}		
        
        $AppReport = App::Model('Appreportcode')->findById($id);
		$this->set('AppReport',$AppReport);
		$this->set('id',$id);
	}
	
	public function exportAction($id=null){
		$AppReport = App::Model('Appreportcode')->findById($id);
		
		App::Utility()->download(App::Config()->RootDir("/component/appreport/data/{$AppReport['code']}"));
		//App::Utility()->download(App::Config()->RootDir("/appreport/data/{$AppReport['code']}");
		
		pre($AppReport);
	}
}
