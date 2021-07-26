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
 * @copyright  Copyright (c) 2010 appRain, Inc. (http://www.apprain.org)
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
 * http ://www.apprain.org/documents
 */
class appslideController extends appRain_Base_Core
{
    public $name = 'appSlide';
    
    public function __preDispatch(){}

    public function indexAction($id=null)
    {
        // Section run for AJAX request
        // so we have set layout to empty
        if(isset($id))  {
            $this->layout="empty";
            $data  = App::InformationSet('appslide')->findById($id);
			//$data['description'] = App::Helper('Utility')->codeFormated($data['description']);
            echo "{$data['description']}";
        }
        exit;
    }
}
