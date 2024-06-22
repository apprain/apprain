-- query
DROP TABLE IF EXISTS {_prefix_}administrators;
-- query
CREATE TABLE `{_prefix_}administrators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupid` int(11) NOT NULL,
  `f_name` varchar(50) NOT NULL,
  `l_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `createdate` datetime NOT NULL,
  `latestlogin` int(11) NOT NULL,
  `lastlogin` int(11) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `type` enum('Super','Normal') NOT NULL DEFAULT 'Normal',
  `acl` text NOT NULL,
  `aclobject` text NOT NULL,
  `description` text NOT NULL,
  `resetsid` varchar(200) NOT NULL,
  `lastresettime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
-- query
INSERT INTO {_prefix_}administrators VALUES ('1','0','Website','Administrator','admin','21232f297a57a5a743894a0e4a801fc3','info@site.com','2024-06-21 08:23:44','1719016595','1719002490','Active','Super','','','','','1718951024');
-- query
DROP TABLE IF EXISTS {_prefix_}appreportcodes;
-- query
CREATE TABLE `{_prefix_}appreportcodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `groups` varchar(100) NOT NULL,
  `code` text NOT NULL,
  `dated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
-- query
INSERT INTO {_prefix_}appreportcodes VALUES ('1','1','All User Report','1','1519835753.arbt','2023-04-16 23:12:18');
-- query
DROP TABLE IF EXISTS {_prefix_}appslide;
-- query
CREATE TABLE `{_prefix_}appslide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminref` int(11) NOT NULL,
  `entrydate` datetime NOT NULL DEFAULT '2012-08-18 10:08:56',
  `lastmodified` datetime NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- query
DROP TABLE IF EXISTS {_prefix_}categories;
-- query
CREATE TABLE `{_prefix_}categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkey` int(11) NOT NULL DEFAULT 0,
  `adminref` int(11) NOT NULL DEFAULT 0,
  `parentid` int(11) NOT NULL DEFAULT 0,
  `image` varchar(200) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `generic` varchar(250) NOT NULL,
  `entrydate` datetime NOT NULL,
  `lastmodified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
-- query
INSERT INTO {_prefix_}categories VALUES ('1','0','1','0','','Common Reports','','appreportgroup','','2023-04-16 23:11:11','2023-04-16 23:11:11');
-- query
DROP TABLE IF EXISTS {_prefix_}coreresources;
-- query
CREATE TABLE `{_prefix_}coreresources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `type` enum('Model','Module','Plugin','Component') NOT NULL DEFAULT 'Model',
  `version` varchar(200) NOT NULL DEFAULT '',
  `status` enum('Active','Inactive') NOT NULL,
  `info` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
