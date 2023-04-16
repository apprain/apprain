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
 * $this->CategorySet($type)->find()
 * $this->CategorySet($type)->findAll()
 * $this->CategorySet($type)->findByFieldname()
 * $this->CategorySet($type)->findAllFieldname()
 * $this->CategorySet($type)->Listing
 * $this->CategorySet($type)->getRecursive()
 * $this->CategorySet($type)->Parents()
 * $this->CategorySet($type)->GroupTag
 * $this->CategorySet($type)->Tag()
 * $this->CategorySet($type)->Save()
 */
class appRain_Base_Modules_CategorySet extends appRain_Base_Objects {

    /**
     * Base function to call Category Set
     *
     * @param $type String
     * @return Object
     */
    public function CategorySet($type = NULl) {
        $this->setFetchtype('categoryset');

        if (isset($type)) {
            $this->setCategorySetType(strtolower($type));
        }
        return $this;
    }

    /**
     * Call magic functions
     *
     * @param $method String
     * @param $params Array
     * @return Array
     */
    public function callCategorySetByFiled($method = NULL, $params = NULL) {

        $_type = $this->getCategorySetType();
        $params[0] = isset($params[0]) ? $params[0] : "";
        if (($field = str_replace("findby", "", strtolower($method))) != strtolower($method)) {

            switch ($field) {
                case "id" :
                    return App::Model('Category')->findById($params[0]);
                    break;

                default :
                    return $this->CategorySet()->find("{$field} ='{$params[0]}'");
                    break;
            }
        } else if (($field = str_replace("findallby", "", strtolower($method))) != strtolower($method)) {
            switch ($field) {
                case "id" :
                    return App::Model('Category')->findAll("id={$params[0]}");
                    break;

                default :
                    return $this->CategorySet()->findAll("{$field} ='{$params[0]}'");
                    break;
            }
        } else if (($field = str_replace("findall", "", strtolower($method))) != strtolower($method)) {
            $sqlPart = $this->fixAditionalCondition($params[0]);
            if (empty($sqlPart)) {
                return App::Model('Category')->findAll("(type = '{$_type}')");
            } else {
                return App::Model('Category')->findAll("(type = '{$_type}') and {$sqlPart}");
            }
        } else if (($field = str_replace("find", "", strtolower($method))) != strtolower($method)) {
            $sqlPart = $this->fixAditionalCondition($params[0]);
            if (empty($sqlPart)) {
                return App::Model('Category')->find("(type = '{$_type}')");
            } else {
                return App::Model('Category')->find("(type = '{$_type}') and {$sqlPart}");
            }
        }
    }

    public function fixAditionalCondition($cnd = NULL) {
        if (empty($cnd))
            return '';

        if ($ext = strstr(strtoupper($cnd), 'ORDER')) {
            $p1 = substr($cnd, 0, (strlen($cnd) - strlen($ext)));
            $p2 = substr($cnd, strlen($p1), strlen($cnd));

            return "($p1) $p2";
        } else if ($ext = strstr(strtoupper($cnd), 'LIMIT')) {
            $p1 = substr($cnd, 0, (strlen($cnd) - strlen($ext)));
            $p2 = substr($cnd, strlen($p1), strlen($cnd));

            return "($p1) $p2";
        } else {
            return "($cnd)";
        }
    }

    /**
     * Get category Title/Links base on category id(s)
     *
     * @param $ids String
     * @param $flag String
     * @param $hlink String
     * @param $options Array
     */
    public function IdToName($ids = NULL, $flag = "long", $hlink = "No", $options = NULL) {
        $a = array();
        if ($ids != "") {
            $id_arr = explode(',', $ids);
            foreach ($id_arr as $id) {
                $titles = array();
                $tmp_arr = $this->CategorySet()->findById($id);
                if (!empty($tmp_arr)) {
                    if (strtolower($hlink) == 'yes') {
                        if (isset($options['link-url'])) {
                            $titles[] = App::load("Helper/Html")->linkTag(str_replace("[id]", $id, $options['link-url']), $tmp_arr['title']);
                        } else {
                            $titles[] = App::load("Helper/Html")->linkTag(App::Helper('Config')->baseurl("/category/manage/" . $tmp_arr['type'] . "/update/$id"), $tmp_arr['title']);
                        }
                    } else {
                        $titles[] = $tmp_arr['title'];
                    }

                    while ($flag == "long" && $tmp_arr['parentid'] != 0) {
                        $tmp_arr = $this->CategorySet()->findById($tmp_arr['parentid']);

                        if ($tmp_arr['title'] != '') {
                            if (strtolower($hlink) == 'yes') {
                                if (isset($options['link-url'])) {
                                    $titles[] = App::load("Helper/Html")->linkTag(str_replace("[id]", $tmp_arr['id'], $options['link-url']), $tmp_arr['title']);
                                } else {
                                    $titles[] = App::load("Helper/Html")->linkTag(App::Helper('Config')->baseurl("/category/manage/" . $tmp_arr['type'] . "/update/$id"), $tmp_arr['title']);
                                }
                            } else {
                                $titles[] = $tmp_arr['title'];
                            }
                        }
                    }
                    $a[] = (count($titles) > 1) ? join(">>", array_reverse($titles)) : $titles[0];
                }
            }
        }
        return join(',', $a);
    }

