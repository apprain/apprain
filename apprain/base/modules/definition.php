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
 * Class to manage cookie
 *
 */
class appRain_Base_Modules_Definition extends appRain_Base_Objects {

    public $InformationSetCache = true;
    private $InformationSetSingleToneCache = array();
    public $CategorySetCache = true;
    private $CategorySetSingleToneCache = array();
    public $InterfaceBuilderCache = true;
    private $InterfaceBuilderSingleToneCache = array();
    public $SiteSettingsCache = true;
    private $SiteSettingsSingleToneCache = array();
    public $URIManagerCache = true;
    private $URIManagerSingleToneCache = array();
    public $AddonCache = true;
    private $AddonSingleToneCache = array();
    private $SysConfigSingleToneCache = array();
    public $ComponentCache = true;
    private $ComponentSingleToneCache = array();

    const COMPONENT_DEF_FILE_MAME = 'definition.xml';

    private $DBConfigSingleToneCache = array();

    const DEFINITION = 'definition';
    const INFO_XML_FILE = 'info.xml';

    public $ext = '.xml';
    public $cache_ext = 'arbt';
    public $script_ext = '.php';
    private $cache_path = "";

    /* ==========================================================================================
      Theme List
      ========================================================================================== */

    public function getThemeInfo($name = null) {
        $definition = array();

        if (!isset($name)) {
            return null;
        }
        if (is_array($name)) {
            return null;
        }

        $defnitionpath = VIEW_PATH . DS . strtolower($name . DS . self::DEFINITION . DS . self::INFO_XML_FILE);
		
        if (!file_exists($defnitionpath)) {
            return $definition;
        }


        $dom = new DOMDocument();
        @$dom->load($defnitionpath);

        $definition = array();
        $definition['name'] = $dom->getElementsByTagName('name')->item(0)->nodeValue;
        $definition['author'] = $dom->getElementsByTagName('author')->item(0)->nodeValue;
        $definition['author_uri'] = $dom->getElementsByTagName('author_uri')->item(0)->nodeValue;
        $definition['description'] = $dom->getElementsByTagName('description')->item(0)->nodeValue;
        $definition['image'] = $dom->getElementsByTagName('image')->item(0)->nodeValue;
        $definition['callback'] = '';
        if ($dom->getElementsByTagName('callback')->item(0)) {
            $definition['callback'] = $dom->getElementsByTagName('callback')->item(0)->nodeValue;
        }

        $definition['settings'] = "";
        if ($dom->getElementsByTagName('settings')->item(0)) {
            $definition['settings'] = $dom->getElementsByTagName('settings')->item(0)->nodeValue;
        }

        if ($dom->getElementsByTagName('pagemanager_hooks')->item(0)) {
            $pagemanager_hooks = $dom->getElementsByTagName('pagemanager_hooks')->item(0)->getElementsByTagName('hook_group');
            foreach ($pagemanager_hooks as $hook_group) {
                $hook_group_name = $hook_group->getAttribute('name');
                $definition['hooks'][$hook_group_name]['title'] = $hook_group->getAttribute('title');
                foreach ($hook_group->getElementsByTagName('hook') as $hook) {
                    $definition['hooks'][$hook_group_name]['list'][$hook->getAttribute('name')] = $hook->nodeValue;
                }
            }
        }
        $definition['components'] = array();
        if ($dom->getElementsByTagName('components')->item(0)) {
            $auto = $dom->getElementsByTagName('components')->item(0)->getElementsByTagName('auto');
            $definition['components']['auto'] = Array();
            if ($auto->item(0)) {
                $install = $auto->item(0)->getElementsByTagName('install');
                $definition['components']['auto']['install'] = array();
                if ($install->item(0)) {
                    $components = $install->item(0)->getElementsByTagName('component');
                    if ($components->item(0)) {
                        foreach ($components as $component) {
                            $definition['components']['auto']['install'][] = $component->nodeValue;
                        }
                    }
                }

                $uninstall = $auto->item(0)->getElementsByTagName('uninstall');
                $definition['components']['auto']['uninstall'] = array();
                if ($uninstall->item(0)) {
                    $components = $uninstall->item(0)->getElementsByTagName('component');
                    if ($components->item(0)) {
                        foreach ($components as $component) {
                            $definition['components']['auto']['uninstall'][] = $component->nodeValue;
                        }
                    }
                }
            }
        }
        return $definition;
    }

    /* ==========================================================================================
      Component List
      =========================================================================================== */

    public function getComponentList($soption = NULL) {
        if (empty($this->ComponentSingleToneCache)) {
            $this->ComponentSingleToneCache = $this->parseComponentList();
        }
        return isset($soption) ? $this->ComponentSingleToneCache[$soption] : $this->ComponentSingleToneCache;
    }

    public function validateComponent($component) {
        $path = COMPONENT_PATH . DS . $component['name'] . DS . self::COMPONENT_DEF_FILE_MAME;
        if (file_exists($path)) {
            return $path;
        } else {
            return false;
        }
    }

    public function parseComponentList() {
        $list = App::Load('Helper/Utility')->getDirLising(COMPONENT_PATH);
        if (empty($list['dir'])) {
            return array();
        }

        $definitionlist = array();
        foreach ($list['dir'] as $component) {
            if ($defnitionpath = $this->validateComponent($component)) {
                $dom = new DOMDocument();
                $dom->load($defnitionpath);
                $definition = array();
                $definition['error'] = array();
                $definition['name'] = UCFirst($dom->getElementsByTagName('name')->item(0)->nodeValue);
                $definition['namespace'] = $dom->getElementsByTagName('namespace')->item(0)->nodeValue;

                $definition['removeable'] = 'Yes';
                if ($dom->getElementsByTagName('removeable')->item(0)) {
                    $definition['removeable'] = $dom->getElementsByTagName('removeable')->item(0)->nodeValue;
                }

                $definition['namespace'] = ($definition['namespace'] == 'auto') ? $component['name'] : $definition['namespace'];
                $definition['help'] = $dom->getElementsByTagName('help')->item(0)->nodeValue;

                if (trim($definition['help']) == "") {
                    $definition['error'][] = $this->__("No help added for the component");
                }

                $definition['version'] = $dom->getElementsByTagName('version')->item(0)->nodeValue;
                $definition['uri'] = $dom->getElementsByTagName('uri')->item(0)->nodeValue;
                $definition['description'] = $dom->getElementsByTagName('description')->item(0)->nodeValue;
                $definition['author'] = $dom->getElementsByTagName('author')->item(0)->nodeValue;
                $definition['author_uri'] = $dom->getElementsByTagName('author_uri')->item(0)->nodeValue;
                $definition['checkfiles']['filepath'] = array();
                $definition['mypath'] = COMPONENT_PATH . DS . $component['name'];

                $path = $definition['mypath'] . DS . appRain_Base_component::BOOT_FILE . $this->script_ext;

                if (!file_exists($path)) {
                    $definition['error'][] = "Your first boot file is not define. Expecting a file  {$path}";
                }

                $checkfiles = $dom->getElementsByTagName('checkfiles')->item(0);
                if ($checkfiles) {
                    $list = $checkfiles->getElementsByTagName('filepath');
                    if ($list) {
                        foreach ($list as $val) {
                            $filepath = $definition['mypath'] . DS . $val->nodeValue;

                            if (!file_exists($filepath)) {
                                $definition['error'][] = "File does not exists : {$filepath}";
                            } else {
                                $definition['checkfiles']['filepath'] = $filepath;
                            }
                        }
                    }
                }

                if (empty($definition['error'])) {
                    $definition['base_class_name'] = ucfirst($component['name']) . CDS . ucfirst($definition['namespace']);

                    App::Component($component['name'])->__data = $definition;
                    $definition['status'] = App::Component($component['name'])->Status();

                    if (appRain_Base_component::STATUS_ACTIVE === $definition['status']) {
                        App::Component($component['name'])->init();
                    }
                } else {
                    $definition['status'] = appRain_Base_component::STATUS_INACTIVE;
                }

                $definitionlist[$definition['namespace']] = $definition;
            }
        }
        return $definitionlist;
    }

