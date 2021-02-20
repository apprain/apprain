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


abstract class appRain_Base_Modules_Html extends appRain_Base_Objects
{

    /**
     *    - Generate Text Input element
     */
    public function inputTag($name = NULL, $value = NULL, $options = NULL)
    {
        return '<input type="text" name="' . $name . '" value="' . $value . '" ' . $this->options2str($options) . '/>';
    }

    /**
     *    - Generate Textarea
     */
    public function textareaTag($name = NULL, $value = NULL, $options = NULL)
    {
        return '<textarea name="' . $name . '" ' . $this->options2str($options) . '>' . $value . "</textarea>";
    }

    /**
     *    - Generate Hidden Input element
     */
    public function hiddenTag($name = NULL, $value = NULL, $options = NULL)
    {
        return '<input type="hidden" name="' . $name . '" value="' . $value . '" ' . $this->options2str($options) . '/>';
    }


    /**
     *    - Generate Text Button element
     */
    public function buttonTag($name = NULL, $value = NULL, $options = NULL)
    {
        return "<input type=\"button\" name=\"{$name}\" {$this->options2str($options)} value=\"{$value}\" />";
    }


    /**
     *    - Generate Text Input element
     */
    public function submitTag($name = NULL, $value = NULL, $options = NULL)
    {
        return '<input type="submit" name="' . $name . '" value="' . $value . '" ' . $this->options2str($options) . '/>';
    }

    /**
     *    - Generate Password field
     */
    public function passwordTag($name = NULL, $value = NULL, $options = NULL)
    {
        return '<input type="password" name="' . $name . '" value="' . $value . '" ' . $this->options2str($options) . '/>';
    }

    /**
     *    - Generate File tag
     */
    public function fileTag($name = NULL, $value = NULL, $options = NULL)
    {
        return '<input type="file" name="' . $name . '" value="' . $value . '" ' . $this->options2str($options) . '/>';
    }


    /**
     *    - Generate Image Button
     */
    public function imageButtonTag($name = NULL, $value = NULL, $options = NULL)
    {
        return '<input type="image" name="' . $name . '" src="' . $value . '" ' . $this->options2str($options) . '/>';
    }

    /**
     * Radio button
     */
    public function radioTag($name = NULL, $data_arr = NULL, $selected = NULL, $html_options = NULL, $options = NULL)
    {
        $pt_str = isset($html_options) ? $this->options2str($html_options) : '';
        $options["html_wrapper"] = isset($options["html_wrapper"]) ? $options["html_wrapper"] : NULL;

        $id_pad = isset($html_options['id']) ? $html_options['id'] : "rdo" . App::Module('Cryptography')->randomNumber();
        $element = "";

        if (is_array($data_arr)) {
            $padding = 0;
            foreach ($data_arr as $key => $val) {
                $id = (!$padding) ? "{$id_pad}" : "{$id_pad}_{$padding}";
                if ($key == $selected) {
                    $e = "<input  name=\"$name\" type=\"radio\" id=\"{$id}\" checked=\"checked\" value=\"$key\" $pt_str /> <label for=\"{$id}\">{$val}</label> ";
                }
                else {
                    $e = "<input  name=\"$name\" type=\"radio\" id=\"{$id}\" value=\"$key\" $pt_str /> <label for=\"{$id}\">{$val}</label> ";
                }

                if (!isset($options["html_wrapper"])) $element .= $e;
                else if ($options["html_wrapper"] == "br") $element .= $e . "<br />";
                else $element .= $this->get_tag($options["html_wrapper"], $e);

                $padding++;
            }
        }
        else {
            $element = "<input  name=\"$name\" type=\"radio\" value=\"$data_arr\" $pt_str />";
        }

        return $element;
    }

