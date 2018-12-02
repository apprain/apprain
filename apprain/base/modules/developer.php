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
 * CornJob Scheduler
 *
 * @author appRain Team
 */
class appRain_Base_Modules_Developer extends appRain_Base_Objects {

    public function clearcache() {
        if ($this->getCacheType()) {
            $this->clearCacheByDir($this->getCacheType());
        } else {
            $this->clearAllCache();
        }

        #//App::Module('Notification')->Push($this->__("System Cache cleared automaticaly."),array('level'=>'Notice'));
        #//App::Module('Notification')->Push($this->__("System Cache cleared automaticaly."),array('type'=>'admin-notice','level'=>'Notice'));
    }

    private function clearAllCache() {
        $paths = $this->setCacheAllDef();

        foreach ($paths as $cacheType => $path) {
            $this->clearCacheByDir($cacheType);
        }
    }

    private function clearCacheByDir($type) {
        $dirs = App::Load("Helper/Utility")->getDirLising($this->setCacheAllDef($type));

        if (isset($dirs['file'])) {
            foreach ($dirs['file'] as $filename) {
                App::Load("Helper/Utility")->deleteFile($this->setCacheAllDef($type, $filename['name']));
            }
        }
    }

    public function cacheSpaceEstimate() {
        $defs = $this->setCacheAllDef();
        $data = Array();
        foreach ($defs as $defKey => $def) {
            $dirInfo = App::Load("Helper/Utility")->getDirLising($def['path']);
            $size = 0;
            if (isset($dirInfo['file'])) {
                foreach ($dirInfo['file'] as $file) {
                    $filepath = $this->setCacheAllDef($defKey, $file['name']);
                    $size += filesize($filepath) / 1024;
                }
            }
            $defs[$defKey]['size'] = round($size, 2);
        }
        return $defs;
    }

    public function setCacheAllDef($path_key = "", $subpart = "") {
        $cachedef = Array(
            "addon" => array(
                "title" => "Addon",
                "path" => ADDON_CACHE_PATH
            ),
            "category_set" => array(
                "title" => "CategorySet",
                "path" => CATEGORYSET_CACHE_PATH
            ),
            "information_set" => array(
                "title" => "InformationSet",
                "path" => INFORMATIONSET_CACHE_PATH
            ),
            "interfacebuilder" => array(
                "title" => "Interface Builder",
                "path" => INTERFACEBUILDER_CACHE_PATH
            ),
            "language" => array(
                "title" => "Language",
                "path" => LANGUAGE_CACHE_PATH
            ),
            "model" => array(
                "title" => "Model",
                "path" => MODEL_CACHE_PATH
            ),
            "sitesettings" => array(
                "title" => "Site Setting",
                "path" => SITESETTINGS_CACHE_PATH
            ),
            "urimanager" => array(
                "title" => "URI Manage",
                "path" => URIMANAGER_CACHE_PATH
            ),
            "wsdl" => array(
                "title" => "Webservice",
                "path" => WSDL_CACHE_PATH
            ),
            "report" => array(
                "title" => "Error Reporting",
                "path" => REPORT_CACHE_PATH
            ),
            "byte_stream" => array(
                "title" => "Manual Cache",
                "path" => BYTE_STREAM
            )
        );
        ksort($cachedef);
        return isset($cachedef[$path_key]) ? $cachedef[$path_key]['path'] . "/" . $subpart : $cachedef;
    }

    public function renderExceptionString($HelpId = null) {

        $arg = isset(App::Config()->get['arg']) ? App::Config()->get['arg'] : array();
        $help = app::__def()->HelpList($HelpId);
        if (!empty($help)) {
            foreach ($arg as $sl => $val) {
                $help['description'] = str_replace("{arg{$sl}}", $val, $help['description']);
            }
            $help['description'] = str_replace("{Exception2Display}", App::Session()->Read('Exception2Display'), $help['description']);
            $help['description'] = App::Helper('Utility')->codeFormated($help['description']);
        } else {
            $help = app::__def()->HelpList('help_not_found');
        }

        return $help;
    }

    public function pathWiseInformationSetList() {
        $addonPathList = App::__def()->fetchInformationSetPathList();
        $List = array();
        foreach ($addonPathList as $path) {
            $def = App::__def()->readInformationSetDefByPath($path);
            $def['base']['path'] = str_replace(App::Config()->rootDir(), '', $path);
            $List[] = $def;
        }
        return $List;
    }

}
