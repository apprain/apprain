-- query
DROP TABLE {_prefix_}ADMINISTRATORS
-- query
CREATE TABLE {_prefix_}ADMINISTRATORS
(
  ID             NUMBER,
  F_NAME         VARCHAR2(100 BYTE),
  L_NAME         VARCHAR2(100 BYTE),
  USERNAME       VARCHAR2(50 BYTE),
  PASSWORD       VARCHAR2(100 BYTE),
  EMAIL          VARCHAR2(100 BYTE),
  CREATEDATE     VARCHAR2(40 BYTE),
  LATESTLOGIN    NUMBER,
  LASTLOGIN      NUMBER,
  STATUS         VARCHAR2(30 BYTE),
  TYPE           VARCHAR2(30 BYTE)              DEFAULT 'Normal',
  ACL            VARCHAR2(2000 BYTE),
  ACLOBJECT      VARCHAR2(2000 BYTE),
  DESCRIPTION    VARCHAR2(200 BYTE),
  RESETSID       VARCHAR2(200 BYTE),
  LASTRESETTIME  NUMBER
)
-- query
DROP TABLE {_prefix_}APPSLIDE
-- query
CREATE TABLE {_prefix_}APPSLIDE
(
  ID            NUMBER(11)                      NOT NULL,
  ADMINID       NUMBER(11),
  ENTRYDATE     VARCHAR2(50 BYTE),
  LASTMODIFIED  VARCHAR2(50 BYTE),
  TITLE         VARCHAR2(255 BYTE),
  IMAGE         VARCHAR2(255 BYTE),
  DESCRIPTION   VARCHAR2(2000 BYTE),
  STATUS        VARCHAR2(50 BYTE)
)
-- query
DROP TABLE {_prefix_}CATEGORIES
-- query
CREATE TABLE {_prefix_}CATEGORIES
(
  ID            NUMBER                          NOT NULL,
  FKEY          NUMBER,
  ADMINREF      NUMBER,
  PARENTID      NUMBER,
  IMAGE         VARCHAR2(300 BYTE),
  TITLE         VARCHAR2(300 BYTE),
  DESCRIPTION   VARCHAR2(500 BYTE),
  TYPE          VARCHAR2(300 BYTE),
  GENERIC       VARCHAR2(300 BYTE),
  ENTRYDATE     DATE,
  LASTMODIFIED  DATE
);
-- query
DROP TABLE {_prefix_}CORERESOURCES
-- query
CREATE TABLE {_prefix_}CORERESOURCES
(
  ID       NUMBER                               NOT NULL,
  NAME     VARCHAR2(300 BYTE),
  TYPE     VARCHAR2(50 BYTE),
  VERSION  VARCHAR2(200 BYTE),
  STATUS   VARCHAR2(30 BYTE),
  INFO     VARCHAR2(4000 BYTE)
)
-- query
DROP TABLE {_prefix_}EMAILTEMPLATE
-- query
CREATE TABLE {_prefix_}EMAILTEMPLATE
(
  ID            NUMBER(11)                      NOT NULL,
  ADMINREF      NUMBER(11)                      NOT NULL,
  ENTRYDATE     VARCHAR2(50 BYTE),
  LASTMODIFIED  VARCHAR2(50 BYTE),
  MESSAGE       VARCHAR2(2000 BYTE),
  TEMPLATETYPE  VARCHAR2(100 BYTE),
  SUBJECT       VARCHAR2(200 BYTE)
)
-- query
DROP TABLE {_prefix_}LOG
-- query
CREATE TABLE {_prefix_}LOG
(
  ID        NUMBER,
  FKEY      NUMBER,
  TYPE      VARCHAR2(50 BYTE),
  DATED     VARCHAR2(50 BYTE),
  DATA      VARCHAR2(3000 BYTE),
  DONOTLOG  VARCHAR2(10 BYTE)
)
-- query
DROP TABLE {_prefix_}PAGES
-- query
CREATE TABLE {_prefix_}PAGES
(
  ID                NUMBER                      NOT NULL,
  FKEY              NUMBER,
  PAGE_TITLE        VARCHAR2(300 BYTE),
  META_KEYWORDS     VARCHAR2(300 BYTE),
  META_DESCRIPTION  VARCHAR2(300 BYTE),
  NAME              VARCHAR2(100 BYTE),
  TITLE             VARCHAR2(100 BYTE),
  CONTENT           VARCHAR2(4000 BYTE),
  HOOK              VARCHAR2(256 BYTE),
  USERDEFINEHOOK    VARCHAR2(256 BYTE),
  RICHTEXTEDITOR    VARCHAR2(5 BYTE),
  RENDERTYPE        VARCHAR2(20 BYTE),
  CONTENTTYPE       VARCHAR2(20 BYTE)           DEFAULT 'Content',
  SORT_ORDER        NUMBER
)
-- query
DROP TABLE {_prefix_}SCONFIGS
-- query
CREATE TABLE {_prefix_}SCONFIGS
(
  ID          NUMBER,
  FKEY        NUMBER,
  SOPTION     VARCHAR2(100 BYTE),
  SVALUE      VARCHAR2(1000 BYTE),
  SORT_ORDER  VARCHAR2(5 BYTE),
  SECTION     VARCHAR2(50 BYTE)
)
-- query
CREATE UNIQUE INDEX {_prefix_}ADMINISTRATORS_PK ON {_prefix_}ADMINISTRATORS(ID)
-- query
CREATE UNIQUE INDEX {_prefix_}APPSLIDE_PK ON {_prefix_}APPSLIDE(ID)
-- query
CREATE UNIQUE INDEX {_prefix_}CATEGORIES_PK ON {_prefix_}CATEGORIES(ID);
-- query
CREATE UNIQUE INDEX {_prefix_}CORERESOURCES_PK ON {_prefix_}CORERESOURCES(ID)
-- query
CREATE UNIQUE INDEX {_prefix_}EMAILTEMPLATE_PK ON {_prefix_}EMAILTEMPLATE(ID)
-- query
CREATE UNIQUE INDEX {_prefix_}LOG_PK ON {_prefix_}LOG(ID)
-- query
CREATE UNIQUE INDEX {_prefix_}PAGES_PK ON {_prefix_}PAGES(ID)
-- query
CREATE UNIQUE INDEX {_prefix_}SCONFIGS_PK ON {_prefix_}SCONFIGS(ID)
-- query
ALTER TABLE {_prefix_}ADMINISTRATORS ADD (
  CONSTRAINT {_prefix_}ADMINISTRATORS_PK
  PRIMARY KEY  (ID)
  USING INDEX {_prefix_}ADMINISTRATORS_PK
  ENABLE VALIDATE)
