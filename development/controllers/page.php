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
     * Manage Static Pages
     *
     */	 
	public function manage_static_pagesAction($action = null, $id = NULL)
	{
		// Set admin tab
		$this->setAdminTab('page_manager');
		$this->addons = array('rich_text_editor','row_manager');
		
		if(!empty($this->data)){
			$this->layout = 'empty';
            try {
				
				if(empty($this->data['Page']['name'])){
					throw new AppException('Enter a page name');
				}
				if ($action == 'create') {
					$Page = App::Model('Page')->findByName($this->data['Page']['name']);
					if(!empty($Page)){
						throw new AppException('Page name already used');
					}
                    $anpima = App::Config()->siteInfo('add_new_page_in_menu_automarically', 1);
                    if ($anpima != 'No') {
                        $this->data['Page']['hook'][] = 'sitemenu';
                        $this->data['Page']['rendertype'] = 'smart_h_link';
                    }
                }
				$this->data['Page']['hook'] = isset($this->data['Page']['hook']) ? $this->data['Page']['hook'] : '';
				if(!empty($this->data['Page']['hook'])){
					$this->data['Page']['hook'] = implode(',', $this->data['Page']['hook']);
				}
				$this->data['Page']['id'] = $id;
				
				$obj = App::Model("Page")->Save($this->data);
				
				if(empty($id)){
					echo App::Load("Module/Cryptography")
						->jsonEncode(array(
							"_status" => 'redirect',
							"_location" => App::Config()->baseUrl('/page/manage-static-pages/update/' . $obj->getId())
						)
					);
				}
				else{
					echo App::Load("Module/Cryptography")
						->jsonEncode(array(
							"_status" => 'Success',
							"_message" => App::Html()->getTag('strong',array('style'=>'color:green'),$this->__("Page Saved successfully"))
						)
					);
				}					
            }
            catch (AppException $e) {
                echo App::Load("Module/Cryptography")
                    ->jsonEncode(
                    array(
                        "_status" => 'Error',
                        "_message" => App::Html()->getTag('strong',array('style'=>'color:red'),$e->getMessage())
                    )
                );
            }
			exit;
		}
		
		if(isset($id)){
			$page = App::Model('Page')->findById($id);
			$this->set("Page", $page);
			$this->set('admin_content_full_length',true);
		}
		else{
			$list = App::Model('Page')->Paging("contenttype='Content' ORDER BY name ASC");
			$this->set("List", $list);
		}
		
		$this->set("action", $action);
		$this->set("id", $id);
	}
	
	public function manage_dynamic_pagesAction($action = null, $id = NULL){
		$this->setAdminTab('page_manager');
		$this->addons = array('ace','row_manager');
		
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
							  "_location" => App::Config()->baseUrl("/page/manage-dynamic-pages/update/" . $obj->getId())
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
		
		if(isset($id)){
			$page = App::Model('Page')->findById($id);
			$this->set("Page", $page);
			$this->set('admin_content_full_length',true);			
		}
		else{
			$list = App::Model('Page')->Paging("contenttype='Snip'");
			$this->set("List", $list);
		}
		//$name = App::PageManager()->FieldValueById($id,'name');
        $this->set("action", $action);
       // $this->page_title = ucfirst($action) . app::__def()->SysConfig('ADMIN_PAGE_TITLE_SAPARATOR') . "{$name}" . app::__def()->SysConfig('ADMIN_PAGE_TITLE_SAPARATOR') . "Page Manager";
		$this->set("page_type", 'snip');
		$this->set("id", $id);
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