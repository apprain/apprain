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
 * @copyright  Copyright (c) 2010 appRain, Team. (http://www.apprain.org)
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
 * http ://www.apprain.org/general-help-center
 */
 
class Component_AppEditor_Helpers_Data extends appRain_Base_Objects
{

	public $ULUI = '';
	private $ExtList = array('php','phtml','css','js','xml','txt','sample');
	private $restricteddirs = array('.svn');
	
    public function getFullDirLisingTreeUI($dir = null)
    {
		App::Module('Cache')->path = BYTE_STREAM;		
		if( !App::Module('Cache')->exists('appeditorlist') ){
			$data = $this->createTreekList($dir);
			App::Module('Cache')->write('appeditorlist',$data);
		}
		else{			
			$data = App::Module('Cache')->read('appeditorlist');
 		}        
		return $data;
		
    }
	
	private function createTreekList($dir){
	
		$listDir = "";		
        if (!isset($dir)) return $listDir;

        if ($handler = opendir($dir)) {
			$listDir .= '<ul>';
            while (($sub = readdir($handler)) !== FALSE) {
                if ($sub != "." && $sub != "..") {
                    if (is_file($dir . "/" . $sub)) {	
						if(in_array(App::Utility()->getExt($sub),$this->ExtList)){
							$path = str_replace(App::Config()->rootDir("/"),"","{$dir}/{$sub}");
							$listDir .= "<li><span class=\"file-ico\">" . App::Html()->linkTag(App::Config()->baseUrl("/appeditor?loc={$path}"),$sub) . "</span></li>";
						}
						else {
							$listDir .= "<li><span class=\"file-ico\" title=\"Modification Disabled\">{$sub}</span></li>";
						}
						
                    } elseif (is_dir($dir . "/" . $sub) && !in_array($sub,$this->restricteddirs)) {
						$path = str_replace(App::Config()->rootDir("/"),"","{$dir}/{$sub}");
                        $listDir .= "<li><span class=\"folder\" title=\"{$path}\">{$sub}</span>" . $this->createTreekList($dir . "/" . $sub) . '</li>';
                    }
                }
            }
			$listDir .= '</ul>';
            closedir($handler);
        }

        return $listDir;
	}
	
	public function CreateResource($post=null){
		if(empty($post)){
			throw new AppException($this->__("Invalid post data."));
		}

		if(empty($post['resname'])){
			throw new AppException($this->__("Enter name correctly."));
		}
		
		$path = App::Config()->rootDir();
		if(!empty($post['loc'])){
			$path .= DS . $post['loc'];
		}
		
		if(!is_writable($path)){
			throw new AppException($this->__("Path is not write able({$path})"));
		}
		if($post['type'] == 'file'){
			$this->setPath($path)
				->CreateNewFile($post['resname']);
		}
		else {
			$this->setPath($path)
				->CreateFolder($post['resname']);
		}
	}
	
	private function CreateNewFile($filename=null){
	
		if(!in_array(App::Utility()->getExt($filename),$this->ExtList)){
			throw new AppException($this->__("Invalid extension of the file(try " . implode(',',$this->ExtList) .")"));
		}
		
		if(file_exists($this->getPath() . DS . $filename)){
			echo "File alredy exists on same path.";
			exit;
		}
		
		App::Utility()->savefilecontent($this->getPath() . DS . $filename,"");
	}
	
	private function CreateFolder($foldername=null){
		
		if(file_exists($this->getPath() . DS . $foldername)){
			echo "Folder alredy exists on same path.";
			exit;
		}
		
		App::Utility()->createDir($this->getPath() . DS . $foldername);
	}
	
	public function editordefaulttext(){
	    return 
'** Instruction :
=========================================================

Follow below steps:
1. click on "Open" button on top right of the window.
2. A popup will appear with a list of folders and files.
3. Find desired file and click to edit it.


Note: This editor do not allow to delete any file.
==========================================================';
	}
	
	public function savefilecontent($path = NULL, $content = NULL, $mode='w')
    {
        if (!$handle = fopen($path, $mode)) {
            echo "Cannot open file ($filename)";
            exit;
        }

        if (fwrite($handle, $content) === FALSE) {
            echo "Cannot write to file ($filename)";
            exit;
        }

        fclose($handle);
    }
	
	public function getQuickLinks(){
		$srr = '';
		
		$list = array(
			array('name'=>'Header','loc'=>'development/view/{current_theme}/elements/header.phtml'),
			array('name'=>'Footer','loc'=>'development/view/{current_theme}/elements/footer.phtml'),
			array('name'=>'Style','loc'=>'webroot/themeroot/{current_theme}/css/default.css'),
			array('name'=>'Common Functions','loc'=>'development/appcommon.php'),
			array('name'=>'Callback Functions','loc'=>'development/callbacks.php'),
			array('name'=>'Page Router','loc'=>'development/definition/uri_manager/page_router.xml')
		);
		
		
		
		foreach($list as $key=>$entry){
			$entry['loc'] = str_replace('{current_theme}', App::Config()->setting('theme'), $entry['loc']);
			if(file_exists(App::Config()->rootDir(DS . $entry['loc']))){
				if(!empty($srr)){
					$srr .= ' - ';
				}
				$srr .= App::Html()->linkTag(App::Config()->baseUrl("/appeditor?loc={$entry['loc']}"),$entry['name']);
			}
		}
		return $srr;
	}	
}