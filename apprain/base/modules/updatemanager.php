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

class  appRain_Base_Modules_Updatemanager extends appRain_Base_Objects
{
    private $soapObj = null;
    private $defFileName = 'definition.xml';

    private function getService()
    {
        if (!isset($soapObj)) {
            $soapObj = new soapclient(App::Load("Helper/Config")->baseurl("/developer/webservice/Versionupdate/wsdl"));
        }

        return $soapObj;
    }

    public function getNewVersion()
    {
        $newversion = App::Load("Module/Session")->read('newversion');

        if ($newversion == "") {
            $newversion = $this->getService()->getNewVersion(App::__def()->sysConfig('APPRAINVERSION'));

            if ($newversion != "NoUpdateAvailable") {
                App::Load("Module/Session")->write('newversion', $newversion);
            }
        }

        return $newversion;
    }

    public function checkappupdate($licensekey = NULL)
    {
        $newversion = $this->getNewVersion();

        if ($licensekey == "") {
            throw new AppException($this->__("Enter A Valid License Key"));
        }
        else if ($newversion == 'NoUpdateAvailable') {
            throw new AppException($this->__("No New version available."));
        }
        else {
            $this->appUpdateManagerAuthontication($licensekey);
        }
    }

    /**
     * @return string
     */
    private function appUpdateManagerAuthontication($licensekey)
    {
        /* Webservice url */
        $url = App::Load("Helper/Config")->baseurl("/developer/webservice/Versionupdate/wsdl");

        $client = new soapclient($url);

        $version = (string)app::__def()->sysConfig('APPRAINVERSION');

        // Connect in Webservice
        $flag = $client->checkupdate($licensekey, $version);

        if ($flag == 0) {
            throw new AppException($this->__("Sorry! Invalid License Key."));
        }
        else if ($flag == 1) {
            throw new AppException($this->__("This Version Is updated."));
        }
        else {
            $this->updateApprainDefinitaion('appRainLicenseKey', $licensekey);
            return $flag;
        }

    }

    private function updateApprainDefinitaion($type = NULL, $value = NULL)
    {
        if (!isset($type) || !isset($value)) return false;

        $file_path = CONFIG_PATH . DS . "config.xml";
        $definition = array();
        $dom = new DOMDocument();
        $dom->load($file_path);

        $dom->getElementsByTagName('Configuration')
            ->item(0)
            ->getElementsByTagName('base')
            ->item(0)
            ->getElementsByTagName($type)
            ->item(0)
            ->nodeValue = $value;

        if (is_writable($file_path)) {
            $dom->save($file_path);
        }
        else {
            throw new AppException($this->__("{$file_path} is not write able"));
        }
    }

    public function getdefinition()
    {
        if (is_writable($this->getSrcPaths("backup_path"))) {
            $this->preparebackup();
        }
        else {
            return (Array("status" => "Failed", "message" => $this->__("<span style=\"color:red\">Access denied to create Directory.(path: " . $this->getSrcPaths("backup_path") . ")</span>")));
        }

        $defContent = $this->getUpdateDefinition($this->getNewVersion());

        $this->setNextStep('parseDefinition');

        if (!file_exists($this->getSrcPaths('definition', $this->defFileName))) {
            if (is_writable($this->getSrcPaths('definition'))) {
                App::Load("Helper/Utility")->createFile($defContent, $this->getSrcPaths('definition', $this->defFileName));
                throw new AppException($this->__("Definition retrived successfully. Now Parsing it..."));
            }
            else {
                return (Array("status" => "Failed", "message" => $this->__("Access denied to create Definition XML.(path: " . $this->getSrcPaths('definition') . ")")));
            }
        }
        else {
            throw new AppException($this->__("Definition already downloaded. Now checking Definition XML Data..."));
        }
    }

    // Prepare Backup folder
    private function preparebackup()
    {
        if (!file_exists($this->getSrcPaths())) App::Load("Helper/Utility")->createDir($this->getSrcPaths());
        if (!file_exists($this->getSrcPaths('oldfiles'))) App::Load("Helper/Utility")->createDir($this->getSrcPaths('oldfiles'));
        if (!file_exists($this->getSrcPaths('newfiles'))) App::Load("Helper/Utility")->createDir($this->getSrcPaths('newfiles'));
        if (!file_exists($this->getSrcPaths('definition'))) App::Load("Helper/Utility")->createDir($this->getSrcPaths('definition'));
    }

