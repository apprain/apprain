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

$AUTO_STRT_INSTALL_OFF = true;
require_once "../../app.php";

$Appi = App::__obj('Webroot_Install_Appinstaller');
$Config = App::Helper('Config');
$step = isset($Config->get['step']) ? $Config->get['step'] : 0;

echo $Appi->getheader();
echo $Appi->getstepsUI($step);
echo $Appi->getactionUI($step);
echo $Appi->getfooter();