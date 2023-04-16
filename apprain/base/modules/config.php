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
abstract class appRain_Base_Modules_Config extends appRain_Base_Objects {

    public $__config = array();
    public $__key = NULL;
    public $get = Array();
    public $post = Array();
    private $singleToneAllByFkey = array();

    public function __construct() {
        $this->get = isset($_GET) ? $_GET : Array();
        $this->post = isset($_POST) ? $_POST : Array();
    }

    public function get($key = NULL) {
        $clone = $this->get_all_configs();
        $this->__key = NULL;

        if (isset($key)) {
            return isset($clone[$key]) ? $clone[$key] : NULL;
        } else {
            return $clone;
        }
    }

    private function get_all_configs() {
        $this->__config['site_info'] = $this->siteInfo();

        if (isset($this->__key)) {
            return isset($this->__config[$this->__key]) ? $this->__config[$this->__key] : Array();
        } else {
            return $this->__config;
        }
    }

    public function setting($field = null, $flag = false) {

        if (!isset($field)) {
            return null;
        }

        return $this->siteInfo($field, $flag);
    }

    public function siteInfo($field = NULL, $flag = true) {
        if (empty($this->singleToneAllByFkey)) {
            $site_config = App::Model('Config')->findAll();
            if (!empty($site_config)) {
                foreach ($site_config['data'] as $key => $val) {
                    $this->singleToneAllByFkey[$val['soption']] = $val['svalue'];
                }
            }
        }

        if (isset($this->singleToneAllByFkey[$field])) {
            return $this->singleToneAllByFkey[$field];
        }

        if ($flag === true) {
            return $this->singleToneAllByFkey;
        } else {
            if ($flag === false) {
                return null;
            } else {
                return $flag;
            }
        }
    }

    public function setSiteInfo($soption, $value) {
        $data = App::Model('Config')->findBySoption($soption);
        $data['id'] = isset($data['id']) ? $data['id'] : null;

        App::Model('Config')
                ->setId($data['id'])
                ->setSoption($soption)
                ->setSvalue($value)
                ->Save();
        return $this;
    }

    public function load($key = NULL) {
        $this->__key = $key;

        return $this;
    }

    public function baseurl($sub_part = NULL, $secure = false) {
        if ($secure) {
            return 'https://' . $this->__config['baseurl'] . $sub_part;
        } else {
            return $this->__config['http'] . $this->__config['baseurl'] . $sub_part;
        }
    }

    public function rootdir($sub_part = NULL) {
        return $this->__config['basedir'] . $sub_part;
    }

    public function basedir($sub_part = NULL) {
        return $this->__config['basedir'] . DS . "webroot" . $sub_part;
    }

    public function filemanagerurl($sub_part = NULL, $https = false) {
        $fileresource_id = App::Config()->Setting('fileresource_id');

        if (!empty($fileresource_id)) {

            return $this->baseurl(DS . "uploads" . DS . "filemanager" . DS . $fileresource_id . $sub_part, $https);
        } else {
            return $this->baseurl(DS . "uploads" . DS . "filemanager" . $sub_part, $https);
        }
    }

    public function filemanagerdir($sub_part = NULL) {
        $fileresource_id = App::Config()->Setting('fileresource_id');
        if (!empty($fileresource_id)) {
            return $this->basedir(DS . "uploads" . DS . "filemanager" . DS . $fileresource_id . $sub_part);
        } else {
            return $this->basedir(DS . "uploads" . DS . "filemanager" . $sub_part);
        }
    }

    public function skinurl($sub_part = NULL, $https = false) {
		return $this->baseurl(DS . "themeroot" . DS . $this->__config['theme'] . $sub_part, $https);
		
       /* $fileresource_id = '';//App::Config()->Setting('fileresource_id');
        if (!empty($fileresource_id)) {
            return $this->baseurl(DS . "themeroot" . DS . $this->__config['theme'] . DS . $fileresource_id . $sub_part, $https);
        } else {
            return $this->baseurl(DS . "themeroot" . DS . $this->__config['theme'] . $sub_part, $https);
        }*/
    }

    public function skindir($sub_part = NULL) {
        /*$fileresource_id = '';//App::Config()->Setting('fileresource_id');
        if (!empty($fileresource_id)) {
            return $this->basedir(DS . "themeroot" . DS . $this->__config['theme'] . DS . $fileresource_id . $sub_part);
        } else {
            return $this->basedir(DS . "themeroot" . DS . $this->__config['theme'] . $sub_part);
        }
		*/
		return $this->basedir(DS . "themeroot" . DS . $this->__config['theme'] . $sub_part);
    }

