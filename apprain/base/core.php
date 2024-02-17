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
 *
 * Apprain core class
 */
class appRain_Base_Core extends appRain_Collection {

    /**
     *
     */
    const ADMIN_VIEW_NAME = 'system';
    const ADMIN_VIEW_LAYOUT_NAME = 'admin';
    const LAYOUT_DIR_NAME = 'layout';
    const ELEMENTS_DIR = "elements";
    const LAYOUT_EMPTY = 'empty';
    const LAYOUT_BLANK = 'blank';
    const DEFAULT_THEME = 'default';

    /**
     * Preserve information section definition
     *
     * @type Array
     */
    public $information_defination = array();

    /**
     *    Global data variable
     *    - This variable will process all $_POST or $_FILES data
     *
     * @type array
     */
    public $data = Array();
    public $post = Array();
    public $get = Array();

    /**
     *   Global Configuraion variable
     *   - Contain all site configuration
     *
     * @type array
     */
    public $config = Array();

    /**
     *   This variables to process all set data in layour
     *
     * @type array
     */
    public $set_vars = array();

    /**
     *  To manage the current layout
     *
     * @type string
     */
    public $layout = "default";

    /**
     * Current theme
     *
     */
    public $theme = NULL;

    /**
     *    To set the correct tab in admin panel
     *
     * @type string
     */
    protected $admin_tab = '';

    /**
     * Page Common meta Tag Information
     *
     * @type string
     */
    protected $page_title = "";
    protected $page_meta_keyowrds = "";
    protected $page_meta_desc = "";

    /**
     *    To process any temporary data gloablly
     *
     * @type mix
     */
    public $tmp = "";

    /**
     *    Addon(3rd party Group 1) lost to load in current scope
     *
     * @type array
     */
    protected $addons = array();

    /**
     *    To add spacific javascripts
     *
     * @type array
     */
    protected $scripts = array();

    /**
     *    Plugin(3rd Party Group 2) list to load in current scope by default
     *
     * @type array
     */
    public $plugins = array();

    /**
     *    Plugin(3rd Party Group 2) list to load in current scope on run time
     *
     * @type array
     */
    public $plugin = array();

    /**
     * Common variables
     *
     * @type mix
     */
    public $relation_data = true;
    public $id = NULL;
    public $model = NULL;
    public $models = array();

    /**
     *    appRain modules
     *
     * @type object
     */
    public $Session = NULL;
    public $Cookie = NULL;
    public $Cache = NULL;
    public $dbimexport = NULL;
    public $Language = NULL;

    /**
     * Load Models
     */
    protected $load_models = array();
    public $fetchtype = NULL;

    /**
     * Basicas works to get prepared
     *
     * @return null
     */
    public function bootstrapping() {
        /*
         * Modules Object
         */
        /* Load all models */
        if (empty($this->load_models)) {
            $models = App::Load("Helper/Utility")->getDirLising($this->model_path());

            foreach ($models["file"] as $v) {

                $this->instanciate_model($this->filename2model_class_name($v["name"]));
            }
        } else {
            foreach ($this->load_models as $v) {
                $this->instanciate_model($this->filename2model_class_name("{$v}.php"));
            }
        }

        $this->veryfirst_render();
    }

