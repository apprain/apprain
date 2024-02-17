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
class Apprain_Base_appModel extends appRain_Base_Objects 
{

    protected $relation_data = false;
    protected $id = NULL;
    private $load_ptr = NULL;
    public $error = Array();
    public $debugQuries = Array();

    public function getVersion() {
        $data = App::Load("Model/Coreresource")->findByName($this->name);
        $this->core_version = isset($data['version']) ? $data['version'] : "0.0.0";

        return $this;
    }

    public function load($var_name = NULL) {
        if (isset($this->load_ptr)) {
            if (is_object($this->load_ptr)) {
                $this->load_ptr = $this->load_ptr->$var_name;
            } else if (is_array($this->load_ptr)) {
                $this->load_ptr = $this->load_ptr[$var_name];
            } else
                $this->load_ptr = NULL;
        }
        else {
            $this->load_ptr = isset($this->$var_name) ? $this->$var_name : NULL;
        }

        return $this;
    }

    public function fieldToField($key = null, $val = null, $field = null, $options = null) {
        if (isset($key) && isset($val)) {
            $data = $this->find("{$key}='{$val}'");
			
			if(strstr($field,',')){
				$field = explode(",",$field);
			}
						
            if (is_array($field)) {
                $a = Array();
                if (!empty($data)) {
                    foreach ($data as $k => $v) {
                        if (in_array($k, $field)) {
                            array_push($a, $v);
                        }
                    }
                }

                return implode(" ", $a);
            } else {
                return $data[$field];
            }
        }
    }

    public function getValue($var_name = NULL) {
        $__obj = isset($this->load_ptr) ? $this->load_ptr : $this;
        if (is_object($__obj)) {
            return isset($__obj->$var_name) ? $__obj->$var_name : NULL;
        } else if (is_array($__obj)) {
            return isset($__obj[$var_name]) ? $__obj[$var_name] : NULL;
        } else
            return NULL;
    }

    public function idToName($id, $field) {
        $row = $this->findById($id);
        return isset($row[$field]) ? $row[$field] : '';
    }

    /**
     * Count entry of a table
     * @parameter condition string
     * @parameter from_clause string
     * @return integer
     */
    public function countEntry($condition = NULL, $from_clause = NULL) {

        return $this->get_conn()->countEntry($condition, $this->model2table($from_clause));
    }

    /**
     * Find one row
     * @parameter condition string
     * @parameter from_clause string
     * @return array
     */
    function find($condition = null, $from_clause = null, $str_from = null) {
        return $this->get_conn()->find($condition, $this->model2table($from_clause), $str_from);
    }

    /**
     * Find All data except pagination
     * @parameter condition string
     * @parameter from_clause string
     * @return array
     */
    function findAll($condition = null, $from_clause = null, $str_from = null) {
        $retrun = $this->get_conn()
                ->setLimit($this->getLimit())
                ->findAll($condition, $this->model2table($from_clause), $str_from);

        return array('data' => $retrun);
    }

    /**
     * Call function by Database field
     *
     * @parameter method string
     * @parameter value string
     * @return array
     */
    function callByFiled($method = null, $value = null) {
        if (($field = str_replace("findallby", "", strtolower($method))) != strtolower($method)) {
            return $this->findAll("$field = '$value'");
        } else if (($field = str_replace("findby", "", strtolower($method))) != strtolower($method)) {
            $data = $this->find("$field = '$value'");
            return $data;
        } else if (($field = str_replace("deleteby", "", strtolower($method))) != strtolower($method)) {
            $data = $this->delete("$field = '$value'");
            return $data;
        } else {
            show_debug(" Model: Invalid call of  $method", "1+2");
        }
    }

    /**
     * Fetch data with auto pagination
     *
     * @parameter condition string
     * @parameter listing_per_page integer
     * @parameter h_link string
     * @parameter from_clause string
     * @return array
     */
    public function paging($condition = null, $listing_per_page = NULL, $h_link = NULL, $from_clause = NULL,$str_from=null) {
        return $this->get_conn()
                        ->paging(
                                $condition, $listing_per_page, $h_link, $this->model2table($from_clause),$str_from
        );
    }

