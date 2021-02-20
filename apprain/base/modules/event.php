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


class appRain_Base_Modules_Event
{
    private $callbacks;

    public function __construct()
    {
        $this->callbacks = array();
    }

    private function Get_Callback($args)
    {
        return (count($args) < 2)
            ? new Callback($args[0], '')
            : new Callback($args[1], get_class($args[0]));
    }

    public function Subscribe()
    {
        $callback = $this->Get_Callback(func_get_args());
        if (!in_array($callback, $this->callbacks)) {
            $this->callbacks[] = $callback;
        }
        else throw new Exception($callback->method . ' already subscribed to this event');
    }

    public function Unsubscribe()
    {
        $callback = $this->Get_Callback(func_get_args());
        $key = array_search($callback, $this->callbacks);
        if (!($key === false)) {
            unset($this->callbacks[$key]);
        }
        else throw new Exception($callback->method . ' not subscribed to this event');
    }

    public function Raise()
    {
        foreach ($this->callbacks as $callback) {
            if (method_exists($callback->context, $callback->method) || function_exists($callback->method)) {
                $params = func_get_args();
                $callback = (!empty($callback->context)) ? array($callback->context, $callback->method) : $callback->method;
                call_user_func_array($callback, $params);
            }
            else throw new Exception($callback->method . " does not exist");
        }
    }
}

class Callback
{
    public $method;
    public $context;

    public function __construct($method, $context)
    {
        $this->method = $method;
        $this->context = $context;
    }
}