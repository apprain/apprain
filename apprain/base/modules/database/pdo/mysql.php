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
 * @copy right  Copyright (c) 2010 appRain, Team. (http://www.apprain.org)
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

class appRain_Base_Modules_Database_Pdo_Mysql extends appRain_Base_Objects{

	private $sql;
	public $dbdriver = 'pdo';
	public $options = array();
	public $dbconn = null;
	public $prefix = 'app_';
	
	/*
	// Create Connection
	*/	
	public function Connect($db_config = array(),$persistent = FALSE)
	{
		$this->options[PDO::ATTR_PERSISTENT] = $persistent;
		$this->options['1002'] = "SET NAMES {$db_config['charset']}";
		$this->options[PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET sql_mode="NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION"';
		
		try	{
			$this->dbconn = new PDO("mysql:host={$db_config['host']};dbname={$db_config['dbname']};port={$db_config['port']}",$db_config['username'],$db_config['password'],$this->options);
			$this->dbconn->setAttribute(PDO::ATTR_CASE,PDO::CASE_LOWER);

			$this->prefix = $db_config["prefix"];	
		}
		catch (PDOException $e)	{
			throw new Exception($e->getMessage());
		}
		return $this;
	}
	/*
	// Find Single Row
	*/	
	public function find($condition = null, $from_clause = null, $str_from = null)
    {		
		$str_from = isset($str_from) ? $str_from : '*';
        $query = $this->query_builder($condition, $from_clause, $str_from);
		
		$limit = $this->getLimit();
		if(!empty($limit) and count($limit) == 2){
			$query['SQL'] = $query['SQL'] . " LIMIT {$limit[0]},{$limit[1]}";
		}
		
        $query = $this->varifysql($query['SQL']);
		
		$sth = $this->dbconn->prepare($query);
        $sth->execute();
		return $sth->fetch(PDO::FETCH_ASSOC);
    }	
	/*
	// Fx to find all row
	*/	
	public function findAll($condition = null, $from_clause = null, $str_from = null,$limit=null)
    {	
		$str_from = isset($str_from) ? $str_from : '*';
        $query = $this->query_builder($condition, $from_clause, $str_from);
		
		$limit = $this->getLimit();
		if(!empty($limit) and count($limit) == 2){
			$query['SQL'] = $query['SQL'] . " LIMIT {$limit[0]},{$limit[1]}";
		}
		
        $query = $this->varifysql($query['SQL']);
		
		$sth = $this->dbconn->prepare($query);
        $sth->execute();
		return $sth->fetchAll(PDO::FETCH_ASSOC);
		
    }
	/*
	// Find Number of Entry
	*/
	public function countEntry($condition = NULL, $from_clause = NULL){
	
		/*
         * Build Query
         */
        $query = $this->query_builder($condition, $from_clause, "count(*) as cnt");

		/*
         *	Feach data based on SQL
         */
        $data = $this->fetch_rows($query['SQL']);

		/*
        * Return fetched data
        */
		
        return array_sum(array_column($data, 'cnt')); //isset($data[0]["cnt"]) ? $data[0]["cnt"] : 0;
	}	
	/*
	// Create paging for all transaction
	*/
	public function paging($condition = "1=1", $listing_per_page = NULL, $h_link = NULL, $from_clause = NULL, $str_from = null)
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
                $page_no .= "<strong classs=\"page_selected\">" . $i . "</strong> ";
            }
            else {
                $page_no .= '<a href="' . $h_link . '&page=' . $i . '">' . $i . '</a> ';
            }

            $sp_link .= ($i == $page) ? "<li class=\"current\">{$i}</li>" : '<li><a href="' . $h_link . '&page=' . $i . '">' . $i . '</a> </li>';
        }

        /**
         * Bulid  link
         */
        $link = ($page_no != "") ? $this->__("Showing Results") . ' ' . ($startfrom + 1) . "-$endto " . $this->__('of') .  " $total" : "";

        /**
         * Build Pagination string
         */
        $paging = '';
        $sp_prev = '<li class="disabled">' . PREVIOUS_PAGE . '</li>';
        $sp_next = '<li class="disabled">' . NEXT_PAGE . '</li>';
        if ($tpage > 1) {
            $nextpage = $page + 1;
            $prevpage = $page - 1;

            $prevlink = '<a href="' . $h_link . '&amp;page=' . $prevpage . '" class="page_previous" title="' . $this->__(PREVIOUS_PAGE) . '">' . PREVIOUS_PAGE . '</a>';
            $nextlink = '<a href="' . $h_link . '&amp;page=' . $nextpage . '" class="page_next" title="' . $this->__(NEXT_PAGE) . '">' . NEXT_PAGE . '</a>';

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

        $limite = isset($listing_per_page) ? " " . $this->__("limit") . " $startfrom, $listing_per_page" : "";
		
		if(empty($condition)){
			$condition = "1=1";
		}
        $query = $this->query_builder($condition . $limite, $from_clause,$str_from);	
		
		$info_array = $this->fetch_rows($query['SQL']);

        /*
         * Data to return
         */
        $gross['data'] = $info_array;
        $gross['paging'] = $paging;        
        $gross['total'] = $total + 0;
        $gross['page'] = $page + 0;
		$gross['link'] = $link;
		$gross['sp_prev'] = $sp_prev;
		$gross['sp_link'] = $sp_link;
		$gross['sp_next'] = $sp_next;
		
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
	/*
	// Return name of tables 
	*/	
	public function getTables(){
	
		$query = "SHOW tables";
		$list = $this->fetch_rows($query);
		
		$tables = array();
		foreach($list as $row){
			$row = array_values($row);
			$tables[] = $row[0];
		}
		
		return $tables;
	}
	/*
	// Return full description of a table 
	*/
	//-------------------------------------------------------------
	public function collumns($_dbTable=""){
		$_tableFieldInfo = $this->describe($_dbTable);		
		$list = array();
		foreach($_tableFieldInfo as $row){
			$list[] = $row['field'];
		}
        return $list;
	}

	//-----------------------------------------------------------
	/*
	// Return full description of a table 
	*/
	public function describe($table=""){
		$data = array();
		$query = "DESC {$table}";	
        $sth = $this->dbconn->prepare($query);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}	
	/*
	// Save data in a table
	*/		
	public function save($_dbTable=null,$data = null, $_condition = null)
	{		
		$_sthSQLBody = NULL;
		$_sthSQLBodyVal = NULL;
        $_sthBindValues = NULL;
		$id = null;
		$this->sql = '';
		$statement = Array("INSERT");
		
		$_tableFieldInfo = $this->describe($_dbTable);

		$_sthSQLBody = NULL;
		$_sthBindValues = NULL;

		foreach ($_tableFieldInfo as $key => $val) {
			if (isset($data[$val['field']]) && $val['field'] != 'id') {					
				if(is_array($data[$val['field']])){
					$data[$val['field']] = implode(',',$data[$val['field']]);
				}				
				$_sthSQLBody .= (isset($_sthSQLBody)) ? ",{$val['field']} = :{$val['field']}" : "{$val['field']} = :{$val['field']}";
				$_sthBindValues[":{$val['field']}"] = $data[$val['field']];
			}
		}
		
		$data["id"] = isset($data["id"]) ? $data["id"] : "";
        $_condition = isset($_condition) ? $_condition : "";

		if (($data["id"] != "") or ($_condition != "")) {
			array_pop($statement);
			array_push($statement, "UPDATE", $_dbTable, "SET");

			if (isset($data["id"])) {
				$id = isset($data["id"]) ? $data["id"] : "";
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

		$sth = $this->dbconn->prepare($this->sql);
		$sth->execute($_sthBindValues);

		if ((integer)$this->dbconn->errorCode() <= 0) {
			$id = (($this->dbconn->lastInsertId()) ? $this->dbconn->lastInsertId() : ($id));
		}
		
		return $id;
	}
	/**
    // Fetch row
	*/	
	public function fetch_rows($query = null)
    {
		$sth = $this->dbconn->prepare($query);
        $sth->execute();
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	/**
     // Execute Customer Query for SELECT Operation
	*/
	public function custom_execute($sql = null)
	{
	    $sth = $this->dbconn->prepare($sql);
		$sth->execute();
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	/**
     // Delete row
	*/
    function delete($db_table = null,$condtion = null)
    {
		$sql = "DELETE FROM {$db_table} {$condtion}";
	    $sth = $this->dbconn->prepare($sql);
		$sth->execute();
		return $sth->rowCount();
	}	
	/*
	// Develop Query
	*/	
    public function query_builder($condition = NULL, $from_clause = NULL, $str_from = NULL)
    {
        $condition = isset($condition) ? $condition : "1=1";
        $str_from = isset($str_from) ? $str_from : "*";
		$sql = "SELECT {$str_from} FROM " . $from_clause . " WHERE {$condition}";		
		
		return array("SQL" => $sql);
    }	
	/*
	//  Operation prior execution
	*/
	private function varifysql($sql = "")
    {
        if (DEBUG_MODE == 2) {
            App::$__appData['dbQuries'][] = array($sql);
        }
        return $sql;
    }	
	
	// Special Development for Information Set
	
	/*
	// Create first table instance of the table 
	// in database.
	*/
	public function SuperviseInformationSetFirstInstance($_dbTable){
	
		$list = $this->getTables();
		
		if(!in_array($_dbTable,$list)){			
			$sql = "CREATE TABLE `{$_dbTable}` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `adminref` int(11) NOT NULL,
			  `entrydate` DATETIME NOT NULL DEFAULT '" . App::Helper('Date')->getdate('Y-m-d H:i:s') . "', 
			  `lastmodified` DATETIME NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
			
			$sth = $this->dbconn->prepare($sql);
			return $sth->execute();	
		};
	}
	
	/*
	 // Add/Modify fields
	 */
	public function createModifyInformationSetFields($_dbTable=null,$field_name="",$db_attributes=null){

		$description = $this->Describe($_dbTable);
		$db_attributes_old = array();
		foreach($description as $row){
			if($row['field'] == $field_name){
				$db_attributes_old = $row;
				break;	
			}
		}
		
		if(empty($db_attributes_old)){
			return $this->AddDBField($_dbTable,$field_name,$db_attributes);
		}
		else{
		
			if($this->shouldIUpdate($db_attributes,$db_attributes_old)){
				return $this->ModifyDBField($_dbTable,$field_name,$db_attributes);
			}
		}

	}
	/*
	 // Check the requirement of update
	 */
	private function shouldIUpdate($db_attributes=array(),$db_attributes_old=array()){

		$old_def = preg_split('/\(|\)/',$db_attributes_old['type']);
		
		if(in_array($db_attributes['type'],array('enum','char','varchar','int'))){			
			if($db_attributes['length'] != $old_def[1]){
				return true;
			}
		}
		
		if($db_attributes['type'] != $old_def[0]){
			return true;
		}
		
		if($db_attributes['default'] != $db_attributes_old['default']){
			return true;
		}
		
		return false;
	}
    /*
	 // Add new field
	 */
	public function AddDBField($_dbTable,$fname=null,$def=null){

		$defaultstr = '';
		if($def['default']!= ''){
			$defaultstr = " DEFAULT '{$def['default']}'";
		}

		switch(strtolower($def['type'])){
			case 'enum' : case 'char' : case 'varchar' : case 'int' :
				$sql = "ALTER TABLE `{$_dbTable}` ADD `{$fname}` " . strtoupper($def['type']) . "({$def['length']}) {$def['null']} {$defaultstr}";					
				break;	
			default :
				$sql = "ALTER TABLE `{$_dbTable}` ADD `{$fname}` " . strtoupper($def['type']) . "  {$def['null']} {$defaultstr}";									
		}
				
		$sth = $this->dbconn->prepare($sql);		
		return $sth->execute();	
	}
    /*
	 // Modify Field
	 */
	public function ModifyDBField($_dbTable,$fname=null,$def=null){
		$defaultstr = '';
		if($def['default']!= ''){
			$defaultstr = " DEFAULT '{$def['default']}'";
		}
		switch(strtolower($def['type'])){
			case 'enum' : case 'char' : case 'varchar' : case 'int' :
				$sql = "ALTER TABLE `{$_dbTable}` CHANGE `{$fname}` `{$fname}` " . strtoupper($def['type']) . "({$def['length']}) {$def['null']} {$defaultstr}";
				break;						
			default :
				$sql = "ALTER TABLE `{$_dbTable}` CHANGE `{$fname}` `{$fname}` " . strtoupper($def['type']) . "  {$def['null']} {$defaultstr}";								
		}
		
		$sth = $this->dbconn->prepare($sql);		
		return $sth->execute();	
	}	
	
	public function dateReFormate($formate=null){

		$replacements[0] = '%Y'; $patterns[10] = '/YYYY/';
		$replacements[1] = '%y'; $patterns[9] = '/YY/'; 	   
		$replacements[2] = '%b'; $patterns[8] = '/MON/';
		$replacements[3] = '%M'; $patterns[7] = '/MONTH/'; 	
		$replacements[4] = '%m'; $patterns[6] = '/MM/'; 	   
		$replacements[5] = '%a'; $patterns[5] = '/DY/'; 	   
		$replacements[6] = '%d'; $patterns[4] = '/DD/'; 	   
		$replacements[7] = '%H'; $patterns[3] = '/HH24/';	
		$replacements[8] = '%h'; $patterns[2] = '/HH/';     
		$replacements[9] = '%i'; $patterns[1] = '/MI/'; 	   
		$replacements[10] = '%s';$patterns[0] = '/SS/'; 	   

		return preg_replace($patterns, $replacements, $formate);

	}

	
	 public function toDate($date=null,$formate='YYYY-MM-DD',$value=null,$other=false){	

		if(!empty($value)){			
			return $this->DoDefaultDateFormat($date,$value);		
		}
		
		$formate = $this->dateReFormate($formate);
		$isField = isset($other['isfield']) ? $other['isfield'] : false;
		$fx = 'DATE_FORMAT';
		
		if($isField)
			return "{$fx}({$date},'{$formate}')";	
		else
			return "{$fx}('{$date}','{$formate}')";	
			
		
		return "TO_DATE('{$value}',{$formate})";	
	}	
	
	public function DoDefaultDateFormat($date=null,$field=null){
	
		if(strlen($date) == 10){
			return $this->DefaultDateFormat($field);
		}
		else{
			return $this->DefaultDateFormat($field,'long');
		}
		
	}
	
	public function DefaultDateFormat($field=null,$select='short'){
	
		if($select == 'short'){
			return "DATE_FORMAT(:{$field},'%Y-%m-%d')";
		}
		else{
			return "DATE_FORMAT(:{$field},'%Y-%m-%d %H:%i:%s')";
		}
	}
	
	public function Equal($fiend=null,$value=null,$quoted=true){
		
		if($quoted){
			return " {$fiend} = '{$value}'";
		}
		else{
			return " {$fiend} = {$value}";
		}
	}
	
	public function NotEqual($fiend=null,$value=null,$quoted=true){
		
		if($quoted){
			return " {$fiend} != '{$value}'";
		}
		else{
			return " {$fiend} != {$value}";
		}
	}

	public function Concat($values=array()){
		return "CONCAT(" . implode(',',$values) . ")";
	}
	
}
