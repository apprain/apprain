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

function userErrorHandler($errno, $errmsg, $filename, $linenum, $vars)
{
    // timestamp for the error entry
    $dt = date("Y-m-d H:i:s (T)");

    // define an assoc array of error string
    $errortype = array(
        E_ERROR => "Error",
        E_WARNING => "Warning",
        E_PARSE => "Parsing Error",
        E_NOTICE => "Notice",
        E_CORE_ERROR => "Core Error",
        E_CORE_WARNING => "Core Warning",
        E_COMPILE_ERROR => "Compile Error",
        E_COMPILE_WARNING => "Compile Warning",
        E_USER_ERROR => "User Error",
        E_USER_WARNING => "User Warning",
        E_USER_NOTICE => "User Notice",
        E_STRICT => "Runtime Notice"
    );

    // set of errors for which a var trace will be saved
    $user_errors = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);

    $errortype[$errno] = isset($errortype[$errno]) ? $errortype[$errno] : '';
    $err = "<errorentry>\n";
    $err .= "\t<datetime>" . $dt . "</datetime>\n";
    $err .= "\t<errornum>" . $errno . "</errornum>\n";
    $err .= "\t<errortype>" . $errortype[$errno] . "</errortype>\n";
    $err .= "\t<errormsg>" . $errmsg . "</errormsg>\n";
    $err .= "\t<scriptname>" . $filename . "</scriptname>\n";
    $err .= "\t<scriptlinenum>" . $linenum . "</scriptlinenum>\n";

    if (in_array($errno, $user_errors)) {
        $err .= "\t<vartrace>" . wddx_serialize_value($vars, "Variables") . "</vartrace>\n";
    }
    $err .= "</errorentry>\n\n";

    if (app::__def()->sysConfig('DEBUG_MODE') > 0) {
        try {
            throw new AppException('Trace:');
        }
        catch (AppException $e) {
			App::Session()->Write('Exception2Display',"{$e->__toString()}");
			App::__transfer("/developer/exception/syntexerro?arg[]={$errmsg}");			
        }
    }

    if (ucfirst(app::__def()->sysConfig('ERROR_REPORT_MODE')) == "Save") {
        error_log($err, 3, REPORT_CACHE_PATH . DS . date("Y-m-d_") . "error.log");
    }
    else if (ucfirst(app::__def()->sysConfig('ERROR_REPORT_MODE')) == "Email") {
        mail(App::Load("Helper/Config")->Load("site_info")->get("support_email"), "Critical User Error", $err);
    }
}

function pr($v = NULL)
{
    $v = isset($v) ? $v : "";
    if ($v) {
        echo "<pre>";
        print_r($v);
        echo "</pre>";
    }
}


function vd($v = NULL)
{
    $v = isset($v) ? $v : "";
    if ($v) {
        echo "<pre>";
        var_dump($v);
        echo "</pre>";
    }
}

function pre($var = NULL)
{
    pr($var);
    exit;
}

function vde($var = NULL)
{
    vd($var);
    exit;
}

function show_debug($msg = NULL, $level = NULL)
{
    if (strstr($level, DEBUG_MODE)) {
        pr($msg);
    }
}