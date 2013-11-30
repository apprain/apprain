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


/**
 * $this->informationset($type)->find()
 * $this->informationset($type)->findAll()
 * $this->informationset($type)->findByFieldname()
 * $this->informationset($type)->findAllFieldname()
 * $this->informationset($type)->oneDArray()
 * $this->informationset($type)->Tag()
 * $this->informationset($type)->Save()
 * $this->informationset($type)->Delete()
 * $this->informationset($type)->idToName()
 * $this->informationset($type)->Listing()
 * $this->informationset($type)->get_information()
 * 
 */

class appRain_Base_Modules_InformationSet extends appRain_Base_Objects
{
     private $default_condition = '=';
    private $idbprifix = "";

    public function __construct()
    {
        $this->idbprifix = App::Model('Information')->DBprefix();
    }

    public function InformationSet($type = NULl)
    {
        $this->setFetchtype('informationset');
        if( isset($type)){
            $this->setInformationSetFetchType(strtolower($type));
        }
		App::Model('Information')->db_table = strtolower($type);
        return $this;
    }

	public function Save($data=null){
		$thisAdminInfo = App::AdminManager()->thisAdminInfo();
		if(empty($data)){
			foreach( $this->__data as $key=>$val){
				if(!in_array($key,array('fetchtype','informationsetfetchtype'))){
					App::Model('Information')->__data[$key] = $val;
				}
			}
		
			App::Model('Information')->__data['lastmodified'] = date('Y-m-d H:i:s');
			App::Model('Information')->__data['adminref'] = $thisAdminInfo['id'];
		}
		else {
			$data['Information']['lastmodified'] = date('Y-m-d H:i:s');
			$data['Information']['adminref'] = $thisAdminInfo['id'];
		}

		return App::Model('Information')->Save($data);
	}

    public function callInformationSetByFiled( $method = NULL, $params = NULL)
    {
		$params[0] = isset($params[0]) ? $params[0] : null;
		$params[1] = isset($params[1]) ? $params[1] : null;
		$params[2] = isset($params[2]) ? $params[2] : null;
		$params[3] = isset($params[3]) ? $params[3] : null;
		
		App::Model('Information')->db_table = $this->getInformationSetFetchType();
		$data = App::Model('Information')
			->$method($params[0],$params[1],$params[2],$params[3]);
		return $data;
    }
	
	
	public function RefreshDb($name=null){
	
		if(!isset($name)){
			return null;
		}
		
		$this->SuperviseFirstInstance($name);
		$this->DevelopOtherFields($name);
	}
	
	public function DevelopOtherFields($name=null){
		
		// Read InformationSet Definition
		$definition = App::__def()->getInformationSetDefinition($name);
	
		// Create list of old fields
		$desc = App::Model()->table_description("{$this->idbprifix}{$name}");
		$fields = array();
		$allFields = array();
		foreach($desc as $row){
			$allFields[$row['Field']] = $row;
			$fields[] = $row['Field'];
		}	
//pre($allFields);
		// Update fields 
		foreach($definition['fields'] as $fname => $fdef){
			
			// Create New fields
			if(!in_array($fname,$fields)){
				$sql = $this->setAction('Add')->fieldSQLGenerator($fname,$fdef,$name);	
				$obj = App::Model()->custom_query($sql);
			}
			else {
				if($this->doINeedToUpdate($fdef['db-attributes'],$allFields[$fname])){
					$sql = $this->setAction('Chnage')->fieldSQLGenerator($fname,$fdef,$name);	
					$obj = App::Model()->custom_query($sql);
				}
			}
			
		}
	}
	
	private function doINeedToUpdate($fAttr=null, $dbAttr=null){
		return true;
	}
	
	
	// Generate SQL command for add and chnage
	public function fieldSQLGenerator($fname=null,$def=null,$name=null){
		$action = $this->getAction();
		$defaultstr = '';
		if($def['db-attributes']['default']!= ''){
			$defaultstr = " DEFAULT '{$def['db-attributes']['default']}'";
		}
		switch(strtolower($def['db-attributes']['type'])){
			case 'enum' : case 'char' : case 'varchar' : case 'int' :
				if(strtolower($action) == 'add'){
					$sql = "ALTER TABLE `{$this->idbprifix}{$name}` ADD `{$fname}` " . strtoupper($def['db-attributes']['type']) . "({$def['db-attributes']['length']}) {$def['db-attributes']['null']} {$defaultstr}";
				}
				else {
					$sql = "ALTER TABLE `{$this->idbprifix}{$name}` CHANGE `{$fname}` `{$fname}` " . strtoupper($def['db-attributes']['type']) . "({$def['db-attributes']['length']}) {$def['db-attributes']['null']} {$defaultstr}";
				}
				break;						
			default :
				if(strtolower($action) == 'add'){
					$sql = "ALTER TABLE `{$this->idbprifix}{$name}` ADD `{$fname}` " . strtoupper($def['db-attributes']['type']) . "  {$def['db-attributes']['null']} {$defaultstr}";
				}
				else {
					$sql = "ALTER TABLE `{$this->idbprifix}{$name}` CHANGE `{$fname}` `{$fname}` " . strtoupper($def['db-attributes']['type']) . "  {$def['db-attributes']['null']} {$defaultstr}";
				}
				break;												
		}
		return $sql;
	}
	
