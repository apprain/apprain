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
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
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
INSERT INTO {_prefix_}coreresources VALUES ('12','homepress','Component','0.1.0','Active','a:1:{s:11:"installdate";s:19:"2023-04-20 00:45:42";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('13','pagemanager','Component','1.2.6','Active','a:1:{s:11:"installdate";s:19:"2021-07-26 22:18:13";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('14','adminpanelquicklaunch','Component','1.0.1','Active','a:1:{s:11:"installdate";s:19:"2023-04-15 20:55:05";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('15','dbexpert','Component','0.1.2','Active','a:1:{s:11:"installdate";s:19:"2021-07-26 22:51:31";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('16','ethical','Component','2.1.1','Active','a:1:{s:11:"installdate";s:19:"2021-07-26 23:06:08";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('17','appreport','Component','2.1.1','Active','a:1:{s:11:"installdate";s:19:"2023-04-19 23:42:39";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('18','Appreportcode','Model','0.1.0','Active','');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('19','messenger','Component','2.0.0','Inactive','a:1:{s:11:"installdate";s:19:"2023-04-19 23:41:49";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('20','Message','Model','0.1.0','Active','');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('21','Notification','Model','0.1.0','Active','');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('22','contactus','Component','0.1.1','Inactive','a:1:{s:11:"installdate";s:19:"2023-04-20 01:25:39";}');
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
INSERT INTO {_prefix_}emailtemplate VALUES ('7','1','2012-08-22 15:59:32','2023-04-19 23:41:18','ContactUs','One message sent  by {FirstName}{LastName}','Following message sen by {FirstName}{LastName}

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
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
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;
-- query
INSERT INTO {_prefix_}pages VALUES ('1','0','About appRain Content Management Framework','','','aboutus','About Us','<div>
<p>appRain is one of the first officially released open-source content management frameworks (CMF). CMF is a new, web engineering concept where a content management system (CMS) and a rapid development framework perform side-by-side to produce endless varieties of output in a very limited time.</p>

<p>appRain is developed on a daily basis, drawing on extensive project experience. A common problem that we all face in a framework is that we need to re-develop some common modules in each project. With content management systems, we sometimes get stuck driving our development based on the strict conventions the system enforces. Why is there no CMS integrated with a framework? This is the question that gave birth to appRain.</p>

<p>Content management systems and frameworks are very popular in web development. These two technologies work in different ways. One is used for rapid development, the other for more customized output. appRain merges these two technologies. appRain is fast, flexible, and makes it easy to complete tasks in a very short time period. It can be expanded and scaled.</p>

<p>The tools in the CMS component of appRain are all configurable, making development faster. It helps to avoid repeating tasks. The framework component is used when it becomes too difficult to complete your requirements using the CMS tools. The framework contains all of the core programming tools.</p>

<p>appRain aims to make creating web technology simple and easily optimized.</p>
</div>
','sitemenu','','Yes','text','Content','9');
-- query
INSERT INTO {_prefix_}pages VALUES ('2','0','InformationSet and CategorySet','InformationSet and CategorySet','InformationSet and CategorySet','informationset-categoryset','InformationSet and CategorySet','<div>
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
INSERT INTO {_prefix_}pages VALUES ('3','0','Theme Development','Theme Development','Theme Development','theme-development','Theme Development','<p>When developing websites, working with themes is a typical task. It could be the website&#39;s front end or the admin area. Let&#39;s take a look at how to create a front-end theme.</p>

<p>All themes are created inside the view folder of the development folder. Create a directory in the location below if the theme&#39;s name is Rainy Day.</p>

<p><code>development/view/rainyday</code></p>

<p>There are a few fundamental folders that must be created in the view folder; let&#39;s go over each one individually.</p>

<p><strong>Definition:</strong></p>

<p>Definition is a required folder that stores a theme&#39;s core resources. First of all, the <em>info.xml</em>. It contains basic boot files and developer&#39;s information.When you open a file from an existing theme, you may find the XML with the nodes listed below.</p>

<p>{{name=UI type=staticpage name=theme-info-xml-field-information-dp autoformat=off}}</p>

<p>The logo serves as the theme&#39;s thumbnail in the theme gallery. The name of the logo should match the info.xml definition.</p>

<p><em>register.php</em> is the class file defined in info XML. As per Apprain convention, the <a href="http://docs.apprain.org/index.html?definition.htm">class name</a> comes with the path of the file. The class contains the basic callback function listed below</p>

<p><code>before_theme_load($Send=null)<br />
after_theme_load($Send=null)<br />
before_theme_install($Send=null)<br />
after_theme_installed($Send=null)<br />
on_theme_removed($Send=null) </code></p>

<p>Before the theme loads, we frequently change the layout based on what the page is showing. For an illustration, see the sample below.</p>

<pre>
if(App::Config()-&gt;isPageView()){
  $Send-&gt;layout = App::Config()-&gt;Setting(&#39;site_pageview_layout&#39;,&#39;right_column_layout&#39;);
}
</pre>

<p>The <em>themesettings.xml </em>file contains any settings that a theme could require from the user. The field that a user must edit in order to change the theme might be specified. The settings can be accessed via the admin panel from <em>Preferences &gt; Theme &gt; Settings.</em></p>

<p><strong>Layout</strong></p>

<p>Through layout, we define the basic page structure; all are the.phtml files stored in the layout folder, and the system loads default.phtml by default; however, when a different layout is needed, we can set it like $send-&gt;layout = &#39;simple&#39; from the register callback method.</p>

<p>Below are some important points to be noted</p>

<p><em><code>$this-&gt;callElement(&quot;header_info&quot;)</code> </em>:<br />
This is to call an element from the elements folder that sets the header of the HTML documents.</p>

<p><code><em>$this-&gt;fetchAddonlibs();</em></code><br />
Load all client-side addons generally based on HTML, Javascript, and CSS</p>

<p><code><em>$this-&gt;callElement(&quot;header&quot;), $this-&gt;callElement(&quot;footer&quot;)</em></code><br />
It is advised to keep the header and footer in these two elements that eventually help to edit from the admin panel.</p>

<p><code><em>$content_rendered</em></code><br />
This variable contains the output of the page view that we have defined in the controller function as per the conventions of MVC. So when we browse different web pages, the content changes and is placed in the layout. more, as you can see in the <a href="http://docs.apprain.org/layout.htm">documentation</a>.</p>

<p><strong>Elements:</strong><br />
Elements are split-view files that can be included into other pages as needed. The <a href="http://docs.apprain.org/elements.htm">method for rendering an element&#39;s</a> content is shown below.</p>

<p><code>$this-&gt;callElement([Element Name])</code> for example <code>echo $this-&gt;callElement(&quot;quicklinks&quot;)</code></p>

<p><strong>Home, Page</strong><br />
These are two folders created for Home and Page Controller in the development folder as a standard. All the files inside are templates for Action Method.</p>

<p>index.html in the home folder is the default page, as it&#39;s defined in Router (boot_router.xml). On the other hand, view.phtml in the pages folder is to display content from the Page Manger in the admin panel.</p>

<p>More pages can be created in the development area or from a component that loads as per the browsed webpage address following the <a href="http://docs.apprain.org/action_template.htm">convention of the MVC pattern</a></p>

<p><strong>UI Hook</strong></p>

<p>UI Hooks are placeholders to render content from external modules like Component, Page Manager, and so on. A theme contains basic UI hooks defined in info.xml by the theme developer. Then the end user can easily place content on a webpage from the Page Manager in the admin panel.</p>

<p>As these hooks cannot be seen without going into code, the end user can go to Preferences &gt; Configuration and set the parameter Show Hook Positions to &quot;Yes&quot; to view the positions in the front end to select where to put the content. See the instance below; more illustrations can be <a href="http://docs.apprain.org/ui_hooks.htm">found in the documentation</a>.</p>

<p><code>App::Hook(&#39;UI&#39;)-&gt;Render([Hook Name]); </code>for example <code>App::Hook(&#39;UI&#39;)-&gt;Render(&#39;quick_links_top&#39;);</code></p>

<p>External Resouces</p>

<p>For most of the theme, we need to store CSS, JavaScript, and other theme files and access them from the development area. Generally, we store those files in the themeroot folder in webroot; for example, see below location</p>

<p><code>webroot/themeroot/rainyday</code></p>

<p>Note: Generally, we save a default.css file in a CSS folder that we can modify from the admin panel in the theme area.</p>

<p>To retrieve resources from the theme folder that is presently active, use the skinUrl function. See examples below.</p>

<p><code>echo App::Config()-&gt;skinUrl(&quot;/css/default.css&quot;);<br />
echo App::Config()-&gt;skinUrl(&quot;/images/banner.jpg&quot;);</code></p>

<p>One more function that will help you is to load resources uploaded by file manager using filemanagerUrl. See below example:</p>

<p><code>echo App::Config()-&gt;fileManagerUrl(&quot;/logo.png&quot;);</code></p>

<p>You can read a lot about theme development in the <a href="http://docs.apprain.org/theme.htm">manual</a>.</p>
','quicklinks','','Yes','smart_h_link','Content','6');
-- query
INSERT INTO {_prefix_}pages VALUES ('4','0','General Help Center','General Help Center','General Help Center','general-help-center','General Help Center','<p>appRain has a detailed manual to read online or download. We always encourage sending your valuable feedback to info@apprain.com</p>

<p><a href="http://docs.apprain.org">Online Manual</a></p>

<p>CHM is the standard help format for a windows desktop application. The output is a single file with extension *.chm.</p>

<p><a href="http://www.apprain.org/help/chm">Download</a></p>

<p>Adobe Portable Document Format (PDF) is a platform independent file format. This is ideal for Device and Print.</p>

<p><a href="http://www.apprain.org/help/pdf">Download</a></p>

<p>This type is a cross-platform e-book standard created by the IDPF, which is supported by Apple iBooks, Andriod Tablets/smartphones and many other e-readers on windows, Mac OSX, iOS and Linux.</p>

<p><a href="http://www.apprain.org/help/epub">Download</a></p>

<p>This format is an ideal to illustrate web-based application, to publish documentation to the internet, intranet or CD-ROM</p>

<p><a href="http://www.apprain.org/help/html">Download</a></p>

<p>Windows e-books are stand-alone Windows executable with HTML formatted texts and images. This output format is great for CD-ROM presentations.</p>

<p><a href="http://www.apprain.org/help/ebook">Download</a></p>
','quicklinks','','Yes','smart_h_link','Content','8');
-- query
INSERT INTO {_prefix_}pages VALUES ('12','0','Quick Links Top','','','quick-links-top','Quick Links Top','{{name=UI type=staticpage name=quick-links-top-dp autoformat=off}}
','quick_links_top','','Yes','text','Content','0');
-- query
INSERT INTO {_prefix_}pages VALUES ('13','0','','','','quick-links-top-dp','','<div class="p-4 mb-3 bg-light rounded">
	<h4 class="fst-italic">Apprain <?php echo App::__Def()->sysConfig(''APPRAINVERSION''); ?></h4>
	<p class="mb-0">
	    Version <?php echo App::__Def()->sysConfig(''APPRAINVERSION''); ?> has come up with many fixes with the new version of PHP.This release includes two components: ethincal and messenger, which play a significant role in development.
	</p>
</div>','','','Yes','h_link','Snip','0');
-- query
INSERT INTO {_prefix_}pages VALUES ('6','0','Terms of Use: appRain Content Management Framework','Terms, Condition, Copy Right','','terms-of-use','Terms of Use','<p>Copyright (c) appRain CMF (http://www.apprain.com)<br />
<br />
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the &quot;Software&quot;), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:<br />
<br />
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.<br />
<br />
THE SOFTWARE IS PROVIDED &quot;AS IS&quot;, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.</p>
','quicklinks','','Yes','smart_h_link','Content','7');
-- query
INSERT INTO {_prefix_}pages VALUES ('41','0','','','','whitecloud_slide','','<section id="myCarousel" class="carousel slide" data-bs-ride="carousel">
	<div class="carousel-indicators">
	  <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
	  <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
	  <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
	</div>
	<div class="carousel-inner">
	  <div class="carousel-item active">
		<svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false">
			<rect width="100%" height="100%" fill="#666"/>
		</svg>
		<div class="container">
		  <div class="carousel-caption text-start">
			<h1 class="display-5 fw-bold">Apprain 4.0.5</h1>
			
			 <p>
				Are you ready to write some XML tags? It''s pretty simple, right? XML-based coding will enable significant advancements in appRain. 
				You can create an admin panel interface, configure software, work with databases, and many other things.
			 </p>
			 <p>
			 appRain is the best fit for your enterprise projects with less effort.</p><hr />
			<p><a class="btn btn-lg btn-primary" href="<?php echo App::Config()->baseUrl("/concept-of-development");?>">Concept of development.</a></p>
		  </div>
		</div>
	  </div>
	  <div class="carousel-item">
		<svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#444"/></svg>
		<div class="container">
		  <div class="carousel-caption text-start">
			<h1 class="display-5 fw-bold">CMS + Framework</h1>
			<p>Website or enterprise project, plan it first properly to make the development faster and more convenient. First, use the built-in tools available in CMS. Secondly, use the configureable tools in Framework, and then go for coding for customized development in MVC.</p>
			<p>appRain enables the maximum amount of customized development through its standard libraries. </p>
			<hr />
			<p><a class="btn btn-lg btn-primary" href="#">Quick Start</a></p>
		  </div>
		</div>
	  </div>
	  <div class="carousel-item">
		<svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false">
			<rect width="100%" height="100%" fill="#555"/>
		</svg>
		<div class="container">
		  <div class="carousel-caption text-start">
			<h1 class="display-5 fw-bold">API Service</h1>
			<p>Convert your work into APIs; it''s very easy. The application can be securely integrated with any other system on any platform.</p>
			<p>Ethical is a security plugin in-built with version 4.0.5 that also works as an API layer. Install the component, create a service helper, and that''s all it takes to make the method callable from other systems through user authentication and a secure token. </p>
			<p><a class="btn btn-lg btn-primary" href="#">Ethical Component</a></p>
		  </div>
		</div>
	  </div>
	  
	</div>
	<button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
	  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
	  <span class="visually-hidden">Previous</span>
	</button>
	<button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
	  <span class="carousel-control-next-icon" aria-hidden="true"></span>
	  <span class="visually-hidden">Next</span>
	</button>
</section>','','','Yes','h_link','Snip','0');
-- query
INSERT INTO {_prefix_}pages VALUES ('8','0','appRain:  Content  Management Framework is a combination of Content Management System and Rapid Development Framework','Content Management System, PHP Framework, PHP Content Management System, PHP CMS, Web Development Tool, Project Development Tool','A PHP Content Management Framework combining  CMS(Content Management System) and Framework (Rapid Development Framework) to enable fast Web Developmen','home-page','What is appRain  Content Management Framework?','<hr />
<h2>What is appRain&nbsp; Content Management Framework?</h2>

<p>appRain is one of the first officially released Opensource Content Management Framework (CMF). CMF is a new web engineering concept where &quot;CMS (Content Management System)&quot; and &quot;Framework&quot; perform together to produce endless varieties of output in a very limited time.</p>

<p>appRain, published with lots of extensive features to reduce our development work time. It satisfies both Client and Developers with a safe and quality output.</p>
','','','Yes','text','Content','0');
-- query
INSERT INTO {_prefix_}pages VALUES ('9','0','Page Manager','','','page-manager','Page Manager','<p>Page Manager is a frequently used module to create new pages on the website. You will find it in the first tab after logging into the Admin Panel.</p>

<p>Use the link page section to assign your page to different places on the website. You will get a selected section to assign the page in the menu under Quick Links. Holding the CTRL key and clicking with the left mouse button selects multiple hooks.</p>

<p>You can select the option from the drop-down beneath the hook list. The Text option will place the page content in a particular area of a page. Hyperlinks can be of two types; one is Smart Link, which generates a page with an optimized URL. The other is a direct link to the page.</p>

<p>A large text box is available to renter a page in a User Defile Hook defined in the theme; each hook name must be comma separated.</p>

<p>It is really important to format the page well. Use the common field section to set the page title and other meta information.</p>

<p>The Sort Order field is helpful to manage the order of the page in the website menu and quick links.</p>

<p>Dynamic pages are great features in Page Manager for writing server-side code from the interface. All resources should be accessible through App Factory. Because this factory will make all your resources available in the script, To work in a dynamic page, you should be familiar with the system&#39;s internal coding structure. One important tip: dynamic pages render only under static pages. Click on the &quot;Page Code List&quot; button, and the list will pop up. Also, a static page can be rendered alongside another static page. Just paste the page code inside the content.</p>

<p>For developers, there is a detailed module to execute all operations. This module helps to work with pages in the MVC model. Moreover, it has different hooks to register Page Manager in a component in different events.</p>
','quicklinks','','Yes','smart_h_link','Content','2');
-- query
INSERT INTO {_prefix_}pages VALUES ('10','0','Quick Start','Quick Start','Quick Start','quick-start','Quick Start','<p>How a project&#39;s development starts basically depends on the demands of the requirements, but typically it is either front end of the website or in the admin panel.</p>

<p>First, log in to the admin panel (see the link in the footer) and go to &quot;<em>Preferences &gt; Admin Settings</em>,&quot; where you can change basic information. Moreover, check all the other menus under &quot;Preferences&quot; to explore other options. Among them, theme is one of the options that helps to change the installed themes.</p>

<p><u>Note:</u> Two basic themes have been released as samples with the installation of version 4.0.5. These themes have been given as a sample, but other themes may vary depending on the theme developer. How to develop a theme has been described in the <a href="{baseurl}/theme-development">Theme Development Section</a>.</p>

<p><strong>Customize website content</strong></p>

<p>Login to the admin panel and activate the theme &quot;White Cloud&quot; from the below location</p>

<p><em>Preferences &gt; Theme.</em></p>

<p>We can use Page Manager to modify the content of the website. Go to the below location to modify website page content.</p>

<p><em>Page Manager &gt; Static Pages &gt; Manage Pages</em></p>

<p>For this theme, Page Manager will help modify the HTML content as well. Go to the dynamic pages section to modify the content from the below location.</p>

<p><em>Page Manager &gt; Dynamic Pages &gt; Manage Pages</em></p>

<p>White Cloud is a special theme that saves all HTML content to the database and allows modification from the admin panel. However, because HTML is generally saved in the file system, you should find it in the below folder. To simulate this, you can use the Rainy Day theme.</p>

<p><code>development/view/rainyday</code></p>

<p><u>Note:</u> Dynamic pages allow HTML and PHP to be executed, and it is recommended that Apprain Factory be used to access all internal resources.</p>

<p><strong>Create your first controller and page:</strong></p>

<p>Creating a controller and a page is generally the first step of a project to create a webpage and process data. More detail will be in the documentation, but we will see a simple simulation here. A controller is a class containing a set of methods; a method is called an action method when we add the word &quot;Action&quot; at the end of the function name. As a result, it gains the ability to display a page and interact with external calls. Create the below class in the &quot;<em>development/controllers</em>&quot; folder with the name <em>helloworld.php</em>.</p>

<pre>
class helloworldController extends appRain_Base_Core
{
  public $name = &#39;helloworld&#39;;
  public function mypageAction(){}
}</pre>

<p>Now create a folder called &quot;helloworld&quot; in your theme directory; for example, if the theme name is White Cloud, then the location will be</p>

<p><em>/development/view/whitecloud/</em></p>

<p>Inside the folder, create a file with the name &quot;mypage.phtml,&quot; which is basically the name of the action method, and put some content there.&nbsp;</p>

<p>Now you can browse the page with the below convention:</p>

<p><em>[domain name]/[controller name]/[action method name]</em><br />
For example <em>www.example.com/helloworld/mypage</em></p>

<p>This is a minimal example of a controller, and there are many more things to do, which can be found in the documentation.</p>

<p><strong>Page in Admin Panel:</strong></p>

<p>After creating a page to render in the admin panel with user authentication, it is widely used in enterprise projects. To render a page in admin panel simple add a tab name in action method</p>

<pre>
public function mypageAction()
{
   $this-&gt;setAdminTab(&#39;page_manager&#39;);
}</pre>

<p>Now if you browse the same page, it will be rendered in the admin panel. For further development, see the documentation.</p>

<p><strong>More Quick Points</strong></p>

<ul>
	<li>Log in to the Admin Panel, then Preferences &gt; Theme. You can edit Header, Footer and default css throught App Editor. Evaltually, you can edit files across the project.</li>
	<li>Visit the Applications page in the admin panel to install and test all of the available components. A popular tool for creating reports is called Appreport.</li>
	<li>Database Expert in the Preferences tab helps to import, export, and backup databases.</li>
	<li>Read the user <a href="http://docs.apprain.org/index.html?user_manual.htm">manual</a> for more help</li>
</ul>
','quicklinks','','Yes','smart_h_link','Content','1');
-- query
INSERT INTO {_prefix_}pages VALUES ('11','0','Concept of Development','Concept of Development','Concept of Development','concept-of-development','Concept of Development','<p>Apprain is a robust platform for development that optimizes effort and time.</p>

<p>After setting up Apprain , start development with all interface-based tools like Page Manager, Theme, etc. This is the primary stage of your start-up.</p>

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
INSERT INTO {_prefix_}pages VALUES ('48','0','','','','whitecloud_footer-content','','<div class="col-md-5 offset-md-1 mb-3">
	<h5>
		<?php 
			## Check in Language file Admin Panel > Preferances > Language > default.xml
			echo $this->__("APPRAIN");
		?>
		<?php
			## Check in System Configuration file in source code. This is an hidden field
			## definition/system_configuration/config.xml 
			echo App::__Def()->sysConfig(''APPRAINVERSION''); 
		?>
	</h5>
	<p>
		The new release focused on security and data interfacing through the Ethical Component.
	</p>
</div>','','','Yes','h_link','Snip','0');
-- query
INSERT INTO {_prefix_}pages VALUES ('50','0','','','','whitecloud_home-content-area-A','','<section>
<div class="container px-4 py-4">
	<div class="row row-cols-1 row-cols-md-2 align-items-md-center g-5 py-5">
	  <div class="col d-flex flex-column align-items-start gap-2">
		<h3 class="fw-bold">Concept of Development</h3>
		<p class="text-muted">Working with appRain is all about planning our work. Split the work into three major phases. First, use all CMS tools to execute your first line of defense. Secondly, when you need to work with databases and other customized requirements, switch to using Framework Ready tools. Finally, start coding to do your job. Keep the source code untouched in the core library so applications can be upgraded in the next release.</p>
		<p class="text-muted">appRain is well-equipped for enterprise project development, making it faster and more secure; appRain ERP is an example. All that remains is to select the appropriate tools.</p>
  </div>

	  <div class="col">
		<div class="row row-cols-1 row-cols-sm-2 g-4">
		  <div class="col d-flex flex-column gap-2">
			<h4 class="fw-semibold mb-0">&check;  Information Set</h4>		
			<p class="text-muted">Helps to work with database tables without manual intervention.</p>
		  </div>

		  <div class="col d-flex flex-column gap-2">
			<h4 class="fw-semibold mb-0">&check; Category Set</h4>
			<p class="text-muted">It aids in categorizing information for more meaningful use.</p>
		  </div>

		  <div class="col d-flex flex-column gap-2">
			<h4 class="fw-semibold mb-0">&check; Static Page</h4>
			<p class="text-muted">Use to manage your content and publish to present on your website </p>
		  </div>

		  <div class="col d-flex flex-column gap-2">
			<h4 class="fw-semibold mb-0">&check; Dynamic Page</h4>
			<p class="text-muted">Write code from the interface to prepare content for Page Manager.</p>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</section>','','','Yes','h_link','Snip','0');
-- query
INSERT INTO {_prefix_}pages VALUES ('43','0','','','','whitecloud_home-content-area-B','','<section class="background-grey">
<div class="container px-4 py-4">
	<div class="row row-cols-1 row-cols-md-2 align-items-md-center g-5 py-5">
	  <div class="col d-flex flex-column align-items-start gap-2">
		<h3 class="fw-bold">COMPONENT</h3>
		<p class="text-muted">Always try to make your work reusable. Each component works independently and is reusable, so create a component when the requirement is new. 
		Use all resources through App Factory, staying within the component folder; if needed, access other components resources or send back references using Hooks.</p>
	 </div>
	  <div class="col">
		<h3 class="fw-bold">Base Pattern</h3>
		<p class="text-muted"><code>App</code> Factory helps manage all resources in the system. It is recommended to use that to ensure compliance.</p>
		<p class="text-muted"><code>App::Module(''Hook'')</code>  is primarily used in components to register all resources and utilize them in a standalone manner.</p>
	 
	  </div>
	</div>
</div>
</section>','','','Yes','h_link','Snip','0');
-- query
INSERT INTO {_prefix_}pages VALUES ('44','0','','','','whitecloud_home-content-area-C','','<section>
<div class="container px-4 py-4">
    <div class="row  align-items-md-center g-5 py-5">
      <div class="col">
        <h3 class="fw-bold">Guide Line</h3>
        <p class="text-muted">
			Need any help? Shoot us a mail at info[at]apprain.com
		</p>
        <p>
See the Site Setting, Interface Builder, and ACL sections; those will make your development most customizable. </p>
		<p>
If multiple applications run in a single organization, then try to avoid going through multiple instances of installation. First, configure the router to merge multiple applications with database profiling and give distributed access to the end user by specifying a domain or sub-domin.		</p>
		<p>
			Always do component-based development; save your work for future use. Develop hooks for your own component and open it up for other developers to use internally.
      </div>
    </div>
  </div>
</section>','','','Yes','h_link','Snip','0');
-- query
INSERT INTO {_prefix_}pages VALUES ('45','0','','','','whitecloud_home-content-area-D','','<section>
<div class="bg-dark text-secondary px-4 text-center">
	<div class="py-5">
		<h1 class="display-5 fw-bold text-white">Apprain Community</h1>
		<div class="col-lg-6 mx-auto">
			<p class="fs-5 mb-4">
			appRain is currently hosted on two websites, which are www.apprain.org and www.apprain.com. New releases, developer materials, and all other information are available on the ORG website. The COM website, on the other hand, offers support for the appRain team''s ERP.
			The context here is that the ORG is practicing CSR with the support of COM in return enjoys all the releases from the ORG.
			</p>
			<div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
				<a href="https://www.apprain.org" target="_blank"><button type="button" class="btn btn-outline-info btn-lg px-4 me-sm-3 fw-bold">.ORG</button></a>
				<a href="https://www.apprain.com" target="_blank"><button type="button" class="btn btn-outline-light btn-lg px-4 me-sm-3 fw-bold">.COM</button></a>
			</div>
		</div>
	</div>
</div>
</section>','','','Yes','h_link','Snip','0');
-- query
INSERT INTO {_prefix_}pages VALUES ('56','0','','','','whitecloud_menu','','<ul class="navbar-nav col-lg-8 justify-content-lg-end">		  
<?php App::Hook("UI")->Render("template_header_A"); #User Interface Hook ?>
<li class="nav-item">
  <a class="nav-link" aria-current="page" href="<?php echo App::Config()->baseUrl(); ?>">Home</a>
</li>
<li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Hand Book</a>
  <ul class="dropdown-menu">
	<li><a class="dropdown-item" href="<?php echo App::Config()->baseUrl("/quick-start");?>">Quick Start</a></li>
	<li><a class="dropdown-item" href="<?php echo App::Config()->baseUrl("/page-manager");?>">Page Manager</a></li>
	<li><a class="dropdown-item" href="<?php echo App::Config()->baseUrl("/concept-of-development");?>">Concept of Development</a></li>
	<li><a class="dropdown-item" href="<?php echo App::Config()->baseUrl("/informationset-categoryset");?>">InformationSet and CategorySet</a></li>
	<li><a class="dropdown-item" href="<?php echo App::Config()->baseUrl("/theme-development");?>">Theme Development</a></li>
	<li><a class="dropdown-item" href="<?php echo App::Config()->baseUrl("/terms-of-use");?>">Terms of Use</a></li>
  </ul>
</li>
<li class="nav-item">
  <a class="nav-link" href="<?php echo App::Config()->baseUrl("/about-us");?>">About Apprain</a>
 
</li>
<li class="nav-item">
  <a class="nav-link" href="<?php echo App::Config()->baseUrl("/general-help-center");?>">Support</a>
</li>
<?php App::Hook("UI")->Render("template_header_B"); #User Interface Hook ?>
</ul>','','','Yes','h_link','Snip','0');
-- query
INSERT INTO {_prefix_}pages VALUES ('51','0','','','','theme-info-xml-field-information-dp ','','<table class="table">
	<tbody>
		<tr>
			<td>Tag Name</td>
			<td>Purpose</td>
		</tr>
		<tr>
			<td>&lt;name&gt;</td>
			<td>Name of the theme</td>
		</tr>
		<tr>
			<td>&lt;author&gt;</td>
			<td>Developers Name</td>
		</tr>
		<tr>
			<td>&lt;author_uri&gt;</td>
			<td>Website address</td>
		</tr>
		<tr>
			<td>&lt;description&gt;</td>
			<td>Summary of the theme</td>
		</tr>
		<tr>
			<td>&lt;image&gt;</td>
			<td>The logo image name is in the same folder</td>
		</tr>
		<tr>
			<td valign="top">&lt;pagemanager_hooks&gt;</td>
			<td>These are the placeholder names for rendering content created in Page Manager from the admin panel or from a component</td>
		</tr>
		<tr>
			<td valign="top">&lt;settings&gt;</td>
			<td>This is a site setting file name that contains a set of configurations that the user can change from theme settings in the admin panel</td>
		</tr>
		<tr>
			<td valign="top">&lt;components&gt;</td>
			<td>List of the components that need to be installed or uninstalled when the theme is activated from the admin panel</td>
		</tr>
		<tr>
			<td valign="top">&lt;callback&gt;</td>
			<td>Call Back is a class name that runs each time the theme loads to work with dynamic resources in the system. </td>
		</tr>		
	</tbody>
</table>','','','Yes','h_link','Snip','0');
-- query
INSERT INTO {_prefix_}pages VALUES ('58','0','','','','whitecloud_footer-menu','','<div class="col-6 col-md-2 mb-3">
	<h5>Themes</h5>
	<ul class="nav flex-column">
		<li class="nav-item mb-2"><a href="<?php echo App::Config()->baseUrl("/theme-development"); ?>" class="nav-link p-0 text-muted">Website Theme</a></li>
		<li class="nav-item mb-2"><a href="<?php echo App::Config()->baseUrl("/page-manager"); ?>" class="nav-link p-0 text-muted">Page Manager</a></li>
	</ul>
  </div>
  
  <div class="col-6 col-md-2 mb-3">
	<h5>Developers</h5>
	<ul class="nav flex-column">
	  <li class="nav-item mb-2"><a href="<?php echo App::Config()->baseUrl("/quick-start"); ?>" class="nav-link p-0 text-muted">Quick Start</a></li>
	  <li class="nav-item mb-2"><a href="<?php echo App::Config()->baseUrl("/concept-of-development"); ?>" class="nav-link p-0 text-muted">Ideas and Concepts</a></li>
	</ul>	
  </div>

  <div class="col-6 col-md-2 mb-3">
	<h5>Help</h5>
	<ul class="nav flex-column">
	  <li class="nav-item mb-2"><a href="<?php echo App::Config()->baseUrl("/admin"); ?>" class="nav-link p-0 text-muted">Admin Login</a></li>
	  <li class="nav-item mb-2"><a href="https://www.apprain.org/general-help-center" class="nav-link p-0 text-muted" target="_blamk">Documentations</a></li>
	</ul>
</div>','','','Yes','h_link','Snip','0');
-- query
INSERT INTO {_prefix_}pages VALUES ('57','0','API Development','API Development','','api-development','API Development','<p>Here, creating an API is fairly easy. It is prepared in two steps.</p>

<p><strong>Step 1:</strong><br />
Activate the Ethical component under the Applications page in the Admin Panel after logging in.</p>

<p><strong>Step 2: </strong><br />
Go to any of your components and create a helper called service. Now each function in the helper serves as an API call.</p>

<p>After the two steps, go to user management and create a user because credentials are required to create a token for the call to the API. Now let&#39;s look at a step-by-step guideline.</p>

<p><strong>Activate the Ethical Component:</strong><br />
Log in to the admin panel, go to the Applications menu, find the ethical component, and activate it if it is not already activated.</p>

<p><code>Admin Panel &gt; Applications &gt; Ethical (Activate)</code></p>

<p><u>Note:</u> The Messenger component should also be enabled so that we can replicate the API there.</p>

<p><strong>Create Api User: </strong><br />
Go to User Management and create a user to use the API service. For example, the user name is &quot;apiuser&quot; and the password is &quot;Api@24H7&quot;</p>

<p><strong>Create Service</strong><br />
Go to the following location in the messenger component&#39;s helper directory.</p>

<p><code>component/messenger/helpers</code></p>

<p>Create the file service.php and the following classes if they don&#39;t already exist.</p>

<pre>
class Component_Messenger_Helpers_Service extends appRain_Base_Objects
{
}</pre>

<p>Now let&#39;s create the function below in the service class as test service.</p>

<pre>
public function getMyPetName($data){
  $type = isset($data[&#39;type&#39;]) ? $data[&#39;type&#39;] : &#39;&#39;;
  switch($type){
    case &#39;animal&#39;:
      return array(&#39;state&#39;=&gt;&#39;100&#39;,&#39;petname&#39;=&gt;&#39;Dog&#39;);
    case &#39;bird&#39;:
      return array(&#39;state&#39;=&gt;&#39;100&#39;,&#39;petname&#39;=&gt;&#39;Cockatiel&#39;);			
    default:
      return array(&#39;state&#39;=&gt;&#39;101&#39;,&#39;petname&#39;=&gt;&#39;&#39;);
}</pre>

<p>Thats all our API server has ready; if we want to know an animal, it should return &quot;Dog&quot; and for a bird, it will return &quot;Cockatiel&quot;. In both cases, it will return the state code &quot;100&quot;. For other requests, it will return state code &quot;101&quot;. It is a sample setup, but we can do it as needed.</p>

<p><strong>API Call </strong></p>

<p>For an API call, we have two basic addresses: one for authorization and another for the final call to receive data. For example, if project address is www.example.com the authentication and data exchange addresses will be as follows:</p>

<p><code>https://www.example.com/ethical/auth<br />
https://www.example.com/ethical/exchange</code></p>

<p><em>Crate Token:</em><br />
Follow the below script to create an authentication token</p>

<pre>
$AUTH_URI = &quot;https://www.example.com/ethical/auth&quot;
$DATA_EXCHANGE_URI = &quot;https://www.example.com/ethical/exchange&quot;

$data = array(
	&quot;username&quot;=&gt;&quot;apiuser&quot;,
	&quot;password&quot;=&gt;&quot;Api@24H7&quot;
);
$response = httpPost($AUTH_URI ,$data);
$result = json_decode($response,true);

$token = $result[&#39;token&#39;];
$timestamp = $result[&#39;timestamp&#39;];</pre>

<p><em>Do API Call<strong>: </strong></em><br />
In the last step, we received a token and a time stamp that we will use to send the reques. There are specific parameters that must be sent during a call; see the list of important information below.</p>

<ol>
	<li>Component containing the service class sent in the request array at index &#39;com&#39;</li>
	<li>The service method, which we send in the &quot;action&quot; index, is the second important parameter.</li>
	<li>The token and timestamp are sent in the request received during the previous stage.</li>
	<li>Other parameters should be given as needed.</li>
</ol>

<pre>
$post = array();
$post[&#39;token&#39;] = $result[&#39;token&#39;];
$post[&#39;timestamp&#39;] = $result[&#39;timestamp&#39;];
$post[&#39;com&#39;] = &#39;Messenger&#39;;
$post[&#39;action&#39;] = &quot;getMyPetName&quot;;
$post[&#39;type&#39;] = &quot;animal&quot;;

$response = httpPost($DATA_EXCHANGE_URI ,$post);
$result = json_decode($response,true);
print_r($result)</pre>

<p>Return value</p>

<pre>
Array
(
    [state] =&gt; 100
    [petname] =&gt; Dog
    [token] =&gt; ezEyMzQ1Njc4OTAxMjoyOjE2ODE5MjM3NjJ9
    [timestamp] =&gt; 1681923762
    [status] =&gt; 1
)</pre>

<p>Now see the full script with the additional calls</p>

<pre>
$AUTH_URI = "https://www.example.com/ethical/auth";
$DATA_EXCHANGE_URI = "https://www.example.com/ethical/exchange";

## Step 1: Create the token
$data = array(
	"username"=>"apiuser",
	"password"=>"Api@24H7"
);
$response = httpPost($AUTH_URI ,$data);
$result = json_decode($response,true);

$token = $result[''token''];
$timestamp = $result[''timestamp''];

## Step 2: 
# Call 1
$post = array();
$post[''token''] = $result[''token''];
$post[''timestamp''] = $result[''timestamp''];
$post[''com''] = ''Messenger'';
$post[''action''] = "getMyPetName";
$post[''type''] = "animal";

$response = httpPost($DATA_EXCHANGE_URI ,$post);
$result = json_decode($response,true);
print_r($result);

# Call 2
$post = array();
$post[''token''] = $result[''token''];
$post[''timestamp''] = $result[''timestamp''];
$post[''com''] = ''Messenger'';
$post[''action''] = "getMyPetName";
$post[''type''] = "bird";

$response = httpPost($DATA_EXCHANGE_URI ,$post);
$result = json_decode($response,true);
print_r($result);

# Call 3
$post = array();
$post[''token''] = $result[''token''];
$post[''timestamp''] = $result[''timestamp''];
$post[''com''] = ''Messenger'';
$post[''action''] = "getMyPetName";
$post[''type''] = "other";

$response = httpPost($DATA_EXCHANGE_URI ,$post);
$result = json_decode($response,true);
print_r($result);


## Submit request
function httpPost($url, $data)
{
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($curl);
  curl_close($curl); 
  return $response;
}</pre>
','','','Yes','smart_h_link','Content','0');
-- query
INSERT INTO {_prefix_}pages VALUES ('59','0','Contact Us','','','contact-us','Contact Us','<p>
	Duis arcu elit, rutrum a interdum quis, vulputate et diam. Mauris eleifend cursus tortor. Sed ut leo quis nisi vehicula sagittis. Maecenas sed nisl at quam vulputate mattis in nec sapien. Etiam vel massa in eros sodales bibendum. Vestibulum ut urna cursus lectus sodales facilisis vel vitae sem. Aenean a nisl ut nulla ullamcorper tristique non quis sem.<br />
	<br />
	<strong>Vestibulum at orci a velit varius</strong><br />
	45/B consectetur quis sit amet<br />
	diam. <br />
	phasellus@eget felis.purus.</p>
','','','Yes','h_link','Content','0');
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
) ENGINE=MyISAM AUTO_INCREMENT=224 DEFAULT CHARSET=utf8;
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('1','0','theme','whitecloud','0','hidden');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('2','0','site_logo','','','themesettings');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('3','0','default_pagination','50','19','general');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('4','0','time_zone','Asia/Dhaka','23','general');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('5','0','copy_right_text','Copyright Apprain Technologies, www.apprain.org.','','general');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('6','0','site_title','Start with Apprain','','');
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
INSERT INTO {_prefix_}sconfigs VALUES ('19','0','site_pageview_layout','right_column_layout','','themesettings');
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
INSERT INTO {_prefix_}sconfigs VALUES ('186','0','adminpanel_quick_launch','{"\/admin\/manage":{"title":"Manage Users","iconpath":"\/themeroot\/admin\/images\/icons\/info.jpg","mylink":"\/admin\/manage","fetchtype":"URL"},"\/appreport\/executor":{"title":"Reports","iconpath":"\/component\/appreport\/interface_builder\/icon.jpg","mylink":"\/appreport\/executor","fetchtype":"FilePath"},"\/page\/manage-static-pages":{"title":"Static Page","iconpath":"\/themeroot\/admin\/images\/icons\/info.jpg","mylink":"\/page\/manage-static-pages","fetchtype":"URL"},"\/page\/manage-dynamic-pages":{"title":"Dynamic Page","iconpath":"\/themeroot\/admin\/images\/icons\/info.jpg","mylink":"\/page\/manage-dynamic-pages","fetchtype":"URL"}}','','');
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
