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

abstract class appRain_Base_Modules_search extends appRain_Base_Objects
{
    public $searchPool = Array();
    const LINK_RELATIVE = 'Relative';
    const LINK_ABSOLUTE = 'Absolute';
    const CACHE_PRE_FIX = '__search__';
    const PARMA_DESC_LEANGTH = 200;

    public function search($srt = "")
    {
        if ($srt == "") {
            return "";
        }
        $this->setSearchString($srt);


        if (!$this->hasCache()) {
            $this->searchPool = Array();

            App::__obj("Development_Callbacks")->_before_search_init($this);

            foreach (App::__def()->getCategorySetList() as $name) {
                $srcStr = $this->CategorySetSearchData($name);
                if (!empty($srcStr)) {
                    $this->searchPool = array_merge($this->searchPool, $srcStr);
                }
            }

            foreach (App::__def()->getInformationSetList() as $type) {

                $srcStr = $this->getSearchableFields($type);
				
                if (!empty($srcStr)) { 
                    $this->searchPool = array_merge($this->searchPool, $this->processInformationSet($type, $srcStr));
                }
            }

            $pages = App::Model('Page')->findAll("title LIKE '%$srt%' OR content LIKE '%$srt%' and Fkey=0");
            foreach ($pages['data'] as $row) {
                $row['_parmalink'] = App::Helper('Html')->linkTag(App::Config()->baseUrl("/page/view/{$row['name']}"), $row['title']);
                $row['_parmadesc'] = substr(strip_tags($row['content']), 0, 200);
                $this->searchPool[] = $row;
            }

            App::__obj("Development_Callbacks")->_after_search_init($this);

            $this->createCache();
        }
        else {
            $this->searchPool = $this->readCache();
        }

        return App::Helper('Utility')->array_paginator($this->searchPool, Array('limit' => $this->getLimit(), 'h_link' => $this->getHLink(), 'page' => $this->getPage(), 'smart' => $this->getSmartPaging()));
    }

    private function readCache()
    {
        if (app::__def()->sysConfig('SEARCH_CACHE') == 'File') {
            return App::Module('Cache')->Read($this->cacheKey());
        }
        else if (app::__def()->sysConfig('SEARCH_CACHE') == 'Session') {
            return App::Module('Session')->Read($this->cacheKey());
        }
    }

    private function createCache()
    {
        if (!empty($this->searchPool)) {
            if (app::__def()->sysConfig('SEARCH_CACHE') == 'File') {
                App::Module('Cache')->Write($this->cacheKey(), $this->searchPool);
            }
            else if (app::__def()->sysConfig('SEARCH_CACHE') == 'Session') {
                App::Module('Session')->Write($this->cacheKey(), $this->searchPool);
            }
        }
        return $this;
    }

    private function hasCache()
    {
        if (app::__def()->sysConfig('SEARCH_CACHE') == 'NoCache') {
            return false;
        }
        else if (app::__def()->sysConfig('SEARCH_CACHE') == 'File') {
            return App::Module('Cache')->exists($this->cacheKey());
        }
        else if (app::__def()->sysConfig('SEARCH_CACHE') == 'Session') {
            return App::Module('Session')->exists($this->cacheKey());
        }
    }

    private function cacheKey()
    {
        return self::CACHE_PRE_FIX . App::Helper('Utility')->text2Normalize($this->getSearchString());
    }

    private function categorySetSearchData($name)
    {
        $definition = App::__def()->getCategorySetDefinition($name);
        $definition['search']['status'] = isset($definition['search']['status']) ? $definition['search']['status'] : "No";
        $srcstr = $this->getSearchString();

        $data = Array();
        if ($definition['search']['status'] == 'Yes') {
            $tmp = App::CategorySet($name)->findAll("title LIKE '%{$srcstr}%' OR description LIKE '%{$srcstr}%'");

            foreach ($tmp['data'] as $key => $val) {
                $uri = str_replace('[id]', $val['id'], $definition['search']['parma-link']['uri']);
                $uri = str_replace('[title]', App::Helper('Utility')->text2Normalize($val[$definition['search']['field-selected']]), $uri);

                if (ucfirst($definition['search']['parma-link']['type']) == self::LINK_ABSOLUTE) {
                    $val['_parmalink'] = App::Helper('Html')->linkTag($uri, $val[$definition['search']['field-selected']]);
                }
                else {
                    $val['_parmalink'] = App::Helper('Html')->linkTag(App::Helper('Config')->baseurl("/{$uri}"), $val[$definition['search']['field-selected']]);
                }

                $val['_parmadesc'] = substr($val['description'], 0, self::PARMA_DESC_LEANGTH);
                $data[] = $val;
            }
        }
        return $data;
    }

    private function processInformationSet($type = null, $srcStr = null)
    {
        $definition = App::__def()->getInformationSetDefinition($type);

        $result = App::InformationSet($type)->findAll($srcStr);

        $data = Array();
        foreach ($result['data'] as $val) {
            $uri = $definition['base']['search']['parma-link']['uri'];

            foreach (explode("/", $uri) as $needle) {
                if (substr($needle, 0, 1) == "[" && (substr($needle, (strlen($needle) - 1), (strlen($needle)))) == "]") {
                    $field = substr($needle, 1, strlen($needle) - 2);
                    $uri = str_replace($needle, $val[$field], $uri);
                }
            }

            if (ucfirst($definition['base']['search']['parma-link']['type']) == self::LINK_ABSOLUTE) {
                $val['_parmalink'] = App::Helper('Html')->linkTag($uri, $val[$definition['base']['search']['field-selected']]);
            }
            else {
                $val['_parmalink'] = App::Helper('Html')->linkTag(App::Helper('Config')->baseurl("/{$uri}"), $val[$definition['base']['search']['field-selected']]);
            }

            $val['_parmadesc'] = isset($val[$definition['base']['search']['field-description']])
                ? substr(strip_tags($val[$definition['base']['search']['field-description']]), 0, self::PARMA_DESC_LEANGTH) : "";

            $data[] = $val;
        }
		
        return $data;
    }

    private function getSearchableFields($type)
    {
        $definition = App::__def()->getInformationSetDefinition($type);

        $srcStr = '';
        $definition['base']['search']['status'] = isset($definition['base']['search']['status']) ? $definition['base']['search']['status'] : "No";

        if (strtolower($definition['base']['search']['status']) == 'yes') {
            foreach ($definition['fields'] as $name => $field) {
                if (strtolower($field['searchable']) == 'yes') {
					$srcStr = ($srcStr=='') ? $srcStr : " {$srcStr} OR "; 
					$srcStr .= " {$name} LIKE '".  '%' . $this->getSearchString() . "%'";
                }
            }
        }
		
        return $srcStr;
    }
}