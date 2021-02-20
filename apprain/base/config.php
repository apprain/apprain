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
// Start Session
session_start();

// Directory separator
define("DS", "/");

// Class Directory Saperator
define("CDS", "_");

define("SEXT", ".php");

// Application root
define("APPRAIN_ROOT", App::getBaseDir() . DS);

// Define cache path development
define("CACHE", APPRAIN_ROOT . "development/cache");
define("BYTE_STREAM", APPRAIN_ROOT . "development/cache/byte-stream");
define("BACKUP", APPRAIN_ROOT . "development/cache/backup");
define("SOURCECODEBACKUP", BACKUP . "/sourcecode");
define("DATA", APPRAIN_ROOT . "development/cache/data");
define("TEMP", APPRAIN_ROOT . "development/cache/temporary");
define("VIEW_PATH", APPRAIN_ROOT . "development/view");

define("CONTROLLER_PATH", APPRAIN_ROOT . "development/controllers");

// Model Path
define("MODEL_CACHE_PATH", APPRAIN_ROOT . "development/cache/temporary/model");
define("MODEL_PATH", APPRAIN_ROOT . "development/models");
define("MODULE_PATH", APPRAIN_ROOT . "apprain/base/modules");


// Information Set
define("INFORMATIONSET_PATH", APPRAIN_ROOT . "development/definition/information_set");
define("INFORMATIONSET_CACHE_PATH", APPRAIN_ROOT . "development/cache/temporary/information_set");

// Category Set
define("LANGUAGE_PATH", APPRAIN_ROOT . "development/definition/language");
define("LANGUAGE_CACHE_PATH", APPRAIN_ROOT . "development/cache/temporary/language");

// Category Set
define("CATEGORYSET_PATH", APPRAIN_ROOT . "development/definition/category_set");
define("CATEGORYSET_CACHE_PATH", APPRAIN_ROOT . "development/cache/temporary/category_set");


// Interface Builder Set
define("INTERFACEBUILDER_PATH", APPRAIN_ROOT . "development/definition/interface_builder");
define("INTERFACEBUILDER_CACHE_PATH", APPRAIN_ROOT . "development/cache/temporary/interfacebuilder");

// Site setting Set
define("SITESETTINGS_PATH", APPRAIN_ROOT . "development/definition/site_settings");
define("SITESETTINGS_CACHE_PATH", APPRAIN_ROOT . "development/cache/temporary/sitesettings");

// URI Manager Set
define("URIMANAGER_PATH", APPRAIN_ROOT . "development/definition/uri_manager");
define("URIMANAGER_CACHE_PATH", APPRAIN_ROOT . "development/cache/temporary/urimanager");

// Addons
define("ADDON_PATH", APPRAIN_ROOT . "development/definition/addons");
define("ADDON_CACHE_PATH", APPRAIN_ROOT . "development/cache/temporary/addon");

// profile user config
define("PROFILEUSERCONFIG_PATH", APPRAIN_ROOT . "development/definition/profile_user_default_resources");
define("PROFILEUSERCONFIG_CACHE_PATH", APPRAIN_ROOT . "development/cache/temporary/profileuserconfig");

// URI Manager Set
define("WSDL_PATH", APPRAIN_ROOT . "development/definition/wsdl");
define("WSDL_CACHE_PATH", APPRAIN_ROOT . "development/cache/temporary/wsdl");

define("COMPONENT_PATH", APPRAIN_ROOT . "component");
define("COMPONENT_CACHE_PATH", APPRAIN_ROOT . "development/cache/temporary/component");


// Configuration file
define("CONFIG_PATH", APPRAIN_ROOT . "development/definition/system_configuration");

// Database
define("DATABASE_PATH", APPRAIN_ROOT . "development/definition");

// Plugin path
define("PLUGIN_PATH", APPRAIN_ROOT . "development/plugins");

define("REPORT_CACHE_PATH", APPRAIN_ROOT . "development/cache/data/report");

# Attach the configuration file and database information
if (!file_exists(DATABASE_PATH . DS . "database.xml") && !isset($AUTO_STRT_INSTALL_OFF)) {
    if (file_exists(APPRAIN_ROOT . "webroot/install/install.php"))
        header("location:install/install.php");
    else
        die("Run appRain installer to Start Installation Process");
}

## Load Basics
require_once(APPRAIN_ROOT . "apprain/base/abstract.php");
require_once(APPRAIN_ROOT . "apprain/base/objects.php");
require_once(APPRAIN_ROOT . "apprain/base/modules/definition.php");
require_once(APPRAIN_ROOT . "apprain/base/appmodel.php");
require_once(APPRAIN_ROOT . "apprain/base/model.php");
require_once(APPRAIN_ROOT . "apprain/base/globalfx.php");


define('DEBUG_MODE', app::__def()->sysConfig('DEBUG_MODE'));
define('TPL_EXT', '.phtml');
define('NEXT_PAGE', app::__def()->sysConfig('NEXT_PAGE'));
define('PREVIOUS_PAGE', app::__def()->sysConfig('PREVIOUS_PAGE'));
define('ERROR_BACKGROUND', app::__def()->sysConfig('ERROR_BACKGROUND'));
define('DEFAULT_BACKGROUND', app::__def()->sysConfig('DEFAULT_BACKGROUND'));
define('CATEGORY_PATH_MODE', app::__def()->sysConfig('CATEGORY_PATH_MODE'));

