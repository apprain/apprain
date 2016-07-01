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

class Development_Callbacks extends appRain_Base_Modules_Callbacks
{
    /*
     * Callback function
     *
     * Run before page start
     */
    public function before_render()
    {		
    }

    /*
     * Callback function
     *
     * Run before admin start
     */
    public function before_adminpanel_render()
    {
    }

    /*
     * Callback function
     *
     * Run after page render complete
     */
    public function after_render()
    {
    }

    /*
     * Callback function
     *
     * Run before admin start
     */
    public function after_adminpanel_render()
    {
    }

    /**
     * Callback function
     *
     * Before an addon load complete
     */
    public function before_addon_load($name = NULL, $options = NULL)
    {
        switch ($name) {
        }
    }

    /**
     * Callback function
     *
     * After an addon load
     */
    public function after_addon_load($name = NULL, $options = NULL)
    {	
        switch ($name) {
			case "rich_text_editor" :
                if (App::Config()->Setting('rich_text_editor') != 'No') {                   
                    echo "<script type=\"text/javascript\">
							window.onload = function(){
								var arr = document.getElementsByTagName('textarea');
								for(var i = 0; i < arr.length; i++ ){
								   if(arr[i].className.match('richtexteditor')){
										CKEDITOR.replace(arr[i]);
									}
								}
							}
						</script>";
                }
                break;}
    }

    /**
     * Information Set call back function.
     * Run when we view information set
     *
     * @param fixedArray
     */
    public function on_information_set_view($options = NULL)
    {
        switch ($options['type']) {
        }
    }

    /*
     * Callback function
     *
     * Run when any Information Set entry delete
     */
    public function on_information_set_delete($options = NULL)
    {
        switch ($options['type']) {
        }
    }

    /*
     * Callback function
     *
     * Run before Information Set entery Save
     */
    public function before_information_set_save($options = NULL)
    {
        switch ($options['type']) {
        }
    }

    /*
     * Callback function
     *
     * Run after Information Set entry save
     */
    public function after_information_set_save($options = NULL)
    {
        switch ($options['type']) {
        }
    }

    /*
     * Callback function
     *
     * Run before search data initialized
     * Debug hints
     * pre($send->searchPool)
     * pre($send->getSearchstring());
     * pre($send->getLimit());
     * pre($send->getGroupnames());
     */
    public function _before_search_init($send = NULL)
    {
        /*
            # EXAMPLE TO ADD DADA MANUALLY
            $send->searchPool[] = Array('id'=>'5','str'=>'xy1');
            $send->searchPool[] = Array('id'=>'6','str'=>'xy2');
            $send->searchPool[] = Array('id'=>'7','str'=>'xy3');
        */

    }

    /*
     * Callback function
     *
     * Run once auto search initialization complete
     */
    public function after_search_init($send = NULL)
    {
    }

    /*
     * Callback function
     *
     * Helps to modify the URL Manager Definition
     */
    public function on_uri_definition_init($def = NULL)
    {
        /*
         * Example 1
         * This example moves control to
         * home/index for the url www.example.com/hellow-world
         */
        /*$def['pagerouter'][] = array(
            "actual"=>Array("home","index"),
            "virtual"=>Array("hello-world1")
        );*/

        /*
         * Example 2
         * This example moves control to
         * home/index/5 for the url www.example.com/birthday-gift/15th-birthday
         */
        /*$def['pagerouter'][] = array(
            "actual"=>Array("home","index","5"),
            "virtual"=>Array("birthday-gift","15th-birthday")
        `);*/

        /*
         * For any new chnage we have to return $def
         */
        //return $def;
    }
}