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
class appRain_Base_Modules_ACL extends appRain_Base_Objects {

    const SUPER = 'super';

    public function register($identity = null, $options = array()) {
        App::Module('Hook')->setHookName('ACL')
                ->setAction("register_detail_acl")
                ->Register(get_class($this), "register_detail_acl_definition", array('identity' => $identity, 'options' => $options));
    }

    public function hasAccess($name = null, $expValue = null) {
        $adminInfo = App::AdminManager()->thisAdminInfo();

        if (strtolower($adminInfo['type']) == self::SUPER)
            return true;

        $aclobject = unserialize($adminInfo['aclobject']);

        if (!isset($aclobject[$this->getGroupName()][$name]))
            return false;

        $default = $aclobject[$this->getGroupName()][$name];

        if (is_array($default) && in_array($expValue, $default))
            return true;
        else if ((string) $expValue == $default)
            return true;
        else
            return false;
    }

	
	// Type acl , aclobject
	// return value or true of super admin
    public function readAccess($type='acl', $link= null) {
        $adminInfo = App::adminManager()->thisAdminInfo();

        if (!isset($adminInfo['type']) || strtolower($adminInfo['type']) == self::SUPER) {
            return true;
        }
        if ($adminInfo[$type] != '') {
            $data =  unserialize($adminInfo[$type]);

			if( isset($link) and !empty($link)){
				$list = explode('/',$link);
				
				foreach($list as $key){
					if(isset($data[$key])){
						$data = $data[$key];
					}
					else{
						$data = "";
					}
				}
				
				return $data;
			}
			
			return $data;
        }

        return array();
    }

    public function readNAVAccess($flag = 'Top') {

        $adminInfo = App::adminManager()->thisAdminInfo();

        if (strtolower($adminInfo['type']) == self::SUPER) {
            $adminDefinition = App::__def()->getInterfaceBuilderDefinition();
            if (strtolower($flag) == 'top') {
                return array_keys($adminDefinition);
            } else {
                return $adminDefinition;
            }
        }

        if ($adminInfo['acl'] != '') {
            $acl = unserialize($adminInfo['acl']);
            if (strtolower($flag) == 'top') {
                return array_keys($acl);
            } else {
                return unserialize($adminInfo['acl']);
            }
        }

        return array();
    }

    public function accessLinksOnly($accessArr = null) {
        $tmp = array();
        if (!empty($accessArr)) {
            if (isset($accessArr['child'])) {
                foreach ($accessArr['child'] as $row) {
                    foreach ($row['items'] as $item) {
                        $tmp[] = $item['link'];
                    }
                }
            } else {
                foreach ($accessArr as $row) {
                    if (is_array($row)) {
                        $tmp = array_merge($tmp, $row);
                    }
                }
            }
        }
        return $tmp;
    }

