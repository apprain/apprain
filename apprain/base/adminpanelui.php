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
class appRain_Base_Modules_AdminpanelUI extends appRain_Base_Objects {

    public function loadAdminLogin() {
        $lastLoginData = App::Model('Admin')->findAll('1=1 Order By lastlogin DESC');

        $html = "";
        foreach ($lastLoginData['data'] as $key => $data) {
            if ($data['lastlogin']) {
                if ($html != '') {
                    $html .= '<br />';
                }
                $html .= "<strong>{$data['f_name']} {$data['l_name']}</strong><br /> &nbsp;&nbsp;&nbsp;<em>" . $this->__(" on ") . App::Helper('Date')->dateFormated($data['latestlogin'], 'long') . '</em>';
            }
        }
        if ($html == '') {
            $html = 'No last activity yet.';
        }
        return $html;
    }

    public function senitizeLink($val = '') {
        $val = str_replace('{current_theme}', App::Config()->setting('theme'), $val);
        if (strstr($val, '{[ENCODE[')) {
            $link = "";
            foreach (explode('{[ENCODE[', $val) as $line) {
                if (strstr($line, ']]}')) {
                    $tmp = explode(']]}', $line);
                    $line = base64_encode($tmp[0]) . $tmp[1];
                }
                $link .= $line;
            }
            $val = $link;
        }
        return $val;
    }

    public function pageCount($type = 'Content') {
        $result = App::Model('Page')->find("contenttype='{$type}'", null, 'count(*) as cnt');
        return $result['cnt'];
    }

    public function adminName($id = null) {
        if (isset($id)) {
            $Info = App::Model('Admin')->findById($id);
        } else {
            $Info = App::AdminManager()->thisAdminInfo();
        }

        $name = "";
        $name .= isset($Info['f_name']) ? "{$Info['f_name']}" : "";
        $name .= isset($Info['l_name']) ? " {$Info['l_name']}" : "";
        $name .= isset($Info['name']) ? " {$Info['name']}" : "";
        return $name;
    }

    public function cacheChart() {
        $spaceEstimate = App::Load("Module/Developer")->cacheSpaceEstimate();
        $DataGrid = App::Module('DataGrid');
        $size = 0;
        foreach ($spaceEstimate as $space) {
            $DataGrid->addRow($space['title'], $space['size'] . $this->__("kb"));
            $size += $space['size'];
        }

        $DataGrid->setHeader(array('Cache Type', 'Size'))
                ->setFooter("Total memory size: {$size} kb")
                ->Render();
    }

    public function autoCompleteInfo($JSReferance = "") {
        $adminInfo = App::Model('Admin')->findAll();
        $data = Array();

        if (!empty($adminInfo['data'])) {
            foreach ($adminInfo['data'] as $val) {
                $data[] = $val['email'];
            }
        }

        return App::Helper('JavaScript')->autoComplete($JSReferance, $data);
    }

