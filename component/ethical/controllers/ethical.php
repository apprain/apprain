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
class ethicalController extends appRain_Base_Core
{
    public $name = 'Ethical';
	public $Admin = array();
    public function __preDispatch()
    {
		$this->layout = 'empty';
    }


    public function indexAction(){
        
        if(isset($_SERVER['HTTP_CRYPTO'])){
            App::Session()->Write('HTTP_CRYPTO',$_SERVER['HTTP_CRYPTO']);
        }
        
        $HTTP_CRYPTO =  App::Session()->Read('HTTP_CRYPTO');
 
        if(!empty($HTTP_CRYPTO)){
            $this->redirect();
        }
        else{
            pre("UN_AUTHORIZED");
        }
    }
	
	public function authAction($action='new'){

		$auth = App::Component('Ethical')->Helper('Auth')->Login($this->post);
		if($auth['status'] == 1){
			$this->createSession($auth['user']['adminref']);
			$message['token'] = base64_encode('{' . App::__Def()->sysConfig('APPRAINLICENSEKEY') . ':' . $auth['user']['adminref'] . ':' . $auth['user']['latestlogin'] . '}');
			$message['timestamp'] = $auth['user']['latestlogin'];
			$message['status'] = '1';
			$message['auth'] = $auth['user'];
			$message['data'] = array();
			$this->deleteSession();
		}
		else{
			$message['status'] = '2';
			$message['message'] = $auth['message'];
		}	
		echo json_encode($message);
		exit;
	
	}
	
	public function exchangeAction(){
		
		$auth = App::Component('Ethical')->Helper('Auth')->Renew($this->post);
		if($auth['status'] != 1){
			$this->DisplayResult(array('status'=>'2','message'=>'INVALID_REQUEST'));
		}
		
		$message['token'] = base64_encode('{' . App::__Def()->sysConfig('APPRAINLICENSEKEY') . ':' . $auth['user']['adminref'] . ':' . $auth['user']['latestlogin'] . '}');	
		if(App::Component($this->post['com'])->Status() != 'Active'){
			$this->DisplayResult(array('status'=>'2','message'=>'INVALID_COM'));
		}
		
		$action = $this->post['action'];
		
		$this->createSession($auth['user']['adminref']);
		$message = App::Component($this->post['com'])->Helper('Service')->$action($this->post);
		$this->deleteSession();

		$message['token'] = base64_encode('{' . App::__Def()->sysConfig('APPRAINLICENSEKEY') . ':' . $auth['user']['adminref'] . ':' . $auth['user']['latestlogin'] . '}');
		$message['timestamp'] = $auth['user']['latestlogin'];
		$message['status'] = '1';

		$this->DisplayResult($message);
		
	}
	
	private function DisplayResult($message){
		echo json_encode($message);
		exit;
	}
	
	public function createSession($id=null){
		
		// Find Data
		/*$admin_login_info = App::Model('Admin')->findByUsername(
		
			App::Config()->Setting('system_default_a4m','user')
		
		);*/
		
		// Prepare Record 
		$admin_info_arr = array(
			'adminref' => $id,
			'status' => 'Admin',
			'f_name' => "",
			'l_name' => "",
			'email' => "",
			'admin_panel_tabs' => array()
		);
		
		// Create Session
		App::Load("Module/Session")->write('User', $admin_info_arr);
	}
	
	public function deleteSession(){
		
		App::Load("Module/Session")->Delete('User');
		
	}
}