-- query
ALTER TABLE {_prefix_}APPSLIDE ADD (
  CONSTRAINT {_prefix_}APPSLIDE_PK
  PRIMARY KEY  (ID)
  USING INDEX {_prefix_}APPSLIDE_PK
  ENABLE VALIDATE)  
-- query
ALTER TABLE {_prefix_}CATEGORIES ADD (
  CONSTRAINT {_prefix_}CATEGORIES_PK
  PRIMARY KEY  (ID)
  USING INDEX {_prefix_}CATEGORIES_PK
  ENABLE VALIDATE)
-- query
ALTER TABLE {_prefix_}CORERESOURCES ADD (
  CONSTRAINT {_prefix_}CORERESOURCES_PK
  PRIMARY KEY  (ID)
  USING INDEX {_prefix_}CORERESOURCES_PK
  ENABLE VALIDATE)
-- query
ALTER TABLE {_prefix_}EMAILTEMPLATE ADD (
  CONSTRAINT {_prefix_}EMAILTEMPLATE_PK
  PRIMARY KEY  (ID)
  USING INDEX {_prefix_}EMAILTEMPLATE_PK
  ENABLE VALIDATE)
-- query
ALTER TABLE {_prefix_}LOG ADD (
  CONSTRAINT {_prefix_}LOG_PK
  PRIMARY KEY  (ID)
  USING INDEX {_prefix_}LOG_PK
  ENABLE VALIDATE)