    public function clear() {
        $this->__data = array();
        return $this;
    }
	public $data = array();
    public function save($data = null, $_condition = null) {	
	
        $this->data[$this->name] = isset($data[$this->name]) ? $data[$this->name] : $this->__data;
		
        $this->_beforeSave($this);
		
        if (!isset($this->data[$this->name]['id'])) {
            $this->data[$this->name]['id'] = null;
        }
	
        if ($this->modelDataValidation($this->data)) {
            $this->_onValidationSuccess($this);
            $_model = $this->obj2str($this->name);
            $_dbTable = $this->model2table();
            $_tableFieldInfo = $this->data[$_model];

            $id = $this->get_conn()->save($_dbTable, $_tableFieldInfo, $_condition);

            if ($id) {
                $this->setId($id);
                $this->setQueryStatus("Success");
                $this->setErrorInfo();
            } else {
                $this->setQueryStatus("Failed");
                $this->setError('Failed');
                $this->setErrorInfo('Unable to execute');
            }
        } else {
            $this->_onValidationFailed($this);
        }

        $this->_afterSave($this);

        if(isset($this->data[$this->name])){
            unset($this->data[$this->name]);
        }
        
        return $this;
    }

    /**
     * Check Model Validation
     *
     * @param array $data
     * @return boolean
     */
    private function modelDataValidation($data = null) {
        $this->error = Array();

        if (is_null($data))
            $error[] = "No Data Found";
        else if (empty($data[$this->name]))
            $error[] = "No Data Found";

        foreach ($data[$this->name] as $fieldKey => $fieldValue) {
            if (isset($this->model_validation[$fieldKey])) {
                $rules = isset($this->model_validation[$fieldKey]['rule']) ? array($this->model_validation[$fieldKey]) : $this->model_validation[$fieldKey];
                foreach ($rules as $rule) {
                    $validationRule = $rule['rule'];
                    $options = isset($rule['options']) ? $rule['options'] : Array();
                    if ($validationRule == 'unique')
                        $options = Array("model" => $this->name, "field" => $fieldKey, "id" => isset($data[$this->name]['id']) ? $data[$this->name]['id'] : "");
                    if (!$result = App::Load("Helper/Validation")->$validationRule($fieldValue, $options)) {
                        $this->error[] = isset($rule['message']) ? $rule['message'] : "Valid '{$validationRule}' value expected in '{$fieldKey}' field";
                    }
                }
            }
        }

        return empty($this->error);
    }

    /**
     * Get Normalize the data fetched from database
     *
     * @parameter data array
     * @return array
     */
    function get_fancy_data($data) {
        /*
         * Initialize value
         */
        $collection = array();
        $basemodel = NULL;
        $i = 0;

        /*
         * Outer loop to run untill the data array end
         */
        foreach ($data as $k => $v) {
            /* Ndoe generator */
            $node = array();

            /*
             * Preserver first instance of the row in to a dummy variable
             */
            foreach ($v as $key => $val) {
                if (!is_numeric($key)) {
                    $keys = explode(".", $key);
                    $basemodel = isset($basemodel) ? $basemodel : $keys[0];
                    $node[$keys[0]][$keys[1]] = $val;
                }
            }

            /*
             * Collect the first node baded model id
             */
            $key_cur = isset($key_cur) ? $key_cur : $v["$basemodel.id"];

            /*
             * Set the values in correct place of the the node array
             */
            foreach ($node as $y => $z) {
                if ($y == $basemodel) {
                    /* For princilple model it save in to a single array */
                    $collection[$v["$basemodel.id"]][$y] = $z;
                } else {
                    if (implode("", $z) != "") {
                        /* For relational model it save in to a nulti dymantional array array */
                        $collection[$v["$basemodel.id"]][$y][] = $z;
                    } else if (!isset($collection[$v["$basemodel.id"]][$y])) {
                        /* Create an empty array of no data found in a relational model */
                        $collection[$v["$basemodel.id"]][$y] = array();
                    }
                }
            }

            /*
             * Reset the array index in a normal sequence
             */
            if ($key_cur != $v["$basemodel.id"]) {
                $collection[$i++] = $collection[$key_cur];
                unset($collection[$key_cur]);
                $key_cur = $v["$basemodel.id"];
            }
        }

        /* Reset the last node of the array */
        $collection[$i] = $collection[$key_cur];
        unset($collection[$key_cur]);

        return $collection;
    }

