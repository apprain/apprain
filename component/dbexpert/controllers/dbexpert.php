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
class dbexpertController extends appRain_Base_Core
{
    public $name = 'dbexpert';
    
    public function __preDispatch(){
	
		$this->setAdminTab('developer');
        $this->page_title = $this->__("Database Expert");        		
	}

    public function indexAction($action=null)
    {
		
    }
	
	public function imexportAction($action = null, $dta = NULL){
		
        $this->page_title = "Backup Database";
        $import_err = "";
        $backup_err = "";
        $restore_err = "";


        if ($action == 'delete') {
            unlink(DATA . DS . "database/" . base64_decode($dta));
            App::Module('Notification')->Push($this->__("Deleted successfully"));
            $this->redirect('/dbexpert/imexport/');
            exit;
        }


        if (!empty($this->data)) {
            if (isset($this->data['ImExport']['export'])) {
                App::Component('DBExpert')->Helper('Dbimexport')->download = true;
                App::Component('DBExpert')->Helper('Dbimexport')->file_name = date("Y-m-d_h-i-s_A");
                App::Component('DBExpert')->Helper('Dbimexport')->export();
            }
            else if (isset($this->data['ImExport']['import'])) {
                if ($this->data['ImExport']['filename']['name'] == "") {
                    App::Module('Notification')->Push($this->__("Select a valid database file"), 'Error');
                }
                else {
                    $raw_file = App::Load("Helper/Utility")->upload($this->data['ImExport']['filename'], TEMP . DS);

                    App::Component('DBExpert')->Helper('Dbimexport')->import_path = TEMP . DS . $raw_file['file_name'];
                    App::Component('DBExpert')->Helper('Dbimexport')->import();

                    @unlink(App::Component('DBExpert')->Helper('Dbimexport')->import_path);
                    App::Module('Notification')->Push($this->__("Database Imported successfully"));
                }
            }
            else if (isset($this->data['ImExport']['backup'])) {
                App::Component('DBExpert')->Helper('Dbimexport')->file_name = $this->data['ImExport']['filename'];
                App::Component('DBExpert')->Helper('Dbimexport')->download_path = DATA . DS . "database";
                App::Component('DBExpert')->Helper('Dbimexport')->export();

                App::Module('Notification')->Push($this->__("Backup has created successfully."));
            }
            else if (isset($this->data['ImExport']['restore'])) {
                if ($this->data['ImExport']['file_name'] == "") {
                    App::Module('Notification')->Push($this->__("No Database file selected"), "Error");
                }
                else {
                    App::Component('DBExpert')->Helper('Dbimexport')->import_path = DATA . DS . "/database/{$this->data['ImExport']['file_name']}";
                    App::Component('DBExpert')->Helper('Dbimexport')->import();
                    App::Module('Notification')->Push("Database restored successfully to {$this->data['ImExport']['file_name']}");
                }
            }
            $this->redirect('/dbexpert/imexport/');
            exit;
        }

        $database_files = App::load("Helper/Utility")->getDirLising(DATA . DS . "database");
        $database_files['file'] = isset($database_files['file']) ? $database_files['file'] : array();
        $database_files_paging = App::Helper('Utility')->array_paginator($database_files['file'], array('limit' => 10));

        $this->set("database_files_paging", $database_files_paging);
        $this->set("database_files", $database_files);
        $this->set("restore_err", $restore_err);
        $this->set("import_err", $import_err);
        $this->set("backup_err", $backup_err);
	}
}