    /*
     * Retrun a check box group
     */
    public function checkboxTag($name = NULL, $data_arr = NULL, $selected = NULL, $html_options = NULL, $options = NULL)
    {

        $select_arr = (is_array($selected)) ? $selected : explode(",", $selected);
        $pt_str = isset($html_options) ? $this->options2str($html_options) : '';
        $element = "";

        $options["html_wrapper"] = isset($options["html_wrapper"]) ? $options["html_wrapper"] : NULL;
        $id_pad = isset($html_options['id']) ? $html_options['id'] : "chk" . App::Module('Cryptography')->randomNumber();

        if (is_array($data_arr)) {
            $padding = 0;
            foreach ($data_arr as $key => $val) {
                $id = (!$padding) ? "{$id_pad}" : "{$id_pad}_{$padding}";
                if (in_array($key, $select_arr)) {
                    $e = "<input  name=\"$name\" type=\"checkbox\" id=\"{$id}\" checked=\"checked\" value=\"$key\" $pt_str /> <label for=\"{$id}\">{$val}</label> ";
                }
                else {
                    $e = "<input  name=\"$name\" type=\"checkbox\" id=\"{$id}\" value=\"$key\" $pt_str /> <label for=\"{$id}\">{$val}</label> ";
                }

                if (!isset($options["html_wrapper"])) $element .= $e;
                else if ($options["html_wrapper"] == "br") $element .= $e . "<br />";
                else $element .= $this->get_tag($options["html_wrapper"], $e);

                $padding++;
            }
        }
        else {
            $element = "<input  name=\"$name\" type=\"checkbox\" value=\"$data_arr\" $pt_str />";
        }

        return $element;
    }

    /**
     *    - Generate Dropdown box with give array
     */
    public function selectTag($name = NULL, $data_arr = NULL, $selected = NULL, $options = NULL, $parameter = NULL)
    {

        $pt_str = isset($options) ? $this->options2str($options) : '';
        $size = isset($options['size']) ? $options['size'] : 1;
		
        $name = ($size > 1) ? "{$name}[]" : $name;
		
		if(isset($parameter['title'])){
			$element = "<select name=\"{$name}\" {$pt_str} ><option value=\"\">{$parameter['title']}</option>";
		}
		else{
		
			$offblank = isset($parameter['off_blank']) ? $parameter['off_blank'] : 'No';
			
			if($offblank == 'No'){
				$element = "<select name=\"{$name}\" {$pt_str} ><option value=\"\"></option>";
			}
			else{
				$element = "<select name=\"{$name}\" {$pt_str} >";
			}
		}
	
        foreach ($data_arr as $key => $val) {
            if (in_array($key, explode(',', $selected))) {
                $element .= "<option selected=\"selected\" value=\"{$key}\">{$val}</option>";
            }
            else {
                $element .= "<option value=\"{$key}\">{$val}</option>";
            }
        }

        $element .= "</select>";

        return $element;
    }


    /*
     * Generate a hyper link button group
     */
    public function linkTag($src = "", $link_text = NULL, $options = NULL)
    {
        $src = ($src != "") ? $src : "javascript:void(0)";
        $pt_str = isset($options) ? $this->options2str($options) : '';
        return '<a href="' . $src . '" ' . $pt_str . '>' . $link_text . '</a>';
    }

    /**
     * - Generate a dropdown of given range of number
     */
    public function numberTag($name = NULL, $data_arr = NULL, $selected = NULL, $options = NULL)
    {
        $tmp_arr = array();
        for ($rbl = $data_arr['Start']; $rbl <= $data_arr['End']; $rbl++) {
            $tmp_arr[$rbl] = $rbl;
        }

        return $this->selectTag($name, $tmp_arr, $selected, $options);
    }

    /**
     *    This public function return a <li> node with given variable
     *    This is basically to generate from view follwoing Liquid HTML Model
     */
    public function get_from_row($label = NULL, $val = NULL, $options = NULL, $hints = NULL)
    {
        $pt_str = isset($options) ? $this->options2str($options) : '';

        if (isset($label) && !isset($val)) {
            $val = $label;
            unset($label);

        }

        $hints = isset($hints) ? "<span class=\"hints\">$hints</span><br class='clearboth' />" : '';
        $label = isset($label) ? "<label>$label</label>" : '';
        $val = isset($val) ? "<span>{$hints} {$val}</span>" : '';

        return "<li $pt_str>$label $val</li>";

    }

