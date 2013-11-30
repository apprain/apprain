<?php
/**
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
class updatemanagerController extends appRain_Base_Core{

    public $dispatch = Array(
        'preDispatchExclude' => array('historyAction'),
        'postDispatchExclude' => array()
    );
	
    public function __preDispatch()
    {
		$this->check_admin_login();	
		$this->layout = 'admin';
        $this->admin_tab = 'blunk';
        $this->set('admin_content_full_length', true);
        $this->set('disable_admin_header', true);
        $this->set('disable_admin_footer', true);	
    }
	
	public function indexAction(){

		$this->site_title = "-- System Update --";	

		if(!empty($this->data)){
			App::Session()->Write('AgreeToInstall','Yes');
			$this->redirect("/updatemanager/install");
		}
		
	}
	
	public function commitAction(){
		$this->layout = 'empty';
		
		$SourceToInstall = App::Session()->Read('SourceToInstall');
		$SourcePathToInstall = App::Session()->Read('SourcePathToInstall');
		
		if($SourcePathToInstall != '' && $SourceToInstall != ''){
			$path = $SourcePathToInstall . DS . $SourceToInstall;

			$obj = App::Module('Universal_Installer')
				->setSourceAutoDelete(true)
				->setSourceOverwrite(true)
				->setDefaultInstallationPath($SourcePathToInstall)
				->setResourcePath($path)
				->Install();		
			App::Config()->setSiteInfo('last_update_patch',$SourceToInstall);
			$this->writelogtofile(
				array(
					strtoupper(date('d-M-Y')),
					date("H:i:s"),
					$SourceToInstall
				)
			);
			
			$this->redirect("/updatemanager/complete");
		}
		
	}
	
	public function installAction($action=null){
	
		$AgreeToInstall = App::Session()->Read('AgreeToInstall');		
		
		if(!isset($AgreeToInstall) or $AgreeToInstall == ''){
			$this->redirect("/updatemanager");
		}
				
		if(!empty($this->data)){
			if($this->data['UpdateManager']['file']['name'] !=''){
				$path = DATA . DS . time();			
				App::Helper('Utility')->createDir($path, 0777);		
				$Source = App::Utility()->Upload($this->data['UpdateManager']['file'],$path . DS );
				
				App::Session()->Write('SourceToInstall',$Source['file_name']);			
				App::Session()->Write('SourcePathToInstall',$path);
				
				$this->redirect("/updatemanager/install/ready");
			}
			else {
				$this->redirect("/updatemanager/install");
			}
		}
		$this->set('SourceToInstall',App::Session()->Read('SourceToInstall'));
		$this->set('SourcePathToInstall',App::Session()->Read('SourcePathToInstall'));
		$this->set('action',$action);
	}
	
	private function writelogtofile($info=array()){
		$dt = App::Module('Cryptography')->jsonEncode(
			array(
				"date" => $info[0],
				"time" => $info[1],
				"patch"=>$info[2]
			)
		);	
		App::Utility()->savefilecontent(DATA . DS . "versionupdate.log",",{$dt}",'a');
	}

	public function completeAction(){
	
		$SourcePathToInstall = App::Session()->Read('SourcePathToInstall');
		if($SourcePathToInstall != ''){
			App::Session()->Delete('AgreeToInstall');	
			App::Session()->Delete('SourceToInstall');	
			App::Session()->Delete('SourcePathToInstall');	
		}
	}	
	
	public function historyAction($action=null){
	
		$this->setadminTab('component');
		
		if($action == 'clearlastcheck'){
			App::Config()->setSiteInfo('last_check_date','');
			$this->redirect("/updatemanager/history");
		}
		$path = DATA . DS . "versionupdate.log";
		if(file_exists($path)){
			$log = App::Utility()->fatchfilecontent($path);
			$log = '{{"date":"DATE","time":"TIME","patch":"PATCH NAME"}' . $log . '}';
			$History = App::Module('Cryptography')->jsonDecode($log);
			$History = array_reverse($History);
			$this->set('History',$History);
		}
		if(!empty($this->data)){
			App::Config()->setSiteInfo('checkupdate_duration',$this->data['checkupdate_duration']);
			App::Config()->setSiteInfo('checkupdate_repo_uri',$this->data['checkupdate_repo_uri']);
			App::Config()->setSiteInfo('update_manager_history_widget',$this->data['update_manager_history_widget']);
			App::Config()->setSiteInfo('update_manager_disable_notification',$this->data['update_manager_disable_notification']);			
			App::Module('Notification')->Push('Setting updated successfully');
			$this->redirect("/updatemanager/history");
		}
	}	
}