    public function staticPageLeftLinks($action, $type = 'staticpage', $id = null) {
        $page_arr = App::Pagemanager()->getData(null, null, "contenttype='Content'");
        $pageData = App::Pagemanager()->pages($id);
        $pageClass = 'open';
        $snipClass = 'open';
        $pageSelect = '';
        $snipSelect = '';

        if ($type == 'staticpage') {
            $snipClass = 'closed';
            $pageSelect = 'selected';
        } else {
            $pageClass = 'closed';
            $snipSelect = 'selected';
        }

        $chileClass = 'expended';

        $html = '<h6 id="h-menu-pages" class="' . $pageSelect . '"><a href="#pages"><span>Pages (' . count($page_arr['data']) . ')</span></a></h6>
                    <ul id="menu-pages" class="' . $pageClass . '">
                        <li class="' . (($action == 'create') ? 'selected' : '') . '"><a href="' . App::Config()->baseUrl('/page/manage/create') . '">New Page</a></li>
                        <li class="collapsible last">
                            <a href="#" class="collapsible minus">Manage Pages</a>
                            <ul class="' . $chileClass . '">';
        foreach ($page_arr['data'] as $val) {
            if ($id == $val['id'])
                $html .= '<li class="selected"><a href="' . App::Config()->baseUrl("/page/manage/update/{$val['id']}") . '">' . $val['name'] . '</a></li>';
            else
                $html .= '<li><a href="' . App::Config()->baseUrl("/page/manage/update/{$val['id']}") . '">' . $val['name'] . '</a></li>';
        }
        $html .= '</ul>
                        </li>
                    </ul>';

        $page_arr = App::Pagemanager()->getData(null, null, "contenttype='Snip'");
        $html .= '<h6 id="h-menu-snips" class="' . $snipSelect . '"><a href="#snips"><span>Snips (' . count($page_arr['data']) . ')</span></a></h6>
                    <ul id="menu-snips" class="' . $snipClass . '">
                        <li class="' . (($action == 'createsnip') ? 'selected' : '') . '"><a href="' . App::Config()->baseUrl('/page/manage-snip/create') . '">New Snip</a></li>
                        <li class="collapsible last">
                            <a href="#" class="collapsible minus">Manage Snips</a>
                            <ul class="' . $chileClass . '">';
        foreach ($page_arr['data'] as $key => $val) {
            if ($id == $val['id']) {
                $html .= '<li class="selected"><a href="' . App::Config()->baseUrl("/page/manage-snip/update/{$val['id']}") . '">' . $val['name'] . '</a></li>';
            } else {
                $html .= '<li><a href="' . App::Config()->baseUrl("/page/manage-snip/update/{$val['id']}") . '">' . $val['name'] . '</a></li>';
            }
        }
        $html .= '</ul>
                        </li>
                    </ul>';

        return $html;
    }

    public function pageCodesList() {
        $page_arr = App::Pagemanager()->getData();

        $snipCodeList = "";
        $pageCodeList = "";

        foreach ($page_arr['data'] as $val) {
            if ($val['contenttype'] == appRain_Base_Modules_Page::CONTENT) {
                $pageCodeList .= "{{name=UI type=staticpage name={$val['name']} autoformat=off}}<br />";
            } else {
                $snipCodeList .= "{{name=UI type=staticpage name={$val['name']} autoformat=off}}<br />";
            }
        }

        return '<div id="dialog-modal" title="All Page Codes">
                <strong>Page Codes</strong>
                <p>' . $pageCodeList . '</p>
                <strong>Snip Codes</strong>
                <p>' . $snipCodeList . '</p>
                </div>';
    }

    public function dashBoardLink() {
        $__AppConfig = App::Helper('Config');
        $params = $__AppConfig->get('params');

        if ((isset($params['controller']) && $params['controller'] == 'admin') &&
                (isset($params['action']) && $params['action'] == 'introduction')
        ) {
            return $__AppConfig->baseUrl('/admin/account');
        } else {
            return $__AppConfig->baseUrl('/admin/introduction');
        }
    }

    public function currentNavTitle($tabname = null) {
        $NAVList = App::Module('ACL')->getInterfaceBuilderDefinition();

        $title = '';
        if (isset($NAVList[$tabname])) {
            $title .= $NAVList[$tabname]['parent']['title'];
            $title .= app::__def()->SysConfig('ADMIN_PAGE_TITLE_SAPARATOR');
        }

        $title .= ucfirst(
                App::Load("Helper/Config")
                        ->Load('params')
                        ->get('action')
        );

        return $title;
    }

    public function currentDate() {
        return '<span style="color:#ffff99">' . App::Helper('Date')->getdate('l, jS F Y h:i:s A', App::Helper('Date')->getTime()) . '</span>';
    }

    public function themeInfo($currentTheme = "") {
        $theme_info = App::Load('Helper/Utility')->getDirLising(VIEW_PATH);
        $info = App::__Def()->getThemeInfo($currentTheme);
        if (!empty($info)) {
            return $this->__("Current Theme <strong>") . "{$info['name']}</strong>";
        } else {
            return 'None';
        }
    }

