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

class Apprain_Base_Model extends Apprain_Base_appModel
{
    public function _beforeSave($send = NULL)
    {
    }

    public function _afterSave($send = NULL)
    {
    }

    public function _beforeDelete($send = NULL)
    {
    }

    public function _afterDelete($send = NULL)
    {
    }

    public function _onValidationSuccess($send = NULL)
    {
    }

    public function _onValidationFailed($send = NULL)
    {
    }

    public function DBPrefix($cname = null)
    {
        if (!isset($cname)) {
            $cname = (isset($this->conn)) ? $this->conn : appRain_Base_Abstract::PRIMARY;
        }

        return isset(App::$__appData["db_prefix"][$cname]) ? App::$__appData["db_prefix"][$cname] : appRain_Base_Abstract::_APP;
    }
}
