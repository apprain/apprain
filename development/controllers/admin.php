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
 * Admin Controller
 */
class adminController extends appRain_Base_Core {

    /**
     * Define the name of
     * the controller
     */
    public $name = 'Admin';

    /**
     * Govern all type of configuration
     * The configuration section is profiled by user id
     *
     * @return null
     */
    public function configAction($section = 'general') {
        /* Fetch this common site setting defintion */
        $definition = app::__def()->getSiteSettingsDefinition();
        $definition = isset($definition[$section]) ? $definition[$section] : $definition;

        $this->page_title = isset($definition['base']['title']) ? $definition['base']['title'] : "Configuration";

        /**
         * Set tab and do
         * authontication
         */
        $this->setAdminTab(isset($definition['base']['admin_tab']) ? $definition['base']['admin_tab'] : 'sconfig');


        if (!empty($this->data)) {
            foreach ($this->data['sconfig'] as $key => $val) {
                if (is_array($val)) {
                    if (isset($val['tmp_name'])) {
                        if ($val['tmp_name'] != "") {
                            $path = $this->get_config("filemanager_path") . "/";
                            $file_data = App::Load("Helper/Utility")->upload($val, $path);
                            $val = $file_data['file_name'];
                        } else {
                            unset($val);
                        }
                    } else {
                        $val = implode(',', $val);
                    }
                }

                if (isset($val)) {
                    $data = App::Model('Config')->find("soption='{$key}'");
                    if (!empty($data)) {
                        $data['svalue'] = $val;
                    } else {
                        $data = Array(
                            "soption" => $key,
                            "svalue" => $val,
                            "section" => $section
                        );
                    }

                    App::Model('Config')->Save(
                            Array(
                                "Config" => $data
                            )
                    );
                }
            }

            App::Module('Notification')->Push("Updated successfully.");

            $this->redirect("/admin/config/{$section}");
            exit;
        }
        $str = ($section == 'all') ? "1 order by sort_order asc" : "section='$section' order by sort_order asc";

        $data_array = App::Model('Config')->findAll($str);
        $this->set('definition', $definition);
        $this->set('data_array', $data_array);
        $this->set('section', $section);
    }

    /**
     *    Super admin login section
     *
     * @return null
     */
    public function systemAction() {
        $this->layout = 'admin';
        $this->admin_tab = 'blunk';
        $this->page_title = "Super Admin";
        $error = '';

        /* Set layout parameters */
        $this->set('admin_content_clear_length', true);
        $this->set('disable_admin_header', true);
        $this->set('disable_admin_footer', true);

        /**
         * Redirect control if ther user
         * already logged in
         */
        $this->user_already_loggedin();

        /* Process admin login */
        if (!empty($this->data)) {
            /* Admin post date */
            $admin_name = isset($this->data['Admin']['admin_id']) ? $this->data['Admin']['admin_id'] : '';
            $admin_password = isset($this->data['Admin']['admin_password']) ? $this->data['Admin']['admin_password'] : '';


			$admin_login_info = App::Module('Admin')->AdminInfo($admin_name,true);

            $admin_db_name = isset($admin_login_info["username"]) ? $admin_login_info["username"] : "";
            $admin_db_password = isset($admin_login_info["password"]) ? $admin_login_info["password"] : "";

            // Check the data individually
            if ($admin_name == '' || $admin_password == '') {
                $error = $this->__("Sorry! Invalid Username or Password.");
            } else if ($admin_login_info['status'] != "Active") {
                $error = $this->__("Account is not active");
            } else if (($admin_name == $admin_db_name) && (App::Module("Cryptography")->checkEncrypt($admin_password, $admin_db_password))
            ) {

                /* Update Last Login time */
                App::Model('Admin')
                        ->setId($admin_login_info['id'])
                        ->setLatestLogin(App::Helper('Date')->getTime())
                        ->setLastlogin($admin_login_info['latestlogin'])
                        ->Save();

                if (strtolower($admin_login_info["type"]) == "super") {
                    $admin_tab_access = $this->admin_tab_access('superadmin');
                } else {
                    $admin_tab_access = ($admin_login_info["acl"] != "") ? explode(',', $admin_login_info["acl"]) : Array();
                }

                if (!empty($admin_tab_access)) {

                    /* Admin Session information */
                    $admin_info_arr = array(
                        'adminref' => $admin_login_info['id'],
                        'status' => 'Admin',
                        'f_name' => $admin_login_info['f_name'],
                        'l_name' => $admin_login_info['l_name'],
                        'email' => $this->get_config('admin_email'),
                        'admin_panel_tabs' => $admin_tab_access
                    );

                    /* Write Cookie to remember user Credential */
                    if (isset($this->data['Admin']['remember_my_name'])) {
                        App::load("Module/Cookie")->write("remember_super_admin_name", $admin_name);
                        App::load("Module/Cookie")->write("remember_super_admin_password", "");
                    } else if (isset($this->data['Admin']['remember_me'])) {
                        App::load("Module/Cookie")->write("remember_super_admin_name", $admin_name);
                        App::load("Module/Cookie")->write("remember_super_admin_password", $admin_password);
                    }

                    App::Load("Module/Session")->write('User', $admin_info_arr);

                    if ($this->hasRequestURI()) {
                        $this->redirectToRequestURI();
                    } else {
						$admin_landing_page = App::Config()->Setting('admin_landing_page','admin/introduction');
                        $this->redirect(DS . $admin_landing_page);
                    }
                    exit;
                } else {
                    $error = $this->__("User does not have enough Tab preveliege");
                }
            } else {
                $error = $this->__("Sorry! Invalid Username or Password.");
            }
        }

        /* Fetch data from cookie */
        $remember_super_admin_name = app::load("Module/Cookie")->read('remember_super_admin_name');
        $remember_super_admin_password = app::load("Module/Cookie")->read('remember_super_admin_password');

        /* Set values */
        $this->set('remember_super_admin_name', $remember_super_admin_name);
        $this->set('remember_super_admin_password', $remember_super_admin_password);
        $this->set('error', $error);
    }

