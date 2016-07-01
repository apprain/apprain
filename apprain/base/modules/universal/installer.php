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
 *
 * This core resource is developer by Reazaul Karim, reazulk@gmail.com
 *
 */

class appRain_Base_Modules_Universal_Installer extends appRain_Base_Objects
{
    const OVERWRITE = false;
    const SUPPORTED_EXT = 'zip';
    const UNIVERSAL_DEFANATION_FILE_NAME = 'installer.xml';
    const ADVANCED = 'advanced';
    const SIMPLE = 'simple';
    public $restrictedPath = array(
        array('path' => '/webroot/uploads/filemanager'),
        array('path' => '/webroot/addons'),
        array('path' => '/webroot/componentroot'),
        array('path' => '/webroot/images'),
        array('path' => '/webroot/install', 'mode' => 'strict'),
        array('path' => '/webroot/js'),
        array('path' => '/webroot/themeroot'),
        array('path' => '/webroot/themeroot/admin', 'mode' => 'strict'),
        array('path' => '/webroot/uploads'),
        array('path' => '/webroot'),
        array('path' => '/component'),
        array('path' => '/development/cache', 'mode' => 'strict'),
        array('path' => '/development/controllers'),
        array('path' => '/development/definition', 'mode' => 'strict'),
        array('path' => '/development/helper'),
        array('path' => '/development/models'),
        array('path' => '/development/plugin'),
        array('path' => '/development/view'),
        array('path' => '/development/view/system', 'mode' => 'strict'),
        array('path' => '/development'),
        array('path' => '/apprain', 'mode' => 'strict')
    );
    public $errors = Array();
    private $mode = 'auto';
    private $source_auto_delete = true;
    private $resourcepath = "";
    private $definationPath = "";
    private $defaultinstallationpath = "";
    private $tmp_path = null;
    private $xmlObj = Array();
    private $name = "";
    private $isAutoCopy = true;

    private $_ftp = null;

    public function upload($fileRes)
    {
        if (!isset($this->tmp_path)) {
            $this->tmp_path = DATA;
        }

        $resFileExt = App::Helper('Utility')->getExt($fileRes['name']);

        $resName = App::Helper('Utility')->getName($fileRes['name']);

        if ($resFileExt != self::SUPPORTED_EXT) {
            $this->errors[] = "File does not support";
        }
        else if (
            file_exists($this->getDefaultinstallationpath() . DS . $resName)
        ) {
            $this->errors[] = "'{$resName}' Already Installed";
        }
        else if (!is_writable($this->tmp_path)) {
            $this->errors[] = "Path is no writeable '{$this->tmp_path}'";
        }
        else {
            $dirName = time();

            $this->tmp_path = $this->tmp_path . DS . $dirName;
            
			App::Helper('Utility')->createDir($this->tmp_path, 0777);
			
            $this->attachForcePermission($this->tmp_path);

            $fileInfo = App::Load("Helper/Utility")
                ->upload($fileRes, $this->tmp_path . DS);

            $this->setResourcePath($this->tmp_path . DS . $fileInfo['file_name']);
            $this->isAutoCopy = false;
        }

        return $this;
    }

    /* INSTALL RESOURCE
    =======================================================================*/
    public function Install()
    {
		
        if ($this->prepare()) {
            $this->temporary_extract()
                ->checkDefinition()
                ->executeCommand()
                ->clearResource();
        }

        return $this;
    }

    private function prepare()
    {
        if (!empty($this->errors)) {
            return false;
        }

        if (!isset($this->tmp_path)) {
			if ($this->getResourcePath()) {
				$this->tmp_path = dirname($this->resourcepath);
			}
			else {
				$this->tmp_path = DATA;
			}
        }

        if (is_bool($this->getSourceAutoDelete())) {
            $this->source_auto_delete = $this->getSourceAutoDelete();
        }

        if ($this->getResourcePath()) {
            $this->resourcepath = $this->getResourcePath();			
        }

        if (!file_exists($this->resourcepath)) {
            $this->errors[] = 'Source path not found: ' . $this->getResourcePath();
            return false;
        }

        $arr = preg_split('[\/|\\\|\.]', $this->resourcepath);
        $this->name = $arr[count($arr) - 2];

        if ($this->getDefaultInstallationPath()) {
            $this->defaultinstallationpath = $this->getDefaultInstallationPath();
        }

        if (!file_exists($this->defaultinstallationpath)) {
            $this->errors[] = 'Default Installation path is not correct: ' . $this->getResourcePath();
            return false;
        }

        $this->attachForcePermission($this->resourcepath);
        $this->attachForcePermission($this->defaultinstallationpath);

        return true;
    }

