<?php
/**
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

class Component_Appreport_Helpers_Data extends appRain_Base_Objects
{

	public function getFilePath($part=''){
			return COMPONENT_PATH . DS . 'appreport' . DS . 'data' . DS .  $part;
	}
	
	public function ReportCategories(){
		$categories = App::Model('Category')->findAll("type='appreportgroup' ORDER BY title ASC");
		return $categories['data'];
	}
	
	public function ReportByGroup($gid=null){
		$list =  App::Model('AppReportCode')->findAll();
		
		$list2 = array();
		foreach($list['data'] as $key => $row){
			
			$arr = explode(',',$row['groups']);
			
			if(in_array($gid,$arr)){
				$list2['data'][] = $row;
			}
		}
		
		return $list2;
	}
	
	public function Report($id=null, $field=null){		
		if(isset($id) || isset($field)){
			$data = App::Model('AppReportCode')->findById($id);
			if(empty($data)) return '';
			
			$path = $this->getFilePath($data['code']);

			if(isset($field)){
				if($field == 'code'){
					if(!empty($data['code'])){
						if(file_exists($path)){
							return App::Utility()->fatchfilecontent($path);
						}
						else{
							return '';
						}						
					}
				}
				return isset($data[$field]) ? $data[$field] : '';
			} 
			else {
				return $data;
			}
		}	
		
		return App::Model('AppReportCode')->findAll();;
	}
	
	public function ExecuteById($id=null,$autodisplay=true){
		$code = App::Component('appReport')->Helper('Data')->Report($id,'code');		
		if($autodisplay){
			echo App::Helper('Utility')->parsePHP(trim($code));
		}
		else {
			return App::Helper('Utility')->parsePHP(trim($code));
		}
	}	
}