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


class memberController extends appRain_Base_Core
{
    /* Controller Name */
    public $name = "Member";

    /**
     * Render Member Login page
     */
    public function loginAction()
    {
        /* Attach addons and set metat information */
        $this->addons = array('appform', 'ajaxsubmit');
        $error = '';
        $staticpage = $this->staticPageNameToMetaInfo('memberlogin');
        $this->set('staticpage', $staticpage);

        /**
         * Execute if there is any POST
         * request submit for this page
         */
        if (!empty($this->data)) {
            $username = isset($this->data['Member']['login_id'])
                ? $this->data['Member']['login_id'] : '';
            $password = isset($this->data['Member']['password'])
                ? $this->data['Member']['password'] : '';

            if (($username == '') || ($password == '')) {
                $error = $this->__("Please enter username and password.");
            }
            else {
                $fieldname = app::__def()->sysConfig('LOGIN_FIELD');
                $user_arr = App::Model('Member')->find("{$fieldname}='{$username}'");

                if (empty($user_arr)) {
                    $error = $this->__("Sorry! Invalid Login.");
                }
                else if ($user_arr['status'] != "Active") {
                    $error = $this->__("Sorry! Account not activated.");
                }
                else {
                    if (App::Module("Cryptography")->checkEncrypt($password, $user_arr['password'])) {
                        /* Login as App User */
                        App::Load("Module/Session")
                            ->write(
                            'AppUser',
                            array(
                                'id' => $user_arr['id'],
                                'f_name' => $user_arr['f_name'],
                                'l_name' => $user_arr['l_name']
                            )
                        );

                        /* Redirect */
						$loc = App::Session()->Read('redirect_member_after_login');
						if(isset($loc)){
							   $this->redirect($loc);
						}
						else{
						    $this->redirect('/');
						}
                    }
                    else {
                        $error = $this->__("Sorry! Invalid Login.");
                    }
                }
            }
        }

        /* Set values in views*/
        $this->set("selected", "login");
        $this->set("section_title", "Member Login");
        $this->set('message', $error);

    }

    /**
     * Member Logout
     */
    public function logoutAction()
    {
        /* Set layout */
        $this->layout = "empty";

        /* Unregister App user */
        App::Load("Module/Session")->delete('AppUser');

        /* Unregister Profile user */
        App::Load("Module/Session")->delete('User');

        /**
         * Redirect to home page
         * Fancy Redirection
         * App::Helper('Config')->transfer(null,"You are loging out...");
         */
        $this->redirect("/");
        exit;
    }

    /**
     * Member Forgot Login
     */
    public function forgotloginAction()
    {
        // Set Layout
        $this->layout = "empty";

        if (!empty($this->data)) {
            try {
                if (!App::Load("Helper/Validation")->Email($this->data['Forgotlogin']['login_name'])) {
                    throw new AppException($this->__("Pleaes enter a valid email address."));
                }
                else {
                    $this->complete_forget_login($this->data['Forgotlogin']['login_name']);
                }

                echo App::Load("Module/Cryptography")->jsonEncode(array("_status" => "Success", "_message" => $this->__("Password reset instruction sent in your email.")));

            }
            catch (AppException $e) {
                echo App::Load("Module/Cryptography")
                    ->jsonEncode(
                    array(
                        "_status" => "Error",
                        "_message" => $e->getMessage()
                    )
                );
            }
        }
    }


    /**
     * This is an Private function
     * and it's can't execute by URL because
     * we did not added the extension "Action" end of
     * function.
     * It's a Law of MVC pattern in appRain. This
     * low save us from unauthorize function
     * call.
     */
    private function complete_forget_login($email = "")
    {
        /* Fetch data by Email Address */
        $member_info = App::Load("Model/Member")->findByEmail($email);

        if (empty($member_info)) {
            /* Throw exception to return in Catch block */
            throw new AppException($this->__("No member found with this email address."));
        }
        else {
            /**
             *  Set new Reset for the user to be
             * used in Varification
             */
            $resetid = App::Helper('Date')->getTime();
            App::Load("Model/Member")->setId($member_info['id'])
                ->setResetid($resetid)
                ->Save();
            // Set email notificatin
			$Link = App::Helper("Html")->linkTag($this->baseurl("/member/passwordreset/" . base64_encode($resetid)), $this->__("Reset Password"));
			App::Helper('EmailTemplate')->setParameters(Array(
                'FirstName' => $member_info['f_name'],
                'LastName' => $member_info['l_name'],
                'Email' => $member_info['email'],
                'PasswordResetLink' => $Link
            ))
                ->setTo(array($member_info['email'], "{$member_info['f_name']} {$member_info['l_name']}"))
                ->prepare(
                $tempalteName = 'ForgotPassword',
                $isNotified = true);
        }
    }

