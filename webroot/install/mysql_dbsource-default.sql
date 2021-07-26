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
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
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
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;
-- query
INSERT INTO {_prefix_}appreportcodes VALUES ('1','1','Test Report','1','1519835753.arbt','2021-07-26 23:16:05');
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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
-- query
INSERT INTO {_prefix_}appslide VALUES ('1','1','2015-06-18 12:25:11','2016-06-15 17:08:08','appRain CMS','CMS.png','<h1>appRain CMS</h1>

<p>appRain helps you to develop web based software with effortless try. Install it by simple wizard and add necessary plug-in to meet up self or client demand. Use this part of appRain to start your development without high level technical knowledge.</p>

<h3>Make development 100% faster</h3>
','Active');
-- query
INSERT INTO {_prefix_}appslide VALUES ('2','1','2015-06-18 12:25:11','2016-06-15 17:07:59','appRain Framework','Framework.png','<h1>appRain Framework</h1>

<p>appRain Framework is open for you, this is simply a large platform to make your work robust. Environment is organized with latest programming patterns and easy to extend in any edge of reusable development to make you well-built.</p>

<h3>For robast development</h3>
','Active');
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
INSERT INTO {_prefix_}categories VALUES ('1','0','1','0','','Test','','appreportgroup','','2021-07-26 23:15:57','2021-07-26 23:15:57');
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
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
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
INSERT INTO {_prefix_}coreresources VALUES ('11','appslide','Component','0.1.0','Active','a:1:{s:11:"installdate";s:19:"2021-07-26 06:54:55";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('12','homepress','Component','0.1.0','Active','a:1:{s:11:"installdate";s:19:"2021-07-26 06:55:04";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('13','pagemanager','Component','1.2.6','Active','a:1:{s:11:"installdate";s:19:"2021-07-26 22:18:13";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('14','adminpanelquicklaunch','Component','1.0.1','Inactive','a:1:{s:11:"installdate";s:19:"2021-07-26 23:06:37";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('15','dbexpert','Component','0.1.2','Active','a:1:{s:11:"installdate";s:19:"2021-07-26 22:51:31";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('16','ethical','Component','2.1.1','Active','a:1:{s:11:"installdate";s:19:"2021-07-26 23:06:08";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('17','appreport','Component','2.1.1','Active','a:1:{s:11:"installdate";s:19:"2021-07-26 23:06:40";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('18','Appreportcode','Model','0.1.0','Active','');
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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
-- query
INSERT INTO {_prefix_}emailtemplate VALUES ('1','1','2012-08-22 15:59:32','2020-03-18 11:38:45','InventoryReachedCriticalQuantity','Refill your inventory urgently','Dear Concern,
Following product has  reached critical quantity. Refill your inventory urgently. 

<strong>Product Information:</strong>
ID:{id}, Name: {title}, Qty:  {qty}

<hr />
<a href="{baseurl}/admin"></a>');
-- query
INSERT INTO {_prefix_}emailtemplate VALUES ('2','1','2012-08-22 15:59:32','2020-03-18 11:38:45','InventoryAdjusted','Inventory has been adjusted','Dear Concern,
Following product has been adjusted. 

<strong>Product Name:</strong>
 {title} 
<strong>Quantity Reached:</strong>
 {qty} 


<hr />
<a href="{baseurl}/admin">View Admin Panel</a>');
-- query
INSERT INTO {_prefix_}emailtemplate VALUES ('3','1','2012-08-22 15:59:32','2020-03-18 11:38:45','StorePaymentSuccessAdmin','One Order completed successfully','Dear Admin,
Order has been completed successfully. Please find the attached invoice.

You order is id : {OrderId}.


<hr />
<a href="{baseurl}">View Website</a>
<a href="{baseurl}/admin">Admin Panel</a>');
-- query
INSERT INTO {_prefix_}emailtemplate VALUES ('4','1','2012-08-22 15:59:32','2020-03-18 11:38:45','StorePaymentSuccessCustomer','Order completed successfully','Dear Customer,
Congratulation! Order has been completed successfully. Please find the attached invoice.

You order is id : {OrderId}.

Please contact us at info@example.com or call us at 0123456789 for any further assistance.


<hr />
<a href="{baseurl}">View Website</a>
<a href="{baseurl}/admin">Admin Panel</a>');
-- query
INSERT INTO {_prefix_}emailtemplate VALUES ('5','1','2012-08-22 15:59:32','2020-03-18 11:38:45','StorePaymentFailedAdmin','One Order completed unsuccessfully','Dear Admin,
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
INSERT INTO {_prefix_}emailtemplate VALUES ('6','1','2012-08-22 15:59:32','2020-03-18 11:38:45','StorePaymentFailedCustomer','Order unsuccessful notification','Dear Customer,
Unfortunately your payment did not complete successfully.
Order Id: {OrderId}

Please contact us at info@example.com or call us at 0123456789 for any further assistance.


<hr />
<a href="{baseurl}">View Website</a>
<a href="{baseurl}/admin">Admin Panel</a>');
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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
-- query
INSERT INTO {_prefix_}homepress VALUES ('1','1','2016-05-04 19:12:42','2016-06-15 17:07:29','Page Manager','InkPot.jpg','','2','Active','template_left_column_A');
-- query
INSERT INTO {_prefix_}homepress VALUES ('2','1','2016-05-04 19:12:42','2016-06-28 16:14:31','appRain Background','About.jpg','<p>appRain aims to make creating web technology simplified and easily optimized.It makes live easily dynamic.</p>
','9','Active','home_content_area_D');
-- query
INSERT INTO {_prefix_}homepress VALUES ('3','1','2016-05-04 19:12:42','2016-06-28 16:16:08','Concept of Development','Concept.jpg','<p>appRain has both ready-made and un-stitched tool, we just have to use it as per need following the conversions</p>
','4','Active','home_content_area_D');
-- query
INSERT INTO {_prefix_}homepress VALUES ('4','1','2016-05-04 19:12:42','2016-06-28 16:17:34','General Help Center','Help.jpg','<p>Manuals are ready online for User, Developer and learners. Also, you can download or print as you need</p>
','8','Active','home_content_area_D');
-- query
INSERT INTO {_prefix_}homepress VALUES ('5','1','2016-05-04 19:12:42','2016-06-15 17:06:57','Every chance','Theme.jpg','','6','Active','template_left_column_A');
-- query
INSERT INTO {_prefix_}homepress VALUES ('6','1','2016-05-04 19:12:42','2016-06-15 17:06:49','Offer','Engin.jpg','','9','Active','template_left_column_A');
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
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
-- query
INSERT INTO {_prefix_}log VALUES ('1','1','DataDeleted','2021-06-12 00:56:43','a:1:{i:0;a:10:{s:2:"id";s:2:"23";s:8:"adminref";s:1:"1";s:9:"entrydate";s:19:"2015-07-16 23:58:58";s:12:"lastmodified";s:19:"2017-06-10 14:49:07";s:4:"name";s:8:"INTEREST";s:4:"code";s:8:"INTEREST";s:12:"shortcomment";s:8:"INTEREST";s:6:"linked";s:2:"No";s:10:"inverntory";s:2:"No";s:9:"financial";s:3:"Yes";}}');
-- query
INSERT INTO {_prefix_}log VALUES ('2','1','DataDeleted','2021-06-12 00:57:06','a:1:{i:0;a:11:{s:2:"id";s:4:"1799";s:4:"fkey";s:1:"0";s:8:"adminref";s:1:"1";s:8:"parentid";s:1:"0";s:5:"image";s:0:"";s:5:"title";s:24:"GENERAL EXPENSE OUTLET 2";s:11:"description";s:0:"";s:4:"type";s:17:"accopttemplategrp";s:7:"generic";s:0:"";s:9:"entrydate";s:19:"2020-09-04 21:12:20";s:12:"lastmodified";s:19:"2020-09-04 21:12:20";}}');
-- query
INSERT INTO {_prefix_}log VALUES ('3','1','DataDeleted','2021-06-12 00:57:45','a:1:{i:0;a:11:{s:2:"id";s:2:"17";s:4:"fkey";s:1:"0";s:8:"adminref";s:1:"1";s:8:"parentid";s:1:"0";s:5:"image";s:0:"";s:5:"title";s:19:"SUPPLIER MOTIVATION";s:11:"description";s:0:"";s:4:"type";s:17:"accopttemplategrp";s:7:"generic";s:2:"14";s:9:"entrydate";s:19:"2017-03-28 16:39:41";s:12:"lastmodified";s:19:"2017-03-28 16:39:41";}}');
-- query
INSERT INTO {_prefix_}log VALUES ('4','1','DataDeleted','2021-06-12 00:58:09','a:1:{i:0;a:14:{s:2:"id";s:2:"12";s:4:"name";s:26:"LOAN ADJUSTMENT - LOAN PAY";s:12:"debitaccount";s:0:"";s:13:"creditaccount";s:0:"";s:18:"debitautoselection";s:1:"0";s:19:"creditautoselection";s:1:"0";s:4:"code";s:10:"ADJUSTMENT";s:7:"groupid";s:1:"6";s:6:"method";s:10:"Percentage";s:5:"value";s:3:"100";s:11:"shortremark";s:15:"LOAN ADJUSTMENT";s:10:"fullremark";s:0:"";s:9:"entrydate";s:19:"2017-03-28 16:39:41";s:9:"createdby";s:1:"1";}}');
-- query
INSERT INTO {_prefix_}log VALUES ('5','1','DataDeleted','2021-06-12 00:58:13','a:1:{i:0;a:14:{s:2:"id";s:2:"33";s:4:"name";s:24:"GENERAL EXPENSE OUTLET 2";s:12:"debitaccount";s:13:"1020500000036";s:13:"creditaccount";s:13:"1020500000032";s:18:"debitautoselection";s:1:"0";s:19:"creditautoselection";s:1:"0";s:4:"code";s:0:"";s:7:"groupid";s:4:"1799";s:6:"method";s:10:"Percentage";s:5:"value";s:3:"100";s:11:"shortremark";s:7:"EXPENSE";s:10:"fullremark";s:0:"";s:9:"entrydate";s:19:"2020-09-04 09:17:28";s:9:"createdby";s:1:"1";}}');
-- query
INSERT INTO {_prefix_}log VALUES ('6','1','DataDeleted','2021-06-12 00:58:17','a:1:{i:0;a:14:{s:2:"id";s:1:"9";s:4:"name";s:12:"LOAN POSTING";s:12:"debitaccount";s:0:"";s:13:"creditaccount";s:13:"1012443130493";s:18:"debitautoselection";s:1:"1";s:19:"creditautoselection";s:1:"0";s:4:"code";s:10:"STAFF_LOAN";s:7:"groupid";s:1:"1";s:6:"method";s:10:"Percentage";s:5:"value";s:3:"100";s:11:"shortremark";s:18:"PAY FOR STAFF LOAN";s:10:"fullremark";s:12:"LOAN POSTING";s:9:"entrydate";s:19:"2017-03-28 16:39:41";s:9:"createdby";s:1:"1";}}');
-- query
INSERT INTO {_prefix_}log VALUES ('7','1','DataDeleted','2021-06-12 00:58:19','a:1:{i:0;a:14:{s:2:"id";s:2:"17";s:4:"name";s:13:"LOAN DISBURSE";s:12:"debitaccount";s:13:"1012443130493";s:13:"creditaccount";s:13:"1011158392268";s:18:"debitautoselection";s:1:"0";s:19:"creditautoselection";s:1:"0";s:4:"code";s:7:"PAYMENT";s:7:"groupid";s:1:"1";s:6:"method";s:10:"Percentage";s:5:"value";s:3:"100";s:11:"shortremark";s:17:"LOAN DISBURSEMENT";s:10:"fullremark";s:12:"DISBURSEMENT";s:9:"entrydate";s:19:"2017-03-28 16:39:41";s:9:"createdby";s:1:"1";}}');
-- query
INSERT INTO {_prefix_}log VALUES ('8','1','DataDeleted','2021-06-12 00:58:21','a:1:{i:0;a:14:{s:2:"id";s:2:"20";s:4:"name";s:19:"SUPPLIER MOTIVATION";s:12:"debitaccount";s:0:"";s:13:"creditaccount";s:13:"1016251858520";s:18:"debitautoselection";s:1:"1";s:19:"creditautoselection";s:1:"0";s:4:"code";s:18:"SUPPLER_MOTIVATION";s:7:"groupid";s:2:"17";s:6:"method";s:10:"Percentage";s:5:"value";s:3:"100";s:11:"shortremark";s:10:"MOTIVATION";s:10:"fullremark";s:0:"";s:9:"entrydate";s:19:"2017-03-28 16:39:41";s:9:"createdby";s:1:"1";}}');
-- query
INSERT INTO {_prefix_}log VALUES ('9','1','DataDeleted','2021-06-12 00:58:23','a:1:{i:0;a:14:{s:2:"id";s:2:"28";s:4:"name";s:12:"SMS FEES VAT";s:12:"debitaccount";s:13:"1019426541137";s:13:"creditaccount";s:0:"";s:18:"debitautoselection";s:1:"0";s:19:"creditautoselection";s:1:"1";s:4:"code";s:3:"VAT";s:7:"groupid";s:4:"1762";s:6:"method";s:10:"Percentage";s:5:"value";s:2:"15";s:11:"shortremark";s:3:"VAT";s:10:"fullremark";s:0:"";s:9:"entrydate";s:19:"2017-03-28 16:39:41";s:9:"createdby";s:1:"1";}}');
-- query
INSERT INTO {_prefix_}log VALUES ('10','1','DataDeleted','2021-06-12 00:58:25','a:1:{i:0;a:14:{s:2:"id";s:2:"29";s:4:"name";s:16:"OWN SOL TRANSFER";s:12:"debitaccount";s:0:"";s:13:"creditaccount";s:0:"";s:18:"debitautoselection";s:1:"0";s:19:"creditautoselection";s:1:"0";s:4:"code";s:8:"CASH_OUT";s:7:"groupid";s:4:"1775";s:6:"method";s:10:"Percentage";s:5:"value";s:3:"100";s:11:"shortremark";s:8:"TRANSFER";s:10:"fullremark";s:19:"INT SOL TR SELF TXN";s:9:"entrydate";s:19:"2018-08-08 04:13:13";s:9:"createdby";s:1:"1";}}');
-- query
INSERT INTO {_prefix_}log VALUES ('11','1','DataDeleted','2021-06-12 00:58:27','a:1:{i:0;a:14:{s:2:"id";s:2:"30";s:4:"name";s:18:"OTHER SOL TRANSFER";s:12:"debitaccount";s:0:"";s:13:"creditaccount";s:0:"";s:18:"debitautoselection";s:1:"0";s:19:"creditautoselection";s:1:"0";s:4:"code";s:7:"CASH_IN";s:7:"groupid";s:4:"1775";s:6:"method";s:10:"Percentage";s:5:"value";s:3:"100";s:11:"shortremark";s:7:"CASH IN";s:10:"fullremark";s:19:"INT SOL TR OTHR TXN";s:9:"entrydate";s:19:"2018-08-08 04:15:47";s:9:"createdby";s:1:"1";}}');
-- query
INSERT INTO {_prefix_}log VALUES ('12','1','DataDeleted','2021-06-12 00:58:28','a:1:{i:0;a:14:{s:2:"id";s:2:"31";s:4:"name";s:17:"CASH PAY OUTLET 2";s:12:"debitaccount";s:0:"";s:13:"creditaccount";s:13:"1020500000032";s:18:"debitautoselection";s:1:"1";s:19:"creditautoselection";s:1:"0";s:4:"code";s:8:"CASH_OUT";s:7:"groupid";s:4:"1797";s:6:"method";s:10:"Percentage";s:5:"value";s:3:"100";s:11:"shortremark";s:8:"CASH PAY";s:10:"fullremark";s:0:"";s:9:"entrydate";s:19:"2020-09-04 09:19:24";s:9:"createdby";s:1:"1";}}');
-- query
INSERT INTO {_prefix_}log VALUES ('13','1','DataDeleted','2021-06-12 00:58:30','a:1:{i:0;a:14:{s:2:"id";s:2:"32";s:4:"name";s:21:"CASH RECEIVE OUTLET 2";s:12:"debitaccount";s:13:"1020500000032";s:13:"creditaccount";s:0:"";s:18:"debitautoselection";s:1:"0";s:19:"creditautoselection";s:1:"1";s:4:"code";s:7:"CASH_IN";s:7:"groupid";s:4:"1798";s:6:"method";s:10:"Percentage";s:5:"value";s:3:"100";s:11:"shortremark";s:7:"CASH IN";s:10:"fullremark";s:0:"";s:9:"entrydate";s:19:"2020-09-04 09:19:35";s:9:"createdby";s:1:"1";}}');
-- query
INSERT INTO {_prefix_}log VALUES ('14','1','DataDeleted','2021-06-12 01:02:39','a:1:{i:0;a:9:{s:2:"id";s:1:"5";s:8:"adminref";s:1:"1";s:9:"entrydate";s:19:"2018-04-21 20:05:03";s:12:"lastmodified";s:19:"2020-12-03 17:48:39";s:4:"name";s:19:"Pharmacy Terminal 2";s:4:"code";s:3:"202";s:8:"location";s:0:"";s:7:"cashacc";s:13:"1020500000032";s:5:"store";s:1:"2";}}');
-- query
INSERT INTO {_prefix_}log VALUES ('15','1','DataDeleted','2021-06-12 01:02:43','a:1:{i:0;a:9:{s:2:"id";s:1:"6";s:8:"adminref";s:1:"1";s:9:"entrydate";s:19:"2018-04-21 20:05:03";s:12:"lastmodified";s:19:"2021-02-22 17:38:02";s:4:"name";s:18:"TERMINAL-3 (JELAN)";s:4:"code";s:3:"203";s:8:"location";s:0:"";s:7:"cashacc";s:13:"1010500000121";s:5:"store";s:1:"1";}}');
-- query
INSERT INTO {_prefix_}log VALUES ('16','1','DataDeleted','2021-06-12 01:05:53','a:1:{i:0;a:17:{s:2:"id";s:2:"17";s:8:"entityid";s:1:"0";s:2:"no";s:17:"20502290100063514";s:7:"acctype";s:1:"1";s:4:"name";s:16:"COMPANY BANK C/A";s:9:"accstatus";s:1:"1";s:4:"tier";s:4:"1002";s:11:"nonnegative";s:1:"Y";s:6:"scheme";s:1:"C";s:4:"curr";s:3:"050";s:10:"branchcode";s:3:"101";s:12:"externalcode";s:1:"0";s:16:"externalcodetype";s:0:"";s:7:"balance";s:1:"0";s:8:"operator";s:1:"1";s:9:"entrydate";s:19:"2018-04-22 02:29:30";s:6:"remark";s:12:"COMPANY BANK";}}');
-- query
INSERT INTO {_prefix_}log VALUES ('17','2147483647','POS_ITEM_FAIELD','2021-07-09 15:12:13','SELECT_ITEM');
-- query
INSERT INTO {_prefix_}log VALUES ('18','2147483647','POS_ITEM_FAIELD','2021-07-09 15:12:19','SELECT_ITEM');
-- query
INSERT INTO {_prefix_}log VALUES ('19','5275','POS_ITEM_FAIELD','2021-07-09 15:12:32','INSUFFICIENT_QTY');
-- query
INSERT INTO {_prefix_}log VALUES ('20','1','DataDeleted','2021-07-09 15:17:00','a:1:{i:0;a:26:{s:2:"id";s:1:"6";s:6:"itemid";s:2:"28";s:7:"storeid";s:1:"1";s:5:"value";s:4:"0.24";s:12:"presentstock";s:6:"399.76";s:8:"discount";s:1:"0";s:14:"discountmethod";s:1:"F";s:9:"unitprice";s:2:"19";s:17:"unitpurchaseprice";s:1:"0";s:7:"vatrate";s:1:"0";s:3:"vat";s:1:"0";s:8:"subtotal";s:4:"4.56";s:11:"totaleprice";s:4:"4.56";s:18:"totalpurchaseprice";s:1:"0";s:9:"invoiceid";s:3:"769";s:5:"lotno";s:0:"";s:11:"productcode";s:0:"";s:5:"color";s:0:"";s:5:"sizes";s:0:"";s:10:"attributes";s:0:"";s:8:"supplier";s:1:"0";s:8:"warranty";s:0:"";s:5:"track";s:3:"4|0";s:8:"returned";s:1:"0";s:11:"additionals";s:0:"";s:9:"entrydate";s:19:"2021-07-09 15:16:11";}}');
-- query
INSERT INTO {_prefix_}log VALUES ('21','1','DataDeleted','2021-07-09 15:18:02','a:1:{i:0;a:26:{s:2:"id";s:1:"7";s:6:"itemid";s:2:"28";s:7:"storeid";s:1:"1";s:5:"value";s:6:"0.2407";s:12:"presentstock";s:8:"399.7593";s:8:"discount";s:1:"0";s:14:"discountmethod";s:1:"F";s:9:"unitprice";s:2:"19";s:17:"unitpurchaseprice";s:1:"0";s:7:"vatrate";s:1:"0";s:3:"vat";s:1:"0";s:8:"subtotal";s:6:"4.5733";s:11:"totaleprice";s:6:"4.5733";s:18:"totalpurchaseprice";s:1:"0";s:9:"invoiceid";s:3:"769";s:5:"lotno";s:0:"";s:11:"productcode";s:0:"";s:5:"color";s:0:"";s:5:"sizes";s:0:"";s:10:"attributes";s:0:"";s:8:"supplier";s:1:"0";s:8:"warranty";s:0:"";s:5:"track";s:3:"4|0";s:8:"returned";s:1:"0";s:11:"additionals";s:0:"";s:9:"entrydate";s:19:"2021-07-09 15:17:05";}}');
-- query
INSERT INTO {_prefix_}log VALUES ('22','1','DataDeleted','2021-07-09 15:18:50','a:1:{i:0;a:26:{s:2:"id";s:1:"8";s:6:"itemid";s:2:"28";s:7:"storeid";s:1:"1";s:5:"value";s:6:"0.2407";s:12:"presentstock";s:8:"399.7593";s:8:"discount";s:1:"0";s:14:"discountmethod";s:1:"F";s:9:"unitprice";s:2:"19";s:17:"unitpurchaseprice";s:1:"0";s:7:"vatrate";s:1:"0";s:3:"vat";s:1:"0";s:8:"subtotal";s:6:"4.5733";s:11:"totaleprice";s:6:"4.5733";s:18:"totalpurchaseprice";s:1:"0";s:9:"invoiceid";s:3:"769";s:5:"lotno";s:0:"";s:11:"productcode";s:0:"";s:5:"color";s:0:"";s:5:"sizes";s:0:"";s:10:"attributes";s:0:"";s:8:"supplier";s:1:"0";s:8:"warranty";s:0:"";s:5:"track";s:3:"4|0";s:8:"returned";s:1:"0";s:11:"additionals";s:0:"";s:9:"entrydate";s:19:"2021-07-09 15:18:08";}}');
-- query
INSERT INTO {_prefix_}log VALUES ('23','1','DataDeleted','2021-07-09 15:23:39','a:1:{i:0;a:26:{s:2:"id";s:1:"9";s:6:"itemid";s:2:"28";s:7:"storeid";s:1:"1";s:5:"value";s:4:"0.24";s:12:"presentstock";s:6:"399.76";s:8:"discount";s:1:"0";s:14:"discountmethod";s:1:"F";s:9:"unitprice";s:2:"25";s:17:"unitpurchaseprice";s:1:"0";s:7:"vatrate";s:1:"0";s:3:"vat";s:1:"0";s:8:"subtotal";s:1:"6";s:11:"totaleprice";s:1:"6";s:18:"totalpurchaseprice";s:1:"0";s:9:"invoiceid";s:3:"769";s:5:"lotno";s:0:"";s:11:"productcode";s:0:"";s:5:"color";s:0:"";s:5:"sizes";s:0:"";s:10:"attributes";s:0:"";s:8:"supplier";s:1:"0";s:8:"warranty";s:0:"";s:5:"track";s:3:"4|0";s:8:"returned";s:1:"0";s:11:"additionals";s:0:"";s:9:"entrydate";s:19:"2021-07-09 15:19:07";}}');
-- query
INSERT INTO {_prefix_}log VALUES ('24','1','DataDeleted','2021-07-09 15:25:16','a:1:{i:0;a:26:{s:2:"id";s:2:"10";s:6:"itemid";s:2:"28";s:7:"storeid";s:1:"1";s:5:"value";s:6:"0.2407";s:12:"presentstock";s:8:"399.7593";s:8:"discount";s:1:"0";s:14:"discountmethod";s:1:"F";s:9:"unitprice";s:2:"25";s:17:"unitpurchaseprice";s:1:"0";s:7:"vatrate";s:1:"0";s:3:"vat";s:1:"0";s:8:"subtotal";s:6:"6.0175";s:11:"totaleprice";s:6:"6.0175";s:18:"totalpurchaseprice";s:1:"0";s:9:"invoiceid";s:3:"769";s:5:"lotno";s:0:"";s:11:"productcode";s:0:"";s:5:"color";s:0:"";s:5:"sizes";s:0:"";s:10:"attributes";s:0:"";s:8:"supplier";s:1:"0";s:8:"warranty";s:0:"";s:5:"track";s:3:"4|0";s:8:"returned";s:1:"0";s:11:"additionals";s:0:"";s:9:"entrydate";s:19:"2021-07-09 15:23:45";}}');
-- query
INSERT INTO {_prefix_}log VALUES ('25','1','DataDeleted','2021-07-26 22:43:32','a:1:{i:0;a:17:{s:2:"id";s:2:"27";s:7:"groupid";s:1:"0";s:6:"f_name";s:7:"Chandon";s:6:"l_name";s:7:"Bhuiyan";s:8:"username";s:7:"Chandon";s:8:"password";s:32:"c44b141cdccc00893c884e70ddbd8f65";s:5:"email";s:21:"chandonrain@gmail.com";s:10:"createdate";s:19:"2020-12-10 11:37:42";s:11:"latestlogin";s:10:"1617756347";s:9:"lastlogin";s:10:"1617714255";s:6:"status";s:6:"Active";s:4:"type";s:6:"Normal";s:3:"acl";s:1737:"a:4:{s:8:"accounts";a:4:{i:5;a:3:{i:0;s:25:"/searchexpert/do/accounts";i:1;s:18:"/accounts/save/new";i:2;s:22:"/accounts/accountchart";}i:6;a:5:{i:0;s:38:"/category/manage/accopttemplategrp/add";i:1;s:34:"/category/manage/accopttemplategrp";i:2;s:34:"/accounts/operationtemplate/create";i:3;s:27:"/accounts/operationtemplate";i:4;s:15:"/accounts/inout";}i:7;a:1:{i:0;s:27:"/accounts/transactionviewer";}i:9;a:4:{i:0;s:22:"/voucher/manage/create";i:1;s:15:"/voucher/manage";i:2;s:18:"/voucher/bulkentry";i:3;s:29:"/admin/config/vouchersettings";}}s:9:"admission";a:1:{i:3;a:3:{i:0;s:26:"/searchexpert/do/admission";i:1;s:16:"/admission/entry";i:2;s:24:"/admission/manageentries";}}s:9:"inventory";a:7:{i:2;a:3:{i:0;s:31:"/searchexpert/do/invprodcompany";i:1;s:38:"/information/manage/invprodcompany/add";i:2;s:34:"/information/manage/invprodcompany";}i:3;a:3:{i:0;s:32:"/searchexpert/do/invitemcategory";i:1;s:31:"/category/manage/invitemcat/add";i:2;s:27:"/category/manage/invitemcat";}i:4;a:4:{i:0;s:24:"/searchexpert/do/invitem";i:1;s:26:"/inventory/manageitems/add";i:2;s:22:"/inventory/manageitems";i:3;s:24:"/inventory/itembulkentry";}i:5;a:4:{i:0;s:26:"/searchexpert/do/invordsrc";i:1;s:22:"/order/purchase/create";i:2;s:28:"/order/purchasereturn/create";i:3;s:16:"/inventory/order";}i:6;a:1:{i:2;s:26:"/inventory/stockmonitoring";}i:7;a:4:{i:0;s:27:"/searchexpert/do/invinvoice";i:2;s:22:"/inventory/invoicelist";i:3;s:25:"/inventory/salemonitoring";i:4;s:41:"/developer/debug-log/db?s=POS_ITEM_FAIELD";}i:9;a:3:{i:0;s:40:"/information/manage/invpaymentmethod/add";i:1;s:36:"/information/manage/invpaymentmethod";i:2;s:39:"/extpaymentmethod/transactionmonitoring";}}s:9:"appreport";a:1:{i:2;a:1:{i:0;s:19:"/appreport/executor";}}}";s:9:"aclobject";s:779:"a:4:{s:17:"accopttemplategrp";a:8:{i:2;a:1:{i:0;s:3:"Yes";}i:4;a:1:{i:0;s:3:"Yes";}i:5;a:1:{i:0;s:3:"Yes";}i:7;a:1:{i:0;s:3:"Yes";}i:18;a:1:{i:0;s:3:"Yes";}i:19;a:1:{i:0;s:3:"Yes";}i:20;a:1:{i:0;s:3:"Yes";}i:29;a:1:{i:0;s:3:"Yes";}}s:10:"accounting";a:1:{s:13:"defaultbranch";s:3:"101";}s:18:"appreportoperation";a:5:{i:9;a:1:{i:0;s:3:"Yes";}i:10;a:1:{i:0;s:3:"Yes";}i:23;a:1:{i:0;s:3:"Yes";}i:24;a:1:{i:0;s:3:"Yes";}i:179;a:1:{i:0;s:3:"Yes";}}s:16:"inventoryaclopts";a:5:{s:28:"inventory_invoice_adjustment";a:4:{i:0;s:6:"return";i:1;s:8:"discount";i:2;s:18:"change_sales_price";i:3;s:21:"change_service_charge";}s:33:"invenotry_maskduringshadowenabled";s:2:"No";s:24:"invenotry_changestockqty";s:3:"Yes";s:18:"invenotry_terminal";s:0:"";s:15:"itemrestriction";s:8:"disabled";}}";s:11:"description";s:0:"";s:8:"resetsid";s:0:"";s:13:"lastresettime";s:1:"0";}}');
-- query
INSERT INTO {_prefix_}log VALUES ('26','1','DataDeleted','2021-07-26 22:43:33','a:1:{i:0;a:17:{s:2:"id";s:2:"29";s:7:"groupid";s:1:"0";s:6:"f_name";s:2:"Md";s:6:"l_name";s:5:"Zilan";s:8:"username";s:5:"zilan";s:8:"password";s:32:"a8758bbefb0fd73719270e48b4c7c20c";s:5:"email";s:15:"zilan@gmail.com";s:10:"createdate";s:19:"2021-02-16 13:36:09";s:11:"latestlogin";s:10:"1613830284";s:9:"lastlogin";s:10:"1613485514";s:6:"status";s:6:"Active";s:4:"type";s:6:"Normal";s:3:"acl";s:1322:"a:4:{s:8:"accounts";a:2:{i:5;a:3:{i:0;s:25:"/searchexpert/do/accounts";i:1;s:18:"/accounts/save/new";i:2;s:22:"/accounts/accountchart";}i:7;a:1:{i:0;s:27:"/accounts/transactionviewer";}}s:9:"admission";a:1:{i:3;a:3:{i:0;s:26:"/searchexpert/do/admission";i:1;s:16:"/admission/entry";i:2;s:24:"/admission/manageentries";}}s:9:"inventory";a:6:{i:2;a:3:{i:0;s:31:"/searchexpert/do/invprodcompany";i:1;s:38:"/information/manage/invprodcompany/add";i:2;s:34:"/information/manage/invprodcompany";}i:3;a:3:{i:0;s:32:"/searchexpert/do/invitemcategory";i:1;s:31:"/category/manage/invitemcat/add";i:2;s:27:"/category/manage/invitemcat";}i:4;a:5:{i:0;s:24:"/searchexpert/do/invitem";i:1;s:26:"/inventory/manageitems/add";i:2;s:22:"/inventory/manageitems";i:3;s:24:"/inventory/itembulkentry";i:4;s:24:"/inventory/exportbarcode";}i:5;a:4:{i:0;s:26:"/searchexpert/do/invordsrc";i:1;s:22:"/order/purchase/create";i:2;s:28:"/order/purchasereturn/create";i:3;s:16:"/inventory/order";}i:6;a:4:{i:0;s:19:"/inventory/stock/in";i:1;s:24:"/inventory/stocktransfer";i:2;s:26:"/inventory/stockmonitoring";i:3;s:44:"/inventory/stockmonitoring?entrytype=PENDING";}i:7;a:3:{i:0;s:27:"/searchexpert/do/invinvoice";i:2;s:22:"/inventory/invoicelist";i:3;s:25:"/inventory/salemonitoring";}}s:9:"appreport";a:1:{i:2;a:1:{i:0;s:19:"/appreport/executor";}}}";s:9:"aclobject";s:475:"a:3:{s:10:"accounting";a:1:{s:13:"defaultbranch";s:3:"101";}s:18:"appreportoperation";a:2:{i:9;a:1:{i:0;s:3:"Yes";}i:10;a:1:{i:0;s:3:"Yes";}}s:16:"inventoryaclopts";a:5:{s:28:"inventory_invoice_adjustment";a:4:{i:0;s:6:"return";i:1;s:8:"discount";i:2;s:18:"change_sales_price";i:3;s:21:"change_service_charge";}s:33:"invenotry_maskduringshadowenabled";s:2:"No";s:24:"invenotry_changestockqty";s:2:"No";s:18:"invenotry_terminal";s:0:"";s:15:"itemrestriction";s:8:"disabled";}}";s:11:"description";s:0:"";s:8:"resetsid";s:0:"";s:13:"lastresettime";s:1:"0";}}');
-- query
INSERT INTO {_prefix_}log VALUES ('27','1','DataDeleted','2021-07-26 22:43:35','a:1:{i:0;a:17:{s:2:"id";s:2:"30";s:7:"groupid";s:1:"0";s:6:"f_name";s:2:"Md";s:6:"l_name";s:5:"Sohel";s:8:"username";s:5:"sohel";s:8:"password";s:32:"d5d8aa8a35a03523a44ec06b0a9cd6cf";s:5:"email";s:15:"sohel@gmail.com";s:10:"createdate";s:19:"2021-02-22 15:02:00";s:11:"latestlogin";s:10:"1618485204";s:9:"lastlogin";s:10:"1618479012";s:6:"status";s:6:"Active";s:4:"type";s:6:"Normal";s:3:"acl";s:1218:"a:4:{s:8:"accounts";a:3:{i:5;a:3:{i:0;s:25:"/searchexpert/do/accounts";i:1;s:18:"/accounts/save/new";i:2;s:22:"/accounts/accountchart";}i:7;a:1:{i:0;s:27:"/accounts/transactionviewer";}i:9;a:3:{i:0;s:22:"/voucher/manage/create";i:1;s:15:"/voucher/manage";i:2;s:18:"/voucher/bulkentry";}}s:9:"admission";a:1:{i:3;a:3:{i:0;s:26:"/searchexpert/do/admission";i:1;s:16:"/admission/entry";i:2;s:24:"/admission/manageentries";}}s:9:"inventory";a:5:{i:2;a:3:{i:0;s:31:"/searchexpert/do/invprodcompany";i:1;s:38:"/information/manage/invprodcompany/add";i:2;s:34:"/information/manage/invprodcompany";}i:4;a:4:{i:0;s:24:"/searchexpert/do/invitem";i:2;s:22:"/inventory/manageitems";i:3;s:24:"/inventory/itembulkentry";i:4;s:24:"/inventory/exportbarcode";}i:5;a:4:{i:0;s:26:"/searchexpert/do/invordsrc";i:1;s:22:"/order/purchase/create";i:2;s:28:"/order/purchasereturn/create";i:3;s:16:"/inventory/order";}i:6;a:3:{i:1;s:24:"/inventory/stocktransfer";i:2;s:26:"/inventory/stockmonitoring";i:3;s:44:"/inventory/stockmonitoring?entrytype=PENDING";}i:7;a:3:{i:0;s:27:"/searchexpert/do/invinvoice";i:2;s:22:"/inventory/invoicelist";i:3;s:25:"/inventory/salemonitoring";}}s:9:"appreport";a:1:{i:2;a:1:{i:0;s:19:"/appreport/executor";}}}";s:9:"aclobject";s:587:"a:4:{s:17:"accopttemplategrp";a:6:{i:2;a:1:{i:0;s:3:"Yes";}i:4;a:1:{i:0;s:3:"Yes";}i:5;a:1:{i:0;s:3:"Yes";}i:7;a:1:{i:0;s:3:"Yes";}i:20;a:1:{i:0;s:3:"Yes";}i:29;a:1:{i:0;s:3:"Yes";}}s:10:"accounting";a:1:{s:13:"defaultbranch";s:3:"101";}s:18:"appreportoperation";a:5:{i:9;a:1:{i:0;s:3:"Yes";}i:10;a:1:{i:0;s:3:"Yes";}i:23;a:1:{i:0;s:3:"Yes";}i:24;a:1:{i:0;s:3:"Yes";}i:179;a:1:{i:0;s:3:"Yes";}}s:16:"inventoryaclopts";a:4:{s:33:"invenotry_maskduringshadowenabled";s:2:"No";s:24:"invenotry_changestockqty";s:3:"Yes";s:18:"invenotry_terminal";s:0:"";s:15:"itemrestriction";s:7:"enabled";}}";s:11:"description";s:0:"";s:8:"resetsid";s:0:"";s:13:"lastresettime";s:1:"0";}}');
-- query
INSERT INTO {_prefix_}log VALUES ('28','1','DataDeleted','2021-07-26 22:43:37','a:1:{i:0;a:17:{s:2:"id";s:2:"26";s:7:"groupid";s:1:"0";s:6:"f_name";s:6:"Pijush";s:6:"l_name";s:5:"Bablu";s:8:"username";s:5:"bablu";s:8:"password";s:32:"8dcebe5681864fd001fb1720786ee346";s:5:"email";s:15:"bablu@gmail.com";s:10:"createdate";s:19:"2020-12-04 12:26:02";s:11:"latestlogin";s:10:"1618548043";s:9:"lastlogin";s:10:"1618496120";s:6:"status";s:6:"Active";s:4:"type";s:6:"Normal";s:3:"acl";s:224:"a:1:{s:9:"inventory";a:2:{i:4;a:1:{i:0;s:24:"/searchexpert/do/invitem";}i:7;a:4:{i:0;s:27:"/searchexpert/do/invinvoice";i:1;s:18:"/inventory/invoice";i:2;s:22:"/inventory/invoicelist";i:3;s:25:"/inventory/salemonitoring";}}}";s:9:"aclobject";s:392:"a:4:{s:17:"accopttemplategrp";a:1:{i:7;a:1:{i:0;s:3:"Yes";}}s:10:"accounting";a:1:{s:13:"defaultbranch";s:3:"101";}s:18:"appreportoperation";a:2:{i:9;a:1:{i:0;s:3:"Yes";}i:10;a:1:{i:0;s:3:"Yes";}}s:16:"inventoryaclopts";a:4:{s:33:"invenotry_maskduringshadowenabled";s:3:"Yes";s:24:"invenotry_changestockqty";s:2:"No";s:18:"invenotry_terminal";s:3:"201";s:15:"itemrestriction";s:7:"enabled";}}";s:11:"description";s:0:"";s:8:"resetsid";s:0:"";s:13:"lastresettime";s:1:"0";}}');
-- query
INSERT INTO {_prefix_}log VALUES ('29','1','DataDeleted','2021-07-26 22:43:38','a:1:{i:0;a:17:{s:2:"id";s:2:"25";s:7:"groupid";s:1:"0";s:6:"f_name";s:2:"Md";s:6:"l_name";s:5:"Selim";s:8:"username";s:5:"selim";s:8:"password";s:32:"0a7a6947b248c0535c3301e695605d38";s:5:"email";s:15:"selim@gmail.com";s:10:"createdate";s:19:"2020-12-03 21:08:03";s:11:"latestlogin";s:10:"1610817751";s:9:"lastlogin";s:10:"1610815621";s:6:"status";s:8:"Inactive";s:4:"type";s:6:"Normal";s:3:"acl";s:306:"a:1:{s:9:"inventory";a:3:{i:4;a:2:{i:0;s:24:"/searchexpert/do/invitem";i:2;s:22:"/inventory/manageitems";}i:6;a:1:{i:2;s:26:"/inventory/stockmonitoring";}i:7;a:4:{i:0;s:27:"/searchexpert/do/invinvoice";i:1;s:18:"/inventory/invoice";i:2;s:22:"/inventory/invoicelist";i:3;s:25:"/inventory/salemonitoring";}}}";s:9:"aclobject";s:254:"a:2:{s:10:"accounting";a:1:{s:13:"defaultbranch";s:3:"101";}s:16:"inventoryaclopts";a:4:{s:33:"invenotry_maskduringshadowenabled";s:3:"Yes";s:24:"invenotry_changestockqty";s:2:"No";s:18:"invenotry_terminal";s:0:"";s:15:"itemrestriction";s:8:"disabled";}}";s:11:"description";s:0:"";s:8:"resetsid";s:0:"";s:13:"lastresettime";s:1:"0";}}');
-- query
INSERT INTO {_prefix_}log VALUES ('30','1','DataDeleted','2021-07-26 22:43:40','a:1:{i:0;a:17:{s:2:"id";s:2:"24";s:7:"groupid";s:1:"0";s:6:"f_name";s:5:"Nurul";s:6:"l_name";s:5:"Afsar";s:8:"username";s:5:"afsar";s:8:"password";s:32:"cf6d4633fcaf92ac7e4f8a3c8252a141";s:5:"email";s:15:"afsar@gmail.com";s:10:"createdate";s:19:"2020-12-03 17:55:23";s:11:"latestlogin";s:10:"1607314779";s:9:"lastlogin";s:10:"1607179006";s:6:"status";s:8:"Inactive";s:4:"type";s:6:"Normal";s:3:"acl";s:976:"a:2:{s:9:"admission";a:1:{i:3;a:3:{i:0;s:26:"/searchexpert/do/admission";i:1;s:16:"/admission/entry";i:2;s:24:"/admission/manageentries";}}s:9:"inventory";a:6:{i:2;a:3:{i:0;s:31:"/searchexpert/do/invprodcompany";i:1;s:38:"/information/manage/invprodcompany/add";i:2;s:34:"/information/manage/invprodcompany";}i:3;a:3:{i:0;s:32:"/searchexpert/do/invitemcategory";i:1;s:31:"/category/manage/invitemcat/add";i:2;s:27:"/category/manage/invitemcat";}i:4;a:4:{i:0;s:24:"/searchexpert/do/invitem";i:1;s:26:"/inventory/manageitems/add";i:2;s:22:"/inventory/manageitems";i:3;s:24:"/inventory/itembulkentry";}i:5;a:3:{i:0;s:26:"/searchexpert/do/invordsrc";i:1;s:22:"/order/purchase/create";i:3;s:16:"/inventory/order";}i:6;a:3:{i:0;s:19:"/inventory/stock/in";i:1;s:24:"/inventory/stocktransfer";i:2;s:26:"/inventory/stockmonitoring";}i:7;a:4:{i:0;s:27:"/searchexpert/do/invinvoice";i:1;s:18:"/inventory/invoice";i:2;s:22:"/inventory/invoicelist";i:3;s:25:"/inventory/salemonitoring";}}}";s:9:"aclobject";s:254:"a:2:{s:10:"accounting";a:1:{s:13:"defaultbranch";s:3:"101";}s:16:"inventoryaclopts";a:4:{s:33:"invenotry_maskduringshadowenabled";s:3:"Yes";s:24:"invenotry_changestockqty";s:2:"No";s:18:"invenotry_terminal";s:0:"";s:15:"itemrestriction";s:8:"disabled";}}";s:11:"description";s:0:"";s:8:"resetsid";s:0:"";s:13:"lastresettime";s:1:"0";}}');
-- query
INSERT INTO {_prefix_}log VALUES ('31','1','DataDeleted','2021-07-26 22:43:42','a:1:{i:0;a:17:{s:2:"id";s:2:"23";s:7:"groupid";s:1:"0";s:6:"f_name";s:2:"Md";s:6:"l_name";s:6:"Saiful";s:8:"username";s:6:"saiful";s:8:"password";s:32:"dbbad869ead3e9b75d1c9a67dfcfe05f";s:5:"email";s:16:"saiful@gmail.com";s:10:"createdate";s:19:"2020-12-03 17:53:40";s:11:"latestlogin";s:10:"1607314848";s:9:"lastlogin";s:10:"1607261666";s:6:"status";s:8:"Inactive";s:4:"type";s:6:"Normal";s:3:"acl";s:976:"a:2:{s:9:"admission";a:1:{i:3;a:3:{i:0;s:26:"/searchexpert/do/admission";i:1;s:16:"/admission/entry";i:2;s:24:"/admission/manageentries";}}s:9:"inventory";a:6:{i:2;a:3:{i:0;s:31:"/searchexpert/do/invprodcompany";i:1;s:38:"/information/manage/invprodcompany/add";i:2;s:34:"/information/manage/invprodcompany";}i:3;a:3:{i:0;s:32:"/searchexpert/do/invitemcategory";i:1;s:31:"/category/manage/invitemcat/add";i:2;s:27:"/category/manage/invitemcat";}i:4;a:4:{i:0;s:24:"/searchexpert/do/invitem";i:1;s:26:"/inventory/manageitems/add";i:2;s:22:"/inventory/manageitems";i:3;s:24:"/inventory/itembulkentry";}i:5;a:3:{i:0;s:26:"/searchexpert/do/invordsrc";i:1;s:22:"/order/purchase/create";i:3;s:16:"/inventory/order";}i:6;a:3:{i:0;s:19:"/inventory/stock/in";i:1;s:24:"/inventory/stocktransfer";i:2;s:26:"/inventory/stockmonitoring";}i:7;a:4:{i:0;s:27:"/searchexpert/do/invinvoice";i:1;s:18:"/inventory/invoice";i:2;s:22:"/inventory/invoicelist";i:3;s:25:"/inventory/salemonitoring";}}}";s:9:"aclobject";s:257:"a:2:{s:10:"accounting";a:1:{s:13:"defaultbranch";s:3:"101";}s:16:"inventoryaclopts";a:4:{s:33:"invenotry_maskduringshadowenabled";s:3:"Yes";s:24:"invenotry_changestockqty";s:2:"No";s:18:"invenotry_terminal";s:3:"201";s:15:"itemrestriction";s:8:"disabled";}}";s:11:"description";s:0:"";s:8:"resetsid";s:0:"";s:13:"lastresettime";s:1:"0";}}');
-- query
INSERT INTO {_prefix_}log VALUES ('32','1','DataDeleted','2021-07-26 22:43:59','a:1:{i:0;a:17:{s:2:"id";s:1:"2";s:7:"groupid";s:1:"0";s:6:"f_name";s:6:"System";s:6:"l_name";s:5:"Admin";s:8:"username";s:8:"sysadmin";s:8:"password";s:32:"afdd0b4ad2ec172c586e2150770fbf9e";s:5:"email";s:16:"info@apprain.com";s:10:"createdate";s:19:"2016-08-31 19:17:02";s:11:"latestlogin";s:10:"1600763308";s:9:"lastlogin";s:10:"1600678432";s:6:"status";s:6:"Active";s:4:"type";s:6:"Normal";s:3:"acl";s:3059:"a:7:{s:8:"accounts";a:7:{i:0;a:2:{i:0;s:36:"/information/manage/accgenerator/add";i:1;s:32:"/information/manage/accgenerator";}i:2;a:2:{i:0;s:31:"/information/manage/acctype/add";i:1;s:27:"/information/manage/acctype";}i:3;a:2:{i:0;s:30:"/information/manage/branch/add";i:1;s:26:"/information/manage/branch";}i:4;a:2:{i:0;s:33:"/information/manage/entrycode/add";i:1;s:29:"/information/manage/entrycode";}i:5;a:3:{i:0;s:16:"/search/accounts";i:1;s:18:"/accounts/save/new";i:2;s:22:"/accounts/accountchart";}i:6;a:5:{i:0;s:38:"/category/manage/accopttemplategrp/add";i:1;s:34:"/category/manage/accopttemplategrp";i:2;s:34:"/accounts/operationtemplate/create";i:3;s:27:"/accounts/operationtemplate";i:4;s:15:"/accounts/inout";}i:7;a:1:{i:0;s:27:"/accounts/transactionviewer";}}s:9:"admission";a:4:{i:0;a:1:{i:0;s:31:"/admin/config/admissionsettings";}i:2;a:4:{i:0;s:38:"/category/manage/userattributesgrp/add";i:1;s:34:"/category/manage/userattributesgrp";i:2;s:42:"/information/manage/userattributefieds/add";i:3;s:38:"/information/manage/userattributefieds";}i:3;a:3:{i:0;s:17:"/search/admission";i:1;s:16:"/admission/entry";i:2;s:24:"/admission/manageentries";}i:4;a:1:{i:0;s:22:"/admission/processfees";}}s:9:"inventory";a:10:{i:0;a:2:{i:0;s:36:"/information/manage/invprodstore/add";i:1;s:32:"/information/manage/invprodstore";}i:1;a:2:{i:0;s:35:"/information/manage/invterminal/add";i:1;s:31:"/information/manage/invterminal";}i:2;a:3:{i:0;s:22:"/search/invprodcompany";i:1;s:38:"/information/manage/invprodcompany/add";i:2;s:34:"/information/manage/invprodcompany";}i:3;a:3:{i:0;s:23:"/search/invitemcategory";i:1;s:31:"/category/manage/invitemcat/add";i:2;s:27:"/category/manage/invitemcat";}i:4;a:5:{i:0;s:15:"/search/invitem";i:1;s:26:"/inventory/manageitems/add";i:2;s:22:"/inventory/manageitems";i:3;s:24:"/inventory/itembulkentry";i:4;s:24:"/inventory/exportbarcode";}i:5;a:6:{i:0;s:17:"/search/invordsrc";i:1;s:22:"/order/purchase/create";i:2;s:28:"/order/purchasereturn/create";i:3;s:23:"/inventory/order/create";i:4;s:22:"/inventory/bulkreceive";i:5;s:16:"/inventory/order";}i:6;a:3:{i:0;s:19:"/inventory/stock/in";i:1;s:24:"/inventory/stocktransfer";i:2;s:26:"/inventory/stockmonitoring";}i:7;a:4:{i:0;s:18:"/search/invinvoice";i:1;s:18:"/inventory/invoice";i:2;s:22:"/inventory/invoicelist";i:3;s:25:"/inventory/salemonitoring";}i:8;a:1:{i:0;s:31:"/admin/config/inventorysettings";}i:9;a:2:{i:0;s:41:"//information/manage/invpaymentmethod/add";i:1;s:36:"/information/manage/invpaymentmethod";}}s:9:"appreport";a:3:{i:0;a:2:{i:0;s:35:"/category/manage/appreportgroup/add";i:1;s:31:"/category/manage/appreportgroup";}i:1;a:1:{i:0;s:21:"/appreport/manage/add";}i:2;a:1:{i:0;s:19:"/appreport/executor";}}s:14:"usermanagement";a:1:{i:0;a:2:{i:0;s:17:"/admin/manage/add";i:1;s:13:"/admin/manage";}}s:9:"component";a:2:{i:0;a:1:{i:0;s:11:"/dataexpert";}i:2;a:3:{i:0;s:34:"/information/manage/searchrole/add";i:1;s:30:"/information/manage/searchrole";i:2;s:23:"/admin/config/appsearch";}}s:9:"developer";a:1:{i:6;a:1:{i:0;s:18:"/dbexpert/imexport";}}}";s:9:"aclobject";s:340:"a:3:{s:10:"accounting";a:1:{s:13:"defaultbranch";s:0:"";}s:18:"appreportoperation";a:4:{i:9;a:1:{i:0;s:3:"Yes";}i:10;a:1:{i:0;s:3:"Yes";}i:23;a:1:{i:0;s:3:"Yes";}i:24;a:1:{i:0;s:3:"Yes";}}s:16:"inventoryaclopts";a:3:{s:33:"invenotry_maskduringshadowenabled";s:2:"No";s:18:"invenotry_terminal";s:0:"";s:15:"itemrestriction";s:8:"disabled";}}";s:11:"description";s:0:"";s:8:"resetsid";s:0:"";s:13:"lastresettime";s:1:"0";}}');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
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
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
-- query
INSERT INTO {_prefix_}pages VALUES ('1','0','About appRain Content Management Framework','','','aboutus','About Us','<p>appRain is one of the first, officially-released, open source Content Management Frameworks (CMF). CMF is a new, web engineering concept where a Content Management System (CMS) and a rapid development framework perform side-by-side to produce endless varieties of output in a very limited time.</p>

<p>appRain is developed on a daily basis, drawing on extensive project experience. A common problem that we all face in a framework is that we need to re-develop some common modules in each project. With Content Management Systems, we sometimes get stuck driving our development based on strict development conventions the system enforces. Why is there no CMS integrated with a framework? This is the question that gave birth to appRain.</p>

<p>Content Management Systems and frameworks are very popular in web development. These two technologies work in different ways. One is used for rapid development, the other for more customized output. appRain merges these two technologies. appRain is fast, flexible, and makes it easy to complete tasks in a very short time period. It can be expanded and scaled.</p>

<p>The tools in the CMS component of appRain are all configurable, making development faster. It helps to avoid repeating tasks. The framework component is used when it becomes too difficult to complete your requirements using the CMS tools. The framework contains all of the core programming tools.</p>

<p>appRain aims to make creating web technology simplified and easlily optimized.</p>
','sitemenu','','Yes','text','Content','9');
-- query
INSERT INTO {_prefix_}pages VALUES ('2','0','InformationSet and CategorySet','InformationSet and CategorySet','InformationSet and CategorySet','informationset-categoryset','InformationSet and CategorySet','<p>InformationSet and CategorySet are prominent methods work with database. This to special tool keep you hassle free to manage database table. It create interface automatically for data import, control by auto validation also interact with database to fetch data without writing. &nbsp;These two methods time of development significantly.</p>

<p>An InformationSet manage a single database table. All database fields defined separately with addition parameter like</p>

<ol>
	<li>Database attributes</li>
	<li>Data Input type (text box, text area, file input etc.)</li>
	<li>Define the validation during data input</li>
	<li>Render interface in admin panel for Add, Modify and View.</li>
</ol>

<p>InformationSet can adjust field modification when a definition change or add. In that case, necessary permission is required for the database user. For Oracle Database, InformationSet creates created a sequence automatically to manage the auto increment value for Primary Key.<br />
<br />
InformationSet can be linked with other InformationSet or CategorySet for joining, also, it created link input tag like Drop Down, Check Box in the interface.<br />
<br />
CategorySet works similar to InformationSet but it specially works to manage recursive Parent Child relation. Generally it uses to categorize any InformationSet. &nbsp;</p>

<p>A rich library of functions has been developed to interact with database to server necessary purpose.</p>
','quicklinks','','Yes','smart_h_link','Content','5');
-- query
INSERT INTO {_prefix_}pages VALUES ('3','0','Theme Development','Theme Development','Theme Development','theme-development','Theme Development','<p>Theme development is one of the common requirements during a new website development. appRain has a theme gallery to select theme. Gallery is available in below location:</p>

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
INSERT INTO {_prefix_}pages VALUES ('4','0','General Help Center','General Help Center','General Help Center','general-help-center','General Help Center','<p>Read appRain manual online, this is a HTML based manual for User, Developer and learners. We always encourage sending your valuable feedback.</p>

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
INSERT INTO {_prefix_}pages VALUES ('5','0','','','','home-page-summary','','<?php 
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
INSERT INTO {_prefix_}pages VALUES ('6','0','Terms of Use: appRain Content Management Framework','Terms, Condition, Copy Right','','terms-of-use','Terms of Use','<p>Copyright (c) appRain CMF (http://www.apprain.com)<br />
<br />
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the &quot;Software&quot;), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:<br />
<br />
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.<br />
<br />
THE SOFTWARE IS PROVIDED &quot;AS IS&quot;, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.</p>
','sitemenu,template_footer_menu','','Yes','h_link','Content','7');
-- query
INSERT INTO {_prefix_}pages VALUES ('7','0','','','','samplephp','','<?php
    $pages= array(''quick-start'',''page-manager'');
    
    foreach($pageList as $name){
        pr(App::Module(''Page''));
    }
?>','','','Yes','h_link','Snip','0');
-- query
INSERT INTO {_prefix_}pages VALUES ('8','0','appRain:  Content  Management Framework is a combination of Content Management System and Rapid Development Framework','Content Management System, PHP Framework, PHP Content Management System, PHP CMS, Web Development Tool, Project Development Tool','A PHP Content Management Framework combining  CMS(Content Management System) and Framework (Rapid Development Framework) to enable fast Web Developmen','home-page','What is appRain  Content Management Framework?','<hr />
<h2>What is appRain&nbsp; Content Management Framework?</h2>

<p>appRain is one of the first officially released Opensource Content Management Framework (CMF). CMF is a new web engineering concept where &quot;CMS (Content Management System)&quot; and &quot;Framework&quot; perform together to produce endless varieties of output in a very limited time.</p>

<p>appRain, published with lots of extensive features to reduce our development work time. It satisfies both Client and Developers with a safe and quality output.</p>
','home_content_area_A','','Yes','text','Content','0');
-- query
INSERT INTO {_prefix_}pages VALUES ('9','0','Page Manager','','','page-manager','Page Manager','<p><strong>Page Manger</strong> is a frequently used module to create new pages in the website. You will get it in first Tab after login Admin Panel.</p>

<p>Use link page section to assign your page in different place in the website. You will get different selected section to assign the page in Menu, Quick Links. You can select multiple hooks by holding CTRL key and Mouse left Click.</p>

<p>The presentation of the page can be text or hyper link. You can select the option from drop down beneath the hook list. Text option will place the page content in a particular area of a page. Hyper link can be two type, one is Smart Link which generates a page with optimized URL. Other one is a direct link of the page.</p>

<p>A large text box is available to renter a page in a User Defile Hook defined in the theme, each hook name must be comma separated.</p>

<p>It is really important to present the page well formatted. Use common field section to set Page Title and other Meta information.</p>

<p>Sort Order, is helpful to manage the order of the page in website menu and quick links.</p>

<p>Dynamic pages are great features in Page Manager to write Server Side Coding. All resource should be access through App factory. Because, this factory will bring all your resource available in the script. To work in dynamic page you need little ideal of <a href="http://docs.apprain.com/index.html?chapter_2.htm">internal structure</a> of appRain. One important tips, Dynamic page render only under static page. Click on &quot;Page Code List&quot; button and the list will popup. Also, a static page can be rendered in side other static page. Just paste the Page Code inside the content.</p>

<p>For developers, there is a detailed module to execute all operations. This module helps to work with Pages in MVC model. Moreover, it has different hooks to register Page Manager in Component in different events.</p>
','quicklinks','','Yes','smart_h_link','Content','2');
-- query
INSERT INTO {_prefix_}pages VALUES ('10','0','Quick Start','Quick Start','Quick Start','quick-start','Quick Start','<p>appRain has multidimensional approach to serve a purpose in web based software development. Specifically, Use as Content Management System or utilized the framework layer only.</p>

<p>For a quick start, CMS would be a great area to choose.</p>

<p>appRain has an attractive Admin panel, you must login there first. Go the page manager to has a look around and add some content in the website. You can put the content of a page in different location in website by User Hook. If you wish, can see all location by enabling the flag &ldquo;Show Hook Positions&rdquo; in Preference &gt; Configuration<br />
If you love to write some PHP, you can create dynamic pages. A dynamic page can render under a static page only.</p>

<p>Next, you might need a Blog or Contact Us page, may be other features for your site. Just install component! It will enable addition functionality. Go in Application tab to add new components.</p>

<p>appRain has a wide range of configurable parameters. You can setup some of them from Preference.</p>

<p>Now, for an expert developer, It is easy to start your development by creating new Components. It will keep your code separate, plug-able and distributable. Any core resource can inherit by related hook. Also, development can be done from &ldquo;development&rdquo; folder, especially theme. It&rsquo;s advisable to use UI Hook to make the theme more accessible by external plug-ins.</p>

<p>Database! Never be tired by redundant work. Use InformationSet and CategorySet. appRain takes care of interface development, validation also auto made your query.</p>

<p>Further more, you are open for extensive development with different type of databases and Web Service layer.</p>
','sitemenu','','Yes','smart_h_link','Content','1');
-- query
INSERT INTO {_prefix_}pages VALUES ('11','0','Concept of Development','Concept of Development','Concept of Development','concept-of-development','Concept of Development','<p>appRain is a robust platform for development which optimized the effort and time.</p>

<p>First setup appRain, then start development with all interface based tool like Page Manager, Theme etc.&nbsp; This is a very preliminary stage of you start up.</p>

<p>After that, find components that fit for you and install it. This will save lots of you time.</p>

<p>On next level appRain always advice to avoid making your hand dirty with lots of hard coding and database query management. Just configure some XML and..</p>

<ul>
	<li>Use InformationSet, CategorySet to develop interface quickly for data management</li>
	<li>Create different type of setting for your project by &ldquo;Site Settings&rdquo;</li>
	<li>Create menu and render interface in admin panel by &ldquo;Interface Builder&rdquo;</li>
	<li>Mange website routing</li>
	<li>Work with language</li>
	<li>Integrate external plug-ins</li>
	<li>Web Service</li>
</ul>

<p>By doing configuration we can cover a large part of your project.</p>

<p>Now start to work with MVC pattern to meet up any expectation. Configure one or multiple database to work with simultaneously.<br />
This is highly recommended, develop new components for a specify requirements. Each component will enrich your personal archive because it is in-stable. A component uses any core resource by using hook. Moreover, It can be keep away from main system by&nbsp;&nbsp; deactivating by a simple click.</p>

<p>However, appRain has both ready-made and un-stitched tool, we just have to use it as per need.</p>
','quicklinks','','Yes','smart_h_link','Content','4');
-- query
INSERT INTO {_prefix_}pages VALUES ('12','0','Component Installation','Component Installation','Component Installation','component-installation','Component Installation','<p>Component is a pluggable module, the main logic of it to connect to core system with different hook and add new features. Let&rsquo;s say you want a blog in your website. Just download the component from the archive and install.</p>

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
) ENGINE=MyISAM AUTO_INCREMENT=220 DEFAULT CHARSET=utf8;
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('1','0','theme','business','0','hidden');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('2','0','site_logo','','','themesettings');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('3','0','default_pagination','50','19','general');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('4','0','time_zone','Asia/Dhaka','23','general');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('5','0','copy_right_text','Copyright @ appRain','','general');
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
INSERT INTO {_prefix_}sconfigs VALUES ('18','0','site_homepage_layout','left_column','','themesettings');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('19','0','site_pageview_layout','right_column','','themesettings');
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
INSERT INTO {_prefix_}sconfigs VALUES ('40','0','emailsetup_enabled','Yes','','opts');
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
INSERT INTO {_prefix_}sconfigs VALUES ('186','0','adminpanel_quick_launch','{"/page/manage-static-pages":{"title":"Manage Pages","iconpath":"/themeroot/admin/images/icons/info.jpg","mylink":"/page/manage-static-pages","fetchtype":"URL"},"/admin/managegroup":{"title":"Manage Group","iconpath":"/themeroot/admin/images/icons/info.jpg","mylink":"/admin/managegroup","fetchtype":"URL"},"/admin/manage":{"title":"Manage Users","iconpath":"/themeroot/admin/images/icons/info.jpg","mylink":"/admin/manage","fetchtype":"URL"}}','','');
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