	public function SuperviseFirstInstance($name=null){
	
		// Check the table already exists in database
		$check = App::Model()->custom_query("SHOW TABLES LIKE '{$this->idbprifix}{$name}'");
		
		if(empty($check)){
		
			// Create first table instance of the table 
			// in database.
			$sql = "CREATE TABLE `{$this->idbprifix}{$name}` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `adminref` int(11) NOT NULL,
			  `entrydate` DATETIME NOT NULL DEFAULT '" . date('Y-m-d H:i:s') . "', 
			  `lastmodified` DATETIME NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
			
			// Execute DDL operation 
			App::Model()->custom_query($sql);
		}		
		
		return $this;
	}
	
	
	public function Tag( $name = NULL, $value = NULL,$paramater = NULL, $options = NULL)
    {
        if( $this->getFetchtype() == 'categoryset'){
            return $this->categorysetTag($name, $value,$paramater, $options);
        }
        else{
           $paramater['key']	=	isset($paramater['key'])		?	$paramater['key'] : "id";
            $paramater['val']	=	isset($paramater['val'])		?	$paramater['val'] : "id";
            $c2['option']		=	isset($paramater['option'])		?	$paramater['option'] : array();
            $inputType			=	isset($paramater['inputType'])	?	$paramater['inputType'] : "selectTag";
            $name				=	($inputType == "checkboxTag")	?	$name . "[checkbox][]" : $name;

            /* Set filter */
            $data_arr = $this->InformationSet($this->getInformationSetFetchType())->OneDArray($paramater['key'],$paramater['val'],$c2['option']);

            return App::load("Helper/Html")->$inputType( $name , $data_arr , $value, $options);
        }
    }
	
   /**
    * Fetch value from an Informationset and Return a with a 2D array format
    * Note: This function is usefull to use a part of information in droupdown box
    *
    * @parame skey String
    * @parame sval String
    * @parame option Array
    * @return Array
    * @example $this->informationSetBy1DArray("editorial_poat","id","title",array("ioptions='status' AND ivalue='Active'"));
    */
    public function oneDArray($skey = 'id', $sval = NULL,$option = array() )
    {
        $tmp_data = App::InformationSet($this->getInformationSetFetchType())->findAll();
        $tmp = array();
        foreach( $tmp_data['data'] as $key => $val ){
            if(isset($val[$skey]) && isset($val[$sval])){
                $tmp[$val[$skey]] = $val[$sval];
            }
        }
		
        return $tmp;
    }	
	
	/**
     * Get Information Set Value By Id
     *
     * @param ids String
     * @param title_key String
     * @param h_link String
     * @param options Array
     * @return String
     */
    public function idToName($ids = NULL ,$title_key = 'id', $h_link = 'No',$options=NULL)
    {
        if( $ids == "" ) return "";

        if( $this->getFetchtype() == 'categoryset'){
            return App::CategorySet()->IdToName( $ids, $title_key, $h_link, $options );
        }
        else{

            $a = array();
            foreach( explode(',',$ids) as $id ){
                $info_arr = $this->InformationSet($this->getInformationSetFetchType())->findById( $id);
				if(!empty($info_arr)){
					if( strtolower($h_link) == 'yes' ){
						if( isset($options['link-url'])){
							$a[] = app::Load("Helper/Html")->linkTag(str_replace("[id]",$id,$options['link-url']),$info_arr[$title_key]);
						}
						else{
							$a[] = app::Load("Helper/Html")->linkTag(App::Helper('Config')->baseurl("/information/manage/" . $this->getInformationSetFetchType() . "/view/$id"),$info_arr[$title_key]);
						}
					}
					else{
						$a[] = $info_arr[$title_key];
					}
				}
            }
            return  join(',',$a);
        }
    }
	
	/**
     * Export Information Set
     *
     * Return Mix
     */
    public function export($download = false)
    {
        $info_arr = $this->InformationSet($this->getInformationSetFetchType())->findAll();

        switch (strtolower($this->getExporttype())) {
            case 'csv':
                $data = App::Load("Helper/Utility")->convertArrayToCsvString(array_keys($info_arr['data'][0]), ',');
                foreach ($info_arr['data'] as $val) {
                    $data .= App::Load("Helper/Utility")->convertArrayToCsvString($val, ',');
                }
                break;
            case 'xml':
                $data = App::Load("Helper/Utility")->convertArrayToXML($info_arr['data']);
                break;
        }

        if ($download === true) {
            App::Load("Helper/Utility")->downloadInline($data, $this->getInformationSetFetchType() . '.' . $this->getExporttype());
        }
        else {
            return $data;
        }
    }	
	
	
}