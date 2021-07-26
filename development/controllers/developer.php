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
 * Admin Controller
 */
class developerController extends appRain_Base_Core
{
    public $name = 'Developer';

    /**
     * Admin index
     *
     * @parameter admin_flag string
     *
     * @return null
     */
    public function indexAction($admin_flag = 'introduction')
    {
        $this->redirect('/admin/' . app::__def()->sysConfig('ADMIN_REDIRECTION'));
        exit;
    }

    /*
     * Developer file manager
     *
     * Depricated function from verson 3.0.3
     */
    public function editorAction() {
       
    }

    /**
     * View phpinfo()
     *
     * @return null
     */
    public function showmyphpinfoAction()
    {
        $this->setAdminTab('developer');
        $this->page_title = "PHP info";
    }


    /**
     * Manage appRain theme
     *
     * @parameter theme2install string
     * @return null
     */
    public function themeAction($themeName = NULL, $action = null)
    {
        // Sec Admin TAB
        $this->setAdminTab('developer');
        $this->addons = array('dialogs');

        if (!empty($this->data)) {

            /* Save Theme Information */
            $obj = App::Module('Universal_Installer')
                ->setSourceAutoDelete(true)
                ->setDefaultInstallationPath(VIEW_PATH)
                ->upload($this->data['Theme']['resourcefile'])
                ->Install();

            if (empty($obj->errors)) {
                App::Module('Notification')->Push('Theme installed successfully');
            }
            else {
                App::Module('Notification')->Push($obj->errors, 'Error');
            }

            App::Module("Developer")->clearCache();

            $this->redirect("/developer/theme");
            exit;
        }
        else if ($action == 'remove') {
		
		    App::Module('Callbacks')->_on_theme_remove($themeName);
            $obj = App::Module('Universal_Installer')
                ->setResourcePath(VIEW_PATH . DS . $themeName)
                ->Uninstall();
            App::Module('Notification')->Push('Theme Removed successfully');
            App::Module("Developer")->clearCache();

            $this->redirect("/developer/theme");
            exit;
        }

        if (isset($themeName)) {
            $new_theme = base64_decode($themeName);

            $row = App::Model('Config')->find("soption='theme'");					
            App::Module('Callbacks')->_before_theme_install($row['svalue']);
			
			$result = App::Config()->setSiteInfo('theme',$new_theme);

            App::Module('Notification')->Push('Theme installed successfully');
            App::Module("Developer")->clearCache();
            App::Module('Callbacks')->_after_theme_installed($new_theme);
            $this->redirect("/developer/theme");
            exit;
        }

        /** Fetch themes */
        $theme_info = App::Load('Helper/Utility')->getDirLising(VIEW_PATH);
        $themes = Array();
        $themes_default = Array();

        foreach ($theme_info['dir'] as $val) {

            $path = VIEW_PATH . DS . $val['name'];

            if (file_exists("{$path}/definition/info.xml")) {
                $info = App::Load("Helper/Utility")->fatchfilecontent("{$path}/definition/info.xml");
                $name = App::Load("Helper/Utility")->get_value_by_tag_name($info, "<name>", "</name>");
                $desc = App::Load("Helper/Utility")->get_value_by_tag_name($info, "<description>", "</description>");
                $author = App::Load("Helper/Utility")->get_value_by_tag_name($info, "<author>", "</author>");
                $author_uri = App::Load("Helper/Utility")->get_value_by_tag_name($info, "<author_uri>", "</author_uri>");

                $basepath = $path;

                $image = App::Load("Helper/Utility")->get_value_by_tag_name($info, "<image>", "</image>");

                if (($name != "")
                    && ($desc != "")
                    && ($image != "")
                ) {
                    $tmp = array(
                        "name" => $val['name'],
                        "title" => $name,
                        "description" => $desc,
                        "image" => $image,
                        "basepath" => $basepath,
                        'author' => $author,
                        'author_uri' => $author_uri
                    );

                    if ($this->theme == $val['name']) {
                        $themes_default = $tmp;
                    }
                    else {
                        $themes[] = $tmp;
                    }
                }
            }
        }

        $this->set("themes", $themes);
        $this->set("action", $action);
        $this->set("themes_default", $themes_default);
    }