-- query
ALTER TABLE {_prefix_}PAGES ADD (
  CONSTRAINT {_prefix_}PAGES_PK
  PRIMARY KEY  (ID)
  USING INDEX {_prefix_}PAGES_PK
  ENABLE VALIDATE)
-- query
ALTER TABLE {_prefix_}SCONFIGS ADD (
  CONSTRAINT {_prefix_}SCONFIGS_PK
  PRIMARY KEY  (ID)
  USING INDEX {_prefix_}SCONFIGS_PK
  ENABLE VALIDATE)
-- query  
CREATE SEQUENCE {_prefix_}ADMINISTRATORS_SEQ
  START WITH 1
  MAXVALUE 999999999999999999999999999
  MINVALUE 1
  NOCYCLE
  NOCACHE
  NOORDER
-- query
CREATE SEQUENCE {_prefix_}APPSLIDE_SEQ
  START WITH 2
  MAXVALUE 999999999999999999999999999
  MINVALUE 1
  NOCYCLE
  CACHE 20
  NOORDER;
-- query
CREATE SEQUENCE {_prefix_}CORERESOURCES_SEQ
  START WITH 13
  MAXVALUE 999999999999999999999999999
  MINVALUE 0
  NOCYCLE
  NOCACHE
  NOORDER
-- query
CREATE SEQUENCE {_prefix_}EMAILTEMPLATE_SEQ
  START WITH 3
  MAXVALUE 999999999999999999999999999
  MINVALUE 0
  NOCYCLE
  NOCACHE
  NOORDER
-- query
CREATE SEQUENCE {_prefix_}LOG_SEQ
  START WITH 1
  MAXVALUE 999999999999999999999999999
  MINVALUE 0
  NOCYCLE
  NOCACHE
  NOORDER
-- query
CREATE SEQUENCE {_prefix_}PAGES_SEQ
  START WITH 35
  MAXVALUE 999999999999999999999999999
  MINVALUE 1
  NOCYCLE
  CACHE 20
  NOORDER
-- query
CREATE SEQUENCE {_prefix_}SCONFIGS_SEQ
  START WITH 1
  MAXVALUE 999999999999999999999999999
  MINVALUE 0
  NOCYCLE
  NOCACHE
  NOORDER
-- query
Insert into {_prefix_}SCONFIGS
   (ID, FKEY, SOPTION, SVALUE, SORT_ORDER, 
    SECTION)
 Values
   (1, 0, 'theme', 'bootstrap', '0', 
    'hidden')
-- query	
Insert into {_prefix_}SCONFIGS
   (ID, FKEY, SOPTION, SVALUE, SORT_ORDER, 
    SECTION)
 Values
   (2, 0, 'site_logo', 'logo.jpg', NULL, 
    'themesettings')
-- query
Insert into {_prefix_}SCONFIGS
   (ID, FKEY, SOPTION, SVALUE, SORT_ORDER, 
    SECTION)
 Values
   (3, 0, 'default_pagination', '15', '19', 
    'general')
-- query
Insert into {_prefix_}SCONFIGS
   (ID, FKEY, SOPTION, SVALUE, SORT_ORDER, 
    SECTION)
 Values
   (4, 0, 'time_zone', 'Asia/Dhaka', '23', 
    'general')
-- query
Insert into {_prefix_}SCONFIGS
   (ID, FKEY, SOPTION, SVALUE, SORT_ORDER, 
    SECTION)
 Values
   (20, 0, 'copy_right_text', 'Copy Right [year] [website]', NULL, 
    'general')
