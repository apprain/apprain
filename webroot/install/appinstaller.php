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
/**
 * appRain Installer class
 *
 * @author appRain Team
 */
class Webroot_Install_Appinstaller extends appRain_Base_Objects
{
    const DB_FILE_PATH = 'dbsource.sql';
    const PREFIX_REPLACE = "{_prefix_}";
    const REGEXP = '/\-\- query/';
    const DB_RESOURCE = 'dbsource.sql';
    const charset = "utf8";

    private $resourcepaths = Array(
        Array(
            "title" => "webroot/uploads",
            "path" => "../../webroot/uploads"
        ),
        Array(
            "title" => "webroot/uploads/filemanager",
            "path" => "../../webroot/uploads/filemanager"
        ),
        Array(
            "title" => "development/definition",
            "path" => "../../development/definition"
        ),
        Array(
            "title" => "development/system_configuration/config.xml",
            "path" => "../../development/definition/system_configuration/config.xml"
        ),
        Array(
            "title" => "development/cache",
            "path" => "../../development/cache"
        ),
        Array(
            "title" => "development/cache/backup",
            "path" => "../../development/cache/backup"
        ),
        Array(
            "title" => "development/cache/backup/version",
            "path" => "../../development/cache/backup/version"
        ),
        Array(
            "title" => "development/cache/byte-stream",
            "path" => "../../development/cache/byte-stream"
        ),
        Array(
            "title" => "development/cache/data",
            "path" => "../../development/cache/data"
        ),
        Array(
            "title" => "development/cache/data/database",
            "path" => "../../development/cache/data/database"
        ),
        Array(
            "title" => "development/cache/data/report",
            "path" => "../../development/cache/data/report"
        ),
        Array(
            "title" => "development/cache/temporary",
            "path" => "../../development/cache/temporary"
        ),
        Array(
            "title" => "development/cache/temporary/addon",
            "path" => "../../development/cache/temporary/addon"
        ),
        Array(
            "title" => "development/cache/temporary/category_set",
            "path" => "../../development/cache/temporary/category_set"
        ),
        Array(
            "title" => "development/cache/temporary/information_set",
            "path" => "../../development/cache/temporary/information_set"
        ),
        Array(
            "title" => "development/cache/temporary/interfacebuilder",
            "path" => "../../development/cache/temporary/interfacebuilder"
        ),
        Array(
            "title" => "development/cache/temporary/language",
            "path" => "../../development/cache/temporary/language"
        ),
        Array(
            "title" => "development/cache/temporary/model",
            "path" => "../../development/cache/temporary/model"
        ),        
        Array(
            "title" => "development/cache/temporary/sitesettings",
            "path" => "../../development/cache/temporary/sitesettings"
        ),
        Array(
            "title" => "development/cache/temporary/urimanager",
            "path" => "../../development/cache/temporary/urimanager"
        ),
        Array(
            "title" => "development/cache/temporary/wsdl",
            "path" => "../../development/cache/temporary/wsdl"
        )
    );

    public function getactionUI($currentStep = 0)
    {
        switch ($currentStep) {
            case 0 :
                $html = $this->checksecurity()
                    ->requirmentUI();
                break;
            case 1 :
                $html = $this->checksecurity()
                    ->envUI();
                break;
            case 2 :
                $html = $this->checksecurity()
                    ->dbUI();
                break;
            case 3 :
                $html = $this->checksecurity()
                    ->installdbUI();
                break;
            case 4 :
			    if(file_exists(self::DB_RESOURCE)){
					@unlink(self::DB_RESOURCE);
				}
                $html = $this->checksecurity()
                    ->securityUI();
                break;
            case 5 :
                $html = $this->createAdmin();
                break;
            case 6 :
                $html = $this->completeUI();
                break;
        }

        return $html;
    }

