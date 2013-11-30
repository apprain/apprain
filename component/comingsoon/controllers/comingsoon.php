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
class comingsoonController extends appRain_Base_Core{
	
	public function indexAction(){
		
		$this->layout = 'blank';
		$this->site_title = "Coming Soon";
	}
	
	public function preferenceAction($action=null){
	
		$this->setadminTab('component');
		
		if(!empty($this->data)){
			if($this->data['Preference']['comingsoon_mode'] == 'Image' && $this->data['Preference']['comingsoon_image']['name']==''){
				App::Module('Notification')->Push('Please upload an image','Error');
			}
			else{
				if($this->data['Preference']['comingsoon_image']['name']!=''){
					$image = App::Helper('Utility')->upload($this->data['Preference']['comingsoon_image'],$this->baseDir("/uploads/filemanager/"));
					App::Config()->setSiteInfo('comingsoon_image',$image['file_name']);
				}
				App::Config()->setSiteInfo('comingsoon_script',$this->data['Preference']['comingsoon_script']);
				App::Config()->setSiteInfo('comingsoon_mode',$this->data['Preference']['comingsoon_mode']);			
				App::Module('Notification')->Push('Setting updated successfully');				
			}
			$this->redirect("/comingsoon/preference");
		}
	}		
}