-- query
COMMIT
-- query
Insert into {_prefix_}PAGES
   (ID, FKEY, PAGE_TITLE, META_KEYWORDS, META_DESCRIPTION, 
    NAME, TITLE, CONTENT, HOOK, USERDEFINEHOOK, 
    RICHTEXTEDITOR, RENDERTYPE, CONTENTTYPE, SORT_ORDER)
 Values
   (9, 0, 'About appRain Content Management Framework', NULL, NULL, 
    'aboutus', 'About Us', '<p>appRain is one of the first, officially-released, open source Content Management Frameworks (CMF). CMF is a new, web engineering concept where a Content Management System (CMS) and a rapid development framework perform side-by-side to produce endless varieties of output in a very limited time.</p>

<p>appRain is developed on a daily basis, drawing on extensive project experience. A common problem that we all face in a framework is that we need to re-develop some common modules in each project. With Content Management Systems, we sometimes get stuck driving our development based on strict development conventions the system enforces. Why is there no CMS integrated with a framework? This is the question that gave birth to appRain.</p>

<p>Content Management Systems and frameworks are very popular in web development. These two technologies work in different ways. One is used for rapid development, the other for more customized output. appRain merges these two technologies. appRain is fast, flexible, and makes it easy to complete tasks in a very short time period. It can be expanded and scaled.</p>

<p>The tools in the CMS component of appRain are all configurable, making development faster. It helps to avoid repeating tasks. The framework component is used when it becomes too difficult to complete your requirements using the CMS tools. The framework contains all of the core programming tools.</p>

<p>appRain aims to make creating web technology simplified and easlily optimized.</p>
', 'sitemenu,quicklinks', NULL, 
    'Yes', 'text', 'Content', 9)
-- query
Insert into {_prefix_}PAGES
   (ID, FKEY, PAGE_TITLE, META_KEYWORDS, META_DESCRIPTION, 
    NAME, TITLE, CONTENT, HOOK, USERDEFINEHOOK, 
    RICHTEXTEDITOR, RENDERTYPE, CONTENTTYPE, SORT_ORDER)
 Values
   (5, 0, 'InformationSet and CategorySet', 'InformationSet and CategorySet', 'InformationSet and CategorySet', 
    'informationset-categoryset', 'InformationSet and CategorySet', '<p>InformationSet and CategorySet are prominent methods work with database. This to special tool keep you hassle free to manage database table. It create interface automatically for data import, control by auto validation also interact with database to fetch data without writing. ;These two methods time of development significantly.</p>

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
CategorySet works similar to InformationSet but it specially works to manage recursive Parent Child relation. Generally it uses to categorize any InformationSet. ;</p>

<p>A rich library of functions has been developed to interact with database to server necessary purpose.</p>
', 'quicklinks', NULL, 
    'Yes', 'smart_h_link', 'Content', 5)
-- query
Insert into {_prefix_}PAGES
   (ID, FKEY, PAGE_TITLE, META_KEYWORDS, META_DESCRIPTION, 
    NAME, TITLE, CONTENT, HOOK, USERDEFINEHOOK, 
    RICHTEXTEDITOR, RENDERTYPE, CONTENTTYPE, SORT_ORDER)
 Values
   (6, 0, 'Theme Development', 'Theme Development', 'Theme Development', 
    'theme-development', 'Theme Development', '<p>Theme development is one of the common requirements during a new website development. appRain has a theme gallery to select theme. Gallery is available in below location:</p>

<p>Login Admin Panel ; Preferences ; Theme</p>

<p>You can choose a theme or add a new theme in the gallery.; Theme can be installed by clicking ;Install New Theme; button. In that case you have to upload theme files in Zip format.</p>

<p>To develop a new theme common practice is to copy an existing theme (except ;admin; folder) in below location:</p>

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

<p>A vast area of work remains for admin interface development.; Admin design generally depends on the controller action to set the design.; Most of the time you have to work with Toolbar, Data Grid and Row Manage to display and manage data.</p>
', 'quicklinks', NULL, 
    'Yes', 'smart_h_link', 'Content', 6)
