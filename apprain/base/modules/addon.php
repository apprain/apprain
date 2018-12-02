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
class appRain_Base_Modules_addon extends appRain_Base_Objects {

    public function pathWiseAddonList($addonname = null) {
        $addonPathList = App::__def()->readAddonPath();

        $List = array();
        foreach ($addonPathList as $path) {
            $defList = App::__def()->readaddonsfromhook($path);

            $groupList = array();
            foreach ($defList as $name => $def) {
                $groupList[$name] = $def;
            }

            if (isset($groupList[$addonname]) and isset($addonname)) {
                $groupList[$addonname]['path'] = $path;
                return $groupList[$addonname];
            }

            $List[] = array(
                'path' => str_replace(App::Config()->rootDir(), '', $path),
                'list' => $groupList
            );
        }

        return $List;
    }

    public function updateAddon($name = null, $values = null) {
        if (!isset($name)) {
            return;
        }
        $_addon = $this->pathWiseAddonList($name);
        $dom = new DomDocument();
        $dom->load($_addon['path']);
        $addons = $dom->getElementsByTagName('addon');
        foreach ($addons as $key => $addon) {
            if ($addon->getAttribute('name') == $name) {
                $dom->getElementsByTagName('status')->item($key)->nodeValue = $values['status'];
                $dom->getElementsByTagName('load')->item($key)->nodeValue = $values['load'];
                $dom->getElementsByTagName('layouts')->item($key)->nodeValue = $values['layouts'];
                $dom->getElementsByTagName('layouts_except')->item($key)->nodeValue = $values['layouts_except'];
            }
        }
        $dom->Save($_addon['path']);
        App::Module('Developer')->setCacheType('addon')->clearCache();
    }

}