    /**
     * Password Reset Action
     */
    public function passwordresetAction($restKey = NULL)
    {
        $this->addons = array('validation', 'ajaxsubmit');
        // Fetch Member by reset Id
        $memberData = App::Model('Member')->findByResetid(base64_decode($restKey));

        if (!empty($memberData)) {
            if (!empty($this->data)) {
                $this->layout = 'empty';
                try {
                    if ($this->data['Forgotlogin']['new_password'] != $this->data['Forgotlogin']['re_new_password']) {
                        throw new AppException($this->__('Password did not match'));
                    }
                    else {
                        App::Model('Member')->setId($memberData['id'])
                            ->setPassword(App::Module("Cryptography")->encrypt($this->data['Forgotlogin']['new_password']))
                            ->setResetid('')
                            ->Save();

                        echo App::Load("Module/Cryptography")->jsonEncode(Array("_status" => "Redirect", "_location" => $this->baseurl("/member/login")));
                    }

                }
                catch (AppException $e) {
                    echo App::Load("Module/Cryptography")->jsonEncode(Array("_status" => "Error", "_message" => $e->getMessage()));
                }

            }
        }
        else App::Helper('Config')->transfer($this->baseurl('/'), "Link expired!"); // Fancy redirection

		$this->set("section_title", "Change Password");	
        $this->set('restKey', $restKey);
    }

    /**
     * Member Registration Action
     *
     */
    public function signupAction()
    {
        $this->set('staticpage',$this->staticPageNameToMetaInfo('membersignup'));
        $this->set("selected", "signup");

        if (!empty($this->data)) {
            $this->layout = 'empty';
            try {
			
                // Execute Signup Process
                $this->completeAjaxSignup();

                echo App::Load("Module/Cryptography")
					->jsonEncode(
						Array(
							"_status" => "Success", 
							"_message" => $this->__("Registration done successfully. Please check your mail.")
						)
					);
            }
            catch (AppException $e) {
                echo App::Load("Module/Cryptography")
					->jsonEncode(
						Array(
							"_status" => "Error", 
							"_message" => '<div class="error">' . $e->getMessage() . '</div>'
						)
					);
            }
        }
		
		$this->set("section_title", "Member Signup");
    }

    /**
     * This is a private function and
     * it can not be execute from Url
     */
    private function completeAjaxSignup()
    {
        $capacha = App::Module('Session')->read('capacha');
        if ($capacha['memberregi'] != $this->data['Member']['capacha']) throw new AppException($this->__('Please fillup the capacha text correctly'));


        // Set Signupdate and standard password
        $this->data['Member']['signup_date'] = App::Load("Helper/Date")->getDate('Y-m-d');
        $this->data['Member']['password'] = App::Module("Cryptography")->encrypt($this->data['Member']['password']);
        // Set resetid
        $resetid = App::Helper('Date')->getTime();
        $this->data['Member']['resetid'] = $resetid;

        // Save Member Data
        $errors = App::Model('Member')
            ->Save($this->data)
            ->getErrorInfo();

        if (empty($errors)) {
            // Send Email
            App::Helper('EmailTemplate')->setParameters(
                Array(
                    'FirstName' => $this->data['Member']['f_name'],
                    'LastName' => $this->data['Member']['l_name'],
                    'Email' => $this->data['Member']['email'],
                    'VerificationLink' => App::Helper("Html")
                        ->linkTag(
                        $this->baseurl("/member/verifybyemail/" . base64_encode($resetid)),
                        $this->__("Complete your registration")
                    )
                )
            )
                ->setTo(array($this->data['Member']['email'], "{$this->data['Member']['f_name']} {$this->data['Member']['l_name']}"))
                ->prepare('MemberRegistration',
                $isNotified = true);

        }
        else {
            // Throw Exception imploding all Model Errors
            throw new AppException(implode("<br>", $errors));
        }
    }

    /**
     * Verify Registration
     */
    public function verifybyemailAction($resetkey = null)
    {
        $this->layout = 'empty';
        App::Component('Members')
			->Helper('Auth')
			->verifyRegistrationByResetkey($resetkey);
    }

    /**
     * Chagne password
     *
     * @return null
     */
    public function change_passwordAction()
    {
        $this->layout = 'admin';
        $this->admin_tab = 'usersetting';
        $this->addons = array('validation');
        $member_info = App::Component('Members')->Helper('Data')->Current();
        $message = Array();
        if (!empty($this->data)) {
            if (
                $this->data['Member']['old_password'] == ''
                || $this->data['Member']['new_password'] == ''
                || $this->data['Member']['re_new_password'] == ''
            ) {
                $message = Array("type" => "error", "msg" => "Field can not be empty.");
            }
            else if (
                !App::Module("Cryptography")
                    ->checkEncrypt(
                    $this->data['Member']['old_password'],
                    $member_info['password']
                )
            ) {
                $message = Array("type" => "error", "msg" => "The old password did not matched.");
            }
            else if ($this->data['Member']['new_password'] != $this->data['Member']['re_new_password']) {
                $message = Array("type" => "error", "msg" => "New password did not match.");
            }
            else {
                App::Model('Member')
                    ->setId($member_info['id'])
                    ->setPassword(App::Module("Cryptography")->encrypt($this->data['Member']['new_password']))
                    ->Save();

                $message = Array("type" => "success", "msg" => "Password changed successfully");
            }
        }

        $this->set('message', $message);
    }

