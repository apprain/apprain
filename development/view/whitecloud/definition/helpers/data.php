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
 * @copyright  Copyright (c) 2010 appRain, Team. (http://www.apprain.org)
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
 * http ://www.apprain.org/general-help-center
 */

 
class Development_View_Whitecloud_Definition_Helpers_Data extends appRain_Collection {
	
	const WHITECLOUD = "whitecloud";
	
	public function PrintCallBackMenus(){
		$External_Menu_List =  $this->siteMenuClear()->siteMenuRender('ARRAY');
		foreach($External_Menu_List as $menu){
			echo '<li class="nav-item">' . App::Html()->linkTag($menu[0],$menu[1],array("class"=>"nav-link")) . "</li>";
		}
	}
	
	public function getDynamicPageData($name=null,$default=null){
		
		$pagename = self::WHITECLOUD . "_{$name}";

		$Content = App::Model("Page")->findByName($pagename);

		if(empty($Content)){
			
			$obj = App::Model("Page")
				->setId(null)
				->setContentType('Snip')
				->setName($pagename)
				->setContent($default)
				->Save();

			return App::Helper('Utility')->parsePHP($default);
		}
		
		
		return App::Helper('Utility')->parsePHP($Content['content']);
	}
	
	
	public function getMenu(){
		
		$default_content =  
'<ul class="navbar-nav col-lg-8 justify-content-lg-end">		  
<?php App::Hook("UI")->Render("template_header_A"); #User Interface Hook ?>
<li class="nav-item">
  <a class="nav-link" aria-current="page" href="<?php echo App::Config()->baseUrl(); ?>">Home</a>
</li>
<?php App::View("Whitecloud")->Helper("Data")->PrintCallBackMenus(); ## Printing a menu from the Call Back functions ?>
<?php App::Hook("UI")->Render("template_header_B"); #User Interface Hook ?>
</ul>';
				
		return $this->getDynamicPageData('menu',$default_content);
	  
	}
	
	public function getSlide(){
		$default_content = 
'<section id="myCarousel" class="carousel slide" data-bs-ride="carousel">
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
			<h1 class="display-5 fw-bold">Apprain</h1>
			
			 <p>
				Are you ready to write some XML tags? It\'s pretty simple, right? XML-based coding will enable significant advancements in appRain. 
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
			<p>Convert your work into APIs; it\'s very easy. The application can be securely integrated with any other system on any platform.</p>
			<p>Ethical is a security plugin in-built with version 4.0.5 that also works as an API layer. Install the component, create a service helper, and that\'s all it takes to make the method callable from other systems through user authentication and a secure token. </p>
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
</section>';
		  
		return $this->getDynamicPageData('slide',$default_content);
	}


	public function HomeContentAreaA(){
		$default_content =
'<section>
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
</section>';
		
		return $this->getDynamicPageData('home-content-area-A',$default_content);
	}
	
	public function HomeContentAreaB(){
		$default_content =
'<section class="background-grey">
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
		<p class="text-muted"><code>App::Module(\'Hook\')</code>  is primarily used in components to register all resources and utilize them in a standalone manner.</p>
	 
	  </div>
	</div>
</div>
</section>';
	
		return $this->getDynamicPageData('home-content-area-B',$default_content);
	}
	
	public function HomeContentAreaC(){
		$default_content =
'<section>
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
</section>';
	
		return $this->getDynamicPageData('home-content-area-C',$default_content);
	}
	
	public function HomeContentAreaD(){
		$default_content =
'<section>
<div class="bg-dark text-secondary px-4 text-center">
	<div class="py-5">
		<h1 class="display-5 fw-bold text-white">Apprain Community</h1>
		<div class="col-lg-6 mx-auto">
			<p class="fs-5 mb-4">
			appRain is currently hosted on two websites, which are www.apprain.org and www.apprain.com. New releases, developer materials, and all other information are available on the ORG website. The COM website, on the other hand, offers support for the appRain team\'s ERP.
			The context here is that the ORG is practicing CSR with the support of COM in return enjoys all the releases from the ORG.
			</p>
			<div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
				<a href="https://www.apprain.org" target="_blank"><button type="button" class="btn btn-outline-info btn-lg px-4 me-sm-3 fw-bold">.ORG</button></a>
				<a href="https://www.apprain.com" target="_blank"><button type="button" class="btn btn-outline-light btn-lg px-4 me-sm-3 fw-bold">.COM</button></a>
			</div>
		</div>
	</div>
</div>
</section>';
	
		return $this->getDynamicPageData('home-content-area-D',$default_content);
	}


	
	public function getFooterMenu(){
		
		$default_content = 
'<div class="col-6 col-md-2 mb-3">
        <h5>Page</h5>
        <ul class="nav flex-column">
			<li class="nav-item mb-2"><a href="<?php echo App::Config()->baseUrl("/theme-development"); ?>" class="nav-link p-0 text-muted">Home</a></li>
        </ul>
      </div>
	  
      <div class="col-6 col-md-2 mb-3">
        <h5>Access</h5>
        <ul class="nav flex-column">
			<li class="nav-item mb-2"><a href="<?php echo App::Config()->baseUrl("/admin"); ?>" class="nav-link p-0 text-muted">Admin Login</a></li>
		</ul>
	  </div>

      <div class="col-6 col-md-2 mb-3">
        <h5>Help</h5>
        <ul class="nav flex-column">
          
          <li class="nav-item mb-2"><a href="https://www.apprain.org/general-help-center" class="nav-link p-0 text-muted" target="_blamk">Documentations</a></li>
        </ul>
 </div>';
			  
		return $this->getDynamicPageData('footer-menu',$default_content);
		
	}
	
	public function getFooterContent(){
		
		$default_content = 
'<div class="col-md-5 offset-md-1 mb-3">
	<h5>
		<?php 
			## Check in Language file Admin Panel > Preferances > Language > default.xml
			echo $this->__("APPRAIN");
		?>
		<?php
			## Check in System Configuration file in source code. This is an hidden field
			## definition/system_configuration/config.xml 
			echo App::__Def()->sysConfig(\'APPRAINVERSION\'); 
		?>
	</h5>
	<p>
		The new release focused on security and data interfacing through the Ethical Component.
	</p>
</div>';
	  
		return $this->getDynamicPageData('footer-content',$default_content);
		
	}
	
}