    /*     * *** **** */

    public function registerThemeInfo() {
        $themleInfo = App::__Def()->getThemeInfo(App::Helper('Config')->siteInfo('theme'));

        if (isset($themleInfo['settings']) && $themleInfo['settings'] != "") {

            App::Module('Hook')->setHookName('InterfaceBuilder')
                    ->setAction("update_definition")
                    ->Register(get_class($this), "interfacebuilder_update_for_theme", $themleInfo);

            if ($themleInfo['settings'] != "") {
                App::Module('Hook')
                        ->setHookName('Sitesettings')
                        ->setAction("register_definition")
                        ->Register(get_class($this), "register_sitesettings_for_theme_defination");
            }
        }
    }

    public function interfacebuilder_update_for_theme($send, $themleInfo) {
        $themeName = App::Helper('Config')->siteInfo('theme', 0);
        if ($themeName) {
            $themleInfo = App::__Def()->getThemeInfo($themeName);
            if ($themleInfo['settings'] != "") {
                $send['developer']['child'][2]['items'][] = array(
                    "title" => "Settings",
                    "link" => "/admin/config/" . App::Helper('Utility')->getName($themleInfo['settings'])
                );
            }
        }
        return $send;
    }

    public function register_sitesettings_for_theme_defination() {
        $themeName = App::Helper('Config')->siteInfo('theme', 0);
        $srcpaths = Array();
        if ($themeName) {
            $themleInfo = App::__Def()->getThemeInfo($themeName);
            $srcpaths[] = VIEW_PATH . DS . App::Helper('Config')->siteInfo('theme') . DS . "definition/{$themleInfo['settings']}";
        }
        return array('filepaths' => $srcpaths);
    }

    /* ==========================================================================================
      Read Help
      =========================================================================================== */

    public function HelpList($HelpId = null) {

        $List = array();

        $file_path = DATA . DS . 'apphelp.xml';

        $dom = new DOMDocument();
        $dom->load($file_path);

        $Base = $dom->getElementsByTagName('base');
        $List['base'] = array(
            'date' => $Base->item(0)->getElementsByTagName('date')->item(0)->nodeValue,
            'version' => $Base->item(0)->getElementsByTagName('version')->item(0)->nodeValue
        );

        $Records = $dom->getElementsByTagName('record');

        if ($Records->item(0)) {
            foreach ($Records as $Record) {
                $id = $Record->getElementsByTagName('id')->item(0)->nodeValue;
                $List['records'][$id] = array(
                    'id' => $Record->getElementsByTagName('id')->item(0)->nodeValue,
                    'title' => $Record->getElementsByTagName('title')->item(0)->nodeValue,
                    'shortdesc' => $Record->getElementsByTagName('shortdesc')->item(0)->nodeValue,
                    'description' => $Record->getElementsByTagName('description')->item(0)->nodeValue
                );
            }
        }
        if (isset($HelpId)) {
            return isset($List['records'][$HelpId]) ? $List['records'][$HelpId] : '';
        }

        return $List;
    }

    /* ==========================================================================================
      Online Component List
      =========================================================================================== */

    public function onlinecomponentList($src_key = null) {

        $this->cache_path = BYTE_STREAM;
        $List = array();
        if (!$this->cache_exists("componentonline")) {
            $file_path = app::__def()->sysConfig('ONLINE_COMPONENT_REPO_URI');
            $dom = new DOMDocument();
            $dom->load($file_path);

            $Components = $dom->getElementsByTagName('Component');
            if ($Components->item(0)) {
                foreach ($Components as $Component) {
                    $List[] = array(
                        'Id' => $Component->getElementsByTagName('Id')->item(0)->nodeValue,
                        'version' => $Component->getElementsByTagName('Version')->item(0)->nodeValue,
                        'title' => $Component->getElementsByTagName('Title')->item(0)->nodeValue,
                        'description' => $Component->getElementsByTagName('Description')->item(0)->nodeValue,
                        'categoryid' => $Component->getElementsByTagName('CategoryId')->item(0)->nodeValue,
                        'categoryname' => $Component->getElementsByTagName('CategoryName')->item(0)->nodeValue,
                        'thumuri' => $Component->getElementsByTagName('ThumURI')->item(0)->nodeValue,
                        'parmauri' => $Component->getElementsByTagName('ParmaURI')->item(0)->nodeValue,
                        'relatedcomponents' => $Component->getElementsByTagName('RelatedComponents')->item(0)->nodeValue,
                        'downloaduri' => $Component->getElementsByTagName('DownloadURI')->item(0)->nodeValue,
                        'info' => $Component->getElementsByTagName('Info')->item(0)->nodeValue,
                        'warning' => $Component->getElementsByTagName('Warning')->item(0)->nodeValue
                    );
                }
            }
            $this->do_cache($List, 'componentonline');
        } else {
            $List = $this->read_cache("componentonline");
            if ($src_key != '') {
                foreach ($List as $key => $row) {
                    if (!strstr($row['title'], $src_key) && !strstr($row['description'], $src_key)) {
                        unset($List[$key]);
                    } else {
                        $List[$key]['title'] = str_replace($src_key, "<span class=\"searchtext\">{$src_key}</span>", $List[$key]['title']);
                        $List[$key]['description'] = str_replace($src_key, "<span  class=\"searchtext\">{$src_key}</span>", $List[$key]['description']);
                    }
                }
            }
        }
        if ($src_key != '') {
            return App::Helper('Utility')->ArrayPaginator($List, array('h_link' => "?src_key={$src_key}"));
        } else {
            return App::Helper('Utility')->ArrayPaginator($List);
        }
    }

    /* ==========================================================================================
      sysConfig
      =========================================================================================== */

    public function sysConfig($soption = NULL) {
        if (empty($this->SysConfigSingleToneCache)) {
            $this->SysConfigSingleToneCache = $this->parsesysConfigDefinition();
        }
        return isset($soption) ? $this->SysConfigSingleToneCache[$soption] : $this->SysConfigSingleToneCache;
    }

    private function parsesysConfigDefinition() {
        $file_path = CONFIG_PATH . DS . "config" . $this->ext;

        //Halt if information set is not exists
        if (!file_exists($file_path)) {
            pre("Configuration file missing  <br /> #Path: {$file_path}");
        }

        $definition = array();
        $dom = new DOMDocument();
        $dom->load($file_path);

        $base = $dom->getElementsByTagName('Configuration')
                ->item(0)
                ->getElementsByTagName('base')
                ->item(0);

        $definition['APPRAINVERSION'] = $base->getElementsByTagName('appRainversion')
                        ->item(0)
                ->nodeValue;

        $definition['APPRAINLICENSEKEY'] = $base->getElementsByTagName('appRainLicenseKey')
                        ->item(0)
                ->nodeValue;

        $options = $dom->getElementsByTagName('Configuration')
                ->item(0)
                ->getElementsByTagName('options')
                ->item(0)
                ->getElementsByTagName('option');

        foreach ($options as $val) {
            $nodevalue = ($val->getElementsByTagName('flag')->item(0)->nodeValue == 0) ? $val->getElementsByTagName('value')->item(0)->nodeValue : $val->getElementsByTagName('default')->item(0)->nodeValue;

            switch (strtolower($val->getAttribute('type'))) {
                case "string" :
                    $definition[$val->getAttribute('name')] = "{$nodevalue}";
                    break;
                case "boolean" :
                    $definition[$val->getAttribute('name')] = (strtolower($nodevalue) == 'yes') ? true : false;
                    break;
                default :
                    $definition[$val->getAttribute('name')] = $nodevalue;
            }
        }
        return $definition;
    }

    /* ==========================================================================================
      Database config
      =========================================================================================== */

