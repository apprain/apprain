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

class Component_Appreport_Helpers_Formatting extends appRain_Base_Objects
{
	public function rpad($input='', $pad_length=0, $pad_string=null,$Url=null)
	{
        $pad_string = isset($pad_string) ? $pad_string : ' ';
        
        if(isset($Url)){        
            return App::Html()->linkTag($Url,str_pad (substr($input,0,$pad_length), $pad_length, $pad_string, STR_PAD_RIGHT));
        }        
        else{
            return str_pad (substr($input,0,$pad_length), $pad_length, $pad_string, STR_PAD_RIGHT);
        }        
	}
	
	public function lpad($input='', $pad_length=0, $pad_string=null,$Url=null)
	{
        $pad_string = isset($pad_string) ? $pad_string : ' ';
        
        if(isset($Url)){        
            return App::Html()->linkTag($Url,str_pad (substr($input,0,$pad_length), $pad_length, $pad_string, STR_PAD_LEFT));
        }        
        else{
            return str_pad (substr($input,0,$pad_length), $pad_length, $pad_string, STR_PAD_LEFT);
        }
	}
	
	public function cpad($input='', $pad_length=0, $pad_string=null)
	{
        $pad_string = isset($pad_string) ? $pad_string : ' ';
        
        if(isset($Url)){        
            return App::Html()->linkTag($Url,str_pad (substr($input,0,$pad_length), $pad_length, $pad_string, STR_PAD_BOTH));
        }        
        else{
            return str_pad (substr($input,0,$pad_length), $pad_length, $pad_string, STR_PAD_BOTH);
        }
        
		//return str_pad (substr($input,0,$pad_length), $pad_length, $pad_string, STR_PAD_BOTH);
	}
	
	public function printr($value=''){
		echo "<pre>{$value}</pre>";
	}
}