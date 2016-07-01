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

class appRain_Base_Modules_Session extends appRain_Base_Objects
{
    /**
     *     To write session
     */
    public function write($name = "", $val = "")
    {
        if ($name != "") {
            $_SESSION[$name] = $val;
        }

        return $this;

    } //function session_write( $name = NULL, $val = NULL)

    /**
     *    To read session
     */
    public function read($name = NULL)
    {
        if (isset($name)) {
            return isset($_SESSION[$name]) ? $_SESSION[$name] : '';
        }
        else {
            return $_SESSION;
        }
    }

    //function session_read( $name = NULL)

    /**
     *    To Check session
     */
    public function exists($name = NULL)
    {
        return isset($_SESSION[$name]) ? true : false;
    }

    //function session_read( $name = NULL)

    /**
     *    To delete session
     */
    public function delete($name = NULL)
    {
        if (isset($_SESSION[$name])) {
            unset($_SESSION[$name]);
        }
        return $this;
    }

    //function session_delete( $name = NULL)

    /**
     *    Push a value temporerly for further use
     */
    public function push($name = NULL, $val = NULL)
    {
        $this->write($name, $val);
        return $this;
    }

    /**
     * Delete the previouse value and return it
     */
    public function pop($name = NULL, $flag = true)
    {
        if ($name == "") return NULL;

        $tmp = $this->read($name);

        if ($flag) {
            $this->delete($name);
        }

        return $tmp;
    }

}