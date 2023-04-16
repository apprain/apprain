-- query
DROP TABLE IF EXISTS app_administrators;
-- query
CREATE TABLE `app_administrators` (
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
INSERT INTO app_administrators VALUES ('1','0','Website','Administrator','admin','21232f297a57a5a743894a0e4a801fc3','info@site.com','2023-03-08 16:08:36','1681539042','1681511121','Active','Super','','','','','1678288116');
-- query
DROP TABLE IF EXISTS app_appreportcodes;
-- query
CREATE TABLE `app_appreportcodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `groups` varchar(100) NOT NULL,
  `code` text NOT NULL,
  `dated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;
-- query
INSERT INTO app_appreportcodes VALUES ('1','1','Test Report','1','1519835753.arbt','2021-07-26 23:16:05');
-- query
DROP TABLE IF EXISTS app_appslide;
-- query
CREATE TABLE `app_appslide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminref` int(11) NOT NULL,
  `entrydate` datetime NOT NULL DEFAULT '2012-08-18 10:08:56',
  `lastmodified` datetime NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
-- query
INSERT INTO app_appslide VALUES ('1','1','2015-06-18 12:25:11','2016-06-15 17:08:08','appRain CMS','CMS.png','<h1>appRain CMS</h1>

<p>appRain helps you to develop web based software with effortless try. Install it by simple wizard and add necessary plug-in to meet up self or client demand. Use this part of appRain to start your development without high level technical knowledge.</p>

<h3>Make development 100% faster</h3>
','Active');
-- query
INSERT INTO app_appslide VALUES ('2','1','2015-06-18 12:25:11','2016-06-15 17:07:59','appRain Framework','Framework.png','<h1>appRain Framework</h1>

<p>appRain Framework is open for you, this is simply a large platform to make your work robust. Environment is organized with latest programming patterns and easy to extend in any edge of reusable development to make you well-built.</p>

<h3>For robast development</h3>
','Active');
-- query
DROP TABLE IF EXISTS app_categories;
-- query
CREATE TABLE `app_categories` (
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
INSERT INTO app_categories VALUES ('1','0','1','0','','Test','','appreportgroup','','2021-07-26 23:15:57','2021-07-26 23:15:57');
-- query
DROP TABLE IF EXISTS app_coreresources;
-- query
CREATE TABLE `app_coreresources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `type` enum('Model','Module','Plugin','Component') NOT NULL DEFAULT 'Model',
  `version` varchar(200) NOT NULL DEFAULT '',
  `status` enum('Active','Inactive') NOT NULL,
  `info` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
-- query
INSERT INTO app_coreresources VALUES ('1','Admin','Model','0.1.0','Active','');
-- query
INSERT INTO app_coreresources VALUES ('2','Category','Model','0.1.0','Active','');
-- query
INSERT INTO app_coreresources VALUES ('3','Config','Model','0.1.0','Active','');
-- query
INSERT INTO app_coreresources VALUES ('4','Coreresource','Model','0.1.0','Active','');
-- query
INSERT INTO app_coreresources VALUES ('5','Developer','Model','0.1.0','Active','');
-- query
INSERT INTO app_coreresources VALUES ('6','Home','Model','0.1.0','Active','');
-- query
INSERT INTO app_coreresources VALUES ('7','Information','Model','0.1.0','Active','');
-- query
INSERT INTO app_coreresources VALUES ('8','Log','Model','0.1.0','Active','');
-- query
INSERT INTO app_coreresources VALUES ('9','Page','Model','0.1.0','Active','');
-- query
INSERT INTO app_coreresources VALUES ('10','appeditor','Component','0.1.7','Active','a:1:{s:11:"installdate";s:19:"2021-07-26 06:54:52";}');
-- query
INSERT INTO app_coreresources VALUES ('11','appslide','Component','0.1.0','Active','a:1:{s:11:"installdate";s:19:"2021-07-26 06:54:55";}');
-- query
INSERT INTO app_coreresources VALUES ('12','homepress','Component','0.1.0','Active','a:1:{s:11:"installdate";s:19:"2021-07-26 06:55:04";}');
-- query
INSERT INTO app_coreresources VALUES ('13','pagemanager','Component','1.2.6','Active','a:1:{s:11:"installdate";s:19:"2021-07-26 22:18:13";}');
-- query
INSERT INTO app_coreresources VALUES ('14','adminpanelquicklaunch','Component','1.0.1','Inactive','a:1:{s:11:"installdate";s:19:"2021-07-26 23:06:37";}');
-- query
INSERT INTO app_coreresources VALUES ('15','dbexpert','Component','0.1.2','Active','a:1:{s:11:"installdate";s:19:"2021-07-26 22:51:31";}');
-- query
INSERT INTO app_coreresources VALUES ('16','ethical','Component','2.1.1','Active','a:1:{s:11:"installdate";s:19:"2021-07-26 23:06:08";}');
-- query
INSERT INTO app_coreresources VALUES ('17','appreport','Component','2.1.1','Active','a:1:{s:11:"installdate";s:19:"2021-07-26 23:06:40";}');
-- query
INSERT INTO app_coreresources VALUES ('18','Appreportcode','Model','0.1.0','Active','');
-- query
DROP TABLE IF EXISTS app_emailtemplate;
-- query
CREATE TABLE `app_emailtemplate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminref` int(11) NOT NULL,
  `entrydate` datetime NOT NULL DEFAULT '2012-08-22 15:59:32',
  `lastmodified` datetime NOT NULL,
  `templatetype` varchar(100) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
-- query
INSERT INTO app_emailtemplate VALUES ('1','1','2012-08-22 15:59:32','2020-03-18 11:38:45','InventoryReachedCriticalQuantity','Refill your inventory urgently','Dear Concern,
Following product has  reached critical quantity. Refill your inventory urgently. 

<strong>Product Information:</strong>
ID:{id}, Name: {title}, Qty:  {qty}

<hr />
<a href="{baseurl}/admin"></a>');
-- query
INSERT INTO app_emailtemplate VALUES ('2','1','2012-08-22 15:59:32','2020-03-18 11:38:45','InventoryAdjusted','Inventory has been adjusted','Dear Concern,
Following product has been adjusted. 

<strong>Product Name:</strong>
 {title} 
<strong>Quantity Reached:</strong>
 {qty} 


<hr />
<a href="{baseurl}/admin">View Admin Panel</a>');
-- query
INSERT INTO app_emailtemplate VALUES ('3','1','2012-08-22 15:59:32','2020-03-18 11:38:45','StorePaymentSuccessAdmin','One Order completed successfully','Dear Admin,
Order has been completed successfully. Please find the attached invoice.

You order is id : {OrderId}.


<hr />
<a href="{baseurl}">View Website</a>
<a href="{baseurl}/admin">Admin Panel</a>');
-- query
INSERT INTO app_emailtemplate VALUES ('4','1','2012-08-22 15:59:32','2020-03-18 11:38:45','StorePaymentSuccessCustomer','Order completed successfully','Dear Customer,
Congratulation! Order has been completed successfully. Please find the attached invoice.

You order is id : {OrderId}.

Please contact us at info@example.com or call us at 0123456789 for any further assistance.


<hr />
<a href="{baseurl}">View Website</a>
<a href="{baseurl}/admin">Admin Panel</a>');
-- query
INSERT INTO app_emailtemplate VALUES ('5','1','2012-08-22 15:59:32','2020-03-18 11:38:45','StorePaymentFailedAdmin','One Order completed unsuccessfully','Dear Admin,
One of the order has been unsuccessful. Please take necessary Steps
Order Id: {OrderId} <a href="{baseurl}/managestore/orders/view/{OrderId}">View Order</a>
Customer Information:
Name: {BillingFirstName} {BillingLastName} unsuccessfully 
Email: {BillingEmail}
Phone No: {BillingPhone}


<hr />
<a href="{baseurl}">View Website</a>
<a href="{baseurl}/admin">Admin Panel</a>');
-- query
INSERT INTO app_emailtemplate VALUES ('6','1','2012-08-22 15:59:32','2020-03-18 11:38:45','StorePaymentFailedCustomer','Order unsuccessful notification','Dear Customer,
Unfortunately your payment did not complete successfully.
Order Id: {OrderId}

Please contact us at info@example.com or call us at 0123456789 for any further assistance.


<hr />
<a href="{baseurl}">View Website</a>
<a href="{baseurl}/admin">Admin Panel</a>');
-- query
DROP TABLE IF EXISTS app_homepress;
-- query
CREATE TABLE `app_homepress` (
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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
-- query
INSERT INTO app_homepress VALUES ('1','1','2016-05-04 19:12:42','2016-06-15 17:07:29','Page Manager','InkPot.jpg','','2','Active','template_left_column_A');
-- query
INSERT INTO app_homepress VALUES ('2','1','2016-05-04 19:12:42','2016-06-28 16:14:31','appRain Background','About.jpg','<p>appRain aims to make creating web technology simplified and easily optimized.It makes live easily dynamic.</p>
','9','Active','home_content_area_D');
-- query
INSERT INTO app_homepress VALUES ('3','1','2016-05-04 19:12:42','2016-06-28 16:16:08','Concept of Development','Concept.jpg','<p>appRain has both ready-made and un-stitched tool, we just have to use it as per need following the conversions</p>
','4','Active','home_content_area_D');
-- query
INSERT INTO app_homepress VALUES ('4','1','2016-05-04 19:12:42','2016-06-28 16:17:34','General Help Center','Help.jpg','<p>Manuals are ready online for User, Developer and learners. Also, you can download or print as you need</p>
','8','Active','home_content_area_D');
-- query
INSERT INTO app_homepress VALUES ('5','1','2016-05-04 19:12:42','2016-06-15 17:06:57','Every chance','Theme.jpg','','6','Active','template_left_column_A');
-- query
INSERT INTO app_homepress VALUES ('6','1','2016-05-04 19:12:42','2016-06-15 17:06:49','Offer','Engin.jpg','','9','Active','template_left_column_A');
-- query
DROP TABLE IF EXISTS app_log;
-- query
CREATE TABLE `app_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkey` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `dated` datetime NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
-- query
INSERT INTO app_log VALUES ('1','1','DataDeleted','2021-06-12 00:56:43','a:1:{i:0;a:10:{s:2:"id";s:2:"23";s:8:"adminref";s:1:"1";s:9:"entrydate";s:19:"2015-07-16 23:58:58";s:12:"lastmodified";s:19:"2017-06-10 14:49:07";s:4:"name";s:8:"INTEREST";s:4:"code";s:8:"INTEREST";s:12:"shortcomment";s:8:"INTEREST";s:6:"linked";s:2:"No";s:10:"inverntory";s:2:"No";s:9:"financial";s:3:"Yes";}}');
-- query
INSERT INTO app_log VALUES ('2','1','DataDeleted','2021-06-12 00:57:06','a:1:{i:0;a:11:{s:2:"id";s:4:"1799";s:4:"fkey";s:1:"0";s:8:"adminref";s:1:"1";s:8:"parentid";s:1:"0";s:5:"image";s:0:"";s:5:"title";s:24:"GENERAL EXPENSE OUTLET 2";s:11:"description";s:0:"";s:4:"type";s:17:"accopttemplategrp";s:7:"generic";s:0:"";s:9:"entrydate";s:19:"2020-09-04 21:12:20";s:12:"lastmodified";s:19:"2020-09-04 21:12:20";}}');
-- query
INSERT INTO app_log VALUES ('3','1','DataDeleted','2021-06-12 00:57:45','a:1:{i:0;a:11:{s:2:"id";s:2:"17";s:4:"fkey";s:1:"0";s:8:"adminref";s:1:"1";s:8:"parentid";s:1:"0";s:5:"image";s:0:"";s:5:"title";s:19:"SUPPLIER MOTIVATION";s:11:"description";s:0:"";s:4:"type";s:17:"accopttemplategrp";s:7:"generic";s:2:"14";s:9:"entrydate";s:19:"2017-03-28 16:39:41";s:12:"lastmodified";s:19:"2017-03-28 16:39:41";}}');
-- query
INSERT INTO app_log VALUES ('4','1','DataDeleted','2021-06-12 00:58:09','a:1:{i:0;a:14:{s:2:"id";s:2:"12";s:4:"name";s:26:"LOAN ADJUSTMENT - LOAN PAY";s:12:"debitaccount";s:0:"";s:13:"creditaccount";s:0:"";s:18:"debitautoselection";s:1:"0";s:19:"creditautoselection";s:1:"0";s:4:"code";s:10:"ADJUSTMENT";s:7:"groupid";s:1:"6";s:6:"method";s:10:"Percentage";s:5:"value";s:3:"100";s:11:"shortremark";s:15:"LOAN ADJUSTMENT";s:10:"fullremark";s:0:"";s:9:"entrydate";s:19:"2017-03-28 16:39:41";s:9:"createdby";s:1:"1";}}');
-- query
INSERT INTO app_log VALUES ('5','1','DataDeleted','2021-06-12 00:58:13','a:1:{i:0;a:14:{s:2:"id";s:2:"33";s:4:"name";s:24:"GENERAL EXPENSE OUTLET 2";s:12:"debitaccount";s:13:"1020500000036";s:13:"creditaccount";s:13:"1020500000032";s:18:"debitautoselection";s:1:"0";s:19:"creditautoselection";s:1:"0";s:4:"code";s:0:"";s:7:"groupid";s:4:"1799";s:6:"method";s:10:"Percentage";s:5:"value";s:3:"100";s:11:"shortremark";s:7:"EXPENSE";s:10:"fullremark";s:0:"";s:9:"entrydate";s:19:"2020-09-04 09:17:28";s:9:"createdby";s:1:"1";}}');
-- query
INSERT INTO app_log VALUES ('6','1','DataDeleted','2021-06-12 00:58:17','a:1:{i:0;a:14:{s:2:"id";s:1:"9";s:4:"name";s:12:"LOAN POSTING";s:12:"debitaccount";s:0:"";s:13:"creditaccount";s:13:"1012443130493";s:18:"debitautoselection";s:1:"1";s:19:"creditautoselection";s:1:"0";s:4:"code";s:10:"STAFF_LOAN";s:7:"groupid";s:1:"1";s:6:"method";s:10:"Percentage";s:5:"value";s:3:"100";s:11:"shortremark";s:18:"PAY FOR STAFF LOAN";s:10:"fullremark";s:12:"LOAN POSTING";s:9:"entrydate";s:19:"2017-03-28 16:39:41";s:9:"createdby";s:1:"1";}}');
-- query
INSERT INTO app_log VALUES ('7','1','DataDeleted','2021-06-12 00:58:19','a:1:{i:0;a:14:{s:2:"id";s:2:"17";s:4:"name";s:13:"LOAN DISBURSE";s:12:"debitaccount";s:13:"1012443130493";s:13:"creditaccount";s:13:"1011158392268";s:18:"debitautoselection";s:1:"0";s:19:"creditautoselection";s:1:"0";s:4:"code";s:7:"PAYMENT";s:7:"groupid";s:1:"1";s:6:"method";s:10:"Percentage";s:5:"value";s:3:"100";s:11:"shortremark";s:17:"LOAN DISBURSEMENT";s:10:"fullremark";s:12:"DISBURSEMENT";s:9:"entrydate";s:19:"2017-03-28 16:39:41";s:9:"createdby";s:1:"1";}}');
-- query
INSERT INTO app_log VALUES ('8','1','DataDeleted','2021-06-12 00:58:21','a:1:{i:0;a:14:{s:2:"id";s:2:"20";s:4:"name";s:19:"SUPPLIER MOTIVATION";s:12:"debitaccount";s:0:"";s:13:"creditaccount";s:13:"1016251858520";s:18:"debitautoselection";s:1:"1";s:19:"creditautoselection";s:1:"0";s:4:"code";s:18:"SUPPLER_MOTIVATION";s:7:"groupid";s:2:"17";s:6:"method";s:10:"Percentage";s:5:"value";s:3:"100";s:11:"shortremark";s:10:"MOTIVATION";s:10:"fullremark";s:0:"";s:9:"entrydate";s:19:"2017-03-28 16:39:41";s:9:"createdby";s:1:"1";}}');
-- query
INSERT INTO app_log VALUES ('9','1','DataDeleted','2021-06-12 00:58:23','a:1:{i:0;a:14:{s:2:"id";s:2:"28";s:4:"name";s:12:"SMS FEES VAT";s:12:"debitaccount";s:13:"1019426541137";s:13:"creditaccount";s:0:"";s:18:"debitautoselection";s:1:"0";s:19:"creditautoselection";s:1:"1";s:4:"code";s:3:"VAT";s:7:"groupid";s:4:"1762";s:6:"method";s:10:"Percentage";s:5:"value";s:2:"15";s:11:"shortremark";s:3:"VAT";s:10:"fullremark";s:0:"";s:9:"entrydate";s:19:"2017-03-28 16:39:41";s:9:"createdby";s:1:"1";}}');
-- query
INSERT INTO app_log VALUES ('10','1','DataDeleted','2021-06-12 00:58:25','a:1:{i:0;a:14:{s:2:"id";s:2:"29";s:4:"name";s:16:"OWN SOL TRANSFER";s:12:"debitaccount";s:0:"";s:13:"creditaccount";s:0:"";s:18:"debitautoselection";s:1:"0";s:19:"creditautoselection";s:1:"0";s:4:"code";s:8:"CASH_OUT";s:7:"groupid";s:4:"1775";s:6:"method";s:10:"Percentage";s:5:"value";s:3:"100";s:11:"shortremark";s:8:"TRANSFER";s:10:"fullremark";s:19:"INT SOL TR SELF TXN";s:9:"entrydate";s:19:"2018-08-08 04:13:13";s:9:"createdby";s:1:"1";}}');
-- query
INSERT INTO app_log VALUES ('11','1','DataDeleted','2021-06-12 00:58:27','a:1:{i:0;a:14:{s:2:"id";s:2:"30";s:4:"name";s:18:"OTHER SOL TRANSFER";s:12:"debitaccount";s:0:"";s:13:"creditaccount";s:0:"";s:18:"debitautoselection";s:1:"0";s:19:"creditautoselection";s:1:"0";s:4:"code";s:7:"CASH_IN";s:7:"groupid";s:4:"1775";s:6:"method";s:10:"Percentage";s:5:"value";s:3:"100";s:11:"shortremark";s:7:"CASH IN";s:10:"fullremark";s:19:"INT SOL TR OTHR TXN";s:9:"entrydate";s:19:"2018-08-08 04:15:47";s:9:"createdby";s:1:"1";}}');
-- query
INSERT INTO app_log VALUES ('12','1','DataDeleted','2021-06-12 00:58:28','a:1:{i:0;a:14:{s:2:"id";s:2:"31";s:4:"name";s:17:"CASH PAY OUTLET 2";s:12:"debitaccount";s:0:"";s:13:"creditaccount";s:13:"1020500000032";s:18:"debitautoselection";s:1:"1";s:19:"creditautoselection";s:1:"0";s:4:"code";s:8:"CASH_OUT";s:7:"groupid";s:4:"1797";s:6:"method";s:10:"Percentage";s:5:"value";s:3:"100";s:11:"shortremark";s:8:"CASH PAY";s:10:"fullremark";s:0:"";s:9:"entrydate";s:19:"2020-09-04 09:19:24";s:9:"createdby";s:1:"1";}}');
-- query
INSERT INTO app_log VALUES ('13','1','DataDeleted','2021-06-12 00:58:30','a:1:{i:0;a:14:{s:2:"id";s:2:"32";s:4:"name";s:21:"CASH RECEIVE OUTLET 2";s:12:"debitaccount";s:13:"1020500000032";s:13:"creditaccount";s:0:"";s:18:"debitautoselection";s:1:"0";s:19:"creditautoselection";s:1:"1";s:4:"code";s:7:"CASH_IN";s:7:"groupid";s:4:"1798";s:6:"method";s:10:"Percentage";s:5:"value";s:3:"100";s:11:"shortremark";s:7:"CASH IN";s:10:"fullremark";s:0:"";s:9:"entrydate";s:19:"2020-09-04 09:19:35";s:9:"createdby";s:1:"1";}}');
-- query
INSERT INTO app_log VALUES ('14','1','DataDeleted','2021-06-12 01:02:39','a:1:{i:0;a:9:{s:2:"id";s:1:"5";s:8:"adminref";s:1:"1";s:9:"entrydate";s:19:"2018-04-21 20:05:03";s:12:"lastmodified";s:19:"2020-12-03 17:48:39";s:4:"name";s:19:"Pharmacy Terminal 2";s:4:"code";s:3:"202";s:8:"location";s:0:"";s:7:"cashacc";s:13:"1020500000032";s:5:"store";s:1:"2";}}');
-- query
INSERT INTO app_log VALUES ('15','1','DataDeleted','2021-06-12 01:02:43','a:1:{i:0;a:9:{s:2:"id";s:1:"6";s:8:"adminref";s:1:"1";s:9:"entrydate";s:19:"2018-04-21 20:05:03";s:12:"lastmodified";s:19:"2021-02-22 17:38:02";s:4:"name";s:18:"TERMINAL-3 (JELAN)";s:4:"code";s:3:"203";s:8:"location";s:0:"";s:7:"cashacc";s:13:"1010500000121";s:5:"store";s:1:"1";}}');
-- query
INSERT INTO app_log VALUES ('16','1','DataDeleted','2021-06-12 01:05:53','a:1:{i:0;a:17:{s:2:"id";s:2:"17";s:8:"entityid";s:1:"0";s:2:"no";s:17:"20502290100063514";s:7:"acctype";s:1:"1";s:4:"name";s:16:"COMPANY BANK C/A";s:9:"accstatus";s:1:"1";s:4:"tier";s:4:"1002";s:11:"nonnegative";s:1:"Y";s:6:"scheme";s:1:"C";s:4:"curr";s:3:"050";s:10:"branchcode";s:3:"101";s:12:"externalcode";s:1:"0";s:16:"externalcodetype";s:0:"";s:7:"balance";s:1:"0";s:8:"operator";s:1:"1";s:9:"entrydate";s:19:"2018-04-22 02:29:30";s:6:"remark";s:12:"COMPANY BANK";}}');
-- query
INSERT INTO app_log VALUES ('17','2147483647','POS_ITEM_FAIELD','2021-07-09 15:12:13','SELECT_ITEM');
-- query
INSERT INTO app_log VALUES ('18','2147483647','POS_ITEM_FAIELD','2021-07-09 15:12:19','SELECT_ITEM');
-- query
INSERT INTO app_log VALUES ('19','5275','POS_ITEM_FAIELD','2021-07-09 15:12:32','INSUFFICIENT_QTY');
-- query
INSERT INTO app_log VALUES ('20','1','DataDeleted','2021-07-09 15:17:00','a:1:{i:0;a:26:{s:2:"id";s:1:"6";s:6:"itemid";s:2:"28";s:7:"storeid";s:1:"1";s:5:"value";s:4:"0.24";s:12:"presentstock";s:6:"399.76";s:8:"discount";s:1:"0";s:14:"discountmethod";s:1:"F";s:9:"unitprice";s:2:"19";s:17:"unitpurchaseprice";s:1:"0";s:7:"vatrate";s:1:"0";s:3:"vat";s:1:"0";s:8:"subtotal";s:4:"4.56";s:11:"totaleprice";s:4:"4.56";s:18:"totalpurchaseprice";s:1:"0";s:9:"invoiceid";s:3:"769";s:5:"lotno";s:0:"";s:11:"productcode";s:0:"";s:5:"color";s:0:"";s:5:"sizes";s:0:"";s:10:"attributes";s:0:"";s:8:"supplier";s:1:"0";s:8:"warranty";s:0:"";s:5:"track";s:3:"4|0";s:8:"returned";s:1:"0";s:11:"additionals";s:0:"";s:9:"entrydate";s:19:"2021-07-09 15:16:11";}}');
-- query
INSERT INTO app_log VALUES ('21','1','DataDeleted','2021-07-09 15:18:02','a:1:{i:0;a:26:{s:2:"id";s:1:"7";s:6:"itemid";s:2:"28";s:7:"storeid";s:1:"1";s:5:"value";s:6:"0.2407";s:12:"presentstock";s:8:"399.7593";s:8:"discount";s:1:"0";s:14:"discountmethod";s:1:"F";s:9:"unitprice";s:2:"19";s:17:"unitpurchaseprice";s:1:"0";s:7:"vatrate";s:1:"0";s:3:"vat";s:1:"0";s:8:"subtotal";s:6:"4.5733";s:11:"totaleprice";s:6:"4.5733";s:18:"totalpurchaseprice";s:1:"0";s:9:"invoiceid";s:3:"769";s:5:"lotno";s:0:"";s:11:"productcode";s:0:"";s:5:"color";s:0:"";s:5:"sizes";s:0:"";s:10:"attributes";s:0:"";s:8:"supplier";s:1:"0";s:8:"warranty";s:0:"";s:5:"track";s:3:"4|0";s:8:"returned";s:1:"0";s:11:"additionals";s:0:"";s:9:"entrydate";s:19:"2021-07-09 15:17:05";}}');
-- query
INSERT INTO app_log VALUES ('22','1','DataDeleted','2021-07-09 15:18:50','a:1:{i:0;a:26:{s:2:"id";s:1:"8";s:6:"itemid";s:2:"28";s:7:"storeid";s:1:"1";s:5:"value";s:6:"0.2407";s:12:"presentstock";s:8:"399.7593";s:8:"discount";s:1:"0";s:14:"discountmethod";s:1:"F";s:9:"unitprice";s:2:"19";s:17:"unitpurchaseprice";s:1:"0";s:7:"vatrate";s:1:"0";s:3:"vat";s:1:"0";s:8:"subtotal";s:6:"4.5733";s:11:"totaleprice";s:6:"4.5733";s:18:"totalpurchaseprice";s:1:"0";s:9:"invoiceid";s:3:"769";s:5:"lotno";s:0:"";s:11:"productcode";s:0:"";s:5:"color";s:0:"";s:5:"sizes";s:0:"";s:10:"attributes";s:0:"";s:8:"supplier";s:1:"0";s:8:"warranty";s:0:"";s:5:"track";s:3:"4|0";s:8:"returned";s:1:"0";s:11:"additionals";s:0:"";s:9:"entrydate";s:19:"2021-07-09 15:18:08";}}');
-- query
INSERT INTO app_log VALUES ('23','1','DataDeleted','2021-07-09 15:23:39','a:1:{i:0;a:26:{s:2:"id";s:1:"9";s:6:"itemid";s:2:"28";s:7:"storeid";s:1:"1";s:5:"value";s:4:"0.24";s:12:"presentstock";s:6:"399.76";s:8:"discount";s:1:"0";s:14:"discountmethod";s:1:"F";s:9:"unitprice";s:2:"25";s:17:"unitpurchaseprice";s:1:"0";s:7:"vatrate";s:1:"0";s:3:"vat";s:1:"0";s:8:"subtotal";s:1:"6";s:11:"totaleprice";s:1:"6";s:18:"totalpurchaseprice";s:1:"0";s:9:"invoiceid";s:3:"769";s:5:"lotno";s:0:"";s:11:"productcode";s:0:"";s:5:"color";s:0:"";s:5:"sizes";s:0:"";s:10:"attributes";s:0:"";s:8:"supplier";s:1:"0";s:8:"warranty";s:0:"";s:5:"track";s:3:"4|0";s:8:"returned";s:1:"0";s:11:"additionals";s:0:"";s:9:"entrydate";s:19:"2021-07-09 15:19:07";}}');
-- query
INSERT INTO app_log VALUES ('24','1','DataDeleted','2021-07-09 15:25:16','a:1:{i:0;a:26:{s:2:"id";s:2:"10";s:6:"itemid";s:2:"28";s:7:"storeid";s:1:"1";s:5:"value";s:6:"0.2407";s:12:"presentstock";s:8:"399.7593";s:8:"discount";s:1:"0";s:14:"discountmethod";s:1:"F";s:9:"unitprice";s:2:"25";s:17:"unitpurchaseprice";s:1:"0";s:7:"vatrate";s:1:"0";s:3:"vat";s:1:"0";s:8:"subtotal";s:6:"6.0175";s:11:"totaleprice";s:6:"6.0175";s:18:"totalpurchaseprice";s:1:"0";s:9:"invoiceid";s:3:"769";s:5:"lotno";s:0:"";s:11:"productcode";s:0:"";s:5:"color";s:0:"";s:5:"sizes";s:0:"";s:10:"attributes";s:0:"";s:8:"supplier";s:1:"0";s:8:"warranty";s:0:"";s:5:"track";s:3:"4|0";s:8:"returned";s:1:"0";s:11:"additionals";s:0:"";s:9:"entrydate";s:19:"2021-07-09 15:23:45";}}');
-- query
INSERT INTO app_log VALUES ('25','1','DataDeleted','2021-07-26 22:43:32','a:1:{i:0;a:17:{s:2:"id";s:2:"27";s:7:"groupid";s:1:"0";s:6:"f_name";s:7:"Chandon";s:6:"l_name";s:7:"Bhuiyan";s:8:"username";s:7:"Chandon";s:8:"password";s:32:"c44b141cdccc00893c884e70ddbd8f65";s:5:"email";s:21:"chandonrain@gmail.com";s:10:"createdate";s:19:"2020-12-10 11:37:42";s:11:"latestlogin";s:10:"1617756347";s:9:"lastlogin";s:10:"1617714255";s:6:"status";s:6:"Active";s:4:"type";s:6:"Normal";s:3:"acl";s:1737:"a:4:{s:8:"accounts";a:4:{i:5;a:3:{i:0;s:25:"/searchexpert/do/accounts";i:1;s:18:"/accounts/save/new";i:2;s:22:"/accounts/accountchart";}i:6;a:5:{i:0;s:38:"/category/manage/accopttemplategrp/add";i:1;s:34:"/category/manage/accopttemplategrp";i:2;s:34:"/accounts/operationtemplate/create";i:3;s:27:"/accounts/operationtemplate";i:4;s:15:"/accounts/inout";}i:7;a:1:{i:0;s:27:"/accounts/transactionviewer";}i:9;a:4:{i:0;s:22:"/voucher/manage/create";i:1;s:15:"/voucher/manage";i:2;s:18:"/voucher/bulkentry";i:3;s:29:"/admin/config/vouchersettings";}}s:9:"admission";a:1:{i:3;a:3:{i:0;s:26:"/searchexpert/do/admission";i:1;s:16:"/admission/entry";i:2;s:24:"/admission/manageentries";}}s:9:"inventory";a:7:{i:2;a:3:{i:0;s:31:"/searchexpert/do/invprodcompany";i:1;s:38:"/information/manage/invprodcompany/add";i:2;s:34:"/information/manage/invprodcompany";}i:3;a:3:{i:0;s:32:"/searchexpert/do/invitemcategory";i:1;s:31:"/category/manage/invitemcat/add";i:2;s:27:"/category/manage/invitemcat";}i:4;a:4:{i:0;s:24:"/searchexpert/do/invitem";i:1;s:26:"/inventory/manageitems/add";i:2;s:22:"/inventory/manageitems";i:3;s:24:"/inventory/itembulkentry";}i:5;a:4:{i:0;s:26:"/searchexpert/do/invordsrc";i:1;s:22:"/order/purchase/create";i:2;s:28:"/order/purchasereturn/create";i:3;s:16:"/inventory/order";}i:6;a:1:{i:2;s:26:"/inventory/stockmonitoring";}i:7;a:4:{i:0;s:27:"/searchexpert/do/invinvoice";i:2;s:22:"/inventory/invoicelist";i:3;s:25:"/inventory/salemonitoring";i:4;s:41:"/developer/debug-log/db?s=POS_ITEM_FAIELD";}i:9;a:3:{i:0;s:40:"/information/manage/invpaymentmethod/add";i:1;s:36:"/information/manage/invpaymentmethod";i:2;s:39:"/extpaymentmethod/transactionmonitoring";}}s:9:"appreport";a:1:{i:2;a:1:{i:0;s:19:"/appreport/executor";}}}";s:9:"aclobject";s:779:"a:4:{s:17:"accopttemplategrp";a:8:{i:2;a:1:{i:0;s:3:"Yes";}i:4;a:1:{i:0;s:3:"Yes";}i:5;a:1:{i:0;s:3:"Yes";}i:7;a:1:{i:0;s:3:"Yes";}i:18;a:1:{i:0;s:3:"Yes";}i:19;a:1:{i:0;s:3:"Yes";}i:20;a:1:{i:0;s:3:"Yes";}i:29;a:1:{i:0;s:3:"Yes";}}s:10:"accounting";a:1:{s:13:"defaultbranch";s:3:"101";}s:18:"appreportoperation";a:5:{i:9;a:1:{i:0;s:3:"Yes";}i:10;a:1:{i:0;s:3:"Yes";}i:23;a:1:{i:0;s:3:"Yes";}i:24;a:1:{i:0;s:3:"Yes";}i:179;a:1:{i:0;s:3:"Yes";}}s:16:"inventoryaclopts";a:5:{s:28:"inventory_invoice_adjustment";a:4:{i:0;s:6:"return";i:1;s:8:"discount";i:2;s:18:"change_sales_price";i:3;s:21:"change_service_charge";}s:33:"invenotry_maskduringshadowenabled";s:2:"No";s:24:"invenotry_changestockqty";s:3:"Yes";s:18:"invenotry_terminal";s:0:"";s:15:"itemrestriction";s:8:"disabled";}}";s:11:"description";s:0:"";s:8:"resetsid";s:0:"";s:13:"lastresettime";s:1:"0";}}');
-- query
INSERT INTO app_log VALUES ('26','1','DataDeleted','2021-07-26 22:43:33','a:1:{i:0;a:17:{s:2:"id";s:2:"29";s:7:"groupid";s:1:"0";s:6:"f_name";s:2:"Md";s:6:"l_name";s:5:"Zilan";s:8:"username";s:5:"zilan";s:8:"password";s:32:"a8758bbefb0fd73719270e48b4c7c20c";s:5:"email";s:15:"zilan@gmail.com";s:10:"createdate";s:19:"2021-02-16 13:36:09";s:11:"latestlogin";s:10:"1613830284";s:9:"lastlogin";s:10:"1613485514";s:6:"status";s:6:"Active";s:4:"type";s:6:"Normal";s:3:"acl";s:1322:"a:4:{s:8:"accounts";a:2:{i:5;a:3:{i:0;s:25:"/searchexpert/do/accounts";i:1;s:18:"/accounts/save/new";i:2;s:22:"/accounts/accountchart";}i:7;a:1:{i:0;s:27:"/accounts/transactionviewer";}}s:9:"admission";a:1:{i:3;a:3:{i:0;s:26:"/searchexpert/do/admission";i:1;s:16:"/admission/entry";i:2;s:24:"/admission/manageentries";}}s:9:"inventory";a:6:{i:2;a:3:{i:0;s:31:"/searchexpert/do/invprodcompany";i:1;s:38:"/information/manage/invprodcompany/add";i:2;s:34:"/information/manage/invprodcompany";}i:3;a:3:{i:0;s:32:"/searchexpert/do/invitemcategory";i:1;s:31:"/category/manage/invitemcat/add";i:2;s:27:"/category/manage/invitemcat";}i:4;a:5:{i:0;s:24:"/searchexpert/do/invitem";i:1;s:26:"/inventory/manageitems/add";i:2;s:22:"/inventory/manageitems";i:3;s:24:"/inventory/itembulkentry";i:4;s:24:"/inventory/exportbarcode";}i:5;a:4:{i:0;s:26:"/searchexpert/do/invordsrc";i:1;s:22:"/order/purchase/create";i:2;s:28:"/order/purchasereturn/create";i:3;s:16:"/inventory/order";}i:6;a:4:{i:0;s:19:"/inventory/stock/in";i:1;s:24:"/inventory/stocktransfer";i:2;s:26:"/inventory/stockmonitoring";i:3;s:44:"/inventory/stockmonitoring?entrytype=PENDING";}i:7;a:3:{i:0;s:27:"/searchexpert/do/invinvoice";i:2;s:22:"/inventory/invoicelist";i:3;s:25:"/inventory/salemonitoring";}}s:9:"appreport";a:1:{i:2;a:1:{i:0;s:19:"/appreport/executor";}}}";s:9:"aclobject";s:475:"a:3:{s:10:"accounting";a:1:{s:13:"defaultbranch";s:3:"101";}s:18:"appreportoperation";a:2:{i:9;a:1:{i:0;s:3:"Yes";}i:10;a:1:{i:0;s:3:"Yes";}}s:16:"inventoryaclopts";a:5:{s:28:"inventory_invoice_adjustment";a:4:{i:0;s:6:"return";i:1;s:8:"discount";i:2;s:18:"change_sales_price";i:3;s:21:"change_service_charge";}s:33:"invenotry_maskduringshadowenabled";s:2:"No";s:24:"invenotry_changestockqty";s:2:"No";s:18:"invenotry_terminal";s:0:"";s:15:"itemrestriction";s:8:"disabled";}}";s:11:"description";s:0:"";s:8:"resetsid";s:0:"";s:13:"lastresettime";s:1:"0";}}');
-- query
INSERT INTO app_log VALUES ('27','1','DataDeleted','2021-07-26 22:43:35','a:1:{i:0;a:17:{s:2:"id";s:2:"30";s:7:"groupid";s:1:"0";s:6:"f_name";s:2:"Md";s:6:"l_name";s:5:"Sohel";s:8:"username";s:5:"sohel";s:8:"password";s:32:"d5d8aa8a35a03523a44ec06b0a9cd6cf";s:5:"email";s:15:"sohel@gmail.com";s:10:"createdate";s:19:"2021-02-22 15:02:00";s:11:"latestlogin";s:10:"1618485204";s:9:"lastlogin";s:10:"1618479012";s:6:"status";s:6:"Active";s:4:"type";s:6:"Normal";s:3:"acl";s:1218:"a:4:{s:8:"accounts";a:3:{i:5;a:3:{i:0;s:25:"/searchexpert/do/accounts";i:1;s:18:"/accounts/save/new";i:2;s:22:"/accounts/accountchart";}i:7;a:1:{i:0;s:27:"/accounts/transactionviewer";}i:9;a:3:{i:0;s:22:"/voucher/manage/create";i:1;s:15:"/voucher/manage";i:2;s:18:"/voucher/bulkentry";}}s:9:"admission";a:1:{i:3;a:3:{i:0;s:26:"/searchexpert/do/admission";i:1;s:16:"/admission/entry";i:2;s:24:"/admission/manageentries";}}s:9:"inventory";a:5:{i:2;a:3:{i:0;s:31:"/searchexpert/do/invprodcompany";i:1;s:38:"/information/manage/invprodcompany/add";i:2;s:34:"/information/manage/invprodcompany";}i:4;a:4:{i:0;s:24:"/searchexpert/do/invitem";i:2;s:22:"/inventory/manageitems";i:3;s:24:"/inventory/itembulkentry";i:4;s:24:"/inventory/exportbarcode";}i:5;a:4:{i:0;s:26:"/searchexpert/do/invordsrc";i:1;s:22:"/order/purchase/create";i:2;s:28:"/order/purchasereturn/create";i:3;s:16:"/inventory/order";}i:6;a:3:{i:1;s:24:"/inventory/stocktransfer";i:2;s:26:"/inventory/stockmonitoring";i:3;s:44:"/inventory/stockmonitoring?entrytype=PENDING";}i:7;a:3:{i:0;s:27:"/searchexpert/do/invinvoice";i:2;s:22:"/inventory/invoicelist";i:3;s:25:"/inventory/salemonitoring";}}s:9:"appreport";a:1:{i:2;a:1:{i:0;s:19:"/appreport/executor";}}}";s:9:"aclobject";s:587:"a:4:{s:17:"accopttemplategrp";a:6:{i:2;a:1:{i:0;s:3:"Yes";}i:4;a:1:{i:0;s:3:"Yes";}i:5;a:1:{i:0;s:3:"Yes";}i:7;a:1:{i:0;s:3:"Yes";}i:20;a:1:{i:0;s:3:"Yes";}i:29;a:1:{i:0;s:3:"Yes";}}s:10:"accounting";a:1:{s:13:"defaultbranch";s:3:"101";}s:18:"appreportoperation";a:5:{i:9;a:1:{i:0;s:3:"Yes";}i:10;a:1:{i:0;s:3:"Yes";}i:23;a:1:{i:0;s:3:"Yes";}i:24;a:1:{i:0;s:3:"Yes";}i:179;a:1:{i:0;s:3:"Yes";}}s:16:"inventoryaclopts";a:4:{s:33:"invenotry_maskduringshadowenabled";s:2:"No";s:24:"invenotry_changestockqty";s:3:"Yes";s:18:"invenotry_terminal";s:0:"";s:15:"itemrestriction";s:7:"enabled";}}";s:11:"description";s:0:"";s:8:"resetsid";s:0:"";s:13:"lastresettime";s:1:"0";}}');
-- query
INSERT INTO app_log VALUES ('28','1','DataDeleted','2021-07-26 22:43:37','a:1:{i:0;a:17:{s:2:"id";s:2:"26";s:7:"groupid";s:1:"0";s:6:"f_name";s:6:"Pijush";s:6:"l_name";s:5:"Bablu";s:8:"username";s:5:"bablu";s:8:"password";s:32:"8dcebe5681864fd001fb1720786ee346";s:5:"email";s:15:"bablu@gmail.com";s:10:"createdate";s:19:"2020-12-04 12:26:02";s:11:"latestlogin";s:10:"1618548043";s:9:"lastlogin";s:10:"1618496120";s:6:"status";s:6:"Active";s:4:"type";s:6:"Normal";s:3:"acl";s:224:"a:1:{s:9:"inventory";a:2:{i:4;a:1:{i:0;s:24:"/searchexpert/do/invitem";}i:7;a:4:{i:0;s:27:"/searchexpert/do/invinvoice";i:1;s:18:"/inventory/invoice";i:2;s:22:"/inventory/invoicelist";i:3;s:25:"/inventory/salemonitoring";}}}";s:9:"aclobject";s:392:"a:4:{s:17:"accopttemplategrp";a:1:{i:7;a:1:{i:0;s:3:"Yes";}}s:10:"accounting";a:1:{s:13:"defaultbranch";s:3:"101";}s:18:"appreportoperation";a:2:{i:9;a:1:{i:0;s:3:"Yes";}i:10;a:1:{i:0;s:3:"Yes";}}s:16:"inventoryaclopts";a:4:{s:33:"invenotry_maskduringshadowenabled";s:3:"Yes";s:24:"invenotry_changestockqty";s:2:"No";s:18:"invenotry_terminal";s:3:"201";s:15:"itemrestriction";s:7:"enabled";}}";s:11:"description";s:0:"";s:8:"resetsid";s:0:"";s:13:"lastresettime";s:1:"0";}}');
-- query
INSERT INTO app_log VALUES ('29','1','DataDeleted','2021-07-26 22:43:38','a:1:{i:0;a:17:{s:2:"id";s:2:"25";s:7:"groupid";s:1:"0";s:6:"f_name";s:2:"Md";s:6:"l_name";s:5:"Selim";s:8:"username";s:5:"selim";s:8:"password";s:32:"0a7a6947b248c0535c3301e695605d38";s:5:"email";s:15:"selim@gmail.com";s:10:"createdate";s:19:"2020-12-03 21:08:03";s:11:"latestlogin";s:10:"1610817751";s:9:"lastlogin";s:10:"1610815621";s:6:"status";s:8:"Inactive";s:4:"type";s:6:"Normal";s:3:"acl";s:306:"a:1:{s:9:"inventory";a:3:{i:4;a:2:{i:0;s:24:"/searchexpert/do/invitem";i:2;s:22:"/inventory/manageitems";}i:6;a:1:{i:2;s:26:"/inventory/stockmonitoring";}i:7;a:4:{i:0;s:27:"/searchexpert/do/invinvoice";i:1;s:18:"/inventory/invoice";i:2;s:22:"/inventory/invoicelist";i:3;s:25:"/inventory/salemonitoring";}}}";s:9:"aclobject";s:254:"a:2:{s:10:"accounting";a:1:{s:13:"defaultbranch";s:3:"101";}s:16:"inventoryaclopts";a:4:{s:33:"invenotry_maskduringshadowenabled";s:3:"Yes";s:24:"invenotry_changestockqty";s:2:"No";s:18:"invenotry_terminal";s:0:"";s:15:"itemrestriction";s:8:"disabled";}}";s:11:"description";s:0:"";s:8:"resetsid";s:0:"";s:13:"lastresettime";s:1:"0";}}');
-- query
INSERT INTO app_log VALUES ('30','1','DataDeleted','2021-07-26 22:43:40','a:1:{i:0;a:17:{s:2:"id";s:2:"24";s:7:"groupid";s:1:"0";s:6:"f_name";s:5:"Nurul";s:6:"l_name";s:5:"Afsar";s:8:"username";s:5:"afsar";s:8:"password";s:32:"cf6d4633fcaf92ac7e4f8a3c8252a141";s:5:"email";s:15:"afsar@gmail.com";s:10:"createdate";s:19:"2020-12-03 17:55:23";s:11:"latestlogin";s:10:"1607314779";s:9:"lastlogin";s:10:"1607179006";s:6:"status";s:8:"Inactive";s:4:"type";s:6:"Normal";s:3:"acl";s:976:"a:2:{s:9:"admission";a:1:{i:3;a:3:{i:0;s:26:"/searchexpert/do/admission";i:1;s:16:"/admission/entry";i:2;s:24:"/admission/manageentries";}}s:9:"inventory";a:6:{i:2;a:3:{i:0;s:31:"/searchexpert/do/invprodcompany";i:1;s:38:"/information/manage/invprodcompany/add";i:2;s:34:"/information/manage/invprodcompany";}i:3;a:3:{i:0;s:32:"/searchexpert/do/invitemcategory";i:1;s:31:"/category/manage/invitemcat/add";i:2;s:27:"/category/manage/invitemcat";}i:4;a:4:{i:0;s:24:"/searchexpert/do/invitem";i:1;s:26:"/inventory/manageitems/add";i:2;s:22:"/inventory/manageitems";i:3;s:24:"/inventory/itembulkentry";}i:5;a:3:{i:0;s:26:"/searchexpert/do/invordsrc";i:1;s:22:"/order/purchase/create";i:3;s:16:"/inventory/order";}i:6;a:3:{i:0;s:19:"/inventory/stock/in";i:1;s:24:"/inventory/stocktransfer";i:2;s:26:"/inventory/stockmonitoring";}i:7;a:4:{i:0;s:27:"/searchexpert/do/invinvoice";i:1;s:18:"/inventory/invoice";i:2;s:22:"/inventory/invoicelist";i:3;s:25:"/inventory/salemonitoring";}}}";s:9:"aclobject";s:254:"a:2:{s:10:"accounting";a:1:{s:13:"defaultbranch";s:3:"101";}s:16:"inventoryaclopts";a:4:{s:33:"invenotry_maskduringshadowenabled";s:3:"Yes";s:24:"invenotry_changestockqty";s:2:"No";s:18:"invenotry_terminal";s:0:"";s:15:"itemrestriction";s:8:"disabled";}}";s:11:"description";s:0:"";s:8:"resetsid";s:0:"";s:13:"lastresettime";s:1:"0";}}');
-- query
INSERT INTO app_log VALUES ('31','1','DataDeleted','2021-07-26 22:43:42','a:1:{i:0;a:17:{s:2:"id";s:2:"23";s:7:"groupid";s:1:"0";s:6:"f_name";s:2:"Md";s:6:"l_name";s:6:"Saiful";s:8:"username";s:6:"saiful";s:8:"password";s:32:"dbbad869ead3e9b75d1c9a67dfcfe05f";s:5:"email";s:16:"saiful@gmail.com";s:10:"createdate";s:19:"2020-12-03 17:53:40";s:11:"latestlogin";s:10:"1607314848";s:9:"lastlogin";s:10:"1607261666";s:6:"status";s:8:"Inactive";s:4:"type";s:6:"Normal";s:3:"acl";s:976:"a:2:{s:9:"admission";a:1:{i:3;a:3:{i:0;s:26:"/searchexpert/do/admission";i:1;s:16:"/admission/entry";i:2;s:24:"/admission/manageentries";}}s:9:"inventory";a:6:{i:2;a:3:{i:0;s:31:"/searchexpert/do/invprodcompany";i:1;s:38:"/information/manage/invprodcompany/add";i:2;s:34:"/information/manage/invprodcompany";}i:3;a:3:{i:0;s:32:"/searchexpert/do/invitemcategory";i:1;s:31:"/category/manage/invitemcat/add";i:2;s:27:"/category/manage/invitemcat";}i:4;a:4:{i:0;s:24:"/searchexpert/do/invitem";i:1;s:26:"/inventory/manageitems/add";i:2;s:22:"/inventory/manageitems";i:3;s:24:"/inventory/itembulkentry";}i:5;a:3:{i:0;s:26:"/searchexpert/do/invordsrc";i:1;s:22:"/order/purchase/create";i:3;s:16:"/inventory/order";}i:6;a:3:{i:0;s:19:"/inventory/stock/in";i:1;s:24:"/inventory/stocktransfer";i:2;s:26:"/inventory/stockmonitoring";}i:7;a:4:{i:0;s:27:"/searchexpert/do/invinvoice";i:1;s:18:"/inventory/invoice";i:2;s:22:"/inventory/invoicelist";i:3;s:25:"/inventory/salemonitoring";}}}";s:9:"aclobject";s:257:"a:2:{s:10:"accounting";a:1:{s:13:"defaultbranch";s:3:"101";}s:16:"inventoryaclopts";a:4:{s:33:"invenotry_maskduringshadowenabled";s:3:"Yes";s:24:"invenotry_changestockqty";s:2:"No";s:18:"invenotry_terminal";s:3:"201";s:15:"itemrestriction";s:8:"disabled";}}";s:11:"description";s:0:"";s:8:"resetsid";s:0:"";s:13:"lastresettime";s:1:"0";}}');
-- query
INSERT INTO app_log VALUES ('32','1','DataDeleted','2021-07-26 22:43:59','a:1:{i:0;a:17:{s:2:"id";s:1:"2";s:7:"groupid";s:1:"0";s:6:"f_name";s:6:"System";s:6:"l_name";s:5:"Admin";s:8:"username";s:8:"sysadmin";s:8:"password";s:32:"afdd0b4ad2ec172c586e2150770fbf9e";s:5:"email";s:16:"info@apprain.com";s:10:"createdate";s:19:"2016-08-31 19:17:02";s:11:"latestlogin";s:10:"1600763308";s:9:"lastlogin";s:10:"1600678432";s:6:"status";s:6:"Active";s:4:"type";s:6:"Normal";s:3:"acl";s:3059:"a:7:{s:8:"accounts";a:7:{i:0;a:2:{i:0;s:36:"/information/manage/accgenerator/add";i:1;s:32:"/information/manage/accgenerator";}i:2;a:2:{i:0;s:31:"/information/manage/acctype/add";i:1;s:27:"/information/manage/acctype";}i:3;a:2:{i:0;s:30:"/information/manage/branch/add";i:1;s:26:"/information/manage/branch";}i:4;a:2:{i:0;s:33:"/information/manage/entrycode/add";i:1;s:29:"/information/manage/entrycode";}i:5;a:3:{i:0;s:16:"/search/accounts";i:1;s:18:"/accounts/save/new";i:2;s:22:"/accounts/accountchart";}i:6;a:5:{i:0;s:38:"/category/manage/accopttemplategrp/add";i:1;s:34:"/category/manage/accopttemplategrp";i:2;s:34:"/accounts/operationtemplate/create";i:3;s:27:"/accounts/operationtemplate";i:4;s:15:"/accounts/inout";}i:7;a:1:{i:0;s:27:"/accounts/transactionviewer";}}s:9:"admission";a:4:{i:0;a:1:{i:0;s:31:"/admin/config/admissionsettings";}i:2;a:4:{i:0;s:38:"/category/manage/userattributesgrp/add";i:1;s:34:"/category/manage/userattributesgrp";i:2;s:42:"/information/manage/userattributefieds/add";i:3;s:38:"/information/manage/userattributefieds";}i:3;a:3:{i:0;s:17:"/search/admission";i:1;s:16:"/admission/entry";i:2;s:24:"/admission/manageentries";}i:4;a:1:{i:0;s:22:"/admission/processfees";}}s:9:"inventory";a:10:{i:0;a:2:{i:0;s:36:"/information/manage/invprodstore/add";i:1;s:32:"/information/manage/invprodstore";}i:1;a:2:{i:0;s:35:"/information/manage/invterminal/add";i:1;s:31:"/information/manage/invterminal";}i:2;a:3:{i:0;s:22:"/search/invprodcompany";i:1;s:38:"/information/manage/invprodcompany/add";i:2;s:34:"/information/manage/invprodcompany";}i:3;a:3:{i:0;s:23:"/search/invitemcategory";i:1;s:31:"/category/manage/invitemcat/add";i:2;s:27:"/category/manage/invitemcat";}i:4;a:5:{i:0;s:15:"/search/invitem";i:1;s:26:"/inventory/manageitems/add";i:2;s:22:"/inventory/manageitems";i:3;s:24:"/inventory/itembulkentry";i:4;s:24:"/inventory/exportbarcode";}i:5;a:6:{i:0;s:17:"/search/invordsrc";i:1;s:22:"/order/purchase/create";i:2;s:28:"/order/purchasereturn/create";i:3;s:23:"/inventory/order/create";i:4;s:22:"/inventory/bulkreceive";i:5;s:16:"/inventory/order";}i:6;a:3:{i:0;s:19:"/inventory/stock/in";i:1;s:24:"/inventory/stocktransfer";i:2;s:26:"/inventory/stockmonitoring";}i:7;a:4:{i:0;s:18:"/search/invinvoice";i:1;s:18:"/inventory/invoice";i:2;s:22:"/inventory/invoicelist";i:3;s:25:"/inventory/salemonitoring";}i:8;a:1:{i:0;s:31:"/admin/config/inventorysettings";}i:9;a:2:{i:0;s:41:"//information/manage/invpaymentmethod/add";i:1;s:36:"/information/manage/invpaymentmethod";}}s:9:"appreport";a:3:{i:0;a:2:{i:0;s:35:"/category/manage/appreportgroup/add";i:1;s:31:"/category/manage/appreportgroup";}i:1;a:1:{i:0;s:21:"/appreport/manage/add";}i:2;a:1:{i:0;s:19:"/appreport/executor";}}s:14:"usermanagement";a:1:{i:0;a:2:{i:0;s:17:"/admin/manage/add";i:1;s:13:"/admin/manage";}}s:9:"component";a:2:{i:0;a:1:{i:0;s:11:"/dataexpert";}i:2;a:3:{i:0;s:34:"/information/manage/searchrole/add";i:1;s:30:"/information/manage/searchrole";i:2;s:23:"/admin/config/appsearch";}}s:9:"developer";a:1:{i:6;a:1:{i:0;s:18:"/dbexpert/imexport";}}}";s:9:"aclobject";s:340:"a:3:{s:10:"accounting";a:1:{s:13:"defaultbranch";s:0:"";}s:18:"appreportoperation";a:4:{i:9;a:1:{i:0;s:3:"Yes";}i:10;a:1:{i:0;s:3:"Yes";}i:23;a:1:{i:0;s:3:"Yes";}i:24;a:1:{i:0;s:3:"Yes";}}s:16:"inventoryaclopts";a:3:{s:33:"invenotry_maskduringshadowenabled";s:2:"No";s:18:"invenotry_terminal";s:0:"";s:15:"itemrestriction";s:8:"disabled";}}";s:11:"description";s:0:"";s:8:"resetsid";s:0:"";s:13:"lastresettime";s:1:"0";}}');
-- query
DROP TABLE IF EXISTS app_notifications;
-- query
CREATE TABLE `app_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `channel` varchar(20) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `timestamp` varchar(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
-- query
DROP TABLE IF EXISTS app_pages;
-- query
CREATE TABLE `app_pages` (
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
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
-- query
INSERT INTO app_pages VALUES ('1','0','About appRain Content Management Framework','','','aboutus','About Us','<p>appRain is one of the first, officially-released, open source Content Management Frameworks (CMF). CMF is a new, web engineering concept where a Content Management System (CMS) and a rapid development framework perform side-by-side to produce endless varieties of output in a very limited time.</p>

<p>appRain is developed on a daily basis, drawing on extensive project experience. A common problem that we all face in a framework is that we need to re-develop some common modules in each project. With Content Management Systems, we sometimes get stuck driving our development based on strict development conventions the system enforces. Why is there no CMS integrated with a framework? This is the question that gave birth to appRain.</p>

<p>Content Management Systems and frameworks are very popular in web development. These two technologies work in different ways. One is used for rapid development, the other for more customized output. appRain merges these two technologies. appRain is fast, flexible, and makes it easy to complete tasks in a very short time period. It can be expanded and scaled.</p>

<p>The tools in the CMS component of appRain are all configurable, making development faster. It helps to avoid repeating tasks. The framework component is used when it becomes too difficult to complete your requirements using the CMS tools. The framework contains all of the core programming tools.</p>

<p>appRain aims to make creating web technology simplified and easlily optimized.</p>
','sitemenu','','Yes','text','Content','9');
-- query
INSERT INTO app_pages VALUES ('2','0','InformationSet and CategorySet','InformationSet and CategorySet','InformationSet and CategorySet','informationset-categoryset','InformationSet and CategorySet','<div>
<p>InformationSet and CategorySet are two common tools used to manage data. These two methods reduce development time significantly.</p>

<p>InformationSet automatically creates interfaces for data entry controlled by a preconfigured validation matrix. This is a single database table managed by an XML file where all database fields are defined separately with parameters like</p>

<ol>
	<li>Database attributes</li>
	<li>Data Input Type (Text Box, Text Area, File Input, etc.)</li>
	<li>Define the validation.</li>
	<li>Render an interface in the admin panel for Add, Modify, and View.</li>
</ol>

<p>InformationSet can adjust when the definition of a field changes. In that case, the database user needs the necessary permissions.<br />
<br />
An InformationSet can be linked with other InformationSets or CategorySets for joining, and it also creates linked input tags like Drop Down and Check Box, etc.<br />
<br />
CategorySet works similarly to InformationSet, but it specifically works to manage recursive parent-child relations. Generally, it is used to categorize any InformationSet data.</p>

<p>A rich library of functions has been developed to work with InformationSet and CategorySet.</p>
</div>
','quicklinks','','Yes','smart_h_link','Content','5');
-- query
INSERT INTO app_pages VALUES ('3','0','Theme Development','Theme Development','Theme Development','theme-development','Theme Development','<p>Theme development is one of the common requirements during a new website development. appRain has a theme gallery to select theme. Gallery is available in below location:</p>

<p>Login Admin Panel &gt; Preferences &gt; Theme</p>

<p>You can choose a theme or add a new theme in the gallery.&nbsp; Theme can be installed by clicking &ldquo;Install New Theme&rdquo; button. In that case you have to upload theme files in Zip format.</p>

<p>To develop a new theme common practice is to copy an existing theme (except &ldquo;admin&rdquo; folder) in below location:</p>

<p><strong>development/view<br />
webroot/themeroot</strong></p>

<p>After copy first edit files <strong>info.xml </strong>and register.php as per appRain conversion to add developer credits and perform default options.<br />
<br />
A theme as some basic requirements to adjust with appRain environment</p>

<ol>
	<li>Folder structures</li>
	<li>UI Hooks</li>
	<li>Layouts</li>
	<li>Style Sheets(CSS)</li>
</ol>

<p>Folder structure you will get easily by coping existing one. UI Hooks is an anchor to place content from external modules like Component, Page Manager so on. Default themes contain basic UI Hooks but theme developer can add more Hooks to serve advanced purpose.</p>

<p>In info.xml file you can defile a hook to display in PageManger to render content also a setting file can add to create theme setup. Also you can install/uninstall a particular component during theme activation.</p>

<p>In register.php you can do some work during different event. These events really helpful to prepare environment for theme during first installation.</p>

<p>A vast area of work remains for admin interface development.&nbsp; Admin design generally depends on the controller action to set the design.&nbsp; Most of the time you have to work with Toolbar, Data Grid and Row Manage to display and manage data.</p>
','quicklinks','','Yes','smart_h_link','Content','6');
-- query
INSERT INTO app_pages VALUES ('4','0','General Help Center','General Help Center','General Help Center','general-help-center','General Help Center','<p>Read appRain manual online, this is a HTML based manual for User, Developer and learners. We always encourage sending your valuable feedback.</p>

<p><a href="http://docs.apprain.com">Online Manual</a></p>

<p>CHM is the standard help format for a windows desktop application. The output is a single file with extension *.chm.</p>

<p><a href="http://www.apprain.com/help/chm">Download</a></p>

<p>Adobe Portable Document Format (PDF) is a platform independent file format. This is ideal for Device and Print.</p>

<p><a href="http://www.apprain.com/help/pdf">Download</a></p>

<p>This type is a cross-platform e-book standard created by the <a href="www.openebook.org">IDPF</a>, which is supported by Apple iBooks, Andriod Tablets/smartphones and many other e-readers on windows, Mac OSX, iOS and Linux.</p>

<p><a href="http://www.apprain.com/help/epub">Download</a></p>

<p>This format is an ideal to illustrate web-based application, to publish documentation to the internet, intranet or CD-ROM</p>

<p><a href="http://www.apprain.com/help/html">Download</a></p>

<p>Windows e-books are stand-alone Windows executable with HTML formatted texts and images. This output format is great for CD-ROM presentations.</p>

<p><a href="http://www.apprain.com/help/ebook">Download</a></p>
','quicklinks','','Yes','smart_h_link','Content','8');
-- query
INSERT INTO app_pages VALUES ('5','0','','','','home-page-summary','','<?php 
    // Enter List of page name
    $pages= array(
        ''quick-start'',
        ''page-manager'',
        ''plugin-component'',
        ''concept-of-development'',
        ''informationset-categoryset'',
        ''theme-development'',
        ''general-help-center''
    );
?>
    
<?php   
    // Run loop to print HTML
    // We can do had code in Static page as well
    foreach($pages as $name): ?>
    <h4>
        <span class="glyphicon glyphicon-circle-arrow-right"></span>
        <a href="<?php echo App::Config()->baseUrl("/{$name}"); ?>">
            <?php echo App::Module(''Page'')->getData($name,''title''); ?>
        </a>
    </h4>
<?php 
    // End of Loop
    endforeach; ?>    ','','','Yes','h_link','Snip','0');
-- query
INSERT INTO app_pages VALUES ('6','0','Terms of Use: appRain Content Management Framework','Terms, Condition, Copy Right','','terms-of-use','Terms of Use','<p>Copyright (c) appRain CMF (http://www.apprain.com)<br />
<br />
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the &quot;Software&quot;), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:<br />
<br />
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.<br />
<br />
THE SOFTWARE IS PROVIDED &quot;AS IS&quot;, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.</p>
','sitemenu,template_footer_menu','','Yes','smart_h_link','Content','7');
-- query
INSERT INTO app_pages VALUES ('7','0','','','','samplephp','','<?php
    $pages= array(''quick-start'',''page-manager'');
    
    foreach($pageList as $name){
        pr(App::Module(''Page''));
    }
?>','','','Yes','h_link','Snip','0');
-- query
INSERT INTO app_pages VALUES ('8','0','appRain:  Content  Management Framework is a combination of Content Management System and Rapid Development Framework','Content Management System, PHP Framework, PHP Content Management System, PHP CMS, Web Development Tool, Project Development Tool','A PHP Content Management Framework combining  CMS(Content Management System) and Framework (Rapid Development Framework) to enable fast Web Developmen','home-page','What is appRain  Content Management Framework?','<hr />
<h2>What is appRain&nbsp; Content Management Framework?</h2>

<p>appRain is one of the first officially released Opensource Content Management Framework (CMF). CMF is a new web engineering concept where &quot;CMS (Content Management System)&quot; and &quot;Framework&quot; perform together to produce endless varieties of output in a very limited time.</p>

<p>appRain, published with lots of extensive features to reduce our development work time. It satisfies both Client and Developers with a safe and quality output.</p>
','home_content_area_A','','Yes','text','Content','0');
-- query
INSERT INTO app_pages VALUES ('9','0','Page Manager','','','page-manager','Page Manager','<div>
<p><strong>Page Manager</strong> is a frequently used module to create new pages on the website. You will find it in the first tab after logging into the Admin Panel.</p>

<p>Use the link page section to assign your page to different places on the website. You will get a selected section to assign the page in the menu under Quick Links. Holding the CTRL key and clicking with the left mouse button selects multiple hooks.</p>

<p>You can select the option from the drop-down beneath the hook list. The Text option will place the page content in a particular area of a page. Hyperlinks can be of two types; one is Smart Link, which generates a page with an optimized URL. The other is a direct link to the page.</p>

<p>A large text box is available to renter a page in a User Defile Hook defined in the theme; each hook name must be comma separated.</p>

<p>It is really important to format the page well. Use the common field section to set the page title and other meta information.</p>

<p>The Sort Order field is helpful to manage the order of the page in the website menu and quick links.</p>

<p>Dynamic pages are great features in Page Manager for writing server-side code from the interface. All resources should be accessible through App Factory. Because this factory will make all your resources available in the script, To work in a dynamic page, you should be familiar with the system&#39;s internal coding structure. One important tip: dynamic pages render only under static pages. Click on the &quot;Page Code List&quot; button, and the list will pop up. Also, a static page can be rendered alongside another static page. Just paste the page code inside the content.</p>

<p>For developers, there is a detailed module to execute all operations. This module helps to work with pages in the MVC model. Moreover, it has different hooks to register Page Manager in a component in different events.</p>
</div>
','quicklinks','','Yes','smart_h_link','Content','2');
-- query
INSERT INTO app_pages VALUES ('10','0','Quick Start','Quick Start','Quick Start','quick-start','Quick Start','<p>appRain has a multidimensional approach to serving a purpose in web-based software development. Specifically, use it as a content management system or utilize it as a framework.</p>

<p>For a quick start, CMS would be a great area to choose.</p>

<p>appRain has an attractive admin panel; you must login there first. Go to the page manager to take a look around and add some content to the website. You can put the content of a page in a different location on your website by using a user hook. If you wish, you can see all locations by enabling the flag &quot;Show Hook Positions&quot; in Preference &gt; Configuration.</p>

<p>If you love to write PHP, you can create dynamic pages. A dynamic page can only be rendered under a static page.</p>

<p>Next, you might need a blog or a Contact Us page; there may be other features for your site. Just install the component! It will enable additional functionality. Go to the Application tab in the admin panel to add new components.</p>

<p>appRain has a wide range of configurable parameters. You can set up some of them in the preferences section.</p>

<p>Now, for a developer, it is easy to start your development by creating new components. It will keep your code separate, pluggable, and distributable. Any core resource can be inherited by a related hook. Also, development can be done from the &quot;development&quot; folder, especially with themes. It&rsquo;s advisable to use UI Hook to make the theme more accessible by external plug-ins.</p>

<p>Database! Use InformationSet and CategorySet first to serve your purpose. appRain takes care of interface development by creating some XML to make your development faster.</p>

<p>Start coding with the framework and it&#39;s to manage your development in any extend.</p>
','sitemenu','','Yes','smart_h_link','Content','1');
-- query
INSERT INTO app_pages VALUES ('11','0','Concept of Development','Concept of Development','Concept of Development','concept-of-development','Concept of Development','<p>appRain is a robust platform for development that optimizes effort and time.</p>

<p>After setting up appRain, start development with all interface-based tools like Page Manager, Theme, etc. This is the primary stage of your start-up.</p>

<p>After that, find components that fit you and install them. This will save you a lot of time.</p>

<p>Next, work with XML to manage your development to save time. Below are some common sections to work with that are found in &quot;development/definition.&quot;.</p>

<ul>
	<li>Interface Builder is used to develop the admin and manage access control.</li>
	<li>InformationSet and CategorySet help with data management.</li>
	<li>Site Settings is a strong tool to manage configuration.</li>
	<li>The URI Manager is used to manage the routing of the system and dynamically access resources.</li>
	<li>There is a strong language module to maintain information.</li>
	<li>Integrate external UI plug-ins by using add-ons.</li>
</ul>

<p>Now start working with the MVC pattern to meet order requirements. Configure one or multiple databases to work with simultaneously.<br />
This is highly recommended: develop new components for specific requirements. Each component will enrich your personal archive because it is reusable. A component uses any core resource by using a hook.</p>

<p>However, appRain has both ready-made and unstitched tools; we just have to use them as per need.</p>
','quicklinks','','Yes','smart_h_link','Content','4');
-- query
INSERT INTO app_pages VALUES ('12','0','Component Installation','Component Installation','Component Installation','component-installation','Component Installation','<p>Component is a pluggable module, the main logic of it to connect to core system with different hook and add new features. Let&rsquo;s say you want a blog in your website. Just download the component from the archive and install.</p>

<p>Your entire component list can be seen in &quot;Applications&quot; tab after login Admin Panel.</p>

<p>There are few simple steps to install a component. appRain has an installer to add new component.</p>

<ol>
	<li>First login to Admin Panel</li>
	<li>Click on <strong>Application tab</strong> then <strong>Install New Component </strong>button</li>
	<li>Select Component source file in Zip format</li>
	<li>Click on <strong>Install</strong> Button</li>
</ol>

<p>After a successful installation the component will be available in the list. Find your installed Component check and click on ACTIVATE link to enable the component.</p>

<p>If you feel any component is not fit for you, just deactivate it. The component will stop functioning instantly.</p>

<p>Generally all components isolate the code in &ldquo;component&rdquo; folder. If auto installation process does not work you can copy the code in that folder. However, always follow developer&rsquo;s instruction in any exception.<br />
<br />
&nbsp;After installation, new tab or menu can be seen in admin panel and website. It&rsquo;s depending on the architecture of the component development.</p>

<p>A component is always an external resource. If it has been deactivated all resources will be out of the overall system.</p>
','quicklinks','','Yes','smart_h_link','Content','3');
-- query
INSERT INTO app_pages VALUES ('13','0','','','','business_featured-services','','<section id="featured-services">
      <div class="container">
        <div class="row">

          <div class="col-lg-4 box">
            <i class="ion-ios-bookmarks-outline"></i>
            <h4 class="title"><a href="">LOW COST</a></h4>
            <p class="description">
			P500 is mobile version of the ERP, this cost altogether 1000BDT which is much lower then around PC base implementation.</p>
          </div>

          <div class="col-lg-4 box box-bg">
            <i class="ion-ios-stopwatch-outline"></i>
            <h4 class="title"><a href="">More Sales</a></h4>
            <p class="description">
			Under p500, we are offering free sales promotion in Market place and Social networks for free to boast sales. </p>
          </div>

          <div class="col-lg-4 box">
            <i class="ion-ios-heart-outline"></i>
            <h4 class="title"><a href="">FEE E-COMMERCE</a></h4>
            <p class="description">
			Each customer get a free e-commerce website with direct integration with POS devise to communicate with customers.</p>
          </div>

        </div>
      </div>
    </section>','','','Yes','h_link','Snip','0');
-- query
INSERT INTO app_pages VALUES ('14','0','','','','business_about-text','','<section id="about">
      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <h3>About Us</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        </header>

        <div class="row about-cols">

          <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
            <div class="about-col">
              <div class="img">
                <img src="<?php echo App::Config()->skinUrl("/assets/"); ?>img/about-mission.jpg" alt="" class="img-fluid">
                <div class="icon"><i class="bi bi-bar-chart"></i></div>
              </div>
              <h2 class="title"><a href="#">Our Mission</a></h2>
              <p>
                Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod tempor ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
              </p>
            </div>
          </div>

          <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="about-col">
              <div class="img">
                <img src="<?php echo App::Config()->skinUrl("/assets/"); ?>img/about-plan.jpg" alt="" class="img-fluid">
                <div class="icon"><i class="bi bi-brightness-high"></i></div>
              </div>
              <h2 class="title"><a href="#">Our Plan</a></h2>
              <p>
                Sed ut perspiciatis unde omnis iste natus error sit voluptatem doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
              </p>
            </div>
          </div>

          <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="about-col">
              <div class="img">
                <img src="<?php echo App::Config()->skinUrl("/assets/"); ?>img/about-vision.jpg" alt="" class="img-fluid">
                <div class="icon"><i class="bi bi-calendar4-week"></i></div>
              </div>
              <h2 class="title"><a href="#">Our Vision</a></h2>
              <p>
                Nemo enim ipsam voluptatem quia voluptas sit aut odit aut fugit, sed quia magni dolores eos qui ratione voluptatem sequi nesciunt Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet.
              </p>
            </div>
          </div>

        </div>

      </div>
    </section>','','','Yes','h_link','Snip','0');
-- query
INSERT INTO app_pages VALUES ('15','0','','','','business_service-text','','<section id="services">
      <div class="container" data-aos="fade-up">

        <header class="section-header wow fadeInUp">
          <h3>Services</h3>
          <p>Laudem latine persequeris id sed, ex fabulas delectus quo. No vel partiendo abhorreant vituperatoribus, ad pro quaestio laboramus. Ei ubique vivendum pro. At ius nisl accusam lorenta zanos paradigno tridexa panatarel.</p>
        </header>

        <div class="row">

          <div class="col-lg-4 col-md-6 box" data-aos="fade-up" data-aos-delay="100">
            <div class="icon"><i class="bi bi-briefcase"></i></div>
            <h4 class="title"><a href="">Lorem Ipsum</a></h4>
            <p class="description">Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident</p>
          </div>
          <div class="col-lg-4 col-md-6 box" data-aos="fade-up" data-aos-delay="200">
            <div class="icon"><i class="bi bi-card-checklist"></i></div>
            <h4 class="title"><a href="">Dolor Sitema</a></h4>
            <p class="description">Minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat tarad limino ata</p>
          </div>
          <div class="col-lg-4 col-md-6 box" data-aos="fade-up" data-aos-delay="300">
            <div class="icon"><i class="bi bi-bar-chart"></i></div>
            <h4 class="title"><a href="">Sed ut perspiciatis</a></h4>
            <p class="description">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur</p>
          </div>
          <div class="col-lg-4 col-md-6 box" data-aos="fade-up" data-aos-delay="200">
            <div class="icon"><i class="bi bi-binoculars"></i></div>
            <h4 class="title"><a href="">Magni Dolores</a></h4>
            <p class="description">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
          </div>
          <div class="col-lg-4 col-md-6 box" data-aos="fade-up" data-aos-delay="300">
            <div class="icon"><i class="bi bi-brightness-high"></i></div>
            <h4 class="title"><a href="">Nemo Enim</a></h4>
            <p class="description">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque</p>
          </div>
          <div class="col-lg-4 col-md-6 box" data-aos="fade-up" data-aos-delay="400">
            <div class="icon"><i class="bi bi-calendar4-week"></i></div>
            <h4 class="title"><a href="">Eiusmod Tempor</a></h4>
            <p class="description">Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi</p>
          </div>

        </div>

      </div>
    </section>','','','Yes','h_link','Snip','0');
-- query
INSERT INTO app_pages VALUES ('16','0','','','','business_portfolio','','<section id="portfolio" class="section-bg">
      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <h3 class="section-title">Our Portfolio</h3>
        </header>

        <div class="row" data-aos="fade-up" data-aos-delay="100"">
      <div class=" col-lg-12">
          <ul id="portfolio-flters">
            <li data-filter="*" class="filter-active">All</li>
            <li data-filter=".filter-app">App</li>
            <li data-filter=".filter-card">Card</li>
            <li data-filter=".filter-web">Web</li>
          </ul>
        </div>
      </div>

      <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">

        <div class="col-lg-4 col-md-6 portfolio-item filter-app">
          <div class="portfolio-wrap">
            <figure>
              <img src="<?php echo App::Config()->skinUrl("/assets/"); ?>img/portfolio/app1.jpg" class="img-fluid" alt="">
              <a href="<?php echo App::Config()->skinUrl("/assets/"); ?>img/portfolio/app1.jpg" data-lightbox="portfolio" data-title="App 1" class="link-preview"><i class="bi bi-plus"></i></a>
              <a href="portfolio-details.html" class="link-details" title="More Details"><i class="bi bi-link"></i></a>
            </figure>

            <div class="portfolio-info">
              <h4><a href="portfolio-details.html">App 1</a></h4>
              <p>App</p>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 portfolio-item filter-web">
          <div class="portfolio-wrap">
            <figure>
              <img src="<?php echo App::Config()->skinUrl("/assets/"); ?>img/portfolio/web3.jpg" class="img-fluid" alt="">
              <a href="<?php echo App::Config()->skinUrl("/assets/"); ?>img/portfolio/web3.jpg" class="link-preview portfolio-lightbox" data-gallery="portfolioGallery" title="Web 3"><i class="bi bi-plus"></i></a>
              <a href="portfolio-details.html" class="link-details" title="More Details"><i class="bi bi-link"></i></a>
            </figure>

            <div class="portfolio-info">
              <h4><a href="portfolio-details.html">Web 3</a></h4>
              <p>Web</p>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 portfolio-item filter-app">
          <div class="portfolio-wrap">
            <figure>
              <img src="<?php echo App::Config()->skinUrl("/assets/"); ?>img/portfolio/app2.jpg" class="img-fluid" alt="">
              <a href="<?php echo App::Config()->skinUrl("/assets/"); ?>img/portfolio/app2.jpg" class="link-preview portfolio-lightbox" data-gallery="portfolioGallery" title="App 2"><i class="bi bi-plus"></i></a>
              <a href="portfolio-details.html" class="link-details" title="More Details"><i class="bi bi-link"></i></a>
            </figure>

            <div class="portfolio-info">
              <h4><a href="portfolio-details.html">App 2</a></h4>
              <p>App</p>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 portfolio-item filter-card">
          <div class="portfolio-wrap">
            <figure>
              <img src="<?php echo App::Config()->skinUrl("/assets/"); ?>img/portfolio/card2.jpg" class="img-fluid" alt="">
              <a href="<?php echo App::Config()->skinUrl("/assets/"); ?>img/portfolio/card2.jpg" class="link-preview portfolio-lightbox" data-gallery="portfolioGallery" title="Card 2"><i class="bi bi-plus"></i></a>
              <a href="portfolio-details.html" class="link-details" title="More Details"><i class="bi bi-link"></i></a>
            </figure>

            <div class="portfolio-info">
              <h4><a href="portfolio-details.html">Card 2</a></h4>
              <p>Card</p>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 portfolio-item filter-web">
          <div class="portfolio-wrap">
            <figure>
              <img src="<?php echo App::Config()->skinUrl("/assets/"); ?>img/portfolio/web2.jpg" class="img-fluid" alt="">
              <a href="<?php echo App::Config()->skinUrl("/assets/"); ?>img/portfolio/web2.jpg" class="link-preview portfolio-lightbox" data-gallery="portfolioGallery" title="Web 2"><i class="bi bi-plus"></i></a>
              <a href="portfolio-details.html" class="link-details" title="More Details"><i class="bi bi-link"></i></a>
            </figure>

            <div class="portfolio-info">
              <h4><a href="portfolio-details.html">Web 2</a></h4>
              <p>Web</p>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 portfolio-item filter-app">
          <div class="portfolio-wrap">
            <figure>
              <img src="<?php echo App::Config()->skinUrl("/assets/"); ?>img/portfolio/app3.jpg" class="img-fluid" alt="">
              <a href="<?php echo App::Config()->skinUrl("/assets/"); ?>img/portfolio/app3.jpg" class="link-preview portfolio-lightbox" data-gallery="portfolioGallery" title="App 3"><i class="bi bi-plus"></i></a>
              <a href="portfolio-details.html" class="link-details" title="More Details"><i class="bi bi-link"></i></a>
            </figure>

            <div class="portfolio-info">
              <h4><a href="portfolio-details.html">App 3</a></h4>
              <p>App</p>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 portfolio-item filter-card">
          <div class="portfolio-wrap">
            <figure>
              <img src="<?php echo App::Config()->skinUrl("/assets/"); ?>img/portfolio/card1.jpg" class="img-fluid" alt="">
              <a href="<?php echo App::Config()->skinUrl("/assets/"); ?>img/portfolio/card1.jpg" class="link-preview portfolio-lightbox" data-gallery="portfolioGallery" title="Card 1"><i class="bi bi-plus"></i></a>
              <a href="portfolio-details.html" class="link-details" title="More Details"><i class="bi bi-link"></i></a>
            </figure>

            <div class="portfolio-info">
              <h4><a href="portfolio-details.html">Card 1</a></h4>
              <p>Card</p>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 portfolio-item filter-card">
          <div class="portfolio-wrap">
            <figure>
              <img src="<?php echo App::Config()->skinUrl("/assets/"); ?>img/portfolio/card3.jpg" class="img-fluid" alt="">
              <a href="<?php echo App::Config()->skinUrl("/assets/"); ?>img/portfolio/card3.jpg" class="link-preview portfolio-lightbox" data-gallery="portfolioGallery" title="Card 3"><i class="bi bi-plus"></i></a>
              <a href="portfolio-details.html" class="link-details" title="More Details"><i class="bi bi-link"></i></a>
            </figure>

            <div class="portfolio-info">
              <h4><a href="portfolio-details.html">Card 3</a></h4>
              <p>Card</p>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 portfolio-item filter-web">
          <div class="portfolio-wrap">
            <figure>
              <img src="<?php echo App::Config()->skinUrl("/assets/"); ?>img/portfolio/web1.jpg" class="img-fluid" alt="">
              <a href="<?php echo App::Config()->skinUrl("/assets/"); ?>img/portfolio/web1.jpg" class="link-preview portfolio-lightbox" data-gallery="portfolioGallery" title="Web 1"><i class="bi bi-plus"></i></a>
              <a href="portfolio-details.html" class="link-details" title="More Details"><i class="bi bi-link"></i></a>
            </figure>

            <div class="portfolio-info">
              <h4><a href="portfolio-details.html">Web 1</a></h4>
              <p>Web</p>
            </div>
          </div>
        </div>

      </div>

      </div>
    </section>','','','Yes','h_link','Snip','0');
-- query
INSERT INTO app_pages VALUES ('17','0','','','','business_clients','','<section id="clients">
      <div class="container" data-aos="zoom-in">

        <header class="section-header">
          <h3>Our Clients</h3>
        </header>

        <div class="clients-slider swiper">
          <div class="swiper-wrapper align-items-center">
            <div class="swiper-slide"><img src="<?php echo App::Config()->skinUrl("/assets/"); ?>img/clients/client-1.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="<?php echo App::Config()->skinUrl("/assets/"); ?>img/clients/client-2.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="<?php echo App::Config()->skinUrl("/assets/"); ?>img/clients/client-3.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="<?php echo App::Config()->skinUrl("/assets/"); ?>img/clients/client-4.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="<?php echo App::Config()->skinUrl("/assets/"); ?>img/clients/client-5.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="<?php echo App::Config()->skinUrl("/assets/"); ?>img/clients/client-6.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="<?php echo App::Config()->skinUrl("/assets/"); ?>img/clients/client-7.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="<?php echo App::Config()->skinUrl("/assets/"); ?>img/clients/client-8.png" class="img-fluid" alt=""></div>
          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>
    </section>','','','Yes','h_link','Snip','0');
-- query
INSERT INTO app_pages VALUES ('18','0','','','','business_team','','<section id="team">
      <div class="container">
        <div class="section-header wow fadeInUp">
          <h3>Team</h3>
          <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque</p>
        </div>

        <div class="row">

          <div class="col-lg-3 col-md-6 wow fadeInUp">
            <div class="member">
              <img src="<?php echo App::Config()->skinUrl("/img/"); ?>team-1.jpg" class="img-fluid" alt="">
              <div class="member-info">
                <div class="member-info-content">
                  <h4>Walter White</h4>
                  <span>Chief Executive Officer</span>
                  <div class="social">
                    <a href=""><i class="fa fa-twitter"></i></a>
                    <a href=""><i class="fa fa-facebook"></i></a>
                    <a href=""><i class="fa fa-google-plus"></i></a>
                    <a href=""><i class="fa fa-linkedin"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
            <div class="member">
              <img src="<?php echo App::Config()->skinUrl("/img/"); ?>team-2.jpg" class="img-fluid" alt="">
              <div class="member-info">
                <div class="member-info-content">
                  <h4>Sarah Jhonson</h4>
                  <span>Product Manager</span>
                  <div class="social">
                    <a href=""><i class="fa fa-twitter"></i></a>
                    <a href=""><i class="fa fa-facebook"></i></a>
                    <a href=""><i class="fa fa-google-plus"></i></a>
                    <a href=""><i class="fa fa-linkedin"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
            <div class="member">
              <img src="<?php echo App::Config()->skinUrl("/img/"); ?>team-3.jpg" class="img-fluid" alt="">
              <div class="member-info">
                <div class="member-info-content">
                  <h4>William Anderson</h4>
                  <span>CTO</span>
                  <div class="social">
                    <a href=""><i class="fa fa-twitter"></i></a>
                    <a href=""><i class="fa fa-facebook"></i></a>
                    <a href=""><i class="fa fa-google-plus"></i></a>
                    <a href=""><i class="fa fa-linkedin"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
            <div class="member">
              <img src="<?php echo App::Config()->skinUrl("/img/"); ?>team-4.jpg" class="img-fluid" alt="">
              <div class="member-info">
                <div class="member-info-content">
                  <h4>Amanda Jepson</h4>
                  <span>Accountant</span>
                  <div class="social">
                    <a href=""><i class="fa fa-twitter"></i></a>
                    <a href=""><i class="fa fa-facebook"></i></a>
                    <a href=""><i class="fa fa-google-plus"></i></a>
                    <a href=""><i class="fa fa-linkedin"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section>','','','Yes','h_link','Snip','0');
-- query
INSERT INTO app_pages VALUES ('19','0','','','','business_contact_text','','<div class="section-header">
          <h3>Contact Us</h3>
          <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque</p>
        </div>

        <div class="row contact-info">

          <div class="col-md-4">
            <div class="contact-address">
              <i class="ion-ios-location-outline"></i>
              <h3>Address</h3>
              <address>A108 Adam Street, NY 535022, USA</address>
            </div>
          </div>

          <div class="col-md-4">
            <div class="contact-phone">
              <i class="ion-ios-telephone-outline"></i>
              <h3>Phone Number</h3>
              <p><a href="tel:+155895548855">+1 5589 55488 55</a></p>
            </div>
          </div>

          <div class="col-md-4">
            <div class="contact-email">
              <i class="ion-ios-email-outline"></i>
              <h3>Email</h3>
              <p><a href="mailto:info@example.com">info@example.com</a></p>
            </div>
          </div>

        </div>','','','Yes','h_link','Snip','0');
-- query
INSERT INTO app_pages VALUES ('20','0','','','','business_slide','','<section id="hero">
    <div class="hero-container">
      <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

        <ol id="hero-carousel-indicators" class="carousel-indicators"></ol>

        <div class="carousel-inner" role="listbox">

          <div class="carousel-item active" style="background-image: url(<?php echo App::Config()->skinUrl("/assets/"); ?>img/hero-carousel/1.jpg)">
            <div class="carousel-container">
              <div class="container">
                <h2 class="animate__animated animate__fadeInDown">We are professional</h2>
                <p class="animate__animated animate__fadeInUp">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                <a href="#featured-services" class="btn-get-started scrollto animate__animated animate__fadeInUp">Get Started</a>
              </div>
            </div>
          </div>

          <div class="carousel-item" style="background-image: url(<?php echo App::Config()->skinUrl("/assets/"); ?>img/hero-carousel/2.jpg)">
            <div class="carousel-container">
              <div class="container">
                <h2 class="animate__animated animate__fadeInDown">At vero eos et accusamus</h2>
                <p class="animate__animated animate__fadeInUp">Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut.</p>
                <a href="#featured-services" class="btn-get-started scrollto animate__animated animate__fadeInUp">Get Started</a>
              </div>
            </div>
          </div>

          <div class="carousel-item" style="background-image: url(<?php echo App::Config()->skinUrl("/assets/"); ?>img/hero-carousel/3.jpg)">
            <div class="carousel-container">
              <div class="container">
                <h2 class="animate__animated animate__fadeInDown">Temporibus autem quibusdam</h2>
                <p class="animate__animated animate__fadeInUp">Beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt omnis iste natus error sit voluptatem accusantium.</p>
                <a href="#featured-services" class="btn-get-started scrollto animate__animated animate__fadeInUp">Get Started</a>
              </div>
            </div>
          </div>

          <div class="carousel-item" style="background-image: url(<?php echo App::Config()->skinUrl("/assets/"); ?>img/hero-carousel/4.jpg)">
            <div class="carousel-container">
              <div class="container">
                <h2 class="animate__animated animate__fadeInDown">Nam libero tempore</h2>
                <p class="animate__animated animate__fadeInUp">Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum.</p>
                <a href="#featured-services" class="btn-get-started scrollto animate__animated animate__fadeInUp">Get Started</a>
              </div>
            </div>
          </div>

          <div class="carousel-item" style="background-image: url(<?php echo App::Config()->skinUrl("/assets/"); ?>img/hero-carousel/5.jpg)">
            <div class="carousel-container">
              <div class="container">
                <h2 class="animate__animated animate__fadeInDown">Magnam aliquam quaerat</h2>
                <p class="animate__animated animate__fadeInUp">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                <a href="#featured-services" class="btn-get-started scrollto animate__animated animate__fadeInUp">Get Started</a>
              </div>
            </div>
          </div>

        </div>

        <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
          <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
        </a>

        <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
          <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
        </a>

      </div>
    </div>
  </section><!-- End Hero Section -->','','','Yes','h_link','Snip','0');
-- query
INSERT INTO app_pages VALUES ('21','0','About The Theme','About The Theme','About The Theme','about-the-theme','About The Theme','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer non commodo ligula, at dignissim tortor. Donec vitae mi quis enim mollis vulputate vel nec nisl. Donec id neque sem. Nullam laoreet ut eros vel pulvinar. Curabitur dictum metus tortor, et facilisis erat rutrum auctor. Nulla vulputate efficitur libero, blandit lobortis mi placerat non. Suspendisse vitae est finibus, molestie ligula sodales, posuere nisl. Suspendisse lectus ex, pulvinar nec varius venenatis, aliquet sed massa. Fusce risus libero, ultricies ac vestibulum vitae, congue et risus.</p>

<p>Suspendisse potenti. Maecenas vestibulum lorem tempor turpis posuere imperdiet. Pellentesque sed vestibulum tortor. Aenean aliquam, erat a tristique ultrices, purus magna maximus sem, sit amet facilisis odio mauris sed massa. Duis ut turpis at risus dignissim mollis. Aliquam vel tempor sem. Vivamus a ex dictum, consequat leo ac, dapibus dui.</p>

<p>Curabitur malesuada, lectus quis rutrum luctus, dolor sapien varius justo, at vehicula metus magna sed urna. In placerat, lectus in vestibulum iaculis, neque mauris feugiat nulla, vestibulum placerat massa elit sit amet dolor. Praesent in nisl feugiat urna ultricies sollicitudin. Nunc fermentum leo eu fermentum mollis. Quisque lobortis odio ornare magna congue elementum. Ut at auctor risus. Nulla pharetra a lectus non malesuada. Suspendisse dapibus commodo nulla, ornare vehicula turpis congue a. Nam scelerisque varius lacus, non facilisis purus eleifend a. Vestibulum egestas consequat elit. Suspendisse tristique, est nec posuere convallis, neque lorem mollis dui, feugiat luctus magna orci in ex.</p>
','sitemenu','','Yes','smart_h_link','Content','0');
-- query
INSERT INTO app_pages VALUES ('22','0','About Release','About Release','About Release','about-release','About Release','<p>Version 4.0.5 has come up with many fixes with the new version of PHP.This release includes two components: ethincal and messenger, which play a significant role in development.</p>

<p>The ethical component will help mitigate the security and compliance issues and interface with other systems.</p>

<p>A new bootstart theme is added without modifying the library, so developers can start easily.</p>
','sitemenu','','Yes','smart_h_link','Content','0');
-- query
DROP TABLE IF EXISTS app_sconfigs;
-- query
CREATE TABLE `app_sconfigs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkey` int(11) NOT NULL DEFAULT 0,
  `soption` text NOT NULL,
  `svalue` text NOT NULL,
  `sort_order` varchar(5) NOT NULL,
  `section` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=220 DEFAULT CHARSET=utf8;
-- query
INSERT INTO app_sconfigs VALUES ('1','0','theme','bootstrap','0','hidden');
-- query
INSERT INTO app_sconfigs VALUES ('2','0','site_logo','','','themesettings');
-- query
INSERT INTO app_sconfigs VALUES ('3','0','default_pagination','50','19','general');
-- query
INSERT INTO app_sconfigs VALUES ('4','0','time_zone','Asia/Dhaka','23','general');
-- query
INSERT INTO app_sconfigs VALUES ('5','0','copy_right_text','Copyright Apprain Technologies','','general');
-- query
INSERT INTO app_sconfigs VALUES ('6','0','site_title','Start with appRain','','');
-- query
INSERT INTO app_sconfigs VALUES ('7','0','admin_title','Start with appRain Admin','','');
-- query
INSERT INTO app_sconfigs VALUES ('8','0','admin_email','info@site.com','','');
-- query
INSERT INTO app_sconfigs VALUES ('9','0','activity_widget','Yes','','');
-- query
INSERT INTO app_sconfigs VALUES ('10','0','leave_amessage_widget','Yes','','');
-- query
INSERT INTO app_sconfigs VALUES ('11','0','disable_quick_links','No','','themesettings');
-- query
INSERT INTO app_sconfigs VALUES ('12','0','whitecloud_disable_footer','No','','themesettings');
-- query
INSERT INTO app_sconfigs VALUES ('13','0','whitecloud_background_position','bgstartfromtop','','themesettings');
-- query
INSERT INTO app_sconfigs VALUES ('15','0','appslidesettings_displaymode','ajaxbased','','appslidesettings');
-- query
INSERT INTO app_sconfigs VALUES ('18','0','site_homepage_layout','default','','themesettings');
-- query
INSERT INTO app_sconfigs VALUES ('19','0','site_pageview_layout','default','','themesettings');
-- query
INSERT INTO app_sconfigs VALUES ('20','0','site_defaultview_layout','default','','themesettings');
-- query
INSERT INTO app_sconfigs VALUES ('21','0','flash_file_uploader','Yes','','');
-- query
INSERT INTO app_sconfigs VALUES ('31','0','add_new_page_in_menu_automarically','Yes','','opts');
-- query
INSERT INTO app_sconfigs VALUES ('32','0','disable_page_meta_options','Yes','','opts');
-- query
INSERT INTO app_sconfigs VALUES ('33','0','disable_menu_icon','No','','opts');
-- query
INSERT INTO app_sconfigs VALUES ('34','0','quick_navigation_widget','Yes','','opts');
-- query
INSERT INTO app_sconfigs VALUES ('35','0','currency','BDT','','opts');
-- query
INSERT INTO app_sconfigs VALUES ('36','0','is_site_alive','Yes','','opts');
-- query
INSERT INTO app_sconfigs VALUES ('37','0','large_image_width','500','','opts');
-- query
INSERT INTO app_sconfigs VALUES ('38','0','large_image_height','500','','opts');
-- query
INSERT INTO app_sconfigs VALUES ('39','0','rich_text_editor','Yes','','opts');
-- query
INSERT INTO app_sconfigs VALUES ('40','0','emailsetup_enabled','Yes','','opts');
-- query
INSERT INTO app_sconfigs VALUES ('41','0','emailsetup_host','localhost','','opts');
-- query
INSERT INTO app_sconfigs VALUES ('42','0','emailsetup_port','25','','opts');
-- query
INSERT INTO app_sconfigs VALUES ('43','0','emailsetup_username','','','opts');
-- query
INSERT INTO app_sconfigs VALUES ('44','0','emailsetup_password','','','opts');
-- query
INSERT INTO app_sconfigs VALUES ('52','0','support_email','support@apprain.com','','general');
-- query
INSERT INTO app_sconfigs VALUES ('207','0','admin_landing_page','admin/introduction','','opts');
-- query
INSERT INTO app_sconfigs VALUES ('128','0','business_date','','','businessdate');
-- query
INSERT INTO app_sconfigs VALUES ('129','0','business_time','','','businessdate');
-- query
INSERT INTO app_sconfigs VALUES ('154','0','fileresource_id','','','opts');
-- query
INSERT INTO app_sconfigs VALUES ('155','0','db_version','2.5.4','','opts');
-- query
INSERT INTO app_sconfigs VALUES ('158','0','time_zone_padding','','','opts');
-- query
INSERT INTO app_sconfigs VALUES ('181','0','language','default','','');
-- query
INSERT INTO app_sconfigs VALUES ('186','0','adminpanel_quick_launch','{"/page/manage-static-pages":{"title":"Manage Pages","iconpath":"/themeroot/admin/images/icons/info.jpg","mylink":"/page/manage-static-pages","fetchtype":"URL"},"/admin/managegroup":{"title":"Manage Group","iconpath":"/themeroot/admin/images/icons/info.jpg","mylink":"/admin/managegroup","fetchtype":"URL"},"/admin/manage":{"title":"Manage Users","iconpath":"/themeroot/admin/images/icons/info.jpg","mylink":"/admin/manage","fetchtype":"URL"}}','','');
-- query
INSERT INTO app_sconfigs VALUES ('191','0','quick_navigation_show_calander','Yes','','opts');
-- query
INSERT INTO app_sconfigs VALUES ('192','0','emailsetup_from_email','','','opts');
-- query
INSERT INTO app_sconfigs VALUES ('209','0','logo','','','general');
-- query
INSERT INTO app_sconfigs VALUES ('214','0','last_synced','','','');
-- query
INSERT INTO app_sconfigs VALUES ('215','0','last_message_board_synced','','','');