    public function getDBConfig($key = NULL, $cName = appRain_Base_Abstract::PRIMARY) {
        if (!isset($this->DBConfigSingleToneCache[$cName])) {

            $dom = new DOMDocument();
            $dom->load(DATABASE_PATH . DS . 'database' . $this->ext);

            $connections = $dom->getElementsByTagName('connections')->item(0)->getElementsByTagName('connection');

            foreach ($connections as $conn) {
                if ($conn->getElementsByTagName('active')->item(0)->nodeValue == 1 &&
                        strtolower($conn->getElementsByTagName('cname')->item(0)->nodeValue) == strtolower($cName)
                ) {
                    $dataConf = array(
                        'cname' => $conn->getElementsByTagName('cname')->item(0)->nodeValue,
                        'driver' => $conn->getElementsByTagName('driver')->item(0)->nodeValue,
                        'port' => $conn->getElementsByTagName('port')->item(0)->nodeValue,
                        'type' => $conn->getElementsByTagName('type')->item(0)->nodeValue,
                        'charset' => $conn->getElementsByTagName('charset')->item(0)->nodeValue,
                        'prefix' => $conn->getElementsByTagName('prefix')->item(0)->nodeValue,
                        'host' => $conn->getElementsByTagName('host')->item(0)->nodeValue,
                        'dbname' => $conn->getElementsByTagName('dbname')->item(0)->nodeValue,
                        'username' => $conn->getElementsByTagName('username')->item(0)->nodeValue,
                        'password' => $conn->getElementsByTagName('password')->item(0)->nodeValue
                    );
                    $this->DBConfigSingleToneCache[$cName] = $dataConf;
                }
            }
        }

        if (!isset($this->DBConfigSingleToneCache[$cName])) {
			$url = str_replace(".ca",".com",$_SERVER['HTTP_HOST']);
			pre('Your new server <a href="http://' . $url . '">' . $url . '</a>');
            pre("System looking for database profile '{$cName}' but not found, Please reffer to database.xml");
        }

        return isset($this->DBConfigSingleToneCache[$cName][$key]) ? $this->DBConfigSingleToneCache[$cName][$key] : $this->DBConfigSingleToneCache[$cName];
    }

    /* ==========================================================================================
      Addons
      =========================================================================================== */

    public function getAddons() {
        if (empty($this->AddonSingleToneCache)) {
            $this->cache_path = ADDON_CACHE_PATH;

            // Read Cache
            $definition = ($this->cache_exists("addons")) ? $this->read_cache("addons") : $this->parseAddons();

            // Set Single tone cache
            $this->AddonSingleToneCache = $definition;

            // Create Physical cache
            if (app::__def()->sysConfig('ADDON_CACHE')) {
                if (!$this->cache_exists("addons")) {
                    $this->do_cache($definition, "addons");
                }
            }
        }

        // Return defination
        return $this->AddonSingleToneCache;
    }

    public function readAddonPath() {
        $file_path = ADDON_PATH;

        if (!file_exists($file_path)) {
            pre("Addons defination file missing  <br /> #Path: {$file_path}");
        }

        $definition = array();
        $list = App::Load('Helper/Utility')->getDirLising($file_path);

        $pathList = Array();
        foreach ($list['file'] as $def) {
            if (strstr($def['name'], $this->ext) && $def['name'] != "addons{$this->ext}") {
                $pathList[] = $file_path . DS . $def['name'];
            } else {
                $pathList2[] = $file_path . DS . $def['name'];
            }
        }
        $pathList = array_merge($pathList2, $pathList);

        $hookResource = App::Module('Hook')->getHookResouce('Addon', 'register_addon');
        if (!empty($hookResource)) {
            foreach ($hookResource as $node) {
                if (($class = $node['resource'][0]) != "" && ($method = $node['resource'][1]) != "") {
                    $defs = App::__obj($class)->$method($definition);
                    foreach ($defs as $def) {
                        $pathList[] = $def['path'];
                    }
                }
            }
        }

        return $pathList;
    }

    private function parseAddons() {
        $addonpaths = $this->readAddonPath();
        $definition = array();
        $hdef = array();
        if (!empty($addonpaths)) {
            foreach ($addonpaths as $path) {
                if (file_exists($path)) {
                    $hdef = $this->readaddonsfromhook($path);
                    $definition = array_merge($definition, $hdef);
                }
            }
        }

        return $definition;
    }

    public function readaddonsfromhook($file_path) {
        $dom = new DOMDocument();
        $dom->load($file_path);

        $addons = $dom->getElementsByTagName('Addons')->item(0)->getElementsByTagName('addon');

        foreach ($addons as $addon) {
            $status = $addon->getElementsByTagName('status')->item(0)->nodeValue;
            //if ($status == 'Active') {
            $name = $addon->getAttribute('name');
            $definition[$name]['version'] = ($addon->getAttribute('version')) ? $addon->getAttribute('version') : '0.1.0';
            $definition[$name]['title'] = $addon->getElementsByTagName('title')->item(0)->nodeValue;
            $definition[$name]['code'] = $addon->getElementsByTagName('code')->item(0)->nodeValue;
            $definition[$name]['load'] = $addon->getElementsByTagName('load')->item(0)->nodeValue;
            $definition[$name]['layouts'] = $addon->getElementsByTagName('layouts')->item(0)->nodeValue;
            $definition[$name]['layouts_except'] = $addon->getElementsByTagName('layouts_except')->item(0)->nodeValue;
            $definition[$name]['status'] = $status;

            $definition[$name]['author_name'] = "";
            if ($addon->getElementsByTagName('author_name')->item(0)) {
                $definition[$name]['author_name'] = $addon->getElementsByTagName('author_name')->item(0)->nodeValue;
            }

            $definition[$name]['author_uri'] = "";
            if ($addon->getElementsByTagName('author_uri')->item(0)) {
                $definition[$name]['author_uri'] = $addon->getElementsByTagName('author_uri')->item(0)->nodeValue;
            }

            $definition[$name]['addon_uri'] = "";
            if ($addon->getElementsByTagName('addon_uri')->item(0)) {
                $definition[$name]['addon_uri'] = $addon->getElementsByTagName('addon_uri')->item(0)->nodeValue;
            }

            $definition[$name]['description'] = "";
            if ($addon->getElementsByTagName('description')->item(0)) {
                $definition[$name]['description'] = $addon->getElementsByTagName('description')->item(0)->nodeValue;
            }

            $js_srcs = $addon->getElementsByTagName('javascripts')->item(0)->getElementsByTagName('src');
            $definition[$name]['javascripts'] = array();
            foreach ($js_srcs as $js_src) {
                $definition[$name]['javascripts'][] = $js_src->nodeValue;
            }

            $style_sheets = $addon->getElementsByTagName('style_sheets')->item(0)->getElementsByTagName('link');
            $definition[$name]['style_sheets'] = array();
            foreach ($style_sheets as $style_sheet) {
                $definition[$name]['style_sheets'][] = $style_sheet->nodeValue;
            }
            // }
        }

        return $definition;
    }

   
    /* ==========================================================================================
      URI Manager
      =========================================================================================== */

    public $to_clean = array();

