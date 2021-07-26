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
 * @copyright  Copyright (c) 2010 appRain, Inc. (http://www.apprain.org)
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
 * http ://www.apprain.org/documents
 */

class appRain_Base_Modules_Toolbar extends appRain_Base_Objects
{
    private $_buttons = null;
    const BUTTON_PADDING = "btn";
    private $opts = null;

    /**
     * Generate List of buttons
     *
     * Function execute in a singleton pattern
     */
    private function init_buttons()
    {
        if ($this->__data) {
            foreach ($this->__data as $key => $value) {
                if (substr($key, 0, 3) == self::BUTTON_PADDING) {
                    $this->prepareHTML($key, $value);
                }
            }
        }
    }

    private function prepareHTML($fx, $args)
    {
        $this->_buttons[] = $this->$fx($args);
    }

    private function btnsave($args = null)
    {
        return App::Helper('Html')
            ->submitTag(
            'Button[button_save]',
            $this->__(
                (isset($args['name']) ? $args['name'] : 'Save')
            ),
            Array(
                'title' => $this->__('Save Entry')
            )
        );
    }
	
	private function btnsubmit($args = null)
    {
        return App::Helper('Html')
            ->submitTag(
            'Button[button_submit]',
            $this->__(
                (isset($args['name']) ? $args['name'] : 'Submit')
            ),
            Array(
                'title' => $this->__('Submit Entry')
            )
        );
    }

    private function btnsaveandupdate($args = null)
    {
        return App::Helper('Html')
            ->submitTag(
            'Button[button_save_and_update]',
            $this->__(
                (isset($args['name']) ? $args['name'] : 'Save and Update')
            ),
            Array(
                'title' => $this->__('Save and Update')
            )
        );
    }
	
	private function btnsaveandadd($args = null)
    {
        return App::Helper('Html')
            ->submitTag(
            'Button[button_save_and_add]',
            $this->__(
                (isset($args['name']) ? $args['name'] : 'Save and New')
            ),
            Array(
                'title' => $this->__('Save and New')
            )
        );
    }


    private function btndelete($args = null)
    {
        $name = 'Delete';
        if (isset($args['name'])) {
            $name = $args['name'];
            unset($args['name']);
        }

        $args['title'] = isset($args['title']) ? $args['title'] : "Delete";
        $args['class'] = isset($args['class']) ? "{$args['title']} _deletebtn" : "_deletebtn";

        return App::Helper('Html')->submitTag('Button[button_delete]', $this->__($name), $args);
    }


    private function btnfilemanager($args = null)
    {
        return App::Helper('Html')
            ->buttonTag(
            'Button[filemanager]',
            $this->__(
                (isset($args['name']) ? $args['name'] : 'File Manager')
            ),
            Array(
                'title' => $this->__('File Manager'),
                "onclick" => "var win = window.open('" . App::Helper('Config')->baseurl('/admin/filemanager') . "','Window1','menubar=no,toolbar=no,scrollbars=yes');")
        );
    }

    private function btnback($args = null)
    {
        return App::load("Helper/Html")
            ->buttonTag("Button[Back]",
            $this->__(
                (isset($args['name']) ? $args['name'] : "<< Back")
            ),
            array(
                "onclick" => "javascript:history.go(-1)")
        );
    }
	
    private function btnNext($args = null)
    {
        return App::Helper('Html')
            ->submitTag(
            'Button[button_next]',
            $this->__(
                (isset($args['name']) ? $args['name'] : 'Next')
            ),
            Array(
                'title' => $this->__('Next')
            )
        );
    }
	
    private function btntoggle($args = null)
    {
        return App::load("Helper/Html")
            ->buttonTag(
            "Button[Toggle]",
            $this->__(
                (isset($args['name']) ? $args['name'] : "Toggle")
            ),
            array(
                "class" => "view_hidden_content"
            )
        );
    }

    private function BtnComponentSrcBox()
    {
        $Config = App::Config();
        $htmlHelper = App::Helper('Html');
        $src_key = isset($_GET['src_key']) ? $_GET['src_key'] : '';
        $html = $htmlHelper->getTag('form', array('method' => 'get', 'action' => $Config->baseurl("/developer/componentsonline")));
        $html .= $htmlHelper->getTag('div', array('class' => 'left'), '<div class="button">' . App::load("Helper/Html")->inputTag("src_key", $src_key) . ' ' . $htmlHelper->submitTag("", "Search") . '</div> &nbsp;&nbsp;');
        $html .= $htmlHelper->getTag('/form');
        return array('box' => $html);
    }

    private function BtnInformationSetViewSrcBox()
    {
        $args = func_get_args();
        $definition = app::__def()->getInformationSetDefinition($args[0]['type']);

        $categoryTypesarr = array();
        $key_arr = array();
        foreach ($definition['fields'] as $key => $val) {
            if ($val['type'] == 'categoryTag') {
                $categoryTypesarr[$key] = $val['category_type'];
            }
            $key_arr[$key] = $this->__($val['title']);
        }

        $Config = $args[0]['config'];
        $src_key = $args[0]['src_key'];
        $src_cat = $args[0]['src_cat'];
        $src_field = $args[0]['src_field'];

        $htmlHelper = App::Helper('Html');
        $html = $htmlHelper->getTag('form', array('method' => 'get', 'action' => $Config->baseurl("/information/manage/{$args[0]['type']}")));
        $html .= $htmlHelper->getTag('div', array('class' => 'left'), '<div class="button">' . App::load("Helper/Html")->inputTag("src_key", $src_key) . '  ' . $htmlHelper->selectTag("src_field", $key_arr, $src_field, array('style' => 'padding:3px;width:150px')) . '  ' . App::categorySet()->GroupTag("src_cat", $categoryTypesarr, $src_cat, array('style' => 'padding:3px;width:150px')) . ' ' . $htmlHelper->submitTag("", "Search") . '</div> &nbsp;&nbsp;');
        $html .= $htmlHelper->getTag('/form');

        return array('box' => $html);
    }

    private function btnFilemanagerSrcBox($srcstr = "")
    {

        $html = '<form method="post">
        <input type="text" name="data[FileManager][search]" value="' . $srcstr . '" />
        <div class="button" style="float:right"><input type="submit" value="Search" /></div>
        </form>';

        return array('box' => $html);
    }

    private function btnInformationSetExportbox()
    {
        $args = func_get_args();
        $Config = $args[0]['config'];
        $htmlHelper = App::Helper('Html');
        $html = "";
        $html = $htmlHelper->get_tag('form', array('method' => 'post', 'action' => $Config->baseurl("/information/export/{$args[0]['type']}"), 'style' => 'float:right'));
        $html .= $htmlHelper->get_tag('div', array('class' => 'right'), App::load("Helper/Html")->selectTag("data[Export][type]", Array('CSV' => 'CSV', 'XML' => 'XML'), 'CSV', Array('off_blank' => 'Yes')) . App::load("Helper/Html")->submitTag("data[Export][request]", "Export"));
        $html .= $htmlHelper->get_tag('/form');

        return array('box' => $html);
    }

    private function isTop()
    {
        return ($this->getTitle()) ? true : false;
    }

    public function btnCustomHTML()
    {
        $args = func_get_args();
        return $args[0];
    }

    private function getWrappered($buttonHtml = "", $boxHtml = "")
    {
        switch ($this->isTop()) {
            case true:
                $html = '<div class="box"><div class="title"><h5>' . $this->__($this->getTitle()) . '</h5>
						<div class="search">
							<div class="input" style="float:left">
								' . $boxHtml . '
							</div>
							<div class="button">
								<!--input type="submit" value="Search" name="submit" class="ui-button ui-widget ui-state-default ui-corner-all" role="button" aria-disabled="false" -->
								' . $buttonHtml . '
							</div>
						</div>

					</div>';
                $html .= '<div class="form">
								<div class="fields">';
                break;
            default :
                if ($this->getFormJustified()) {
                    $html = '<div class="buttons"  style="margin-left:22%">';
                }
                else {
                    $html = '<div class="buttons" style="margin-left:0px">';
                }
                $html .= $buttonHtml . $boxHtml;
                $html .= '</div>';
                $html .= '</div></div></div>';
                break;
        }

        return $html;
    }

    private function renderHTML($html = "")
    {
        $buttons = array();
        $boxes = array();
        if (!empty($this->_buttons)) {
            foreach ($this->_buttons as $button) {
                if (is_string($button)) {
                    if ($button != '') $buttons[] = $button;
                }
                else {
                    if (isset($button['box'])) $boxes[] = $button['box'];
                }

            }
        }
        return $this->getWrappered(
            implode(' ', $buttons),
            implode(' ', $boxes)
        );
    }

    public function init_pre_callbacks()
    {
        $hookResource = App::Module('Hook')->getHookResouce('Toolbar', 'button_at_start');

        if (!empty($hookResource)) {
            foreach ($hookResource as $node) {
                if (($class = $node['resource'][0]) != "" && ($method = $node['resource'][1]) != "") {
                    $this->_buttons[] = App::__obj($class)->$method($this->opts);
                }
            }
        }
    }

    public function init_post_callbacks()
    {
        $hookResource = App::Module('Hook')->getHookResouce('Toolbar', 'button_at_end');

        if (!empty($hookResource)) {
            foreach ($hookResource as $node) {
                if (($class = $node['resource'][0]) != "" && ($method = $node['resource'][1]) != "") {
                    $this->_buttons[] = App::__obj($class)->$method($this->opts);
                }
            }
        }
    }

    public function clear()
    {
        $this->__data = null;
        $this->_buttons = null;
    }

    public function render($opts)
    {
        $this->opts = $opts;
        $this->init_pre_callbacks();
        $this->init_buttons();
        $this->init_post_callbacks();
        echo $this->renderHTML();
        $this->clear();
    }
}
