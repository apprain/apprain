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


class Component_Members_Models_Installer_Member extends memberModel
{

    public function installerResource()
    {
		$prefix =  App::get("db_prefix");
        return  array
        (
            '0.1.0'=>
                      "	CREATE TABLE IF NOT EXISTS `{$prefix['primary']}members` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `photo` varchar(50) NOT NULL,
						  `name_title` varchar(200) NOT NULL,
						  `f_name` varchar(200) NOT NULL,
						  `l_name` varchar(200) NOT NULL,
						  `password` varchar(200) NOT NULL,
						  `email` varchar(200) NOT NULL,
						  `address` text NOT NULL,
						  `state` varchar(50) NOT NULL,
						  `zipcode` varchar(15) NOT NULL,
						  `country` varchar(50) NOT NULL,
						  `gmcoordinate` varchar(50) NOT NULL,
						  `exp_date` date NOT NULL DEFAULT '0000-00-00',
						  `website` varchar(100) NOT NULL,
						  `note` text NOT NULL,
						  `signup_date` date NOT NULL DEFAULT '0000-00-00',
						  `phone_no` varchar(50) NOT NULL,
						  `status` enum('Applied','Accepted','Active','Inactive','Defaulter') NOT NULL DEFAULT 'Applied',
						  `resetid` varchar(250) NOT NULL,
						  PRIMARY KEY (`id`),
						  UNIQUE KEY `email` (`email`)
						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;						
                      "
        );
    }
}
