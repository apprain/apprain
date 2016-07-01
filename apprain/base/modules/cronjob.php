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

/**
 * CornJob Scheduler
 *
 * @author appRain Team
 */
class appRain_Base_Modules_Cronjob extends appRain_Base_Objects
{
    private $callDefData = Array();
    private $presentTime = NULL;
    private $presentSchedule = "";
    private $scheduleExecute = NULL;

    public function run()
    {
        $this->__init();
        $this->execute();

    }

    private function __init()
    {
        $this->setPresentTime();
        $this->getJobDef();
    }

    private function getJobDef()
    {
        $class = new ReflectionClass("Development_Helper_Cronjob");
        $methods = $class->getMethods();

        foreach ($methods as $method) {
            if ($method->isProtected() && !$method->isConstructor() && strtolower(substr($method->name, -3)) == "job") {
                $this->callDefData[$method->name] = Array(
                    "schedule" => $this->getSchedule($method->getDocComment())
                );
            }
        }
    }

    private function setPresentTime()
    {
        $ss = date("H");
        $se = date("H", (time() + strtotime($ss) + (1 * 60 * 60)));
        $this->presentSchedule = "{$ss}-{$se}";
        $this->presentTime = date("H:m");
    }

    private function getSchedule($c)
    {
        $c = preg_split("/@schedule/", $c);
        $c = preg_split("/\[|\]/", $c[1]);
        $c = preg_split("/ /", $c[1]);
        return $c;
    }

    private function execute()
    {
        foreach ($this->callDefData as $methodName => $methodInfo) {
            if ($this->hasToExecute($methodName)) {
                echo  App::Load("Helper/Cronjob")->$methodName();
            }
        }

        // Execute call back functions
        App::Module('Hook')->getHandler('Cron', 'register_function', $this->presentTime);
    }

    private function hasToExecute($methodName)
    {
        foreach ($this->callDefData[$methodName]["schedule"] as $schedule) {
            if ($schedule == "*") return true;

            $stime = explode("-", $schedule);
            if (
                ($this->presentTime > $stime[0] && $this->presentTime < $stime[1])
                or $schedule == "*"
                or $this->presentTime == $schedule
            ) {
                return true;
            }
        }

        return false;
    }
}