    private function temporary_extract()
    {
        if ($this->isAutoCopy) {
            $dirName = time();
            $this->tmp_path = $this->tmp_path . DS . $dirName;
            App::Helper('Utility')->createDir($this->tmp_path, 0777);
        }

        App::Module('Zip')
            ->setFileName($this->resourcepath)
            ->Extract($this->tmp_path);
        return $this;
    }

    private function checkDefinition($isResource = false)
    {
        if ($isResource) {
            $this->definationPath = $this->resourcepath . DS . self::UNIVERSAL_DEFANATION_FILE_NAME;
        }
        else {
            $this->definationPath = $this->tmp_path . DS . $this->name . DS . self::UNIVERSAL_DEFANATION_FILE_NAME;
        }
		
        if (!file_exists($this->definationPath)) {
            $this->mode = self::SIMPLE;
        }
        else {
            $this->xmlObj = simplexml_load_file($this->definationPath);
            $this->mode = self::ADVANCED;
        }

        return $this;
    }

	private function checkPathPermission(){
	
		$errorMst = array();
		if ($this->mode == self::SIMPLE){
			if(!is_writable($this->defaultinstallationpath)){
				$errorMst[] = $this->defaultinstallationpath;
			}
		}
		else{
			foreach ($this->xmlObj->command->copy as $command) {
			
                $des = $this->senitizePath((string)$command->des, true);
				$des = $this->aheaddir($des);
				if(!is_writable($des)){
					$errorMst[] = $des;
				}
			}
		}

		if(!empty($errorMst)){
			$this->errors = $this->__('Write Permission Required:') . '<br />' . implode('<br />',$errorMst);
		}
	}
	
	private function aheaddir($des=null){
		if(file_exists($des)){
			return $des;
		}
		else {
			return dirname($des);
		}
	}
	
	private function getFTPConn(){
	
		$ftpInfo = App::Config()->siteInfo();
		$ftpserver = isset($ftpInfo['ftpserver']) ? $ftpInfo['ftpserver'] : null;
		$ftpusername = isset($ftpInfo['ftpusername']) ? $ftpInfo['ftpusername'] : null;
		$ftppassword = isset($ftpInfo['ftppassword']) ? $ftpInfo['ftppassword'] : null;
		$ftpstatus = isset($ftpInfo['ftpstatus']) ? $ftpInfo['ftpstatus'] : null;

		if (
                isset($ftpserver) && isset($ftpusername) && isset($ftppassword) &&
                strtolower($ftpstatus) == 'enable'
            ) {
                if (!isset($this->_ftp)) {
                    $this->_ftp = App::Module('Ftp');
                    $this->_ftp->SetServer($ftpserver);
                    if(!$this->_ftp->connect()){
						$this->errors[] = 'Could not connect FTP';
					}
					
                    if(!$this->_ftp->login($ftpusername, $ftppassword)){
						$this->errors[] = 'Invalid FTP Login';
					}
					
                    $this->_ftp->SetType(FTP_AUTOASCII);
                    $this->_ftp->Passive(FALSE);

                }
        }		
	}
	
	private function ftpFullCopy($src,$des){
		$this->getFTPConn();
		
		if(!$this->_ftp->is_Exists($des)){
			$this->_ftp->mkDir($des);
		}
		$this->_ftp->mPut($src,$des, true);		
	}
	
