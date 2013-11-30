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


class  appRain_Base_Modules_Admin extends appRain_Base_Objects
{
    const ADMIN = 'Admin';
	
	public $thisAdminInfo = Array();

    /**
     * Base function to call Page Section
     *
     * @param $type String
     * @return Object
     */
    /*public function AdminManager()
    {
        $this->setFetchtype('AdminManager');
        return $this;
    }*/

    public function isLoggedIn()
    {
        $admin_info = App::Load("Module/Session")->read('User');
        $admin_info['status'] = isset($admin_info['status']) ? $admin_info['status'] : '';
        return ($admin_info['status'] == self::ADMIN);

    }

    public function thisAdminSession()
    {
        return App::Session()->read('User');
    }

    public function thisAdminInfo($field=null)
    {
		if(empty($this->thisAdminInfo)){
			$user_arr = $this->thisAdminSession();

			$this->thisAdminInfo =  isset($user_arr['adminref']) ?
				$this->listing($user_arr['adminref'])
				: Array();
		}	
		return isset($this->thisAdminInfo[$field]) ? $this->thisAdminInfo[$field] : $this->thisAdminInfo;	
    }


    /**
     * Get Admin lists
     *
     * @return Array
     */
    public function listing($id = null)
    {
        if (isset($id)) return App::Load("Model/Admin")->findById($id);
        else return App::Load("Model/Admin")->paging();
    }

    /**
     * Admin Panel root Navigation List
     *
     * @return Array
     */
    public function rootnavelist($nav_list = null, $type = 'superadmin')
    {
        $data = Array();
        foreach ($nav_list as $nav_key => $nav) {
            if (strtolower($type) == 'all') {
                $data[$nav_key] = $nav["parent"]["title"];
            }
            else {
                if (in_array($type, $nav['parent']['acl'])) {
                    $data[$nav_key] = $nav["parent"]["title"];
                }
            }
        }

        return $data;
    }

    /**
     * Save Data
     *
     * Return Integer
     */
    public function save($data)
    {

        /*if(isset($data['Admin']['acl']))
        {
            $data['Admin']['acl'] = implode(',',$data['Admin']['acl']);
        } else $data['Admin']['acl'] = "";*/
        if (!empty($data['Admin']['acl'])) {
            $data['Admin']['acl'] = serialize($data['Admin']['acl']);
        }

        if (!empty($data['Admin']['aclobject'])) {
            $data['Admin']['aclobject'] = serialize($data['Admin']['aclobject']);
        }
        return App::Load("Model/Admin")->Save($data);
    }

    /**
     * Generate Admin Referance Information
     *
     * @return string
     */
    public function getAdminReferance($inforow)
    {
        $inforow['adminref'] = isset($inforow['adminref']) ? $inforow['adminref'] : "";
        $adminInfo = App::Load("Model/Admin")->findById($inforow['adminref']);
        return (!empty($adminInfo))
            ? (app::__def()->sysConfig('ADMIN_REF_WITH_LINK'))
                ? App::Load("Helper/Html")->linkTag(App::Load("Helper/Config")->baseurl("/admin/manage/view/{$inforow['adminref']}"), "{$adminInfo['f_name']} {$adminInfo['l_name']}") . "<br />On " . App::Load("Helper/Date")->dateFormated($inforow["lastmodified"], 'long')
                : "{$adminInfo['f_name']} {$adminInfo['l_name']} <br />On " . App::Load("Helper/Date")->dateFormated($inforow["lastmodified"], 'long')
            : App::Load("Helper/Date")->dateFormated($inforow["lastmodified"]);
    }

    /**
     * Update configuration
     * Create user configuraion for during login
     *
     * @param $user_arr Array
     */
    public function updateProfileUserConfiguration($user_arr)
    {
        $definition = App::__def()->getProfileUserConfigDefinition();

        /*
         * Update the user configuration
         */
        if (App::__def()->sysConfig('CREATE_CONFIGURATION_FOR_USER')) {

            $config_arr = App::Model('Config')->findAll("fkey=" . $user_arr['id']);
            if (empty($config_arr['data'])) {
                /*
                 * Update configuration for user
                 */
                foreach ($definition['settings'] as $key => $val) {
                    App::Model('Config')
                        ->setId(null)
                        ->setSvalue($val['value'])
                        ->setSoption($val['name'])
                        ->setSort_order($val['sort_order'])
                        ->setSection($val['section'])
                        ->setFkey($user_arr['id'])
                        ->Save();
                }
            }
        }

        /*
        * Update user static pages
        * Create pages for users
        */
        if (app::__def()->sysConfig('CREATE_DUMMY_PAGE_FOR_USER')) {
            $page_arr = App::Model('Page')->findAll("fkey=" . $user_arr['id']);

            if (empty($page_arr['data'])) {
                /*
                 *	Update Dummy page for user
                 */
                foreach ($definition['pages'] as $key => $val) {
                    $obj = App::Model('Page')
                        ->setId(null)
                        ->setName($val['name'])
                        ->setTitle($val['title'])
                        ->setContent($val['content'])
                        ->setFkey($user_arr['id'])
                        ->Save();
                }
            }
        }
    }

