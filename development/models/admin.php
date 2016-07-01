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


class adminModel extends appRain_Base_Model
{
    /*
     * Model Version
     * This flag will help you to run latest installer
     */
    public $version = "0.1.0";

    /*
     * Model Name that we used to perform database operations
     * Note: Generall we used Capitalize format that
     */
    public $name = "Admin";

    /*
     * Database table name
     * Use Boolean False if there is not spacific tablse
     *
     * Note: Skip Table Prefix
     */
    public $db_table = "administrators";

    /*
     * Database Table Relation
     */
    protected $relation = array();

    /*
     * Database table validation
     * Keepit empty for no-restriction
     */
    protected $model_validation = Array(
        "username" => array(Array("rule" => "unique", "message" => "Username already Exists")),
        # TO ENABLE PASSWORD COMPLEXY CHECK
        #"password"     => Array("rule"=>"password","message"=>"Invalide Admin Password <br />(Valid password length is 8 characther with combination of :A-Za-z0-1)"),
        "email" => Array("rule" => "email", "message" => "Invalide Email Address"),
    );
}