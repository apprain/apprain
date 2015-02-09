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
 * @copyright  Copyright (c) 2010 appRain, Inc. (http://www.apprain.com)
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
 * http ://www.apprain.com/documents
 */
class blogController extends appRain_Base_Core
{
    public $name = 'Blog';

    /**
     * Execute before the action
     */
    public function __preDispatch()
    {

        $this->set("section_title","Blog");
        $this->set("selected","blog");
    }

    /**
     * This is blog starting page
     * We have configure this page from
     * URI_Manager >> Boot_Router
     */
    public function indexAction($action=null, $id=null,$page = 1)
    {
        // Fetch a page from Page Manager and
        // set Meta information.
        $homepage = $this->staticPageNameToMetaInfo('Blog');

        if($action == 'bypost'){
            // Fetch a Single Post from Information Set
            // by Post Id
            $post = App::InformationSet('blogpost')->findById($id);
            $this->set('post',$post);
			$this->set("catid",$post['category']);

            // Overwrite the page title
            $this->page_title = $post['title'];

            // Fetch all Comments for a particuler post
            $comments = App::Model('BlogComment')->findAll("postid={$id} AND status='Active'");
            $this->set('comments',$comments);
        }
        else if($action == 'bycat'){
            /**
             * See we can how we can optimize the pagination
             * You can make it more easier as per need
             */
            $blogpost = App::InformationSet('blogpost')->paging("category={$id}",App::Config()->setting('blogsettings_list_per_page',10));
            $this->set('blogpost',$blogpost);

            // Overwrite the page title
            $this->page_title = App::CategorySet()->idToName($id);
           $this->set("catid",$id);
        }
        else{
            /**
             * See we can how we can optimize the pagination
             * You can make it more easier as per need
             */
            $page = is_numeric($action) ? $action : 1;
            $blogpost = App::InformationSet('blogpost')
                ->paging("1 ORDER BY id DESC",15);
			$this->set('blogpost',$blogpost);			
        }

        // Assign Common values
        // in template
        $this->set("action",$action);
        
    }

    /**
     * This page is called by an AJAX
     * request. We have have set the layout "empty"
     *
     * Empty layout never attach any template from "View"
     */
    public function submitcommentAction($id=null)
    {
        if(empty($this->data)){
			$this->redirect("/");
		}
		
        // Set Empty Layout
        $this->layout = 'empty';

        // This is an simple example of Capture response by AppException Handaler
        // Hope you will like it
        // AJAX SUBMIT Helper capture response in JSON Formate
        // See Referance in Manual section from appRain official site
        try {
            $capacha = App::Module('Session')->read('capacha');

            if($capacha['blogcommet'] != $this->data['BlogComment']['capacha']){
                throw new AppException($this->__("Please fillin the text display left side image correctly."));
            }

            // Save Comments
            // Please apply more logic if you needed
            $this->data['BlogComment']['postid'] = $id;
            $this->data['BlogComment']['status'] = 'Inactive';
            $this->data['BlogComment']['dated'] = App::Helper('Date')->getDate("Y-m-d H:i:s");
			
            $obj = App::Model('BlogComment')->Save($this->data);
			
            // Send Email notification using
            // Template Manager Helper
            App::Helper('EmailTemplate')
				->setParameters(
					Array(
						'Name'=>$this->data['BlogComment']['name'],
						'Comment'=>$this->data['BlogComment']['comment'],
						'EmailAddress'=>$this->data['BlogComment']['email'],
						'Website'=>$this->data['BlogComment']['website']
					)
				)
                ->prepare('BlogComment',true);

            $status = 'Success';
            throw new AppException($this->__("Thank you, Your comment is waiting for approval."));
        }
        catch (AppException $e){
            // Catch exceptions and display message
            // in JSON format using Cryptography Helper
			$status = (isset($status) ? $status : 'Error');
            echo App::Load("Module/Cryptography")
				->jsonEncode(
					array(
						"_status" =>(isset($status) ? $status : 'Error'),
						"_message"=> App::Html()->getTag('span',array('class'=>strtolower($status)),$e->getMessage())
					)
				);
        }
    }

    /**
     * Manage Blog Comments
     * We have render this page under Blog tab
     * in admin panel.
     */
    public function managecommentAction($action=null, $id = null)
    {
        // Set Admin Tab
        $this->setAdminTab('blog');

        // Update the post if
        // the action is set to 'update'
        if($action == 'update'){

            if(!empty($this->data)){
			
                $this->data['BlogComment']['id'] = $id;
                $this->data['BlogComment']['dated'] = date('Y-m-d H:i:s',strtotime("{$this->data['BlogComment']['dated']['year']}-{$this->data['BlogComment']['dated']['month']}-{$this->data['BlogComment']['dated']['day']} {$this->data['BlogComment']['dated']['hour']}:{$this->data['BlogComment']['dated']['munite']}:{$this->data['BlogComment']['dated']['second']}"));
                App::Model('BlogComment')->Save($this->data);

				App::Module('Notification')->push("Comment updates successfully");
                $this->redirect("/manage-comments");
                exit;
            }

            $comment = App::Model('BlogComment')->findById($id);
            $this->set("comment",$comment);
            $this->set('id',$id);
        }
        else{
            // Fetch all comments form 'Comment' model
            // and assign to template
            $comments = App::Model('BlogComment')->paging("1 ORDER BY id DESC");
            $this->set("comments",$comments);
        }

        $this->set("action",$action);
    }
}
