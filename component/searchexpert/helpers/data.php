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
 
class Component_SearchExpert_Helpers_Data extends appRain_Base_Objects
{
    public $navlinks = '';
    public function generateInputs($obj=null){
       
        
        $InputType = isset($obj->type) ? $obj->type : 'inputTag';
        
        $cssClass = '';
         if($InputType =='inputTag'){
            $cssClass = isset($obj->samerowfield) ? 'small' : 'app_input';
        }
        
        
        $name = isset($obj->name) ? $obj->name : '#';
        $optaions = isset($obj->optaions) ? (array) $obj->optaions : array();
		$optaions['class'] = isset($optaions['class']) ? "{$optaions['class']} {$cssClass}" :  $cssClass;
		
        $parameters = isset($obj->parameters) ? $obj->parameters : array();
        $default = isset($obj->default) ? $obj->default : '';      
        $str = $this->createField($InputType,$name,$default,$optaions,$parameters);
        
        if(isset($obj->samerowfield)){
            
            $obj = $obj->samerowfield;           
            $InputType = isset($obj->type) ? $obj->type : 'inputTag';
            $name = isset($obj->name) ? $obj->name : '#';
            $optaions = isset($obj->optaions) ? (array)$obj->optaions : array();
			$optaions['class'] = isset($optaions['class']) ? "{$optaions['class']} small" :  'small';
            $parameters = isset($obj->parameters) ? $obj->parameters : array();
            $default = isset($obj->default) ? $obj->default : '';      
            $str .= ' ' . $this->createField($InputType,$name,$default,$optaions,$parameters);
        }
        
        
        return $str;
    }
    
     public function createField($type=null,$name,$default=null,$optaions,$parameters){
        $default =  isset($_GET[$name]) ? $_GET[$name] : $default;

        switch($type){
            case 'inputTag' : 
                return App::Html()->inputTag($name,$default,$optaions);
                break;
            case 'dateRange' : 
                $sdefault =  isset($_GET["{$name}_f"]) ? $_GET["{$name}_f"] : '';
                $tdefault =  isset($_GET["{$name}_t"]) ? $_GET["{$name}_t"] : '';
                return App::Html()->dateTag("{$name}_f",$sdefault,array('placeholder'=>'From Date','class'=>'small')) . ' &nbsp; ' . App::Html()->dateTag("{$name}_t",$tdefault,array('placeholder'=>'To Date','class'=>'small'));
                break;    
            case 'selectTag': 
            case 'radioTag' :             
                return App::Html()->selectTag($name,$parameters,$default,$optaions);
                break;
            case 'CategorySet' : 
				$categorysetname = isset($parameters->categorysetname) ? $parameters->categorysetname : $name;
                return App::categorySet($categorysetname)->Tag($name,$default,$optaions);   
				break;
			case 'Model' : 
				$modelname = isset($parameters->modelname) ? $parameters->modelname : $name;
				$parameters = (array) $parameters;
                return App::Html()->ModelTag($name,$modelname,$default,$parameters);  
				break;	
			case 'personList' : 
				if(!isset($optaions['id'])){
					$optaions['id'] = 'clientid';
				}				
				return App::Component('Inventory')->Helper('Data')->clientList($name,$default,$optaions) .
				App::Hook('UI')->Render('product_input_src_control',array('point'=>$optaions['id'],'select'=>'id','lookfor'=>'admission'),false);
				
				//$modelname = isset($parameters->modelname) ? $parameters->modelname : $name;
				//$parameters = (array) $parameters;
                //return App::Html()->ModelTag($name,$modelname,$default,$parameters);  
				break;
            case 'InformationSet' :
				$val ='id';
				if(isset($parameters))
                $val = isset($parameters->val) ? $parameters->val : 'id';
                $informationsetname = isset($parameters->informationsetname) ? $parameters->informationsetname : $name;
                $a = App::InformationSet($informationsetname)->Tag($name,$default,array('val'=>$val));    

                return $a;
                break;    
        }
    }
    
    public function fieldset($scheme=null){
	//	pre($scheme);
        $Object = json_decode($scheme['fields']);

        $DataGrid = App::Module('DataGrid')->setDisplay('FormListing');

        foreach($Object->fields as $key=>$row){
            $DataGrid->addRow($row->title,$this->generateInputs($row));            
        }
		
		$toolbar = '';
		if(!empty($Object->toolbar)){
			foreach($Object->toolbar as $row){
				$btnInfo = explode('|',$row->link);
				$link = str_replace('[BASEURL]',App::Config()->baseUrl(),$btnInfo[1]);
				$toolbar .= ' ' . App::Html()->buttonTag('',$btnInfo[0],array('class'=>'button toolbarbtn','link-action'=>$link));
			}	
		}	

        $DataGrid->addRow('',
			App::Html()->submitTag('src','Search',array('class'=>'button')) . 
			$toolbar
		);
		
		
        $DataGrid->Render();
    }
    
