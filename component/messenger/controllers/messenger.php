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
class MessengerController extends appRain_Base_Core {

    public $name = 'Messenger';
    public $Admin = array();

    public function __preDispatch() {
      //  $this->Admin = App::Module('Admin')->thisAdminInfo();
       // $this->setAdminTab('accounts');
    }

    public function getDataAction($session=null) {
		
		echo App::Component('Messenger')->Helper('Data')->LiveStatus(true);		
		
		if(!isset($session)){
			die();
		}

		$list = App::Model('Message')->findAll("session='{$session}' order by id desc limit 0,50");
		if(empty($list['data'])){
			die();
		}

		$list['data'] = array_reverse($list['data']);
		foreach($list['data'] as $row){
			pr($row['sendertitle'] . ' : ' . $row['message']);
		}
	
		exit;
	}
    public function indexAction() {

		$mbname =  App::Session()->Read('mbname');
		$mbsession =  App::Session()->Read('mbsession');
		$mbparentid =  App::Session()->Read('mbparentid');
		$senderid =  App::Session()->Read('senderid');
				
		if(!empty($this->data)){
			if(!empty($this->data['Message']['name'])){
				
				if(empty($this->data['Message']['name']) || empty($this->data['Message']['senderid'])){
					die("Entry name and phone no correctly.");
				}
				
				$capacha = App::Session()->Read("capacha");
				if($capacha['adminpasswordreset'] != $this->data['Message']['capacha']){
					die("Hit Back button and enter capacha correctly. <br />We track all robotic activity and take necessay action!");
				}
				$mbsession = time();
				App::Session()->Write('mbsession',$mbsession);
				App::Session()->Write('mbname',$this->data['Message']['name']);
				App::Session()->Write('senderid',$this->data['Message']['senderid']);
				$this->Redirect("/messenger");
			}
			
			if(!empty($this->data['Message']['message'])){

				$obj = App::Model('Message')
				->setId(null)
				->setParent($mbparentid)
				->setMessage($this->data['Message']['message'])
				->setSendertitle($mbname)
				->setSenderid($senderid) 
				->setreceivedid("") 
				->setSession($mbsession) 
				->setTimestamp(time()) 
				->setReaderstatus("1") 
				->setImagelink("") 
				->setEntrydate(date("Y-m-d")) 
				->setType("guest") 
				->Save();
				
				App::Model("Notification")
				->setChannel("MessageBoard") 
				->setTitle("New Message")
				->setDescription( "{$mbname} sent a message")
				->setDate(date('Y-m-d'))
				->setTimestamp(time())
				->Save();
				
				
				if(empty($mbparentid)){
					App::Session()->Write('mbparentid',$obj->getId());
				}
				
			}
			$this->redirect("/messenger");
		}
		
		$this->set('mbsession',$mbsession);
		$this->set('mbname',$mbname);
    }

	public function logoutAction(){
		App::Session()->Delete('mbsession');
		App::Session()->Delete('mbname');
		App::Session()->Delete('senderid');
		App::Session()->Delete('mbparentid');
		$this->Redirect("/messenger");
		
	}
   

}
