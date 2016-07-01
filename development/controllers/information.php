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


class informationController extends appRain_Base_Core
{
    /* Controller Name */
    public $name = 'Information';

    /**
     * A restricted index page
     * This function is hidden 
     * from browser action 
     *
     * @return null
     */
    private function index( $msg = NULL)
    {
    }

    /**
     * Manage all information set
     *
     * $parameter type string
     * $parameter action string
     * $parameter id integer
     * $parameter page  integer
     * @return null
     */
    public function manageAction( $type = NULL , $action = NULL, $id = NULL, $page = NULL )
    {
        /**
         * - Read Information Set defination 
         * - Set admin TAB and check login Authentication
         */
		$definition = App::Module('ACL')->verifyInformationSetModifyAccessByAction($type,$action);	
        $this->setAdminTab($definition['base']['admin_tab']);

        /* Current user id to keep trac data profiling */
       
        $this->page_title   = $definition['base']['title'];

        /* Set addons */
        $definition['base']['addons'] = isset($definition['base']['addons'])?$definition['base']['addons']:Array();
        $this->addons = array_merge($definition['base']['addons'],array('validation','rich_text_editor','row_manager'));
        $errors = Array();

         /* Save  Information Set */
        if( isset( $this->data['Information']))
        {
            /* Formate data from in a proper way */
            $this->data = $this->format_data($type,$this->data,$id);


            /* Run call backfunction before saving Information Set */
            $this->_before_information_set_save(array("type"=>"$type"));
			$this->data['Option']['id']	= $this->data['Information']['id'];
			$data = array("Information"=>$this->data['Option']);
			
            /* Save Information Set */
            $InfoSetObj = App::InformationSet($type)->save($data);

            /* Call back after saving Information Set */
            $this->_after_information_set_save(
                array(
                    "type" => "$type",
                    "id" => $InfoSetObj->getId()
                )
            );

            $errors = $InfoSetObj->getErrorInfo();

            if(empty($errors)) {
                /* Page to redirect */
                $page = ( $this->data['Information']['page'] !='' ) ? '?page=' . $this->data['Information']['page'] : '';
                
                App::Module('Notification')->Push("Updated successfully.");

                /* Redirect to user control */
                if(isset($this->post['Button']['button_save_and_update'])) {
                    $this->redirect('/information/manage/' . $type . '/update/' . $InfoSetObj->getId()  );
                }
                else if( isset($this->post['Button']['button_save_and_add'])) {
                    $this->redirect('/information/manage/' . $type . '/add'  );
                }
                else {
                    $this->redirect('/information/manage/' . $type . $page );
                }
                exit;
            }
        }
        
		if($action == 'copy'){
			$data = App::InformationSet($type)->findById($id);
			$data['id'] = null;
			$Data['Information'] = $data;

			$InfoSetObj = App::InformationSet($type)->Save($Data);
			App::Module('Notification')->Push("Copied Successfully");
			$this->redirect('/information/manage/' . $type . '/update/' . $InfoSetObj->getId()); 
			exit;
		}
        else if (isset($id)) {
            $this->_on_information_set_view(
                array(
                    "type"  => "{$type}",
                    "id"    => $id
                )
             );             
            $data = App::InformationSet($type)->findById($id);
        }
        else  {
			$data = App::informationSet($type)
				->paging(
					$this->conditions()->getSearchCondition()
					,NULL,
					$this->conditions()->getSearchParams()
				);				
        }

        /* Count total entry */
        $entry_total =  App::informationSet($type)->countEntry();

        /* Set some variables to output */        
        $this->set('data_list', $data);
        $this->set('type', $type);
        $this->set('page', $page);
        $this->set('action', $action);
        $this->set('definition', $definition);
        $this->set('errors', $errors);
        $this->set('entry_total', $entry_total);
    }
	
