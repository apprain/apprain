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

class appRain_Base_Modules_Cryptography extends appRain_Base_Objects
{
    private $salt = '$1$stoptherain$';

    public function jsonEncode($a = NULL)
    {
        if (is_null($a)) {
            return 'null';
        }
        if ($a === false) {
            return 'false';
        }
        if ($a === true) {
            return 'true';
        }
        if (is_scalar($a)) {
            if (is_float($a)) {
                // Always use "." for floats.
                return floatval(str_replace(",", ".", strval($a)));
            }

            if (is_string($a)) {
                static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
                return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
            }
            else {
                return $a;
            }
        }
        $isList = true;
        for ($i = 0, reset($a); $i < count($a); $i++, next($a)) {
            if (key($a) !== $i) {
                $isList = false;
                break;
            }
        }
        $result = array();
        if ($isList) {
            foreach ($a as $v) {
                $result[] = $this->jsonEncode($v);
            }
            return '[' . join(',', $result) . ']';
        }
        else {
            foreach ($a as $k => $v) {
                $result[] = $this->jsonEncode($k) . ':' . $this->jsonEncode($v);
            }
            return '{' . join(',', $result) . '}';
        }
    }

    public function jsonDecode($json)
    {
        // Author: walidator.info 2009
        $comment = false;
        $out = '$x=';

        for ($i = 0; $i < strlen($json); $i++) {
            if (!$comment) {
                if ($json[$i] == '{') {
                    $out .= ' array(';
                }
                else if ($json[$i] == '}') {
                    $out .= ')';
                }
                else if ($json[$i] == ':') {
                    $out .= '=>';
                }
                else {
                    $out .= $json[$i];
                }
            }
            else {
                $out .= $json[$i];
            }
            if ($json[$i] == '"') {
                $comment = !$comment;
            }
        }

        eval($out . ';');

        return $x;
    }

    /*							PHP Crypct
     ---------------------------------------------------------------------------
    $notEncripted   = '1234565';
    $encripted      = App::Module("Cryptography")->salt('rl')->encrypt($notEncripted);
    $result         = App::Module("Cryptography")->checkEncrypt("1234565", $encripted);
     ---------------------------------------------------------------------------
    */
    public function encrypt($input = NULL)
    {
        $input = isset($input) ? $input : $this->randomNumber();

        return md5($input);
        #return crypt($input, $this->salt);
    }

    public function    checkEncrypt($notEncripted = NULL, $encripted = NULL)
    {
        return (md5($notEncripted) === $encripted);
        #return (crypt($notEncripted, $encripted) == $encripted);
    }

    /**
     * Example Salts:
     * _J9..rasm
     * $1$rasmusle$
     * $2a$07$rasmuslerd...........$
     */
    public function salt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /** 
     *	PHP MD5     
     */
    public function md5($input)
    {
        return md5($input);
    }

    public function    checkMd5($notEncripted = NULL, $encripted = NULL)
    {
        return (md5($notEncripted) === $encripted);
    }

	/*
     * Generate Random number
     */
    public function randomNumber($salt='')
    {
		$rnd4 = rand(11, 99);
		$rnd = time();
		return $rnd4 . $salt. $rnd;
    }
	
	public function mask($str=null,$l=4,$r=4){
		return  substr($str,0,$l) . '********' . substr($str,strlen($str)-$r,strlen($str));		
	}	
}