    public function getURIManagerDefinition() {
        if (empty($this->URIManagerSingleToneCache)) {
            $this->cache_path = URIMANAGER_CACHE_PATH;

            // Read Cache
            $definition = ($this->cache_exists("urimanager")) ? $this->read_cache("urimanager") : $this->parseURIManagerDefinition();

            // Set Single tone cache
            $this->URIManagerSingleToneCache = $definition;

            // Create Physical cache
            if (app::__def()->sysConfig('URI_MANAGER_CACHE')) {
                $definition['bootrouter']['type'] = isset($definition['bootrouter']['type']) ? $definition['bootrouter']['type'] : "Fixed";

                if (strtolower($definition['bootrouter']['type']) != 'auto') {
                    if (!$this->cache_exists("urimanager")) {
                        $this->do_cache($definition, "urimanager");
                    }
                }
            }
        }

        // RUN Callbacks
        $DynamicallyChnagedDefiniton = App::__obj('Development_Callbacks')->_on_uri_definition_init($this->URIManagerSingleToneCache);
		
        if (is_array($DynamicallyChnagedDefiniton) && !empty($DynamicallyChnagedDefiniton)){
            $this->URIManagerSingleToneCache = $DynamicallyChnagedDefiniton;
		}

        $hookResource = App::Module('Hook')->getHookResouce('URIManager', 'on_initialize');
		$list = array();
        if (!empty($hookResource)) {
			foreach ($hookResource as $nodkey=>$node) {
				if(!isset($node['resource'][0]) || !isset($node['resource'][1])){
					continue;
				}				
				$class = $node['resource'][0];
				$method = $node['resource'][1];
				$key = $class . $method;
				if(!isset($this->to_clean[$key])){
					$this->to_clean[$key] = time();
					$r2 = isset($node['resource'][2]) ? $node['resource'][2] : null;
					$DynamicallyChnagedDefiniton = App::__obj($class)->$method($this->URIManagerSingleToneCache, $r2);
					if (is_array($DynamicallyChnagedDefiniton) && !empty($DynamicallyChnagedDefiniton)) {
						$this->URIManagerSingleToneCache = $DynamicallyChnagedDefiniton;
					}				
				}
			}
        }
        return $this->URIManagerSingleToneCache;
    }

    private function parseURIManagerDefinition() {
        $file_path = URIMANAGER_PATH;

        if (!file_exists($file_path)) {
            pre("URI Manager missing  <br /> #Path: {$file_path}");
        }

        $definition = array();
        $dom = new DOMDocument();
        $dom->load($file_path . DS . "boot_router" . $this->ext);

        $bootrouter = $dom->getElementsByTagName('bootrouters')
                ->item(0)
                ->getElementsByTagName('bootrouter');


		$DOMAIN = App::Helper('Config')->getServerInfo('HTTP_HOST');

        foreach ($bootrouter as $val) {
            $theme = (strtolower($val->getElementsByTagName('theme')->item(0)->nodeValue) == 'auto') ? "" : $val->getElementsByTagName('theme')->item(0)->nodeValue;

            if (strtolower($val->getElementsByTagName('type')->item(0)->nodeValue) == 'fixed') {
                $definition['bootrouter'] = Array(
                    'type' => $val->getElementsByTagName('type')->item(0)->nodeValue,
                    'domain' => $val->getElementsByTagName('domain')->item(0)->nodeValue,
                    'theme' => $theme,
                    'controller' => $val->getElementsByTagName('controller')->item(0)->nodeValue,
                    'action' => $val->getElementsByTagName('action')->item(0)->nodeValue,
                    'connection' => $val->getElementsByTagName('connection')->item(0)->nodeValue
                );
            } else if ((str_replace('www.', '', $DOMAIN) . App::getBaseUrl()) == str_replace('www.', '', $val->getElementsByTagName('domain')->item(0)->nodeValue)) {
                $definition['bootrouter'] = Array(
                    'type' => $val->getElementsByTagName('type')->item(0)->nodeValue,
                    'domain' => $val->getElementsByTagName('domain')->item(0)->nodeValue,
                    'theme' => $theme,
                    'controller' => $val->getElementsByTagName('controller')->item(0)->nodeValue,
                    'action' => $val->getElementsByTagName('action')->item(0)->nodeValue,
                    'connection' => $val->getElementsByTagName('connection')->item(0)->nodeValue
                );
                break;
            }
        }

        if (!isset($definition['bootrouter'])) {
            pre("Boot Router is not define.<br />Check URI Manager : {$file_path}");
        }

        $dom = new DOMDocument();
        $dom->load($file_path . DS . "global_router" . $this->ext);

        $globalrouter = $dom->getElementsByTagName('globalrouter')->item(0);
        $definition['globalrouter']['controller'] = $globalrouter->getElementsByTagName('controller')->item(0)->nodeValue;
        $definition['globalrouter']['action'] = $globalrouter->getElementsByTagName('action')->item(0)->nodeValue;

        # Page Router
        $dom = new DOMDocument();
        $dom->load($file_path . DS . "page_router" . $this->ext);

        $roles = $dom->getElementsByTagName('pagerouter')->item(0)->getElementsByTagName('role');
        foreach ($roles as $role) {
            if ($role->getElementsByTagName('actual')->item(0) && $role->getElementsByTagName('virtual')->item(0)) {
                $definition['pagerouter'][] = array
                    (
                    "actual" => explode("/", $role->getElementsByTagName('actual')->item(0)->nodeValue),
                    "virtual" => array($role->getElementsByTagName('virtual')->item(0)->nodeValue)
                );
            }
        }

        return $definition;
    }

    /* ==========================================================================================
      SITE SETTING
      ============================================================================================ */

    public function getSiteSettingsDefinition() {
        if (empty($this->SiteSettingsSingleToneCache)) {
            $this->cache_path = SITESETTINGS_CACHE_PATH;

            // Read Cache
            $definition = ($this->cache_exists("sitesettings")) ? $this->read_cache("sitesettings") : $this->parseSiteSettingsDefinition();

            // Set Single tone cache
            $this->SiteSettingsSingleToneCache = $definition;

            // Create Physical cache
            if (app::__def()->sysConfig('SITE_SETTINGS_CACHE')) {
                if (!$this->cache_exists("sitesettings")) {
                    $this->do_cache($definition, "sitesettings");
                }
            }
        }

        return $this->parseSiteSettingsDefinition();
    }

    private function parseSiteSettingsDefinition() {
        $file_path = SITESETTINGS_PATH;

        //Halt if information set is not exists
        if (!file_exists($file_path)) {
            pre("Site Settings missing  <br /> #Path: {$file_path} <br /> #Tipe: Do not forget to set \"admin_tab\"");
        }

        $definition = Array();

        $list = App::Load('Helper/Utility')->getDirLising($file_path);

        $definition = Array();

        foreach ($list['file'] as $def) {
            if (strstr($def['name'], $this->ext)) {
                $def = $this->parseSiteSettingByFile($file_path . DS . $def['name']);
                $definition = array_merge($definition, $def);
            }
        }

        // Generate by hook
        $hookResource = App::Module('Hook')->getHookResouce('Sitesettings', 'register_definition');

        if (!empty($hookResource)) {
            foreach ($hookResource as $node) {
                if (($class = $node['resource'][0]) != "" && ($method = $node['resource'][1]) != "") {
                    $_rtn_resources = App::__obj($class)->$method();

                    if (!empty($_rtn_resources)) {
                        foreach ($_rtn_resources['filepaths'] as $filepath) {
							
                            $def = $this->parseSiteSettingByFile($filepath);

							foreach($def as $key=>$defrow){

								if (isset($definition[$key])) {
									$definition[$key]['groups'] = array_merge($definition[$key]['groups'], $defrow['groups']);
								} else{
									$definition[$key] = $defrow;
								}
								
							}
                        }
                    }
                }
            }
        }

        return $definition;
    }

