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
 * @copyright  Copyright (c) 2010 appRain, Team. (http://www.apprain.com)
 * @license    http://www.opensource.org/licenses/mit-license.php MIT license
 *
 * HELP
 *
 * Official Website
 * http://www.apprain.com/
 *
 * Download Link
 * http://www.apprain.com/download
 *
 * Documents Link
 * http ://www.apprain.com/docs
 */

class Apprain_Base_appModel extends appRain_Base_Objects
{
    protected $relation_data = false;
    protected $id = NULL;
    private $load_ptr = NULL;
    public $error = Array();
    public $debugQuries = Array();

    public function getVersion()
    {
        $data = App::Load("Model/Coreresource")->findByName($this->name);
        $this->core_version = isset($data['version']) ? $data['version'] : "0.0.0";

        return $this;
    }

    public function load($var_name = NULL)
    {
        if (isset($this->load_ptr)) {
            if (is_object($this->load_ptr)) {
                $this->load_ptr = $this->load_ptr->$var_name;
            }
            else if (is_array($this->load_ptr)) {
                $this->load_ptr = $this->load_ptr[$var_name];
            }
            else $this->load_ptr = NULL;
        }
        else {
            $this->load_ptr = isset($this->$var_name) ? $this->$var_name : NULL;
        }

        return $this;
    }

    public function fieldToField($key = null, $val = null, $field = null, $options = null)
    {
        if (isset($key) && isset($val)) {
            $data = $this->find("{$key}='{$val}'");
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
            }
            else {
                return $data[$field];
            }
        }
    }

    public function getValue($var_name = NULL)
    {
        $__obj = isset($this->load_ptr) ? $this->load_ptr : $this;
        if (is_object($__obj)) {
            return isset($__obj->$var_name) ? $__obj->$var_name : NULL;
        }
        else if (is_array($__obj)) {
            return isset($__obj[$var_name]) ? $__obj[$var_name] : NULL;
        }
        else return NULL;
    }

	public function idToName($id,$field,$b,$c){
		$data = $this->findById($id);
		return isset($row[$field]) ? $row[$field] : '';
	}
	
    /**
     * Count entry of a table
     *
     * @parameter condition string
     * @parameter from_clause string
     * @return integer
     */
    public function countEntry($condition = NULL, $from_clause = NULL)
    {
        /*
         * Build Query
         */
        $query = $this->query_builder($this->name, $condition, $from_clause, "count(*) as cnt");

        /*
         *	Feach data based on SQL
         */
        $data = $this->fetch_rows($query);

        /*
        * Return fetched data
        */
        return isset($data[0]["cnt"]) ? $data[0]["cnt"] : 0;
    }

    /**
     *    Find one row
     *
     * @parameter condition string
     * @parameter from_clause string
     * @return array
     */
    function find($condition = NULL, $from_clause = NULL, $str_from = null)
    {
		$str_from = isset($str_from) ? $str_from : '*';
        $query = $this->query_builder($this->name, $condition, $from_clause, $str_from);
        $this->varifysql($query['SQL']);
        $sth = $this->get_conn()
            ->prepare($query['SQL']);
        $sth->execute();
        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Find All data except pagination
     *
     * @parameter condition string
     * @parameter from_clause string
     * @return array
     */
    function findAll($condition = NULL, $from_clause = NULL, $str_from = null)
    {
		$str_from = isset($str_from) ? $str_from : '*';
        $query = $this->query_builder($this->name, $condition, $from_clause, $str_from);
        $this->varifysql($query['SQL']);
        $sth = $this->get_conn()
            ->prepare($query['SQL']);
        $sth->execute();
        return Array("data" => $sth->fetchAll(PDO::FETCH_ASSOC));
    }

    /**
     * Call function by Database field
     *
     * @parameter method string
     * @parameter value string
     * @return array
     */
    function callByFiled($method = NULL, $value = NULL)
    {
        if (($field = str_replace("findallby", "", strtolower($method))) != strtolower($method)) {
            return $this->findAll("$field = '$value'");
        }
        else if (($field = str_replace("findby", "", strtolower($method))) != strtolower($method)) {
            $data = $this->find("$field = '$value'");
            return $data;
        }
        else if (($field = str_replace("deleteby", "", strtolower($method))) != strtolower($method)) {
            $data = $this->delete("$field = '$value'");
            return $data;
        }
        else {
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
    function paging($condition = "1", $listing_per_page = NULL, $h_link = NULL, $from_clause = NULL)
    {
        /*
        * General link
        */
        $h_link = isset($h_link) ? $h_link : '?';

        /*
         * Read the page number
         */
        $page = isset($_GET['page']) ? $_GET['page'] : "1";

        /*
        * Total page
        */
        $total = $this->countEntry($condition, $from_clause);

        /*
        * List per page
        */
        $listing_per_page = isset($listing_per_page) ? $listing_per_page : app::Config()->Setting('default_pagination');
		$listing_per_page = (empty($listing_per_page) or !is_numeric($listing_per_page)) ?  $total : $listing_per_page;

        /*
        * Tota page in the selection
        */
        $tpage = isset($listing_per_page) && ($listing_per_page != 0) ? ceil($total / $listing_per_page) : $total;

        /*
        *	Total page
        */
        $spage = ($tpage == 0) ? ($tpage + 1) : $tpage;
        $startfrom = ($page - 1) * $listing_per_page;
        $endto = ($page) * $listing_per_page;
        if ($endto > $total) {
            $endto = $total;
        }
        $page_no = "";
        $s = $i = $page - 5;
        $s = ($s < 1) ? 1 : $s;
        $sp_link = '';
        for ($i = $s; $i <= $page + 5 && $i <= $tpage; $i++) {
            if ($i == $page) {
                $page_no .= "<strong classs=\"page_selected\">" . $this->__($i) . "</strong> ";
            }
            else {
                $page_no .= '<a href="' . $h_link . '&page=' . $i . '">' . $this->__($i) . '</a> ';
            }

            $sp_link .= ($i == $page) ? "<li class=\"current\">{$i}</li>" : '<li><a href="' . $h_link . '&page=' . $i . '">' . $i . '</a> </li>';
        }

        /**
         * Bulid  link
         */
        $link = ($page_no != "") ? "Showing Results " . ($startfrom + 1) . "-$endto of $total" : "";

        /**
         * Build Pagination string
         */
        $paging = '';
        $sp_prev = '<li class="disabled">' . PREVIOUS_PAGE . '</li>';
        $sp_next = '<li class="disabled">' . NEXT_PAGE . '</li>';
        if ($tpage > 1) {
            $nextpage = $page + 1;
            $prevpage = $page - 1;

            $prevlink = '<a href="' . $h_link . '&amp;page=' . $prevpage . '" class="page_previous" title="' . $this->__(PREVIOUS_PAGE) . '">' . $this->__(PREVIOUS_PAGE) . '</a>';
            $nextlink = '<a href="' . $h_link . '&amp;page=' . $nextpage . '" class="page_next" title="' . $this->__(NEXT_PAGE) . '">' . $this->__(NEXT_PAGE) . '</a>';

            if ($page == $tpage) {
                $paging = "$prevlink";
                $sp_prev = "<li>$paging</li>";
                $sp_next = '<li class="disabled">' . NEXT_PAGE . '</li>';

            }
            elseif ($tpage > $page && $page > 1) {
                $paging = "$prevlink | $nextlink";
                $sp_prev = "<li>$prevlink</li>";
                $sp_next = "<li>$nextlink</li>";
            }
            elseif ($tpage > $page && $page <= 1) {
                $paging = "$nextlink";
                $sp_prev = '<li class="disabled">' . PREVIOUS_PAGE . '</li>';
                $sp_next = "<li>$paging</li>";
            }
        }

        /*
        * Build query
        */
        $limite = isset($listing_per_page) ? " " . $this->__("limit") . " $startfrom, $listing_per_page" : "";
        $query = $this->query_builder($this->name, $condition . $limite, $from_clause);

        /*
        * Feach data based on SQL
        */
        $info_array = $this->fetch_rows($query);

        /*
         * Data to return
         */
        $gross['data'] = $info_array;
        $gross['paging'] = $paging;
        $gross['link'] = $link;
        $gross['total'] = $total + 0;
        $gross['page'] = $page + 0;
        $gross['paging_str'] =
            '<div class="pagination pagination-left">
				<div class="results">
					<span>' . $link . '</span>
				</div>
				<ul class="pager">
					' . $sp_prev . '
					' . $sp_link . '
					' . $sp_next . '
				</ul>
			</div>';
        return $gross;
    }

    /**
     * Common function to save data
     *
     * @parameter data array
     * @parameter condition string
     * @return integer
     */
    function save($data = NULL, $_condition = NULL)
    {
        $this->data[$this->name] = ($data[$this->name]) ? $data[$this->name] : $this->__data;

        $this->_beforeSave($this);

        $statement = Array("INSERT");
        $_PdoObj = NULL;

        if ($this->modelDataValidation($this->data)) {
            $this->_onValidationSuccess($this);

            $_model = $this->obj2str($this->name);
            $_dbTable = $this->model2table();
            $_tableFieldInfo = $this->describe();

            $_sthSQLBody = NULL;
            $_sthBindValues = NULL;
            foreach ($_tableFieldInfo as $key => $val) {
                if (isset($this->data[$_model][$val['Field']]) && $val['Field'] != 'id') {					
					if(is_array($this->data[$_model][$val['Field']])){
						$this->data[$_model][$val['Field']] = implode(',',$this->data[$_model][$val['Field']]);
					}				
                    $_sthSQLBody .= (isset($_sthSQLBody)) ? ",{$val['Field']} = :{$val['Field']}" : "{$val['Field']} = :{$val['Field']}";
                    $_sthBindValues[":{$val['Field']}"] = $this->data[$_model][$val['Field']];
                }
            }

            $this->data[$_model]["id"] = isset($this->data[$_model]["id"]) ? $this->data[$_model]["id"] : "";
            $_condition = isset($_condition) ? $_condition : "";

            if (($this->data[$_model]["id"] != "") or ($_condition != "")) {
                array_pop($statement);
                array_push($statement, "UPDATE", $_dbTable, "SET");

                if (isset($this->data[$_model]["id"])) {
                    $id = isset($this->data[$_model]["id"]) ? $this->data[$_model]["id"] : "";
                }

                $c = "";
                if (($id != "") && ($_condition != "")) {
                    $c = "WHERE id = :id AND $_condition";
                    $_sthBindValues[":id"] = $id;
                }
                else if ($id != "") {
                    $c = "WHERE id = :id";
                    $_sthBindValues[":id"] = $id;
                }
                else if ($_condition != "") $c = "WHERE $_condition";

                array_push($statement, $_sthSQLBody, $c);
            }
            else {
                array_push($statement, "INTO", $_dbTable, "SET", $_sthSQLBody);
            }

            $this->sql = join(" ", $statement);
            $_PdoObj = $this->get_conn()->prepare($this->sql);
            $_PdoObj->execute($_sthBindValues);

            if ((integer)$_PdoObj->errorCode() <= 0) {
                $this->setId(($this->get_conn()->lastInsertId()) ? $this->get_conn()->lastInsertId() : ($id));
            }

        }
        else {
            $this->_onValidationFailed($this);
        }

        $this->__setOperationInfo($_PdoObj);

        $this->_afterSave($this);

        return $this;
    }

    private function __setOperationInfo($_PdoObj = NULL)
    {
        if (is_object($_PdoObj)) {
            if ($_PdoObj->errorCode() > 0) {
                $errorInfo = $_PdoObj->errorInfo();
                $this->setErrorCode($_PdoObj->errorCode());
                if ($_PdoObj->errorCode() == 23000) $this->setErrorInfo(Array("Sorry! Entry already exists"));
                else $this->setErrorInfo(Array($errorInfo[2]));
                $this->setQueryStatus("Failed");
            }
            else {
                $this->setQueryStatus("Success");
            }
            $this->setSQL($this->sql);
        }
        else {

            $this->setErrorInfo($this->error);
            $this->setQueryStatus("Failed");
        }
    }

    /**
     * Check Model Validation
     *
     * @param array $data
     * @return boolean
     */
    private function modelDataValidation($data = null)
    {
        $this->error = Array();

        if (is_null($data)) $error[] = "No Data Found";
        else if (empty($data[$this->name])) $error[] = "No Data Found";

        foreach ($data[$this->name] as $fieldKey => $fieldValue) {
            if (isset($this->model_validation[$fieldKey])) {
                $rules = isset($this->model_validation[$fieldKey]['rule']) ? array($this->model_validation[$fieldKey]) : $this->model_validation[$fieldKey];
                foreach ($rules as $rule) {
                    $validationRule = $rule['rule'];
                    $options = isset($rule['options']) ? $rule['options'] : Array();
                    if ($validationRule == 'unique') $options = Array("model" => $this->name, "field" => $fieldKey, "id" => isset($data[$this->name]['id']) ? $data[$this->name]['id'] : "");
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
    function get_fancy_data($data)
    {
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
                }
                else {
                    if (implode("", $z) != "") {
                        /* For relational model it save in to a nulti dymantional array array */
                        $collection[$v["$basemodel.id"]][$y][] = $z;
                    }
                    else if (!isset($collection[$v["$basemodel.id"]][$y])) {
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
    function delete($condition = NULL)
    {
        $db_table = $this->model2table();
        $c2 = isset($this->id) ? " WHERE id=" . $this->id : "";
        $c = isset($condition) ? "WHERE $condition" : $c2;

        $sql = "DELETE FROM $db_table $c";

        if (!$this->getDonotLog()) {
            $this->logDeletedData("$db_table $c");
        }

        $this->varifysql($sql);
        $stmt = $this->get_conn()
            ->prepare("$sql");

        $this->_beforeDelete($this);
        $stmt->execute();
        $this->_afterDelete($this);

        return $stmt->rowCount();
    }

    private function logDeletedData($sql_part)
    {
        if (App::__def()->sysConfig('LOG_DELETED_DATA')) {
            $query = "SELECT * FROM $sql_part";
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
    function custom_execute($sql = NULL)
    {

        $this->varifysql($sql);
        $sth = $this->get_conn()
            ->prepare($sql);
        $sth->execute();

        return $this;
    }

    /*
     * Custom query execution
     *
     * @parameter sql string
     * @return array
     */
    public function custom_query($sql = NULL)
    {
        $this->varifysql($sql);
        $sth = $this->get_conn()
            ->prepare($sql);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
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
    function query_builder($model = NULL, $condition = NULL, $from_clause = NULL, $str_from = "*")
    {
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
        }
        else {
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
    function model2querystr($model = NULL)
    {
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
    function describe($model = NULL)
    {
        $model = isset($model) ? $model : $this->name;
        $db_table = $this->model2table($model);

        if (($db_table != "")) {
            $data = $this->model2cashedata($model);

            if (!empty($data["table_description"])) {
                return ($data["table_description"]);
            }
            else {
                return $this->table_description($db_table);
            }
        }
        else return "";
    }

    /**
     *    Return the table description
     *
     * @parameter db_table string
     * @return array
     */
    function table_description($db_table)
    {
        return $this->fetch_rows(array("type" => "normal", "SQL" => "DESCRIBE $db_table"));
    }

    /**
     * Execute the SQL commnad
     *
     * @parameter query string
     * @return array
     */
    function db_execute($query)
    {
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
    function fetch_rows($query)
    {
        $this->varifysql($query["SQL"]);
        $sth = $this->get_conn()
            ->prepare($query["SQL"]);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     *    Get table name from model
     *
     * @parameter model string
     * @return string
     */
    function model2table($model = NULL)
    {
        $model = isset($model) ? $model : $this->name;
        $cname = isset($this->conn) ? $this->conn : 'primary';
        $prefix = App::Load("Module/definition")->getDBConfig('prefix', $cname);

        if ($this->name == $model) {
            return $prefix . $this->db_table;
        }
        else {
            $data = $this->model2cashedata($model);
            $this->db_table = isset($data["table_name"]) ? $data["table_name"] : $this->db_table;

            return $prefix . $this->db_table;
        }


    }

    /**
     * Get table description
     *
     * @parameter model string
     * @return array
     */
    function model2cashedata($model)
    {
        $path = MODEL_CACHE_PATH . DS . strtolower($model) . '.mcf';

        return file_exists($path) ? unserialize($this->fatchfilecontent($path)) : $this->create_model_cache($model);
    }

    private function create_model_cache($model = NULL)
    {
        $obj = is_object($model) ? $model : App::Model($model);

        $mode_cash_path = MODEL_CACHE_PATH . DS . strtolower($obj->name) . '.mcf';

        if (file_exists($mode_cash_path)) {
            return unserialize($this->fatchfilecontent($mode_cash_path));
        }
        else {
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
    function quote_smart($value)
    {
        return $value;
    }

    /**
     *    Simple casting
     *
     * @parameter obj object
     * @return string
     */
    function obj2str($obj)
    {
        return "$obj";
    }

    /**
     *    Fetch data from file
     *
     * @parameter file_path string
     * @return string
     */
    function fatchfilecontent($file_path = NULL)
    {
        $handle = fopen($file_path, "r");
        $contents = '';
        while (!feof($handle)) {
            $contents .= fread($handle, 8192);
        }
        fclose($handle);
        return $contents;
    }

    private function varifysql($sql = "")
    {
        if (DEBUG_MODE == 2) {
            App::$__appData['dbQuries'][] = array($sql);
        }
        return $sql;
    }
}
