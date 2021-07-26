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

/**
 *  Component Name: Contact us
 *  Auther : Reazaul Karim
 *  E-mail: info@apprain.com
 */
class contactusController extends appRain_Base_Core
{
    /**
     * Controller Name
     */
    public $name = 'Contactus';

    /**
     * Execute before the action
     */
    public function __preDispatch()
    {
    }

    /**
     * Execute to response the ajax call
     */
    public function indexAction($action = null, $id = null, $page = 1)
    {

        $siteInfo = App::Helper('Config')->siteInfo();

        // Attach all necessary addons
        $this->addons = Array('defaultvalues', 'form');

        // Set meta information and fetch data
        // from Page Manager
        $staticpage = $this->staticPageNameToMetaInfo('contact-us');

        // This section run if there is any
        // submit by POST method.
        if (!empty($this->data) && isset($this->data['Contact'])) {
            
			$this->layout = 'empty';
			
            try {
                // Read capacha session value
                $capacha = App::Module('Session')->read('capacha');
                // Compare capacha value and throw exception
                // for Invalid Input
				if(!isset($capacha['contactus'])){
					throw new AppException($this->__("Capacha expired, please try again later."));
				}
				
                if ($capacha['contactus'] != $this->data['Contact']['capacha']) {
                    throw new AppException($this->__("Please fillin the text display left side image correctly."));
                }
				
				$this->data['Contact']['l_name'] = isset($this->data['Contact']['l_name']) ? $this->data['Contact']['l_name'] : '';
				
                // Prepare Email template Parameters
                $params = Array(
                    'FirstName' => $this->data['Contact']['f_name'],
                    'LastName' => $this->data['Contact']['l_name'],
                    'Email' => $this->data['Contact']['email'],
                    'Phoneno' => $this->data['Contact']['phoneno'],
                    'Message' => $this->data['Contact']['message']
                );

                // Prepare tempate and send to User.
                // We can set a specific reciver by a magic
                // method setTo(Array('email','name')) also
                // sender like setFrom(Array('email','name'))
                $ETObj = App::Helper('EmailTemplate')->setParameters($params);
                if (isset($siteInfo['contactussettings_replay_email']) && $siteInfo['contactussettings_replay_email'] != "") {
                    $ETObj->setFrom(array($siteInfo['contactussettings_replay_email'], $siteInfo['contactussettings_replay_email_title']));
                }
                $ETObj->prepare('ContactUs',true);

                // Throw final exception with Success status
                // We also do that by displaying the message and status
                // in JSON format without throwing Exception.
                $status = 'Success';
                throw new AppException($this->__("Thank you, Message sent successfully."));
            }
            catch (AppException $e) {
                // Simple pack the data in JSON format and
                // display the outpost for AJAX module
                echo App::Load("Module/Cryptography")
                    ->jsonEncode(
                    array(
                        "_status" => (isset($status) ? $status : 'Error'),
                        "_message" => $e->getMessage()
                    )
                );
            }
        }

        // Set common values in template
        $this->set("staticpage", $staticpage);
        $this->set("selected", "contactus");
        $this->set("section_title", "Contact Us");
    }
}
