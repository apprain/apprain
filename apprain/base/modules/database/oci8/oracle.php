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
 
class appRain_Base_Modules_Database_Oci8_Oracle extends appRain_Base_Objects{

	public $dbdriver = 'Oci8';
	public $dbconn = null;
	public $prefix = 'app_';
	const _MAX_TEXT_LENGTH = 2000;
	
	/*
	// Create Connection
	*/
	public function Connect($db_config,$persistent = FALSE)
	{				
		try	{
			$tns = " 
			(DESCRIPTION =
				(ADDRESS_LIST =
					(ADDRESS = (PROTOCOL = TCP)(HOST ={$db_config['host']})(PORT = {$db_config['port']}))
				)
				(
					CONNECT_DATA = (SERVICE_NAME = {$db_config['dbname']})
				)
			)
			";		
			$this->dbconn = oci_connect($db_config['username'], $db_config['password'], $tns);
			### DIRECT CONNECTION $this->dbconn = oci_connect($db_config['username'], $db_config['password'], $db_config['host'].'/'.$db_config['dbname']);
			$this->prefix = $db_config["prefix"];	
		}
		catch (PDOException $e)	{
			throw new Exception($e->getMessage());
		}
		
		return $this;
	}
	
	/*
	// Lets do some stupid work to make it comparable
	*/
	public function makemelower1D($r=array()){
		if(!is_array($r)){
			return $r;
		}
		return array_change_key_case($r, CASE_LOWER);
	}
	/*
	// Lets do some stupid work to make it comparable
	*/	
	public function makemelower($rows=null){
	
		$list = array();
		foreach($rows as $row){
			$list[] = $this->makemelower1D($row);
		}
		unset($rows);
		return $list;
	}
	/*
	// Find Single Row
	*/
	public function find($condition = null, $from_clause = null, $str_from = null)
    {
		$str_from = isset($str_from) ? $str_from : '*';
        $query = $this->query_builder($condition, $from_clause, $str_from);
        $this->varifysql($query['SQL']);
		$stid = oci_parse($this->dbconn,$query['SQL']);
		oci_execute($stid);	
		
		$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);