    private function executeCommand()    
	{
		$this->checkPathPermission();
	
		if(empty($this->errors)){			

			if ($this->mode == self::SIMPLE) {
				App::Helper('Utility')
					->dirFullCopy(
					$this->tmp_path . DS . $this->name,
					$this->defaultinstallationpath . DS . $this->name,
					$this->getSourceOverwrite()
				);
			}
			else {
				foreach ($this->xmlObj->command->copy as $command) {
					$src = $this->senitizePath((string)$command->src);
					$des = $this->senitizePath((string)$command->des, true);
					App::Helper('Utility')->dirFullCopy($src, $des, $this->getSourceOverwrite());
				}

				$definition_path = $this->defaultinstallationpath . DS . $this->name . DS . self::UNIVERSAL_DEFANATION_FILE_NAME;

				if (file_exists($definition_path)) {
					$this->errors[] = "Already exists : {$definition_path}";
				}
				else {
					App::Helper('Utility')
						->Copy(
						$this->definationPath, $definition_path
					);
				}
			}
		}
		else {
			$this->errors = array();
			$this->getFTPConn();
			if(empty($this->errors)){	
				if ($this->mode == self::SIMPLE) {
					$src = $this->tmp_path . DS . $this->name;
					$des = $this->defaultinstallationpath . DS . $this->name;
					$this->ftpFullCopy($src, $des,$this->getSourceOverwrite());					
				}
				else {
				
					foreach ($this->xmlObj->command->copy as $command) {
						$src = $this->senitizePath((string)$command->src);
						$des = $this->senitizePath((string)$command->des, true);				
						$this->ftpFullCopy($src, $des,$this->getSourceOverwrite());
					}
				}
			}
		}
		
        return $this;
    }

    private function clearResource()
    {
        App::Helper('Utility')
            ->dirFullRemove(
            dirname($this->resourcepath)
        );
		
    }

    private function senitizePath($src = "", $isBase = false)
    {
        return ($isBase)
            ? App::Helper('Config')->rootDir($src)
            : $this->tmp_path . DS . $this->name . $src;
    }

    public function attachForcePermission($path = null)
    {

        if (isset($path) && file_exists($path) && !is_writable($path)) {

            $ftpInfo = App::Config()->siteInfo();
			
            $ftpserver = isset($ftpInfo['ftpserver']) ? $ftpInfo['ftpserver'] : null;
            $ftpusername = isset($ftpInfo['ftpusername']) ? $ftpInfo['ftpusername'] : null;
            $ftppassword = isset($ftpInfo['ftppassword']) ? $ftpInfo['ftppassword'] : null;
            $ftpstatus = isset($ftpInfo['ftpstatus']) ? $ftpInfo['ftpstatus'] : null;

            if (
                isset($ftpserver) && isset($ftpusername) && isset($ftppassword) &&
                strtolower($ftpstatus) == 'enable' 
            ) {
                if (!isset($this->_ftp)) {
                    $this->_ftp = App::Module('Ftp');
                    $this->_ftp->SetServer($ftpserver);
                    $this->_ftp->connect();
                    $this->_ftp->login($ftpusername, $ftppassword);
                    $this->_ftp->SetType(FTP_AUTOASCII);
                    $this->_ftp->Passive(FALSE);

                }
                $this->_ftp->chmod($path, 0777);
            }
            else {
                @chmod($path, 0777);
            }

            return $path;
        }		
    }

    /* UNINSTALL RESOURCE
    =======================================================================*/
    public function Uninstall()
    {
        $this->resourcepath = $this->getResourcePath();
        $this->checkDefinition(true)
            ->Run();
    }

    public function Run()
    {
        if ($this->mode == self::SIMPLE) {
            $this->attachForcePermission($this->resourcepath);
            App::Helper('Utility')
                ->dirFullRemove($this->resourcepath);
        }
        else {
            foreach ($this->xmlObj->command->copy as $command) {
                $cpath = (string)$command->des;
                if ($this->checkpathtodelete($cpath)) {
                    $path = $this->senitizePath($cpath, true);
                    if (file_exists($path)) {
                        $this->attachForcePermission($path);
                        App::Helper('Utility')->dirFullRemove($path);
                    }
                }
            }
        }
    }

    public function checkpathtodelete($path = null)
    {

        for ($i = 0; $i < count($this->restrictedPath); $i++) {

            $mode = isset($this->restrictedPath[$i]['mode'])
                ? $this->restrictedPath[$i]['mode'] : 'normal';

            if ($mode == 'normal') {
                if ($this->restrictedPath[$i]['path'] == $path OR $this->restrictedPath[$i]['path'] . DS == $path) {
                    return false;
                }
            }
            else {
                if (
                    substr($path, 0, strlen($this->restrictedPath[$i]['path'])) == $this->restrictedPath[$i]['path']
                    OR
                    substr($path, 0, strlen($this->restrictedPath[$i]['path'] . DS)) == $this->restrictedPath[$i]['path'] . DS
                ) {
                    return false;
                }
            }
        }
        return true;
    }
}