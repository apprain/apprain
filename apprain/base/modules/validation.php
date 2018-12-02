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

abstract class appRain_Base_Modules_Validation extends appRain_Base_Objects
{
    /*
     *   Common Reguler Expression Rules
     */
    private $_ruleExp = Array(
        'alphanumeric' => '/^[\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}]+$/mu',
        'email' => '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i',
        'password' => '/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/',
        'notempty' => '/.+/',
        'time' => '%^((0?[1-9]|1[012])(:[0-5]\d){0,2}([AP]M|[ap]m))$|^([01]\d|2[0-3])(:[0-5]\d){0,2}$%',
        'cc' => Array(
            'amex' => '/^3[4|7]\\d{13}$/',
            'bankcard' => '/^56(10\\d\\d|022[1-5])\\d{10}$/',
            'diners' => '/^(?:3(0[0-5]|[68]\\d)\\d{11})|(?:5[1-5]\\d{14})$/',
            'disc' => '/^(?:6011|650\\d)\\d{12}$/',
            'electron' => '/^(?:417500|4917\\d{2}|4913\\d{2})\\d{10}$/',
            'enroute' => '/^2(?:014|149)\\d{11}$/',
            'jcb' => '/^(3\\d{4}|2100|1800)\\d{11}$/',
            'maestro' => '/^(?:5020|6\\d{3})\\d{12}$/',
            'mc' => '/^5[1-5]\\d{14}$/',
            'solo' => '/^(6334[5-9][0-9]|6767[0-9]{2})\\d{10}(\\d{2,3})?$/',
            'switch' => '/^(?:49(03(0[2-9]|3[5-9])|11(0[1-2]|7[4-9]|8[1-2])|36[0-9]{2})\\d{10}(\\d{2,3})?)|(?:564182\\d{10}(\\d{2,3})?)|(6(3(33[0-4][0-9])|759[0-9]{2})\\d{10}(\\d{2,3})?)$/',
            'visa' => '/^4\\d{12}(\\d{3})?$/',
            'voyager' => '/^8699[0-9]{11}$/'
        )
    );

    /**
     * Validate Email Address
     *
     * @param $_value String
     * @return Boolean
     */
    public function email($_value)
    {
        return
            $this->setRuleType('email')
                ->setRuleValue($_value)
                ->excRegExp();

    }

    /**
     * Validate Password
     * Rule: Password must be at least 8 characters and must contain at least one lower case letter, one upper case letter and one digit
     *
     * @param $_value String
     * @return Boolean
     */
    public function password($_value)
    {
        return
            $this->setRuleType('password')
                ->setRuleValue($_value)
                ->excRegExp();

    }

    public function textData($_value)
    {
        return true;
    }

    /**
     * In List
     */
    function inList($_value, $options)
    {
        if ($this->allowEmpty($_value, $options)) {
            return true;
        }
        $list = isset($options["_list"]) ? $options["_list"] : $options;
        return in_array($_value, $list);
    }

    public function isImage($file_name = "", $options = Array())
    {
        if ($this->allowEmpty($file_name, $options)) {
            return true;
        }
        $list = isset($options["_list"]) ? $options["_list"] : $options;
        $ext_arr = empty($list) ? array('.gif', '.jpg', '.jpeg', '.png') : $list;

        $sp = strrpos($file_name, '.');
        $ep = strlen($file_name);
        $ext = substr($file_name, $sp, $ep);
        return in_array(strtolower($ext), $ext_arr) ? true : false;
    }

    public function isDoc($file_name = "", $options = Array())
    {
        if ($this->allowEmpty($file_name, $options)) return true;

        $list = isset($options["_list"]) ? $options["_list"] : $options;
        $ext_arr = empty($list) ? array('.doc', '.docx', '.txt', '.docm', '.docm', '.rtf') : $list;

        $sp = strrpos($file_name, '.');
        $ep = strlen($file_name);
        $ext = substr($file_name, $sp, $ep);
        return in_array(strtolower($ext), $ext_arr) ? true : false;
    }

