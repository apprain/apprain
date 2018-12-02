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
 *  // Example
 *  // Delte Cache
 *    $this->Cache->delete('key');
 *
 *  // Replace Cache
 *    $this->Cache->replace = true;
 *    $text = 'Some content';
 *    $key = $this->Cache->write($text,'key');
 *
 *  // A standared way
 *    if( !$this->Cache->exists('key') )
 *    {
 *        $text = 'Some content';
 *        $key = $this->Cache->write($text,'key');
 *    }
 *    else
 *    {
 *        $text = $this->Cache->read('key');
 *        pr( $text );
 *    }
 */
class appRain_Base_Modules_Cache extends appRain_Base_Objects {

    public $clear_time = false;
    public $path = NULL;
    public $mode = 'BYTE_STREAM';
    public $ext = 'arbt';
    public $replace = false;

    /**
     * Prepare basic environment
     */
    public function __construct() {
        $this->ini();
    }

    /**
     * Write Cache in Disc
     *
     * @param $key MIX
     * @param $data String
     * @return Self
     */
    public function write($key = "", $data = "") {
        if (($key == "") || ($data == ""))
            return false;

        $key = $this->get_key($key);

        if ($this->exists($key)) {
            if ($this->replace)
                $this->delete($key);
            else
                return false;
        }

        $this->write_to_disk($this->encode($data), $key);

        return true;
    }

    /**
     * Read Cache from Disc
     *
     * @param $key String
     * @return String (Base64_encoded)
     */
    public function read($key = NULL) {
        if (is_null($key)) {
            return "";
        }
        $encoted_content = $this->read_from_desk($key);
        return $this->decoted($encoted_content);
    }

    /**
     * Delete Cache
     *
     * @param $pre_name String
     */
    public function delete($pre_name = NULL) {
        if (isset($pre_name)) {
            $path = $this->path . DS . "{$pre_name}.{$this->ext}";
            if (file_exists($path)) {
                unlink($path);
            }
        }

        return $this;
    }

    /**
     * Serialize Data
     *
     * @param $data MIS
     * @return BYTE_STREM
     */
    private function encode($data = NULL) {
        return isset($data) ? serialize($data) : "";
    }

    /**
     * Unserialize Data
     *
     * @param $data BYTE_STREM
     * @return MIX
     */
    private function decoted($data = NULL) {
        return isset($data) ? unserialize($data) : "";
    }

    /**
     * Set Basic Setting
     *
     * @return NULL
     */
    private function ini() {
        switch ($this->mode) {
            case 'BYTE_STREAM' :
                $this->path = BYTE_STREAM;
                break;
            default :
                $this->path = BYTE_STREAM;
                break;
        }
    }

    /**
     * Generate a key
     *
     * @param $key String
     * @return String
     */
    public function get_key($key = NULL) {
        if (isset($key)) {
            return $key;
        } else {
            return md5(uniqid(rand(), true));
        }
    }

    /**
     * @param pre_name String
     * @return Boolean
     */
    public function exists($pre_name = NULL) {
        return file_exists($this->path . DS . "{$pre_name}.{$this->ext}");
    }

    /**
     * Read From Disc
     *
     * @param $pre_name String
     * @return String
     */
    public function read_from_desk($pre_name = NULL) {
        $path = $this->path . DS . "{$pre_name}.{$this->ext}";
        $contents = "";

        if (file_exists($path)) {
            $handle = fopen($path, "r");
            $contents = '';
            while (!feof($handle)) {
                $contents .= fread($handle, 8192);
            }
            fclose($handle);
        }

        return $contents;
    }

    /**
     * Write In Disc
     *
     * @param $data String
     * @param $pre_name String
     * @return Self
     */
    public function write_to_disk($data = NULL, $pre_name = NULL) {
        $path = $this->path . DS . "{$pre_name}.{$this->ext}";

        if (!$handle = fopen($path, 'w')) {
            echo "Cannot open file ($filename)";
            exit;
        }

        if (fwrite($handle, $data) === FALSE) {
            echo "Cannot write to file ($filename)";
            exit;
        }

        fclose($handle);

        return $this;
    }

}
