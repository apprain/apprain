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
 
class Component_Blog_Helpers_Data extends appRain_Base_Objects
{
    public function getName($Post=null)
    {
		if(!is_array($Post)){
			$post = App::Model('blogComment')->find();
		}
	}
	
	public function getFirstPera($text='', $cnt=1){
		
		$data = preg_split('[\<\/p>]',$text);
		
		$newText = '';
		for($i=0; $i<count($data) && $i < $cnt;$i++){
			$newText .= "{$data[$i]}</p>";
		}
		
		return $newText;
	}
	
	public function caregoryList(){
		$Category = App::CategorySet('blog-cat')->findAll("1 ORDER BY title");
		return $Category['data'];
	}
	
	public function countCommentByPost($postid=null){
		if(!isset($postid)){
			return (string) "0";
		}
		
		return App::Model('blogComment')->countEntry("postid={$postid}");
	}
}