    // Redirect
    public function redirect($url_part = "", $mode = "header", $https = false) {
        $url = $this->baseurl($url_part, $https);

        if ($mode == 'javascript') {
            echo App::Helper('Html')->getTag(
                    "script", array(
                "type" => "text/javascript"
                    ), "window.location = '{$url}';"
            );
        } else {
            header("location:{$url}");
        }
        exit;
    }

    /**
     * App::Helper('Config')->setPostVars(Array("key"=>"val"))
     *   ->transfer( $url = $this->baseurl('/'),
     *   $msg = "Link expired!"
     *   );
     */
    public function transfer($redirectUrl = NULL, $message = null) {
        $message = isset($message) ? $message : $this->__("System is redirecting control to new location.");
        $redirectUrl = isset($redirectUrl) ? $redirectUrl : $this->baseurl('/');
        echo "<html>\n";
        echo "<head><title>Redirecting control...</title><style type=\"text/css\">body{font-size:14px;font-family:arial;padding-top:20px}</style></head>\n";
        echo "<body onLoad=\"document.forms['app_form'].submit();\">\n";
        echo "<center><h2>{$message}</h2></center>\n";
        echo "<form method=\"post\" name=\"app_form\" ";
        echo "action=\"" . $redirectUrl . "\">\n";
        if ($this->getPostVars())
            foreach ($this->getPostVars() as $name => $value) {
                echo "<input type=\"hidden\" name=\"$name\" value=\"$value\"/>\n";
            }
        echo "<center><br/>Please wait, If you are not automatically redirected  ";
        echo "within 5 seconds...<br/><br/>\n";
        echo "<input type=\"submit\" value=\"Click Here\"></center>\n";
        echo "</form>\n";
        echo "</body></html>\n";
        exit;
    }

    public function isSiteLive() {
        if ($this->Load('site_info')->get('is_site_alive') == 'No') {
            echo App::Load('Helper/Html')
                    ->get_tag(
                            'div', array(
                        'style' => 'font-family:verdana;font-size:12px;text-align:center;margin-top:200px'
                            ), $this->__(
                                    App::Load('Helper/Html')->get_tag(
                                            'h1', array(
                                        'style' => 'color:red'
                                            ), $this->Load('site_info')->get('site_title'))
                                    . App::Load('Helper/Html')->get_tag(
                                            'strong', 'Sorry for the inconvenience  .'
                                    ) .
                                    App::Load('Helper/Html')->get_tag(
                                            'p', 'Website is temporarily unavailable. Please try after some time.'
                                    )
                            )
            );
            exit;
        }
    }

    public function getServerInfo($key = NULL) {
		if($key== NULL){
			return $_SERVER;
		}
		
        return isset($_SERVER[$key]) ? $_SERVER[$key] : '';
    }

    public function getProtocol() {
        return $this->get('http');
    }

    public function isPageView() {
        $params = $this->getBootInfo(true);

        $current_controller = isset($params['controller']) ? $params['controller'] : '';
        $current_action = isset($params['action']) ? $params['action'] : '';

        if ($current_controller == 'page' and $current_action == 'view') {
            return true;
        } else {
            return false;
        }
    }

    public function isHomePage() {

        $BootRouting = $this->getBootInfo();
        $CurrentRouting = $this->getBootInfo(true);

        $current_controller = isset($CurrentRouting['controller']) ? $CurrentRouting['controller'] : '';
        $current_action = isset($CurrentRouting['action']) ? $CurrentRouting['action'] : '';

        $boot_controller = isset($BootRouting['controller']) ? $BootRouting['controller'] : '';
        $boot_action = isset($BootRouting['action']) ? $BootRouting['action'] : '';

        if (
                ($current_controller == $boot_controller) &&
                ($current_action == $boot_action)
        ) {
            return true;
        } else {
            return false;
        }
    }

    public function getBootInfo($isCurrent = false) {
        $params = $this->get('params');
        $current_controller = isset($params['controller']) ? $params['controller'] : '';
        $current_action = isset($params['action']) ? $params['action'] : '';

        if ($isCurrent) {
            return array('controller' => $current_controller, 'action' => $current_action);
        } else {
            $RouterInfo = App::__Def()->getURIManagerDefinition();

            $boot_controller = isset($RouterInfo['bootrouter']['controller']) ? $RouterInfo['bootrouter']['controller'] : '';
            $boot_action = isset($RouterInfo['bootrouter']['action']) ? $RouterInfo['bootrouter']['action'] : '';

            return array('controller' => $boot_controller, 'action' => $boot_action);
        }
    }

}