    /**
     * Create a HTML Tag with category information
     *
     * @param $name string
     * @param $value String
     * @param $parameter Array
     * @param $options Array
     */
    public function Tag($name = NULL, $value = NULL, $parameter = NULL, $options = NULL) {

        /**
         * Define the root. We can set parent start as perametre so that it can start form any parent
         */
        $parent_start = isset($parameter['parent_start]']) ? $parameter['parent_start]'] : 0;
        $inputType = isset($parameter['inputType']) ? $parameter['inputType'] : "selectTag";
        $name = ($inputType == "checkboxTag" && substr($name,-2) != '[]') ? $name . "[checkbox][]" : $name;

        /**
         * Requesting for respactive category
         */
        $tmp = $this->CategorySet($this->getCategorySetType())->getRecursive($parent_start);

        $filter_node = isset($tmp['data'][0]['path_2']) ? 'path_2' : 'title';

        /*
         * Generate a 1D array for dropdown list
         */
        $data_arr = App::load("Helper/Utility")->get_1d_arr($tmp['data'], 'id', $filter_node);
		//$data_arr[''] = 'Select';

        /*
         * Return the HTML Deopdown list
         */
        return App::load("Helper/Html")->$inputType($name, $data_arr, $value, $options);
    }

    /**
     * Get category recutsively with Parent->Child Tree
     *
     * @param $pid Integer
     */
    public function getRecursive($pid = 0) {

        // Reset the global temp variable
        $this->tmp = array();
        $this->get_category_recursion($this->getCategorySetType(), $pid);

        if ($this->getPagination()) {
            return App::Helper('Utility')->arrayPaginator($this->tmp);
        } else {
            return array('data' => $this->tmp);
        }
    }

    /**
     * Fire the recursion to featch the category tree.
     *
     * @param $type String
     * @param $pid Integer
     * @param $padding1 String
     * @param $padding2 String
     */
    public function get_category_recursion($type = '', $pid = 0, $padding1 = '', $padding2 = '') {
        // Query data from DB
        //pre("type='{$type}' AND id={$pid}");
        $parent_arr = App::Model('Category')->find("type='{$type}' AND id='{$pid}'");

        $child_arr_arr = App::Model("Category")->findAll("type='{$type}' AND parentid={$pid}  ORDER BY title ASC");
        //pre($child_arr_arr);

        $parent_arr['title'] = isset($parent_arr['title']) ? $parent_arr['title'] : "";
        if ($parent_arr['title'] != '') {
            $padding1 .= '|___';
            $padding2 .= $parent_arr['title'] . '>>';
        }

        // Base case
        if (!empty($child_arr_arr['data'])) {
            foreach ($child_arr_arr['data'] as $key => $val) {
                $this->tmp[] = array(
                    'id' => $val['id'],
                    'adminref' => $val['adminref'],
                    'lastmodified' => $val['lastmodified'],
                    'entrydate' => $val['entrydate'],
                    'pid' => $val['parentid'],
                    'image' => $val['image'],
                    'title' => $val['title'],
                    'path_1' => $padding1 . $val['title'],
                    'path_2' => $padding2 . $val['title']
                );

                $this->get_category_recursion($type, $val['id'], $padding1, $padding2);
            }
        } else {
            return;
        }
    }

    /**
     * Get Category Information
     *
     * @param $type Stirng
     * @param $limit Integer
     * @param $flag String
     */
    public function get_category($type = NULL, $limit = NULL, $flag = "short") {
        $data_arr = App::Model("Category")->paging("type='$type'", $limit);

        if ($flag == "short") {
            $arr = array();
            foreach ($data_arr['data'] as $key => $val) {
                $arr[$val['id']] = $val['title'];
            }
            $data_arr['data'] = $arr;
        }

        return $data_arr;
    }