    /**
     *    The function will render some mandatary functions to set some common variables
     *
     * @return null
     */
    public function veryfirst_render() {
        /**
         * Gloabl configurations here
         */
        $config = Array();

        # Define URI
        $config['ip'] = $_SERVER['REMOTE_ADDR'];
        $config['http'] = isset($_SERVER['REDIRECT_HTTPS']) ? "https://" : "http://";
		
		$config['host'] = $_SERVER['SERVER_NAME'];
		if(isset($_SERVER['HTTP_HOST'])){
			$config['host'] = $_SERVER['HTTP_HOST'];
		}


        $config['port'] = $_SERVER['SERVER_PORT'];
        $config['rootdir'] = $_SERVER['DOCUMENT_ROOT'];
        $config['subpath'] = substr(dirname($_SERVER["PHP_SELF"]), 0, ((strrpos(dirname($_SERVER["PHP_SELF"]), "webroot")) - 1));

        # Cookie Domain
        $config['cookie_domaint'] = (substr($config['host'], 0, 4) == "www.") ? substr($config['host'], 3, strlen($config['host'])) : $config['cookie_domaint'] = "." . $config['host'];
        if ($config['cookie_domaint'] == '.localhost')
            $config['cookie_domaint'] = NULL;

        # Initialize some basic config
        define('COOKIE_TIME_OUT', app::__def()->sysConfig('COOKIE_TIME_OUT') * 60);
		if (!isset($_SESSION)) {
			ini_set('session.gc_maxlifetime', app::__def()->sysConfig('SESSION_TIME_OUT') * 60);
			ini_set('session.gc_divisor', 1);
			ini_set('session.cookie_domain', $config['cookie_domaint']);
		}
        # Disabled Magic Quotes
        #if(get_magic_quotes_runtime())
        #{
        #	set_magic_quotes_runtime(false);
        #}

        $config["session_id"] = App::Load("Module/Cookie")->read("PHPSESSID");

        # Set URL of the site
        $config['baseurl'] = ($config['port'] != "80") ? ($config['host'] . ":" . $config['port'] . $config['subpath']) : ($config['host'] . $config['subpath']);

        $config['basedir'] = App::getBaseDir();
        $config['filemanager_base_dir'] = 'uploads' . DS . 'filemanager';

        $config['site_info'] = $this->user_settings();

        # Optional date values
        $time_zone = isset($config['site_info']['time_zone']) ? $config['site_info']['time_zone'] : "America/Los_Angeles";

        @date_default_timezone_set($time_zone);
        $config['today'] = date('D, M d y');
        $config['date'] = date('Y-m-d');

        // Parameters
        $config['params'] = $this->params;

        set_error_handler("userErrorHandler");

        # SET ERROR REPORTING
        if (DEBUG_MODE == "1" or DEBUG_MODE == "2") {
            error_reporting(E_ALL);
        } else {
            error_reporting(0);
        }

        /*
         * Process $_POST or $_FILESE in data variable
         */
        $this->set_post();

        /*
         * Load Default plugins
         */
        $this->load_plugins();

        /*
         * Process the admin panel links
         */
        $this->set('left_links', $this->get_admin_links($this->admin_tab, 'adminleft'));

        // User Information
        $config['user'] = app::load("Module/Session")->read("User");

        // Select the apprain theme
        $this->app_theme_selector($config['site_info']);

        // Set Theme in config
        $config['theme'] = $this->theme;

        // Set to global variable
        app::load("Helper/Config")->__config = $config;
    }

    /**
     * Instanciate Model
     */
    private function instanciate_model($model_name) {
        $long = $model_name["long"];
        $short = $model_name["short"];
        if (class_exists($long)) {
            if (App::__def()->sysConfig('LOAD_MODEL_OBJECT_TO_THIS')) {
                $this->$short = new $long();
            }

            if (App::__def()->sysConfig('MODEL_VERSION_CONTROL') && App::__def()->sysConfig('DEBUG_MODE') > 0) {
                $this->setModelname($short)
                        ->modelinstaller();
            }
        } else {
            die(nl2br("<code style=\"font-family:arial;font-size:12px\">Create the following model \n File Location:  development/models \n File Name:  " . strtolower($short) . ".php\n\n" . "class $long extends model \n{\nvar $" . "name = '$short';\npublic $" . "db_table = 'DATABASE_TABLE_NAME';\n}\n</code>"));
        }
    }

    // LETS SEE SOME MAGIC
    private function modelinstaller() {
        $short = $this->getModelname();

        $core_version = App::Model($short)
                ->getVersion()
                ->getValue('core_version');

        $version = App::Model($short)
                ->getValue('version');

        if ($core_version < $version) {
            if (file_exists($this->installerPath($short))) {
                $installerResource = App::__pathToClass($this->installerPath($short))->installerResource();

                if (isset($installerResource["{$version}"])) {
                    if (is_array($installerResource["{$version}"])) {
                        foreach ($installerResource["{$version}"] as $queries) {
                            foreach (App::Helper('Utility')->sqlSaperator($queries) as $query) {
                                App::Model($short)->custom_execute($query);
                            }
                        }
                    } else {
                        foreach (App::Helper('Utility')->sqlSaperator($installerResource["{$version}"]) as $query) {
                            App::Model($short)->custom_execute($query);
                        }
                    }
                }
            }

            $this->updatemodelversion();
        }

        return $this;
    }

    public function installerPath($short) {
        return $this->model_path(NULL, $short) . DS . "installer" . DS . strtolower(App::Model($short)->name) . ".php";
    }

    private function updatemodelversion() {
        $short = $this->getModelname();

        $version = App::Model($short)->version;

        $saved_data = App::Load("Model/Coreresource")->findByName($short);

        $id = isset($saved_data['id']) ? $saved_data['id'] : NULL;

        App::Load("Model/Coreresource")
                ->save(
                        array(
                            "Coreresource" => array(
                                "id" => $id,
                                "name" => $short,
                                "version" => $version,
                                "type" => "Model"
                            )
                        )
        );
    }