-- query
Insert into {_prefix_}PAGES
   (ID, FKEY, PAGE_TITLE, META_KEYWORDS, META_DESCRIPTION, 
    NAME, TITLE, CONTENT, HOOK, USERDEFINEHOOK, 
    RICHTEXTEDITOR, RENDERTYPE, CONTENTTYPE, SORT_ORDER)
 Values
   (8, 0, 'General Help Center', 'General Help Center', 'General Help Center', 
    'general-help-center', 'General Help Center', '<p>Read appRain manual online, this is a HTML based manual for User, Developer and learners. We always encourage sending your valuable feedback.</p>

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
', 'quicklinks', NULL, 
    'Yes', 'smart_h_link', 'Content', 8)
-- query
Insert into {_prefix_}PAGES
   (ID, FKEY, PAGE_TITLE, META_KEYWORDS, META_DESCRIPTION, 
    NAME, TITLE, CONTENT, HOOK, USERDEFINEHOOK, 
    RICHTEXTEDITOR, RENDERTYPE, CONTENTTYPE, SORT_ORDER)
 Values
   (11, 0, NULL, NULL, NULL, 
    'home-page-summary', NULL, '<?php 
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
        <a href="<?php echo App::Config()->baseUrl("/{$name}");?>">
            <?php echo App::Module(''Page'')->getData($name,''title''); ?>
        </a>
    </h4>
<?php 
    // End of Loop
    endforeach; ?>    ', NULL, NULL, 
    'Yes', 'h_link', 'Snip', 0)
-- query
Insert into {_prefix_}PAGES
   (ID, FKEY, PAGE_TITLE, META_KEYWORDS, META_DESCRIPTION, 
    NAME, TITLE, CONTENT, HOOK, USERDEFINEHOOK, 
    RICHTEXTEDITOR, RENDERTYPE, CONTENTTYPE, SORT_ORDER)
 Values
   (7, 0, 'Terms of Use: appRain Content Management Framework', 'Terms, Condition, Copy Right', NULL, 
    'terms-of-use', 'Terms of Use', '<p>Copyright (c) appRain CMF (http://www.apprain.com)<br />
<br />
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the ;Software;), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:<br />
<br />
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.<br />
<br />
THE SOFTWARE IS PROVIDED ;AS IS;, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.</p>
', 'sitemenu,quicklinks,template_footer_B', NULL, 
    'Yes', 'h_link', 'Content', 7)
-- query
Insert into {_prefix_}PAGES
   (ID, FKEY, PAGE_TITLE, META_KEYWORDS, META_DESCRIPTION, 
    NAME, TITLE, CONTENT, HOOK, USERDEFINEHOOK, 
    RICHTEXTEDITOR, RENDERTYPE, CONTENTTYPE, SORT_ORDER)
 Values
   (12, 0, NULL, NULL, NULL, 
    'samplephp', NULL, '<?php
    $pages= array(''quick-start'',''page-manager'');
    
    foreach($pageList as $name){
        pr(App::Module(''Page''));
    }
?>', NULL, NULL, 
    'Yes', 'h_link', 'Snip', 0)
-- query
Insert into {_prefix_}PAGES
   (ID, FKEY, PAGE_TITLE, META_KEYWORDS, META_DESCRIPTION, 
    NAME, TITLE, CONTENT, HOOK, USERDEFINEHOOK, 
    RICHTEXTEDITOR, RENDERTYPE, CONTENTTYPE, SORT_ORDER)
 Values
   (10, 0, 'appRain:  Content  Management Framework is a combination of Content Management System and Rapid Development Framework', 'Content Management System, PHP Framework, PHP Content Management System, PHP CMS, Web Development Tool, Project Development Tool', 'A PHP Content Management Framework combining  CMS(Content Management System) and Framework (Rapid Development Framework) to enable fast Web Developmen', 
    'home-page', 'What is appRain  Content Management Framework?', '<h1>What is appRain Content Management Framework?</h1>

<p>appRain is one of the first officially released Opensource Content Management Framework (CMF). CMF is a new web engineering concept where ;CMS (Content Management System); and ;Framework; perform together to produce endless varieties of output in a very limited time.</p>

<p>appRain, published with lots of extensive features to reduce our development work time. It satisfies both Client and Developers with a safe and quality output.</p>

<hr />
<h3><a href="{baseurl}/quick-start">Quick Start</a></h3>
', 'home_content_area_A', NULL, 
    'Yes', 'text', 'Content', 0)