    private function parseSiteSettingByFile($file_path) {
        $dom = new DOMDocument();

        $dom->load($file_path);

        $sections = $dom->getElementsByTagName('sections');
        $definition = Array();
        foreach ($sections as $sectionkey => $section) {
            $section_title = $section->getElementsByTagName('base')
                            ->item(0)
                            ->getElementsByTagName('title')
                            ->item(0)
                    ->nodeValue;

            $section_name = $section->getElementsByTagName('base')
                    ->item(0)
                    ->getAttribute('name');

            $admin_tab = $section->getElementsByTagName('base')
                            ->item(0)
                            ->getElementsByTagName('admin_tab')
                            ->item(0)
                    ->nodeValue;

            $groups = $section->getElementsByTagName('groups')->item(0)->getElementsByTagName('group');

            foreach ($groups as $group) {
                $gt = array();
                $group_base = $group->getElementsByTagName('base')->item(0);
                $gt['name'] = $group_base->getAttribute('name');
                $gt['title'] = $group_base->getElementsByTagName('title')->item(0)->nodeValue;

                // ACL
                $acl = $group_base->getElementsByTagName('acl')
                        ->item(0)
                        ->getElementsByTagName('ugroup');

                foreach ($acl as $ugroup) {
                    $gt['acl'][] = $ugroup->nodeValue;
                }

                $group_selections = $group->getElementsByTagName('selections')
                        ->item(0)
                        ->getElementsByTagName('selection');

                foreach ($group_selections as $selection) {
                    $name = $selection->getElementsByTagName('name')->item(0);
                    $gt['selection'][$name->nodeValue]['title'] = $selection->getElementsByTagName('title')->item(0)->nodeValue;
                    $gt['selection'][$name->nodeValue]['type'] = $selection->getElementsByTagName('type')->item(0)->nodeValue;
                    $gt['selection'][$name->nodeValue]['default'] = $selection->getElementsByTagName('default')->item(0)->nodeValue;
                    $gt['selection'][$name->nodeValue]['hints'] = "";
                    if ($selection->getElementsByTagName('hints')->item(0)) {
                        $gt['selection'][$name->nodeValue]['hints'] = $selection->getElementsByTagName('hints')->item(0)->nodeValue;
                    }

                    $options = $selection->getElementsByTagName('options')->item(0);
                    $opts = array();
                    if ($options) {
                        foreach ($options->getElementsByTagName('option') as $option) {
                            $opts[$option->getAttribute('value')] = $option->nodeValue;
                        }
                        $gt['selection'][$name->nodeValue]['options'] = $opts;
                    }
                }

                $definition[$section_name]['base']['title'] = $section_title;
                $definition[$section_name]['base']['admin_tab'] = $admin_tab;
                $definition[$section_name]['base']['name'] = $gt['name'];
                $definition[$section_name]['groups'][$gt['name']] = $gt;
            }
        }

        return $definition;
    }

    /* ==========================================================================================
      WSDL Type
      ============================================================================================ */

    public function WSDLType() {
        return $this->parseWSDLType();
    }

    private function parseWSDLType() {
        $file_path = WSDL_PATH;

        if (!file_exists($file_path)) {
            pre("WSDL Directory missing  <br /> #Path: {$file_path}");
        }

        $list = App::Load('Helper/Utility')->getDirLising($file_path);

        $defDom = new DOMDocument();
        $types = $defDom->createElement('types');
        $types = $defDom->appendChild($types);

        $schema = $defDom->createElement('schema');
        $schema = $types->appendChild($schema);

        /* $import = $defDom->createElement ('import');
          $import = $schema->appendChild ($import);
          $import->setAttribute("namespace","http://schemas.xmlsoap.org/soap/encoding/");
          $import->setAttribute("schemaLocation","http://schemas.xmlsoap.org/soap/encoding/"); */

        foreach ($list['file'] as $defkey => $def) {
            if (strstr($def['name'], $this->ext)) {
                $dom = new DOMDocument();
                $dom->load($file_path . DS . $def['name']);

                $types = $dom->getElementsByTagName('complexType');
                foreach ($types as $type) {
                    $domType = $defDom->importNode($type, true);
                    $schema->appendChild($domType);
                }
            }
        }

        // Clear data
        unset($schema);
        unset($dom);

        return ($defDom->getElementsByTagName('types')->item(0));
    }

    /* ==========================================================================================
      INTERFACE BUILDER
      ============================================================================================ */

    public function getInterfaceBuilderDefinition() {
        if (empty($this->InterfaceBuilderSingleToneCache)) {
            $this->cache_path = INTERFACEBUILDER_CACHE_PATH;

            // Read Cache
            $definition = ($this->cache_exists("interfacebuilder")) ? $this->read_cache("interfacebuilder") : $this->parseInterfaceBuilderDefinition();

            // Set Single tone cache
            $this->InterfaceBuilderSingleToneCache = $definition;

            // Create Physical cache
            if (app::__def()->sysConfig('INTERFACE_BUILDER_CACHE')) {
                if (!$this->cache_exists("interfacebuilder")) {
                    $this->do_cache($definition, "interfacebuilder");
                }
            }
        }

        // Return defination
        return $this->InterfaceBuilderSingleToneCache;
    }

    private function parseInterfaceBuilderDefinition() {
        $file_path = INTERFACEBUILDER_PATH;

        //Halt if information set is not exists
        if (!file_exists($file_path)) {
            pre("Interfacebuilder missing  <br /> #Path: {$file_path} <br /> #Tipe: Do not forget to set \"admin_tab\"");
        }

        $list = App::Load('Helper/Utility')->getDirLising($file_path);
        $interfacebuilder_def = Array();

        // General from defintion inside
        foreach ($list['file'] as $def) {
            if (strstr($def['name'], $this->ext)) {
                $definition = $this->parseEachInterfaceBuilderDefintionFile($file_path . DS . $def['name']);
                $interfacebuilder_def = array_merge($interfacebuilder_def, $definition);
            }
        }

        $hookResource = App::Module('Hook')->getHookResouce('InterfaceBuilder', 'register_definition');
        if (!empty($hookResource)) {
            foreach ($hookResource as $node) {
                if (($class = $node['resource'][0]) != "" && ($method = $node['resource'][1]) != "") {
                    $_rtn_resources = App::__obj($class)->$method();

                    if (!empty($_rtn_resources)) {
                        foreach ($_rtn_resources['filepaths'] as $filepath) {
                            $definition = $this->parseEachInterfaceBuilderDefintionFile($filepath);
                            $interfacebuilder_def = array_merge($interfacebuilder_def, $definition);
                        }
                    }
                }
            }
        }

        $hookResource = App::Module('Hook')->getHookResouce('InterfaceBuilder', 'update_definition');
        if (!empty($hookResource)) {
            foreach ($hookResource as $node) {
                if (($class = $node['resource'][0]) != "" && ($method = $node['resource'][1]) != "") {
                    $_rtn_resources = App::__obj($class)->$method($interfacebuilder_def, null);
                    if (isset($_rtn_resources) && is_array($_rtn_resources) && !empty($_rtn_resources)) {
                        $interfacebuilder_def = $_rtn_resources;
                    }
                }
            }
        }
        return $this->sort_menu($interfacebuilder_def);
    }

    private function sort_menu($definition) {
        try {
            foreach ($definition as &$ma) {
                $tmp[] = &$ma['parent']["sort_order"];
            }

            array_multisort($tmp, $definition);

            return $definition;
        } catch (AppException $err) {
            return $definition;
        }
    }

