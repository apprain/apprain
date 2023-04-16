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

class appRain_Base_Modules_log extends appRain_Base_Objects
{
    // fkey type dated data
    private $fkey = NULL;
    private $type = 'debug';
    private $dated = NULL;
    private $data = "";
    private $save_mode = "File"; // Db/File
    public $log_file_name = "app.log";

    const MESSGE_ADMIN_GENERAL = 'admin-general';
    const MESSGE_ADMIN_DASHBOARD = 'admin-dashboard';
	
	public function __construct(){
		
		$file = App::Config()->get('baseurl');
		$this->log_file_name = str_replace("/","_",$file) . "_app.log";
		
		$path = REPORT_CACHE_PATH . DS . $this->log_file_name;
		if(!file_exists($path)){
			file_put_contents($path,"");
		}
	}

    /**
     * Prepare the data set
     */
    private function preparedataset()
    {
        $this->fkey = $this->getfkey();
		
        // Set Log type
        $type = $this->getLogType();
        $this->type = isset($type) ? $type : $this->type;

        // Set Dated
        $this->dated = App::Load("Helper/Date")->getDate('Y-m-d H:i:s a');

        //Set Data
        $logsavemode = $this->getLogMessage();
        $this->data = isset($logsavemode) ? $logsavemode : $this->data;
        $this->data = is_string($this->data) ? $this->data : serialize($this->data);

        // Set Debug Save Mode
        $logsavemode = $this->getLogSaveMode();
        if (isset($logsavemode)) $this->save_mode = $logsavemode;
        else if (strtolower($this->type) == 'query') $this->save_mode = 'Db';
        else $this->save_mode = 'File';
    }

    /**
     * Save Log data
     */
    public function save()
    {

        if (strtolower($this->save_mode) == 'db') {
			
            App::Model("Log")
                ->setFkey($this->fkey)
                ->setType($this->type)
                ->setDated($this->dated)
                ->setData($this->data)
                ->Save();
        }
        else {	
            error_log(sprintf("%s \t %s \t %s \t %s  \t %s \n", $this->fkey, $this->type, $this->dated, App::Config()->getServerInfo('REMOTE_ADDR'), $this->data), 3, REPORT_CACHE_PATH . DS . $this->log_file_name);
        }

    }

    public function Write($msg = NULL)
    {
        if ($this->getDonotLog()) return;

        // Set the message if it direct come from Write function
        if (isset($msg)) {
            $this->data = $msg;
        }

        // Premare data set
        $this->preparedataset();

        // Save Data to logged
        $this->save();
    }
	
	public function clear(){
		
		file_put_contents(REPORT_CACHE_PATH . DS . $this->log_file_name,'');
		//die("FX Disabled");
	}


    public function readFullLog($model = 'file')
    {
        return App::Helper('Utility')->fetchFile(REPORT_CACHE_PATH . DS . $this->log_file_name);
    }
}