-- query
Insert into {_prefix_}PAGES
   (ID, FKEY, PAGE_TITLE, META_KEYWORDS, META_DESCRIPTION, 
    NAME, TITLE, CONTENT, HOOK, USERDEFINEHOOK, 
    RICHTEXTEDITOR, RENDERTYPE, CONTENTTYPE, SORT_ORDER)
 Values
   (2, 0, 'Page Manager', NULL, NULL, 
    'page-manager', 'Page Manager', '<p><strong>Page Manger</strong> is a frequently used module to create new pages in the website. You will get it in first Tab after login Admin Panel.</p>

<p>Use link page section to assign your page in different place in the website. You will get different selected section to assign the page in Menu, Quick Links. You can select multiple hooks by holding CTRL key and Mouse left Click.</p>

<p>The presentation of the page can be text or hyper link. You can select the option from drop down beneath the hook list. Text option will place the page content in a particular area of a page. Hyper link can be two type, one is Smart Link which generates a page with optimized URL. Other one is a direct link of the page.</p>

<p>A large text box is available to renter a page in a User Defile Hook defined in the theme, each hook name must be comma separated.</p>

<p>It is really important to present the page well formatted. Use common field section to set Page Title and other Meta information.</p>

<p>Sort Order, is helpful to manage the order of the page in website menu and quick links.</p>

<p>Dynamic pages are great features in Page Manager to write Server Side Coding. All resource should be access through App factory. Because, this factory will bring all your resource available in the script. To work in dynamic page you need little ideal of <a href="http://docs.apprain.com/index.html?chapter_2.htm">internal structure</a> of appRain. One important tips, Dynamic page render only under static page. Click on ;Page Code List; button and the list will popup. Also, a static page can be rendered in side other static page. Just paste the Page Code inside the content.</p>

<p>For developers, there is a detailed module to execute all operations. This module helps to work with Pages in MVC model. Moreover, it has different hooks to register Page Manager in Component in different events.</p>
', 'quicklinks', NULL, 
    'Yes', 'smart_h_link', 'Content', 2)
-- query
Insert into {_prefix_}PAGES
   (ID, FKEY, PAGE_TITLE, META_KEYWORDS, META_DESCRIPTION, 
    NAME, TITLE, CONTENT, HOOK, USERDEFINEHOOK, 
    RICHTEXTEDITOR, RENDERTYPE, CONTENTTYPE, SORT_ORDER)
 Values
   (1, 0, 'Quick Start', 'Quick Start', 'Quick Start', 
    'quick-start', 'Quick Start', '<p>appRain has multidimensional approach to serve a purpose in web based software development. Specifically, Use as Content Management System or utilized the framework layer only.</p>

<p>For a quick start, CMS would be a great area to choose.</p>

<p>appRain has an attractive Admin panel, you must login there first. Go the page manager to has a look around and add some content in the website. You can put the content of a page in different location in website by User Hook. If you wish, can see all location by enabling the flag ;Show Hook Positions; in Preference ; Configuration<br />
If you love to write some PHP, you can create dynamic pages. A dynamic page can render under a static page only.</p>

<p>Next, you might need a Blog or Contact Us page, may be other features for your site. Just install component! It will enable addition functionality. Go in Application tab to add new components.</p>

<p>appRain has a wide range of configurable parameters. You can setup some of them from Preference.</p>

<p>Now, for an expert developer, It is easy to start your development by creating new Components. It will keep your code separate, plug-able and distributable. Any core resource can inherit by related hook. Also, development can be done from ;development; folder, especially theme. It;s advisable to use UI Hook to make the theme more accessible by external plug-ins.</p>

<p>Database! Never be tired by redundant work. Use InformationSet and CategorySet. appRain takes care of interface development, validation also auto made your query.</p>

<p>Further more, you are open for extensive development with different type of databases and Web Service layer.</p>
', 'sitemenu,quicklinks', NULL, 
    'Yes', 'smart_h_link', 'Content', 1)