    private function parseEachInterfaceBuilderDefintionFile($file_path) {
        if (!file_exists($file_path))
            return Array();

        $definition = Array();
        $dom = new DOMDocument();
        $dom->load($file_path);

        /* Parse Category set defination */
        $navigations = $dom->getElementsByTagName('navigation');
        foreach ($navigations as $navigation) {
            // Parse Parent
            $parent = $navigation->getElementsByTagName('parent')->item(0);
            $nav_name = $navigation->getAttribute('name');
            $definition[$nav_name]['parent']['title'] = $parent->getElementsByTagName('title')->item(0)->nodeValue;
            $definition[$nav_name]['parent']['action'] = $parent->getElementsByTagName('action')->item(0)->nodeValue;
            $definition[$nav_name]['parent']['sort_order'] = $parent->getElementsByTagName('sort_order')->item(0)->nodeValue;
            $definition[$nav_name]['parent']['icon'] = '';
            if ($parent->getElementsByTagName('icon')->item(0)) {
                $definition[$nav_name]['parent']['icon'] = $parent->getElementsByTagName('icon')->item(0)->nodeValue;
            }
            $definition[$nav_name]['parent']['submenu'] = array();
            if ($parent->getElementsByTagName('submenu')->item(0)) {
                $items = $parent->getElementsByTagName('submenu')->item(0)->getElementsByTagName('item');
                foreach ($items as $key => $item) {
                    $definition[$nav_name]['parent']['submenu'][] = array(
                        "title" => $item->getElementsByTagName('title')->item(0)->nodeValue,
                        "link" => $item->getElementsByTagName('link')->item(0)->nodeValue
                    );
                    if ($item->getAttribute('type') == 'multiple') {
                        $childitem = $item->getElementsByTagName('childitem');
                        foreach ($childitem as $ckey => $citem) {
                            $definition[$nav_name]['parent']['submenu'][$key]['child'][] = array(
                                "title" => $citem->getElementsByTagName('title')->item(0)->nodeValue,
                                "link" => $citem->getElementsByTagName('link')->item(0)->nodeValue
                            );
                        }
                    }
                }
            }

            $acl_groups = $parent->getElementsByTagName('acl')->item(0)->getElementsByTagName('group');
            foreach ($acl_groups as $acl_group) {
                $definition[$nav_name]['parent']['acl'][] = $acl_group->nodeValue;
            }

            // Parse Child
            $children = $navigation->getElementsByTagName('child');
            foreach ($children as $child) {
                $menu_arr = array();
                $menus = $child->getElementsByTagName('menu');
                foreach ($menus as $menu) {
                    $items = $menu->getElementsByTagName('items')->item(0)->getElementsByTagName('item');
                    $menu_items = array();
                    foreach ($items as $item) {
                        $menu_items[] = array(
                            'title' => $item->getElementsByTagName('title')->item(0)->nodeValue,
                            'link' => $item->getElementsByTagName('link')->item(0)->nodeValue
                        );
                    }

                    $adminicon = array();
                    if ($child->getElementsByTagName('adminicon')->item(0)) {
						if ($menu->getElementsByTagName('adminicon')->item(0)->getElementsByTagName('type')->item(0)) {
							$adminicon['type'] = $menu->getElementsByTagName('adminicon')->item(0)->getElementsByTagName('type')->item(0)->nodeValue;
						}
						if($menu->getElementsByTagName('adminicon')->item(0)->getElementsByTagName('type')->item(0))
						{
							$adminicon['location'] = $menu->getElementsByTagName('adminicon')->item(0)->getElementsByTagName('location')->item(0)->nodeValue;
						}
                    }
                    $menu_arr[] = array('title' => $menu->getElementsByTagName('title')->item(0)->nodeValue, "items" => $menu_items, 'adminicon' => $adminicon);
                }
                $definition[$nav_name]["child"] = $menu_arr;
            }
        }

        return $definition;
    }

    /* ==========================================================================================
      CATAGORY SET
      ============================================================================================ */

    public function getCategorySetPathList() {
        $handaller = App::Module('Hook')->getHandler('CategorySet', 'register_definition');
        $data = array(CATEGORYSET_PATH);
        foreach ($handaller as $val) {
            $data[] = dirname($val[0]['path']);
        }

        return $data;
    }

    /**
     * Read Category Set List
     */
    public function getCategorySetList() {
        $list = App::Helper('Utility')->getDirLising($this->getCategorySetPathList());
        $tmp = Array();
        if (isset($list['file'])) {
            foreach ($list['file'] as $val) {
                $ext = App::Helper('Utility')->getExt($val['name']);
                if (".{$ext}" == $this->ext) {
                    array_push($tmp, App::Helper('Utility')->getName($val['name']));
                }
            }
        }
        return array_unique($tmp);
    }

    /**
     * Read information set definition
     *
     * @parameter type string
     * @return array
     */
    public function getCategorySetDefinition($type = NULL) {
        if (!isset($this->CategorySetSingleToneCache[$type])) {
            $this->cache_path = CATEGORYSET_CACHE_PATH;

            // Read Cache
            $definition = ($this->cache_exists($type)) ? $this->read_cache($type) : $this->parseCategorySetdefination($type);

            // Set Single tone cache
            $this->CategorySetSingleToneCache[$type] = $definition;

            // Create Physical cache
            if (app::__def()->sysConfig('CATEGORY_SET_CACHE')) {
                if (!$this->cache_exists($type)) {
                    $this->do_cache($definition, $type);
                }
            }
        }

        // Return defination
        return $this->CategorySetSingleToneCache[$type];
    }

    private function parseCategorySetdefination($type = NULL) {
        $file_path = CATEGORYSET_PATH . DS . $type . $this->ext;

        //Halt if information set is not exists
        if (!file_exists($file_path)) {
            $file_path = "";
            $hookResource = App::Module('Hook')->getHookResouce('CategorySet', 'register_definition');
            if (!empty($hookResource)) {
                foreach ($hookResource as $node) {
                    if (($class = $node['resource'][0]) != "" && ($method = $node['resource'][1]) != "") {
                        $_rtn_resources = App::__obj($class)->$method();
                        if (!empty($_rtn_resources)) {
                            foreach ($_rtn_resources as $res) {
                                if (strtolower($type) == strtolower($res['type'])) {
                                    $file_path = $res['path'];
                                }
                            }
                        }
                    }
                }
            }
            if ($file_path == "") {
                pre("Category set is missing for  \"{$type}\" <br /> #Path: development/core/category_set/{$type}.xml");
            }
        }

        $definition = array();
        $dom = new DOMDocument();
        $dom->load($file_path);

        /* Parse Category set defination */
        $base = $dom->getElementsByTagName('base');
        $definition['version'] = $base->item(0)->getElementsByTagName("version")->item(0)->nodeValue;
        $definition['lastupdate'] = $base->item(0)->getElementsByTagName("lastupdate")->item(0)->nodeValue;
        $definition['title'] = $base->item(0)->getElementsByTagName("title")->item(0)->nodeValue;
        $definition['admin_tab'] = $base->item(0)->getElementsByTagName("admin_tab")->item(0)->nodeValue;
        if ($base->item(0)->getElementsByTagName('parameters')->item(0)) {
            $parameters = $base->item(0)->getElementsByTagName('parameters')->item(0)->getElementsByTagName('parameter');
            foreach ($parameters as $parameter) {
                $definition['base']['parameters'][$parameter->getAttribute('name')] = $parameter->nodeValue;
            }
        } else {
            $definition['parameters'] = array();
        }
        $definition['description'] = $base->item(0)->getElementsByTagName("description")->item(0)->nodeValue;
        $definition['image']['status'] = $base->item(0)->getElementsByTagName("image")->item(0)->getElementsByTagName("status")->item(0)->nodeValue;
        $definition['image']['type'] = $base->item(0)->getElementsByTagName("image")->item(0)->getElementsByTagName("type")->item(0)->nodeValue;
        $definition['haschild'] = $base->item(0)->getElementsByTagName("haschild")->item(0)->nodeValue;
        $definition['generic']['status'] = $base->item(0)->getElementsByTagName("generic")->item(0)->getElementsByTagName("status")->item(0)->nodeValue;
        $definition['generic']['title'] = $base->item(0)->getElementsByTagName("generic")->item(0)->getElementsByTagName("title")->item(0)->nodeValue;

        // Search informaton
        $search = $dom->getElementsByTagName("sreach")->item(0);
        $definition['search'] = Array();
        if ($search) {
            $definition['search']['status'] = $search->getElementsByTagName('status')->item(0)->nodeValue;
            $definition['search']['field-selected'] = $search->getElementsByTagName('field-selected')->item(0)->nodeValue;
            $definition['search']['parma-link']['type'] = $search->getElementsByTagName('parma-link')->item(0)->getElementsByTagName('type')->item(0)->nodeValue;
            $definition['search']['parma-link']['uri'] = $search->getElementsByTagName('parma-link')->item(0)->getElementsByTagName('uri')->item(0)->nodeValue;
        }
        return $definition;
    }

    /* ==========================================================================================
      INFORMATION SET
      ============================================================================================ */

    public function fetchInformationSetPathList() {
        $list = App::Helper('Utility')->getDirLising($this->getInformationSetPathList());
        $pathList = array();
        foreach ($list['file'] as $row) {
            $ext = App::Helper('Utility')->getExt($row['name']);
            if (".{$ext}" == $this->ext) {
                $pathList[] = $row['dir_path'] . DS . $row['name'];
            }
        }

        $hookResource = App::Module('Hook')->getHookResouce('InformationSet', 'register_definition');
        if (!empty($hookResource)) {
            foreach ($hookResource as $node) {
                if (($class = $node['resource'][0]) != "" && ($method = $node['resource'][1]) != "") {
                    $_rtn_resources = App::__obj($class)->$method();
                    if (!empty($_rtn_resources)) {
                        foreach ($_rtn_resources as $res) {
                            $pathList[] = $res['path'];
                        }
                    }
                }
            }
        }

        return $pathList;
    }

