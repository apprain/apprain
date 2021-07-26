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
 * @copyright  Copyright (c) 2010 appRain, Inc. (http://www.apprain.org)
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
 * http ://www.apprain.org/documents
 */
class appRain_Base_Modules_Callbacks extends Development_AppCommon {
    /*
     * Callback function
     *
     * Call before page randier
     */

    public function _before_render() {
        $this->before_render();
        App::Module('Hook')->getHandler('Callback', 'before_render');
        if (App::AdminManager()->isLoggedIn()) {
            $this->before_adminpanel_render();
            App::Module('Hook')->getHandler('Callback', 'before_adminpanel_render');
        }
    }

    /*
     * Callback function
     *
     * Run after page render complete
     */

    public function _after_render() {
        $this->after_render();
        App::Module('Hook')->getHandler('Callback', 'after_render');

        if (App::AdminManager()->isLoggedIn()) {
            $this->after_adminpanel_render();
            App::Module('Hook')->getHandler('Callback', 'after_adminpanel_render');
        }

        $this->printQuries();
    }

    /**
     * Callback function
     *
     * Before an addon load complete
     */
    public function _before_addon_load($name = NULL) {
        $this->before_addon_load($name);
        App::Module('Hook')->getHandler('Callback', 'before_addon_load', $name);
    }

    /**
     * Callback function
     *
     * After an addon load
     */
    public function _after_addon_load($name = NULL) {
        $this->after_addon_load($name);
        App::Module('Hook')->getHandler('Callback', 'after_addon_load', $name);
    }

    /**
     * Information Set call back function.
     * Run when we view information set
     *
     * @param fixedArray
     */
    public function _on_information_set_view($options = NULL) {
        $this->on_information_set_view($options);
        App::Module('Hook')->getHandler('Callback', 'on_information_set_view', $options);
    }

    /*
     * Callback function
     *
     * Run when any Information Set entry delete
     */

    public function _on_information_set_delete($options = NULL) {
        $this->on_information_set_delete($options);
        App::Module('Hook')->getHandler('Callback', 'on_information_set_delete', $options);
    }

    /*
     * Callback function
     *
     * Run before Information Set entry Save
     */

    public function _before_information_set_save($options = NULL) {
        $this->before_information_set_save($options);
        App::Module('Hook')->getHandler('Callback', 'before_information_set_save', $options);
    }

    /*
     * Callback function
     *
     * Run after Information Set entry save
     */

    public function _after_information_set_save($options = NULL) {
        $this->after_information_set_save($options);
        App::Module('Hook')->getHandler('Callback', 'after_information_set_save', $options);
    }

    /*
     * Callback function
     *
     * Run before search data initialized
     */

    public function _before_search_init($send = NULL) {
        $this->before_search_init($send);
        App::Module('Hook')->getHandler('Callback', 'before_search_init', $send);
    }

    /*
     * Callback function
     *
     * Run once auto search initialization complete
     */

    public function _after_search_init($send = NULL) {
        $this->after_search_init($send);
        App::Module('Hook')->getHandler('Callback', 'after_search_init', $send);
    }

    /*
     * Callback function
     *
     * Helps to modify the URL Manager Definition
     */

    public function _on_uri_definition_init($send = NULL) {
        $_send = $this->on_uri_definition_init($send);
        if (is_array($_send) && !empty($_send))
            $send = $_send;

        $defs = App::Module('Hook')->getHandler('Callback', 'on_uri_definition_init', null, 'object');
        foreach ($defs as $def) {
            $method = $def['method'];
            $_send = $def['_obj']->$method($send);
            if (is_array($_send) && !empty($_send)) {
                $send = $_send;
            }
        }
        return $send;
    }

    public function _on_theme_remove($name = null) {
        $themeInfo = app::__def()->getThemeInfo($name);
        if (!empty($themeInfo['callback'])) {
            App::__Obj($themeInfo['callback'])->on_theme_remove($themeInfo);
        }
    }

    public function _before_theme_load($_Obj = null) {
        $themeInfo = app::__def()->getThemeInfo($_Obj->theme);
		if(!isset($themeInfo['callback'])){
			return ;
		}
        App::__Obj($themeInfo['callback'])->before_theme_load($_Obj);
    }

    public function _after_theme_load($_Obj = null) {
        $themeInfo = app::__def()->getThemeInfo($_Obj->theme);
		if(!isset($themeInfo['callback'])){
			return ;
		}
        App::__Obj($themeInfo['callback'])->after_theme_load($_Obj);
    }

    public function _before_theme_install($name = null, $def = null) {
        $themeInfo = app::__def()->getThemeInfo($name);
        if (!empty($themeInfo['callback'])) {
            App::__Obj($themeInfo['callback'])->before_theme_install($themeInfo);
        }
        App::Module('Hook')->getHandler('Callback', 'before_theme_install', $themeInfo);
        $com2Uninstall = isset($themeInfo['components']['auto']['uninstall']) ? $themeInfo['components']['auto']['uninstall'] : Array();
        if (!empty($com2Uninstall)) {
            foreach ($com2Uninstall as $component) {
                if (App::Component($component)->status() == appRain_Base_component::STATUS_ACTIVE) {
                    App::Component($component)->chnageStatus();
                }
            }
        }
    }

    public function _after_theme_installed($name = null, $def = null) {
        $themeInfo = app::__def()->getThemeInfo($name);
        if (!empty($themeInfo['callback'])) {
            App::__Obj($themeInfo['callback'])->after_theme_installed($themeInfo);
        }
        App::Module('Hook')->getHandler('Callback', 'after_theme_install', $themeInfo);
        $com2Install = isset($themeInfo['components']['auto']['install']) ? $themeInfo['components']['auto']['install'] : Array();
        if (!empty($com2Install)) {
            foreach ($com2Install as $component) {
                if (App::Component($component)->status() == appRain_Base_component::STATUS_INACTIVE) {
                    App::Component($component)->chnageStatus();
                }
            }
        }
    }

    private function printQuries() {
        if (!empty(App::$__appData['dbQuries'])) {
            pr("SL  Query");
            foreach (App::$__appData['dbQuries'] as $key => $query) {
                pr(($key + 1) . ". {$query[0]}");
            }
        }
    }

}