    /**
     * Commong logout
     *
     * @return null
     */
    public function logoutAction() {
        /* Read admin previouse session */
        $admin_info = App::Load("Module/Session")->read('User');

        /* Clear session */
        App::Load("Module/Session")->delete('User');

        if (isset($admin_info['id'])) {
            /**
             * Redirect to "login" window
             * if use is logged out as profile
             * user.
             */
            $this->redirect('/admin/login');
        } else {
            /**
             * Redirect to "system" window
             * if use is logged out as super
             * administrator.
             */
            $this->redirect('/admin/system');
        }
        exit;
    }

    /**
     * An inactive function always
     * redirect to othr page
     *
     * @parameter admin_flag string
     *
     * @return null
     */
    public function indexAction($admin_flag = 'introduction') {
        $this->redirect('/admin/' . app::__def()->sysConfig('ADMIN_REDIRECTION'));
        exit;
    }

    /**
     * This function to generate the deshboard of the admin panel
     *
     * @return null
     */
    public function introductionAction() {
        /**
         * Check authentication of
         * the user
         */
        $this->check_admin_login();

        $this->layout = 'admin';
        $this->admin_tab = 'blunk';
        $this->addons = Array('dialogs', 'validation');

        $login_session = App::Load("Module/Session")->read('User');
        $admin_arr = $this->get_this_member_info();

        $this->set('admin_arr', $admin_arr);
        $this->set('login_session', $login_session);
    }

    /**
     * Send email to administrator from
     * dashboard "Leave a message"
     * section.
     *
     * @return null
     */
    public function sendMessageAction() {
        $this->check_admin_login();
        $this->layout = 'blank';

        try {
            if (!App::Helper("Validation")
                            ->Email($this->data['Message']['email'])
            ) {
                throw new AppException(App::Module('Notification')->toHtml($this->__("Pleaes enter a valid email address."), "error"));
            } else {
                /* Fetch currently loggedin user data */
                $adminData = App::AdminManager()->thisAdminInfo();
                App::Helper('EmailTemplate')
                        ->setParameters(
                                Array(
                                    'AdminFirstName' => $adminData['f_name'],
                                    'AdminLastName' => $adminData['l_name'],
                                    'Subject' => $this->data['Message']['subject'],
                                    'Message' => $this->data['Message']['message'],
                                    'AdminEmail' => $adminData['email'],
                                    'SentTime' => App::Helper('Date')->dateFormated(NULL, 'long')
                                )
                        )
                        ->setTo(array($this->data['Message']['email'], ""))
                        ->prepare('Admin2AdminContact', true);
            }
            echo App::Load("Module/Cryptography")->jsonEncode(array("_status" => "Success", "_message" => App::Module('Notification')->toHtml($this->__("Message sent successfully."), "success")));
        } catch (AppException $e) {
            echo App::Load("Module/Cryptography")->jsonEncode(array("_status" => "Error", "_message" => $e->getMessage()));
        }
    }

