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


/**
 * Home page
 */
class homeController extends appRain_Base_Core
{
    // Controller Name
    public $name = "Home";
    public $dispatch = Array(
        'preDispatchExclude' => array(),
        'postDispatchExclude' => array()
    );

    /**
     * Function Call before Page action method each time
     */
    public function __preDispatch()
    { 
    }

    /**
     * Function Call before Page action method each time
     */
    public function __postDispatch()
    {
    }

    /**
     * Render Home page
     * We have configure this page from
     * URI_Manager >> Boot_Router
     * to be Render as a starting page of the project
     */
    public function indexAction($id = null)
    { 
        /**
         * Fetch data from static page manager and
         * set Page Meta Information.
         */
        $pageinfo = $this->staticPageNameToMetaInfo('home-page');
		$this->set('pageinfo', $pageinfo);

        /* Set value to template */
        $this->set("selected", "home");
    }

    /**
     * Create search result based on Definitions
     * and call back functions.
     */
    public function searchAction()
    {
        /* Attach Addons and Set meta information */
        $staticpage = $this->staticPageNameToMetaInfo('search');

        /**
         * Fetch all search data definition in defintion
         * for Information Set and Category set
         */
        $srcstr = isset($this->get['ss']) ? $this->get['ss'] : '';
        $page = isset($this->get['page']) ? $this->get['page'] : '';
		
        $srcData = App::Helper("Search")
            //->setSmartPaging(true)
            ->setPage($page)
            ->setLimit(App::Config()->Setting('default_pagination',50))
            ->setHLink(App::Config()->baseUrl("/search?ss={$srcstr}"))
            ->Search($srcstr);
			///pre($srcData);
        /* Overwrite page title */
        $this->page_title = "{$srcstr} {$this->page_title}";

        /* Set Search data */
        $this->set('srcstr', $srcstr);
        $this->set('srcarr', $srcData);

        /* Set Common variables */
        $this->set("section_title", "Search Reasult");
        $this->set("selected", "search");
    }
}