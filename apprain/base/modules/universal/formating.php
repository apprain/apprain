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
 * echo App::Module('Universal_Formating')->blockFormated($page_content['content'],$page_content['name']);
 * echo App::Module('Universal_Formating')->pageFormated($page_content['id'])
 */
class appRain_Base_Modules_Universal_Formating extends appRain_Base_Modules_Utility {

    private $content = "";
    private $fields = array();

    const CACHE_PAGE_PRE_FIX = '__UF__';
    const REGEXP_TAGSPLIT = '[{{|}}]';
    const REGEXP_ENTITY = '[=| ]';
    const NAME = 'name';
    const AUTOFORMATE = 'autoformat';
    const OFF = 'off';
    const ON = 'on';
    const CONTENT_CACHE = false;
    const MAX_ROUND = 5;

    private $cnt = 1;

    public function blockFormated($content = "", $hash = "", $isCache = true) {
        if (empty($content)) {
            return "";
        }

        if (is_array($content)) {
            $content = implode(" ", $content);
        }

        $result =  $this->secretary($content, $hash, $isCache);
		
		return $result;
    }

    public function pageFormated($page, $isCache = true) {
        if (is_numeric($page)) {
            $page = App::Model('Page')->findById($page);
        } else if (is_string($page)) {
            $page = App::PageManager()->getData($page);
        }

        if (isset($page['content'])) {
            $hash = "{$page['name']}{$page['id']}";

            return $this->secretary($page['content'], $hash, $isCache);
        } else {
            return "";
        }
    }

    private function secretary($content = "", $hash = "", $isCache = true) {
        $this->cnt = 1;
        if ($isCache && $hash != "" && self::CONTENT_CACHE) {
            $hash = self::CACHE_PAGE_PRE_FIX . $hash;
            if (!$this->hasCache($hash)) {
                return $this->createCache($hash, $this->typeWritter($content));
            } else {
                return $this->readCache($hash);
            }
        } else {
            return $this->typeWritter($content);
        }
    }

    private function typeWritter($content = "", $autoFormated = true) {
		
		if(empty($content)){
			return "";
		}
		
        // First fragmentize the
        // the content by TAG
        $this->Fragmentize($content)
                // Process the content
                ->Processing($autoFormated)
                // Finalize the formated
                // content.
                ->Finaize();

        if (preg_match("/\{\{(.*?)\}\}/i", $this->content) && $this->cnt < self::MAX_ROUND) {
            $this->cnt++;
            return $this->typeWritter($this->content, $autoFormated);
        } else {
            return $this->content;
        }
    }

    private function fragmentize($content) {
        $this->content = preg_split(self::REGEXP_TAGSPLIT, $content);

        return $this;
    }

    private function Processing($autoFormated) {
        foreach ($this->content as $key => $row) {
            if ($key % 2 == 1 && trim($row)) {
                $this->fields = $this->splitInLine($row);
                switch (strtolower($this->fields['type'])) {
                    case 'staticpage' :
                        $this->StaticPage($key);
                        break;
                    case 'hook' :
                        $this->Hook($key);
                        break;
                }
            } else {
                if ($autoFormated) {
                    $this->content[$key] = App::Helper('Utility')->codeFormated($this->content[$key]);
                }
            }
        }

        return $this;
    }

    private function splitInLine($row) {
        $row = preg_split(self::REGEXP_ENTITY, $row);
        $tmp = array();
        for ($kk = 0; $kk < sizeof($row); $kk += 2) {
            $row[$kk + 1] = isset($row[$kk + 1]) ? $row[$kk + 1] : "";
            $row[$kk] = isset($row[$kk]) ? $row[$kk] : "";
            $tmp[$row[$kk]] = trim($row[$kk + 1]);
        }
        return $tmp;
    }

    private function StaticPage($key) {
        $page = App::PageManager()->getData($this->fields[self::NAME]);
        $data = isset($page['content']) ? $page['content'] : "";
        if ($page['contenttype'] == 'Content') {
            $this->replaceData($key, $data);
        } else {
            $this->replacePHPCode($key, $data);
            
        }
    }

    private function Hook($key) {
        $name = isset($this->fields['name']) ? $this->fields['name'] : "UI";
        $action = isset($this->fields['action']) ? $this->fields['action'] : "";
        $peram = isset($this->fields['peram']) ? $this->fields['peram'] : "";

        $data = App::Hook($name)->Render($action, $peram, 0);
        $data = is_array($data) ? implode('', $data) : $data;

        $this->replaceData($key, $data);
    }

    private function finaize() {
        $this->content = implode("", $this->content);
    }

    private function readCache($code = "") {
        return App::Module('Cache')->Read($code);
    }

    private function createCache($code, $content) {
        App::Module('Cache')->Write($code, $content);
        return $content;
    }

    private function hasCache($code = "") {
        return App::Module('Cache')->exists($code);
    }

    private function replaceData($key, $data) {
        $autoformate = isset($this->fields[self::AUTOFORMATE]) ? $this->fields[self::AUTOFORMATE] : self::ON;

        if ($autoformate != self::OFF) {
            $data = App::Helper('Utility')->codeFormated($data);
        }

        $this->content[$key] = $data;
    }

    private function replacePHPCode($key, $data) {
        $this->content[$key] = App::Helper('Utility')->parsePHP($data);
    }

}