    /**
     *    Geenrate html Tag
     */
    public function get_tag($tag = NULL, $options = NULL, $innerHtml = NULL)
    {
        $str = is_array($options) ? $this->options2str($options) : '';
        $innerHtml = (!is_array($options) && $options != NULL && $innerHtml == NULL) ? $options : $innerHtml;
        if ($innerHtml == '/') {
            return "<$tag $str />";
        }
        else    return isset($innerHtml) ? "<$tag $str>$innerHtml</$tag>" : "<$tag $str>";

    }

    public function getTag($tag = NULL, $options = NULL, $innerHtml = NULL)
    {
        return $this->get_tag($tag, $options, $innerHtml);
    }


    /**
     *    - To serilize the HTML options in string
     */
    public function options2str($options = NULL)
    {
        $opt = "";
        if (is_array($options) && !empty($options)) {
            foreach ($options as $key => $val) {
                $opt .= $key . '="' . $val . '" ';
            }
        }
        return " " . $opt;
    }

    /**
     *    Generate country list
     */
    public function countryTag($name = NULL, $value = NULL, $options = NULL, $parameter = NULL)
    {
        $c = App::Load("Helper/Utility")->get_common_var('country');
        $parameter['title'] = isset($parameter['title']) ? $parameter['title'] : "Select Country";
        return $this->selectTag($name, $c, $value, $options, $parameter);
    }

    /**
     *    Generate a Date picker driven my mootools
     */
    public function dateTag($name = NULL, $value = NULL, $options = NULL)
    {
        $id = substr($name, strrpos($name, "[") + 1, (strlen($name)));
        $id = substr($id, 0, strrpos($id, "]"));
        $formate = isset($options['formate']) ? $options['formate'] : 'Y-ds-m-ds-d';
		if(!isset($options['class'])){
			$options['class'] = 'date';
		}
		else{
			$options['class'] .= ' date';
		}
        return '<input type="text" id="' . $id . '" name="' . $name . '" value="' . $value . '" ' . $this->options2str($options) . '/>';

    }

    /**
     *    - This public function to put images and at render
     */
    public function imageTag($name = NULL, $value = NULL, $options = NULL)
    {
        return '<textarea name="' . $name . '" ' . $this->options2str($options) . '>' . $value . "</textarea>";
    }


    /**
     *    - Javascript Color Picker
     **/
    public function colorpickerTag($name = NULL, $value = NULL, $options = NULL)
    {
        $options['class'] = isset($options['class']) ? $options['class'] . " apprain_color" : "apprain_color";
        return '<input type="text" name="' . $name . '" value="' . $value . '" ' . $this->options2str($options) . '/>';
    }

    /**
     *    - Generate Text Input element
     */
    /*public function inputbtnTag( $name = NULL, $src =NULL, $value = NULL , $options = NULL)
    {
        return '<input type="image" name="' . $name .'"  src="' . $src .'" value="' . $value . '" ' . $this->options2str( $options ) . '/>';
    }//public function inputTag( $name = NULL, $value = NULL , $options = NULL)*/

    /**
     *    - Generate Dynamic image
     */
    public function imgDTag($src = "", $width = "/80/fix", $options = NULL)
    {
        return '<img src="' . App::Load("Helper/Config")->baseurl('/') . 'common/get_image/' . base64_encode($src) . $width . '" ' . $this->options2str($options) . ' />';
    }

    /**
     * This public function can be use to direct image display or image from imagedirectory uploaded by admin
     * echo $this->imgTag('logo.gif',array('mode' => 'imagemanager'),array("class"=>"logo","alt"=>"Apprain Official Website"));
     */
    public function imgTag($src = NULL, $options = NULL, $html_potions = NULL)
    {
        $mode = isset($options['mode']) ? $options['mode'] : '';

        /* Generate html options  */
        $html_options = $this->options2str($html_potions);

        if ($mode == "imagemanager" || $mode == "filemanager") {
            //$filemanager_path = App::Helper('Config')->get('filemanager_base_dir');

            return '<img src="' . App::Helper('Config')->filemanagerurl("/{$src}") . '"' . $html_options . ' />';
        }
        else {
            return '<img src="' . $src . '"' . $html_options . ' />';
        }
    }