    /**
     * Save Category data
     *
     * @param $_data String
     * @return Object
     */
    public function save_category($_data = NULL) {
		
        $user = App::Load("Module/Session")->read('User');

        $data['Category'] = isset($_data['Category']) ? $_data['Category'] : $_data;

		if(!isset($data['Category']['type'])){
			$data['Category']['type'] = $this->getCategorySetType();
		}
        $data['Category']['adminref'] = isset($user['adminref']) ? $user['adminref'] : 0;
        $data['Category']['entrydate'] = isset($data['Category']['entrydate']) ? $data['Category']['entrydate'] : App::Load("Helper/Date")->getDate('Y-m-d H:i:s');
        $data['Category']['lastmodified'] = App::Load("Helper/Date")->getDate('Y-m-d H:i:s');

        return App::Model("Category")->save($data);
    }

    public function Save($_data) {
		
        return $this->save_category($_data);
    }

    /**
     * Delete Category data
     *
     * @param $id Integer
     * @return Object
     */
    public function delete_category($id = NULL) {
        App::Model("Category")->deleteById($id);
        return $this;
    }

    public function deleteCategoryById($id) {
        $catData = App::CategorySet()->findById($id);
        $this->deleteCategoryImage($catData['image']);
        App::Model("Category")->deleteById($id);

        return $this;
    }

    public function deleteCategoryImage($ref = "") {
        if (is_numeric($ref)) {
            $catData = App::CategorySet()->findById($ref);
            $ref = $catData['image'];
        } else if (is_array($ref)) {
            $catData = App::CategorySet()->findById($ref['id']);
            $ref = $catData['image'];
        }

        if ($ref != "") {
            $path = App::load("Helper/Config")->get('filemanager_base_dir') . "/{$ref}";
            if (file_exists($path))
                App::Helper('Utility')->deleteFile($path);
        }
    }

    public function Delete($id = null) {
        if (isset($id)) {
            $this->deleteCategoryById($id);
        } else {
            if ($this->getCategorysettype()) {
                $categories = App::CategorySet($this->getCategorysettype())->findAll();
                if (!empty($categories['data'])) {
                    foreach ($categories['data'] as $category)
                        $this->deleteCategoryById($category['id']);
                }
            }
        }
    }

    /**
     * Get All parent categoris
     *
     * @param $flag String
     * @return Object
     */
    public function Parents($flag = "long") {
        $data_arr = $this->CategorySet($this->getCategorySetType())->findAllByparentid(0);

        if ($flag == "short") {
            $arr = array();
            foreach ($data_arr['data'] as $key => $val) {
                $arr[$val['id']] = $val['title'];
            }
            $data_arr['data'] = $arr;
        }

        return $data_arr['data'];
    }

    /**
     * Get Group Select box
     *
     * @param $name Stirng
     * @param $category_type_arr Stirng
     * @param $value Stirng
     * @param $options Array
     * @return String
     */
    public function GroupTag($name = NULL, $category_type_arr = NULL, $value = "", $options = NULL) {
        $pt_str = isset($options) ? App::Helper('Html')->options2str($options) : '';
        $select_arr = ($value != "") ? explode('|', $value) : array("-", "-");
        $element = '';

        if (!empty($category_type_arr)) {
            $element = "<select name=\"$name\" $pt_str ><option value=\"\"></option>";
            foreach ($category_type_arr as $category_key => $category_type) {
                /*
                 * Requesting for respactive category
                 */
                $tmp = $this->CategorySet($category_type)->getRecursive();

                $filter_node = isset($tmp['data'][0]['path_2']) ? 'path_2' : 'title';
                $data_arr = array();
                $data_arr = App::Load("Helper/Utility")->get_1d_arr($tmp['data'], 'id', $filter_node);

                $element .= "<optgroup label=\"$category_type\">";
                foreach ($data_arr as $key => $val) {
                    if ($key == $select_arr[1]) {
                        $element .= "<option selected=\"selected\" value=\"$category_key|$key\">$val</option>";
                    } else {
                        $element .= "<option value=\"$category_key|$key\">$val</option>";
                    }
                }
                $element .= "</optgroup>";
            }
            $element .= "</select>";
        }

        return $element;
    }

    public function Listing($options = NULL) {
        $options['limit'] = isset($options['limit']) ? $options['limit'] : NULL;
        $options['flag'] = isset($options['flag']) ? $options['flag'] : NULL;
        return $this->get_category(
                        $this->getCategorySetType(), $options['limit'], $options['flag']
        );
    }

}