//if (get_magic_quotes_gpc()) 
/*{
    $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
    foreach ($process as $key=>$val) {
        foreach ($val as $k => $v) {
            unset($process[$key][$k]);
            if (is_array($v)) {
                $process[$key][stripslashes($k)] = $v;
                $process[] = &$process[$key][stripslashes($k)];
            } else {
                $process[$key][stripslashes($k)] = stripslashes($v);
            }
        }
    }
    unset($process);
}*/


spl_autoload_register(

	function ($class_name) {
		if (strstr(strtolower($class_name), "model") == 'model') {
			if (file_exists(MODEL_PATH . DS . strtolower(substr($class_name, 0, (strlen($class_name) - 5))) . ".php")) {
				if (!class_exists($class_name))
					require_once(MODEL_PATH . DS . strtolower(substr($class_name, 0, (strlen($class_name) - 5))) . ".php");
			}
			else {
				$_CE = true;
				$hookResource = App::Module('Hook')->getHookResouce('Model', 'register_model');

				if (!empty($hookResource)) {
					foreach ($hookResource as $node) {
						if (($class = $node['resource'][0]) != "" && ($method = $node['resource'][1]) != "") {
							$_rtn_resources = App::__obj($class)->$method();

							if (!empty($_rtn_resources)) {
								foreach ($_rtn_resources as $res) {
									if (strtolower("{$res['name']}Model") == strtolower($class_name)) {
										$_CE = false;
										if (!class_exists($class_name)) {
											require_once($res['model_path'] . DS . strtolower($res['name']) . ".php");
										}
									}
								}
							}
						}
					}
				}

				if ($_CE) {
					if (app::__def()->sysConfig('DEBUG_MODE') > 0) {
						try {
							throw new AppException('Trace:');
						} catch (AppException $e) {
							$__mdl = UCfirst(substr($class_name, 0, (strlen($class_name) - 5)));
							App::__transfer("/developer/exception/invalid_model?arg[]={$__mdl}&arg[]=" . strtolower($__mdl) . "&arg[]=" . App::Model('Admin')->DbPrefix());
						}
					} else {
						App::__transfer(App::__def()->sysConfig('URL_FOR_404_PAGE'));
					}
				}
			}
		} else if (strstr(strtolower($class_name), "controller") == 'controller') {
			if (
					file_exists(
							CONTROLLER_PATH . DS . strtolower(
									substr(
											$class_name, 0, (strlen($class_name) - 10)
									)
							) . ".php"
					)
			) {
				require_once(CONTROLLER_PATH . DS . strtolower(substr($class_name, 0, (strlen($class_name) - 10))) . ".php");
			} else {
				$_CE = true;
				$hookResource = App::Module('Hook')->getHookResouce('Controller', 'register_controller');
				if (!empty($hookResource)) {
					foreach ($hookResource as $node) {
						if (($class = $node['resource'][0]) != "" && ($method = $node['resource'][1]) != "") {
							$_rtn_resources = App::__obj($class)->$method();

							if (!empty($_rtn_resources)) {
								foreach ($_rtn_resources as $res) {
									if (strtolower("{$res['name']}Controller") == strtolower($class_name)) {
										$_CE = false;
										App::$__appData['controllerLoadByComponent_data'] = $res;
										require_once($res['controller_path'] . DS . strtolower($res['name']) . ".php");
									}
								}
							}
						}
					}
				}
				if ($_CE) {
					if (app::__def()->sysConfig('DEBUG_MODE') > 0) {
						try {
							throw new AppException('Trace:');
						} catch (AppException $e) {
							$__ctrl = strtolower(substr($class_name, 0, (strlen($class_name) - 10)));
							App::__transfer("/developer/exception/invalid_controller?arg[]={$__ctrl}");
						}
					} else {
						App::__transfer(App::__def()->sysConfig('URL_FOR_404_PAGE'));
					}
				}
			}
		} else if (strstr(strtolower($class_name), "appmodule") == 'appmodule') {
			include_once(MODULE_PATH . DS . strtolower(substr($class_name, 0, (strlen($class_name) - 9)) . ".php"));
		} else if (strtolower($class_name) == 'appexception') {
			include_once(MODULE_PATH . DS . strtolower("{$class_name}.php"));
		} else if (file_exists(PLUGIN_PATH . DS . strtolower($class_name . DS . "{$class_name}.php"))) {
			include(PLUGIN_PATH . DS . strtolower($class_name . DS . "{$class_name}") . ".php");
		} elseif (file_exists(APPRAIN_ROOT . strtolower(str_replace("_", DS, $class_name)) . ".php")) {
			require_once APPRAIN_ROOT . strtolower(str_replace("_", DS, $class_name)) . ".php";
		} else {
			App::__transfer("/developer/exception/class_not_defined?arg[]=" . ucfirst($class_name) . "&arg[]={$class_name}");
		}
    }

);
