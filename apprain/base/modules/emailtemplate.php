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

/**
 * Module Name: Email Template Manager
 *
 * Purpose: Process email template and send email by pursing templates.
 */
class appRain_Base_Modules_Emailtemplate extends appRain_Base_Objects
{
    const LP = '{';
    const RP = '}';
    public $tempaltedata = Array();

    public function prepare($tempaltename = null, $send = false)
    {
        if (!isset($tempaltename)) {
            throw new AppException($this->__("Template is not specified"));
        }

        $this->fetchAndSetByName($tempaltename);

        if ($send){
			$this->sendMail();
		}

        return $this;
    }

    protected function fetchAndSetByName($tempaltename = null)
    {
        $tempaltedata = App::InformationSet('emailtemplate')->findByTemplatetype($tempaltename);
        $this->tempaltedata = Array(
            'subject' => $this->replaceByParameters($tempaltedata['subject']),
            'message' => $this->replaceByParameters($tempaltedata['message'])
        );
        return $this;
    }

    protected function replaceByParameters($string = null)
    {
        if (!isset($string)) return $string;
        $lp = self::LP;
        $rp = self::RP;

        $parameters = $this->getParameters();
        if (!empty($parameters)) {
            foreach ($parameters as $field => $value) {
                $string = str_replace("{$lp}{$field}{$rp}", $value, $string);
            }
        }

        return nl2br(App::Helper('Utility')->codeFormated($string));
    }

    protected function sendMail()
    {
        $siteInfo = App::Helper('Config')->siteInfo();

        $to = $this->getTo();
        if (!$to) $to = array($siteInfo['admin_email'], $siteInfo['admin_title']);

        $from = $this->getFrom();
        if (!$from) $from = array($siteInfo['admin_email'], $siteInfo['admin_title']);

		// Set configuration Admin > Preference > Sie Settings
        App::Plugin('Mailing_PHPMailer')->ContentType = "text/html";
		App::Plugin('Mailing_PHPMailer')->Host = App::Config()->setting('emailsetup_host','localhost');
		App::Plugin('Mailing_PHPMailer')->Port = App::Config()->setting('emailsetup_port','25');
		App::Plugin('Mailing_PHPMailer')->Username = App::Config()->setting('emailsetup_username','');
		App::Plugin('Mailing_PHPMailer')->Password = App::Config()->setting('emailsetup_password','');
		
        if (isset($from[0])) App::Plugin('Mailing_PHPMailer')->From = $from[0];
        if (isset($from[1])) App::Plugin('Mailing_PHPMailer')->FromName = $from[1];
		
        App::Plugin('Mailing_PHPMailer')->AddAddress($to[0], $to[1]);
        App::Plugin('Mailing_PHPMailer')->Subject = $this->tempaltedata['subject'];
        App::Plugin('Mailing_PHPMailer')->MsgHTML($this->tempaltedata['message']);
        App::Plugin('Mailing_PHPMailer')->send();
    }

    public function load($data = null)
    {
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

    public function unLoadByTypeName($name = null)
    {
        $data = App::InformationSet('emailtemplate')->findByTemplatetype($name);

        if (!empty($data)) {
            App::InformationSet('emailtemplate')->Delete("{$data['id']}");
        }
    }
}