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
/*
   App::load("Module/Language")->register('lipsum');
   App::load("Module/Language")->getcode();
   App::load("Module/Language")->get('key');

*/
/**
 * Class to manage cookie
 *
 */
class appRain_Base_Modules_Language extends appRain_Base_Objects
{
    public $code = 'default';
    private $LanguageSingleToneCache = array();
    private $cache_path;
    private $ext = '.xml';
    private $cache_ext = 'arbt';

    public function __construct()
    {
        $this->code = $this->getcode();
    }

    public function register($code = 'default')
    {
        App::Load("Module/Session")->write('lang-code', $code);

        return $this;
    }

    public function getcode()
    {
        $code = App::Load("Module/Session")->read('lang-code');
        return ($code != "") ? $code : $this->getDefaultcode();

    }

    public function getDefaultcode()
    {
        $language = App::Helper('Config')->siteInfo('language');
        $this->code = (isset($language) && !is_array($language)) ? $language : $this->code;

        return $this->code;
    }

    public function get($_key = NULl)
    {
        if (isset($_key)) {
            return $this->fetch($_key);

        }

        return NULL;
    }

    private function fetch($key = '')
    {
        if (!is_string($key)) {
            return "";
        }

        if (empty($this->LanguageSingleToneCache)) {
            $this->cache_path = LANGUAGE_CACHE_PATH;

            // Read Cache
            App::Load("Module/Cache")->path = LANGUAGE_CACHE_PATH;
            $definition = (App::Load("Module/Cache")->exists($this->code)) ? App::Load("Module/Cache")->read($this->code) : $this->parseLangDefinition();

            // Set Single tone cache
            $this->LanguageSingleToneCache = $definition;

            // Create Physical cache
            if (app::__def()->sysConfig('LANGUAGE_CACHE')) {
                App::Load("Module/Cache")->replace = true;
                App::Load("Module/Cache")->write($this->code, $definition);
            }
        }

        return isset($this->LanguageSingleToneCache[strtolower($key)]) ? $this->LanguageSingleToneCache[strtolower($key)] : $key;
    }

    private function parseLangDefinition()
    {
        $file_path = $this->lanuagePaths($this->code) . DS . $this->code . $this->ext;

        //Halt if difinition file not found
        if (!file_exists($file_path)) {
            pre("Language file missing  <br /> #Path: {$file_path}");
        }

        $_data = array();
        $dom = new DOMDocument();
        $dom->load($file_path);

        $langs = $dom->getElementsByTagName('langs')->item(0)->getElementsByTagName('lang');

        foreach ($langs as $val) {
            $_data[strtolower($val->getElementsByTagName('key')->item(0)->nodeValue)] = $val->getElementsByTagName('val')->item(0)->nodeValue;
        }

        return $_data;
    }

    public function setDefault($code = null)
    {
        if (isset($code)) {
            App::Helper('Config')->setSiteInfo('language', $code);
        }
    }

    public function lanuagePaths($code = null)
    {
        $hookResource = App::Module('Hook')->getHookResouce('Language', 'register_definition');

        $paths = Array(LANGUAGE_PATH);
        if (!empty($hookResource)) {
            foreach ($hookResource as $node) {
                if (($class = $node['resource'][0]) != "" && ($method = $node['resource'][1]) != "") {
                    $defs = App::__obj($class)->$method(null);
                    foreach ($defs as $def) {
                        if (isset($code) && $code == $def['code']) return dirname($def['path']);
                        else $paths[] = dirname($def['path']);
                    }

                }
            }
        }
        return isset($code) ? $paths[0] : $paths;
    }
}