-- query
Insert into {_prefix_}PAGES
   (ID, FKEY, PAGE_TITLE, META_KEYWORDS, META_DESCRIPTION, 
    NAME, TITLE, CONTENT, HOOK, USERDEFINEHOOK, 
    RICHTEXTEDITOR, RENDERTYPE, CONTENTTYPE, SORT_ORDER)
 Values
   (4, 0, 'Concept of Development', 'Concept of Development', 'Concept of Development', 
    'concept-of-development', 'Concept of Development', '<p>appRain is a robust platform for development which optimized the effort and time.</p>

<p>First setup appRain, then start development with all interface based tool like Page Manager, Theme etc.; This is a very preliminary stage of you start up.</p>

<p>After that, find components that fit for you and install it. This will save lots of you time.</p>

<p>On next level appRain always advice to avoid making your hand dirty with lots of hard coding and database query management. Just configure some XML and..</p>

<ul>
    <li>Use InformationSet, CategorySet to develop interface quickly for data management</li>
    <li>Create different type of setting for your project by ;Site Settings;</li>
    <li>Create menu and render interface in admin panel by ;Interface Builder;</li>
    <li>Mange website routing</li>
    <li>Work with language</li>
    <li>Integrate external plug-ins</li>
    <li>Web Service</li>
</ul>

<p>By doing configuration we can cover a large part of your project.</p>

<p>Now start to work with MVC pattern to meet up any expectation. Configure one or multiple database to work with simultaneously.<br />
This is highly recommended, develop new components for a specify requirements. Each component will enrich your personal archive because it is in-stable. A component uses any core resource by using hook. Moreover, It can be keep away from main system by;; deactivating by a simple click.</p>

<p>However, appRain has both ready-made and un-stitched tool, we just have to use it as per need.</p>
', 'quicklinks', NULL, 
    'Yes', 'smart_h_link', 'Content', 4)
-- query
Insert into {_prefix_}PAGES
   (ID, FKEY, PAGE_TITLE, META_KEYWORDS, META_DESCRIPTION, 
    NAME, TITLE, CONTENT, HOOK, USERDEFINEHOOK, 
    RICHTEXTEDITOR, RENDERTYPE, CONTENTTYPE, SORT_ORDER)
 Values
   (3, 0, 'Component Installation', 'Component Installation', 'Component Installation', 
    'component-installation', 'Component Installation', '<p>Component is a pluggable module, the main logic of it to connect to core system with different hook and add new features. Let;s say you want a blog in your website. Just download the component from the archive and install.</p>

<p>Your entire component list can be seen in ;Applications; tab after login Admin Panel.</p>

<p>There are few simple steps to install a component. appRain has an installer to add new component.</p>

<ol>
    <li>First login to Admin Panel</li>
    <li>Click on <strong>Application tab</strong> then <strong>Install New Component </strong>button</li>
    <li>Select Component source file in Zip format</li>
    <li>Click on <strong>Install</strong> Button</li>
</ol>

<p>After a successful installation the component will be available in the list. Find your installed Component check and click on ACTIVATE link to enable the component.</p>

<p>If you feel any component is not fit for you, just deactivate it. The component will stop functioning instantly.</p>

<p>Generally all components isolate the code in ;component; folder. If auto installation process does not work you can copy the code in that folder. However, always follow developer;s instruction in any exception.<br />
<br />
;After installation, new tab or menu can be seen in admin panel and website. It;s depending on the architecture of the component development.</p>

<p>A component is always an external resource. If it has been deactivated all resources will be out of the overall system.</p>
', 'quicklinks', NULL, 
    'Yes', 'smart_h_link', 'Content', 3)
