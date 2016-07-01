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

class Development_Helper_Api_testService
{

    /**
     * @param string
     * @return integer
     */
    public function getMyTime($date = NULL)
    {
        return (string)strtotime($date);
    }

    /**
     * @return FixedArray
     */
    public function getUserInfo()
    {
        return Array
        (
            "id" => 5,
            "name" => Array("Jon")
        );
    }


    /**
     * @param string This is my string
     * @param FixedArray Must be an array
     * @return FixedArray Must be an array
     */
    public function informationSet($name, $_options = NULL)
    {
        return App::InformationSet($name)->findAll();
    }

}