    public function isPDF($file_name = "", $options = Array())
    {
        if ($this->allowEmpty($file_name, $options)) return true;

        $list = isset($options["_list"]) ? $options["_list"] : $options;
        $ext_arr = empty($list) ? array('.pdf') : $list;

        $sp = strrpos($file_name, '.');
        $ep = strlen($file_name);
        $ext = substr($file_name, $sp, $ep);
        return in_array(strtolower($ext), $ext_arr) ? true : false;
    }

    public function notEmpty($_value = "")
    {
		// Empty Value
		if(empty($_value)) return false;
		
		// Empty Date
		if($_value=='0000-00-00') return false;
		
		// Empty Date
		if($_value=='--')return false;
		
		
	
        return
            $this->setRuleType('notempty')
                ->setRuleValue($_value)
                ->excRegExp();
    }

    private function allowEmpty($_value, $options)
    {
        $options["allowEmpty"] = isset($options["allowEmpty"]) ? $options["allowEmpty"] : "No";

        return (strtolower($options["allowEmpty"]) == "yes" && $_value == "") ? true : false;
    }

    /**
     * Validate Alpha Numeric Value
     *
     * @param $_value String
     * @return Boolean
     */
    public function alphaNumeric($_value)
    {

        return
            $this->setRuleType('alphanumeric')
                ->setRuleValue($_value)
                ->excRegExp();
    }

    /**
     * Validate CC Value
     *
     * @param $_value String
     * @return Boolean
     */
    public function cc($_value, $options)
    {
        return
            $this->setReExp($this->_ruleExp['cc'][$options['type']])
                ->setRuleValue($_value)
                ->excRegExp();
    }

    public function uniqueInformation($_value, $options)
    {
        $key = "findAllBy{$options['fieldname']}";
        $info = App::InformationSet($options['type'])->$key($_value);
        foreach ($info['data'] as $key => $val) {
            if ($val['id'] == $options['id']) {
                unset($info['data'][$key]);
            }
        }
        return empty($info['data']);
    }

    public function unique($_value, $options)
    {
        $id = isset($options['id']) ? $options['id'] : "";
        $fx = "findBy{$options['field']}";
        $row = App::Load("Model/{$options['model']}")->$fx($_value);

        if (empty($row)) {
            return true;
        }
        else {
            return ($id == $row['id']) ? true : false;
        }
    }

    /**
     * Check Minimum lenght of a value
     */
    public function minlength($_value, $options)
    {
        return ($options['minlength'] > strlen($_value)) ? false : true;
    }

    /**
     * Check Minimum lenght of a value
     */
    public function maxlength($_value, $options)
    {
        return ($options['maxlength'] < strlen($_value)) ? false : true;
    }


    public function date($_value)
    {
        return
            (
				checkdate(
					date('m', strtotime($_value)),
					date('d', strtotime($_value)),
					date('Y', strtotime($_value))
				)
            );

    }

    public function time($_value)
    {

        return
            $this->setRuleType('time')
                ->setRuleValue($_value)
                ->excRegExp();
    }

    function boolean($_value)
    {
        $options = array(0, 1, '0', '1', true, false);
        return in_array($_value, $options, true);
    }

    function money($_value, $symbolPosition = 'left')
    {

        $exp = ($symbolPosition == 'right')
            ? '/^(?!0,?\d)(?:\d{1,3}(?:([, .])\d{3})?(?:\1\d{3})*|(?:\d+))((?!\1)[,.]\d{2})?(?<!\x{00a2})\p{Sc}?$/u'
            : '/^(?!\x{00a2})\p{Sc}?(?!0,?\d)(?:\d{1,3}(?:([, .])\d{3})?(?:\1\d{3})*|(?:\d+))((?!\1)[,.]\d{2})?$/u';

        return
            $this->setReExp($exp)
                ->setRuleValue($_value)
                ->excRegExp();
    }

    function isNumber($_value, $optins)
    {
        return is_numeric($_value);
    }


    /**
     * Execute Validation By Reguler Expression
     */
    public function excRegExp()
    {
        if ($this->getReExp()) {
            $exp = $this->getReExp();
            $this->unsetReExp();
        }
        else {
            $exp = $this->_ruleExp[$this->getRuleType()];
        }

        return preg_match($exp, $this->getRuleValue());
    }
}