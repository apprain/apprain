<?php
class Component_Ethical_Helpers_Data extends appRain_Base_Objects{
	
    public function WriteLog($message=null,$fkey='API-CALL') {
		
		 App::Helper('Log')
			->setLogType('API')
			->setFkey($fkey)
			->Write($message);
		
	}
}
