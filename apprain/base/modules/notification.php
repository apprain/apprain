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
 * Usages
 *
 * App::Module('Notification')->Push($this->__("Two new job waiting for approval2"),array('type'=>'admin-notice','level'=>'Warning'));
 * App::Module('Notification')->Push($this->__("New Version of appRain is available2"),array('type'=>'admin-notice','level'=>'Notice'));
 * App::Module('Notification')->Push($this->__("Group meeting on next monday"),array('level'=>'Notice','type'=>'admin-message'));
 */
class appRain_Base_Modules_Notification extends appRain_Base_Objects
{
    const MESSGE_ADMIN_GENERAL = 'admin-general';
    const MESSGE_ADMIN_NOTICE = 'admin-notice';
    private $msgKeys = Array();
    private $defaultOptions = Array('type' => 'admin-general', 'level' => 'Success');

    // Count total message
    public function Count($MSGType = self::MESSGE_ADMIN_GENERAL)
    {
        $messages = $this->getMessageByType($MSGType);
        return count($messages);
    }

    /**
     * Retrive message form session and hook
     */
    private function getMessageByType($MSGType = self::MESSGE_ADMIN_GENERAL)
    {
        // Retrive message form Session
        $systemMessages = App::Module('Session')->read('systemMessages');
        $messages = Array();
        if (!empty($systemMessages))
            foreach ($systemMessages as $key => $row) {
                $message = isset($row[0]) ? $row[0] : "";
                $level = (isset($row[1]['level']) && $row[1]['level'] != "") ? $row[1]['level'] : "success";
                $type = isset($row[1]['type']) ? $row[1]['type'] : self::MESSGE_ADMIN_GENERAL;

                if ($MSGType == $type && $message != "") {
                    $htmlMessage = $this->toHtml($message, $level, true);
                    if (!in_array($htmlMessage, $messages)) {
                        $messages[] = $htmlMessage;
                        $this->msgKeys[] = $key;
                    }
                }
            }

        // Collect Notifications form 3rd party components
        $HookMessages = App::Module('Hook')->getHandler('Ui', 'register_notification');

        if (!empty($HookMessages)) {
            foreach ($HookMessages as $message) {
                if (!empty($message)) {
                    foreach ($message as $row) {
                        $message = isset($row[0]) ? $row[0] : "";
                        $level = (isset($row[1]['level']) && $row[1]['level'] != "") ? $row[1]['level'] : "success";
                        $type = isset($row[1]['type']) ? $row[1]['type'] : self::MESSGE_ADMIN_GENERAL;

                        if ($MSGType == $type && $message != "") {
                            $htmlMessage = $this->toHtml($message, $level, true);
                            if (!in_array($htmlMessage, $messages)) {
                                $messages[] = $htmlMessage;
                            }
                        }
                    }
                }
            }
        }

        return $messages;
    }

    /**
     * Generate proper HTML format form Messages
     */
    public function toHtml($message = "", $level = "", $autoRender = false)
    {
        if ($level == 'message') {
            $level = 'success';
        }
        $level = strtolower($level);

        $heading = '';
        if ($level == 'warning') $heading = 'Warning Message';
        else if ($level == 'notice') $heading = 'Notice Message';
        else if ($level == 'success') $heading = 'Message';
        else if ($level == 'error') $heading = 'Error Message';


        $url = App::Helper('Config')->baseUrl("/themeroot/admin/images/icons/{$level}.png");
        $message = $this->__($message);

        $Html = <<<EOD
<div id="message-{$level}" class="message message-{$level}">
    <div class="image"><img src="{$url}" alt="Message" height="32" /></div>
    <div class="text">
        <strong>{$heading}</strong>
        <span>{$message}</span>
    </div>
    <div class="dismiss">
        <a href="#message-{$level}"></a>
    </div>
</div>
EOD;

        return $Html;
    }

    /**
     * Render Messages
     */
    public function display($MSGType = self::MESSGE_ADMIN_GENERAL, $autoDisplay = true)
    {
        $messages = $this->getMessageByType($MSGType);

        if (!empty($messages)) {
            $html = ($MSGType == self::MESSGE_ADMIN_GENERAL) ?
                '<div class="box"><div class="messages">' . implode('', $messages) . '</div></div>' :
                '<div class="messages" >' . implode('', $messages) . '</div>';

            $this->clearQueue();
            if ($autoDisplay) echo $html;
            else return $html;
        }
    }

    /**
     * Clear particuler type
     * of Messages
     */
    private function clearQueue()
    {
        $systemMessages = App::Module('Session')->read('systemMessages');
        if (!empty($systemMessages)) {
            foreach ($systemMessages as $key => $val) {
                if (in_array($key, $this->msgKeys)) {
                    unset($systemMessages[$key]);
                }
            }
        }
        $systemMessages = App::Module('Session')->write('systemMessages', $systemMessages);
    }

    /**
     * Write message in Session
     */
    public function Push($message = array(), $_options = null)
    {

        $message = is_string($message) ? array($message) : $message;

        if (!isset($_options)) {
            $_options = $this->defaultOptions;
        }

        if (is_string($_options)) {
            $tmp = Array();
            $tmp['level'] = $_options;
            $_options = $tmp;
        }

        $_options['type'] = isset($_options['type']) ? $_options['type'] : self::MESSGE_ADMIN_GENERAL;

        $systemMessages = $this->getMessageList();
        $system1DMessages = $this->getMessageList(true);

        $msg = array();
        if (!empty($message)) {
            foreach ($message as $row) {
                if (!in_array($row, $system1DMessages)) {
                    $msg[] = array($row, $_options);
                }
            }
        }

        $systemMessages = array_merge($systemMessages, $msg);
        App::Module('Session')->Write('systemMessages', $systemMessages);
        return $this;
    }

    public function getMessageList($is1Dlist = false)
    {
        $list = array();
        if (!$is1Dlist) {
            $list = App::Module('Session')->read('systemMessages');
        }
        else {
            $systemMessages = App::Module('Session')->read('systemMessages');
            if (!empty($systemMessages)) {
                foreach ($systemMessages as $row) {
                    if (isset($row[0])) {
                        $list[] = $row[0];
                    }
                }
                $list = array_unique($list);
            }
        }
        return $list = is_array($list) ? $list : Array();
    }
}