    public function LPCollapseLink() {
       // $collapseAdminLeftPan = App::Session()->Read('collapseAdminLeftPan');
       // $str = ($collapseAdminLeftPan) ? "&#187;" : "&laquo;";
		
		
		return App::Helper('Html')
                        ->LinkTag(
                                'javascript:void(0)', '&#x26F6;', array(
                            'style' => "text-decoration:none;color:yellow;font-size:18px;font-weight:bold;margin-top:8px;display:block;float:left;margin-left:10px",
                            'onclick' => "jQuery('#header').toggle();jQuery('#left').toggle();"
                                )
        );
		
        /*return App::Helper('Html')
                        ->LinkTag(
                                'javascript:void(0)', $str, array(
                            'style' => "text-decoration:none;color:#EEE;font-size:18px;font-weight:bold;margin-top:8px;display:block;float:left;margin-left:10px",
                            'onclick' => "jQuery(this).html('&#164;');jQuery(this).css('cursor','wait'); jQuery.ajax({url: siteInfo.baseUrl + '/admin/switchadminleftpan',context: document.body,success: function(){location.reload();}});"
                                )
        );*/
    }

    public function QNColumns() {
        $collapseAdminLeftPan = App::Session()->Read('collapseAdminLeftPan');
        return ($collapseAdminLeftPan) ? 4 : 3;
    }

    public function isAdminLeftPancollapsed() {
        return App::Session()->Read('collapseAdminLeftPan');
    }

    public function renderDashboardNAVS() {
        $DashBoardNAVs = App::Module('ACL')->getDashboardNAVS();
        echo '<table cellpadding="0" cellspacing="0" width="99%">';
        echo '<tr>';
        $track = 0;
        foreach ($DashBoardNAVs as $key => $val) {
            $arr_root = $val['child'];
            if (!empty($arr_root)) {
                foreach ($arr_root as $key1 => $val1) {

                    $fetchType = 'URL';
                    if (!empty($val1['adminicon'])) {
                        $fetchType = $val1['adminicon']['type'];
                        $icon_path = $val1['adminicon']['location'];
                    } else {
                        $icon_path = '/themeroot/admin/images/icons/' . App::Helper('utility')->text2Normalize($val1['title']) . '.jpg';
                    }

                    if (!file_exists(App::Config()->basedir("$icon_path")) && !file_exists(App::Config()->rootDir("$icon_path"))) {
                        $fetchType = 'URL';
                        $icon_path = '/themeroot/admin/images/icons/info.jpg';
                    }
                    if (strtolower($fetchType) == 'url') {
                        $icon = App::load("Helper/Html")->imgTag(App::Config()->baseurl($icon_path), null, array("height" => "40", "width" => "40"));
                    } else {
                        $icon = App::load("Helper/Html")->imgDTag(App::Config()->rootDir($icon_path), '/40/fix', array("height" => "40", "width" => "40"));
                    }
                    if ($track != 0 && $track % App::Module('AdminPanelUi')->QNColumns() == 0) {
                        echo "</tr><tr>";
                    }

                    echo '<td class="dashboard-quicklinks">';
                    echo "<h6>" . $this->__($val1['title']) . "</h6>";
                    echo '<div class="floatleft" style="margin-left: 20px;">';
                    echo $icon;
                    echo '</div>';
                    echo '<div style="float:left;padding:10px">';

                    foreach ($val1['items'] as $key2 => $val2) {
                        echo App::load("Helper/Html")->linkTag(App::Config()->baseurl(App::Module('AdminPanelUi')->senitizeLink($val2['link'])), $this->__($val2['title']));
                    }
                    echo '</div>';
                    echo '</td>';
                    $track++;
                }
            }
        }
        echo '</tr>';
        echo '</table>';
    }

    public function pageNameInputBox($action = null, $type = 'Content', $id = null) {

        if (strtolower($action) == 'create') {
            return App::Helper("Html")->inputTag("data[Page][name]", "", array("class" => "app_input check_notempty", "longdesc" => "A page name is required, Please use alpha numeric value without special character", "id" => "page_name"));
        } else {
            $page_arr = App::Load("Model/Page")->findAll("contenttype='{$type}'");

            $data = array();
            foreach ($page_arr['data'] as $key => $val) {
                $data[$val['id']] = $val['name'];
            }
            return App::Helper("Html")->selectTag('data[Page][id]', $data, $id, array("id" => "{$type}_id"), array("off_blank" => "Yes"));
        }
    }

}
