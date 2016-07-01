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

abstract class appRain_Base_Modules_Javascript extends appRain_Base_Objects
{

    public function appForm($formElement = null)
    {
        $param = "";
        if (isset($formElement)) {
            $formElement = isset($formElement) ? $formElement : 'app_form';


            $options = $this->getValidation();
            $defaultColor = isset($options['defaultColor']) ? $options['defaultColor'] : '#FFFFFF';
            $errorColor = isset($options['errorColor']) ? $options['errorColor'] : '#FF5555';
            $autoSubmit = (isset($options['autoSubmit']) && !$options['autoSubmit']) ? 'false' : 'true';
			
			
            $errorMark = isset($options['errorMark']) ? $options['errorMark'] : 'inline';
			
			

            $options = $this->getAjax();
            $ajaxEnabled = (!empty($options)) ? 'true' : 'false';
            $debug = 'false';
            if (app::__def()->sysConfig('DEBUG_MODE')) {
                $debug = (isset($options['debug']) && $options['debug']) ? 'true' : 'false';
            }
            $ajaxAutoHide = (isset($options['autoHide']) && $options['autoHide']) ? 'true' : 'false';
            $ajaxMessageElement = isset($options['messageElement']) ? $options['messageElement'] : '.message';
            $ajaxLoaderElement = isset($options['loaderElement']) ? $options['loaderElement'] : '.message';
            $ajaxLoadingImageUrl = isset($options['loadingImageUrl']) ? "'{$options['loadingImageUrl']}'" : "siteInfo.baseUrl + '/images/loading.gif'";

            $param = "
            {
                '_formClass' : '{$formElement}',
                '_validation':
                {
                    '_errBg' : '{$errorColor}',
                    '_dflBg' : '{$defaultColor}',
                    '_autoSubmit' : {$autoSubmit},
                    '_errorMark' : '{$errorMark}'
                },
                '_ajax':
                {
                    '_enabled':{$ajaxEnabled},
                    '_debug' : {$debug},
                    '_autoHide' : {$ajaxAutoHide},
                    '_messageElement' : '{$ajaxMessageElement}',
                    '_loaderElement' : '{$ajaxLoaderElement}',
                    '_loadingImg' : {$ajaxLoadingImageUrl}
                }
            }";
        }


        $code = "\n jQuery('{$formElement}').appForm({$param})";

        echo App::Load("Helper/Html")->get_tag('script', array('type' => 'text/javascript'), $code);

        return $this;
    }

    public function autoComplete($JSReferance = "", $data = array())
    {
        $JSONData = App::Module('Cryptography')->jsonEncode(array_unique($data));
        return
            '<script type="text/javascript">
            jQuery(document).ready(function () {
                jQuery("' . $JSReferance . '").autocomplete({
                    source: ' . $JSONData . '
                });
            });
        </script>';
    }

    public function Cycle($element = '#slidewrapper', $flag = 'fade')
    {
        $code = "jQuery('{$element}').cycle( ";
        switch (strtolower($flag)) {
            case 'fade' :
                $code .= "{
                    fx:    'fade', 
                    speed:  2500 
                }";
                break;
            case 'scrolldown' :
                $code .= "{ 
                    fx:      'scrollDown', 
                    speed:    300, 
                    timeout:  2000 
                }";
                break;
            case 'zoom':
                $code .= "{
                    fx:     'zoom', 
                    easing: 'easeInBounce', 
                    delay:  -4000 
                }";
                break;
            case 'shuffle':
                $code .= "{
                    fx:    'shuffle', 
                    delay: -4000 
                }";
                break;
            case 'easeinoutback':
                $code .= "{
                    fx:   'shuffle', 
                    shuffle: { 
                        top:  -230, 
                        left:  230 
                    }, 
                    easing: 'easeInOutBack', 
                    delay: -2000 
                }";
                break;
            case 'blindx':
                $code .= "{
                   fx:     'blindX',
                   speed:   1000,
                   timeout: 6000,
                   delay:  -4000
                }";
                break;
            default:
                $code .= $flag;
                break;

        }
        $code .= ');';
        return "<script type=\"text/javascript\">{$code}</script>";
    }
}