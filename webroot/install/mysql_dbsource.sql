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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
-- query
INSERT INTO {_prefix_}appslide VALUES ('1', '1', '2015-06-18 12:25:11', '2016-06-15 17:08:08', 'appRain CMS', 'CMS.png', '<h1>appRain CMS</h1>

<p>appRain helps you to develop web based software with effortless try. Install it by simple wizard and add necessary plug-in to meet up self or client demand. Use this part of appRain to start your development without high level technical knowledge.</p>

<h3>Make development 100% faster</h3>
', 'Active');
-- query
INSERT INTO {_prefix_}appslide VALUES ('2', '1', '2015-06-18 12:25:11', '2016-06-15 17:07:59', 'appRain Framework', 'Framework.png', '<h1>appRain Framework</h1>

<p>appRain Framework is open for you, this is simply a large platform to make your work robust. Environment is organized with latest programming patterns and easy to extend in any edge of reusable development to make you well-built.</p>

<h3>For robast development</h3>
', 'Active');
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
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
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
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
INSERT INTO {_prefix_}coreresources VALUES ('10', 'appeditor', 'Component', '0.1.7', 'Active', 'a:1:{s:11:"installdate";s:19:"2015-07-14 15:02:02";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('11', 'appslide', 'Component', '0.1.0', 'Active', 'a:1:{s:11:"installdate";s:19:"2016-06-22 15:24:06";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('12', 'dbexpert', 'Component', '0.1.2', 'Active', 'a:1:{s:11:"installdate";s:19:"2015-07-14 15:02:07";}');
-- query
INSERT INTO {_prefix_}coreresources VALUES ('13', 'homepress', 'Component', '0.1.0', 'Active', 'a:1:{s:11:"installdate";s:19:"2016-05-04 19:12:36";}');
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
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
INSERT INTO {_prefix_}homepress VALUES ('1', '1', '2016-05-04 19:12:42', '2016-06-15 17:07:29', 'Page Manager', 'InkPot.jpg', '', '2', 'Active', 'template_left_column_A');
-- query
INSERT INTO {_prefix_}homepress VALUES ('2', '1', '2016-05-04 19:12:42', '2016-06-28 16:14:31', 'appRain Background', 'About.jpg', '<p>appRain aims to make creating web technology simplified and easily optimized.It makes live easily dynamic.</p>
', '9', 'Active', 'home_content_area_D');
-- query
INSERT INTO {_prefix_}homepress VALUES ('3', '1', '2016-05-04 19:12:42', '2016-06-28 16:16:08', 'Concept of Development', 'Concept.jpg', '<p>appRain has both ready-made and un-stitched tool, we just have to use it as per need following the conversions</p>
', '4', 'Active', 'home_content_area_D');
-- query
INSERT INTO {_prefix_}homepress VALUES ('4', '1', '2016-05-04 19:12:42', '2016-06-28 16:17:34', 'General Help Center', 'Help.jpg', '<p>Manuals are ready online for User, Developer and learners. Also, you can download or print as you need</p>
', '8', 'Active', 'home_content_area_D');
-- query
INSERT INTO {_prefix_}homepress VALUES ('5', '1', '2016-05-04 19:12:42', '2016-06-15 17:06:57', 'Every chance', 'Theme.jpg', '', '6', 'Active', 'template_left_column_A');
-- query
INSERT INTO {_prefix_}homepress VALUES ('6', '1', '2016-05-04 19:12:42', '2016-06-15 17:06:49', 'Offer', 'Engin.jpg', '', '9', 'Active', 'template_left_column_A');
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
  `sort_order` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fkey` (`fkey`,`name`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
-- query
INSERT INTO {_prefix_}pages VALUES ('1', '0', 'About appRain Content Management Framework', '', '', 'aboutus', 'About Us', '<p>appRain is one of the first, officially-released, open source Content Management Frameworks (CMF). CMF is a new, web engineering concept where a Content Management System (CMS) and a rapid development framework perform side-by-side to produce endless varieties of output in a very limited time.</p>

<p>appRain is developed on a daily basis, drawing on extensive project experience. A common problem that we all face in a framework is that we need to re-develop some common modules in each project. With Content Management Systems, we sometimes get stuck driving our development based on strict development conventions the system enforces. Why is there no CMS integrated with a framework? This is the question that gave birth to appRain.</p>

<p>Content Management Systems and frameworks are very popular in web development. These two technologies work in different ways. One is used for rapid development, the other for more customized output. appRain merges these two technologies. appRain is fast, flexible, and makes it easy to complete tasks in a very short time period. It can be expanded and scaled.</p>

<p>The tools in the CMS component of appRain are all configurable, making development faster. It helps to avoid repeating tasks. The framework component is used when it becomes too difficult to complete your requirements using the CMS tools. The framework contains all of the core programming tools.</p>

<p>appRain aims to make creating web technology simplified and easlily optimized.</p>
', 'sitemenu', '', 'Yes', 'text', 'Content', '9');
-- query
INSERT INTO {_prefix_}pages VALUES ('2', '0', 'InformationSet and CategorySet', 'InformationSet and CategorySet', 'InformationSet and CategorySet', 'informationset-categoryset', 'InformationSet and CategorySet', '<p>InformationSet and CategorySet are prominent methods work with database. This to special tool keep you hassle free to manage database table. It create interface automatically for data import, control by auto validation also interact with database to fetch data without writing. &nbsp;These two methods time of development significantly.</p>

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
', 'quicklinks', '', 'Yes', 'smart_h_link', 'Content', '5');
-- query
INSERT INTO {_prefix_}pages VALUES ('3', '0', 'Theme Development', 'Theme Development', 'Theme Development', 'theme-development', 'Theme Development', '<p>Theme development is one of the common requirements during a new website development. appRain has a theme gallery to select theme. Gallery is available in below location:</p>

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
', 'quicklinks', '', 'Yes', 'smart_h_link', 'Content', '6');
-- query
INSERT INTO {_prefix_}pages VALUES ('4', '0', 'General Help Center', 'General Help Center', 'General Help Center', 'general-help-center', 'General Help Center', '<p>Read appRain manual online, this is a HTML based manual for User, Developer and learners. We always encourage sending your valuable feedback.</p>

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
', 'quicklinks', '', 'Yes', 'smart_h_link', 'Content', '8');
-- query
INSERT INTO {_prefix_}pages VALUES ('5', '0', '', '', '', 'home-page-summary', '', '<?php 
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
    endforeach; ?>    ', '', '', 'Yes', 'h_link', 'Snip', '0');
-- query
INSERT INTO {_prefix_}pages VALUES ('6', '0', 'Terms of Use: appRain Content Management Framework', 'Terms, Condition, Copy Right', '', 'terms-of-use', 'Terms of Use', '<p>Copyright (c) appRain CMF (http://www.apprain.com)<br />
<br />
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the &quot;Software&quot;), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:<br />
<br />
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.<br />
<br />
THE SOFTWARE IS PROVIDED &quot;AS IS&quot;, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.</p>
', 'sitemenu,template_footer_menu', '', 'Yes', 'h_link', 'Content', '7');
-- query
INSERT INTO {_prefix_}pages VALUES ('7', '0', '', '', '', 'samplephp', '', '<?php
    $pages= array(''quick-start'',''page-manager'');
    
    foreach($pageList as $name){
        pr(App::Module(''Page''));
    }
?>', '', '', 'Yes', 'h_link', 'Snip', '0');
-- query
INSERT INTO {_prefix_}pages VALUES ('8', '0', 'appRain:  Content  Management Framework is a combination of Content Management System and Rapid Development Framework', 'Content Management System, PHP Framework, PHP Content Management System, PHP CMS, Web Development Tool, Project Development Tool', 'A PHP Content Management Framework combining  CMS(Content Management System) and Framework (Rapid Development Framework) to enable fast Web Developmen', 'home-page', 'What is appRain  Content Management Framework?', '<hr />
<h2>What is appRain&nbsp; Content Management Framework?</h2>

<p>appRain is one of the first officially released Opensource Content Management Framework (CMF). CMF is a new web engineering concept where &quot;CMS (Content Management System)&quot; and &quot;Framework&quot; perform together to produce endless varieties of output in a very limited time.</p>

<p>appRain, published with lots of extensive features to reduce our development work time. It satisfies both Client and Developers with a safe and quality output.</p>
', 'home_content_area_A', '', 'Yes', 'text', 'Content', '0');
-- query
INSERT INTO {_prefix_}pages VALUES ('9', '0', 'Page Manager', '', '', 'page-manager', 'Page Manager', '<p><strong>Page Manger</strong> is a frequently used module to create new pages in the website. You will get it in first Tab after login Admin Panel.</p>

<p>Use link page section to assign your page in different place in the website. You will get different selected section to assign the page in Menu, Quick Links. You can select multiple hooks by holding CTRL key and Mouse left Click.</p>

<p>The presentation of the page can be text or hyper link. You can select the option from drop down beneath the hook list. Text option will place the page content in a particular area of a page. Hyper link can be two type, one is Smart Link which generates a page with optimized URL. Other one is a direct link of the page.</p>

<p>A large text box is available to renter a page in a User Defile Hook defined in the theme, each hook name must be comma separated.</p>

<p>It is really important to present the page well formatted. Use common field section to set Page Title and other Meta information.</p>

<p>Sort Order, is helpful to manage the order of the page in website menu and quick links.</p>

<p>Dynamic pages are great features in Page Manager to write Server Side Coding. All resource should be access through App factory. Because, this factory will bring all your resource available in the script. To work in dynamic page you need little ideal of <a href="http://docs.apprain.com/index.html?chapter_2.htm">internal structure</a> of appRain. One important tips, Dynamic page render only under static page. Click on &quot;Page Code List&quot; button and the list will popup. Also, a static page can be rendered in side other static page. Just paste the Page Code inside the content.</p>

<p>For developers, there is a detailed module to execute all operations. This module helps to work with Pages in MVC model. Moreover, it has different hooks to register Page Manager in Component in different events.</p>
', 'quicklinks', '', 'Yes', 'smart_h_link', 'Content', '2');
-- query
INSERT INTO {_prefix_}pages VALUES ('10', '0', 'Quick Start', 'Quick Start', 'Quick Start', 'quick-start', 'Quick Start', '<p>appRain has multidimensional approach to serve a purpose in web based software development. Specifically, Use as Content Management System or utilized the framework layer only.</p>

<p>For a quick start, CMS would be a great area to choose.</p>

<p>appRain has an attractive Admin panel, you must login there first. Go the page manager to has a look around and add some content in the website. You can put the content of a page in different location in website by User Hook. If you wish, can see all location by enabling the flag &ldquo;Show Hook Positions&rdquo; in Preference &gt; Configuration<br />
If you love to write some PHP, you can create dynamic pages. A dynamic page can render under a static page only.</p>

<p>Next, you might need a Blog or Contact Us page, may be other features for your site. Just install component! It will enable addition functionality. Go in Application tab to add new components.</p>

<p>appRain has a wide range of configurable parameters. You can setup some of them from Preference.</p>

<p>Now, for an expert developer, It is easy to start your development by creating new Components. It will keep your code separate, plug-able and distributable. Any core resource can inherit by related hook. Also, development can be done from &ldquo;development&rdquo; folder, especially theme. It&rsquo;s advisable to use UI Hook to make the theme more accessible by external plug-ins.</p>

<p>Database! Never be tired by redundant work. Use InformationSet and CategorySet. appRain takes care of interface development, validation also auto made your query.</p>

<p>Further more, you are open for extensive development with different type of databases and Web Service layer.</p>
', 'sitemenu', '', 'Yes', 'smart_h_link', 'Content', '1');
-- query
INSERT INTO {_prefix_}pages VALUES ('11', '0', 'Concept of Development', 'Concept of Development', 'Concept of Development', 'concept-of-development', 'Concept of Development', '<p>appRain is a robust platform for development which optimized the effort and time.</p>

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
', 'quicklinks', '', 'Yes', 'smart_h_link', 'Content', '4');
-- query
INSERT INTO {_prefix_}pages VALUES ('12', '0', 'Component Installation', 'Component Installation', 'Component Installation', 'component-installation', 'Component Installation', '<p>Component is a pluggable module, the main logic of it to connect to core system with different hook and add new features. Let&rsquo;s say you want a blog in your website. Just download the component from the archive and install.</p>

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
', 'quicklinks', '', 'Yes', 'smart_h_link', 'Content', '3');
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
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('1', '0', 'theme', 'bootstrap', '0', 'hidden');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('2', '0', 'site_logo', 'logo.jpg', '', 'themesettings');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('3', '0', 'default_pagination', '15', '19', 'general');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('4', '0', 'time_zone', 'Asia/Dhaka', '23', 'general');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('5', '0', 'copy_right_text', 'Copy Right [year] [website]', '', 'general');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('6', '0', 'site_title', 'Start with appRain', '', '');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('7', '0', 'admin_title', 'Start with appRain Admin', '', '');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('8', '0', 'admin_email', 'info@site.com', '', '');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('9', '0', 'activity_widget', 'No', '', '');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('10', '0', 'leave_amessage_widget', 'No', '', '');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('11', '0', 'disable_quick_links', 'No', '', 'themesettings');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('12', '0', 'whitecloud_disable_footer', 'No', '', 'themesettings');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('13', '0', 'whitecloud_background_position', 'bgstartfromtop', '', 'themesettings');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('15', '0', 'appslidesettings_displaymode', 'ajaxbased', '', 'appslidesettings');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('30', '0', 'homepresssettings_title', 'Quick Links', '', 'homepresssettings');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('16', '0', 'homepresssettings_displaymode', 'TextWithImage', '', 'homepresssettings');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('17', '0', 'homepresssettings_box_per_row', '3', '', 'homepresssettings');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('18', '0', 'site_homepage_layout', 'left_column', '', 'themesettings');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('19', '0', 'site_pageview_layout', 'right_column', '', 'themesettings');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('20', '0', 'site_defaultview_layout', 'default', '', 'themesettings');
-- query
INSERT INTO {_prefix_}sconfigs VALUES ('21', '0', 'flash_file_uploader', 'Yes', '', '');
