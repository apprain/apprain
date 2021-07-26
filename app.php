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

$appLoc = dirname(__FILE__) . "/apprain/base/config.php";

if (!file_exists($appLoc)) {
    die("appRain core file(s) missing... Get a new copy ");
    exit;
}

require_once $appLoc;

final class App
{
    const SUPERADMINLOGINID = 0;
    
    static public $__appData = Array();
    static private $_appDef = NULL;
    static private $__appObj = Array();
    static private $__hash_table = Array(
        "Model" => "Model",
        "Module" => "appRain_Base_Modules_",
        "Helper" => "Development_Helper_",
        "Plugin" => "Development_Plugin_",
        "View" => "Development_View_",
        "Installer" => "Development_Models_Installer_",
        "Component" => "Component_"
    );

    public static function getBaseDir()
    {
        return strtolower(dirname(__FILE__));
    }

    public static function __pathToClass($path = "", $isObject = true)
    {
        $p = str_replace(self::getBaseDir() . DS, "", $path);
        $p = str_replace(DS, CDS, $p);
        $cn = str_replace(SEXT, "", $p);
        return ($isObject) ? self::__obj($cn) : $cn;
    }

    public static function getBaseUrl()
    {
        return
            substr(
                dirname($_SERVER["PHP_SELF"]),
                0,
                (
                    (
                    strrpos(
                        dirname(
                            $_SERVER["PHP_SELF"]
                        ),
                        "webroot"
                    )
                    ) - 1
                )
            );
    }

    public static function __def()
    {
        if (!isset(self::$_appDef)) {
            self::$_appDef = self::load('Module/Definition');
        }

        return self::$_appDef;
    }

    public static function __obj($class_name)
    {
        if (!isset(self::$__appObj[strtolower($class_name)])) {
            self::$__appObj[strtolower($class_name)] = new $class_name();
        }

        return self::$__appObj[strtolower($class_name)];
    }

    public static function get($__key = null)
    {
        return isset(self::$__appData[$__key]) ? self::$__appData[$__key] : self::$__appData;
    }

    public static function AdminManager()
    {
        return self::Module("Admin");
    }

    public static function PageManager($id = NULL)
    {
        return self::Module("Page");
    }

    public static function categorySet($type = NULL)
    {
        return self::Module("categorySet")->categorySet($type);
    }

    public static function informationSet($type = NULL)
    {
        return self::Module("InformationSet")->InformationSet($type);
    }

    public static function helper($name = NULL)
    {
        return isset($name) ? self::load("Helper/{$name}") : NULL;
    }

    public static function module($name = NULL)
    {
        return isset($name) ? self::load("Module/{$name}") : NULL;
    }
	
	public static function Html()
    {
        return App::Helper('Html');
    }
	
	public static function Utility()
    {
        return App::Helper('Utility');
    }	
	
    public static function Session()
    {
        return App::Module('Session');
    }

    public static function Config()
    {
        return App::Helper('Config');
    }

    public static function model($name = 'Home')
    {
        return isset($name) ? self::load("Model/{$name}") : NULL;
    }

    public static function plugin($name = NULL)
    {
        return isset($name) ? self::load("Plugin/{$name}") : NULL;
    }

    public static function component($name = NULL)
    {
        return isset($name) ? self::load("Component/{$name}_" . appRain_Base_component::BOOT_FILE) : NULL;
    }
	
	public static function View($name = NULL)
    {
        return isset($name) ? self::load("View/{$name}_Definition_Register") : NULL;
    }

    public static function hook($name = NULL)
    {
        return self::module('Hook')->setName($name);
    }

    public static function load($hash)
    {
        $tags = explode("/", $hash);

        if (!isset(self::$__hash_table[$tags[0]]) || count($tags) < 2) {
            if (self::__def()->sysConfig('DEBUG_MODE') > 0) {
                pre(("Error : Invalide hash({$hash}) has tried to load. Uses app::load('Module/Session')  "));
            }
            return false;
        }

        switch (strtolower($tags[0])) {
            case "model" :
                return self::__obj(
                    (
                        strtolower(
                            $tags[1]) . self::$__hash_table[$tags[0]]
                    )
                );
                break;
            default    :
                return self::__obj((self::$__hash_table[$tags[0]] . $tags[1]));
        }

    }

    public static function call($__class, $__method, $__param = Array())
    {
        if (method_exists($__class, $__method)) {
            call_user_func_array(array($__class, $__method), $__param);
        }
    }

    public static function __transfer($suri = null)
    {
        if (empty($suri) || $suri === '/') {
            header(
                "location:"
                    . "http://"
                    . $_SERVER['HTTP_HOST']
                    . substr($_SERVER["PHP_SELF"], 0, (strpos($_SERVER["PHP_SELF"], "/webroot")))
                    . app::__def()->sysConfig('URL_FOR_404_PAGE')
            );
        }
        else {
            header(
                "location:"
                    . "http://"
                    . $_SERVER['HTTP_HOST']
                    . substr($_SERVER["PHP_SELF"], 0, (strpos($_SERVER["PHP_SELF"], "/webroot")))
                    . $suri
					. (!strstr($suri,'?') ? '?' : '')
					. "&redirecturi=" . substr($_SERVER["REDIRECT_URL"],strpos($_SERVER["REDIRECT_URL"], "/webroot")+9,strlen($_SERVER["REDIRECT_URL"]))
            );
        }
        exit;
    }