		return $this->makemelower1D($row);
	}	
	/*
	// Fx to find all row
	*/
	public function findAll($condition = null, $from_clause = null, $str_from = null)
    {	
		$str_from = isset($str_from) ? $str_from : '*';
        $query = $this->query_builder($condition, $from_clause, $str_from);
        $query = $this->varifysql($query['SQL']);
		$stid = oci_parse($this->dbconn, $query);
		oci_execute($stid);
		$nrow = oci_fetch_all($stid, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW+OCI_RETURN_NULLS);
		$this->rowfatch = $nrow;	
        return $this->makemelower($rows);
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
        return isset($data[0]["cnt"]) ? $data[0]["cnt"] : 0;
	}
	/*
	// Create paging for all transaction
	*/
	public function paging($condition = "1=1", $listing_per_page = NULL, $h_link = NULL, $from_clause = NULL)
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
		
		$query = $this->query_builder($condition , $from_clause);
		
		$sql = "SELECT * FROM ".
				"(SELECT ROWNUM rnum, a.* FROM ".
				"({$query['SQL']}) a WHERE ROWNUM <=  {$endto}".
				") WHERE rnum > {$startfrom}";
				
		$info_array = $this->fetch_rows($sql);

 
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
	
		$query = "SELECT distinct(TABLE_NAME) FROM USER_TAB_COLUMNS";
		$stid = oci_parse($this->dbconn, $query);
		oci_execute($stid);
		$nrow = oci_fetch_all($stid, $rows, null, null, OCI_FETCHSTATEMENT_BY_COLUMN);
		$tables = array();
		foreach($rows['TABLE_NAME'] as $row){
			$tables[] = strtolower($row);
		}
		return $tables;
	}
	
	/*
	// Return name of tables 
	*/	
	
	public function getSequences(){
	
		$query = "SELECT distinct(sequence_name) FROM user_sequences ";
		
		$stid = oci_parse($this->dbconn, $query);
		oci_execute($stid);
		$nrow = oci_fetch_all($stid, $rows, null, null, OCI_FETCHSTATEMENT_BY_COLUMN);
		$sequences = array();
		foreach($rows['SEQUENCE_NAME'] as $row){
			$sequences[] = strtolower($row);
		}
		return $sequences;

	}
	
	
	/*
	// Return full description of a table 
	*/
	public function describe($table,$from='*',$fetch_type='ROW_WISE'){
		$data = array();
		$query = "SELECT {$from} FROM USER_TAB_COLUMNS where table_name=upper('{$table}') ORDER BY column_id ASC";		
		$stid = oci_parse($this->dbconn, $query);
		oci_execute($stid);
		if($fetch_type == 'ROW_WISE'){
			$nrow = oci_fetch_all($stid, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);	
			return $this->makemelower($rows);		
		}
		else{
			$nrow = oci_fetch_all($stid, $rows, null, null, OCI_FETCHSTATEMENT_BY_COLUMN);	
			return $this->makemelower1D($rows);		
		}
		
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
		$tableInfo = $this->describe($_dbTable,'COLUMN_NAME as fields','COLUMN_WISE');
		$data['errorInfo'] = 'Invalid SQL';

		$fields = $tableInfo['fields'];
		foreach ($data as $field => $val) {
			if(in_array(strtoupper($field),$fields)){
				if($field =='id' && empty($val)){					
					$stid = oci_parse($this->dbconn,"select {$_dbTable}_SEQ.NEXTVAL from dual");				
					oci_execute($stid);
					$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
					$id = $row['NEXTVAL'];
					$val = $id;
				}
				$_sthSQLBody[] = $field;
				$_sthSQLBodyVal[] = ":$field";
				$_sthBindValues[] = $val;	
			}
		}

		$_condition = isset($_condition) ? $_condition : "";		

		 if (( isset($data["id"]) && !empty($data["id"])) or ($_condition != "")) {
			$this->sql = "UPDATE {$_dbTable}  SET ";
			foreach($_sthSQLBody as $key=>$fieldname){
				if($key){
					$this->sql .= ',';
				}
				$this->sql .= "{$fieldname}=:{$fieldname}";
			}
			
			$id = isset($data["id"]) ? $data["id"] : "";
			
			if(!empty($id)){
				$this->sql .= " WHERE id = :id {$_condition}";
				$_sthBindValues[] = $id;
			}
			elseif(!empty($_condition)){
				$this->sql .= " WHERE {$_condition}";
			}		
			$this->sql = "{$this->sql}";
		}
		else {
			$this->sql  = "INSERT INTO {$_dbTable} (";
			$this->sql  .= implode(',',$_sthSQLBody);
			$this->sql  .= ') VALUES (';
			$this->sql  .= implode(',',$_sthSQLBodyVal);
			$this->sql  .= ')';
		}
		
		$_OciObj = oci_parse($this->dbconn,$this->sql);
		
		foreach($_sthSQLBody as $key=>$val){
			oci_bind_by_name($_OciObj, ":{$val}", $_sthBindValues[$key]);
		}
		oci_execute($_OciObj);
		return $id;
	}
	/**
    // Fetch rows
	*/
    function fetch_rows($query)
    {	
        $query = $this->varifysql($query);
		$stid = oci_parse($this->dbconn, $query);
		oci_execute($stid);
		$nrow = oci_fetch_all($stid, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW+OCI_RETURN_NULLS);
		return $this->makemelower($rows);		
    }

	/**
     // Execute Customer Query for SELECT Operation
	*/
    function custom_execute($query)
    {	
		$query = $this->varifysql($query);
		$stid = oci_parse($this->dbconn, $query);
		oci_execute($stid);

		if(oci_num_fields($stid)){
			$nrow = oci_fetch_all($stid, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW+OCI_RETURN_NULLS);
			return $this->fetch_rows($query);		
		}
		
		return null;
    }	
	/**
     // Delete row
	*/
    function delete($db_table = null,$condtion = null)
    {
		$sql = "DELETE FROM {$db_table} {$condtion}";

		$query = $this->varifysql($sql);
		
		$stid = oci_parse($this->dbconn, $query);
		oci_execute($stid);

		return oci_num_rows($stid);
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
	
	/*---------------------------------------------------------------------------------------
	BLOCK FORM INFORMATION SET AUTO SCHEMA POPULATION
	-----------------------------------------------------------------------------------------*/
	/*
	// Create first table instance of the table 
	// in database.
	*/
	public function SuperviseInformationSetFirstInstance($_dbTable){
	
		$_dbSequence = $_dbTable.'_seq';
		$list = $this->getSequences();
		$return = null;
		if(!in_array($_dbSequence,$list)){	
			$sql = "CREATE SEQUENCE {$_dbSequence}
				  START WITH 1
				  MAXVALUE 999999999999999999999999999
				  MINVALUE 0
				  NOCYCLE
				  NOCACHE
				  NOORDER";
			
			$stid = oci_parse($this->dbconn, $sql);
			$return = oci_execute($stid);
		}			

		$list = $this->getTables();
		if(!in_array($_dbTable,$list)){	
			$sql = "CREATE TABLE {$_dbTable} ( 
				id NUMBER(11) NOT NULL,
				adminref NUMBER(11) NOT NULL,
				entrydate     VARCHAR2(50 byte),
				lastmodified  VARCHAR2(50 byte),
				CONSTRAINT customers_pk PRIMARY KEY (id)
			)";
			
			$stid = oci_parse($this->dbconn, $sql);
			$return = oci_execute($stid);	
		}

		return $return;
	}
	
	public function createModifyInformationSetFields($_dbTable=null,$field_name,$db_attributes=null){
		$description = $this->Describe($_dbTable);
		$db_attributes_old = array();
		foreach($description as $row){
			if(strtolower($row['column_name']) == strtolower($field_name)){
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
	
	private function typestandardised($std_field=null){
		switch($std_field){
			case 'text': case 'varchar' : 
				return 'varchar2';
				break;
			case 'enum' : case 'char' :
				return 'char';
				break;
			case 'int' :
				return 'number';
				break;
			case 'float' :
				return 'float';
				break;
		}
	
	}
	
	/*
	 // Check the requirement of update
	 */
	private function shouldIUpdate($db_attributes=array(),$db_attributes_old=array()){
		$ora_field = $this->typestandardised($db_attributes['type']);
		
		if($db_attributes['type'] == 'text'){
			$db_attributes['length'] = self::_MAX_TEXT_LENGTH;
		}
		
		if($db_attributes['length'] != $db_attributes_old['data_length']){
			return true;
		}

		$data_type = strtolower($db_attributes_old['data_type']);		
		
		if($ora_field != $data_type){
			return true;
		}

		if($db_attributes['default'] != $db_attributes_old['data_default']){
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
			case 'enum' : case 'char' :
				$sql = "ALTER TABLE {$_dbTable} ADD {$fname} char({$def['length']}) {$defaultstr}";	
				break;
			case 'varchar' :
				$sql = "ALTER TABLE {$_dbTable} ADD {$fname} varchar2({$def['length']}) {$defaultstr}";				
				break;
			case 'text' :
				$sql = "ALTER TABLE {$_dbTable} ADD {$fname} varchar2(" . self::_MAX_TEXT_LENGTH . ") {$defaultstr}";				
				break;
			case 'int' :
				$sql = "ALTER TABLE {$_dbTable} ADD {$fname} number({$def['length']}) {$defaultstr}";			
				break;
			case 'float' :
				$sql = "ALTER TABLE {$_dbTable} ADD {$fname} float({$def['length']}) {$defaultstr}";			
				break;	
			default :
				$sql = "ALTER TABLE {$_dbTable} ADD {$fname} {$def['type']}({$def['length']}) {$defaultstr}";									
		}

		$stid = oci_parse($this->dbconn, $sql);
		oci_execute($stid);
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
			case 'enum' : case 'char' :
				$sql = "ALTER TABLE {$_dbTable} MODIFY {$fname} char({$def['length']}) {$defaultstr}";	
				break;
			case 'varchar' :
				$sql = "ALTER TABLE {$_dbTable} MODIFY {$fname} varchar2({$def['length']}) {$defaultstr}";				
				break;
			case 'text' :
				$sql = "ALTER TABLE {$_dbTable} MODIFY {$fname} varchar2(" . self::_MAX_TEXT_LENGTH . ") {$defaultstr}";				
				break;
			case 'int' :
				$sql = "ALTER TABLE {$_dbTable} MODIFY {$fname} number({$def['length']}) {$defaultstr}";			
				break;
			case 'float' :
				$sql = "ALTER TABLE {$_dbTable} MODIFY {$fname} float({$def['length']}) {$defaultstr}";			
				break;	
			default :
				$sql = "ALTER TABLE {$_dbTable} MODIFY {$fname} {$def['type']}({$def['length']}) {$defaultstr}";								
		}
		
		$stid = oci_parse($this->dbconn, $sql);
		oci_execute($stid);	
	}	
}
