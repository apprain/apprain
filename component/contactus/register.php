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
 * Component Name: Contact us
 * Auther: Reazaul Karim
 * Email: info@apprain.com
 */
class Component_Contactus_Register extends appRain_Base_Component
{
    /* Default Menu text */
    const DEFAULT_MENU_TITLE = 'Contact Us';
    const CREATE_SITE_MENU = 'Yes';

    /**
     * Initialize all resource
     * in side apprain environment.
     */
    public function init()
    {
        $Config = App::Helper('Config')->siteInfo();

        // Register CSS
        App::Module('Hook')
            ->setHookName('CSS')
            ->setAction("register_css_code")
            ->Register(get_class($this), "register_css_code");

        // Register a Controller to render page
        // and execute ajax request
        App::Module('Hook')
            ->setHookName('Controller')
            ->setAction("register_controller")
            ->Register(get_class($this), "register_controller");

        $Config['contactussettings_create_sitemenu'] = isset($Config['contactussettings_create_sitemenu']) ? $Config['contactussettings_create_sitemenu'] : self::CREATE_SITE_MENU;

        // Create a site menu
        if ($Config['contactussettings_create_sitemenu'] == 'Yes') {
            App::Module('Hook')
                ->setHookName('Sitemenu')
                ->setAction("register_sitemenu")
                ->Register(get_class($this), "register_sitemenu");
        }


        App::Module('Hook')
            ->setHookName('Sitesettings')
            ->setAction("register_definition")
            ->Register(get_class($this), "register_sitesettings_defination");

        App::Module('Hook')
            ->setHookName('InterfaceBuilder')
            ->setAction("update_definition")
            ->Register(get_class($this), "interfacebuilder_update_definition");
    }

    public function init_on_install()
    {
        App::Module('Emailtemplate')
            ->load(
            Array(
                "message" => "Following message sen by {FirstName}{LastName}\n\n{Message}\n\n<hr />\n\nSubject:  {Subject}\n\nSender Email:  {Email}\n\n<a href=\"{baseurl}\">View Website</a> <a href=\"{baseurl}/admin\">View Admin</a>",
                "subject" => "One message sent  by {FirstName}{LastName}",
                "templateType" => "ContactUs"
            )
        );

        App::PageManager()
            ->setTitle('Contact Us')
            ->setPageTitle('Contact Us')
            ->setContent("<p>\r\n	Duis arcu elit, rutrum a interdum quis, vulputate et diam. Mauris eleifend cursus tortor. Sed ut leo quis nisi vehicula sagittis. Maecenas sed nisl at quam vulputate mattis in nec sapien. Etiam vel massa in eros sodales bibendum. Vestibulum ut urna cursus lectus sodales facilisis vel vitae sem. Aenean a nisl ut nulla ullamcorper tristique non quis sem.<br />\r\n	<br />\r\n	<strong>Vestibulum at orci a velit varius</strong><br />\r\n	45/B consectetur quis sit amet<br />\r\n	diam. <br />\r\n	phasellus@eget felis.purus.</p>\r\n")
            ->LoadInDB('contact-us');
    }

    public function init_on_uninstall()
    {
    }

    public function register_css_code()
    {
        return App::Helper('Utility')->fetchFile($this->attachMyPath('css/styles.css'));
    }

    public function register_controller()
    {
        $srcpaths = Array();
        $srcpaths[] = array(
            'name' => 'Contactus',
            'controller_path' => $this->attachMyPath('controllers')
        );

        return $srcpaths;
    }

    public function register_sitemenu($send)
    {
        $settings = App::Helper('Config')->siteInfo('contactussettings');

        $menu = Array();
        $menu[] = Array(
            App::Helper('Config')->baseurl("/contactus"),
            (isset($settings['contactussettings_title']) ? $settings['contactussettings_title'] : self::DEFAULT_MENU_TITLE),
            'contactus'
        );

        return $menu;
    }

    public function register_sitesettings_defination()
    {
        $srcpaths = Array();
        $srcpaths[] = $this->attachMyPath('sitesettings/settings.xml');

        return array(
            'filepaths' => $srcpaths
        );
    }

    public function interfacebuilder_update_definition($send)
    {
        if (isset($send['component']['child'])) {
            $send['component']['child'][] = Array(
                "title" => "Contact Us",
                "items" => Array(
                    Array(
                        "title" => "Settings",
                        "link" => "/admin/config/contactussettings"
                    )
                ),
                "adminicon" => array(
                    "type" => "filePath",
                    'location' => '/component/contactus/icon/logo.jpg'
                )
            );

            return $send;
        }
    }
}