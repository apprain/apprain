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

class appRain_Base_Modules_Page extends appRain_Base_Objects
{
    const CONTENT = 'Content';
    const SNIP = 'Snip';

   
    public function registerCallBacks()
    {
        $pages = App::Load("Model/Page")->findAll("(hook<>'' OR hook<>'userdefinehook' OR rendertype<>'')");

        foreach ($pages['data'] as $page) {
            $combined_hook = $page['hook'] . (($page['userdefinehook'] != '') ? ",{$page['userdefinehook']}" : "");
            $shooks = explode(',', $combined_hook);
            if (in_array('sitemenu', $shooks)) {
                App::Module('Hook')
                    ->setHookName('Sitemenu')
                    ->setAction("register_sitemenu")
                    ->Register(get_class($this), "register_sitemenu", $page);
            }

            foreach ($shooks as $a) {
                App::Module('Hook')
                    ->setHookName('UI')
                    ->setAction($a)
                    ->Register(get_class($this), "register_page_to_hook", $page);
            }

            App::Module('Hook')
                ->setHookName('URIManager')
                ->setAction("on_initialize")
                ->Register(get_class($this), "register_newrole", $page);
        }
    }

    public function register_sitemenu($send, $data)
    {
        $menu = Array();
        if ($data['rendertype'] == 'smart_h_link') {
            $menu[] = Array(App::Helper('Config')
                ->baseurl(
                strtolower("/{$data['name']}")
            ),
                "{$data['title']}",
                strtolower("{$data['name']}")
            );
        }
        else {
            $menu[] = Array(
                App::Helper('Config')->baseurl(
                    strtolower("/page/view/{$data['name']}")
                ),
                "{$data['title']}",
                strtolower("{$data['name']}")
            );
        }
        return $menu;
    }

    public function register_page_to_hook($send = null, $data)
    {
        switch ($data['rendertype']) {
            case 'smart_h_link' :
                return " " . App::Helper('Html')
                    ->linkTag(
                    App::Helper('Config')->baseUrl(
                        strtolower("/{$data['name']}")
                    ),
                    trim($data['title'])
                ) . "  ";
                break;
            case 'h_link' :
                return " " . App::Helper('Html')
                    ->linkTag(
                    App::Helper('Config')
                        ->baseUrl(
                        strtolower("/page/view/{$data['name']}")
                    ),
                    trim($data['title'])
                ) . " ";
                break;
            default     :
                return $data['content'];
                break;

        }
    }

    public function register_newrole($def = null, $data)
    {
        if ($data['rendertype'] == 'smart_h_link') {
            $def['pagerouter'][] = array(
                "actual" => Array(
                    "page", "view", $data['name']
                ),
                "virtual" => Array(
                    $data['name']
                )
            );
        }
        return $def;
    }

	
    public function getDataById($id = NULL)
    {
        return App::Model('Page')->findById($id);
    }

    /**
     * Get Page data
     */
    public function getData($pageName = NULL, $fieldName = NULL, $cnd = "")
    {

        if ($cnd != "") {
			$cnd = "AND ($cnd)";
		}

        if (isset($pageName)) {
            $data = App::Load("Model/Page")->find("name='{$pageName}'  {$cnd}");
            return isset($data[$fieldName]) ? $data[$fieldName] : $data;
        }
        else {
            return App::Load("Model/Page")->findAll("1 {$cnd}");
        }
    }

    /**
     * To process get static page information
     *
     * @param $flag String
     * @param $flag2 String
     */
    public function pages($flag = "all", $flag2 = NULL)
    {
        switch ($flag) {
            case "name_only":
                $page_arr = App::Load("Model/Page")->findAll();
                $data = array();
                foreach ($page_arr['data'] as $key => $val) {
                    $data[$val['id']] = $val['name'];
                }
                return $data;
                break;
            case "title_only":
                $page_arr = App::Load("Model/Page")->findAll();
                $data = array();
                foreach ($page_arr['data'] as $key => $val) {
                    $data[$val['id']] = $val['title'];
                }
                return $data;
                break;
            case "by_name"   :
                return App::Load("Model/Page")->findAll("name='$flag2'");
                break;
            case "all":
                return App::Load("Model/Page")->findAll("1 ORDER BY title ASC");
                break;
            default:
                return App::Load("Model/Page")->findById($flag);
                break;
        }
    }

    public function loadInDB($name = null)
    {
        $data = App::Model('Page')->findByName($name);
        if (!empty($data)) {
            return;
        }

        App::Model('Page')
            ->setId(null)
            ->setName($name)
            ->setTitle($this->getTitle())
            ->setPage_title($this->getPageTitle())
            ->setMeta_keywords($this->getMetaKeywords())
            ->setMeta_description($this->getMetaDescription())
            ->setTitle($this->getTitle())
            ->setContent($this->getContent())
            ->Save();
    }

    public function UnloadInDB($name = null)
    {
        App::Model('Page')->DeleteByName($name);
    }

    public function getQuickLinks()
    {
        $data = App::Model('Page')->findAll("hook LIKE '%quicklinks%'");
        $links = array();
        foreach ($data['data'] as $row) {
            $links[] = array(
                'link' => $this->linkById($row['id']),
                'id' => $row['id'],
                'title' => $row['title']
            );
        }
        return $links;
    }

    public function LinkById($id = null)
    {

        $page = $this->getDataById($id);
        if ($page['rendertype'] == 'smart_h_link') {
            $src = App::Config()->baseUrl("/{$page['name']}");
        }
        else {
            $src = App::Config()->baseUrl("/page/view/{$page['name']}");
        }

        return $src;
    }
	
	public function FieldValueById($id = null,$fieldName=null)
    {
        $page = $this->getDataById($id);		
        return isset($page[$fieldName]) ? $page[$fieldName] : '';
    }
	
}