    public function resetPassword($purpose = "", $notification = false)
    {
        $data = App::Model('Admin')->findById($this->getId());

        if (empty($data)) {
            $this->setErrorInfo($this->__("User does not exists"));
        }
        else if ($purpose == "") {
            $this->setErrorInfo($this->__("You must enter a purpose to chnage the password!"));
        }
        else if ($this->getNewPassword() == "" || ($this->getOldPassword() == "" AND $this->getOldPassword() != false)) {
            $this->setErrorInfo($this->__("Password can not be empty!"));
        }
        else if ($this->getNewPassword() != $this->getconfirmpassword()) {
            $this->setErrorInfo($this->__("New and Confirm password does not match"));
        }
        else if (!App::Helper('Validation')->password($this->getNewPassword())) {
            $this->setErrorInfo($this->__("Weak password. (Hints [A-Za-z0-9] and 6 char length)"));
        }
        else {
            if (App::Module("Cryptography")->checkEncrypt($this->getOldPassword(), $data['password']) OR $this->getOldPassword() === false) {
                App::Model('Admin')
                    ->setId($this->getId())
                    ->setPassword(App::Module("Cryptography")->Encrypt($this->getNewPassword()))
                    ->Save();

                $this->setErrorInfo(NULL);
                if ($notification) {
                    $this->sendNotification('passwordreset');
                }
            }
            else {
                $this->setErrorInfo($this->__("Old Password Does not matched"));
            }
        }
		
		App::Helper('Log')
		->setLogType('System')
		->setFkey($this->getId())->Write($this->__("Password reset attempted.") . " Purpose :{$purpose} " . $this->getErrorInfo() );
					
        return $this;
    }

    public function sendNotification($select = null)
    {
        $mailData = Array();
        $config = App::Helper('Config');
        switch ($select) {
            case "passwordreset":
                break;
            case "forgotpassword":
                $data = App::Model('Admin')->findById($this->getAdminId());
                $mailData['To'] = $data['email'];
                $mailData['ToName'] = "{$data['f_name']} {$data['l_name']}";
                $mailData['From'] = $config->siteInfo('admin_email');
                $mailData['subject'] = $this->__('Password Reset');
                $mailData['body'] = App::Helper('Html')->linkTag($config->baseurl("/admin/forgotlogin/" . base64_encode($data['resetsid'])), 'Click Here to rest your password');
                break;

            default :
                break;
        }

        if (!empty($mailData)) {
            App::Load("Plugin/Mailing_Phpmailer")->ContentType = "text/html";
            App::Load("Plugin/Mailing_Phpmailer")->From = isset($mailData['From']) ? $mailData['From'] : $config->siteInfo('admin_email');
            App::Load("Plugin/Mailing_Phpmailer")->FromName = isset($mailData['FromName']) ? $mailData['FromName'] : $config->siteInfo('site_title');
            App::Load("Plugin/Mailing_Phpmailer")->AddAddress(
                isset($mailData['To']) ? $mailData['To'] : $config->siteInfo('admin_email'),
                isset($mailData['ToName']) ? $mailData['ToName'] : $config->siteInfo('site_title')
            );
            App::Load("Plugin/Mailing_Phpmailer")->Subject = $mailData['subject'];
            App::Load("Plugin/Mailing_Phpmailer")->MsgHTML($mailData['body']);
            App::Load("Plugin/Mailing_Phpmailer")->send();
        }
    }

    public function generateResetSid($id = null, $emailNotification = true)
    {
        if ($this->isAdminExists($id)) {
            App::Model('Admin')
                ->setId($id)
                ->setResetsid(App::Module("Cryptography")->encrypt())
                ->setLastresettime(App::Helper('Date')->getTime())
                ->Save();


            if ($emailNotification) {
                $this->setAdminId($id)
                    ->sendNotification('forgotpassword');
            }
            return true;
        }

        return false;
    }


    public function isAdminExists($id = null)
    {
        $data = App::Model('Admin')->findById($id);
        return !empty($data);
    }
}