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


abstract class appRain_Base_Objects extends appRain_Base_Abstract
{
    public $__data = array();
    public $fetchtype = "";

    /**
     *
     *  @parameter method string
     *  @parameter params array
     */
    public function __call($method, $params)
    {
       // $this->fetchtype = isset($this->fetchtype) ? $this->fetchtype : null;

        if( substr($method, 0, 3) == 'get'){
            $key = $this->method2_var_name(substr($method,3));
            return isset($this->__data[$key]) ? $this->__data[$key] : null;
        }
        else if ( substr($method, 0, 5) == 'unset'){
            $key = $this->method2_var_name(substr($method,5));
            unset($this->__data[$key]);

            return $this;
        }
        else if ( substr($method, 0, 3) == 'set'){
            $key = $this->method2_var_name(substr($method,3));
            $this->__data[$key] = isset($params[0]) ? $params[0] : null;

            return $this;
        }
	else if (
            strtolower(substr(get_class($this),-5)) == 'model'  or 
            strtolower(substr(get_class($this),-14)) == 'informationset' or
            strtolower(substr(get_class($this),-11)) == 'categoryset'
        ){
            if( $this->getFetchtype() == 'informationset' ){
                $this->unsetFetchtype();
                return $this->callInformationSetByFiled( $method, $params );
            }
            else if( $this->getFetchtype() == 'categoryset' ){
                $this->unsetFetchtype();
                return $this->callCategorySetByFiled( $method, $params );
            }
            else{
                if( isset($params[0] )){
                    return $this->callByFiled( $method, $params[0] );
                }
                else return Array();
            }

        }
        else{
            if( app::__def()->sysConfig('DEBUG_MODE') > 0){
                try{
                    throw new AppException('Trace:');
                }
                catch (AppException $e){
                    pr( "Call Unknown Method ('{$method}')\n{$e->__toString()}\n");
                } 
            }
        }
    }

    private function method2_var_name( $method = "")
    {   
        return strtolower($method); 
    }

    public function __( $key = ""){ 
        return App::load("Module/Language")->get($key);
    }

}
