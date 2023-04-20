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
 * @copyright  Copyright (c) 2010 appRain, Tean. (http://www.apprain.org)
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
 * appRain Core lib class
 *
 * @author appRain, Inc.
 */
class appRain_Collection extends Development_Callbacks {

    public $__menu = Array();

    /**
     * Retrun Site URL
     * Alies of App::Load("Helper/Config")->Load()->baseurl()
     *
     * @param $sub_part String
     * @param $secure Boolean
     */
    public function baseurl($sub_part = NULL, $secure = false) {
        return app::load("Helper/Config")->Load()
                        ->baseurl($sub_part, $secure);
    }

    /**
     * Retrun Skin(Theme) URL
     * Alies Of App::Load("Helper/Config")->Load()->skinurl()
     *
     * @param $sub_part String
     * @param $secure Boolean
     */
    public function skinurl($sub_part = NULL, $secure = false) {
        return App::Load("Helper/Config")->Load()->skinurl($sub_part, $secure);
    }

    public function rootDir($sub_part = NULL) {
        return App::Load("Helper/Config")->Load()->rootDir($sub_part);
    }

    /**
     * Retrun Base Directory Path
     * Alies of Ap::Load("Helper/Config")->Load()->basedir();
     *
     * @param $sub_part String
     */
    public function basedir($sub_part = NULL) {
        return App::Load("Helper/Config")->Load()->basedir($sub_part);
    }

    /**
     * Return Theme Directory Path
     * Alies of App::Load("Helper/Config")->Load()->skindir()
     *
     * @param $sub_part String
     */
    public function skindir($sub_part = NULL) {
        return App::Load("Helper/Config")->Load()->skindir($sub_part);
    }

    /**
     * Fetch File Manage Path
     *
     * @param $image_name String
     * @return String
     */
    public function get_img_url($image_name = '') {
        return $this->baseurl("/" . $this->get_config('filemanager_path') . '/' . $image_name);
    }

    /**
     * Fetch File Manage Path
     *
     * @param $image_name String
     * @return String
     */
    public function get_img_dir($image_name = '') {
        return $this->basedir("/" . $this->get_config('filemanager_path') . '/' . $image_name);
    }

    /**
     * Generate HTML Tag
     * Alies of App::Load("Helper/Html")->get_tag()
     *
     * @param $tag String
     * @param $options Array
     * @param $innerHtml String
     */
    public function get_tag($tag = NULL, $options = NULL, $innerHtml = NULL) {
        return App::Load("Helper/Html")->get_tag($tag, $options, $innerHtml);
    }

    /**
     * Get File Manage Path for Supper Admin/User
     * This function create a directory for user if that does not exsits in specific path
     *
     * @param $path String
     */
    public function filemanager_path() {
        $filemanager_base_dir = App::Config()->BaseDir(DS .
                App::Config()->get('filemanager_base_dir')
        );
        return $filemanager_base_dir;
    }

    /**
     * -Redirect the control
     * - We need to send the subpart of the url here. This public function automatically add base url with give part of url
     * Exampel: redirect('admin/login')
     *
     * @param $url_part String
     * @param $mode String
     * @param $https Boolean
     */
    public function redirect($url_part = "", $mode = "header", $https = false) {
        App::Helper('Config')->redirect($url_part, $mode, $https);
    }

    /**
     * Redirect control with message display.
     * We also can set some post data
     */
    public function transfer($redirectUrl = NULL, $message = null) {
        App::Helper('Config')->setPostVars($this->getPostVars())
                ->transfer($redirectUrl, $message);
    }

    /**
     *    A sudo function to check admin logged in status
     */
    public function check_admin_login() {
        if ($this->isByPassTrue())
            return true;

        $admin_info = App::Load("Module/Session")->read('User');
		if(empty($admin_info)){
			$this->redirect('/admin/exception_here');
		}
		
        $admin_info['status'] = isset($admin_info['status']) ? $admin_info['status'] : '';
        if ($admin_info['status'] != 'Admin') {
            $this->writeRequestURI();
            $this->redirect('/admin/exception_here');
            exit;
        }
    }

    /**
     * Verify Bypass request
     */
    public function isByPassTrue() {
        $SuperAuthByPassFlag = App::Module('Session')->read('SuperAuthByPassFlag');
        $SuperAuthByPassFlag = isset($SuperAuthByPassFlag) ? $SuperAuthByPassFlag : false;
        return $SuperAuthByPassFlag;
    }

    public function hasRequestURI() {
        $_redirectToRequestURI = App::Load("Module/Session")->read("_redirectToRequestURI");
        return ($_redirectToRequestURI == "") ? false : true;
    }

    public function writeRequestURI() {
        App::Load("Module/Session")->write("_redirectToRequestURI", App::Load("Helper/Config")->getServerInfo("REQUEST_URI"));
    }

    public function redirectToRequestURI() {
        $redirectURI = App::Load("Helper/Config")->get('http') . App::Load("Helper/Config")->get('host') . App::Load("Module/Session")->read("_redirectToRequestURI");
        App::Load("Module/Session")->delete("_redirectToRequestURI");
        header("location:{$redirectURI}");
        exit;
    }

    public function check_admin_tab_access($tab) {
        $admin_panel_tabs = App::Module('ACL')->readNAVAccess('top');
        // $user = App::Load('Module/Session')->read('User');
        //  $user['admin_panel_tabs'] = isset($user['admin_panel_tabs']) ? $user['admin_panel_tabs'] : Array();
        return in_array($tab, $admin_panel_tabs);
    }

    public function setAdminTab($tab = "") {
		
        $this->check_admin_login();
		
        if ($this->check_admin_tab_access($tab)) {
			
            $this->layout = "admin";
            $this->admin_tab = $tab;
        } else {
			pre('You don\'t have permission @ ' . $tab); // . Collection.php line 211
            $this->redirect("/admin/introduction");
        }
    }

    /**
     * Check if a user alrady logged in
     *
     * @param $type String
     */
    public function user_already_loggedin($type = 'Admin') {
        $admin_info = App::Load("Module/Session")->read('User');
		if(empty($admin_info)){
			return false;
		}
        $admin_info['status'] = isset($admin_info['status']) ? $admin_info['status'] : "";
        if ($admin_info['status'] == $type) {
            $this->redirect('/admin/introduction');
            exit;
        }
    }

    /**
     * Check User Login
     *
     * @return boolean
     */
    public function check_user_login($uri = '/') {
        $admin_info = App::Load("Module/Session")->read('User');
        $admin_info['status'] = isset($admin_info['status']) ? $admin_info['status'] : '';

        if ($admin_info['status'] != 'User' && $admin_info['status'] != 'Admin') {
            $this->redirect($uri);
            exit;
        }
    }

    /**
     * Is logged in
     *
     * @return boolean
     */
    public function is_user_logged_in() {
        $user_info = App::Load("Module/Session")->read('User');
        $admin_info['status'] = isset($admin_info['status']) ? $admin_info['status'] : '';

        return ($admin_info['status'] == "User") ? true : false;
    }

    /**
     * Fetch User Setting Set by UserStatusId
     *
     * @param Array
     */
    public function user_settings() {
        return App::Config()->siteInfo();
    }

    /**
     *    This function to return configuration variables
     * @param $skey String
     * @param $load String
     */
    public function get_config($skey = NULL, $load = "site_info") {
        $rtn = NULL;
        switch ($skey) {
            case 'filemanager_path' :
                return App::Config()->fileManagerDir();
                break;
            default:
                return ($load) ?
                        App::Helper("Config")
                                ->load($load)
                                ->get($skey) :
                        App::load("Helper/Config")
                                ->get($skey);
                break;
        }
    }

    /**
     *    This function return current loggedin User Information
     *
     * @return Mix
     */
    public function current_admin_info($select = NULL) {
        $admin_arr = App::Load("Module/Session")->read('User');
        return isset($select) ? $admin_arr[$select] : $admin_arr;
    }

    /**
     * Fetch Admin Navigation Information
     *
     * @return Array
     */
    public function get_admin_nav() {
        return App::Module('ACL')->getInterfaceBuilderDefinition();
    }

    /**
     * Admin tab information
     */
    public function get_admin_links($admin_flag = NULL, $section = NULL) {
        global $admintop_arr;
        global $adminleft_arr;
        $this->set('admintop_arr', $admintop_arr);

        if ($section == 'adminleft') {
            return isset($adminleft_arr[$admin_flag]) ? $adminleft_arr[$admin_flag] : NULL;
        }
    }

    /**
     * Access level of admin Tab
     *
     * @param $admin_type String
     * @return Array()
     */
    public function admin_tab_access($admin_type = NULL) {
        $definiation = $this->get_admin_nav();
        $admin_tab_access = array();
        foreach ($definiation as $key => $val) {
            if (in_array($admin_type, $val['parent']['acl']))
                $admin_tab_access[] = $key;
        }
        return $admin_tab_access;
    }

    public function staticPageNameToMetaInfo($name = NULL) {
        $pageInfo = App::PageManager()->getData($name);

        if (!empty($pageInfo)) {
            $this->page_title = $pageInfo['page_title'];
            $this->page_meta_keyowrds = $pageInfo['meta_keywords'];
            $this->page_meta_desc = $pageInfo['meta_description'];
        }

        return $pageInfo;
    }

    /**
     * Clear menu pool
     *
     * It's good practice to call this function
     * before adding menu nodes.
     */
    public function siteMenuClear() {
        $this->__menu = Array();
        return $this;
    }

    /**
     * Add each menu link
     */
    public function siteMenu($link = "", $title = "_MENU_NAME_", $selected = "") {
        $this->__menu[] = array($link, $this->__($title), $selected);
        return $this;
    }

    /**
     * Render menu
     */
    public function siteMenuRender($renderType = 'HTML', $spage = "", $sClass = 'selected', $nClass = '') {
        $_links = App::Module('Hook')->getHandler('Sitemenu', 'register_sitemenu');

        if (!empty($_links)) {
            foreach ($_links as $lvl1) {
                if (!empty($lvl1)) {
                    foreach ($lvl1 as $link) {
                        $this->__menu[] = $link;
                    }
                }
            }
        }

        $vandordata = App::Module('Hook')->getHandler('Sitemenu', 'update_sitemenu', $this->__menu);
        if (isset($vandordata[0]) and ! empty($vandordata[0])) {
            $this->__menu = $vandordata[0];
        }

        switch (strtoupper($renderType)) {
            case 'HTML' :
                $rootOpts = $this->getRootHtmlOpts();
                $Html = App::Helper('Html');
                $html = "";
                foreach ($this->__menu as $key => $val) {
                    $class = ($val[2] == $spage) ? $sClass . ' ' . $nClass : $nClass;
					$opts = $this->formatedHtmlOptions($this->getLastItemHtmlOpts(), $class);
                    $html .= $this->get_tag("li", $opts, $Html->linkTag($val[0], $this->__($val[1]), array('class' => $class )));
                }
                return $html;
			case 'LI' :
                $rootOpts = $this->getRootHtmlOpts();
                $Html = App::Helper('Html');
                $html = "";
                foreach ($this->__menu as $key => $val) {
                    $class = ($val[2] == $spage) ? $sClass . ' ' . $nClass : $nClass;
					$opts = $this->formatedHtmlOptions($this->getLastItemHtmlOpts(), $class);
                    $html .= $this->get_tag("li", $opts, $Html->linkTag($val[0], $this->__($val[1]), array('class' => $class )));
                }
                return $html;
            default :
                return $this->__menu;
        }
    }

    private function formatedHtmlOptions($opts = array(), $class = "") {
        if (empty($opts) && $class == "") {
            return array();
        }
        return $opts;
    }

}
