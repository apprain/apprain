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
class  Component_Members_Helpers_Auth extends appRain_Base_Objects
{
    const STATUS_ACTIVE = 'Active';
   
    public function loggedInId()
    {
         $userSession = App::Module("Session")->read('AppUser');
        return isset($userSession['id']) ? $userSession['id'] : App::SUPERADMINLOGINID;
    }

   
    public function isLoggedIn()
    {

        $appuser = app::load("Module/Session")->read('AppUser');
        return empty($appuser) ? false : true;
    }

    public function checkUserLogin()
    {
        if (!$this->isLoggedIn()) {
            App::Helper('Config')->redirect("/login");
            exit;
        }
        else {
            return App::load("Module/Session")->read('AppUser');
        }
    }
    
    public function verifyRegistrationByResetkey($resetid = null)
    {
        $resetid = base64_decode($resetid);
        $memberInfo = App::Model('Member')->findByResetid($resetid);

        if (!empty($memberInfo)) {
            $obj = App::Model('Member')
                ->setId($memberInfo['id'])
                ->setStatus(self::STATUS_ACTIVE)
                ->setResetid('')
                ->Save();

            App::Helper('Config')
                ->transfer(
                App::Helper('Config')->baseurl('/member/login'),
                "Activation Completed..."
            );

        }
        else {
            App::Helper('Config')
                ->transfer(
                App::Helper('Config')->baseurl('/')
                , "Link Expired!"
            );
        }
    }
}