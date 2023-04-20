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
 
class Component_Messenger_Helpers_Service extends appRain_Base_Objects
{   
	public function checkGeneralStatuses($data){
	
		$list = array();	
		$List = App::Model("Notification")->findAll("id > {$data['trackid']}");
		
		
		foreach($List['data'] as $row){	
			$list[] = array("trackid"=>$row["id"],"title"=> $row["title"],"description"=>$row["description"]);
		}
		
		App::Config()->setSiteInfo("last_synced",time());
		
		return array('status'=>'1','trackid'=>$data['trackid'],'data'=>$list);
	}
	
	
	public function saveMessage($data){
		
		$obj = App::Model('Message')
			->setId(null)
			->setMessage($data['message'])
			->setSendertitle($data['sendertitle'])
			->setParent($data['parent'])
			->setSenderid("") 
			->setreceivedid("") 
			->setSession($data['session']) 
			->setTimestamp(time()) 
			->setReaderstatus("1") 
			->setImagelink("") 
			->setEntrydate(date("Y-m-d")) 
			->setType("guest") 
			->Save();
			

		
		
		$row = App::Model('Message')->findById($obj->getId());
		
		return array('status'=>'1','data'=>$row);
		
	}
	
	
	public function fetchMessage($data){
		
		
		$list = App::Model('Message')->findAll("id>{$data['last_id']}");
		
		return array('status'=>'1','data'=>$list['data']);
		
	}
}