    public function capachaTag($name = NULL, $options = NULL)
    {
        $str = isset($options['bk_color']) ? $options['bk_color'] : "#FFFFFF";
        $str .= "," . (isset($options['font_color']) ? $options['font_color'] : "#CCCCCC");
        return $this->imgTag(App::Helper('Config')->baseurl("/common/get_capacha/" . base64_encode($name) . "/" . base64_encode($str)));
    }

    public function dateDDTag($name = NULL, $value = NULL, $selected = "", $options = NULL)
    {
        $format = isset($options['format']) ? $options['format'] : 'd-m-y';
        $format_arr = explode('-', $format);
        $munites = array();
        for ($i = 0; $i <= 60; $i++) {
            $munites[$i] = $i;
        }

        $years = array();
        $value['Start'] = isset($value['Start']) ? $value['Start'] : (App::Helper('Date')->getdate('Y') - 10);
        $value['End'] = isset($value['End']) ? $value['End'] : (App::Helper('Date')->getdate('Y') + 10);

        for($i = $value['Start']; $i <= $value['End']; $i++){
            $years[$i] = $i;
        }

        $selected = ($selected != "" && is_string($selected)) ? $selected : App::Helper('Date')->getdate('Y-m-d');

        $t = explode(" ", $selected);
        $arr1 = explode("-", $t[0]);

        $str = "";
        foreach ($format_arr as $key => $val) {
            switch (strtolower($val)) {
                case 'y':
					$htmOpt = isset($options['y_htmlopts']) ? $options['y_htmlopts'] : array();
                    $str .= $this->selectTag($name . "[year]", $years, $arr1[0],$htmOpt);
                    break;
                case 'm':
					$htmOpt = isset($options['m_htmlopts']) ? $options['m_htmlopts'] : array();
                    $str .= $this->selectTag($name . "[month]", App::Load("Helper/Utility")->get_common_var('months'), $arr1[1],$htmOpt);
                    break;
                case 'd' :
					$htmOpt = isset($options['d_htmlopts']) ? $options['d_htmlopts'] : array();
                    $str .= $this->selectTag($name . "[day]", App::Load("Helper/Utility")->get_common_var('days'), $arr1[2],$htmOpt);
                    break;

            }
        }
        return $str;
    }

    public function ccExpireDate($name = NULL, $selected = "", $value = NULL, $options = NULL)
    {
        $years = Array();
        $value['Start'] = isset($value['Start']) ? $value['Start'] : (App::Helper('Date')->getdate('Y'));
        $value['End'] = isset($value['End']) ? $value['End'] : (App::Helper('Date')->getdate('Y') + 10);
        $options['id'] = isset($options['id']) ? $options['id'] : "cc";

        $years[''] = 'Expire year';
        for ($i = $value['Start']; $i <= $value['End']; $i++) {
            $years[$i] = $i;
        }

        $selected = ($selected != "") ? $selected : "cc_year-cc_month";

        $arr1 = explode("-", $selected);

        $str = "";
        $month = App::Load("Helper/Utility")->get_common_var('months');
        $month[''] = 'Expire Month';

        $tmp = $options['id'];
        $options['id'] = $tmp . '_month';
        $str .= $this->selectTag($name . "[month]", $month, $arr1[1], $options);
        $str .= "";
        $options['id'] = $tmp . '_year';
        $str .= ' ' . $this->selectTag($name . "[year]", $years, $arr1[0], $options);

        return $str;
    }