    // Parse the Definition
    public function parsedefinition()
    {
        $defination = App::Load('Module/Session')->read('definition');

        if (!$defination) {
            $steps = Array('preparation', 'createbackup', 'download', 'review', 'install');
            $dom = new DOMDocument();
            $dom->load($this->getSrcPaths('definition', 'definition.xml'));

            $defination = Array();

            $operation = $dom->getElementsByTagName('definition')->item(0)->getElementsByTagName('operaion')->item(0);

            foreach ($steps as $step) {
                //Read Preparation
                $commands = $operation->getElementsByTagName($step)->item(0)->getElementsByTagName('command');
                foreach ($commands as $command) {
                    $tmpcmd = Array();
                    $tmpcmd['name'] = $command->getElementsByTagName('name')->item(0)->nodeValue;

                    foreach ($command->getElementsByTagName('params')->item(0)->getElementsByTagName('param') as $param) {
                        $tmpcmd['param'][$param->getAttribute('name')] = $param->nodeValue;
                    }
                    $defination[$step][] = $tmpcmd;
                }

            }

            $defination = App::Load('Module/Session')->write('definition', $defination);
            throw new AppException($this->__("Definition Parsing is done. Now Preparing Installation..."));
        }
        else {
            throw new AppException($this->__("Definition Parsing alredy done before. Now Checking Installation environment..."));
        }


    }

    public function createbackup($flag)
    {
        $cmd = App::Load('Module/Session')->read('createbackup_cmd');
        $cmd = ($flag == "start") ? 0 : $cmd;

        $createbackup = $this->getDefinitionInfo('createbackup');

        $return = $this->executeCommand($createbackup[$cmd]);

        if (isset($preparation[($cmd + 1)])) {
            $cmd = App::Load('Module/Session')->write('createbackup_cmd', ($cmd + 1));
            $return['status'] = 'continue';
        }
        else {
            $return['status'] = 'complete';
        }

        return $return;
    }

    public function preparation($flag)
    {
        $cmd = App::Load('Module/Session')->read('preparation_cmd');
        $cmd = ($flag == "start") ? 0 : $cmd;

        $preparation = $this->getDefinitionInfo('preparation');

        $return = $this->executeCommand($preparation[$cmd]);

        if (isset($preparation[($cmd + 1)])) {
            $cmd = App::Load('Module/Session')->write('preparation_cmd', ($cmd + 1));
            $return['status'] = 'continue';
        }
        else {
            $return['status'] = 'complete';
        }

        return $return;
    }

    public function createfilebackup($flag)
    {
        $cmd = App::Load('Module/Session')->read('createbackup_cmd');
        $cmd = ($flag == "start") ? 0 : $cmd;

        $createbackup = $this->getDefinitionInfo('createbackup');
        $return = $this->executeCommand($createbackup[$cmd]);

        if (isset($createbackup[($cmd + 1)])) {
            $cmd = App::Load('Module/Session')->write('createbackup_cmd', ($cmd + 1));
            $return['status'] = 'continue';
        }
        else {
            $return['status'] = 'complete';
        }

        return $return;
    }

    public function download($flag)
    {
        $cmd = App::Load('Module/Session')->read('download_cmd');
        $cmd = ($flag == "start") ? 0 : $cmd;

        $download = $this->getDefinitionInfo('download');

        $return = $this->executeCommand($download[$cmd]);

        if (isset($download[($cmd + 1)])) {
            $cmd = App::Load('Module/Session')->write('download_cmd', ($cmd + 1));
            $return['status'] = 'continue';
        }
        else {
            $return['status'] = 'complete';
        }

        return $return;
    }

    public function install($flag)
    {
        $cmd = App::Load('Module/Session')->read('install_cmd');
        $cmd = ($flag == "start") ? 0 : $cmd;

        $install = $this->getDefinitionInfo('install');

        $return = $this->executeCommand($install[$cmd]);

        if (isset($install[($cmd + 1)])) {
            $cmd = App::Load('Module/Session')->write('install_cmd', ($cmd + 1));
            $return['status'] = 'continue';
        }
        else {
            $return['status'] = 'complete';
        }

        return $return;
    }

    public function complete()
    {
        $newversion = App::Load("Module/Session")->read('newversion');
        $this->updateApprainDefinitaion('appRainversion', $newversion);

        App::Load("Module/Session")->delete('newversion');
        App::Load("Module/Session")->delete('definition');
        App::Load("Module/Session")->delete('review_cmd');

        return Array('state' => 'Done', 'message' => $this->__("Enjoy your new Version ({$newversion})"));
    }

