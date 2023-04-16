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

class appRain_Base_Modules_Database_Pdo_Oracle extends appRain_Base_Modules_Database_Pdo_Mysql {

	public $dbdriver = 'pdo';
	public $options = array();
	public $dbconn = null;
	public $prefix = 'app_';	
	const _MAX_TEXT_LENGTH = 2000;
	/*
	// Create Connection
	*/	
	public function Connect($db_config,$persistent = FALSE)
	{
		$this->options[PDO::ATTR_PERSISTENT] = $persistent;
		$this->options['1002'] = "SET NAMES {$db_config['charset']}";
	
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
			$this->dbconn = new PDO("oci:dbname=".$tns,$db_config['username'],$db_config['password'], $this->getDBOptions());
			$this->dbconn->setAttribute(PDO::ATTR_CASE,PDO::CASE_LOWER);
			$this->prefix = $db_config["prefix"];				

		}
		catch (PDOException $e)	{
			throw new Exception($e->getMessage());
		}
		return $this;
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
		if(empty($condition)){
			$condition = "1=1";
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
		$list = $this->fetch_rows($query);

		$tables = array();
		foreach($list as $row){
			$row = array_values($row);
			$tables[] = strtolower($row[0]);
		}
		return $tables;

	}
	public function getSequences(){
	
		$query = "SELECT sequence_name FROM user_sequences ";
		$list = $this->fetch_rows($query);
		$sequences = array();
		foreach($list as $row){
			$row = array_values($row);
			$sequences[] = strtolower($row[0]);
		}
		return $sequences;

	}
	/*
	// Return full description of a table 
	*/
	public function describe($table,$from='*'){
		$data = array();
		$query = "SELECT {$from} FROM USER_TAB_COLUMNS where table_name=upper('{$table}') ORDER BY column_id ASC";	
		
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

		$_tableFieldInfo = $this->describe($_dbTable,'COLUMN_NAME as fields');
		$data['errorInfo'] = 'Invalid SQL';
		
		$fields = array();
		foreach($_tableFieldInfo as $row){
			$fields[] = strtolower($row['fields']);
		}

		foreach ($data as $field => $val) {
			if(in_array(strtolower($field),$fields)){
				if($field =='id' && empty($val)){					
					$sh = $this->dbconn->prepare("select {$_dbTable}_SEQ.NEXTVAL from dual");
					$sh->execute();
					$id = $sh->fetchColumn(0);
					$val = $id;
				}
				$_sthSQLBody[] = $field;
				$_sthSQLBodyVal[] = '?';
				$_sthBindValues[] = $val;	
			}
		}
		$_condition = isset($_condition) ? $_condition : "";

	   if (( isset($data["id"]) && !empty($data["id"])) or ($_condition != "")) {

			$this->sql = "UPDATE {$_dbTable}  SET " . implode('=?,',$_sthSQLBody) . '=?';
			
			$id = isset($data["id"]) ? $data["id"] : "";
			
			if(!empty($id)){
				$this->sql .= " WHERE id = ? {$_condition}";
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

		$_PdoObj = $this->dbconn->prepare($this->sql);
		$_PdoObj->execute($_sthBindValues);

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
		$r = $sth->execute();
		return $sth->fetchAll(PDO::FETCH_ASSOC); 
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
			$sth = $this->dbconn->prepare($sql);
			$return = $sth->execute();	
		}			

		$list = $this->getTables();

		if(!in_array($_dbTable,$list)){	
			$sql = "CREATE TABLE {$_dbTable} ( 
				id NUMBER(11) NOT NULL,
				adminref NUMBER(11) NOT NULL,
				entrydate     VARCHAR2(50 byte),
				lastmodified  VARCHAR2(50 byte),
				CONSTRAINT {$_dbTable}_id_pk PRIMARY KEY (id)
			)";
			$sth = $this->dbconn->prepare($sql);
			$return = $sth->execute();	
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
		
		//if(in_array($db_attributes['type'],array('enum','char','varchar','int'))){		
			if($db_attributes['length'] != $db_attributes_old['data_length']){
				return true;
			}
		//}

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
		$sth = $this->dbconn->prepare($sql);		
		$sth->execute();	
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
		$sth = $this->dbconn->prepare($sql);		
		return $sth->execute();	
	}	
	
	public function Equal($fiend=null,$value=null,$quoted=true){
		if(empty($value)){
			return " {$fiend} is null";
		}
		
		if($quoted){
			return " {$fiend} = '{$value}'";
		}
		else{
			return " {$fiend} = {$value}";
		}
	}
	
	public function NotEqual($fiend=null,$value=null,$quoted=true){
		
		if(empty($value)){
			return " {$fiend} is not null";
		}
		
		if($quoted){
			return " {$fiend} != '{$value}'";
		}
		else{
			return " {$fiend} != {$value}";
		}
	}
	
	public function Concat($values=array()){
		return implode(' || ',$values);
	}
}