	private function conditions(){
	
		$ordtype = isset($this->get['order']) ? $this->get['order'] : 'asc';

		$newordtype = ($ordtype=='asc') ? 'desc' : 'asc';
		$this->set('newordtype',$newordtype);
		
		$ordfield = isset($this->get['field']) ? $this->get['field'] : 'id';
		$this->set('ordfield', $ordfield);
		
		$src_key = isset($this->get['src_key']) ? $this->get['src_key'] : '';
		$this->set('src_key', $src_key);
		
        $src_field = isset($this->get['src_field']) ? $this->get['src_field'] : '';
		$this->set('src_field', $src_field);
		
        $src_cat = isset($this->get['src_cat']) ? $this->get['src_cat'] : '';
		$this->set('src_cat', $src_cat);
		
		$str = '1=1';
		$params = "";
		if(!empty($src_key) && !empty($src_field)){ 
			$str .= " AND {$src_field} LIKE '%{$src_key}%' ";			
			$params .= "src_key={$src_key}&amp;src_field={$src_field}";
		}
		
		if(!empty($src_cat)){
			$str .= " AND " . str_replace("|", "='", $src_cat) . "'";
			
			if($params == ''){
				$params .= "src_cat={$src_cat}";
			}
			else {
				$params .= "&amp;src_cat={$src_cat}";
			}
		}	 

		$this->setSearchCondition("{$str} ORDER BY {$ordfield} {$newordtype}");
		$this->setSearchParams("?" . "order={$ordtype}&field={$ordfield}&amp;" . $params);
		$this->set('searchparams',"?" . $params);
		return $this;
	}

    /**
     * Formate post data to save Information Set
     *
     * $parameter type string
     * $parameter formated_data array
     * $parameter id integer
     * @return array
     */
    private function format_data( $type = NULL, $formated_data = NULL, $id = NULL)
    {
        $definition = app::__def()->getInformationSetDefinition($type);

        foreach( $definition['fields'] as $field => $def){
            switch($def["type"]){
            
                /* Formate fileTag data */
                case "fileTag" :                    
                    $path = App::Config()->filemanagerDir(DS);
                    
                    if (isset($formated_data["Information"]["id"])){
                        $previouse_info = App::informationSet($type)->findById( $formated_data["Information"]["id"] );
                    }

                    $previouse_file = isset($previouse_info[$field]) 
                                      ? $previouse_info[$field] : "";

                    if( $formated_data["Option"][$field]["name"] != ""){
                    
                        /* Clear garbaze file from disc */
                        if ((file_exists( $path . $previouse_file)) 
                            && ($previouse_file != "")
                        ){
                            @unlink( $path . $previouse_file );
                        }

                        /* Upload files */
                        $file_data = App::Load("Helper/Utility")->upload($formated_data["Option"][$field],$path);

                        /* Resize the if the file an image */
                        if( App::Load("Helper/Utility")->is_image($file_data["file_name"])){
                            $w = isset($def["parameters"]["maxwidth"]) ? $def["parameters"]["maxwidth"] : NULL;
                            $h = isset($def["parameters"]["maxheight"]) ? $def["parameters"]["maxheight"] : NULL;

                            if( isset($w) || isset($h)){
                                $np = $path . "/" . $file_data["file_name"];
                                App::Load("Helper/Utility")->createThumb($np,$np,$w,$h);
                            }
                        }
                        $formated_data["Option"][$field] = $file_data["file_name"];
                    }
                    else {
                        $formated_data["Option"][$field] = $previouse_file;
                    }
                    break;
                    
            }
        }
        
        /* Return Formated Data */
        return $formated_data;
    }

    /**
     * Export Information Set Data
     */
    public function exportAction($type = NULL)
    {
        /* Export and Download Data */
        App::InformationSet($type)
            ->setExporttype($this->data['Export']['type'])
            ->export(true);
    }
	
	public function delete_rowAction($type=null,$id=null)
	{	
		$this->layout = 'blank';
		$this->check_admin_login();   
		$data = App::InformationSet($type)->findById($id);

		if(empty($data)){
			die('Invalid Request');
		}		
				
		App::Module('ACL')->verifyInformationSetModifyAccessByAction($type,'delete',false);	
		App::InformationSet($type)->deleteById($id);
	}
}