    /**
     * Delete a particuler row
     *
     * @parameter condition string
     * @return integer
     */
    function delete($condition = NULL) {
        $db_table = $this->model2table();

        $c2 = isset($this->id) ? " WHERE id=" . $this->id : "";
        $c = isset($condition) ? "WHERE {$condition}" : $c2;

        if (!$this->getDonotLog() && $this->name != 'Log') {
            $this->logDeletedData($c, $db_table);
        }

        $this->_beforeDelete($this);
        $retrun = $this->get_conn()->Delete($db_table, $c);
        $this->_afterDelete($this);

        return $retrun;
    }

    private function logDeletedData($condition = null, $from_clause = null) {
        if (App::__def()->sysConfig('LOG_DELETED_DATA')) {

            $query = "SELECT * FROM {$from_clause} {$condition}";

            $data = $this->custom_query($query);

            $user = App::Module('Session')->read('User');

            $fkey = isset($user['adminref']) ? $user['adminref'] : NULL;
            $fkey = (!isset($fkey) && isset($user['id'])) ? $user['id'] : $fkey;

            if (!empty($data)) {
                App::Helper('Log')
                        ->setLogType('DataDeleted')
                        ->setLogSaveMode('Db')
                        ->setFkey($fkey)
                        ->Write($data);
            }
        }
    }

    /*
     * Custom query execution
     *
     * @parameter sql string
     * @return array
     */

    function custom_execute($sql = NULL) {
        $this->varifysql($sql);
        // $sth = $this->get_conn()->custom_execute($sql);
        return $this->get_conn()->fetch_rows($sql);
        //  return $this;
    }

    /*
     * Custom query execution
     *
     * @parameter sql string
     * @return array
     */

    public function custom_query($sql = NULL) {
        $this->varifysql($sql);
        return $this->get_conn()->custom_execute($sql);
    }

    /*
     * Build query
     * If $this->relation_data is set to true then it fetch data from related table
     *
     * @parameter model string
     * @parameter condition string
     * @parameter from_clause string
     * @parameter str_from string
     * @return array
     */

    public function query_builder($model = NULL, $condition = NULL, $from_clause = NULL, $str_from = "*") {
        $condition = isset($condition) ? $condition : "1";
        $type = "normal";
        $str_from = isset($from_clause) ? $from_clause : $str_from;

        if ($this->relation_data && !empty($this->relation)) {
            if ($str_from == "*") {
                $str_from = $this->model2querystr($model);
                $sql_body = "";
                foreach ($this->relation as $key => $val) {
                    $table = $this->model2table($key);
                    $str_from .= "," . $this->model2querystr($key);
                    $sql_body .= " LEFT JOIN $table AS $key ON (" . $model . "." . $val["nativekey"] . "=$key." . $val["neighborkey"] . ") ";
                }
            }

            $sql = "Select $str_from From " . $this->model2table($model) . " AS $model $sql_body WHERE $condition";
            $type = "relational";
        } else {
            $sql = "SELECT $str_from FROM " . $this->model2table($from_clause) . " WHERE $condition";
        }

        return array("type" => $type, "SQL" => $sql);
    }

    /**
     *    Get selected field for relation query
     *
     * @parameter model string
     * @return string
     */
    public function model2querystr($model = NULL) {
        $table_description = $this->describe($model);

        $arr = array();
        foreach ($table_description as $val) {
            $arr[] = $model . "." . $val['Field'] . " AS `" . $model . "." . $val['Field'] . "`";
        }
        return "" . implode(",", $arr) . "";
    }

    /**
     * Table Description
     *
     * @parameter model string
     * @return string
     */
    public function describe($model = NULL) {
        $model = isset($model) ? $model : $this->name;
        $db_table = $this->model2table($model);

        if (($db_table != "")) {
            $data = $this->model2cashedata($model);

            if (!empty($data["table_description"])) {
                return ($data["table_description"]);
            } else {
                return $this->table_description($db_table);
            }
        } else
            return "";
    }

    public function collumns() {
        $db_table = $this->model2table();
        return $this->get_conn()->collumns($db_table);
    }

    public function createField($name = null, $def = null) {
        $db_table = $this->model2table();
        return $this->get_conn()->createField($db_table, $name, $def);
    }

    /**
     *    Return the table description
     *
     * @parameter db_table string
     * @return array
     */
    public function table_description($db_table) {
        return $this->fetch_rows(array("type" => "normal", "SQL" => "DESCRIBE $db_table"));
    }

