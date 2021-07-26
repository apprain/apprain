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
 * @copyright  Copyright (c) 2010 appRain, Inc. (http://www.apprain.org)
 * @license    http://www.opensource.org/licenses/mit-license.php MIT license
 *
 * HELP
 *
 * Official Website
 * http://www.apprain.org/
 *
 * Download Link
 * http://www.apprain.org/download
 *
 * Documents Link
 * http ://www.apprain.org/documents
 */
class appeditorController extends appRain_Base_Core
{
    public $name = 'appEditor';
    
    public function __preDispatch(){
	
		$this->setAdminTab('developer');
        $this->page_title = $this->__("Developer Page editor");        
		$this->set('admin_content_full_length',true);	
		
	}

    public function indexAction($action=null)
    {
		$this->addons = Array('tree','ace');	
		
		if($action == 'clear'){
			$queue = $this->ppinqueue($this->get['loc'],2);			
			exit;
		}
		
				
		if(!empty($this->post)){
			$path = App::Config()->rootDir(DS . $this->get['loc']);
			if(!is_writable($path)){
				echo App::Load("Module/Cryptography")
						->jsonEncode(
						array(
							"_status" => 'Error',
							"_message" => $this->__("Requested file is not writeable")
						)
					);
			}
			elseif(!file_exists($path)){
				echo App::Load("Module/Cryptography")
						->jsonEncode(
						array(
							"_status" => 'Error',
							"_message" => $this->__("Requested file does not exists")
						)
					);			
			}
			else{
				App::Component('AppEditor')->Helper('Data')->savefilecontent($path,$this->post['content'],'w');
			}
			exit;
		}
		
		$loc = '';
		$mode = 'html';
		$currentfilename = 'nonamed';
		if(isset($this->get['loc'])){
			$loc = $this->get['loc'];
			$this->ppinqueue($loc);
			$mode =  App::Utility()->getExt($loc);
			if(in_array($mode,array('js'))){
				$mode = 'javascript';
			}
			else if(in_array($mode,array('sql'))){
				$mode = 'mysql';
			}
			else if(in_array($mode,array('phtml'))){
				$mode = 'php';
			}
			$tmp = explode('/',($loc));
			$currentfilename = end($tmp);
		}
		$this->set('currentfilename',$currentfilename);
		
		$fileeditorqueue = App::Session()->Read('fileeditorqueue');
		$this->set('fileeditorqueue',$fileeditorqueue);		
		
		$this->set('loc',$loc);
		$this->set('mode',$mode);	
    }
	
	private function ppinqueue($loc=null,$flag=1){
		$queue = App::Session()->Read('fileeditorqueue');
		if($flag == 2){
			$newqueu = array();
			foreach($queue as $row){
				if($row != $loc){
					$newqueu[] = $row;
				}
			}			
			
			App::Session()->Write('fileeditorqueue',$newqueu);
			
			return $newqueu;
		}
		else if(!$queue || !in_array($loc,$queue)){
			$queue = array($loc);
			App::Session()->Write('fileeditorqueue',$queue);
			
			return $queue;
		}
	}
	
	public function createresourceAction(){
	    
	    $this->layout = 'empty';
	    
		if(!empty($this->post)){
			try {
				App::Component('appEditor')
					->Helper('Data')
					->CreateResource($this->post);
		
			}
			catch (AppException $e) {
				echo App::Load("Module/Cryptography")
					->jsonEncode(
					array(
						"_status" => 'Error',
						"_message" => $e->getMessage()
					)
				);
			}
			App::Load("Module/Developer")->setCacheType('byte_stream')->clearCache();
		}
	}
}