    public function AdminNavList($Send = null) {

        $adminDefinition = $this->getInterfaceBuilderDefinition();

        if (isset($Send)) {
			if(is_array($Send)){
				$adminInfoACL = $Send;	
			}
			else{
				$adminInfo = App::AdminManager()->Listing($Send);
				$adminInfoACL = (isset($adminInfo['acl']) && !empty($adminInfo['acl'])) ? unserialize($adminInfo['acl']) : array();
			}
        }
		
		
        $str = '';
        foreach ($adminDefinition as $name => $row) {

            $accessLinks = array();
            if (isset($adminInfoACL[$name])) {
                $accessLinks = $this->accessLinksOnly($adminInfoACL[$name]);
                $str .= App::Helper('Html')->getTag('h5', array("style" => "margin:10px 0 0 0;cursor:pointer"), '<input disabled=\"disable\" onclick="setparentval(this,\'' . $name . '\');" checked="checked" type="checkbox" id="' . $name . '" name="data[Admin][acl][' . $name . ']" value="" /> <label onclick="jQuery(\'#inner_' . $name . '\').toggle()"  />' . $this->__($row['parent']['title']) . '</label>');
            } else {
                $str .= App::Helper('Html')->getTag('h5', array("style" => "margin:10px 0 0 0;cursor:pointer"), '<input disabled=\"disable\" onclick="setparentval(this,\'' . $name . '\');" type="checkbox" id="' . $name . '" name="data[Admin][acl][' . $name . ']" value="" /> <label onclick="jQuery(\'#inner_' . $name . '\').toggle()" />' . $this->__($row['parent']['title']) . '</label>');
            }
            $str .= "<div id=\"inner_{$name}\" style=\"display:none\">";
            $str .= '<ul style="margin-left:15px">';
            foreach ($row['child'] as $childkey => $child) {

                $hasOne = false;
                $childstr = '<ul style="margin-left:15px">';
                foreach ($child['items'] as $itemkey => $item) {
                    if (in_array($item['link'], $accessLinks)) {
                        $hasOne = true;
                        $childstr .= "<li><input type=\"checkbox\" onclick=\"checkmyparents('{$name}');\"  checked=\"checked\" name=\"data[Admin][acl][{$name}][{$childkey}][{$itemkey}]\" value=\"{$item['link']}\" />" . $this->__($item['title']);
                    } else {
                        $childstr .= "<li><input type=\"checkbox\" onclick=\"checkmyparents('{$name}');\"  name=\"data[Admin][acl][{$name}][{$childkey}][{$itemkey}]\" value=\"{$item['link']}\" />" .  $this->__($item['title']);
                    }
                }
                $childstr .= '</ul>';
                if ($hasOne) {
                    $str .= "<li><input type=\"checkbox\" onclick=\"childselection(this);checkmyparents('{$name}');\" checked=\"checked\"  name=\"data[Admin][acl][{$name}][{$childkey}]\" value=\"Yes\" />" . $this->__($child['title']);
                } else {
                    $str .= "<li><input type=\"checkbox\" onclick=\"childselection(this);checkmyparents('{$name}');\" name=\"data[Admin][acl][{$name}][{$childkey}]\" value=\"Yes\" />" . $this->__($child['title']);
                }
                $str .= $childstr;
                $str .= '</li>';
            }
            $str .= '</ul>';
            $str .= "</div>";
        }

        $str .= '<script type="text/javascript">
                    function setparentval(e,name){
                        var flag = jQuery(e).attr(\'checked\');
                        jQuery(e).attr(\'checked\',!flag);
                        jQuery(\'#inner_\' + name ).toggle();
                    }
                    function checkmyparents(name){
                        var cnt = jQuery("#inner_"+ name +" ul li").children("input:checkbox:checked").length;
                        jQuery("#"+name).attr("checked",cnt)
                    }
                    function childselection(obj){
                        jQuery(obj).parent("li")
                        .children("ul")
                            .children("li")
                                .children("input")
                                .attr("checked",jQuery(obj).attr("checked"));
                        checkmyparents();
                    } 
        </script>';
        return $str;
    }

    public function register_detail_acl_definition($user, $params) {
        $name = key($params['identity']);
        $title = $params['identity'][$name];
		
        if (isset($user['aclobject'])) {
			  $userdata = unserialize($user['aclobject']);
		}
		else if(is_array($user)){
           $userdata = $user;
        }

        $str = App::Helper('Html')->getTag('h3', array("onclick" => "jQuery('#otherinnerdiv{$name}').toggle()", "style" => "margin:10px 0 0 0;cursor:pointer"), $title);
        $str .= "<div id=\"otherinnerdiv{$name}\" style=\"display:none;padding:5px; border:1px solid #DDD\">";
        foreach ($params['options'] as $fieldname => $row) {
            $defaultvalue = isset($userdata[$name][$fieldname]) ? $userdata[$name][$fieldname] : $row['defaultvalue'];
			
            $inputtype = $row['inputtype'];

            if (strtolower($inputtype) == 'checkboxtag') {
                $str .= App::Helper('Html')->getTag('h5',array('style'=>'margin-left:0;font-weight:normal;text-transform:underline;padding:1px;background-color:#E3E2E2'), $row['title']) . App::Helper('Html')->$inputtype("data[Admin][aclobject][{$name}][{$fieldname}][]", $row['options'], $defaultvalue);
            }
			else if (strtolower($inputtype) == 'inputtag') {
                $str .= App::Helper('Html')->getTag('h5',array('style'=>'margin-left:0;font-weight:normal;text-transform:underline;padding:1px;background-color:#E3E2E2'), $row['title']) . App::Helper('Html')->$inputtype("data[Admin][aclobject][{$name}][{$fieldname}]", $defaultvalue,array('class'=>'large'));
            } else {
                $str .= App::Helper('Html')->getTag('h5', array('style'=>'margin-left:0;font-weight:normal;text-transform:underline;padding:1px;background-color:#E3E2E2'), $row['title']) . App::Helper('Html')->$inputtype("data[Admin][aclobject][{$name}][{$fieldname}]", $row['options'], $defaultvalue);
            }
        }
        $str .= "</div>";

        return $str;
    }

    public function getInterfaceBuilderDefinition() {
        $access = $this->readaccess();

        $accessarray = array();
        $key = 'superadmin';
        foreach (App::__def()->getInterfaceBuilderDefinition() as $name => $row) {
            if (is_array($access)) {
                if (in_array($key, $row['parent']['acl']) && in_array($name, array_keys($access))) {
                    $accessLinksOnly = $this->accessLinksOnly($access[$name]);
                    foreach ($row['parent']['submenu'] as $ikey => $irow) {
                        if (!in_array($irow['link'], $accessLinksOnly)) {
                            unset($row['parent']['submenu'][$ikey]);
                        }
                    }
                    $accessarray[$name] = $row;
                }
            } else {
                if (in_array($key, $row['parent']['acl'])) {
                    $accessarray[$name] = $row;
                }
            }
        }
        return $accessarray;
    }

    public function getDashboardNAVS() {

        $adminInfo = App::adminManager()->thisAdminInfo();
        $admin_nav_def = App::Module('ACL')->getInterfaceBuilderDefinition();
        $NAVAccess = $this->readNAVAccess('top');
        $CurrentAccess = $this->readNAVAccess('full');

        $accessLinks = $this->accessLinksOnly($CurrentAccess);
        $accessLinks = $this->accessLinksOnly($accessLinks);

        $DashBoardNAVs = Array();
        foreach ($admin_nav_def as $key => $val) {
            if (in_array($key, $NAVAccess)) {
                foreach ($val['child'] as $childKey => $child) {
                    foreach ($child['items'] as $itemKey => $item) {
                        if (!in_array($item['link'], $accessLinks) && strtolower($adminInfo['type']) != self::SUPER) {
                            unset($val['child'][$childKey]['items'][$itemKey]);
                        }
                    }
                    if (empty($val['child'][$childKey]['items'])) {
                        unset($val['child'][$childKey]);
                    }
                }
                $DashBoardNAVs[$key] = $val;
            }
        }

        return $DashBoardNAVs;
    }

    public function verifyInformationSetModifyAccessByAction($type = null, $action = null, $redirect = true) {
        $definition = app::__def()->getInformationSetDefinition($type);
		
		if(!empty($action)){
			switch (strtolower($action)) {
				case 'add' :
					if (isset($definition['base']['parameters']['add']) && strtolower($definition['base']['parameters']['add']) == 'no') {
						App::Module('Notification')->Push("Entry Add is restricted.", "Warning");
						if ($redirect) {
							App::Config()->redirect("/information/manage/{$type}");
						}
					}
					break;
				case 'update' :
					if (isset($definition['base']['parameters']['edit']) && strtolower($definition['base']['parameters']['edit']) == 'no') {
						App::Module('Notification')->Push("Entry edit is restricted.", "Warning");
						if ($redirect) {
							App::Config()->redirect("/information/manage/{$type}");
						}
					}
					break;
				case 'delete' :
					if (isset($definition['base']['parameters']['delete']) && strtolower($definition['base']['parameters']['delete']) == 'no') {
						App::Module('Notification')->Push("Entry edit is restricted.", "Warning");
						if ($redirect) {
							App::Config()->redirect("/information/manage/{$type}");
						}
					}
					break;
				case 'view' :
					if (isset($definition['base']['parameters']['view']) && strtolower($definition['base']['parameters']['view']) == 'no') {
						App::Module('Notification')->Push("Entry view is restricted.", "Warning");
						if ($redirect) {
							App::Config()->redirect("/information/manage/{$type}");
						}
					}
					break;
				default:
					if (isset($definition['base']['parameters']['listview']) && strtolower($definition['base']['parameters']['listview']) == 'no') {
						App::Module('Notification')->Push("User access restricted.", "Warning");
						if ($redirect) {
							App::Config()->redirect('/admin/introduction');
						}
					}
					break;
			}
		}
		
        return $definition;
    }

    public function verifyCategorySetModifyAccessByAction($type = null, $action = null, $redirect = true) {

        $definition = app::__def()->getCategorySetDefinition($type);

        switch (strtolower($action)) {
            case 'add' :
                if (isset($definition['base']['parameters']['add']) && strtolower($definition['base']['parameters']['add']) == 'no') {
                    App::Module('Notification')->Push("Entry Add is restricted.", "Warning");
                    if ($redirect) {
                        App::Config()->redirect("/category/manage/{$type}");
                    }
                }
                break;
            case 'update' :
                if (isset($definition['base']['parameters']['edit']) && strtolower($definition['base']['parameters']['edit']) == 'no') {
                    App::Module('Notification')->Push("Entry edit is restricted.", "Warning");
                    if ($redirect) {
                        App::Config()->redirect("/category/manage/{$type}");
                    }
                }
                break;
            case 'view' :
                if (isset($definition['base']['parameters']['view']) && sstrtolower($definition['base']['parameters']['view']) == 'no') {
                    App::Module('Notification')->Push("Entry view is restricted.", "Warning");
                    if ($redirect) {
                        App::Config()->redirect("/category/manage/{$type}");
                    }
                }
                break;
            default:
                if (isset($definition['base']['parameters']['listview']) && strtolower($definition['base']['parameters']['listview']) == 'no') {
                    App::Module('Notification')->Push("User access restricted.", "Warning");
                    if ($redirect) {
                        App::Config()->redirect('/admin/introduction');
                    }
                }
                break;
        }

        return $definition;
    }

}