    public function getInformationSetPathList() {
        $handaller = App::Module('Hook')->getHandler('InformationSet', 'register_definition');
        $data = array(INFORMATIONSET_PATH);
        foreach ($handaller as $val) {
            $data[] = dirname($val[0]['path']);
        }

        return $data;
    }

    /**
     * Read Category Set List
     */
    public function getInformationSetList() {
        $list = App::Helper('Utility')->getDirLising($this->getInformationSetPathList());
        $tmp = Array();

        foreach ($list['file'] as $val) {
            $ext = App::Helper('Utility')->getExt($val['name']);
            if (".{$ext}" == $this->ext) {
                array_push($tmp, App::Helper('Utility')->getName($val['name']));
            }
        }
        return $tmp;
    }

    /**
     * Read information set definition
     *
     * @parameter type string
     * @return array
     */
    public function getInformationSetDefinition($type = '') {
        if (!isset($this->InformationSetSingleToneCache[$type])) {
            $this->cache_path = INFORMATIONSET_CACHE_PATH;

            if ($this->cache_exists($type)) {
                $definition = $this->read_cache($type);
            } else {
                $definition = $this->parseInformationsetdefination($type);
            }

            // Create Single Tone cache
            $this->InformationSetSingleToneCache[$type] = $definition;

            if ($definition['base']['mode'] == 'db' && !$this->cache_exists($type)) {
                App::Module('informationset')->RefreshDb($type);
            }

            // Create Physical cache
            if (app::__def()->sysConfig('INFORMATION_SET_CACHE')) {
                if (!$this->cache_exists($type)) {
                    $this->do_cache($definition, $type);
                }
            }
        }
        return $this->InformationSetSingleToneCache[$type];
    }

    /**
     * Parse Information Set defination
     *
     * @parameter type string
     * @return Array
     */
    private function parseInformationsetdefination($type = '') {
        $file_path = INFORMATIONSET_PATH . DS . $type . $this->ext;

        if (!file_exists($file_path)) {
            $file_path = "";
            $hookResource = App::Module('Hook')->getHookResouce('InformationSet', 'register_definition');
            if (!empty($hookResource)) {
                foreach ($hookResource as $node) {
                    if (($class = $node['resource'][0]) != "" && ($method = $node['resource'][1]) != "") {
                        $_rtn_resources = App::__obj($class)->$method();
                        if (!empty($_rtn_resources)) {
                            foreach ($_rtn_resources as $res) {
                                if (strtolower($type) == strtolower($res['type'])) {
                                    $file_path = $res['path'];
                                }
                            }
                        }
                    }
                }
            }

            if ($file_path == "") {
                pre("Information set is missing for  \"{$type}\" <br /> #Path: development/definition/information_set/{$type}.xml <br /> #Tipe: Do not forget to set \"admin_tab\"");
            }
        }

        return $this->readInformationSetDefByPath($file_path);
    }

    public function readInformationSetDefByPath($file_path = null) {
        $dom = new DOMDocument();
        $dom->load($file_path);
        $definition = array();

        ## Read base section
        $base = $dom->getElementsByTagName('base');
        $definition['base']['mode'] = ($base->item(0)->getAttribute('mode') != '') ? $base->item(0)->getAttribute('mode') : 'EAV';

        // Information Set Version
        $definition['base']['version'] = $base->item(0)->getElementsByTagName("version")->item(0)->nodeValue;

        // Last Update
        $definition['base']['lastupdate'] = $base->item(0)->getElementsByTagName("lastupdate")->item(0)->nodeValue;

        // Information Set title
        $definition['base']['title'] = $base->item(0)->getElementsByTagName("title")->item(0)->nodeValue;

        // Admin tab to be rendered
        $definition['base']['admin_tab'] = $base->item(0)->getElementsByTagName("admin_tab")->item(0)->nodeValue;

        // Read addons
        if ($base->item(0)->getElementsByTagName('addons')->item(0)) {
            $parameters = $base->item(0)->getElementsByTagName('addons')->item(0)->getElementsByTagName('addon');
            foreach ($parameters as $parameter) {
                $definition['base']['addons'][] = $parameter->nodeValue;
            }
        } else
            $definition['addons'] = array();

        // Read parameters
        if ($base->item(0)->getElementsByTagName('parameters')->item(0)) {
            $parameters = $base->item(0)->getElementsByTagName('parameters')->item(0)->getElementsByTagName('parameter');
            foreach ($parameters as $parameter) {
                $definition['base']['parameters'][$parameter->getAttribute('name')] = $parameter->nodeValue;
            }
        } else {
            $definition['parameters'] = array();
        }
        // Maximum Entry Definition
        $max_entry = $base->item(0)->getElementsByTagName("max_entry");
        $definition['base']['generic_field']['max_entry']['limit'] = $max_entry->item(0)->getElementsByTagName("limit")->item(0)->nodeValue;
        $definition['base']['generic_field']['max_entry']['message'] = $max_entry->item(0)->getElementsByTagName("message")->item(0)->nodeValue;

        // Search information
        $search = $base->item(0)->getElementsByTagName("sreach")->item(0);
        $definition['base']['search'] = Array();
        if ($search) {
            $definition['base']['search']['status'] = $search->getElementsByTagName('status')->item(0)->nodeValue;
            $definition['base']['search']['field-selected'] = $search->getElementsByTagName('field-selected')->item(0)->nodeValue;
            $definition['base']['search']['field-description'] = $search->getElementsByTagName('field-description')->item(0)->nodeValue;
            $definition['base']['search']['parma-link']['type'] = $search->getElementsByTagName('parma-link')->item(0)->getElementsByTagName('type')->item(0)->nodeValue;
            $definition['base']['search']['parma-link']['uri'] = $search->getElementsByTagName('parma-link')->item(0)->getElementsByTagName('uri')->item(0)->nodeValue;
        }

        ## Read Virtual fields
        $fields = $dom->getElementsByTagName('fields')->item(0)->getElementsByTagName('field');
        foreach ($fields as $field) {
            $fieldName = $field->getAttribute('name');
            $definition['fields'][$fieldName] = $this->readInformationsetFieldDef($field);
        }

        return $definition;
    }

    private function readValidationData($domobj = NULL) {
        try {
            $validationObj = $domobj->getElementsByTagName("validation")->item(0);
            $validationlist = Array();
            if ($validationObj) {
                if (!$validationObj->nodeValue) {
                    return Array();
                }
                if ($validationObj->getElementsByTagName("rule")->item(0)) {
                    foreach ($domobj->getElementsByTagName("rule") as $val) {
                        $validationlist[] = $this->readValidationNode($val);
                    }
                } else {
                    $validationlist[] = $this->readValidationNode($validationObj);
                }
            }

            return $validationlist;
        } catch (Exception $Err) {
            return Array();
        }
    }

    private function readValidationNode($domobj = NULL) {
        $nodeArr = Array();

        $nodeArr["type"] = $domobj->getElementsByTagName("type")->item(0)->nodeValue;
        $nodeArr["message"] = $domobj->getElementsByTagName("err-message")->item(0)->nodeValue;
        $list = $domobj->getElementsByTagName("list")->item(0);

        $listArr = Array();
        if ($list) {
            foreach ($list->getElementsByTagName("val") as $val) {
                $listArr[] = $val->nodeValue;
            }
        }
        $nodeArr["list"] = $listArr;

        $options = $domobj->getElementsByTagName("rule-options")->item(0);
        $optionsArr = Array();
        if ($options) {
            foreach ($options->getElementsByTagName("option") as $val) {
                $optionsArr[$val->getAttribute("name")] = $val->nodeValue;
            }
        }
        $nodeArr["options"] = $optionsArr;


        return $nodeArr;
    }

