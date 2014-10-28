-- query
DROP TABLE IF EXISTS {_prefix_}administrators;
-- query
CREATE TABLE `{_prefix_}administrators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
-- query
INSERT INTO {_prefix_}appslide VALUES ('1', '1', '2012-08-18 10:08:56', '2012-12-11 22:37:52', 'Start Typing', 'responsive-design.png', '<h1>
	Start Typing your first text</h1>
<p>
	First login to the admin panel and go following location to edit&nbsp; first post.</p>
<pre> Components &gt; App Slide &gt; Manage Slides 
</pre>
<p>
	Let, people know about you with few words here and drive them inside for more information.</p>
<p>
	Just for your information, appSlide is a 3rd Party component, and lots other available in appRain archive for your use. Let us know if you need any further assistance.</p>
', 'Active');
-- query
INSERT INTO {_prefix_}appslide VALUES ('2', '1', '2012-08-18 10:08:56', '2012-12-11 22:39:04', 'Look & Feel', 'look-and-feel.png', '<h1>
	Customize look and feel...</h1>
<p>
	Change setting to have a quick customization in look and feel</p>
<pre> Preference &gt; Theme &gt; Settings
</pre>
<p>
	The HTML structure has been controlled by CSS grid framework; also the components DOM followed by same architecture to automatically adjust with existing template.</p>
<p>
	You can install more theme from appRain gallery also see update in website and make website look and feel more customizable.</p>
', 'Active');
-- query
INSERT INTO {_prefix_}appslide VALUES ('3', '1', '2012-08-18 10:08:56', '2012-12-11 22:48:56', 'Comfortable', 'comfortable.png', '<h1>
	Meet requirements...</h1>
<p>
	Application center fills your extended need by installing new components and Addons. Installation of new features is very simple, just check available components in bellow locations and click to activate :</p>
<pre> Admin Panel &gt; Applications</pre>
<p>
	You can check new updates from website and also from your admin panel and install third party components by using auto installer.</p>
<p>
	System will notify about new resale to keep up to date.</p>
', 'Active');
-- query
INSERT INTO {_prefix_}appslide VALUES ('4', '1', '2012-08-18 10:08:56', '2012-12-15 12:55:36', 'Step Up', 'browsers.png', '<h1>
	It is open to Step-up...</h1>
<p>
	It is always open to develop your system in large scale and align it with new trend. Develop your own components, Addons, Theme and implement custom business logic to step up your output.</p>
<pre>Read <a href="http://www.apprain.com/manual">manual</a> for further help</pre>
<p>
	appRain is segmented in different part and easy enhanceable.</p>
<p>
	CMS part like auto Data Process Interface Generator, Installer, CategorySet and other tools helps faster development.</p>
', 'Active');
-- query
INSERT INTO {_prefix_}appslide VALUES ('5', '1', '2012-08-18 10:08:56', '2012-12-11 22:35:39', 'Breath Easy', 'help.png', '<h1>
	We here to help you...</h1>
<p>
	Keep in touch to share your issue and keep yourself relax, appRain team always encourage you to create ticket and discuss your concern.</p>
<pre>Please create a <a href="http://www.apprain.com/ticket">ticket</a> to communicate with core developers. </pre>
<p>
	Stay up to date by installing new release or by updating existing system by new patch. Ensure smooth operations with help of videos and documentations. Join our groups and blogs for further sharing.</p>
<p>
	We always welcome to advice us your valuable thoughts.</p>
', 'Active');
-- query
DROP TABLE IF EXISTS {_prefix_}blogcomments;
-- query
CREATE TABLE `{_prefix_}blogcomments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `website` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `dated` datetime NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
-- query
INSERT INTO {_prefix_}blogcomments VALUES ('1', '2', '0', 'Jhon Regan', 'jhon@example.com', 'http://www.example.com', 'Where can I see list of all Page Codes?', '2012-12-13 10:56:44', 'Active');
-- query
INSERT INTO {_prefix_}blogcomments VALUES ('2', '2', '0', 'Paul Lakeman', 'paul@example.com', 'http://www.example.com', 'You can see the list of page code in Static Page update area. On right side of Place Holder list box. 
<pre>See a link "Snip and Page Code list"</pre>', '2012-12-13 11:00:15', 'Active');
-- query
INSERT INTO {_prefix_}blogcomments VALUES ('3', '1', '0', 'Ripon Jong', 'riponj@example.com', 'http://www.example.com', 'Thanks,
For sharing the process flow. It''s helpful. ', '2012-12-18 22:03:31', 'Active');
-- query
DROP TABLE IF EXISTS {_prefix_}blogpost;
-- query
CREATE TABLE `{_prefix_}blogpost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminref` int(11) NOT NULL,
  `entrydate` datetime NOT NULL DEFAULT '2012-12-12 22:23:41',
  `lastmodified` datetime NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` enum('Public','Private') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
-- query
INSERT INTO {_prefix_}blogpost VALUES ('1', '1', '2012-12-12 22:23:41', '2012-12-14 00:13:02', 'How to install Application', '2', '<p>
	Application is one of the easiest solutions to incorporate new features. We can install new or existing applications from bellow location in admin panel:</p>
<pre>Login Admin Panel -&gt; Applications
</pre>
<p>
	Application List by default load components. A component has three common links Status, Help and Remove.</p>
<p>
	Click on Activate link to enable a component. Help link shows common help text define by developer. Remove helps to delete a component with source code.</p>
<h2>
	Install new component:</h2>
<p>
	New component can install from admin panel or manually. Click on &quot;Install New Component&quot; button to install a component by using auto installer. Browse component source in .zip format and click &quot;Install&quot; button.</p>
<p>
	Enter FTP information so system can assign proper right in folders and copy file easily.</p>
<p>
	By default all component sources save in &quot;component&quot; directory also some component required file to copy in &quot;webroot&quot;. We can also manually copy file in related folders to install a component.</p>
<h2>
	Check Online Component:</h2>
<p>
	On top of component list window there is a button &quot;Get Component&quot;. Click on that to see available component list. Also you can search a component directly from admin panel.</p>
<h2>
	Install Addons:</h2>
<p>
	We have interface to view Addons status in latest appRain versions from 3.0.1 and onward. See the list in following location:</p>
<pre>Admin Panel &gt; Preferences(Drop Down) -&gt; Addons </pre>
<p>
	We can Activate/Deactivate, Change Loading method, select Layout for each addons.</p>
<p>
	To install an addons first click on &quot;Install Addon&quot; button then a new pan will appear. Browse addon source file and click &quot;Install&quot;.</p>
<p>
	Also addon can install by copping file manually in following location:</p>
<pre>development/definition/addons  // create definition file
webroot/addons // Copy resources </pre>', 'Public');
-- query
INSERT INTO {_prefix_}blogpost VALUES ('2', '1', '2012-12-12 22:23:41', '2012-12-13 23:59:32', 'Work with Page and UI Hooks ', '1', '<p>
	Page manager is one of the best tool to organize content to create page and place post in different place of the website with help of UI HOOKS. You will find it in admin panel first menu.</p>
<p>
	There are two type of pages &quot;Static Page&quot; and &quot;Snip&quot;.</p>
<h3>
	Static Page</h3>
<p>
	Static page always works with general content like Text, Image etc. We can place a page in menu, footer and side bar or inside a page. There is a list of &quot;Place holder&quot;, you can select one or more to render the content.</p>
<p>
	Manu always render page link and other place holder can display Text or Link both as per selection among &quot;Smart Link&quot;, &quot;Link&quot; or &quot;Text&quot;.</p>
<p>
	A place holder can exists in different part of the page defined by theme creator. You can see all hidden Place Holder by changing bellow setting:</p>
<pre>Admin Panel &gt; Preferences &gt; Configurations  &gt;  Show Hook Positions</pre>
<h3>
	Snip:</h3>
<p>
	Snip always works with PHP code. You can write Server Side PHP code and render it. Snip can access any core or user define library by using app factory.</p>
<p>
	Due to security reason snip only render with help of Static page.</p>
<h3>
	Render page inside page:</h3>
<p>
	A page or snip has an unique identification called &quot;Page Code&quot;. Content can render by copping page code inside Static Page.</p>
', 'Public');
-- query
DROP TABLE IF EXISTS {_prefix_}categories;
-- query
CREATE TABLE `{_prefix_}categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkey` int(11) NOT NULL DEFAULT '0',
  `adminref` int(11) NOT NULL DEFAULT '0',
  `parentid` int(11) NOT NULL DEFAULT '0',
  `image` varchar(200) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `generic` varchar(250) NOT NULL,
  `entrydate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastmodified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
-- query
INSERT INTO {_prefix_}categories VALUES ('1', '0', '1', '0', '', 'Page Manager', '', 'blog-cat', '', '2012-12-13 10:47:18', '2012-12-13 10:47:18');
-- query
INSERT INTO {_prefix_}categories VALUES ('2', '0', '1', '0', '', 'Applications', '', 'blog-cat', '11', '2012-12-13 10:08:41', '2012-12-13 10:08:41');
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
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
-- query
INSERT INTO {_prefix_}coreresources VALUES ('1', 'Admin', 'Model', '0.1.0', 'Active', '');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('2', 'Category', 'Model', '0.1.0', 'Active', '');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('3', 'Config', 'Model', '0.1.0', 'Active', '');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('4', 'Coreresource', 'Model', '0.1.0', 'Active', '');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('5', 'Developer', 'Model', '0.1.0', 'Active', '');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('6', 'Home', 'Model', '0.1.0', 'Active', '');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('7', 'Information', 'Model', '0.1.0', 'Active', '');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('8', 'Log', 'Model', '0.1.0', 'Active', '');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('9', 'Page', 'Model', '0.1.0', 'Active', '');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('10', 'appslide', 'Component', '0.1.0', 'Active', 'a:1:{s:11:"installdate";s:19:"2012-12-12 01:04:03";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('11', 'homepress', 'Component', '0.1.0', 'Active', 'a:1:{s:11:"installdate";s:19:"2012-12-12 01:04:12";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('12', 'contactus', 'Component', '0.1.0', 'Active', 'a:1:{s:11:"installdate";s:19:"2012-12-12 01:04:34";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('13', 'blog', 'Component', '0.2.0', 'Active', 'a:1:{s:11:"installdate";s:19:"2012-12-12 22:18:27";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('14', 'Blogcomment', 'Model', '0.1.0', 'Active', '');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('15', 'appeditor', 'Component', '0.1.0', 'Active', 'a:1:{s:11:"installdate";s:19:"2013-11-28 23:40:55";}');
-- query
DROP TABLE IF EXISTS {_prefix_}emailtemplate;
-- query
CREATE TABLE `{_prefix_}emailtemplate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminref` int(11) NOT NULL,
  `entrydate` datetime NOT NULL DEFAULT '2012-08-22 15:59:32',
  `lastmodified` datetime NOT NULL,
  `templatetype` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
-- query
INSERT INTO {_prefix_}emailtemplate VALUES ('1', '1', '2012-08-22 15:59:32', '2012-11-30 15:56:29', 'ContactUs', 'One message sent  by {FirstName}{LastName}', 'Following message sen by {FirstName}{LastName}

{Message}

<hr />

Subject:  {Subject}

Sender Email:  {Email}

<a href="{baseurl}">View Website</a> <a href="{baseurl}/admin">View Admin</a>');
-- query
INSERT INTO {_prefix_}emailtemplate VALUES ('2', '1', '2012-08-22 15:59:32', '2012-12-20 03:34:58', 'Admin2AdminContact', '{AdminFirstName}{AdminLastName} sent you a message', 'Dear Concern,
Following message sent by {AdminFirstName}{AdminLastName}

{Message}');
-- query
DROP TABLE IF EXISTS {_prefix_}homepress;
-- query
CREATE TABLE `{_prefix_}homepress` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminref` int(11) NOT NULL,
  `entrydate` datetime NOT NULL DEFAULT '2012-09-08 23:44:12',
  `lastmodified` datetime NOT NULL,
  `shortdesc` text NOT NULL,
  `linkedto` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
-- query
INSERT INTO {_prefix_}homepress VALUES ('1', '1', '2012-09-08 23:44:12', '2012-12-13 11:57:35', 'A brief about appRain Content Management Framework.', '1', 'Active', 'What is appRain?', 'what-is-appRain.jpg');
-- query
INSERT INTO {_prefix_}homepress VALUES ('2', '1', '2012-09-08 23:44:12', '2012-12-14 23:04:55', 'Get expected output with less effort and short time.', '5', 'Active', 'Efficient Output', 'efficient-output.jpg');
-- query
INSERT INTO {_prefix_}homepress VALUES ('3', '1', '2012-09-08 23:44:12', '2012-12-18 21:44:48', 'Have a quick reference of common resource regarding development.', '7', 'Active', 'System Performance', 'performance.jpg');
-- query
INSERT INTO {_prefix_}homepress VALUES ('4', '1', '2012-09-08 23:44:12', '2012-12-18 21:47:42', 'Install theme and update it form user interface in admin panel. ', '2', 'Active', 'Terms of Use', 'important.jpg');
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- query
DROP TABLE IF EXISTS {_prefix_}pages;
-- query
CREATE TABLE `{_prefix_}pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkey` int(11) NOT NULL DEFAULT '0',
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `fkey` (`fkey`,`name`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
-- query
INSERT INTO {_prefix_}pages VALUES ('1', '0', 'About appRain:  PHP Content  Management Framework | Content Management System | ', 'About Content Management System, PHP Framework, PHP Content Management System, PHP CMS, Web Development Tool, Project Development Tool', 'A PHP Content Management Framework is Combination of CMS(Content Management System) and Framework (Rapid Development Framework) the best Agile Web Dev', 'aboutus', 'About Us', '<p>
	appRain is one of the first officially released Open Source Content Management Framework (CMF). CMF is a new web engineering concept where &quot;CMS (Content Management System)&quot; and Rapid Development Framework perform side by side to produce endless varieties of output in a very limited time.<br />
	<br />
	It&#39;s&nbsp;is developed&nbsp;on a daily basis&nbsp;drawing on extensive&nbsp; project experience . A common problem that we all face in framework is that&nbsp;we need to redevelop some common modules in each project. In CMS sometimes we get&nbsp;stuck&nbsp;driving our development due to strict development&nbsp;conventions. So&nbsp;the a common question is,&nbsp;why there is no CMS integrated with Framework? It was actually this first concept&nbsp;that gave&nbsp;birth to the&nbsp;appRain development. It is&nbsp;now published with many extensive features to reduce development work time&nbsp;and give a&nbsp;high quality output.<br />
	<br />
	CMS and Framework are very popular and staple terms in web development. These two tools work in two different ways. One we use for rapid development and another one for more customizable output. AppRain is&nbsp;a merging&nbsp;of these two web development&nbsp;technologies. It is extremely&nbsp;fast, flexible&nbsp;and makes it&nbsp;easy to complete tasks in a very short time period. It is&nbsp;also expandable and scaleable.<br />
	<br />
	&nbsp;The CMS part in appRain contains all configurable tools so that we&nbsp;will make the development faster. It helps to avoid repeating tasks. The&nbsp;Framework Part is used when it become difficult to complete the requirements with CMS tools. It contains all core programming tools so that we can move the development as&nbsp;and when we&nbsp;need it.<br />
	&nbsp;<br />
	&nbsp;The&nbsp;initiative is&nbsp;to make web technology&nbsp;simplified and&nbsp;easlily optimized.</p>
', 'sitemenu,quicklinks', '', 'Yes', 'smart_h_link', 'Content');
-- query
INSERT INTO {_prefix_}pages VALUES ('2', '0', 'Terms of Use: appRain Content Management Framework', 'Terms, Condition, Copy Right', '', 'terms-of-use', 'Terms of Use', '<p>
	Copyright (c) appRain CMF (http://www.apprain.com)<br />
	<br />
	Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the &quot;Software&quot;), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:<br />
	<br />
	The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.<br />
	<br />
	THE SOFTWARE IS PROVIDED &quot;AS IS&quot;, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.</p>
', 'quicklinks,template_footer_B', '', 'Yes', 'smart_h_link', 'Content');
-- query
INSERT INTO {_prefix_}pages VALUES ('3', '0', '', '', '', 'samplephp', '', '<?php
/**
* Write PHP Code
*
* Example:
* $Config = App::Config()->siteInfo();
* pre($Config);
*/
?>

<?php echo App::Helper(''Date'')->getDate(''Y-m-d H:i:s'');?>', '', '', 'Yes', 'h_link', 'Snip');
-- query
INSERT INTO {_prefix_}pages VALUES ('4', '0', 'Contact Us any time for any help', 'Contact, Help, Manual, Documentation ', 'Contact us for any help', 'contact-us', 'Contact Us', '<h2>
	appRain</h2>
<p>
	appRain is one of the first officially released Open Source Content Management Framework (CMF). CMF is a new web engineering concept where &quot;CMS (Content Management System)&quot; and Rapid Development Framework perform side by side to produce endless varieties of output in a very limited time.</p>
<p>
	<strong>appRain Content Management Framework</strong><br />
	info@apprain.com<br />
	www.apprain.com.</p>
', '', '', 'Yes', 'h_link', 'Content');
-- query
INSERT INTO {_prefix_}pages VALUES ('5', '0', 'Component: Access unlimited features in appRain Content Management Framework ', 'Blog, Store, Forum, Gallery, News, Videos ', 'Add more features in website by a single click ', 'efficient-output', 'Result Driven', '<p>
	Result driven development always focused in two major issues, which are "Time Saving" and  "Flexible Development". A perfect system should have strength to cover all customer  requirements within the time line.</p>
<p>
	appRain always recommend to analyze the requirements and select correct method to complete it. A task can be done in so many ways but efficient output depends on the way of completion.  </p>
<p>
	For example, if there is a request to  work with news publisher then the task can be done by any one of bellow ideas</p>
<ul>
	<li>
		A. Display a news post in home page</li>
	<li>
		B. News section to update regular basis</li>
	<li>
		C. A newspaper website.</li>
</ul>
<p>
	For point A we can do it simply by Static Page manager and UI Hook. Point B should be done with support of SNIP or create a simple component and for point C we should do a  full scale develop by creating new Theme and Component.</p>
<p>
	appRain is segmented in lots of parts, based on work and user level. It is open for a layman to expert people with it''s extensive features. No one will feel alone with it and can produce result driven output.</p>
', 'quicklinks,template_footer_B', '', 'No', 'smart_h_link', 'Content');
-- query
INSERT INTO {_prefix_}pages VALUES ('6', '0', 'appRain:  Content  Management Framework is a combination of Content Management System and Rapid Development Framework', 'Content Management System, PHP Framework, PHP Content Management System, PHP CMS, Web Development Tool, Project Development Tool', 'A PHP Content Management Framework combining  CMS(Content Management System) and Framework (Rapid Development Framework) to enable fast Web Developmen', 'home-page', 'What is appRain  Content Management Framework?', '<p>
	appRain is one of the first officially released Opensource Content Management Framework (CMF). CMF is a new web engineering concept where &quot;CMS (Content Management System)&quot; and &quot;Framework&quot; perform together to produce endless varieties of output in a very limited time.</p>
<p>
	appRain, published with lots of extensive features to reduce our development work time. It satisfies both Client and Developers with a safe and quality output.</p>
', '', '', 'Yes', 'smart_h_link', 'Content');
-- query
INSERT INTO {_prefix_}pages VALUES ('7', '0', 'Resources : appRain optimized the resources usages ', 'MVC, Components, Modules, Page Manager, Helper, Plugin, Auto Load, Web service, JavaScript,  ', 'appRain optimized and utilize resource usages ', 'resources', 'Resources', '<p>
	appRain resources have been organized base on all standard patterns. Each entity always comes in operation through a channel named App Factory. The factory always ensures the security and performance of the object.</p>
<p>
	Resource access point has several phases based on the depth of requirements. A large volume of library has been developed in core of the system for End Users. Modification of that core library is prohibited because new framework update can overwrite it. End user can extends those sources to perform additional operation easily.</p>
<p>
	Except core library, there are lots of ready-made tools available for end users as well for developers. Some of those tools are Interface based so that user can access with little technical knowledge. Components, Add-ons, Themes, Page Manager, Site Settings, Code Editor and lots of other methods which are very easy to use. A user just has to play around those functionalists to get desire output.</p>
<p>
	Component is a vast way for multipurpose implementation. It can be a small module like Blog or a complete website.</p>
<p>
	Lots of complex process has been generalized in appRain. Information Set is one of them. A programmer does not need to create database table and write code to develop data process form. It automatically renders in admin panel and does necessary data process with proper input box and validation process.</p>
<p>
	appRain facilitate most of the development tools like Category Manager, Configuration Manager, Admin Panel Manager, URI Manager, Cache Management, Web Service, Ftp Service, MVC, Hooks, Call back, Plugin, Add-ons, Multi-Store, Multi-Database, EDP, Ajax Helper, Validation Management and others.</p>
<p>
	The most convenient way of development is component. All possible development can be done with component because it can hook in core system and perform as mirror of main. But the facility what come is easy migration of code in other project. You can just copy the component code or zip the source and install from admin panel. Then the full development will be the part of the new system.</p>
', 'quicklinks,template_footer_B', '', 'Yes', 'smart_h_link', 'Content');
-- query
INSERT INTO {_prefix_}pages VALUES ('8', '0', 'Blog: appRain blog is a portable application', 'Blog, Component, Application', '', 'blog', 'Blog', '', '', '', 'Yes', 'h_link', 'Content');
-- query
DROP TABLE IF EXISTS {_prefix_}sconfigs;
-- query
CREATE TABLE `{_prefix_}sconfigs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkey` int(11) NOT NULL DEFAULT '0',
  `soption` text NOT NULL,
  `svalue` text NOT NULL,
  `sort_order` varchar(5) NOT NULL,
  `section` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('1', '0', 'theme', 'rainbow', '0', 'hidden');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('2', '0', 'site_logo', 'logo.jpg', '', 'themesettings');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('3', '0', 'default_pagination', '15', '19', 'general');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('4', '0', 'time_zone', 'Asia/Dhaka', '23', 'general');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('20', '0', 'copy_right_text', 'Copy Right [year] [website]', '', 'general');