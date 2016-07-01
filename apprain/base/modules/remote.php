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
 * http ://www.apprain.org/documents
 */


class appRain_Base_Modules_Remote extends appRain_Base_Objects
{
    private $_data = Array();
    private $_posts = Array();

    public function addField($key = NULL, $val = NULL)
    {
        $this->_data[$key] = $val;
        return $this;
    }

    public function addPost($key = NULL, $val = NULL)
    {
        $this->_posts[$key] = $val;
        return $this;
    }

    public function execute()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->_data['url']);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $this->_data['requestType'] = isset($this->_data['requestType']) ? $this->_data['requestType'] : "get";

        if (strtolower($this->_data['requestType']) == 'post') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->get_formated_posts());
        }

        ob_start();
        $result = curl_exec($ch);
        curl_close($ch);
        ob_end_clean();

        return $result;
    }

    private function get_formated_posts()
    {
        $str = "";
        if (!empty($this->_posts)) {
            foreach ($this->_posts as $key => $val) {
                if ($str == "") {
                    $str .= "{$key}={$val}";
                }
                else {
                    $str .= "&{$key}={$val}";
                }
            }
        }
        return $str;
    }
}