    /**
     * Common image manager to upload images as well as files
     *
     * @return NULL
     */
    public function filemanagerAction($action = NULL, $image_name = NULL) {
        /* Check Authentication */
        $this->check_admin_login();

        $this->layout = 'admin';
        $this->admin_tab = 'blunk';
        $this->addons = array('uploadify');
        $this->set('admin_content_full_length', true);
        $this->set('disable_admin_header', true);
        $this->set('disable_admin_footer', true);
        $srcstr = '';

        if ($action == 'delete') {
            $name = base64_decode($image_name);
            $path = App::Config()->filemanagerDir(DS . $name);
            unlink($path);
            App::Module('Notification')->Push("File({$name}) has been deleted successfully.");
            App::Config()->redirect("/admin/filemanager");
        } else if ($action == 'efu' || $action == 'dfu') {
            App::Config()->setSiteInfo('flash_file_uploader', ($action == 'efu') ? 'Yes' : 'No');
            App::Config()->redirect("/admin/filemanager/upload");
        }


        if (!empty($this->data)) {
            if (isset($this->data['FileManager']['search'])) {
                $srcstr = $this->data['FileManager']['search'];
            } else {
                if (!App::Module('Filemanager')->varifyFileName($this->data['filemanager']['image']['name'])) {
                    App::Module('Notification')->Push("File({$this->data['filemanager']['image']['name']}) is restricted to uploaded.", "Error");
                    App::Config()->redirect("/admin/filemanager/upload");
                } else {
                    $path = App::Config()->filemanagerDir(DS);
                    $data = App::Utility()->upload($this->data['filemanager']['image'], $path);
                    App::Module('Notification')->Push("File({$data['file_name']}) uploaded successfully.");
                    App::Config()->redirect("/admin/filemanager");
                }
            }
        }
        $viewtype = (isset($this->get['view']) && $this->get['view'] == 'grid') ? 'grid' : 'list';
        $this->set('viewtype', $viewtype);
        $this->set('srcstr', $srcstr);
        $this->set('action', $action);
    }

    /**
     * To display any exception case
     *
     * @parameter flag string
     * @return null
     */
    public function exception_hereAction($flag = "session_expire") {
        /* Set layout */
        $this->layout = 'admin';
        $this->admin_tab = 'blunk';

        $h2 = "";
        $message = "";
        $nav = "";

        $this->set('admin_content_full_length', true);
        $this->set('disable_admin_header', true);
        $this->set('disable_admin_footer', true);

        if ($flag == "bad_link") {
            $h2 = $this->__("Link Expired");
            $message = $this->__("Sorry! Link expired or tried a bad link");
            $nav = App::load("Helper/Html")
                            ->linkTag(
                                    $this->baseurl("/admin"), "Click here to Login") . " | " . App::load("Helper/Html")->linkTag($this->baseurl("/"), "Go to website"
            );
        } else {
            $h2 = $this->__("Session expired");
            $message = $this->__("<strong>Our Apologies.</strong><br /> For security purpose we limit the amount of time within the system.");
            $nav = App::load("Helper/Html")->linkTag($this->baseurl("/admin"), "Click here to Login") . " | " .
                    App::load("Helper/Html")->linkTag($this->baseurl("/"), "Go to website");
        }

        $this->page_title = $h2;

        $this->set("h2", $h2);
        $this->set("message", $message);
        $this->set("nav", $nav);
    }
	