    public static function run()
    {
        $arrCaller = Array();
        $arrParams = Array();

        self::__def();	
        App::__def()->getComponentList();
		App::pageManager()->registerCallBacks();
        App::__def()->registerThemeInfo();

        $definition = self::__def()->getURIManagerDefinition();

        if (!empty($_GET)) {
            $_GET['basicrout'] = isset($_GET['basicrout']) ? str_replace(self::$_appDef->sysConfig('URI_SEPARATOR_MASK'), DS, $_GET['basicrout']) : "";

            $arry2call = explode(DS, $_GET['basicrout']);

            # Page routing section
            if (!empty($definition['pagerouter'])) {
                foreach ($definition['pagerouter'] as $key => $val) {
                    if ($arry2call[0] == $val["virtual"][0]) {
                        if (self::$_appDef->sysConfig('ROUTING_MODE') == "COMPACT") {
                            unset($arry2call[0]);
                            $arry2call = array_merge($val["actual"], $arry2call);
                        }
                        else if (self::$_appDef->sysConfig('ROUTING_MODE') == "EXTENDED") {
                            $sliced = array_slice($arry2call, 0, count($val['virtual']));
                            $rnt = array_diff($sliced, $val['virtual']);
                            if (empty($rnt)) {
                                $arry2call = $val['actual'] + $arry2call;
                            }
                        }
                    }
                }
            }

            # Format all $_GET parameters
            foreach ($arry2call as $key => $val) {
                if ($key > 1) {
                    $arrParams[] = $val;
                }
            }
        }

        # Just to be safe
        $arry2call[0] = (isset($arry2call[0])) ? $arry2call[0] : '';
        $arry2call[1] = (isset($arry2call[1])) ? $arry2call[1] : '';


        # Set Controller and Methods
        if ($arry2call[0] == '') {
            $arrCaller['controller'] = isset($definition['bootrouter']['controller'])
                ? $definition['bootrouter']['controller'] : 'home';

            $arrCaller['action'] = isset($definition['bootrouter']['action'])
                ? $definition['bootrouter']['action'] : 'index';
        }
        else {

            $arrCaller['controller'] = $arry2call[0];
            $arrCaller['action'] = ($arry2call[1] != '') ? $arry2call[1] : 'index';
        }


        $page_router = $definition['pagerouter'];

        # Do some security process
        if (!empty($page_router)) {
            foreach ($page_router as $key => $val) {
                $virtual_controller = isset($val['virtual'][0]) ? $val['virtual'][0] : '';
                $virtual_action = isset($val['virtual'][1]) ? $val['virtual'][1] : 'index';

                if ($virtual_controller == $arrCaller['controller'] && $virtual_action == $arrCaller['action']) {
                    $arrCaller['controller'] = $val['actual'][0];
                    $arrCaller['action'] = $val['actual'][1];
                }
            }
        }

        # Normalize Controller Name and Method
        $arrCaller['controller'] = str_replace(self::$_appDef->sysConfig('URI_MASK'), '_', $arrCaller['controller']);
        $arrCaller['action'] = str_replace(self::$_appDef->sysConfig('URI_MASK'), '_', $arrCaller['action']);

        # Assign the routers
        $arrCaller = empty($arrCaller) ? $boot_router : $arrCaller;

        $__ctrl = $arrCaller['controller'] . "Controller";
        $__action = $arrCaller['action'] . "Action";
        $__event = new $__ctrl;
        $__event->params = $arrCaller;
        $__event->bootstrapping();
        $__event->_before_render();

        if (method_exists($__event, $__action)) {
            if (
                !isset($__event->dispatch['preDispatchExclude'])
                || !in_array($__action, $__event->dispatch['preDispatchExclude'])
            ) {
                app::call($__event, "__preDispatch");
            }

            app::call($__event, $__action, $arrParams);

            if (!isset($__event->dispatch['postDispatchExclude'])
                || !in_array($__action, $__event->dispatch['postDispatchExclude'])
            ) {
                app::call($__event, "__postDispatch");
            }
        }
        else {
            if (self::__def()->sysConfig('DEBUG_MODE') > 0) {
                try {
                    throw new AppException('Trace:');
                }
                catch (AppException $e) {
					self::__transfer("/developer/exception/invalid_action_method?arg[]={$arrCaller['controller']}&arg[]={$arrCaller['action']}");
                }
            }
            else {
                self::__transfer(self::__def()->sysConfig('URL_FOR_404_PAGE'));
            }
        }

        # Manage Global Redirection
        if (self::$_appDef->sysConfig('GLOBAL_REDIRECTION')) {
            $globalrouter = (!empty($definition['globalrouter']))
                ? $definition['globalrouter']
                : Array(
                    'controller' => 'home',
                    'action' => 'index'
                );
            if (
                ($globalrouter['controller'] != $arrCaller['controller']
                || $globalrouter['action'] != $arrCaller['action'])
                && $__event->layout != 'admin'
            ) {
                self::__transfer(DS . implode(DS, $globalrouter));
            }
        }

        $__event->render($arrCaller['controller'] . DS . $arrCaller['action']);
        $__event->_after_render();
    }
}
// END APP FACTORY