    public function getheader()
    {
        $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
                    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
                <head>
                    <link href="css/default.css" rel="stylesheet" type="text/css" media="all" />
                    <title>Install appRain Content Management Framework</title>
                </head>
                <body class="innerbody">
                    <div class="wrapper">
                        <div class="head">
                            <div class="head-left">
                                <img src="images/logo.gif" alt="logo" />
                            </div>
                            <div class="head-right">

                            </div>
                        </div>
                        <div class="clearboth"></div>
                        <div class="top-heading"><h1>Installation Process</h1></div>
                        <div class="clearboth"></div>
                        <div class="container left-bar">';
        return $html;
    }

    public function getfooter()
    {
        $html = '<div class="clearboth"></div>
                </div>
                <div class="clearboth"></div>
                <div class="footer">
                     Copy Right &copy; appRain Content Management Framework
                </div>
            </div>

        </body>
        </html>';
        return $html;
    }

    public function getstepsUI($currentStep = 0)
    {
        $steps = Array("Basic Requirments", "Check Environment", "Database Configuration", "Install Database", "Security Check", "Complete");
        $html = '<div class="inner-left">
                <p>
                    <ul>';
        foreach ($steps as $key => $step) {
            if ($key == $currentStep) {
                $html .= "<li> <h2 class=\"step-selected\">{$step}</h2></li>";
            }
            else {
                $html .= "<li> <h2>{$step}</h2></li>";
            }
        }

        $html .= '</ul>
                </p>
                <br />
            </div>';
        return $html;
    }

    private function createAdmin()
    {
        $error = '';
        if (isset($_POST['data'])) {
            if (
                $_POST['data']['Admin']['sitetitle'] == '' ||
                $_POST['data']['Admin']['f_name'] == '' ||
                $_POST['data']['Admin']['l_name'] == '' ||
                $_POST['data']['Admin']['username'] == '' ||
                $_POST['data']['Admin']['email'] == '' ||
                $_POST['data']['Admin']['password'] == '' ||
                $_POST['data']['Admin']['cpassword'] == ''
            ) {
                $error = 'Please fillup the form correctly';
            }
            elseif ($_POST['data']['Admin']['password'] != $_POST['data']['Admin']['cpassword']) {
                $error = 'Confirm password did not matched';
            }
            else {
                App::Helper('Config')
                    ->setSiteInfo('site_title', $_POST['data']['Admin']['sitetitle'])
                    ->setSiteInfo('admin_title', "{$_POST['data']['Admin']['sitetitle']} Admin")
                    ->setSiteInfo('admin_email', $_POST['data']['Admin']['email']);

                $Err = App::Model('Admin')
                    ->setF_Name($_POST['data']['Admin']['f_name'])
                    ->setL_Name($_POST['data']['Admin']['l_name'])
                    ->setUsername($_POST['data']['Admin']['username'])
                    ->setPassword(App::Module("Cryptography")->encrypt($_POST['data']['Admin']['password']))
                    ->setEmail($_POST['data']['Admin']['email'])
                    ->setCreatedate(date('Y-m-d H:i:s'))
                    ->setLastresettime(time())
                    ->setType('Super')
                    ->Save()
                    ->getErrorinfo();

                if (empty($Err)) {
                    $this->redirect("6");
                }
                else {
                    $error = $Err[0];
                }
            }
        }

        return
            '<div class="inner-right">
                <h2>Website Information</h2>
                <p>Please fillup following information.</p>
                <p>
                    <form action="install.php?step=5" method="post">
                    <ul class="form siteinformation">
                        <li style="width:400px"><span class="fail">' . $error . '</span></li>
                        <li>Website Title *</li>
                        <li style="width:400px"><input style="width:415px" type="text" name="data[Admin][sitetitle]" class="ins-input" value="' . (isset($_POST["data"]["Admin"]["sitetitle"]) ? $_POST["data"]["Admin"]["sitetitle"] : "Start with appRain") . '" /> </li>
                        <li>Admin First Name * </li>
                        <li>Admin Last Name *</li>
                        <li><input type="text" name="data[Admin][f_name]" class="ins-input" value="' . (isset($_POST["data"]["Admin"]["f_name"]) ? $_POST["data"]["Admin"]["f_name"] : "Website") . '" /> </li>
                        <li><input type="text" name="data[Admin][l_name]" class="ins-input" value="' . (isset($_POST["data"]["Admin"]["l_name"]) ? $_POST["data"]["Admin"]["l_name"] : "Administrator") . '" /> </li>
                        <li>Login User Name</li>
                        <li>Email Address *</li>
                        <li><input type="text" name="data[Admin][username]" class="ins-input" value="' . (isset($_POST["data"]["Admin"]["username"]) ? $_POST["data"]["Admin"]["username"] : "admin") . '" /> </li>
                        <li><input type="text" name="data[Admin][email]" class="ins-input" value="' . (isset($_POST["data"]["Admin"]["email"]) ? $_POST["data"]["Admin"]["email"] : "info@site.com") . '" /> </li>
                        <li>Password *</li>
                        <li>Confirm Password *</li>
                        <li><input type="password" name="data[Admin][password]" class="ins-input" value="' . (isset($_POST["data"]["Admin"]["password"]) ? $_POST["data"]["Admin"]["password"] : "") . '" /> </li>
                        <li><input type="password" name="data[Admin][cpassword]" class="ins-input" value="' . (isset($_POST["data"]["Admin"]["cpassword"]) ? $_POST["data"]["Admin"]["cpassword"] : "") . '" /> </li>
                    </ul>
                    <br class="clearboth" />
                    <input type="submit" class="ins-button" name="step" value="Continue >>" />
                    </form>
                </p>
            </div>';
    }

