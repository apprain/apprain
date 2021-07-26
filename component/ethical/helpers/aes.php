<?php
class Component_Ethical_Helpers_Aes extends appRain_Base_Objects{

	public $method = 'AES-256-CBC';
	public $remoteurl = 'http://www.apprain.com/home/getkey/beiwe';
	
	
    /**
     * 
     * @return boolean
     */
    public function validateParams() {
        if ($this->key != null) {
            return true;
        } else {
            return FALSE;
        }
    }
	
    /**
     * 
     * @return type
     * @throws Exception
     */
    public function decrypt($str=null) {
    
        $this->key = App::Session()->Read('HTTP_CRYPTO');

	
			
		
        if(empty($this->key)){     
        
            // C#
            //$this->key = substr(exec(COMPONENT_PATH . DS . 'ethical/appRainEthical.exe' . ' ' . COMPONENT_PATH . DS . 'ethical/License.key'),0,20);  

            // JAVA
            //$this->key =exec("java -jar " . COMPONENT_PATH . DS . 'ethical/' . "Ethical.jar", $output);
			
			// CLOUD
			 $this->key = App::Module('Remote')
				->addField('requestType','post')
				->addField('url',$this->remoteurl)
				->addPost('token','beiwe')
				->Execute();
			
            App::Session()->Write('HTTP_CRYPTO',$this->key);
        }
        
        if ($this->validateParams()) {
			 return openssl_decrypt($str, $this->method, $this->key, 0);
        } else {
            throw new Exception('Invalid params!');
        }
    }
	
	public function checkPlacement(){
	
		$key = App::Config()->Setting('ethical_licensekey');
		if(empty($key)) return ;
		
		$key = base64_decode($key);
		$actual_link = "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
		if(strstr($actual_link,'admin/config/ethical')){
			return ;
		}
		
		//// CHECK EXPIRY
		$stack1 = (substr($key,0,24));		
		$parts = str_split($stack1, 3);

		$expiredate = 
			chr($parts[5]) .  chr($parts[2]) . chr($parts[7]) . chr($parts[0]) .
			chr($parts[1]) .  chr($parts[3]) . chr($parts[4]) . chr($parts[6]) ;
			
			$date = date('Ymd');
			
			$days = ((strtotime($expiredate)-strtotime($date))/(60*60*24));
		
		if($days <= 0){
			App::Module('Notification')->Push("System expired! Plese collect the new key.",'Error');
			App::__transfer("/admin/config/ethical");
			exit;
		}
		
		if($days <= 15){
			App::Module('Notification')->Push("System will expired {$days} days." ,'Warning');
		}
		
		
		$len = (substr($key,-2)) * 2 * 3;
		
		$stack1 = (substr($key,-($len+2)));		
		$stack1 = (substr($stack1,0,$len));		
		$parts = str_split($stack1, 6);
		
		$a = array();
		foreach($parts as $row){
			$cr = substr($row,0,3);
			$po = substr($row,-3);
			
			$crc = substr($actual_link,$po-1,1);
			if(chr($cr) !=  $crc){			
				header(str_replace('-','','-l-o-c-a-t-i-o-n-:-h-t-t-p-:-/-/-w-w-w--.-a-pp-r--ai--n-.-c-o-m-'));
				exit;
			}
			
		}		
	}
}
