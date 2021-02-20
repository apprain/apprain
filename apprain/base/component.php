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
class appRain_Base_component extends appRain_Base_Objects {

    const STATUS_ACTIVE = 'Active';
    const STATUS_INACTIVE = 'Inactive';
    const COMPONENT = 'Component';
    const BOOT_FILE = 'register';

    public $helper_path = "helpers";
    private $listSingleTone = Array();

    /**
     * FUNCTION Called each time it activate
     */
    protected function init() {
        
    }

    /**
     * FUNCTION Called each time it installed
     */
    protected function init_on_install() {
        
    }

    /**
     * Function run on uninstall
     */
    protected function init_on_uninstall() {
        
    }

    public function getCoreResourceInstance() {
        if (empty(App::$__appData['ComponentCoreResourceInstance'])) {
            $List = App::Model('CoreResource')->findAllByType(self::COMPONENT);
            foreach ($List['data'] as $row) {
                App::$__appData['ComponentCoreResourceInstance'][$row['name']] = $row;
            }
        }

        return isset(App::$__appData['ComponentCoreResourceInstance'][$this->getNameSpace()]) ? App::$__appData['ComponentCoreResourceInstance'][$this->getNameSpace()] : null;
    }

    public function status() {
        if (!$this->getStatus()) {
            $coreResource = $this->getCoreResourceInstance();
            $status = isset($coreResource['status']) ? $coreResource['status'] : self::STATUS_INACTIVE;
            $info = Array();
            if (!empty($coreResource['info'])) {
                $info = unserialize($coreResource['info']);
            }
            $this->setStatus($status);
            $this->setInstallDate(isset($info['installdate']) ? $info['installdate'] : $this->getNewInstallationDate());
        }
        return $this->getStatus();
    }

    public function chnageStatus($newstatus = 'toggle') {
        $coreResource = $this->getCoreResourceInstance();

        if ($newstatus == 'toggle') {
            $newstatus = ($this->getStatus() == self::STATUS_ACTIVE) ? self::STATUS_INACTIVE : self::STATUS_ACTIVE;
        }


        $ID = isset($coreResource['id']) ? $coreResource['id'] : null;
        $data = serialize(Array('installdate' => $this->getNewInstallationDate()));
        App::Model('CoreResource')
                ->setId($ID)
                ->setStatus($newstatus)
                ->setName($this->getNameSpace())
                ->setVersion($this->getVersion())
                ->setType(self::COMPONENT)
                ->setInfo($data)
                ->Save();

        $this->excuteInstallerCallbacks($newstatus);

        return $this;
    }

    private function getNewInstallationDate() {
        return date('Y-m-d H:i:s');
    }

    protected function attachMyPath($p = null) {
        return ($p) ? $this->getMyPath() . DS . $p : $this->getMyPath();
    }

    protected function excuteInstallerCallbacks($staus) {
        switch ($staus) {
            case self::STATUS_ACTIVE :
                $this->init_on_install();
                break;
            case self::STATUS_INACTIVE :
                $this->init_on_uninstall();
                break;
        }
    }

    public function Helper($name) {
        $path = $this->getMypath() . DS . $this->helper_path . DS . $name . SEXT;
        return App::__pathToClass($path);
    }

    public function autoRegisterAdminTopNav($tab) {
        $User = App::Module('Session')->read('User');
        if (!in_array($tab, $User['admin_panel_tabs'])) {
            $User['admin_panel_tabs'][] = $tab;
            App::Module('Session')->Write('User', $User);
        }
    }

}
