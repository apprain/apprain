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

class Component_Tablesorter_Register extends appRain_Base_Component
{
    public function init()
    {
		
		App::Module('Hook')
            ->setHookName('CSS')
            ->setAction("register_css_code")
            ->Register(get_class($this),"register_css_code");

		App::Module('Hook')->setHookName('Addon')
            ->setAction("register_addon")
            ->Register(get_class($this),"register_addon_defination");

    }

    public function init_on_install(){}

	public function init_on_uninstall(){}

	public function register_addon_defination()
    {
        $srcpaths = Array();
        $srcpaths[] =   array(
			'type'=>'tablesorter',
            'path'=>$this->attachMyPath('addons/tablesorter.xml')
		);
        return $srcpaths;
    }	
	
	 public function register_css_code()
    {
		return '
			.data-grid th {
				padding-right: 20px;
			}
		
		';
    }
}