    public function review($flag)
    {
        $cmd = App::Load('Module/Session')->read('review_cmd');
        $cmd = ($flag == "start") ? 0 : $cmd;

        $review = $this->getDefinitionInfo('review');

        $return = $this->executeCommand($review[$cmd]);

        if (isset($review[($cmd + 1)])) {
            $cmd = App::Load('Module/Session')->write('review_cmd', ($cmd + 1));
            $return['status'] = 'continue';
        }
        else {
            $return['status'] = 'complete';
        }

        return $return;
    }

    private function executeCommand($options)
    {
        switch ($options['name']) {
            case 'checkfile'    :
                $file_path = App::Load('Helper/Config')->rootdir($options['param']['path'] . DS . $options['param']['filename']);

                if (App::Load("Helper/Utility")->checkFile($file_path)) $return = Array('state' => 'Done', 'message' => $this->__("Required File Exists {$options['param']['filename']}."));
                else $return = Array('state' => 'Done', 'message' => $this->__("<span style=\"color:red\">Required File Does not Exists {$options['param']['filename']}.</span>"));
                break;
            case 'mkdir'    :
                $dir_path = App::Load('Helper/Config')->rootdir($options['param']['path'] . DS . $options['param']['dirname']);

                if (is_writable($dir_path)) {
                    App::Load("Helper/Utility")->createDir($dir_path);
                    $return = Array('state' => 'Done', 'message' => $this->__("Directory Created successfully (Dir Name: {$options['param']['dirname']}). "));
                }
                else {
                    $return = Array('state' => 'Failed', 'message' => $this->__("<span style=\"color:red\">Access denied  to create Directory (Dir Name: {$dir_path}). "));
                }
                break;
            case 'copy'        :
                $src_path = App::Load('Helper/Config')->rootdir($options['param']['srcpath'] . DS . $options['param']['srcfilename']);
                $des_path = App::Load('Helper/Config')->rootdir($options['param']['despath'] . DS . $options['param']['desfilename']);

                if (is_writable(App::Load('Helper/Config')->rootdir($options['param']['srcpath']))) {
                    App::Load("Helper/Utility")->copyFile($src_path, $des_path);
                    $return = Array('state' => 'Done', 'message' => $this->__("File Copied successfully (File Name: {$options['param']['srcfilename']})"));
                }
                else {
                    $return = Array('state' => 'Failed', 'message' => $this->__("<span style=\"color:red\">Access denied to Copy file (Path: {$des_path})</span>"));
                }
                break;
            case 'dwnfile'    :
                $content = $this->getService()->download($this->getNewVersion(), $options['param']['code']);
                $path = App::Load('Helper/Config')->rootdir($options['param']['savepath'] . DS . $options['param']['filename']);

                if (is_writable(App::Load('Helper/Config')->rootdir($options['param']['savepath']))) {
                    App::Load("Helper/Utility")->createFile($content, $path);
                    $return = Array('state' => 'Done', 'message' => $this->__("File Downloaded and saved (File Name  : {$options['param']['filename']})"));
                }
                else {
                    $return = Array('state' => 'Failed', 'message' => $this->__("<span style=\"color:red\">Access denied to create file (Path: $path)</span>"));
                }
                break;
            case 'overwite'    :
                $src_path = App::Load('Helper/Config')->rootdir($options['param']['srcpath'] . DS . $options['param']['srcfilename']);
                $des_path = App::Load('Helper/Config')->rootdir($options['param']['despath'] . DS . $options['param']['desfilename']);

                if (is_writable($des_path)) {
                    App::Load("Helper/Utility")->copyFile($src_path, $des_path);
                    $return = Array('state' => 'Done', 'message' => $this->__("File Installed and saved {$options['param']['srcfilename']}"));
                }
                else
                    $return = Array('state' => 'Failed', 'message' => $this->__("<span style=\"color:red\">Access denied to overwrite file (Path: $des_path)</span>"));
                    {

                    }
                break;

            default            :
                break;
        }

        return $return;
    }

    private function getDefinitionInfo($flag)
    {
        $defination = App::Load('Module/Session')->read('definition');
        return isset($defination[$flag]) ? $defination[$flag] : $defination;
    }

    private function getSrcPaths($select = "default", $subpart = "")
    {
        $path = BACKUP . DS . "version" . DS . $this->getNewVersion();

        switch ($select) {
            case "definition"   :
                return "{$path}/definition/{$subpart}";
                break;
            case "oldfiles"     :
                return "{$path}/oldfiles/{$subpart}";
                break;
            case "newfiles"     :
                return "{$path}/newfiles/{$subpart}";
                break;
            case "backup_path"  :
                return BACKUP . DS . "version/{$subpart}";
                break;
            default             :
                return "{$path}/{$subpart}";
        }
    }

    private function getUpdateDefinition()
    {
        return $this->getService()->getDefinition($this->getNewVersion());
    }
}