-- query
COMMIT;
-- query
Insert into {_prefix_}CORERESOURCES
   (ID, NAME, TYPE, VERSION, STATUS, 
    INFO)
 Values
   (1, 'Admin', 'Model', '0.1.0', NULL, 
    NULL)
-- query
Insert into {_prefix_}CORERESOURCES
   (ID, NAME, TYPE, VERSION, STATUS, 
    INFO)
 Values
   (2, 'Category', 'Model', '0.1.0', NULL, 
    NULL)
-- query
Insert into {_prefix_}CORERESOURCES
   (ID, NAME, TYPE, VERSION, STATUS, 
    INFO)
 Values
   (3, 'Config', 'Model', '0.1.0', NULL, 
    NULL)
-- query
Insert into {_prefix_}CORERESOURCES
   (ID, NAME, TYPE, VERSION, STATUS, 
    INFO)
 Values
   (4, 'Coreresource', 'Model', '0.1.0', NULL, 
    NULL)
-- query
Insert into {_prefix_}CORERESOURCES
   (ID, NAME, TYPE, VERSION, STATUS, 
    INFO)
 Values
   (5, 'Developer', 'Model', '0.1.0', NULL, 
    NULL)
-- query
Insert into {_prefix_}CORERESOURCES
   (ID, NAME, TYPE, VERSION, STATUS, 
    INFO)
 Values
   (6, 'Home', 'Model', '0.1.0', NULL, 
    NULL)
-- query
Insert into {_prefix_}CORERESOURCES
   (ID, NAME, TYPE, VERSION, STATUS, 
    INFO)
 Values
   (7, 'Information', 'Model', '0.1.0', NULL, 
    NULL)
-- query
Insert into {_prefix_}CORERESOURCES
   (ID, NAME, TYPE, VERSION, STATUS, 
    INFO)
 Values
   (8, 'Log', 'Model', '0.1.0', NULL, 
    NULL)
-- query
Insert into {_prefix_}CORERESOURCES
   (ID, NAME, TYPE, VERSION, STATUS, 
    INFO)
 Values
   (9, 'Page', 'Model', '0.1.0', NULL, 
    NULL)
-- query
Insert into {_prefix_}CORERESOURCES
   (ID, NAME, TYPE, VERSION, STATUS, 
    INFO)
 Values
   (10, 'dbexpert', 'Component', '0.1.2', 'Active', 
    'a:1:{s:11:"installdate";s:19:"2015-07-08 14:57:45";}')
-- query
Insert into {_prefix_}CORERESOURCES
   (ID, NAME, TYPE, VERSION, STATUS, 
    INFO)
 Values
   (11, 'appeditor', 'Component', '0.1.7', 'Active', 
    'a:1:{s:11:"installdate";s:19:"2015-07-08 14:57:38";}')
-- query
Insert into {_prefix_}CORERESOURCES
   (ID, NAME, TYPE, VERSION, STATUS, 
    INFO)
 Values
   (12, 'appslide', 'Component', '0.1.0', 'Active', 
    'a:1:{s:11:"installdate";s:19:"2015-07-08 14:57:42";}')
-- query
Insert into {_prefix_}APPSLIDE
   (ID, ADMINID, ENTRYDATE, LASTMODIFIED, TITLE, 
    IMAGE, DESCRIPTION, STATUS)
 Values
   (3, 1, '2015-06-18 12:25:11', '2015-07-08 16:32:12', 'VERSION', 
    'pagemanager.png', '<p>&nbsp;</p>

<p>&nbsp;</p>

<h1>appRain Version CMF</h1>

<h2>For Endless Rapid Development!</h2>
', 'Active')
-- query	
COMMIT

