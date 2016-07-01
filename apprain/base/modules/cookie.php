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


/**
 * Class to manage cookie
 *
 */
class appRain_Base_Modules_Cookie extends appRain_Base_Objects
{
    /**
     * Write Cookie
     *
     * @parameter name string
     * @parameter var mix
     * @return null
     */
    public function write($name = NULL, $val = NULL)
    {
        if (!defined("COOKIE_TIME_OUT")) $t = 24;
        else $t = COOKIE_TIME_OUT;

        if ($name != "" && $val != "") {
            setcookie($name, $val, time() + ($t * 60 * 60), "/", App::Load("Helper/Config")->get("cookie_domaint"));
        }

        return $this;
    }

    /**
     * Write Cookie
     *
     * @parameter name string
     * @return mix
     */
    public function read($name = NULL)
    {
        if (isset($name)) {
            return isset($_COOKIE[$name]) ? $_COOKIE[$name] : NULL;
        }
        else {
            return $_COOKIE;
        }
    }
}