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

if (version_compare(phpversion(), '5.1.0', '<') === true) {
    die("<strong>Whoops, it looks like you have an invalid PHP version.</strong><br /><span>appRain supports PHP 5.1.0 or newer.</span>");
}

$appLoc = dirname(__FILE__) . "/../app.php";

if (!file_exists($appLoc)) {
    die("appRain core file(s) missing... Get a new copy ");
}

require_once $appLoc;

try {
    App::Load("Module/Cronjob")->Run();
}
catch (AppException $err) {
    die($err->__toString());
}