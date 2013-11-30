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
 * @copyright  Copyright (c) 2010 appRain, Team. (http://www.apprain.com)
 * @license    http://www.opensource.org/licenses/mit-license.php MIT license
 *
 * HELP
 *
 * Official Website
 * http://www.apprain.com/
 *
 * Download Link
 * http://www.apprain.com/download
 *
 * Documents Link
 * http ://www.apprain.com/docs
 */

class pageController extends appRain_Base_Core
{
    public $name = 'Page';

    /**
     * This function will reander the home page
     *
     * @return null
     */
    private function index()
    {
    }

    /**
     * Mange static page
     *
     * @parameter id integer
     * @return null
     */
    public function manageAction($action = null, $id = NULL)
    {
        $errors = Array();
        $this->setAdminTab('page_manager');
        $this->addons = array('rich_text_editor');

		$this->loadFirstUri($action);
		
        if (!empty($this->data)) {

            if (isset($this->post['Button']['button_delete'])) {
                App::Load("Model/Page")->DeleteById($id);
                App::Module('Notification')->Push("Deleted successfully.");
				
				$this->loadFirstUri();
            }
            else {
                if (isset($this->data['Page']['hook']) and !empty($this->data['Page']['hook'])) {
                    $this->data['Page']['hook'] = implode(',', $this->data['Page']['hook']);
                }
                else {
                    $this->data['Page']['hook'] = '';
                }

                if ($action == 'create') {
                    $anpima = App::Config()->siteInfo('add_new_page_in_menu_automarically', 1);
                    if ($anpima != 'No') {
                        $this->data['Page']['hook'] = 'sitemenu';
                        $this->data['Page']['rendertype'] = 'smart_h_link';
                    }
                }

                if (isset($this->data['Page']['name'])) {
                    $this->data['Page']['name'] = App::Helper('Utility')->text2NOrmalize($this->data['Page']['name']);
                }
                $result = App::Load("Model/Page")->Save($this->data);
                $errors = $result->getErrorInfo();

                if (empty($errors)) {
                    App::Module('Notification')->Push("Updated successfully.");
                    $this->redirect("/page/manage/update/" . $result->getId());
                    exit;
                }
                else {
                    App::Module('Notification')->Push(implode("<br />", $errors), Array('level' => 'Error'));
                }

            }
        }

       if ($action == 'ues') {
            $page = App::PageManager()->Pages($id);
            $newstatus = ($page['richtexteditor'] == 'Yes') ? 'No' : 'Yes';
            $obj = App::Model('Page')->setId($id)
                ->setRichtexteditor($newstatus)
                ->Save();
            $this->redirect("/page/manage/update/{$id}");
            exit;
        }
			
        $name = App::PageManager()->FieldValueById($id,'name');
        $this->set("action", $action);
        $this->page_title = ucfirst($action) . app::__def()->SysConfig('ADMIN_PAGE_TITLE_SAPARATOR') . "{$name}" . app::__def()->SysConfig('ADMIN_PAGE_TITLE_SAPARATOR') . "Page Manager";
		
		$this->set("page_type", 'staticpage');
        $this->set("id", $id);
	
    }

	public function manage_snipAction($action = "", $id = NULL){
		$this->setAdminTab('page_manager');
		$this->addons = array('ace');
		$this->loadFirstUri($action,'Snip');	
			
		if ($action=='delete') {
			App::Load("Model/Page")->DeleteById($id);
			App::Module('Notification')->Push("Deleted successfully.");
			
			$Page = App::Model("Page")->find("contenttype='Snip'");
			if(!empty($Page)){
				$this->redirect("/page/manage-snip/update/{$Page['id']}");
			}
			else {
				$this->redirect("/page/manage-snip/create");
			}
			exit;
		}
		
		if (!empty($this->post)) {		
			if($action == 'create'){
				$data = App::Model('Page')->findByName($this->data['Page']['name']);
				if(!empty($data)){
					echo App::Module("Cryptography")
					   ->jsonEncode(
						  array(
							  "_status" => 'Error',
							  "_message" => 'File Name already exists.'
						   )
					   );
				}
				else{
					$obj = App::Model("Page")
						->setName($this->data['Page']['name'])
						->setContentType('Snip')
						->Save();
					echo App::Module("Cryptography")
					   ->jsonEncode(
						  array(
							  "_status" => 'Redirect',
							  "_location" => App::Config()->baseUrl("/page/manage-snip/update/" . $obj->getId())
						   )
					   );;
				}
				exit;
			}
			else{
				$this->data['Page']['contenttype'] = 'Snip';	
				$result = App::Model("Page")
					->setId($this->post['id'])
					->setContentType('Snip')
					->setContent($this->post['html'])
					->Save();
			}
			exit;
        }	
		
		$name = App::PageManager()->FieldValueById($id,'name');
        $this->set("action", $action);
        $this->page_title = ucfirst($action) . app::__def()->SysConfig('ADMIN_PAGE_TITLE_SAPARATOR') . "{$name}" . app::__def()->SysConfig('ADMIN_PAGE_TITLE_SAPARATOR') . "Page Manager";
		$this->set("page_type", 'snip');
		$this->set("id", $id);
	}

	private function loadFirstUri($action='',$type='Content'){
		
		if($action==''){
			$Page = App::Model("Page")->find("contenttype='{$type}'");
			$UriPart = ($type == 'Content') ? 'manage' : 'manage-snip';
			if(!empty($Page)){
				$this->redirect("/page/{$UriPart}/update/{$Page['id']}");
			}
			else {
				$this->redirect("/page/{$UriPart}/create");
			}
			exit;
		}
		
	}
	
	
    /**
     * View page content by default it set to about us
     *
     * @parameter page_name string
     * @return null
     */
    public function viewAction($page_name = 'about_us')
    {
        $page_content = $this->staticPageNameToMetaInfo($page_name);

        if ($page_content['contenttype'] == 'Snip') {
            $this->redirect("/");
            exit;
        }

        $this->set("selected", $page_name);
        $this->set("section_title", $page_content['title']);
        $this->set('page_content', $page_content);
    }
}