-- query
INSERT INTO {_prefix_}coreresources VALUES ('1','Admin','Model','0.1.0','Active','');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('2','Category','Model','0.1.0','Active','');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('3','Config','Model','0.1.0','Active','');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('4','Coreresource','Model','0.1.0','Active','');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('5','Developer','Model','0.1.0','Active','');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('6','Home','Model','0.1.0','Active','');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('7','Information','Model','0.1.0','Active','');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('8','Log','Model','0.1.0','Active','');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('9','Page','Model','0.1.0','Active','');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('10','appeditor','Component','0.1.7','Active','a:1:{s:11:"installdate";s:19:"2021-07-26 06:54:52";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('11','appslide','Component','0.1.0','Inactive','a:1:{s:11:"installdate";s:19:"2023-04-19 23:41:14";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('12','homepress','Component','0.1.0','Inactive','a:1:{s:11:"installdate";s:19:"2024-06-22 07:46:40";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('13','pagemanager','Component','1.2.6','Active','a:1:{s:11:"installdate";s:19:"2021-07-26 22:18:13";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('14','adminpanelquicklaunch','Component','1.0.1','Inactive','a:1:{s:11:"installdate";s:19:"2024-06-22 07:32:40";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('15','dbexpert','Component','0.1.2','Active','a:1:{s:11:"installdate";s:19:"2021-07-26 22:51:31";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('16','ethical','Component','2.1.1','Inactive','a:1:{s:11:"installdate";s:19:"2024-06-22 07:46:28";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('17','appreport','Component','2.1.1','Inactive','a:1:{s:11:"installdate";s:19:"2024-06-22 07:43:25";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('18','Appreportcode','Model','0.1.0','Active','');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('19','messenger','Component','2.0.0','Inactive','a:1:{s:11:"installdate";s:19:"2023-04-19 23:41:49";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('20','Message','Model','0.1.0','Active','');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('21','Notification','Model','0.1.0','Active','');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('22','contactus','Component','0.1.1','Inactive','a:1:{s:11:"installdate";s:19:"2024-06-22 07:46:45";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('23','tablesorter','Component','1.0.2','Active','a:1:{s:11:"installdate";s:19:"2023-04-19 23:41:55";}');
-- query
DROP TABLE IF EXISTS {_prefix_}emailtemplate;
-- query
CREATE TABLE `{_prefix_}emailtemplate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminref` int(11) NOT NULL,
  `entrydate` datetime NOT NULL DEFAULT '2012-08-22 15:59:32',
  `lastmodified` datetime NOT NULL,
  `templatetype` varchar(100) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
-- query
INSERT INTO {_prefix_}emailtemplate VALUES ('1','1','2012-08-22 15:59:32','2023-04-19 23:41:18','ContactUs','One message sent  by {FirstName}{LastName}','Following message sen by {FirstName}{LastName}

{Message}

<hr />

Subject:  {Subject}

Sender Email:  {Email}

<a href="{baseurl}">View Website</a> <a href="{baseurl}/admin">View Admin</a>');
-- query
DROP TABLE IF EXISTS {_prefix_}homepress;
-- query
CREATE TABLE `{_prefix_}homepress` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminref` int(11) NOT NULL,
  `entrydate` datetime NOT NULL DEFAULT '2016-05-04 19:12:42',
  `lastmodified` datetime NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `shortdesc` text NOT NULL,
  `linkedto` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `position` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
-- query
DROP TABLE IF EXISTS {_prefix_}log;
-- query
CREATE TABLE `{_prefix_}log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkey` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `dated` datetime NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
-- query
DROP TABLE IF EXISTS {_prefix_}messages;
-- query
CREATE TABLE `{_prefix_}messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL,
  `sendertitle` varchar(50) NOT NULL,
  `senderid` varchar(50) NOT NULL,
  `receivedid` varchar(50) NOT NULL,
  `session` varchar(15) NOT NULL,
  `message` varchar(200) NOT NULL,
  `imagelink` text NOT NULL,
  `readerstatus` char(1) NOT NULL,
  `timestamp` varchar(15) NOT NULL,
  `entrydate` datetime NOT NULL,
  `type` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- query
DROP TABLE IF EXISTS {_prefix_}notifications;
-- query
CREATE TABLE `{_prefix_}notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `channel` varchar(20) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `timestamp` varchar(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
-- query
DROP TABLE IF EXISTS {_prefix_}pages;
-- query
CREATE TABLE `{_prefix_}pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkey` int(11) NOT NULL DEFAULT 0,
  `page_title` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `name` varchar(200) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `hook` varchar(255) NOT NULL,
  `userdefinehook` varchar(256) NOT NULL,
  `richtexteditor` enum('Yes','No') NOT NULL,
  `rendertype` enum('h_link','smart_h_link','text') NOT NULL,
  `contenttype` enum('Content','Snip') NOT NULL DEFAULT 'Content',
  `sort_order` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fkey` (`fkey`,`name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
-- query
INSERT INTO {_prefix_}pages VALUES ('1','0','About appRain Content Management Framework','','','aboutus','About Us','<div>
<p>appRain is one of the first officially released open-source content management frameworks (CMF). CMF is a new, web engineering concept where a content management system (CMS) and a rapid development framework perform side-by-side to produce endless varieties of output in a very limited time.</p>

<p>appRain is developed on a daily basis, drawing on extensive project experience. A common problem that we all face in a framework is that we need to re-develop some common modules in each project. With content management systems, we sometimes get stuck driving our development based on the strict conventions the system enforces. Why is there no CMS integrated with a framework? This is the question that gave birth to appRain.</p>

<p>Content management systems and frameworks are very popular in web development. These two technologies work in different ways. One is used for rapid development, the other for more customized output. appRain merges these two technologies. appRain is fast, flexible, and makes it easy to complete tasks in a very short time period. It can be expanded and scaled.</p>

<p>The tools in the CMS component of appRain are all configurable, making development faster. It helps to avoid repeating tasks. The framework component is used when it becomes too difficult to complete your requirements using the CMS tools. The framework contains all of the core programming tools.</p>

<p>appRain aims to make creating web technology simple and easily optimized.</p>
</div>
','sitemenu','','Yes','text','Content','1');
-- query
DROP TABLE IF EXISTS {_prefix_}sconfigs;
-- query
CREATE TABLE `{_prefix_}sconfigs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkey` int(11) NOT NULL DEFAULT 0,
  `soption` text NOT NULL,
  `svalue` text NOT NULL,
  `sort_order` varchar(5) NOT NULL,
  `section` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=228 DEFAULT CHARSET=utf8;
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('1','0','theme','rainyday','0','hidden');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('2','0','site_logo','','','themesettings');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('3','0','default_pagination','50','19','general');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('4','0','time_zone','Asia/Dhaka','23','general');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('5','0','copy_right_text','Copyright Apprain Technologies, www.apprain.org.','','general');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('6','0','site_title','Start with appRain','','');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('7','0','admin_title','Start with appRain Admin','','');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('8','0','admin_email','info@site.com','','');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('9','0','activity_widget','Yes','','');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('10','0','leave_amessage_widget','Yes','','');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('11','0','disable_quick_links','No','','themesettings');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('12','0','whitecloud_disable_footer','No','','themesettings');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('13','0','whitecloud_background_position','bgstartfromtop','','themesettings');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('15','0','appslidesettings_displaymode','ajaxbased','','appslidesettings');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('18','0','site_homepage_layout','default','','themesettings');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('19','0','site_pageview_layout','single_column_layout','','themesettings');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('20','0','site_defaultview_layout','default','','themesettings');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('21','0','flash_file_uploader','Yes','','');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('31','0','add_new_page_in_menu_automarically','Yes','','opts');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('32','0','disable_page_meta_options','Yes','','opts');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('33','0','disable_menu_icon','No','','opts');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('34','0','quick_navigation_widget','Yes','','opts');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('35','0','currency','BDT','','opts');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('36','0','is_site_alive','Yes','','opts');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('37','0','large_image_width','500','','opts');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('38','0','large_image_height','500','','opts');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('39','0','rich_text_editor','Yes','','opts');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('40','0','emailsetup_enabled','No','','opts');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('41','0','emailsetup_host','localhost','','opts');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('42','0','emailsetup_port','25','','opts');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('43','0','emailsetup_username','','','opts');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('44','0','emailsetup_password','','','opts');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('52','0','support_email','support@apprain.com','','general');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('207','0','admin_landing_page','admin/introduction','','opts');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('128','0','business_date','','','businessdate');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('129','0','business_time','','','businessdate');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('154','0','fileresource_id','','','opts');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('155','0','db_version','2.5.4','','opts');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('158','0','time_zone_padding','','','opts');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('181','0','language','default','','');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('186','0','adminpanel_quick_launch','{"/admin/manage":{"title":"Manage Users","iconpath":"/themeroot/admin/images/icons/info.jpg","mylink":"/admin/manage","fetchtype":"URL"},"/appreport/executor":{"title":"Reports","iconpath":"/component/appreport/interface_builder/icon.jpg","mylink":"/appreport/executor","fetchtype":"FilePath"},"/page/manage-static-pages":{"title":"Static Page","iconpath":"/themeroot/admin/images/icons/info.jpg","mylink":"/page/manage-static-pages","fetchtype":"URL"},"/page/manage-dynamic-pages":{"title":"Dynamic Page","iconpath":"/themeroot/admin/images/icons/info.jpg","mylink":"/page/manage-dynamic-pages","fetchtype":"URL"}}','','');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('191','0','quick_navigation_show_calander','Yes','','opts');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('192','0','emailsetup_from_email','','','opts');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('209','0','logo','','','general');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('214','0','last_synced','','','');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('215','0','last_message_board_synced','','','');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('220','0','contactussettings_title','Contact Us','','contactussettings');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('221','0','contactussettings_replay_email_title','','','contactussettings');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('222','0','contactussettings_replay_email','','','contactussettings');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('223','0','contactussettings_create_sitemenu','Yes','','contactussettings');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('224','0','homepresssettings_title','Quick Links','','homepresssettings');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('225','0','homepresssettings_displaymode','TextBased','','homepresssettings');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('226','0','homepresssettings_box_per_row','4','','homepresssettings');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('227','0','homepresssettings_displaybox','Yes','','homepresssettings');