    /**
    - Date Time Box
     */
    public function dateTimeTag($name = NULL, $selected = "", $value = NULL)
    {

        $munites = array();
        for ($i = 0; $i < 60; $i++) {
            $x = (strlen($i) == 1) ? "0$i" : $i;
            $munites[$i] = $x;
        }

        $value['Start'] = isset($value['Start']) ? $value['Start'] : App::Helper('Date')->getdate('Y')-10;
        $value['End'] = isset($value['End']) ? $value['End'] : App::Helper('Date')->getdate('Y')+10;
        $years = array();
        for ($i = $value['Start']; $i <= $value['End']; $i++) {
            $years[$i] = $i;
        }

        $t = strtotime(($selected != "") ? $selected : $this->get_date("Y-m-d H:i:s"));

        $str = "";
        $str .= $this->selectTag($name . "[day]", App::Load("Helper/Utility")->get_common_var('days'), App::Helper('Date')->getdate('d', $t));
        $str .= "";
        $str .= $this->selectTag($name . "[month]", App::Load("Helper/Utility")->get_common_var('months'), App::Helper('Date')->getdate('m', $t));
        $str .= "";
        $str .= $this->selectTag($name . "[year]", $years, App::Helper('Date')->getdate('Y', $t));
        $str .= " ";
        $str .= $this->selectTag($name . "[hour]", App::Load("Helper/Utility")->get_common_var('hours'), App::Helper('Date')->getdate('H', $t));
        $str .= "";
        $str .= $this->selectTag($name . "[munite]", $munites, App::Helper('Date')->getdate('i', $t));
        $str .= "";
        $str .= $this->selectTag($name . "[second]", $munites, date('s', $t));

        return $str;
    }

    /*
    *	Add Javascript
    */
    public function add_javascript($src)
    {
        if (strstr($src, "//")) {
            return "\n" . '<script type="text/javascript" src="' . $src . '"></script>';
        }
        else {
            return "\n" . '<script type="text/javascript" src="' . App::Load("Helper/Config")->baseurl("$src") . '"></script>';
        }

    }

    public function addJavaScript($src)
    {
        return $this->add_javascript($src);
    }

    /*
     *	Add CSS
     */
    public function add_css($src, $media = 'all')
    {
        if (strstr($src, "//")) {
            return '<link rel="stylesheet" type="text/css" href="' . $src . '" media="' . $media . '" />';
        }
        else {
            return '<link rel="stylesheet" type="text/css" href="' . App::Load("Helper/Config")->baseurl("$src") . '" media="' . $media . '" />';
        }
    }

    public function addCSS($src, $media = 'all')
    {
        return $this->add_css($src, $media);
    }

    public function selectDefaultValue($data = NULL, $key = NULL, $default = NULL)
    {
        if(isset($data[$key])){
			switch($data[$key]){
				case '0000-00-00':
					return $default;
					break;
				default:
					return $data[$key];
			};
		}
		else{
			return $default;
		}
    }

    /**
     * Create HTML Input Tag for a Model
     *
     * @param $name String
     * @param $model String
     * @param $value String
     * @param $parameter Array()
     * @param $options Array()
     */
    public function modelTag($name = NULL, $Model = NULL, $value = NULL, $parameter = NULL, $options = NULL)
    {
        /*
         * Define the root. We can set parent start as perametre so that it can start form any parent
         */
        $inputType = isset($parameter['inputType']) ? $parameter['inputType'] : "selectTag";
        $condition = isset($parameter['condition']) ? $parameter['condition'] : "1=1";
        $name = ($inputType == "checkboxTag") ? $name . "[checkbox][]" : $name;
        $parameter['key'] = isset($parameter['key']) ? $parameter['key'] : "id";
        $parameter['val'] = isset($parameter['val']) ? $parameter['val'] : "id";

        /*
         * Requesting for data
         */
        $tmp = App::Model($Model)->findAll($condition);

        /*
         * Generate a 1D array for dropdown list
         */

        $data_arr = App::Load("Helper/Utility")->get_1d_arr($tmp['data'], $parameter['key'], $parameter['val']);

        /*
        * Return the HTML Deopdown list
        */
        return App::Load("Helper/Html")->$inputType($name, $data_arr, $value, $options, $parameter);
    }
	
    public function helpTag($id=null,$linkText=null){
		if(app::__def()->sysConfig('INLINE_HELP') == 'Enabled'){
			if(isset($linkText)){
				return ' <a class="apphelp" title="Click to view Help" id="' . $id . '" href="javascript:void(0)">' . $linkText . '</a>';
			}
			else{
				return ' (<a class="apphelp" title="Click to view Help" id="' . $id . '" href="javascript:void(0)">?</a>)';
			}
		}
	}		

}