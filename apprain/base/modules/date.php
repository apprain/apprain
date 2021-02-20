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
abstract class appRain_Base_Modules_Date extends appRain_Base_Objects {

    public function getDate($date_formate = 'Y-m-d', $time = null) {
        if (!empty($time)) {
            return date($date_formate, $time);
        }
        return date($date_formate, $this->getTime());
    }

    /**
     * This public function returing the time adjusting  tme with offset set by admin
     *
     * @ return string
     */
    public function getTime() {
        $business_date = App::Config()->Setting('business_date');
        if (empty($business_date)) {
            $business_date = date('Y-m-d');
        }

        $business_time = App::Config()->Setting('business_time');
        if (empty($business_time)) {
            $business_time = date('H:i:s');
        }

        return strtotime("{$business_date} {$business_time}"); //time();// + (3*24*60*60);
    }

    public function getTimeZoneList() {
        $zone_list = $this->getAllTimeZoneList();
        if (isset($zone_list)) {
            return $zone_list;
        } else {
            $zone_list = array();
            if (function_exists('timezone_abbreviations_list')) {
                $abbrarray = timezone_abbreviations_list();
                foreach ($abbrarray as $val) {
                    foreach ($val as $zone) {
                        if ($zone['timezone_id'] != '') {
                            $zone_list[$zone['timezone_id']] = $zone['timezone_id'];
                        }
                    }
                }
                ksort($zone_list);
            }
            if (empty($zone_list)) {
                $zone_list = array(
                    'America/Los_Angeles' => 'America/Los_Angeles',
                    'America/Porto_Acre' => 'America/Porto_Acre',
                    'America/Eirunepe' => 'America/Eirunepe',
                    'America/Rio_Branco' => 'America/Rio_Branco',
                    'Brazil/Acre' => 'Brazil/Acre',
                    'Dhaka/Asia' => 'Dhaka/Asia'
                );
            }
            $this->setAllTimeZoneList($zone_list);
            return $zone_list;
        }
    }

    /*
     * 	To validate time
     */

    public function date2MicroTime($mydate) {
        if (is_integer($mydate) || is_numeric($mydate)) {
            return intval($mydate);
        } else {
            return strtotime($mydate);
        }
    }

    /*
     * 	Return a pretty for mat of give date
     * 	Exampel: $this->date_formated('1971', "short")
     */

    public function dateFormated($date_c = null, $flag = "short") {
        if (empty($date_c)) {
            return '';
        }

        if (substr($date_c,0,10) == '0000-00-00') {
            return '';
        }

        if ($date_c != null) {
            $formated_date = $this->date2MicroTime($date_c);
        } else {
            $formated_date = $this->getTime();
        }

        if($flag == "long") {			
			//return date("D, M jS Y, h:ia ", $formated_date);
			return date("j M Y, h:ia ", $formated_date);
		}
		else if($flag == "short"){
			return date("j M Y", $formated_date);
		}
		else{
			return date($flag, $formated_date);
		}
    }

    public function dateDifference($d1, $d2, $select = 'day') {
        $d = ($this->date2MicroTime($d1) - $this->date2MicroTime($d2));
        if (strtolower($select) == 'day') {
            return abs(round($d / (60 * 60 * 24)));
        }

        return $d;
    }

    public function toDate($date = null, $formate = 'Y-m-d H:i:s') {

        if (strlen($date) == 10) {
            return date('Y-m-d', strtotime($date));
        } else {
            return date($formate, strtotime($date));
        }
    }

}
