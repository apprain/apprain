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

class categoryController extends appRain_Base_Core
{
    /**
     * Controller Name
     * @type string
     */
    public $name = 'Category';

    /**
     * Index page of category controller
     *
     * @return null
     */
    private function index()
    {
        /* 
         * Hidden function not available 
         * in browser action  
         */
    }

    /**
     *  To manager categories
     *
     * @parameter type string
     * @parameter action string
     * @parameter id integer
     * @return null
     */
    public function manageAction($type = NULL, $action = NULL, $id = NULL)
    {

        // Read Definition
        $errors = Array();
		$definition = App::Module('ACL')->verifyCategorySetModifyAccessByAction($type,$action);		

        // Set admin tab
        $this->setAdminTab($definition['admin_tab']);
        $this->page_title = $definition['title'];
        /*
         * Add javascript addons
         */
        if (($action == "add") || ($action == "update")) {
            $this->addons = array('validation', 'rich_text_editor');
        }
        else {
            $this->addons = array('row_manager');
        }

        /**
         * Stop the script fo undefine
         * category access
         */
        if ($type == '') {
            die("Undefined Process... Category Type Missing");
        }
        /* Save category data */
        if (!empty($this->data)) {
            if (isset($this->data['Category']['parentid'])) {
                $this->data['Category']['parentid'] = !isset($this->data['Category']['is_parent'])
                    ? $this->data['Category']['parentid'] : "0";
            }

            if (strtolower($definition['image']['type']) == 'single') {
                if (isset($this->data['Category']['image']['name'])
                    && ($this->data['Category']['image']['name'] != "")
                ) {
                    $this->data['Category']['image'] = $this->processImageData($this->data['Category']['image']);
                    if ($action == 'update') $this->clearPreviouseImage($id);
                }
                else {
                    unset($this->data['Category']['image']);
                }
            }

            $pdo = App::CategorySet()->save_category($this->data);
            $errors = $pdo->getErrorInfo();

            if (empty($errors)) {
                App::Module('Notification')->Push("Updated successfully.");
                if (isset($this->post['Button']['button_save_and_update'])) {
                    $this->redirect('/category/manage/' . $type . '/update/' . $pdo->getId());
                }
				elseif (isset($this->post['Button']['button_save_and_add'])) {
                    $this->redirect('/category/manage/' . $type . '/add');
                }
                else {
                    $this->redirect('/category/manage/' . $type);
                }
                exit;
            }
        }

        /*
         * Get list to update
         */
        if ($action == 'update') {
            $update_data_list = App::Model('Category')
                ->find("id=$id");

            $this->set('update_data_list', $update_data_list);
        }

		if($action=='search'){
			$src = isset($this->get['src']) ? $this->get['src'] : '';
			$category_arr = App::Model('Category')->paging("type='{$type}' and (title like '%{$src}%' OR description like '%{$src}%') ORDER BY parentid ASC,title ASC",null,"?src={$src}");
			$this->set('data_list', $category_arr);
		}
		else{
			$category_arr = App::CategorySet($type)->setPagination(true)->getRecursive();
			//pre($category_arr );
			$this->set('data_list', $category_arr);
		}

        /* Set Category structure to view */
        $this->set('definition', $definition);

        $this->set('type', $type);
        $this->set('action', $action);
        $this->set('errors', $errors);
    }

    /**
     * A private function use in this controller
     * class and absent in browser action.
     *
     * @return null
     */
    private function clearPreviouseImage($id)
    {
        $catdata = App::Model('Category')->findById($id);

        if ($catdata['image'] != "") {
            $path = $this->get_config("filemanager_path") . "/{$catdata['image']}";
            App::Helper('Utility')->deleteFile($path);
        }
    }

    /**
     * A private function use in this controller
     * class and absent in browser action.
     *
     * @return null
     */
    private function processImageData($imgInfo = NULL)
    {
        $path = $this->get_config("filemanager_path") . "/";
        $file_data = App::Load("Helper/Utility")
            ->upload($imgInfo, $path);

        return $file_data['file_name'];
    }
}
