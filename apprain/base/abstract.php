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
 * @copy right  Copyright (c) 2010 appRain, Team. (http://www.apprain.org)
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
abstract class appRain_Base_Abstract {

    private static $__connection = NULL;

    const PRIMARY = 'primary';
    const _APP = 'app_';

    public $_cname = null;

    /**
     * Get the taga object in to the system
     *
     * @return object
     */
    protected function get_conn($cname = null) {
        $this->defineCName($cname);
        if (!isset(App::$__appData["db_connection"][$this->_cname])) {
            try {
                $db_config = $this->readdbconfig();
                App::$__appData["db_connection"][$this->_cname] = App::Module("Database_{$db_config['driver']}_{$db_config['type']}")->Connect($db_config);
            } catch (Exception $e) {
				
				echo "<pre>";
                echo ("<strong>" . $e->getMessage() . "</strong>");
                echo ("\n\n<strong>Hints</strong>\nWe are unable to connect database. Please edit databse definition xml (Path: development/definition/database.xml)");
                echo ("\n\n<strong>Trace:</strong>\n" . $e->getTraceAsString());
                echo "</pre>";
                die();
            }
        }
        return App::$__appData["db_connection"][$this->_cname];
    }

    private function defineCName($cname = null) {
        if (isset($cname)) {
            $this->_cname = $cname;
            return;
        }

        if (isset($this->conn) && $this->conn != 'auto' && !is_bool($this->conn)) {
            $this->_cname = $this->conn;
            return;
        } else {
            $definition = App::__def()->getURIManagerDefinition();
            if (!empty($definition['bootrouter']['connection'])) {
                $this->_cname = $definition['bootrouter']['connection'];
                return;
            }
        }

        $this->_cname = self::PRIMARY;

        return;
    }

    /**
     *  Return Database configuration
     *
     * @parameter null
     * @return array
     */
    public function readdbconfig($key = null, $cname = self::PRIMARY) {
        $cnf = App::Module("definition")
                ->getDBConfig(null, $this->_cname);
        return isset($cnf[$key]) ? $cnf[$key] : $cnf;
    }

}
