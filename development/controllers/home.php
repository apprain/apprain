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
    public function searchAction($srcstr = null, $page = 1)
    {
        /* Attach Addons and Set meta information */
        $this->addons = Array('defaultvalues');
        $staticpage = $this->staticPageNameToMetaInfo('search');

        /**
         * Fetch all search data definition in defintion
         * for Information Set and Category set
         */
        $srcstr = isset($this->post['ss']) ? $this->post['ss'] : $srcstr;
        $srcData = App::Helper("Search")
            ->setSmartPaging(true)
            ->setPage($page)
            ->setLimit(5)
            ->setHLink($this->baseurl("/search/{$srcstr}"))
            ->Search($srcstr);

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