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
interface IEexception {
    /* Protected methods inherited from Exception class */

    public function getMessage(); // Exception message

    public function getCode(); // User-defined Exception code

    public function getFile(); // Source filename

    public function getLine(); // Source line

    public function getTrace(); // An array of the backtrace()

    public function getTraceAsString(); // Formated string of trace

    /* Overrideable methods inherited from Exception class */

    public function __toString(); // formated string for display

    public function __construct($message = null, $code = 0);
}

abstract class CustomizeAppException extends Exception implements IEexception {

    protected $message = 'Unknown exception'; // Exception message
    private $string; // Unknown
    protected $code = 0; // User-defined exception code
    protected $file; // Source filename of exception
    protected $line; // Source line of exception
    private $trace; // Unknown

    public function __construct($message = null, $code = 0) {
        parent::__construct($message, $code);
    }

    public function __toString() {
        return get_class($this)
                . " {$this->message}\n"
                . "{$this->getTraceAsString()}";
    }

}

class AppException extends CustomizeAppException {
    
}