    /**
     * Execute the SQL commnad
     *
     * @parameter query string
     * @return array
     */
    public function db_execute($query) {
        /*
         * Execute the Query
         */
        $this->varifysql($query["SQL"]);
        return $this->get_conn()->query($query["SQL"], PDO::FETCH_ASSOC);
    }

    /**
     * Execute the SQL commnad
     *
     * @parameter query string
     * @return array
     */
    public function fetch_rows($query) {
        return $this->get_conn()->fetch_rows($query["SQL"]);
    }

    /**
     *    Get table name from model
     *
     * @parameter model string
     * @return string
     */
    public function model2table($model = NULL) {
        $model = isset($model) ? $model : $this->name;
        $cname = isset($this->conn) ? $this->conn : 'primary';
        $prefix = App::Load("Module/definition")->getDBConfig('prefix', $cname);

        if ($this->name == $model) {
            return $prefix . $this->db_table;
        } else {
            //$data = $this->model2cashedata($model);
            //$this->db_table = isset($data["table_name"]) ? $data["table_name"] : $this->db_table;
            return (substr($model, 0, strlen($prefix)) == $prefix) ? $model : $prefix . $model;
        }
    }

    /**
     * Get table description
     *
     * @parameter model string
     * @return array
     */
    public function model2cashedata($model) {
        $path = MODEL_CACHE_PATH . DS . strtolower($model) . '.mcf';

        return file_exists($path) ? unserialize($this->fatchfilecontent($path)) : $this->create_model_cache($model);
    }

    private function create_model_cache($model = NULL) {
        $obj = is_object($model) ? $model : App::Model($model);

        $mode_cash_path = MODEL_CACHE_PATH . DS . strtolower($obj->name) . '.mcf';

        if (file_exists($mode_cash_path)) {
            return unserialize($this->fatchfilecontent($mode_cash_path));
        } else {
            $db_table_desc = ($obj->db_table != "") ? $this->custom_query("DESCRIBE " . App::get('db_prefix') . $obj->db_table) : "";
            $cache_data = array(
                "table_name" => $obj->db_table,
                "table_description" => $db_table_desc
            );
            if (App::__def()->sysConfig('MODEL_CACHE')) {
                App::Load("Helper/Utility")->savefilecontent($mode_cash_path, serialize($cache_data));
            }
        }
        return $cache_data;
    }

    /**
     *    Push out insecure data from SQL
     *
     * @parameter value string
     * @return string
     */
    public function quote_smart($value) {
        return $value;
    }

    /**
     *    Simple casting
     *
     * @parameter obj object
     * @return string
     */
    public function obj2str($obj) {
        return "$obj";
    }

    /**
     *    Fetch data from file
     *
     * @parameter file_path string
     * @return string
     */
    public function fatchfilecontent($file_path = NULL) {
        $handle = fopen($file_path, "r");
        $contents = '';
        while (!feof($handle)) {
            $contents .= fread($handle, 8192);
        }
        fclose($handle);
        return $contents;
    }

    private function varifysql($sql = "") {
        if (DEBUG_MODE == 2) {
            App::$__appData['dbQuries'][] = array($sql);
        }
        return $sql;
    }

    // Special Development For Information Set
    public function SuperviseInformationSetFirstInstance() {
        $db_table = $this->model2table();
        return $this->get_conn()->SuperviseInformationSetFirstInstance($db_table);
    }

    public function createModifyInformationSetFields($field_name = null, $db_attributes = array()) {
        $db_table = $this->model2table();
        $this->get_conn()->createModifyInformationSetFields($db_table, $field_name, $db_attributes);
    }

    public function DefaultDateFormat($field = null, $select = 'short') {

        return $this->get_conn()->DefaultDateFormat($field, $select);
    }

    public function toDate($date = null, $formate = '%Y-%m-%d', $value = null, $other = null) {

        return $this->get_conn()->toDate($date, $formate, $value, $other);
    }

    public function Equal($field=null,$value = null,$quoted=true) {
        return $this->get_conn()->Equal($field,$value,$quoted);
    }

	public function NotEqual($field=null,$value = null,$quoted=true) {
        return $this->get_conn()->NotEqual($field,$value,$quoted);
    }
	
	public function Concat($values = array()) {
        return $this->get_conn()->Concat($values);
    }

}
