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

abstract class appRain_Base_Modules_Utility extends appRain_Base_Objects
{
    public function get_common_var($key = NULL)
    {
        $country = array('AF' => 'Afghanistan', 'AL' => 'Albania', 'DZ' => 'Algeria', 'AS' => 'American Samoa', 'AD' => 'Andorra', 'AO' => 'Angola', 'AI' => 'Anguilla', 'AQ' => 'Antarctica', 'AG' => 'Antigua and Barbuda', 'AR' => 'Argentina', 'AM' => 'Armenia', 'AW' => 'Aruba', 'AU' => 'Australia', 'AT' => 'Austria', 'AZ' => 'Azerbaijan', 'BS' => 'Bahamas', 'BH' => 'Bahrain', 'BD' => $this->__('Bangladesh'), 'BB' => 'Barbados', 'BY' => 'Belarus', 'BE' => 'Belgium', 'BZ' => 'Belize', 'BJ' => 'Benin', 'BM' => 'Bermuda', 'BT' => 'Bhutan', 'BO' => 'Bolivia', 'BA' => 'Bosnia and Herzegowina', 'BW' => 'Botswana', 'BV' => 'Bouvet Island', 'BR' => 'Brazil', 'IO' => 'British Indian Ocean', 'BN' => 'Brunei Darussalam', 'BG' => 'Bulgaria', 'BF' => 'Burkina Faso', 'BI' => 'Burundi', 'KH' => 'Cambodia', 'CM' => 'Cameroon', 'CA' => 'Canada', 'CV' => 'Cape Verde', 'KY' => 'Cayman Islands', 'CF' => 'Central African Republic', 'TD' => 'Chad', 'CL' => 'Chile', 'CN' => 'China', 'CX' => 'Christmas Island', 'CS' => 'Cocos Islands', 'CO' => 'Colombia', 'KM' => 'Comoros', 'CG' => 'Congo (Dem Rep of the)', 'CK' => 'Cook islands', 'CR' => 'Costa Rica', 'CI' => 'Cote d Ivoire', 'HR' => 'Croatia', 'CU' => 'Cuba', 'CC' => 'Curaco', 'CY' => 'Cyprus', 'CZ' => 'Czech Republic', 'DK' => 'Denmark', 'DJ' => 'Djibouti', 'DM' => 'Dominica', 'DO' => 'Dominican Republic', 'TP' => 'East Timor', 'EC' => 'Ecuador', 'EG' => 'Egypt', 'SV' => 'El Salvador', 'GQ' => 'Equatorial Guinea', 'ER' => 'Eritrea', 'EE' => 'Estonia', 'ET' => 'Ethiopia', 'FK' => 'Falkland Islands', 'FO' => 'Faroe Islands', 'FJ' => 'Fiji', 'FI' => 'Finland', 'FR' => 'France', 'GF' => 'French Guiana', 'PF' => 'French Polynesia', 'FT' => 'French Southern Terr.', 'GA' => 'Gabon', 'GM' => 'Gambia', 'GE' => 'Georgia', 'DE' => 'Germany', 'GH' => 'Ghana', 'GI' => 'Gibraltar', 'GR' => 'Greece', 'GL' => 'Greenland', 'GD' => 'Grenada', 'GP' => 'Guadeloupe', 'GU' => 'Guam', 'GT' => 'Guatemala', 'GN' => 'Guinea', 'GW' => 'Guinea-Bissau', 'GY' => 'Guyana', 'HT' => 'Haiti', 'HE' => 'Heard and McD. Isl.', 'HN' => 'Honduras', 'HK' => 'Hong Kong', 'HU' => 'Hungary', 'IS' => 'Iceland', 'IN' => 'India', 'ID' => 'Indonesia', 'IR' => 'Iran', 'IQ' => 'Iraq', 'IE' => 'Ireland', 'IL' => 'Israel', 'IT' => 'Italy', 'JM' => 'Jamaica', 'JP' => 'Japan', 'JO' => 'Jordan', 'KZ' => 'Kazakhstan', 'KE' => 'Kenya', 'KI' => 'Kiribati', 'KP' => 'Korea', 'KO' => 'Kosovo', 'KW' => 'Kuwait', 'KG' => 'Kyrgyzstan', 'LO' => 'Laos', 'LV' => 'Latvia', 'LB' => 'Lebanon', 'LS' => 'Lesotho', 'LR' => 'Liberia', 'LY' => 'Libyan Arab Jamahiriya', 'LI' => 'Liechtenstein', 'LT' => 'Lithuania', 'LU' => 'Luxembourg', 'MO' => 'Macau', 'MK' => 'Macedonia', 'MG' => 'Madagascar', 'MW' => 'Malawi', 'MY' => 'Malaysia', 'MV' => 'Maldives', 'ML' => 'Mali', 'MT' => 'Malta', 'MH' => 'Marshall Islands', 'MQ' => 'Martinique', 'MR' => 'Mauritania', 'MU' => 'Mauritius', 'YT' => 'Mayotte', 'MX' => 'Mexico', 'MI' => 'Micronesia', 'MD' => 'Moldova', 'MC' => 'Monaco', 'MN' => 'Mongolia', 'ME' => 'Montenegro', 'MS' => 'Montserrat', 'MA' => 'Morocco', 'MZ' => 'Mozambique', 'MM' => 'Myanmar', 'NA' => 'Namibia', 'NR' => 'Nauru', 'NP' => 'Nepal', 'NL' => 'Netherlands', 'AN' => 'Netherlands Antilles', 'NC' => 'New Caledonia', 'NZ' => 'New Zealand', 'NI' => 'Nicaragua', 'NE' => 'Niger', 'NG' => 'Nigeria', 'NU' => 'Niue', 'NF' => 'Norfolk Island', 'MP' => 'Northern Mariana Islands', 'NO' => 'Norway', 'OM' => 'Oman', 'PK' => 'Pakistan', 'PW' => 'Palau', 'PA' => 'Panama', 'PG' => 'Papua New Guinea', 'PU' => 'Paraguay', 'PE' => 'Peru', 'PH' => 'Philippines', 'PN' => 'Pitcairn', 'PL' => 'Poland', 'PT' => 'Portugal', 'PR' => 'Puerto Rico', 'QA' => 'Qatar', 'RE' => 'Reunion', 'RO' => 'Romania', 'RU' => 'Russian Federation', 'RW' => 'Rwanda', 'SH' => 'Saint Helena', 'KN' => 'Saint Kitts and Nevis', 'LC' => 'Saint Lucia', 'SP' => 'Saint Pierre', 'VC' => 'Saint Vincent', 'WS' => 'Samoa', 'SM' => 'San Marino', 'ST' => 'Sao Tome and Princ.', 'SA' => 'Saudi Arabia', 'SN' => 'Senegal', 'EM' => 'Serbia + Montenegro', 'SC' => 'Seychelles', 'SL' => 'Sierra Leone', 'SG' => 'Singapore', 'SK' => 'Slovakia', 'SI' => 'Slovenia', 'SB' => 'Solomon Islands', 'SO' => 'Somalia', 'ZA' => 'South Africa', 'ES' => 'Spain', 'LK' => 'Sri Lanka', 'SD' => 'Sudan', 'SR' => 'Suriname', 'VB' => 'Svalbard', 'SZ' => 'Swaziland', 'SE' => 'Sweden', 'CH' => 'Switzerland', 'SY' => 'Syrian Arab Republic', 'TW' => 'Taiwan', 'TJ' => 'Tajikistan', 'TZ' => 'Tanzania', 'TH' => 'Thailand', 'TG' => 'Togo', 'TK' => 'Tokelau', 'TO' => 'Tonga', 'TT' => 'Trinidad and Tobago', 'TU' => 'Tunisia', 'TR' => 'Turkey', 'TM' => 'Turkmenistan', 'TC' => 'Turks and Caicos Isl.', 'TV' => 'Tuvalu', 'UG' => 'Uganda', 'UA' => 'Ukraine', 'AE' => 'United Arab Emirates', 'GB' => 'United Kingdom', 'US' => 'United States', 'UY' => 'Uruguay', 'UZ' => 'Uzbekistan', 'VU' => 'Vanuatu', 'VA' => 'Vatican City', 'VE' => 'Venezuela', 'VN' => 'Vietnam', 'VI' => 'Virgin Islands', 'WF' => 'Wallis and Futuna Isl.', 'EH' => 'Western Sahara', 'YE' => 'Yemen', 'ZR' => 'Zaire', 'ZM' => 'Zambia', 'ZW' => 'Zimbabwe');
        $hours = array('00' => '00', '01' => '01', '02' => '02', '03' => '03', '04' => '04', '05' => '05', '06' => '06', '07' => '07', '08' => '08', '09' => '09', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '21' => '21', '22' => '22', '23' => '23');
        $months = array('01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
        $months_short = array('01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec');
        $days = array('01' => '1', '02' => '2', '03' => '3', '04' => '4', '05' => '5', '06' => '6', '07' => '7', '08' => '8', '09' => '9', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '21' => '21', '22' => '22', '23' => '23', '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29', '30' => '30', '31' => '31');

        return isset($$key) ? $$key : NULL;
    }

    public function getCommonVar($key = NULL)
    {
        return $this->get_common_var($key);
    }

    /**
     *    - To upload files
     *    Example: $this->upload($this->data['Category']['image'],$file_path);
     *    REF: controllers/category.php
     *
     * @ parameter image_info string
     * @ parameter dest string
     * @ return string
     */
    public function upload($image_info = NULL, $dest = NULL)
    {

        $media_info = array();
        // Sort File Information
        $tmpfile = $image_info['tmp_name'];
        $tmpfilename = $image_info['name'];
        $tmpfilesize = $image_info['size'];

        // Name And Extensions
        $name = substr($tmpfilename, 0, (strrpos($tmpfilename, '.')));
        $ext = substr($tmpfilename, strrpos($tmpfilename, '.') + 1, strlen($tmpfilename));

        // Reformat the file name
        if (file_exists("{$dest}{$tmpfilename}")) {
            $c = date(time()) . rand(1, 10000);
            $media_info['file_name'] = $name . "_" . $c . "." . $ext;
            $media_info['file_name2'] = $name . "_" . $c;
        }
        else {
            $media_info['file_name'] = "{$name}.{$ext}";
            $media_info['file_name2'] = "{$name}";
        }

        if (isset($tmpfile) && is_uploaded_file($tmpfile)) {
            move_uploaded_file($tmpfile, "{$dest}{$media_info['file_name']}");
        }

        return $media_info;
    }

    /**
     * Resize an image from it's file path and save in disk
     *
     * @ parameter oldimg string
     * @ parameter newimg string
     * @ parameter $maxwidth string
     * @ parameter $maxheight string
     */
    public function createThumb($oldimg = NULL, $newimg = NULL, $maxwidth = NULL, $maxheight = NULL)
    {
		if(!file_exists($oldimg)){
			return ;
		}
		
        $imagedata = GetImageSize($oldimg);
        $imagewidth = $imagedata[0];
        $imageheight = $imagedata[1];
        $imagetype = $imagedata[2];

        $maxheight = isset($maxheight) ? $maxheight : 99999999;
        $maxheight = isset($maxheight) ? $maxheight : 99999999;

        $shrinkage = 1;

        if ($imagewidth > $maxwidth) {
            $shrinkage = $maxwidth / $imagewidth;
        }
        if ($shrinkage != 1) {
            $dest_height = $shrinkage * $imageheight;
            $dest_width = $maxwidth;
        }
        else {
            $dest_height = $imageheight;
            $dest_width = $imagewidth;
        }
        if ($dest_height > $maxheight) {
            $shrinkage = $maxheight / $dest_height;
            $dest_width = $shrinkage * $dest_width;
            $dest_height = $maxheight;
        }
        if ($imagetype == 2) {
            $src_img = imagecreatefromjpeg($oldimg);
            $dst_img = imageCreateTrueColor($dest_width, $dest_height);
            ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $imagewidth, $imageheight);
            imagejpeg($dst_img, $newimg, 100);
            imagedestroy($src_img);
            imagedestroy($dst_img);
        }
        elseif ($imagetype == 3) {
            $src_img = imagecreatefrompng($oldimg);
            $dst_img = imageCreateTrueColor($dest_width, $dest_height);

            imagealphablending($dst_img, false);
            imagesavealpha($dst_img, true);
            $transparent = imagecolorallocatealpha($dst_img, 255, 255, 255, 127);
            imagefilledrectangle($dst_img, 0, 0, $dest_width, $dest_width, $transparent);


            ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $imagewidth, $imageheight);
            imagepng($dst_img, $newimg, 9);
            imagedestroy($src_img);
            imagedestroy($dst_img);
        }
        else {
            $src_img = imagecreatefromgif($oldimg);
            $dst_img = imageCreateTrueColor($dest_width, $dest_height);
            ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $imagewidth, $imageheight);
            imagejpeg($dst_img, $newimg, 100);
            imagedestroy($src_img);
            imagedestroy($dst_img);
        }
    }

    /**
     * Check a file image or not
     *
     * @ parameter file_name string
     * @ return boolean
     */
    public function is_image($file_name = "")
    {
        $ext_arr = array('.gif', '.jpg', '.jpeg', '.png');
        $sp = strrpos($file_name, '.');
        $ep = strlen($file_name);
        $ext = substr($file_name, $sp, $ep);
        return in_array(strtolower($ext), $ext_arr) ? true : false;
    }

    /**
     * A simple mail functin to send email
     *
     * @ parameter recipient string
     * @ parameter from string
     * @ parameter subj string
     * @ parameter body string 
     * @ parameter bcc string
     */
    public function mailing($recipient = "", $from = "", $subj = "", $body = "", $bcc = "")
    {
        // Checking Bcc exist or not
        if ($bcc != "") {
            $headers = "Bcc: " . $bcc . "\n";
        }

        // Setting the header
        $headers = "From: " . $from . "\n";
        $headers .= "http-equiv: Content-Type\n";
        $headers .= "Content-Type: text/html\n";

        // Sending the mail
        mail("{$recipient}", "{$subj}", "{$body}", "{$headers}");
    }

    /**
     * Save content in a file
     *
     * @ parameter path string
     * @ parameter content string
     */
    public function savefilecontent($path = NULL, $content = NULL, $mode='w')
    {
        $content = stripcslashes($content);

        if (!$handle = fopen($path, $mode)) {
            echo "Cannot open file ($filename)";
            exit;
        }

        if (fwrite($handle, $content) === FALSE) {
            echo "Cannot write to file ($filename)";
            exit;
        }

        fclose($handle);
    }

    /**
     *    -Read Content from a file
     */
    public function fatchfilecontent($file_path = NULL)
    {
        $handle = fopen($file_path, "r");
        $contents = '';
        while (!feof($handle)) {
            $contents .= fread($handle, 8192);
        }
        fclose($handle);

        return $contents;
    }


    /**
     * Parse a file
     *
     * @parameter str   string
     * @parameter s_tag string
     * @parameter e_tag string
     * @return string
     */
    public function get_value_by_tag_name($str = NULL, $s_tag = NULL, $e_tag = NULL)
    {
        $s = strpos($str, $s_tag) + strlen($s_tag);
        $e = strlen($str);
        $str = substr($str, $s, $e);
        $e = strpos($str, $e_tag);
        $str = substr($str, 0, $e);
        $str = substr($str, 0, $e);
        return $str;
    }

    /*
     * Retrieve a 1D array from a Muli Dymantial array
     */
    public function get_1d_arr($data = NULL, $key = NULL, $val = NULL)
    {
        $rt_data = array();
		
		$arr = explode(',',$val);
		
        foreach ($data as $key2 => $val2) {			
			for($i=0;$i<count($arr);$i++){
			
				if($i) $rt_data[$val2[$key]] .= ' ';
				else $rt_data[$val2[$key]] = '';
				
				$rt_data[$val2[$key]] .= isset($val2[$arr[$i]]) ? $val2[$arr[$i]] : '';				
			}
        }
        return $rt_data;
    }


    /*
     * Retrive a 1D array from a Muli Dymantial array
     */
    public function get1DArr($data = NULL, $key = NULL, $val = NULL)
    {
        return $this->get_1d_arr($data, $key, $val);
    }


    /*
     * calculate Percentage
     */
    public function getPercentage($x, $y)
    {
        return (($x * $y) / 100);
    }

    /*
     * Conver Hex code to RGB
     */
    public function HexToRGB($hex)
    {

        $hex = preg_replace("/#/i", "", $hex);
        $color = array();

        if (strlen($hex) == 3) {
            $color['r'] = hexdec(substr($hex, 0, 1) . $r);
            $color['g'] = hexdec(substr($hex, 1, 1) . $g);
            $color['b'] = hexdec(substr($hex, 2, 1) . $b);
        }
        else if (strlen($hex) == 6) {
            $color['r'] = hexdec(substr($hex, 0, 2));
            $color['g'] = hexdec(substr($hex, 2, 2));
            $color['b'] = hexdec(substr($hex, 4, 2));
        }
        return $color;
    }

    /*
     *	Convert a RGB to hex code
     */
    public function RGBToHex($r, $g, $b)
    {
        $hex = "#";
        $hex .= dechex($r);
        $hex .= dechex($g);
        $hex .= dechex($b);
        return $hex;
    }

    /*
    * Retrun a country name based on code a specifice
    */
    public function countryCodetoname($code = '')
    {
        $country_arr = $this->get_common_var('country');
        return isset($country_arr[$code]) ? $country_arr[$code] : $code;
    }

    /* -- Normalize a String -- */
    public function text2normalize($str = "")
    {
        $arr_busca = array(' ', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�');
        $arr_susti = array('-', 'a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A', 'e', 'e', 'e', 'E', 'E', 'E', 'i', 'i', 'i', 'I', 'I', 'I', 'o', 'o', 'o', 'o', 'o', 'O', 'O', 'O', 'O', 'u', 'u', 'u', 'U', 'U', 'U', 'c', 'C', 'N', 'n');
        $nom_archivo = trim(str_replace($arr_busca, $arr_susti, strtolower($str)));
        return preg_replace('[^A-Za-z0-9\_\-]', '', $nom_archivo);
    }

    /*
     * Filter <BR /> from pre tag
     */
    public function nl2brPre($string)
    {
        // First, check for <pre> tag
        if (!strstr($string, "<pre")) {
            return nl2br($string);
        }

        // If there is a <pre>, we have to split by line
        // and manually replace the linebreaks with <br />
        $strArr = explode("\n", $string);
        $output = "";
        $preFound = false;

        // Loop over each line
        foreach ($strArr as $line) {
            // See if the line has a <pre>.
            // If it does, set $preFound to true
            if (strstr($line, "<pre") || strstr($line, "<p")) {
                $preFound = true;
            }
            elseif (strstr($line, "</pre") || strstr($line, "</p")) {
                $preFound = false;
            }

            $output .= $line;
            $output .= ($preFound) ? "\n" : "<br />";

        }

        return $output;
    }

    /**
     * A public function incase you need to pagination an array
     *
     * @parameter data array
     * @parameter $options array
     * @return  array()
     */
    public function arrayPaginator($data = NULL, $options = NULL)
    {
        return $this->array_paginator($data, $options);
    }

    public function array_paginator($data = NULL, $options = NULL)
    {
        if (!isset($data)) return Array();

        // Set Parameters
        $options['smart'] = isset($options['smart']) ? $options['smart'] : false;

        if (isset($options['page'])) $_GET['page'] = $options['page'];
        $page = isset($_GET['page']) ? $_GET['page'] : "1";
        $h_link = isset($options['h_link']) ? $options['h_link'] : "?";

        if ($this->getLimit()) $options['limit'] = $this->getLimit();
        $default_pagination = App::Helper('Config')->setting('default_pagination');
        $default_pagination = ($default_pagination) ? $default_pagination : 15;
        $listing_per_page = isset($options['limit']) ? $options['limit'] : $default_pagination;
        $total = count($data);
        $tpage = ceil($total / $listing_per_page);

        $spage = ($tpage == 0) ? ($tpage + 1) : $tpage;
        $startfrom = ($page - 1) * $listing_per_page;
        $endto = ($page) * $listing_per_page;
        if ($endto > $total) {
            $endto = $total;
        }
        $page_no = "";
        $s = $i = $page - 5;
        $s = ($s < 1) ? 1 : $s;

        $sp_link = '';
        for ($i = $s; $i <= $page + 5 && $i <= $tpage; $i++) {
            if ($options['smart']) $page_no .= ($i == $page) ? "<strong classs=\"page_selected\">$i</strong> " : '<a href="' . $this->replaceSmartPage($h_link, $i) . '">' . $i . '</a> ';
            else $page_no .= ($i == $page) ? "<strong classs=\"page_selected\">$i</strong> " : '<a href="' . $h_link . '&page=' . $i . '">' . $i . '</a> ';

            $sp_link .= ($i == $page) ? "<li class=\"current\">{$i}</li>" : '<li><a href="' . $h_link . '&page=' . $i . '">' . $i . '</a> </li>';
        }

        $link = ($page_no != "") ? "Showing Results " . ($startfrom + 1) . "-$endto of $total" : "";
        $paging = '';
        $sp_prev = '<li class="disabled">' . PREVIOUS_PAGE . '</li>';
        $sp_next = '<li class="disabled">' . NEXT_PAGE . '</li>';
        if ($tpage > 1) {
            $nextpage = $page + 1;
            $prevpage = $page - 1;

            if ($options['smart']) {
                $prevlink = '<a href="' . $this->replaceSmartPage($h_link, $prevpage) . '" class="page_previous" title="' . PREVIOUS_PAGE . '">' . PREVIOUS_PAGE . '</a>';
                $nextlink = '<a href="' . $this->replaceSmartPage($h_link, $nextpage) . '" class="page_next" title="' . NEXT_PAGE . '">' . NEXT_PAGE . '</a>';
            }
            else {
                $prevlink = '<a href="' . $h_link . '&amp;page=' . $prevpage . '" class="page_previous" title="' . PREVIOUS_PAGE . '">' . PREVIOUS_PAGE . '</a>';
                $nextlink = '<a href="' . $h_link . '&amp;page=' . $nextpage . '" class="page_next" title="' . NEXT_PAGE . '">' . NEXT_PAGE . '</a>';
            }

            if ($page == $tpage) {
                $paging = "$prevlink";

                $sp_prev = "<li>$paging</li>";
                $sp_next = '<li class="disabled">' . NEXT_PAGE . '</li>';
            }
            elseif ($tpage > $page && $page > 1) {
                $paging = "$prevlink | $nextlink";

                $sp_prev = "<li>$prevlink</li>";
                $sp_next = "<li>$nextlink</li>";
            }
            elseif ($tpage > $page && $page <= 1) {
                $paging = "$nextlink";

                $sp_prev = '<li class="disabled">' . PREVIOUS_PAGE . '</li>';
                $sp_next = "<li>$paging</li>";
            }
        }

        // Get current page data
        $chunk = array_slice($data, $startfrom, $listing_per_page);

        // Formate return data
        $gross['data'] = $chunk;
        $gross['paging'] = $paging;
        $gross['link'] = $link;
        $gross['total'] = $total + 0;
        $gross['page'] = $page + 0;
        $gross['paging_str'] =
            '<div class="pagination pagination-left">
				<div class="results">
					<span>' . $link . '</span>
				</div>
				<ul class="pager">
					' . $sp_prev . '
					' . $sp_link . '
					' . $sp_next . '
				</ul>
			</div>';
        return $gross;
    }

    private function replaceSmartPage($l = NULL, $p = NULL)
    {
        if (isset($l) && isset($p)) {
            return (strstr($l, '[page]')) ? str_replace("[page]", $p, $l) : "{$l}/{$p}";
        }
        else {
            return "?";
        }
    }
	
	public function numberFormate($value=null,$prec=2,$def_rtn='0.00'){
		if(!isset($value) || !is_numeric($value) || $value == 0){
			return $def_rtn;
		}		
		return $this->moneyFormatIndia($value,$prec);	
	 }
	
	public function moneyFormatIndia($num,$prec=2){
		
		
		$symbol = '';
		if($num < 0){
			$symbol = '-';
		}
		
		$num = abs($num);
		$explrestunits = "" ;
		$num=preg_replace('/,+/', '', $num);
		
		$words = explode(".", $num);

		$des="00";
		if(count($words)<=2){
			$num=$words[0];
			if(count($words)>=2){
				$des=$words[1];
			}
			if(strlen($des)<$prec){
				$des=str_pad("{$des}",$prec,'0');
			}else{
				$des=substr($des,0,$prec);
			}
		}
		
		if(strlen($num)>3){
			$lastthree = substr($num, strlen($num)-3, strlen($num));
			$restunits = substr($num, 0, strlen($num)-3);
			$restunits = ( strlen($restunits)%2 == 1 ) ? "0" . $restunits:$restunits;
			$expunit = str_split($restunits, 2);
			for($i=0; $i<sizeof($expunit); $i++){
				if($i==0) {
					$explrestunits .= (int)$expunit[$i].",";
				}
				else{
					$explrestunits .= $expunit[$i].",";
				}
			}
			$thecash = $explrestunits.$lastthree;			
		}
		else {
			$thecash = $num;
		}
		
		if($prec <=0){
			$formatedNum = $symbol . $thecash;
		}
		else {
			$formatedNum  = $symbol . $thecash . "." . $des;
		}
		
		return $formatedNum;
	}

    public function codeFormated($data = "", $nl2br = false)
    {
        $data = str_replace('{lt}', '&lt;', $data);
        $data = str_replace('{gt}', '&gt;', $data);

        $data = str_replace('{code_php}', '<pre class="brush: php"> &lt;?php', $data);
        $data = str_replace('{/code_php}', ' ?&gt;</pre>', $data);

        $data = str_replace('{pre}', '<pre>', $data);
        $data = str_replace('{/pre}', '</pre>', $data);

        $data = str_replace('{break}', '<br />', $data);

		$data = str_replace('{site_title}', App::Load("Helper/Config")->setting('site_title'), $data);
		
        $data = str_replace('{baseurl}', App::Load("Helper/Config")->baseUrl(), $data);
        $data = str_replace('{skinurl}', App::Load("Helper/Config")->skinUrl(), $data);
        $data = str_replace('{filemanagerurl}', App::Load("Helper/Config")->filemanagerUrl(), $data);
        ##$data = str_replace('{filemanagerpath}', App::Load("Helper/Config")->filemanagerDir(), $data);
		
		
		$data = str_replace('{basedir}', App::Load("Helper/Config")->baseDir(), $data);
		#$data = str_replace('{rootdir}', App::Load("Helper/Config")->rootDir(), $data);

        $data = str_replace('{link}', '<a href="', $data);
        $data = str_replace('{innertext}', '">', $data);
        $data = str_replace('{/innertext}{/link}', '</a>', $data);


        $data = str_replace('{pera}', '<p>', $data);
        $data = str_replace('{/pera}', '</p>', $data);

        $data = str_replace('{bold}', '<strong>', $data);
        $data = str_replace('{/bold}', '</strong>', $data);

        $data = str_replace('{underline}', '<u>', $data);
        $data = str_replace('{/underline}', '</u>', $data);

        $data = str_replace('{italic}', '<i>', $data);
        $data = str_replace('{/italic}', '</i>', $data);

        $data = str_replace('{img}', '<img src="', $data);
        $data = str_replace('{/img}', '" />', $data);

        return ($nl2br) ? $this->nl2brPre($data) : $data;


    }

    public function convertArrayToXML($data = NULL)
    {
        $str = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
        $str .= "<nodes>";
        if (!empty($data)) {
            foreach ($data as $p) {
                $str .= '<node>';
                foreach ($p as $ck => $c) {

                    $str .= is_numeric($c) ? "<{$ck}>{$c}</{$ck}>" : "<{$ck}><![CDATA[{$c}]]></{$ck}>";
                }
                $str .= '</node>';
            }
        }
        $str .= "</nodes>";

        return $str;
    }

    public function sqlSaperator($sql = null)
    {
        if (!isset($sql)) return "";

        return preg_split("/;+(?=([^'|^\\\']*['|\\\'][^'|^\\\']*['|\\\'])*[^'|^\\\']*[^'|^\\\']$)/", $sql);
    }

    public function convertArrayToCsvString($fields = array(), $delimiter = ';', $enclosure = '"')
    {
        $str = '';
        $escape_char = '\\';
        foreach ($fields as $value) {
            if (strpos($value, $delimiter) !== false ||
                strpos($value, $enclosure) !== false ||
                strpos($value, "\n") !== false ||
                strpos($value, "\r") !== false ||
                strpos($value, "\t") !== false ||
                strpos($value, ' ') !== false
            ) {
                $str2 = $enclosure;
                $escaped = 0;
                $len = strlen($value);
                for ($i = 0; $i < $len; $i++) {
                    if ($value[$i] == $escape_char) {
                        $escaped = 1;
                    }
                    else if (!$escaped && $value[$i] == $enclosure) {
                        $str2 .= $enclosure;
                    }
                    else {
                        $escaped = 0;
                    }
                    $str2 .= $value[$i];
                }
                $str2 .= $enclosure;
                $str .= $str2 . $delimiter;
            }
            else {
                $str .= $value . $delimiter;
            }
        }

        $str = substr($str, 0, -1);
        $str .= "\n";
        return $str;
    }

    public function downloadInline($data = "", $file_name = 'download.txt', $mime_type = NULL)
    {
        $name = substr($file_name, 0, (strrpos($file_name, '.')));
        $ext = strtolower(substr($file_name, strrpos($file_name, '.') + 1, strlen($file_name)));

        if (isset($mime_type)) {
            header("Content-type:{$mime_type}");
        }
        else {
            header("Content-type: text/{$ext}");
        }
        header("Content-Disposition: attachment; filename={$name}.{$ext}");
        echo $data;
        exit;
    }

    public function download($path = "", $contentType = null, $fileName = null)
    {
        if (!isset($fileName)) {
            $fileNameArr = preg_split('[' . DS . ']', $path);
			$fileName = end($fileNameArr);
        }
        if (!isset($contentType)) {
            $contentType = "application/{$this->getExt($fileName)}";
        }
        header('Content-type: ' . $contentType);
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        readfile($path);
        exit;
    }

    public function getDirLising($dir_paths = NULL, $option = NULL)
    {
        if (!is_array($dir_paths)) {
            $dir_paths = array($dir_paths);
        }
        $list_arr = array();

        foreach ($dir_paths as $dir_path) {
            $handle = opendir($dir_path);
            $filetime_as_index = isset($option["filetime_as_index"]) ? $option["filetime_as_index"] : false;
            if ($handle) {
                while (false !== ($file = readdir($handle))) {
                    if ($file != '..' && $file != '.') {
                        $filemtime = filemtime($dir_path . "/" . $file);

                        if ((is_dir($dir_path . "/" . $file))) {
                            $type = "dir";
                        }
                        else {
                            $type = "file";
                        }

                        if ($filetime_as_index) {
                            $list_arr[$type][$filemtime] = array("dir_path" => $dir_path, "name" => $file, "type" => $type, "filemtime" => $filemtime);
                        }
                        else {
                            $list_arr[$type][] = array("dir_path" => $dir_path, "name" => $file, "type" => $type, "filemtime" => $filemtime);
                        }
                    }
                }
            }
            closedir($handle);
        }

        return $list_arr;
    }

    public function getFullDirLising($dir = null)
    {
        $listDir = array();
        if (!isset($dir)) return $listDir;

        if ($handler = opendir($dir)) {
            while (($sub = readdir($handler)) !== FALSE) {
                if ($sub != "." && $sub != ".." && $sub != "Thumb.db") {
                    if (is_file($dir . "/" . $sub)) {
                        $listDir[] = $sub;
                    } elseif (is_dir($dir . "/" . $sub)) {
                        $listDir[$sub] = $this->getFullDirLising($dir . "/" . $sub);
                    }
                }
            }
            closedir($handler);
        }

        return $listDir;
    }

    public function getName($filename = null)
    {
        $filename = isset($filename) ? $filename : $this->getFileName();
        return @substr($filename, 0, strrpos($filename, '.'));
    }

    public function getExt($filename = nulll)
    {
        $filename = isset($filename) ? $filename : $this->getFileName();
        return @substr(
            $filename,
            strrpos($filename, '.') + 1,
            strlen($filename)
        );
    }

    public function createDir($path = "", $permisson = 0777)
    {
        if (!file_exists($path)) {
            @mkdir($path, $permisson);
        }

        @chmod($path, $permisson);

        return $this;
    }

    public function dirFullRemove($directory, $empty = false)
    {
        if (substr($directory, -1) == DS) {
            $directory = substr($directory, 0, -1);
        }

        if (!file_exists($directory) || !is_dir($directory)) {
            return false;
        }
        elseif (!is_readable($directory)) {
            return false;
        }
        else {
            $directoryHandle = opendir($directory);
            while ($contents = readdir($directoryHandle)) {
                if ($contents != '.' && $contents != '..') {
                    $path = $directory . DS . $contents;

                    if (is_dir($path)) {
                        $this->dirFullRemove($path);
                    }
                    else {
                        if (is_writeable($path)) {
                            @unlink($path);
                        }
                    }
                }
            }
            closedir($directoryHandle);
            if ($empty == false) {
                if (!rmdir($directory)) {
                    return false;
                }
            }

            return true;
        }
    }

    public function dirFullCopy($src = NULL, $dst = NULL, $overwrite = false)
    {
        $dir = opendir($src);
        if (file_exists($dst)) {
            chmod($dst, 0777);
        }
        else {
            $this->createDir($dst, 0777);
        }
        if (!is_dir($dst)) return false;
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                $ss = $src . DS . $file;
                $dd = $dst . DS . $file;
                if (is_dir($ss)) {
                    $this->dirFullCopy($ss, $dd);
                }
                else {

                    if ($overwrite) {
                        $this->copy($ss, $dd);
                    }
                    else {
                        if (!file_exists($dd)) {
                            $this->copy($ss, $dd);
                        }
                    }

                }
            }
        }
        closedir($dir);
    }

    public function createFile($data = NULL, $path = NULl)
    {

        if (!file_exists($path)) {
            if ($handle = fopen($path, 'w')) {
                fwrite($handle, $data);
            }

            fclose($handle);
        }

        return $this;
    }

    public function copy($file1, $file2)
    {
        $status = false;
        if (file_exists($file1) && file_exists(dirname($file2))) {
            $contentx = @file_get_contents($file1);
            $openedfile = fopen($file2, "w");
            fwrite($openedfile, $contentx);
            fclose($openedfile);

            if ($contentx === FALSE) {
                $status = false;
            }
            else {
                chmod($file2, 0777);
                $status = true;
            }
        }
        return $status;
    }

    public function checkFile($src = "")
    {
        return file_exists($src);
    }

    public function overwriteFile($data = NULL, $path = NULl)
    {
        if (file_exists($path)) {
            @unlink($path);
        }
        return $this->createFile($data, $path);
    }

    public function copyFile($src = NULL, $des = NULl)
    {
        if (file_exists($des)) {
            @unlink($des);
        }

        if (file_exists($src)) {
            copy($src, $des);
        }
        return $this;
    }

    public function deleteFile($src = NULL)
    {
        if (file_exists($src)) {
            @unlink($src);
        }
        return $this;
    }

    public function fetchFile($path = NULL)
    {
        $contents = "";
        if (!file_exists($path)) {
            return $contents;
        }
        $handle = fopen($path, "r");
        if ($fs = filesize($path)) {
            $contents = fread($handle, $fs);
        }
        fclose($handle);

        return $contents;
    }

    public function parsePHP($str = "", $options = Array())
    {
		$str = str_replace('{php}','<?php ',$str);
		$str = str_replace('{/php}',' ?>',$str);
	
        if (!empty($options)) {
            foreach ($options as $key => $val) {
                if (is_string($key)) {
                    $$key = $val;
                }
            }
        }
        ob_start();
        eval('?>' . $str );
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }

    public function callElementByPath($path = "", $options = array())
    {
        $contents = "";
        if (file_exists($path)) {
            if (!empty($options)) {
                foreach ($options as $key => $val) {
                    if (is_string($key)) {
                        $$key = $val;
                    }
                }
            }
            ob_start();
            include ($path);
            $contents = ob_get_contents();
            ob_end_clean();
        }
        return $contents;
    }

    public function multiArraySort($arr = array(), $field = null, $sort = 'ASC')
    {
        if (!empty($arr) && isset($field)) {
            $tmp = Array();
            foreach ($arr as &$ma) {
                $tmp[] = &$ma[$field];
            }
            if (strtolower($sort) == 'asc') {
                array_multisort($tmp, SORT_ASC, $arr, SORT_ASC);
            }
            else {
                array_multisort($tmp, SORT_DESC, $arr, SORT_DESC);
            }
        }
        return $arr;
    }
    
    public function convertNumberToWord($number = false,$curr='')
    {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(	0 => '', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine',
						10 => 'ten', 11 => 'eleven', 12 => 'twelve',13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',40 => 'forty', 50 => 'fifty', 60 => 'sixty',70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
        $digits = array('', 'hundred','thousand','lac', 'crore');
		
        while( $i < $digits_length ) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
            } else $str[] = null;
        }
		
        $Taka = implode('', array_reverse($str));
        $paise = ($decimal) ? "point " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) : '';
        $textFinal =  ($Taka ? $Taka : '') . $paise;
		
		if(!empty($textFinal)){
			return  ucwords(preg_replace('/\s+/', ' ', trim($textFinal)))  . " {$curr}";
		}
    }
}