    /**
     * Select theme
     *
     * @return null
     */
    public function app_theme_selector($config = NULL) {
        $definition = App::__def()->getURIManagerDefinition();
        $definition['bootrouter']['theme'] = isset($definition['bootrouter']['theme']) ? $definition['bootrouter']['theme'] : "";

        if ($definition['bootrouter']['theme'] != "") {
            $this->theme = $definition['bootrouter']['theme'];
        } else {
            $this->theme = App::Helper('Config')->load('site_info')->get('theme');
        }

        if (is_null($this->theme)) {
            $this->theme = appRain_Base_Core::DEFAULT_THEME;
        }
    }

    /**
     * Process all POST and GET value
     *
     * @return null
     */
    private function set_post() {
        $this->post = $_POST;
        $this->get = $_GET;
        $this->data = isset($_POST['data']) ? $_POST['data'] : Array();

        if (!empty($_FILES['data'])) {
            $_file_key = key($_FILES['data']['name']);
            foreach ($_FILES['data']['name'][$_file_key] as $key => $val) {
                $this->data[$_file_key][$key] = array(
                    "name" => $_FILES['data']['name'][$_file_key][$key],
                    "type" => $_FILES['data']['type'][$_file_key][$key],
                    "tmp_name" => $_FILES['data']['tmp_name'][$_file_key][$key],
                    "error" => $_FILES['data']['error'][$_file_key][$key],
                    "size" => $_FILES['data']['size'][$_file_key][$key]
                );
            }
        }
    }

    /**
     * Set global variables to process for view
     *
     * @parameter key string
     * @parameter val mix
     * @return null
     */
    public function set($key = NULL, $val = NULL) {
        $this->set_vars[$key] = $val;
    }

    /**
     * Basic render section
     *
     * @parameter render_path string
     * @return null
     */
    public function render($render_path = null) {
        $COData = app::get('controllerLoadByComponent_data');

        if (!empty($this->set_vars)) {
            foreach ($this->set_vars as $key => $val) {
                $$key = $val;
            }
        }

        App::Module('Callbacks')->_before_theme_load($this);
		

        if (!(strtolower($this->layout) == appRain_Base_Core::ADMIN_VIEW_LAYOUT_NAME && file_exists($view_render_path = VIEW_PATH . DS . appRain_Base_Core::ADMIN_VIEW_NAME . DS . $render_path . TPL_EXT))) {
			
			$view_render_path = VIEW_PATH . DS . $this->theme . DS . $render_path . TPL_EXT;
			
			if(!file_exists($view_render_path) && isset($COData['controller_path'])) {
                $view_render_path = $COData['controller_path'] . DS . $render_path . TPL_EXT;
            } 
        }

        if (!(strtolower($this->layout) == appRain_Base_Core::ADMIN_VIEW_LAYOUT_NAME && file_exists($layout_path = VIEW_PATH . DS . appRain_Base_Core::ADMIN_VIEW_NAME . DS . appRain_Base_Core::LAYOUT_DIR_NAME . DS . $this->layout . TPL_EXT))) {
            $layout_path = VIEW_PATH . DS . $this->theme . DS . appRain_Base_Core::LAYOUT_DIR_NAME . DS . $this->layout . TPL_EXT;
        }

        $contents = '';
        if ($this->layout == appRain_Base_Core::LAYOUT_BLANK || $this->layout == appRain_Base_Core::LAYOUT_EMPTY) 
		{
            if ($this->layout == appRain_Base_Core::LAYOUT_BLANK) 
			{
                $contents = file_exists($view_render_path) ? $this->get_include_contents($view_render_path) : "";
            }
        }
		else 
		{
            $content_rendered = file_exists($view_render_path) ? $this->get_include_contents($view_render_path) : "";

            if (file_exists($layout_path)) {
                
				ob_start();
               
				include $layout_path;
               
				$contents = ob_get_contents();
                
				ob_end_clean();
				
				
            } else {
                App::__transfer("/developer/exception/theme_not_defined");
            }
        }

        //echo $contents; ContentModifier
        $hookResource = App::Module('Hook')->getHookResouce('ContentModifier', 'register_modifier');

        if (!empty($hookResource)) {
            foreach ($hookResource as $node) {
                if (($class = $node['resource'][0]) != "" && ($method = $node['resource'][1]) != "") {
                    $contents = App::__obj($class)->$method($contents, $this->layout);
                }
            }
        }

        // Display Content
        echo $contents;

        // After theme loaded 
        App::Module('Callbacks')->_after_theme_load($this);
    }