    public function getSearchRecords($Record=null,$select=null){
        
        $Object = json_decode($Record['fields']);
        $sortorder = isset($Object->sortorder) ? $Object->sortorder : ' id ASC';
        
        $Condition = $this->getConditionList($Object->fields,$_GET);
		
		if(isset($_GET['__dv'])){
			if($select == 'id'){
				$Condition .= " AND {$select}='" . $_GET['__dv'] . "'";
			}
			else{
				$Condition .= " AND {$select} LIKE '%" . $_GET['__dv'] . "%'";
			}
		}
        
        $Condition .= ' ORDER BY ' . $sortorder;


        $list = array();
        switch($Object->sourcetype){
            case 'Model' :
                $list = App::Model($Object->sourcename)->Paging("{$Condition}",null,'?'.$this->navlinks);
                break;
            case 'InformationSet' :
                $list = App::InformationSet($Object->sourcename)->Paging("{$Condition}",null,'?'.$this->navlinks);
                break;
			case 'CategorySet' :
                $list = App::Model('Category')->Paging("type = '{$Object->sourcename}' and {$Condition}",null,'?'.$this->navlinks);
                break;
        }
        return $list;
        
    }
    
    public function actionLink($row=null,$json='',$title='Record'){
        
        $obj = json_decode($json);        
        $link = str_replace('[BASEURL]',App::Config()->baseUrl(),$obj->link);
        $link = str_replace('[id]',$row['id'],$link);
        return App::Html()->linkTag($link,$title);
    }
    
    public function actionSelector($row=null,$json='',$point=null,$f=null,$select=null){
        
        $obj = json_decode($json); 
        $link = str_replace('[BASEURL]',App::Config()->baseUrl(),$obj->link);
        $link = str_replace('[id]',$row['id'],$link);
		
		if($pos = strpos($f,'|')){
			$array = explode('|',$f);
			if($array[1] == 'number'){
				return App::Html()->linkTag("javascript:selectPoint('#{$point}','{$row[$select]}')",App::Utility()->numberFormate($row[$array[0]]));
			}
			elseif($array[1] == 'date'){
				
				return App::Html()->linkTag("javascript:selectPoint('#{$point}','{$row[$select]}')",App::Helper('Date')->dateFormated($row[$array[0]]));
			}
			else{
				return App::Html()->linkTag("javascript:selectPoint('#{$point}','{$row[$select]}')",$row[$array[0]]);
			}			
		}
		else{
            return App::Html()->linkTag("javascript:selectPoint('#{$point}','{$row[$select]}')",$row[$f]);
		}
    }
    
    public function getConditionList($field=null,$params=null){
    
        $str = '1=1';
		
        foreach($field as $keys=>$row){
        
            $str =  $this->formatecondition($row,$params,$str);
            if(isset($row->samerowfield)){
                $str =  $this->formatecondition($row->samerowfield,$params,$str);
            }            
        }        
        return $str;
    }
	
	public function linkforated($link="",$array=array()){
		return str_replace('[BASEURL]',App::Config()->baseUrl(),$link);	
	}
    
    public function formatecondition($row=null,$params=null,$str=''){
        $name = $row->name;
        //pre($row);
        $InputType = isset($row->type) ? $row->type : 'inputTag';
        
        if((isset($params[$name]) and !empty($params[$name])) || $InputType=='dateRange' ){
          
            $this->navlinks .= !empty($this->navlinks) ? '&amp;' : 'src=Search&amp;';
            
            if($InputType == 'dateRange'){
                if(
                    isset($params["{$name}_f"]) && isset($params["{$name}_t"]) &&
                    !empty($params["{$name}_f"]) && !empty($params["{$name}_t"])
                 ){
                    $from_dt = $params["{$name}_f"];
                    $to_dt = $params["{$name}_t"];
                    
                    $str .= !empty($str) ? ' AND ' : '';
                    $str .= " date_format({$name},'%Y %d %m') BETWEEN '{$from_dt}' and '{$to_dt}' ";
                    
                    $this->navlinks .= "{$name}_f={$from_dt}&amp;{$name}_t={$to_dt}";
                }
            }
            elseif($InputType == 'inputTag'){
				$params[$name] = trim($params[$name]);
                $str .= !empty($str) ? ' AND ' : '';
                $str .= "{$name} LIKE '%{$params[$name]}%'";
                $this->navlinks .= "{$name}={$params[$name]}";
            }
            else{
				$params[$name] = trim($params[$name]);
                $str .= !empty($str) ? ' AND ' : '';
                $str .= "{$name} = '{$params[$name]}'";
                $this->navlinks .= "{$name}={$params[$name]}";
            }
        }  
        //pre($this->navlinks);       
        return $str;
    }
}


