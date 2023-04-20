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
 * Module Name: Email Template Manager
 *
 * Purpose: Process email template and send email by pursing templates.
 */
class appRain_Base_Modules_Emailtemplate extends appRain_Base_Objects {

    const LP = '{';
    const RP = '}';

    public $tempaltedata = Array();

    public function prepare($tempaltename = null, $send = false) {
        if (!isset($tempaltename)) {
            throw new AppException($this->__("Template is not specified"));
        }

        $this->fetchAndSetByName($tempaltename);

        if ($send) {
            $this->sendMail();
        }

        return $this;
    }

    protected function fetchAndSetByName($tempaltename = null) {
        $tempaltedata = App::InformationSet('emailtemplate')->findByTemplatetype($tempaltename);
        $this->tempaltedata = Array(
            'subject' => $this->replaceByParameters($tempaltedata['subject']),
            'message' => $this->replaceByParameters($tempaltedata['message'])
        );
        return $this;
    }

    protected function replaceByParameters($string = null) {
        if (!isset($string))
            return $string;
        $lp = self::LP;
        $rp = self::RP;

        $parameters = $this->getParameters();
        if (!empty($parameters)) {
            foreach ($parameters as $field => $value) {
                $string = str_replace("{$lp}{$field}{$rp}", $value, $string);
            }
        }

        return App::Helper('Utility')->codeFormated($string);
    }

    protected function sendMail() {
		
		$emailsetup_enabled = App::Config()->Setting("emailsetup_enabled");
		if($emailsetup_enabled != "Yes"){
			return ;
		}
		
        $siteInfo = App::Helper('Config')->siteInfo();

        $to = $this->getTo();
		
        if (empty($to)){
            $to = array($siteInfo['admin_email'], $siteInfo['admin_title']);
		}
		
        $from = $this->getFrom();
		# NEED TO UPDATE LATER
        if (!$from){
			if(isset($siteInfo['emailsetup_from_email']) && empty($siteInfo['emailsetup_from_email'])){
				$from = array($siteInfo['emailsetup_from_email'], $siteInfo['admin_title']);
			}
			else{
				$from = array($siteInfo['admin_email'], $siteInfo['admin_title']);
			}
		}
		
		$from = array($siteInfo['admin_email'], $siteInfo['admin_title']);
		

        if (isset($from[0])){
            App::Plugin('Mailing_PHPMailer')->From = $from[0];
		}
		
        if (isset($from[1])){
            App::Plugin('Mailing_PHPMailer')->FromName = $from[1];
		}

        App::Plugin('Mailing_PHPMailer')->AddAddress($to[0], $to[1]);
        App::Plugin('Mailing_PHPMailer')->Subject = $this->tempaltedata['subject'];
        App::Plugin('Mailing_PHPMailer')->MsgHTML($this->tempaltedata['message']);
        App::Plugin('Mailing_PHPMailer')->send();
    }
	
	

    public function AddAddress($email = null,$name = null) {
		 App::Plugin('Mailing_PHPMailer')->AddAddress($email, $name);
		 
		 return $this;
	}

	public function ClearAddresses() {
		 App::Plugin('Mailing_PHPMailer')->ClearAddresses();
		 
		 return $this;
	}
	
    public function load($data = null) {
        $Template = App::InformationSet('emailtemplate')->findByTemplateType($data['templateType']);
        if (empty($Template)) {
            App::InformationSet('emailtemplate')
                    ->setId(null)
                    ->setTemplateType($data['templateType'])
                    ->setSubject($data['subject'])
                    ->setMessage($data['message'])
                    ->Save();
        }
    }

    public function unLoadByTypeName($name = null) {
        $data = App::InformationSet('emailtemplate')->findByTemplatetype($name);

        if (!empty($data)) {
            App::InformationSet('emailtemplate')->Delete("{$data['id']}");
        }
    }

}