	public function managegroupAction($action = NULL, $id = NULL){
	
		$this->setAdminTab('usermanagement');
		
		if($action == 'delete'){
			
			$List = App::Model('Admin')->findByGroupid($id);
			if(!empty($List)){
				App::Module('Notification')->Push("Unable to delete as group is not empty!", "Error");
			}
			else{
				App::Module('Notification')->Push("Deleted successfully");
				App::Model('Category')->Delete("id={$id}");
			}
			
			$this->Redirect("/admin/managegroup");
			exit;
		}

		if(!empty($this->data)){
			
			try{
				
				$generic = 'No';
				if(isset($this->data['Group']['access'])){
					$generic = implode(",",$this->data['Group']['access']);
				}
				
				if(isset($this->data['Group']['accessall'])){
					$generic = '';
				}
				
				$data = array(
					'id'=>$id,
					'title'=>$this->data['Group']['name'],
					'description'=>json_encode($this->data['Admin']),
					'generic'=>$generic
				);
				
				$obj = App::CategorySet('Usergroup')->Save($data);
				
				 $status = 'Success';
                 throw new AppException($this->__("Data saved successfully."));
							
			
			} catch (AppException $e) {
                $status = (isset($status) ? $status : 'Error');
                $message_name = ($status == 'Redirect') ? '_location' : '_message';
                echo App::Load("Module/Cryptography")->jsonEncode(
                        array(
                            "_status" => $status,
                            "{$message_name}" => $e->getMessage()
                        )
                );
            }
			exit;
			
		}
		
		$Entry = array();
		if(!empty($id)){
			 $Entry = App::Model('Category')->findById($id);		 
		}
		else{
			$DataList = App::Model('Category')->paging("type='Usergroup' ORDER BY id DESC");
			$this->set("DataList", $DataList);
		}
		
		$this->set("Entry", $Entry);
		$this->set("action", $action);
		$this->set("id", $id);
		
	}

    /**
     * Manage Administrators accounts
     */
    public function manageAction($action = NULL, $id = NULL) {
        $this->setAdminTab('usermanagement');
        $error = "";

        if (($action != 'add') && ($action != 'update')) {
            $this->addons = array('row_manager');
        }

        if (!empty($this->data)) {

            try {
                if (isset($this->data['Admin']['newpassword']) && $this->data['Admin']['newpassword'] != ''
                        and isset($this->data['Admin']['cnewpassword']) && $this->data['Admin']['cnewpassword'] != ''
                ) {
                    $error = App::AdminManager()
                            ->setId($id)
                            ->setOldPassword(false)
                            ->setNewPassword($this->data['Admin']['newpassword'])
                            ->setConfirmPassword($this->data['Admin']['cnewpassword'])
                            ->resetPassword($this->data['Admin']['reason'], false)
                            ->getErrorInfo();
                    if (!empty($error)) {
                        throw new AppException($error);
                    } else {
                        $status = 'Success';
                        throw new AppException($this->__("Password updated successfully."));
                    }
                } else {


                    if ($action == 'add') {
                        $this->data['Admin']['createdate'] = App::Helper('Date')->getdate("Y-m-d H:i:s");
                        if (!App::Helper('Validation')->password($this->data['Admin']['password'])) {
                            throw new AppException($this->__("Weak password. (Hints [A-Za-z0-9] and 6 char length)"));
                        }
                    }

                    if (isset($this->data['Admin']['password'])) {
                        $this->data['Admin']['password'] = App::Module("Cryptography")->encrypt($this->data['Admin']['password']);
                    }

                    if (isset($id)) {
                        $this->data['Admin']['id'] = $id;
                    }

                    $obj = App::AdminManager()->Save($this->data);
					
                    $error = $obj->getErrorInfo();
                    if (!empty($error)) {
                        throw new AppException(implode(",", $error));
                    } else {

                        if ($action == 'add') {
                            $status = 'Redirect';
                            throw new AppException($this->baseUrl("/admin/manage/update/" . $obj->getId()));
                        } else {
                            $status = 'Success';
                            throw new AppException($this->__("Administrator saved successfully."));
                        }
                    }
                }
            } catch (AppException $e) {
                $status = (isset($status) ? $status : 'Error');
                $message_name = ($status == 'Redirect') ? '_location' : '_message';
                echo App::Load("Module/Cryptography")->jsonEncode(
                        array(
                            "_status" => $status,
                            "{$message_name}" => $e->getMessage()
                        )
                );
            }
            exit;
        }

        $adminlist = App::AdminManager()->listing($id);
        $admin_nav_def = App::AdminManager()->rootnavelist($this->get_admin_nav());

        $this->set("error", $error);
        $this->set("admin_nav_def", $admin_nav_def);
        $this->set("action", $action);
        $this->set("adminlist", $adminlist);
    }