    /**
     * Manage System configuration
     * All data saved in XML file
     * in "definition" Directory
     */
    public function sys_configAction()
    {
        // Check authonitcation
        $this->setAdminTab('developer');

        $this->page_title = 'System Configuration';
        $message = "";
        $file_path = CONFIG_PATH . DS . "config.xml";
        $definition = array();
        $dom = new DOMDocument();

        $dom->load($file_path);

        if (isset($this->post['Button']['button_save'])) {
            if (is_writeable($file_path)) {

                $this->data['sconfig'] = isset($this->data['sconfig'])
                    ? $this->data['sconfig'] : array();

                $options = $dom->getElementsByTagName('option');

                foreach ($options as $option) {
                    $name = $option->getAttribute('name');
                    $option->getElementsByTagName('value')->item(0)->nodeValue = '';

                    if (
                        in_array($name,
                            array_keys($this->data['sconfig'])
                        )
                    ) {
                        $cdataNode = $dom->createCDATASection($this->data['sconfig'][$name]);
                        $option->getElementsByTagName('flag')->item(0)->nodeValue = 0;
                    }
                    else {
                        $cdataNode = $dom->createCDATASection(
                            $option->getElementsByTagName('default')
                                ->item(0)
                                ->nodeValue
                        );

                        $option->getElementsByTagName('flag')->item(0)->nodeValue = 1;
                    }

                    $option->getElementsByTagName('value')->item(0)->appendChild($cdataNode);

                }

                App::Module('Notification')->Push($this->__("Configuration updated successfully."));

                /*  Save Configuration */
                $dom->save($file_path);
            }
            else {
                App::Module('Notification')
                    ->Push(
                    $this->__("Your configuration file is not writeable($file_path)."),
                    'Error'
                );
            }
            $this->redirect("/developer/sys-config");
            exit;
        }
        $this->set('sysconf', $dom);
    }

    public function uri_managerAction()
    {
    }

    public function debuggerAction()
    {
        $this->layout = 'admin';
        $this->admin_tab = 'developer';
        $this->page_title = 'System Configuration';
    }

    public function mvcmanagerAction($action = "")
    {
        $this->setAdminTab('developer');

        if ($action != 'create') {
            $mvcdata = $this->get_mvc_data($action);
            $this->set('mvcdata', $mvcdata);
        }
        $this->set('action', $action);
    }


    private function get_mvc_data($model = "")
    {
        $models = App::Load("Helper/Utility")->getDirLising(App::__Obj('appRain_Base_Core')->model_path());

        $_mvc_data = Array();
        foreach ($models['file'] as $val) {

            $name = App::Load("Helper/Utility")
                ->setFileName($val['name'])
                ->getName();

            if (($model == "")
                || $name == $model
            ) {
                $_mvc_data[$name]['model']['version'] = App::Load("Model/{$name}")->version;
                $_mvc_data[$name]['model']['db_table'] = App::Load("Model/{$name}")->db_table;
                $_mvc_data[$name]['model']['exists'] = true;
                $_mvc_data[$name]['model']['path'] = App::__Obj('appRain_Base_Core')->model_path(NULL, App::Model($name)->name);
                $_mvc_data[$name]['model']['name'] = App::Load("Model/{$name}")->name;

                $_mvc_data[$name]['model']['insteller']['exists'] = (file_exists(App::__Obj('appRain_Base_Core')->installerPath(App::Model($name)->name)))
                    ? true : false;

                if (file_exists(CONTROLLER_PATH . DS . $val['name'])) {
                    $_mvc_data[$name]['controller']['path'] = "/development/controllers/";
                    $_mvc_data[$name]['controller']['exists'] = true;
                    $_mvc_data[$name]['controller']['name'] = $name;
                }
                else {
                    $_mvc_data[$name]['controller']['exists'] = false;
                }

                if (file_exists(VIEW_PATH . DS . $this->theme . DS . $name)) {

                    $views = App::Load('Helper/Utility')->getDirLising(VIEW_PATH . DS . $this->theme . DS . $name);
                    $_mvc_data[$name]['view']['path'] = VIEW_PATH . DS . $this->theme . DS . $name;
                    $_mvc_data[$name]['view']['exists'] = true;

                    foreach ($views['file'] as $vnode) {
                        $_mvc_data[$name]['view']['files'][] = array(
                            'name' => App::Load("Helper/Utility")->setFileName($vnode['name'])->getName(),
                            'url' => App::Load('Helper/Config')->baseurl(DS . $name . DS . str_replace('_', '-', App::Load("Helper/Utility")->setFileName($vnode['name'])->getName())),
                            'path' => "/development/view/" . $this->theme . DS . $name,
                            'file_name' => $vnode['name']
                        );
                    }
                }
                else {
                    $_mvc_data[$name]['view']['exists'] = false;
                }
            }
        }

        /* Return GROSS */
        return $_mvc_data;
    }