    private function completeUI()
    {
        return
            '<div class="inner-right">
                <h2>Installation Complete</h2>
                <p>You have successfully completed the appRain installation process. You can now login to your control panel with the information shown below. After logging in, you can begin changing the system settings to suit your needs.</p>
                <p>
                    <ul class="lists">
                        <li><strong class="fail">Important:</strong> We have locked installation process. For further security you can delete "install" directory from your server.</li>
                        <li>After log to your control panel you should visit the "Tools" section to update your site information.</li>
                        <li>Read documentation and Plugin from <a href="http://www.apprain.com" target="_blank">www.apprain.com</a>.</li>
                        <li><strong>Installation Information</strong></li>
                        <li><a href="../" target="_blank">View Website</a><li>
                        <li><a href="../admin/system" target="_blank">Login - to admin Panel</a></li>
                    <ul>
                </p>
            </div>';
    }

    private function securityUI()
    {
        if (file_exists(self::DB_RESOURCE)) {
            $error = "Please delete '" . self::DB_RESOURCE . "' (webroot/install/" . self::DB_RESOURCE . ") file from installation directory. <br />This file is riskfull to hamper your database";
        }
        else {
            $this->redirect("5");
        }

        return
            '<div class="inner-right">
                <h2>Security Check</h2>
                <p>Your Database installation completed successfully</p>
                <p>
                    <span class="fail">' . $error . '</span>
                    <form action="install.php?step=4" method="post">
                    <ul class="form">
                    </ul>
                    <input type="submit" class="ins-button" name="step" value="Next >>" />
                    </form>
                </p>
            </div>';
    }

    private function installdbUI()
    {
        $error = "";
        if (!empty($_POST)) {
            $result = $this->installDB();
            if ($result) {
                $this->redirect("4");
            }
            else {
                $error = "Unexpected error occured. Please try again.";
            }
        }
        return
            '<div class="inner-right">
                <h2>Databse Installation</h2>
                <p>Your Database configuration completed successfully.<br /> This process will overwrite all previouse database tables. Just skip next steps if you want to use existing data.</p>
                <p>
                    <span class="fail">' . $error . '</span>
                    <form action="install.php?step=3" method="post">
                        <input type="submit" class="ins-button" name="step" value="Next >>" />
                    </form>
                </p>
            </div>';
    }

