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

class appRain_Base_Modules_Hook extends appRain_Base_Objects
{
    private $_hookRegister = Array();

    public function register()
    {
        $this->_hookRegister[strtolower($this->getHookName())][strtolower($this->getAction())][] = array('resource' => func_get_args());
    }

    public function getHookResouce($hookName = "", $hookAction = "")
    {
        return isset($this->_hookRegister[strtolower($hookName)][strtolower($hookAction)]) ? $this->_hookRegister[strtolower($hookName)][strtolower($hookAction)] : Array();
    }

    public function getHandler($name = "", $action = "", $args = null, $resultFlag = 'result')
    {
        $hookResource = $this->getHookResouce($name, $action);

        $data = Array();
        if (!empty($hookResource)) {
            foreach ($hookResource as $node) {
                if (($class = $node['resource'][0]) != "" && ($method = $node['resource'][1]) != "") {
                    $param = (isset($node['resource'][2])) ? $node['resource'][2] : null;
                    switch ($resultFlag) {
                        case "result"  :
                            $data[] = App::__obj($class)->$method($args, $param);
                            break;
                        case "display" : 
                            echo App::__obj($class)->$method($args, $param);
                            break;
                        default           :
                            $data[] = array('_obj' => App::__obj($class), 'method' => $method, 'args' => $args, 'param' => $param);
                            break;
                    }
                }
            }
        }
        return $data;
    }

    public function render($action = null, $args = null, $auto_display = true)
    {
        if (app::__def()->sysConfig('SHOW_HOOK_POSITIONS') == 'Yes') {
            echo(App::Helper('Html')->getTag('span', array('style' => 'border:1px solid red;color:red;margin:5px;'), "[{$action}]"));
        }

        $data = $this->getHandler($this->getName(), $action, $args);

        if (empty($data)) {
            $data = array($this->getDefaultData());
            $this->unsetDefaultData();
        }

        $data = App::Module('Universal_Formating')->blockFormated($data);

        if ($auto_display) {
            echo $data;
        }
        else {
            return $data;
        }
    }
}