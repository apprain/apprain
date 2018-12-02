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
class appRain_Base_Modules_component extends appRain_Base_Objects {

    // Singleton counter
    private $totalCount = 0;
    private $activeCount = 0;
    private $inactiveCount = 0;

    const ACTIVE = 'Active';
    const INACTIVE = 'Inactive';
    const ALL = 'All';

    public function count($status = self::ALL) {
        $list = app::__def()->getComponentList();

        if (!empty($list) && !$this->totalCount) {
            foreach ($list as $component) {
                $this->totalCount++;
                if (strtolower($component['status']) == strtolower(self::INACTIVE)) {
                    $this->inactiveCount++;
                } else {
                    $this->activeCount++;
                }
            }
        }

        if (strtolower($status) == strtolower(self::INACTIVE)) {
            return $this->inactiveCount;
        } else if (strtolower($status) == strtolower(self::ACTIVE)) {
            return $this->activeCount;
        } else {
            return $this->totalCount;
        }
    }

    public function exists($name = null) {
        $list = app::__def()->getComponentList();
        return isset($list[$name]);
    }

}