    private function installDB()
    {
        if (
            $mysql_connect = @mysql_connect(
                $_SESSION['dbconfig']['dbhost'],
                $_SESSION['dbconfig']['dbusername'],
                $_SESSION['dbconfig']['dbpassword'])
        ) {
            $mysql_select = @mysql_select_db($_SESSION['dbconfig']["dbname"]);
            $queris = $this->getQueris($this->readDBSource());

            foreach ($queris as $query) {
                if ($query != '') {
                    @mysql_query($query);
                }
            }
            return true;
        }

        return false;
    }

    private function getQueris($dbSource)
    {
        return preg_split(self::REGEXP, $this->setinize($dbSource));
    }

    private function setinize($dbSource)
    {
        return str_replace(self::PREFIX_REPLACE, $_SESSION['dbconfig']['prefix'], $dbSource);
    }

    private function readDBSource()
    {
        $handle = fopen(self::DB_FILE_PATH, "r");
        $contents = '';
        while (!feof($handle)) {
            $contents .= fread($handle, 8192);
        }
        fclose($handle);
        return $contents;
    }

    private function dbUI()
    {
        $error = "";
        if (isset($_POST["data"])) {
            if (
                $_POST["data"]["Db"]["dbhost"] == "" ||
                $_POST["data"]["Db"]["dbname"] == "" ||
                $_POST["data"]["Db"]["dbusername"] == ""
            ) {
                $error = "Please fillup all information below then press 'Test Dabase Connection'";
            }
            else {
                if (
                    $mysql_connect = @mysql_connect(
                        $_POST["data"]["Db"]["dbhost"],
                        $_POST["data"]["Db"]["dbusername"],
                        $_POST["data"]["Db"]["dbpassword"]
                    )
                ) {
                    $mysql_select = @mysql_select_db($_POST["data"]["Db"]["dbname"])
                        or $error = mysql_error();
                    $mysql_version = mysql_get_server_info();
                }
                else {
                    $error = mysql_error();
                }

                if (!$mysql_connect) {
                    $error = "Failed to Connect to Database Server Please check your login information and try again. <br /> (Error From DB Provider: $error)";
                }
                elseif (!$mysql_select) {
                    $error = "Failed to Select Database Database Please check your login information and try again.<br />(Error From DB Provider: $error)";
                }
                else {
                    $result = $this->writeDBFile($_POST["data"]["Db"]);

                    if ($result) {
                        $this->redirect("3");
                    }
                    else {
                        $error = "Failed to write Database definition file. Please check the file permission of the path: development/definition/";
                    }
                }
            }
        }
        return
            '<div class="inner-right">
                <h2>Database Configuration</h2>
                <p>Please provide your Database login information in the fields below. If you do not yet have an available MySQL database, you can most likely create one by accessing your website control panel (i.e. cPanel or Plesk) or by simply contacting your hosting provider.</p>
                <p><span class="fail">' . $error . '</span></p>
                <p>
                    <form action="install.php?step=2" method="post">
                    <ul class="form">
                        <li>Database Table Prefix</li>
                        <li><input type="text" name="data[Db][prefix]" class="ins-input" value="' . (isset($_POST["data"]["Db"]["prefix"]) ? $_POST["data"]["Db"]["prefix"] : "app_") . '" /> </li>
                        <li>Database Host Name</li>
                        <li><input type="text" name="data[Db][dbhost]" class="ins-input" value="' . (isset($_POST["data"]["Db"]["dbhost"]) ? $_POST["data"]["Db"]["dbhost"] : "localhost") . '" /> </li>
                        <li>Database Name</li>
                        <li><input type="text" name="data[Db][dbname]" class="ins-input" value="' . (isset($_POST["data"]["Db"]["dbname"]) ? $_POST["data"]["Db"]["dbname"] : "") . '" /> </li>
                        <li>User Name</li>
                        <li><input type="text" name="data[Db][dbusername]" class="ins-input" value="' . (isset($_POST["data"]["Db"]["dbname"]) ? $_POST["data"]["Db"]["dbusername"] : "") . '" /> </li>
                        <li>Password</li>
                        <li><input type="password" name="data[Db][dbpassword]" class="ins-input" value="" /> </li>
                    </ul>
                    <input type="submit" class="ins-button" name="step" value="Test Database Connection >>" />
                    </form>
                </p>
            </div>';
    }

