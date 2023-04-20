<?php
class Component_Ethical_Helpers_Auth extends appRain_Base_Objects{
	
    /**
     * 
     * @return token
     */
    public function Login($post=null) {
		
		if(empty($post)){
			die("No credentials found.");
		}
		
		$time = time();
		$admin_name = isset($post['username']) ? $post['username'] : '';
        $admin_password = isset($post['password']) ? $post['password'] : '';
			
		$admin_login_info = App::Model('Admin')->findByUsername($post['username']);
		
		$admin_db_name = isset($admin_login_info["username"]) ? $admin_login_info["username"] : "";
        $admin_db_password = isset($admin_login_info["password"]) ? $admin_login_info["password"] : "";
		
		if ($admin_name == '' || $admin_password == '') {
			$error = 'NO_CREDENTIALS';
		} else if ($admin_login_info['status'] != "Active") {
			$error = 'NOT_ACTIVE';
		} 
		else if (($admin_name == $admin_db_name) && (App::Module("Cryptography")->checkEncrypt($admin_password, $admin_db_password))) {
			
			$admin_tab_access = '';
			if (strtolower($admin_login_info["type"]) == "super") {
				$error = 'SUPER_PREVELIEGE_CANNOT_LOGIN';
				echo $error;exit;
			} else {
				$admin_tab_access = ($admin_login_info["acl"] != "") ? array_keys(unserialize($admin_login_info["acl"])) : Array();
			}
				
			if (!empty($admin_tab_access)) {

				App::Model('Admin')
					->setId($admin_login_info['id'])
					->setLatestLogin($time)
					->setLastlogin($admin_login_info['latestlogin'])
					->Save();
			
				$admin_info_arr = array(
						
                        'adminref' => $admin_login_info['id'],
                        'status' => 'Active',
                        'f_name' => $admin_login_info['f_name'],
                        'l_name' => $admin_login_info['l_name'],
                        'email' => $this->get_config('admin_email'),
						'latestlogin' => $time,
                        'admin_panel_tabs' => $admin_tab_access
                    );
					
				return array('status'=>1,'user'=>$admin_info_arr);
			}
			else{
				$error = 'NOT_ENOUGH_TAB_PREVELIEGE';
			}
		}
		else {
                $error = 'INVALID_CREDENTIALS';
            }	

		return array('status'=>2,'message'=>$error);
    }
	
	/**
     * 
     * @return token
     */
    public function renew($post=null) {
        
		$returndata = $this->VerifyToken($post['token']);

		if($returndata['status'] != 1){
			return array('status'=>2,'message'=>$returndata['message']);
		}
		
		$time = time();
		$admin_login_info = $returndata['user'];
		
		App::Model('Admin')
			->setId($admin_login_info['id'])
			->setLatestLogin($time)
			->setLastlogin($admin_login_info['latestlogin'])
			->Save();
		
		$admin_info_arr = array(				
				'adminref' => $admin_login_info['id'],
				'latestlogin' => $time,
			);
			
		return array('status'=>1,'user'=>$admin_info_arr);		
    }
	
	
	private function verifyToken($token=null){
		
		if(empty($token)){
			return array('status'=>2,'message'=>'INVALID_TOKEN');
		}
		
		$line = preg_split('/\}|\{|\:/',base64_decode($token));
		
		$licenseKey = $line[1];
		$adminRef = $line[2];
		$latestlogin = $line[3];
		
		$Admin = App::Model('Admin')->findById($adminRef);

		if(empty($Admin)){
			$error = 'INVALID_USER';
		}
		if($Admin['status'] != 'Active'){
			$error = 'USER_LOCKED';
		}
		
		if(!empty($error)){
			return array('status'=>2,'message'=>$error);
		}
		else{
			return array('status'=>1,'user'=>$Admin);
		}
		
	}
	
   
}
