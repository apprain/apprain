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
 * http ://www.apprain.org/documents
 *
 * Version 0.1.0 Beta
 */


class Component_DBExpert_Helpers_Dbimexport extends appRain_Base_Objects
{
    const PREFIX_REPLACE = "{_prefix_}";

    private $db_config = Array();
    public $download = false;
    public $download_path = "";

    public $file_name = NULL;
    public $file_ext = "sql";
    public $import_path = "";

    /**
     * Constract dbimexport constactor
     */
    public function __construct()
    {
        $this->db_config = $this->read_db_config();
    }

    /**
     *  Return Database configuration
     */
    private function read_db_config()
    {
        return App::Load("Module/definition")->getDBConfig();
    }

    private function setinize($dbSource)
    {
        return str_replace(self::PREFIX_REPLACE, $this->db_config['prefix'], $dbSource);
    }

    /**
     * Execute SQL comments
     */
    private function execute($sql)
    {
        $conn = $this->get_conn();

		return  $conn->custom_execute($this->setinize($sql));
		//pre($Return);
      //  $sth = $conn->prepare();
       // $sth->execute();
       // return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * End part of SQL statement
     */
    private function getEOL()
    {
        return ";\n";
    }

    /**
     * Get Table Difinition
     */
    private function getTables()
    {
        return $this->get_conn()->getTables();
    }

    /**
     * SQL statement delimeter
     */
    private function getBOL()
    {
        return "-- query\n";
    }

    /**
     * Reguler expressionSQL
     * statement delimiter
     */
    private function getRegExp()
    {
        return '/\-\- query/';
    }

    /**
     * Table Structure
     */
    private function _getDumpTable($table)
    {

        /*if (is_array($table)) {
            list($key, $table) = each($table);
        }*/
		
		$TabelDef = $this->execute("SHOW CREATE TABLE " . $table);
		$TabelDef = isset($TabelDef[0]) ? $TabelDef[0] : null;
		
        $getDumpTable = "";     		
		if(isset($TabelDef['create table'])){
			$q_getDumpTable = $this->execute("LOCK TABLES {$table} WRITE");
			$getDumpTable .= $this->getBOL() . "DROP TABLE IF EXISTS " . $table . $this->getEOL();		
			$getDumpTable .= $this->getBOL() . $TabelDef['create table'] . $this->getEOL();		
			$getDumpTable .= $this->_getInsertsTable($table);
			$this->execute("UNLOCK TABLES");
		}
		else{
			if(isset($TabelDef['create view'])){
				$start = (strpos($TabelDef['create view'],$table)-1);
				$end = strlen($TabelDef['create view']);
				$getDumpTable .= $this->getBOL() . "DROP VIEW IF EXISTS " . $table . $this->getEOL();		
				$getDumpTable .= $this->getBOL() . 'CREATE VIEW ' . substr($TabelDef['create view'],$start,$end) . $this->getEOL();			
			}
		}

        return $getDumpTable;
    }

    /**
     * Table data
     */
    private function _getInsertsTable($table)
    {

        $getInsertsTable = "";
        $result = $this->execute("SELECT * FROM " . $table);
		$DescTable = $this->execute("DESC " . $table);
		
		$datepointer = array();
		/*foreach($DescTable as $key=>$row){
			if($row['type'] == 'date'){
				$datepointer[$key] = $row['type'];
			}
			elseif($row['type'] == 'datetime'){
				$datepointer[$key] = $row['type'];
			}
		}*/

	
		
        foreach ($result as $row) {
            $getInsertsTables = "";
			$seq = 0;
            foreach ($row as $data) {
				if($seq){
					$getInsertsTables .= ',';
				}
				if(isset($datepointer[$seq])){
					if($datepointer[$seq] == 'datetime'){
						$getInsertsTables .= "to_date('{$data}','yyyy-mm-dd HH24:MI:SS')";
					}
					else{
						$getInsertsTables .= "to_date('{$data}','yyyy-mm-dd')";
					}
				}
				else{
					$getInsertsTables .= "'" . $this->getSafeData($data) . "'";
				}
				
				$seq++;
            }
//pre($getInsertsTables);
           // $getInsertsTables = substr($getInsertsTables, 0, -2);
            $getInsertsTable .= $this->getBOL() . 'INSERT INTO ' . $table . ' VALUES (' . $getInsertsTables . ')' . $this->getEOL();
        }

        return $getInsertsTable;
    }

    /**
     * Escape single quote by
     * MYSQL escape string
     */
    private function getSafeData($data)
    {
        return str_replace("'", "''", $data);
    }

    /**
     * Export SQL dump
     */
    public function export()
    {

        $dbTables = $this->getTables();

        $quries = "";
        foreach ($dbTables as $table) {
            $quries .= $this->_getDumpTable($table);
        }

        $database_name = (isset($this->file_name)) ? $this->file_name : $database_name;

        if ($this->download) {
            header("Content-type: text/{$this->file_ext}");
            header('Content-Disposition: attachment; filename="' . $database_name . '.' . $this->file_ext . '"');
            echo $quries;
            exit;
        }
        else {
            $filename = "{$this->download_path}/{$database_name}." . $this->file_ext;
            App::Helper('Utility')->savefilecontent($filename, $quries);
        }
    }

    /**
     * Import Databse
     *
     */
    public function import()
    {
        if ($this->import_path == "" || !file_exists($this->import_path)) {
            die("SQL Difinition file does not exist. Please select a backup file");
        }

        $data = App::Helper('Utility')->fatchfilecontent($this->import_path);
        $qureis = preg_split($this->getRegExp(), $data);

        foreach ($qureis as $query) {
            if ($this->isValidSQL($query)) {
                $this->execute($query);
            }
        }


    }

    /**
     * Validation
     */
    private function isValidSQL($sql)
    {
        return ($sql == "") ? false : true;
    }

    public function lastDBDate()
    {
        $database_files = App::load("Helper/Utility")->getDirLising(DATA . DS . "database");

        if (isset($database_files['file'])) {
            $database_files = App::Load("Helper/Utility")->multiArraySort($database_files['file'], 'filemtime', 'DESC');
            return $database_files[0]['filemtime'];
        }
        else {
            return "";
        }
    }
}
