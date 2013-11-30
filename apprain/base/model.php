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
 * @copyright  Copyright (c) 2010 appRain, Team. (http://www.apprain.com)
 * @license    http://www.opensource.org/licenses/mit-license.php MIT license
 *
 * HELP
 *
 * Official Website
 * http://www.apprain.com/
 *
 * Download Link
 * http://www.apprain.com/download
 *
 * Documents Link
 * http ://www.apprain.com/docs
 */

class Apprain_Base_Model extends Apprain_Base_appModel
{
    protected function _beforeSave($send = NULL)
    {
    }

    protected function _afterSave($send = NULL)
    {
    }

    protected function _beforeDelete($send = NULL)
    {
    }

    protected function _afterDelete($send = NULL)
    {
    }

    protected function _onValidationSuccess($send = NULL)
    {
    }

    protected function _onValidationFailed($send = NULL)
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
