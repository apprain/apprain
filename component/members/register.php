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

class Component_Members_Register extends appRain_Base_Component
{
    public function init()
    {
        App::Module('Hook')
            ->setHookName('Controller')
            ->setAction("register_controller")
            ->Register(get_class($this), "register_controller");

        App::Module('Hook')
            ->setHookName('InterfaceBuilder')
            ->setAction("update_definition")
            ->Register(get_class($this), "interfacebuilder_update_definition");

      	App::Module('Hook')->setHookName('URIManager')
			->setAction("on_initialize")
			->Register(get_class($this),"register_newrole");
			
		App::Module('Hook')->setHookName('UI')
            ->setAction("template_header_B")
            ->Register(get_class($this),"header_links");	
			
		App::Module('Hook')->setHookName('Model')
            ->setAction("register_model")
            ->Register(get_class($this),"register_model");			
			
    }

    public function init_on_install()
    {
	        App::Helper('EmailTemplate')
            ->Load(
                array(
                    'templateType' => 'MemberRegistration',
                    'subject' => 'Registration Verification Request',
                    'message' => "Dear {FirstName} {LastName},\n\n" .
								 "Thank you for the registration with us. Please click bellow link to activate account:\n\n" .
								 "{VerificationLink}\n\n" .
								 "For further help please contact us at info@example.com\n\n" .
								 "Regards" 
							
                )
            );

	        App::Helper('EmailTemplate')
            ->Load(
                array(
                    'templateType' => 'ForgotPassword',
                    'subject' => 'Password Reset Request',
                    'message' => "Dear {FirstName} {LastName},\n\n" .
								 "Thank you for password request. Please click bellow link to chnage account password:\n\n" .
								 "{PasswordResetLink}\n\n" .
								 "For further help please contact us at info@example.com\n\n" .
								 "Regards" 
							
                )
            );
			
		App::PageManager()
		   ->setPagetitle ('Member signup ')
		   ->setTitle('Member Registration')
		   ->setContent('<p>Dolor sit amet, consectetur adipiscing elit. Nullam accumsan, arcu sit amet tincidunt aliquam, massa enim elementum mi, sit amet posuere nulla velit vel nunc. Curabitur convallis dolor tristique dui tincidunt eu adipiscing ligula lobortis. Mauris cursus ligula diam. Fusce non lacus vel risus lacinia pellentesque eget ac justo. Morbi porta ipsum velit, sed sodales nulla.<br />	<br />	Integer sed ante magna, at gravida elit. Vivamus consectetur consequat justo, nec vulputate diam tincidunt et. Nunc in diam vitae tortor scelerisque dictum a faucibus augue. Praesent adipiscing ipsum a nunc porta non porttitor ipsum iaculis. Etiam gravida, nisi in mollis molestie, nisi orci molestie turpis, aliquet tincidunt ante diam non turpis.<br />	<br />	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam accumsan, arcu sit amet tincidunt aliquam, massa enim elementum mi, sit amet posuere nulla velit vel nunc. Curabitur convallis dolor tristique dui tincidunt eu adipiscing ligula lobortis. Mauris cursus ligula diam. Fusce non lacus vel risus lacinia pellentesque eget ac justo. Morbi porta ipsum velit, sed sodales nulla.</p>')
		   ->LoadInDB('membersignup');
    }

    public function init_on_uninstall()
    {
    }

    public function register_controller()
    {
        $srcpaths = Array();
        $srcpaths[] = array(
            'name' => 'member',
            'controller_path' => $this->attachMyPath('controllers')
        );
        return $srcpaths;
    }

    public function interfacebuilder_update_definition($send)
    {
        if (isset($send['usermanagement']['child'])) {
            $send['usermanagement']['child'][] = Array(
                "title" => "Members",
                "items" => Array(
                    array(
                        "title" => "Create a Member",
                        "link" => "/member/manage/add"
                    ),
                    array(
                        "title" => "Mange Members",
                        "link" => "/member/manage"
                    )
                ),
                "adminicon" => array(
                    "type" => "filePath",
                    'location' => '/component/members/icon/logo.jpg'
                )
            );

            return $send;
        }
    }


	
	public function register_newrole($def=null)
    {
        $def['pagerouter'][] = array(
			"actual"=>Array("member","login"),
			"virtual"=>Array("login")
		);
		
		$def['pagerouter'][] = array(
			"actual"=>Array("member","signup"),
			"virtual"=>Array("signup")
		);
		
		$def['pagerouter'][] = array(
			"actual"=>Array("member","forgotlogin"),
			"virtual"=>Array("forgot-login")
		);
		
		$def['pagerouter'][] = array(
			"actual"=>Array("member","profile"),
			"virtual"=>Array("profile")
		);
		
        return $def;
    }	
	
	public function header_links($send)
	{
		if(App::Component('Members')->Helper('Auth')->LoggedInId()){
			return
                '<li>'.
                App::Html()
				->linkTag(
					App::Config()->baseUrl('/profile'),
					'Profile'
				) . '</li><li>' . App::Html()
				->linkTag(
					App::Config()->baseUrl('/member/logout'),
					'Logout'
				) .
                '</li>';
		}
		else{
			return 
			 
                '<li>'.			
				App::Html()
				->linkTag(
					App::Config()->baseUrl('/login'),
					'Login'
				) 
				. '</li><li>' .
				App::Html()
					->linkTag(
						App::Config()->baseUrl('/signup'),
						'Signup'
					)
				.'</li>';
		}
	}	
	
	public function register_model()
    {
        $srcpaths = Array();
        $srcpaths[] =   array(
			'name'=>'Member',
            'model_path'=>$this->attachMyPath('models')
		);
        return $srcpaths;
    }	
}