    /**
     * Render page cointent
     *
     * @parameter filename string
     */
    private function get_include_contents($filename) {
        if (!empty($this->set_vars)) {
            foreach ($this->set_vars as $key => $val) {
                $$key = $val;
            }
        }

        if (is_file($filename)) {
            ob_start();
            include $filename;
            $contents = ob_get_contents();
            ob_end_clean();

            /* if($this->layout != 'admin'){
              $str = '<div style="border:1px solid red">';
              $str .= '<a target="_blank" href="' . App::Config()->baseUrl('?loc=' . str_replace(App::Config()->rootDir(),'', $filename)) . '">EDIT</a>';
              $str .= $contents;
              $str .= '</div>';
              return $str;
              }
              else{
              return $contents;
              } */

            return $contents;
        }
        return false;
    }

    /**
     *    Calls elements to render in view
     *
     * @parameter element_path string
     * @parameter args array
     * @return null
     */
    public function callElement($element_path = NULL, $args = NULL) {
        if (!empty($args)) {
            foreach ($args as $key => $val) {
                $this->set($key, $val);
            }
        }

        if (
                !(strtolower($this->layout) == appRain_Base_Core::ADMIN_VIEW_LAYOUT_NAME && file_exists($element_render_path = VIEW_PATH . DS . appRain_Base_Core::ADMIN_VIEW_NAME . DS . "elements" . DS . $element_path . TPL_EXT))
        ) {
            $element_render_path = VIEW_PATH . DS . $this->theme . DS . appRain_Base_Core::ELEMENTS_DIR . DS . $element_path . TPL_EXT;
        }

        return file_exists($element_render_path) ? $this->get_include_contents($element_render_path) : die("ELEMENT Expected: " . $element_render_path);
    }

    /**
     * Load 3rd Parties
      ------------------
     * @parameter plugins string
     * @return null
     */
    public function load_plugins($plugins = NULL) {
        if (isset($plugins)) {
            $this->plugins = $plugins;
        }
        // include (APPRAIN_ROOT . "development/plugin/register.php");
    }

    /**
     * Model directory path
     *
     * @return string
     */
    protected function model_path($sub_part = "", $name = null) {
        $paths = Array();
        $hookResource = App::Module('Hook')->getHookResouce('Model', 'register_model');

        $paths[] = MODEL_PATH . $sub_part;
        if (!empty($hookResource)) {
            foreach ($hookResource as $node) {
                if (($class = $node['resource'][0]) != "" && ($method = $node['resource'][1]) != "") {
                    $_rtn_resources = App::__obj($class)->$method();
                    if (!empty($_rtn_resources)) {
                        foreach ($_rtn_resources as $res) {
                            if (isset($name)) {
                                if (strtolower($name) == strtolower($res['name']))
                                    return $res['model_path'];
                            }
                            else {
                                $paths[] = $res['model_path'] . $sub_part;
                            }
                        }
                    }
                }
            }
        }

        return isset($name) ? $paths[0] : $paths;
    }

    /**
     * Format modles class names
     *
     * @return array
     */
    protected function filename2model_class_name($str = "") {
        $s = explode(".", $str);
        return array("long" => $s[0] . "Model", "short" => ucfirst($s[0]));
    }

    public function fetchAddonlibs() {
        $sys_addons = app::__def()->getAddons();

        foreach ($sys_addons as $addon_name => $addon) {
            if (
				($addon['status'] == 'Active') && 
				(strtolower($addon['layouts']) == 'all' || in_array($this->layout, explode(',', strtolower($addon['layouts'])))) && 
				!in_array($this->layout, explode(',', strtolower($addon['layouts_except'])))
            ) {
                if ($addon['load'] == 'Always' || in_array($addon_name, $this->addons)) {
                    echo "\n<!-- START {$addon['title']} -->";
                    $this->_before_addon_load($addon_name);

                    if (isset($addon['javascripts'])) {
                        foreach ($addon['javascripts'] as $src)
                            echo App::Load("Helper/Html")->add_javascript($src);
                    }

                   if (isset($addon['style_sheets'])) {
                        foreach ($addon['style_sheets'] as $link)
                            echo App::Load("Helper/Html")->add_css($link);
                    }

                     if ($addon['code'] != "") {
                        echo App::Helper('Utility')->codeFormated($addon['code']);
                    }
                    $this->_after_addon_load($addon_name);
                    echo "\n<!-- END {$addon['title']} -->";
                }
            }
        }
    }

}