    /**
     * Administrator account manage section
     */
    public function accountAction($action = "view") {
        $this->layout = 'admin';
        $this->check_admin_login();

        if (!empty($this->data)) {
            $message = NULL;

            /* Update password */
            if (isset($this->post['AdminPassword']['Update'])) {
                $message = App::AdminManager()
                        ->setId($this->data['Admin']['id'])
                        ->setOldPassword($this->post['AdminPassword']['old'])
                        ->setNewPassword($this->post['AdminPassword']['new'])
                        ->setConfirmPassword($this->post['AdminPassword']['confirm'])
                        ->resetPassword($this->post['AdminPassword']['porpose'], true)
                        ->getErrorInfo();
            }

            /* Update Information */
            App::Model('Admin')->Save($this->data);


            if (isset($message)) {
                App::Module('Notification')->Push($message, "Error");
            } else {

                if (isset($this->post['AdminPassword'])) {
                    unset($this->post['AdminPassword']);
                }

                App::Module('Notification')->Push('Update completed successfully');
            }

            $this->redirect("/admin/account/edit");
            exit;
        }

        $userSessoion = App::Module("Session")->read("User");
        $user_data = App::Model('Admin')->findById($userSessoion['adminref']);

        $this->set('user_data', $user_data);
        $this->set('action', $action);
    }

    /**
     * Forgot login action
     */
    public function forgotloginAction($sid = "") {
        /* Set layout variables */
        $this->layout = 'admin';
        $this->admin_tab = 'blunk';

        /* Customize admin layout  */
        $this->set('admin_content_clear_length', true);
        $this->set('disable_admin_header', true);
        $this->set('disable_admin_footer', true);
        $message = '';

        if (!empty($this->data)) {
            if ($sid != "") {
                $data = App::Model('Admin')->findByResetsid(base64_decode($sid));

                if (empty($data)) {
                    $this->redirect('/admin/exception_here/bad_link');
                    exit;
                } else if ($this->data['Admin']['password'] != $this->data['Admin']['cpassword']) {
                    $message = $this->__("Password not matched.");
                } else if (!App::Helper('Validation')->password($this->data['Admin']['password'])) {
                    $message = $this->__("Password must be combination of [A-Z][a-z][0-9]");
                } else {

                    /**
                     * Update password and
                     * reset "RestId" to empty
                     */
                    $err = App::Model('Admin')
                            ->setId($data['id'])
                            ->setPassword(App::Module("Cryptography")->Encrypt($this->data['Admin']['password']))
                            //->setResetsid('')
                            ->save()
                            ->getErrorInfo();

                    /* Redirect after process complete */
                    if (empty($err)) {
                        $this->redirect('/admin/system');
                    } else {
                        $this->redirect('/admin/exception_here/bad_link');
                    }
                    exit;
                }
            } else {

                $data = App::Model('Admin')->findByEmail($this->data['Admin']['email']);

                $capacha = App::Session()->read('capacha');

                if ($this->data['Admin']['capacha'] != $capacha['adminpasswordreset']) {
                    $message = $this->__('Please fillup the capacha correctly');
                } else if (empty($data)) {
                    $message = $this->__('Please enter your email address');
                } else {
                    if (App::AdminManager()->generateResetSid($data['id'])) {
                        $message = $this->__('Please check  your email.');
                    } else {
                        $message = $this->__('Please enter you email address');
                    }
                }
            }
        }

        $this->set('sid', $sid);
        $this->set('message', $message);
    }

    public function switchadminleftpanAction() {
        $this->layout = 'Admin';
        $this->check_admin_login();

        if (App::Session()->Read('collapseAdminLeftPan')) {
            App::Session()->Delete('collapseAdminLeftPan');
        } else {
            App::Session()->Write('collapseAdminLeftPan', true);
        }
    }

    public function apphelpsAction($HelpId = null) {
        $this->check_admin_login();
        $this->layout = 'blank';
        $help = app::__def()->HelpList($HelpId);

        if (!empty($help)) {
            $str = "<h3>{$help['title']}</h3>
				<p>{$help['shortdesc']}</p>
				<h3>Description</h3>
				{$help['description']}";
        } else {
            $str = "<h3>Help data not found</h3>
				<p>Your requested help information is not available for id : <strong>{$HelpId}</strong></p>
				<h3>Further Instruction</h3>
				Please contact <a href=\"http://www.apprain.org/ticket\">apprain</a> help desk to get update help file. Create a ticket to explain your problem.";
        }
        echo $str;
    }

}