    /**
     * A General process to generage WSDL for webservice
     */
    public function webserviceAction($className = NULL, $service = false)
    {
        $this->layout = "blank";
        $niddles = preg_split("[_]", $className);
        $className = "Development_Helper_Api_{$niddles[count($niddles)-1]}";

        if (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {
            App::Load("Module/Webservice")
                ->setClassName($className)
                ->loadServer();
        }
        else {
            if ($service) {
                echo App::Load("Module/Webservice")
                    ->setClassName($className)
                    ->setServiceName("appRain")
                    ->showWSDL();
            }
            else {
                echo App::Load("Module/Webservice")
                    ->setClassName($className)
                    ->setServiceName("appRain")
                    ->showWSDLURI();
            }
        }
    }

    public function clearcacheAction()
    {
        $this->setAdminTab('developer');

        $message = "";
        $cacheAllDef = App::Load("Module/Developer")->setCacheAllDef();
        $def = Array("" => "All");

        foreach ($cacheAllDef as $key => $val) {
            $def[$key] = $val['title'];
        }

        if (!empty($this->data)) {
            App::Load("Module/Developer")
                ->setCacheType($this->data['Cache']["type"])
                ->clearCache();

            App::Module('Notification')->Push($this->__("Temporary Cache has been cleared successfully."));
        }

        $this->set('cacheAllDef', $def);
    }

    public function languageswitchAction($code = "")
    {
        App::Module('Language')->setDefault($code);
        $this->redirect("/developer/language");
        exit;
    }


    /**
     * Manage Language
     */
    public function languageAction($lang_file = NULL)
    {
        $this->setAdminTab('developer');

        /**
         * Update Language
         * file as per POST
         * request
         */
        if (!empty($_POST)) {
            $_dom = new DomDocument();
            $_language = $_dom->createElement('Language');
            $_language = $_dom->appendChild($_language);

            /* Base Section */
            $_base = $_dom->createElement('base');
            $_base = $_language->appendChild($_base);

            $_code = $_dom->createElement('code');
            $_code->nodeValue = $_POST['data']['code'];
            $_base->appendChild($_code);

            $_title = $_dom->createElement('title');
            $_title->nodeValue = $_POST['data']['title'];
            $_base->appendChild($_title);


            /* Language values */
            $_langs = $_dom->createElement('langs');
            $_langs = $_language->appendChild($_langs);

            foreach ($_POST['data']['lang'] as $order => $lang) {
                if ($lang['key'] != "") {
                    $_lang = $_dom->createElement('lang');
                    $_lang = $_langs->appendChild($_lang);

                    $_key = $_dom->createElement('key');
                    $_key->nodeValue = $lang['key'];
                    $_key = $_lang->appendChild($_key);

                    $_val = $_dom->createElement('val');
                    $_val->nodeValue = $lang['value'];
                    $_key = $_lang->appendChild($_val);
                }
            }

            $path = App::Module('Language')->lanuagePaths(App::Helper('utility')->getName($lang_file));
            $_dom->save($path . "/{$lang_file}");
        }

        $paths = App::Module('Language')->lanuagePaths();
        $lang_fiels = App::Load('Helper/Utility')->getDirLising($paths);
        $this->set('lang_fiels', $lang_fiels['file']);

        if (isset($lang_file)) {
            $path = App::Module('Language')->lanuagePaths(App::Helper('utility')->getName($lang_file));

            $lan_xml = simplexml_load_file($path . "/{$lang_file}");
            $this->set('xml', $lan_xml);
            $this->set('lang_file', $lang_file);
        }
    }

    public function debug_logAction($mode = 'file', $action = NULL)
    {
        $this->setAdminTab('developer');
		
		$s = isset($this->get['s']) ? $this->get['s'] : '';

        if ($mode == 'file') {
            if ($action == 'clear') {
                App::Helper('Log')->clear('file');
            }
            $logData = App::Helper('Log')->readFullLog();
            $this->set('logData', $logData);
        }
        else {
            if ($action == 'clear') {
                App::Model('Log')->delete();
            }
			
			$cnd = '1=1';
			if(!empty($s)){
				$cnd = "type='{$s}' or data like '%{$s}%' ";
			}

            $logData = App::Model('Log')->paging("{$cnd} ORDER BY id DESC");
            $this->set('logData', $logData);
        }
        $this->set('mode', $mode);
        $this->set('s', $s);
    }

    public function componentsOnlineAction($action = null)
    {
        if ($action == 'refresh') {
            App::Module('Cache')->delete('componentonline');
            $this->redirect('/developer/componentsonline');
            exit;
        }
        $this->setAdminTab('component');
        $src_key = isset($this->get['src_key']) ? $this->get['src_key'] : null;
        $onlineComponent = app::__def()->onlinecomponentList($src_key);
        $this->set('onlineComponent', $onlineComponent);
    }

    public function componentsAction($classname = null, $action = null)
    {
        $this->setAdminTab('component');
        $this->addons = array('dialogs');

        $paginglink = isset($this->get['page'])
            ? "?page={$this->get['page']}" : "";

        if ($action == 'changestatus') {
            App::Component($classname)->chnageStatus();

            if (App::Component($classname)->status() == appRain_Base_component::STATUS_ACTIVE) {
                App::Module('Notification')->Push("'{$classname}' Component Deactivated successfully");
            }
            else {
                App::Module('Notification')->Push("'{$classname}' Component Activated successfully");
            }

            App::Module("Developer")->clearCache();
            $this->redirect("/developer/components/{$paginglink}#{$classname}");
            exit;
        }
        else if ($action == 'remove') {
            if (App::Component($classname)->status() == appRain_Base_component::STATUS_ACTIVE) {
                App::Component($classname)->chnageStatus();
            }

            $obj = App::Module('Universal_Installer')
                ->setResourcePath(COMPONENT_PATH . DS . $classname)
                ->Uninstall();

            App::Module('Notification')->Push("'{$classname}' Component removed successfully");
            App::Module("Developer")->clearCache();
            $this->redirect("/developer/components/{$paginglink}#{$classname}");
            exit;
        }
        else if ($action == 'install') {
            $this->install_component();

            App::Module("Developer")->clearCache();

            App::Module('Notification')->Push("Component removed successfully");
            App::Module("Developer")->clearCache();
            $this->redirect("/developer/components");
            exit;
        }

        $componentlist = App::Load("Helper/Utility")->multiArraySort(app::__def()->getComponentList(), 'name', 'ASC');
        $componentlist = App::Load("Helper/Utility")->array_paginator($componentlist, array('limit' => "10"));
        $this->set('componentlist', $componentlist);

        $this->set('paginglink', $paginglink);
        $this->set('action', $action);
    }

    private function install_component()
    {

        $this->setAdminTab('component');
        $message = "";
        $error = "";
        if (!empty($this->data)) {
            if (!is_writable(COMPONENT_PATH . DS)) {
                App::Module('Notification')->Push("Component path is not writeable :" . COMPONENT_PATH . DS, 'Error');
            }
            else if ($this->data['Component']['resourcefile']['tmp_name'] == "") {
                App::Module('Notification')->Push("Select a component file please.. ", 'Error');
            }
            else {

                $obj = App::Module('Universal_Installer')
                    ->setSourceAutoDelete(true)
                    ->setDefaultInstallationPath(COMPONENT_PATH)
                    ->upload($this->data['Component']['resourcefile'])
                    ->Install();

                if (empty($obj->errors)) {
                    App::Module('Notification')->Push('Component installed successfully');
                }
                else {
                    App::Module('Notification')->Push($obj->errors, 'Error');
                }
            }
            $this->redirect("/developer/components");
            exit;
        }
    }

    public function uinstallarftpAction()
    {
        $this->check_admin_login();
        $flag = false;
        if (strtolower($this->data['FTP']['status']) == 'enable') {
            $ftp = App::Module('Ftp');
            $ftp->SetServer($this->data['FTP']['server']);
            $ftp->connect();
            $flag = $ftp->login($this->data['FTP']['username'], $this->data['FTP']['password']);

        }

        if ($flag == true || $this->data['FTP']['status'] == 'Disabled') {
            if (!empty($this->data)) {
                App::Config()->setSiteInfo('ftpserver', $this->data['FTP']['server'])
                    ->setSiteInfo('ftpusername', $this->data['FTP']['username'])
                    ->setSiteInfo('ftppassword', $this->data['FTP']['password'])
                    ->setSiteInfo('ftpport', $this->data['FTP']['port'])
                    ->setSiteInfo('ftpstatus', $this->data['FTP']['status']);
            }
            echo "1";
        }
        exit;
    }
	
	public function closewidgetAction($id){
		$this->check_admin_login();
		App::Config()->setSiteInfo($id,'No');
	}
	
	public function exceptionAction($id=null)
	{
		$this->layout = 'admin';
		$this->set('admin_content_full_length', true);
        $this->set('disable_admin_header', true); 	  
		$this->set('id',$id);
	}
	
	public function addonsAction($action=null,$name=null){
		$this->setAdminTab('developer');
		
		if($action=='update'){
			App::Module('Addon')->updateAddon($name,$this->data['Addon']);
			App::Module('Notification')->Push('Addon updated successfully');	
			$this->redirect("/developer/addons?page=" . (isset($this->get['page']) ? $this->get['page'] : '1'));
		}
		
		if (!empty($this->data)) {
			$path = App::Config()->baseDir( DS . "addons" . DS);
            if (!is_writable($path)) {
                App::Module('Notification')->Push("Addon path is not writeable :" . $path , 'Error');
            }
            else if ($this->data['Addon']['resourcefile']['tmp_name'] == "") {
                App::Module('Notification')->Push("Select a addon file please.. ", 'Error');
            }
            else {

                $obj = App::Module('Universal_Installer')
                    ->setSourceAutoDelete(true)
                    ->setDefaultInstallationPath(App::Config()->baseDir( DS . "addons"))
					->setSourceOverwrite(true)
                    ->upload($this->data['Addon']['resourcefile'])
                    ->Install();

                if (empty($obj->errors)) {
                    App::Module('Notification')->Push('Addon installed successfully');
                }
                else {
                    App::Module('Notification')->Push($obj->errors, 'Error');
                }
            }
            $this->redirect("/developer/addons");
            exit;
        }
		
		$addonList = App::Module('Addon')->pathWiseAddonList();
		$list = array();
		foreach($addonList as $row){
			$list = array_merge($list,$row['list']);
		}
		$addonList = App::Helper('Utility')->array_paginator($list, array('limit' => 10));
		$this->set('addonList',$addonList);
		
		$paths = App::Module('Language')->lanuagePaths();
        $lang_fiels = App::Load('Helper/Utility')->getDirLising($paths);
        $this->set('lang_fiels', $lang_fiels['file']);
	}	
	
	public function informationsetAction(){
		$this->setAdminTab('developer');		
		$inforList = App::Module('Developer')->pathWiseInformationSetList();
		$this->set('inforList',$inforList);
	}	
}