    private function writeDBFile($dbconfig = NULL)
    {
        $filename = "../../development/definition/database.xml";
        $somecontent =
            "<?xml version=\"1.0\" encoding=\"utf-8\"?>
<!--
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
 * @copyright  Copyright (c) 2010 appRain, Inc. (http://www.apprain.com)
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
 * http ://www.apprain.com/documents
 */
-->
<database>
    <base>
        <date><![CDATA[" . date('d/m/Y') . "]]></date>
    </base>
    <connections>
        <connection>
            <cname>primary</cname>
            <type><![CDATA[MYSQL]]></type>
            <charset><![CDATA[" . self::charset . "]]></charset>
            <prefix><![CDATA[{$dbconfig['prefix']}]]></prefix>
            <host><![CDATA[{$dbconfig['dbhost']}]]></host>
            <dbname><![CDATA[{$dbconfig['dbname']}]]></dbname>
            <username><![CDATA[{$dbconfig['dbusername']}]]></username>
            <password><![CDATA[{$dbconfig['dbpassword']}]]></password>
            <active>1</active>
        </connection>
        <connection>
            <cname>conn2</cname>
            <type><![CDATA[]]></type>
            <charset><![CDATA[]]></charset>
            <prefix><![CDATA[]]></prefix>
            <host><![CDATA[]]></host>
            <dbname><![CDATA[]]></dbname>
            <username><![CDATA[]]></username>
            <password><![CDATA[]]></password>
            <active>0</active>
        </connection>
   </connections>
 </database>";

        if ($handle = fopen($filename, 'w+')) {
            $_SESSION['dbconfig'] = $dbconfig;
            fwrite($handle, $somecontent);
            fclose($handle);
            return true;
        }
        else {
            return false;
        }
    }

    private function envUI()
    {
        $phtml = "";
        $disabled = false;
        foreach ($this->resourcepaths as $resourcepath) {
            if (is_writeable($resourcepath["path"])) {
                $phtml .= "<li>{$resourcepath['title']} is Writeable ... <span class=\"pass\">Yes</span>";
            }
            else {
                $disabled = true;
                $phtml .= "<li>{$resourcepath['title']} is Writeable ... <span class=\"fail\">No</span>";
            }
        }

        return
            '<div class="inner-right">
                <h2>Checking Environment</h2>
                <p>System requirs following paths writable (777)</p>
                <p>

                    <form action="install.php?step=2" method="post">
                    <ul class="lists">'
            . $phtml .
            '</ul>
                    ' . ((!$disabled) ? ' <input type="submit" class="ins-button" name="step" value="Next >>" />' : "") . '
                    </form>
                </p>
            </div>';
    }

    private function requirmentUI()
    {
        return '<div class="inner-right">
                    <h2>Basic Requirments</h2>
                    <p>
                        <form action="install.php?step=1" method="post">
                        <ul class="lists">
                            <li>Apache webserver with mod_rewrite (ability to use .htaccess files)</li>
                            <li>PHP Version 5.1.0 or newer</li>
                            <li>MySQL 4 or newer (Other Populer database is configurable too)</li>
                        </ul>
                        <input type="submit" class="ins-button" name="step" value="Next >>" />
                        </form>
                    </p>
                </div>';
    }

    private function redirect($step)
    {
        echo '<script type="text/javascript"> window.location="install.php?step=' . $step . '";</script>';
        exit;
    }

    private function checksecurity()
    {
        if (!file_exists(self::DB_RESOURCE) && $this->hasAdmin()) {
            //$this->redirect("6");
        }
        return $this;
    }

    private function hasAdmin()
    {
        $res = App::Model('Admin')->findAll();
        return !empty($res['data']);
    }
}
