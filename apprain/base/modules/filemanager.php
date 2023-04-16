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


class appRain_Base_Modules_FileManager extends appRain_Base_Objects
{
	
	const MAX_WIDTH = '80';
	const MAX_HIGHT = '80';
	const L_MAX_WIDTH = '200';
	const L_MAX_HIGHT = '200';
	private $searchstr = null;
    public function displayFileList($displayType='List',$searchstr=null){

		$this->searchstr = strtolower(trim($searchstr));
		if($displayType == 'grid'){
			$this->gridView();
		}
		else {			
			$this->ListView();
		}
	}
	
	public function varifyFileName($filename){
		$restrictedExt = explode(',',app::__def()->sysConfig('FILE_MANAGER_RESTRICTED_EXT'));
		return !in_array(App::Utility()->getExt($filename),$restrictedExt);
	}
	
	public function readFiles(){
		$Filelist= App::Load("Helper/Utility")->getDirLising(
			App::Config()->filemanagerdir(
			), 
			array(
				"filetime_as_index" => false
			)
		);


		if(!empty($this->searchstr)){
			$List = Array();
			foreach($Filelist['file'] as $row){
				if(strstr(strtolower($row['name']),$this->searchstr)){
					$List[] = $row;	
				}
			}
			$Filelist['file'] = $List;
		}
		
		if(isset($Filelist['file'])){
			$Filelist = App::Load("Helper/Utility")
                ->array_paginator(
                array_reverse(
                   $Filelist['file']),
                Array('limit' => "50")
            );		
		}
		return $Filelist;
	}
	
	public function gridView(){
		$Filelist = $this->readFiles();
		
		$list = Array();
		$i = 0;
		foreach($Filelist['data'] as $key=>$val){
			
			list($width, $hight) = getimagesize($val['dir_path'] . DS . $val['name']);
			$n_hight = ($hight < self::L_MAX_HIGHT ) ? $hight : self::L_MAX_HIGHT ;
			if($hight > 0 ){
				$width = round(($width/$hight)* $n_hight);
			}
			$width = ($width < self::L_MAX_WIDTH ) ? $width : self::L_MAX_WIDTH ;
					
			if($key != 0 and $key % 4==0){
				$i++;
			}
			$list[$i][] = array(
				'image'=> App::Html()->imgTag(App::Config()->filemanagerUrl(DS . $val['name']),null,array("width"=>$width,"hight"=>$n_hight)),
				'name' => $val['name']);
		}
		$Filelist['data'] = $list;			
			
		$Grid = App::Module('DataGrid')->setHeader(array("Grid View","","",""));
		foreach($Filelist['data'] as $val){

			$Grid->addrow(
				isset($val[0]) ? $val[0]['image'] : '',
				isset($val[1]) ? $val[1]['image'] : '',
				isset($val[2]) ? $val[2]['image'] : '',
				isset($val[3]) ? $val[3]['image'] : ''
			);
			
			$Grid->addrow(
				isset($val[0]) ? substr(App::Utility()->getName($val[0]['name']),0,20) . '(' . App::Utility()->getExt($val[0]['name']) . ')' : '',
				isset($val[1]) ? substr(App::Utility()->getName($val[1]['name']),0,20) . '(' . App::Utility()->getExt($val[1]['name']) . ')' : '',
				isset($val[2]) ? substr(App::Utility()->getName($val[2]['name']),0,20) . '(' . App::Utility()->getExt($val[2]['name']) . ')' : '',
				isset($val[3]) ? substr(App::Utility()->getName($val[3]['name']),0,20) . '(' . App::Utility()->getExt($val[3]['name']) . ')' : ''
			);	
		}
		
		$Grid->setFooter($Filelist['paging_str'])->Render();
	}
	public function listView(){
		$Filelist = $this->readFiles();
		
		if(!empty($Filelist)){			
			$Grid = App::Module('DataGrid')->setHeader(array("Image","Information","Size","Type","Date",""));
			foreach($Filelist['data'] as $val){
			
				list($width, $hight) = getimagesize($val['dir_path'] . DS . $val['name']);
				$n_hight = ($hight < self::MAX_HIGHT ) ? $hight : self::MAX_HIGHT ;
				if($hight > 0 ){
					$width = round(($width/$hight)* $n_hight);
				}
				$n_width = ($width < self::MAX_WIDTH ) ? $width : self::MAX_WIDTH ;
				
				$title =  str_replace($this->searchstr,"<span style=\"background-color:yellow\">{$this->searchstr}</span>",App::Utility()->getName($val['name']));
				$Grid->addrow(
					App::Html()->imgTag(App::Config()->filemanagerUrl(DS . $val['name']),null,array("width"=>$n_width,"hight"=>$n_hight))
					. '<br /><br /><strong>' . $title . '</strong><br />'  ,
					'<input type="text" class="small" value="' . App::Config()->filemanagerUrl(DS . $val['name']) . '" />' .
					'<br /><input type="text" class="small" value="' . $val['dir_path'] . DS . $val['name'] . '" />',
					"{$width}x{$hight}",
					App::Utility()->getExt($val['name']),
					App::Helper("Date")->dateFormated($val['filemtime'],'long'),
					App::Html()->linkTag(App::Config()->baseUrl("/admin/filemanager/delete/" . base64_encode($val['name'])),"Delete",array("class"=>"confirm-link"))
				);
			}
			
			$Grid->setFooter($Filelist['paging_str'])->Render();
		}
		else{
			echo $this->__('<h3 class="first">No file found.</h3>');

		}
	}
}