    /**
     * Example
     * Manage Member
     *
     * @parameter action string
     * @parameter id integer
     * @return null
     */
    public function manageAction($action = NULL, $id = NULL)
    {
        /*
         * Set Layout admin admin tab
         */
        $this->setAdminTab('usermanagement');
		
        $error = "";

        /**
         * Batch Delete
         */
        if (isset($this->data['Button']['Delete'])) {
            if (isset($this->data['id'])) {
                foreach ($this->data['id'] as $id) {
                    App::Model('Member')->DeleteById($id);
                }
                App::Module('Notification')->Push("Delete successfully.");
            }
            $this->redirect("/member/manage");
            exit;
        }
        /*
         * Attached Plugins during Add or Update data
         * For View addmin common admin functions
         */
        if ($action != 'update') {
            $this->addons = array('row_manager');
        }

        /*
         * Saving data if any POST request appear
         */
        if (!empty($this->data)) {
            $error = '';

            if (isset($this->data['Member']['password']) || isset($this->data['Member']['cpassword'])) {
                if ($this->data['Member']['password'] == '' or $this->data['Member']['cpassword'] == '') {
                    $error = "Please enter password";
                }
                else if ($this->data['Member']['password'] != $this->data['Member']['cpassword']) {
                    $error = "Confirm password does not match";
                }
                $this->data['Member']['password'] = App::Module("Cryptography")->encrypt($this->data['Member']['password']);
            }
            if ($error == '') {
                $this->data['Member']['id'] = isset($id) ? $id : null;
				
                $obj = App::Model('Member')
                    ->save($this->data);
                $error = $obj->getErrorInfo();
            }

            if (!empty($error)) {
                App::Module('Notification')->Push($error,'error');
            }
            else {
                App::Module('Notification')->Push("Saved Successfully");
            }

            $id = isset($id) ? $id : $obj->getId();

            if (isset($this->post['Button']['button_save_and_update']) or !empty($error)) {
                if ($id) {
                    $this->redirect("/member/manage/update/{$id}");
                    exit;
                }
            }
            else {
                $this->redirect("/member/manage");
                exit;
            }

        }

        /*
         * Feach Data for view
         */
        if ($action == 'view' || $action == 'update') {
            /* Data for singal Entry */
            $data = App::Model('Member')->findById($id);
        }
        else {
            /* List user data */
            $data = App::Model('Member')->paging();
        }

        $this->set('error', $error);
        $this->set('data_list', $data);
        $this->set('action', $action);
    }

    public function profileAction($action=null,$id = null)
    {
	
		App::Component('Members')
			->Helper('Auth')
			->checkUserLogin();
		
        if (empty($id)) {
            $id = App::Component('Members')
					->Helper('Auth')
					->LoggedInId();
        }
		
		if(!empty($this->data)){
			$this->data['Member']['id'] = $id;
            
			if($action == 'change-picture'){               
				$this->clearImage($id);
				$arr = App::Utility()
					->Upload(
						$this->data['Member']['photo'],
						App::Config()->filemanagerDir(DS)
					);
				$this->data['Member']['photo'] = $arr['file_name'];	
				
			}			
			App::Model('Member')->Save($this->data);
			$this->redirect("/profile/{$action}");
		}
		
		if($action == 'remove-picture'){
			$this->clearImage($id);
			$this->redirect("/profile/change-picture");
		}	

        $memberData = App::Model('Member')->findById($id);
		$this->page_title = "{$memberData['f_name']} {$memberData['l_name']}";
        $this->set('memberData', $memberData);
        $this->set("section_title", "Profile");
        $this->set("selected", "member");
        $this->set("id", $id);
        $this->set("action", $action);
    }
	
	private function clearImage($Member){
		if(!is_array($Member)){
			$Member = App::Model('Member')->findById($Member);
		}
		
		if(empty($Member) OR empty($Member['photo'])){
			return ;
		}

		$path = App::Config()->fileManagerDir( DS . $Member['photo']);
		if(file_exists($path)){
			unlink($path);
		}
		
		App::Model('Member')
			->setId($Member['id'])
			->setPhoto('')
			->Save();
		
	}
}