    /**
     * Read field object
     *
     * @parameter fieldobj DOM XML Object
     * @return Array
     */
    private function readInformationsetFieldDef($fieldobj = NULL) {
        $defarr = array();

        if ($fieldobj->getElementsByTagName('title')->item(0)) {
            $defarr['title'] = $fieldobj->getElementsByTagName('title')->item(0)->nodeValue;
        } else
            $defarr['title'] = "";

        if ($fieldobj->getElementsByTagName('searchable')->item(0)) {
            $defarr['searchable'] = $fieldobj->getElementsByTagName('searchable')->item(0)->nodeValue;
        } else
            $defarr['searchable'] = "No";

        if ($fieldobj->getElementsByTagName('selected')->item(0)) {
            $defarr['selected'] = $fieldobj->getElementsByTagName('selected')->item(0)->nodeValue;
        } else
            $defarr['selected'] = "";

        if ($fieldobj->getElementsByTagName('hints')->item(0)) {
            $defarr['hints'] = $fieldobj->getElementsByTagName('hints')->item(0)->nodeValue;
        } else
            $defarr['hints'] = "";

        if ($fieldobj->getElementsByTagName('type')->item(0)) {
            $defarr['type'] = $fieldobj->getElementsByTagName('type')->item(0)->nodeValue;
        } else
            $defarr['type'] = "";

        if (($fieldobj->getElementsByTagName('category_type')->item(0))) {
            $defarr['category_type'] = $fieldobj->getElementsByTagName('category_type')->item(0)->nodeValue;
        }

        if (($fieldobj->getElementsByTagName('informationset_type')->item(0))) {
            $defarr['informationset_type'] = $fieldobj->getElementsByTagName('informationset_type')->item(0)->nodeValue;
        }


        $defarr['validation'] = $this->readValidationData($fieldobj);

        if ($fieldobj->getElementsByTagName('options')->item(0)) {
            $options = $fieldobj->getElementsByTagName('options')->item(0)->getElementsByTagName('option');
            foreach ($options as $option) {
                $defarr['options'][$option->getAttribute('value')] = $option->nodeValue;
            }
        }

        if ($fieldobj->getElementsByTagName('parameters')->item(0)) {
            $parameters = $fieldobj->getElementsByTagName('parameters')->item(0)->getElementsByTagName('parameter');
            foreach ($parameters as $parameter) {
                $defarr['parameters'][$parameter->getAttribute('name')] = $parameter->nodeValue;
            }
        } else
            $defarr['parameters'] = array();

        if ($fieldobj->getElementsByTagName('tag-attributes')->item(0)) {
            $parameters = $fieldobj->getElementsByTagName('tag-attributes')->item(0)->getElementsByTagName('attribute');
            foreach ($parameters as $parameter) {
                $defarr['tag-attributes'][$parameter->getAttribute('name')] = $parameter->nodeValue;
            }
        } else
            $defarr['tag-attributes'] = array();

        if ($fieldobj->getElementsByTagName('db-attribute')->item(0)) {
            $parameters = $fieldobj->getElementsByTagName('db-attribute')->item(0)->getElementsByTagName('attribute');
            foreach ($parameters as $parameter) {
                $defarr['db-attributes'][trim($parameter->getAttribute('name'))] = $parameter->nodeValue;
            }
        }

        $defarr['db-attributes'] = $this->varifyDBAttribute($defarr, $defarr);

        // Return in array
        return $defarr;
    }

    private function varifyDBAttribute($fdef = array(), $defarr = array()) {
        $def = isset($fdef['db-attributes']) ? $fdef['db-attributes'] : array();
        //Varify Files
        $def['type'] = isset($def['type']) ? $def['type'] : 'varchar';
        $def['length'] = isset($def['length']) ? $def['length'] : '255';
        $def['null'] = (isset($def['null']) && in_array($def['null'], array('NULL', 'NOT NULL')) ) ? $def['null'] : 'NOT NULL';
        $def['default'] = isset($def['default']) ? $def['default'] : '';
        if ($def['type'] == 'enum') {
            $keyslist = array_keys($defarr['options']);
            $def['length'] = (!empty($keyslist)) ? "'" . implode("','", $keyslist) . "'" : '';
        }
        return $def;
    }

    /* ==========================================================================================
      PROCESS CACHE
      ============================================================================================ */

    private function do_cache($data = NULL, $file_name = NULL) {
        $this->write_to_disc($this->encode($data), $file_name);
    }

    private function read_cache($file_name = NULL) {
        return $this->decoted($this->read_from_desk($file_name));
    }

    function encode($data = NULL) {
        return isset($data) ? serialize($data) : "";
    }

    function decoted($data = NULL) {
        return isset($data) ? unserialize($data) : "";
    }

    function cache_exists($pre_name = NULL) {
        return file_exists($this->cache_path . DS . "{$pre_name}.{$this->cache_ext}");
    }

    function read_from_desk($pre_name = NULL) {
        $path = $this->cache_path . DS . "{$pre_name}.{$this->cache_ext}";

        if (file_exists($path)) {
            $handle = fopen($path, "r");
            $contents = '';
            while (!feof($handle)) {
                $contents .= fread($handle, 8192);
            }
            fclose($handle);

            return $contents;
        } else {
            echo "Key not found '{$pre_name}'";
        }
    }

    function write_to_disc($data = NULL, $pre_name = NULL) {
        $path = $this->cache_path . DS . "{$pre_name}.{$this->cache_ext}";

        if (!$handle = fopen($path, 'w')) {
            echo "Can not write file($path)";
            exit;
        }

        if (fwrite($handle, $data) === FALSE) {
            echo "Can not write file($path)";
            exit;
        }

        fclose($handle);
    }

    public function cache_path_manager() {
        if (!file_exists(CACHE) || !is_writeable(CACHE)) {
            pre("Cache path is not writeable or missibg   <br /> #Path: " . CACHE);
        }

        // Create Base cache
        if (!file_exists(TEMP))
            mkdir(TEMP, 0777);
        if (!file_exists(BACKUP))
            mkdir(BACKUP, 0777);
        if (!file_exists(BYTE_STREAM))
            mkdir(BYTE_STREAM, 0777);
        if (!file_exists(DATA))
            mkdir(DATA, 0777);
        if (!file_exists(DATA . DS . 'database'))
            mkdir(DATA . DS . 'database', 0777);

        // Create Temporary Cache
        if (!file_exists(MODEL_CACHE_PATH))
            mkdir(MODEL_CACHE_PATH, 0777);
        if (!file_exists(REPORT_CACHE_PATH))
            mkdir(REPORT_CACHE_PATH, 0777);
        if (!file_exists(CATEGORYSET_CACHE_PATH))
            mkdir(CATEGORYSET_CACHE_PATH, 0777);
        if (!file_exists(INFORMATIONSET_CACHE_PATH))
            mkdir(INFORMATIONSET_CACHE_PATH, 0777);
        if (!file_exists(INTERFACEBUILDER_CACHE_PATH))
            mkdir(INTERFACEBUILDER_CACHE_PATH, 0777);
        if (!file_exists(ADDON_CACHE_PATH))
            mkdir(ADDON_CACHE_PATH, 0777);
        if (!file_exists(SITESETTINGS_CACHE_PATH))
            mkdir(SITESETTINGS_CACHE_PATH, 0777);
        if (!file_exists(URIMANAGER_CACHE_PATH))
            mkdir(URIMANAGER_CACHE_PATH, 0777);
        if (!file_exists(LANGUAGE_CACHE_PATH))
            mkdir(LANGUAGE_CACHE_PATH, 0777);
        if (!file_exists(WSDL_CACHE_PATH))
            mkdir(WSDL_CACHE_PATH, 0777);
        if (!file_exists(COMPONENT_CACHE_PATH))
            mkdir(COMPONENT_CACHE_PATH, 0777);
    }

}
