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

class commonController extends appRain_Base_Core
{
    public $name = 'Common';
    public $layout = 'blank';

    /**
     * This function is absent in 
     * browser action request
     *
     * return NULL
     */
    private function indexAction()
    {
        die();
    }
    
    /**
     * Used to resize any image dynamically based on
     * parameters send in GET request
     *
     * Example:
     * -----------------------------
     * www.mysite/common/get_image/aW1nL2QuanBn/.5          : Resize 50% of orginal image
     * www.mysite/common/get_image/aW1nL2QuanBn/1           : Resize 100% of orginal image
     * www.mysite/common/get_image/aW1nL2QuanBn/100/fix     : Resize to 100px of orginal image
     *
     * @return byte-stream
     */
    public function get_imageAction( $file = NULL,  $size = NULL,$resize_flag = 'per' )
    {
        $this->layout   ='blank';
        $file =  base64_decode($file);

		if(!App::Helper('Validation')->isImage($file) || !file_exists($file)){
			return null;
		}
		
		$imagedata      = GetImageSize($file);
  
        $width          = $imagedata[0];
        $height         = $imagedata[1];
        $imagetype      = $imagedata[2];

        // Setting the resize parameters
        list($width, $height) = getimagesize($file);

		
        
        if ($resize_flag == 'per') {
            $modwidth = $width * $size;
            $modheight = $height * $size;
        }
        else {
            $modwidth = $size;
            $modheight = round(( $height * $size ) / $width);
        }
         
        /**
         * Render image based on the 
         * image type
         */
        if ($imagetype==2) {
            header('Content-type: image/jpeg');
            $tn = imagecreatetruecolor($modwidth, $modheight);
			//pre($file);
            $image = imagecreatefromjpeg($file);
			//pre($image);
            imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height);
            imagejpeg($tn, null, 100);
            imagedestroy($tn);
            imagedestroy($image);
        }
        elseif ($imagetype == 3) {

            header('Content-type: image/png');
            $tn = imagecreatetruecolor($modwidth, $modheight);
            $image = imagecreatefrompng($file);
			//////////////
			imagealphablending($tn, false);
            imagesavealpha($tn, true);
            $transparent = imagecolorallocatealpha($tn, 255, 255, 255, 127);
            imagefilledrectangle($tn, 0, 0, $modwidth, $modheight, $transparent);
			//////////////
			
			
            imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height);
            imagepng($tn);
            imagedestroy($tn);
            imagedestroy($image);
        }
        else {
            header('Content-type: image/gif');
            $tn = imagecreatetruecolor($modwidth, $modheight);
            $image = imagecreatefromgif($file);
            imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height);
            imagegif($tn, null, 100);
            imagedestroy($tn);
            imagedestroy($image);
        }
    }

    /**
     * An general function use to delete data
     * in the grid as per bulk request.
     * 
     * It's a very secure function please
     * mantain authonication to during 
     * Edit/Update it
     */
    public function deletegroupAction($mode=null,$ids=null)
    {
        /** 
         * Set layout  to empty to
         * avoid unnecessary data. 
         */
        $this->layout = 'empty';
        $this->check_admin_login();
        
        $ids = App::Module('Cryptography')->jsonDecode($this->post['ids']);
		
		if(strstr($mode,'informationset')){
			$type = substr($mode,15,strlen($mode));
			$mode = substr($mode,0,14);
		}
        if (!empty($ids)) { 
            switch($mode) {
                case "informationset":  
                    /* Information Set Batch Delete */					
                    foreach ($ids as $id) {
                        App::informationset($type)->DeleteById($id);
                    }
                    break;
                                    
                case "categoryset" :
                    /* Category Set Batch Delete */
                    foreach ($ids as $id) {
                        App::Categoryset()
                            ->setDeletedRow($id)
                            ->Delete($id);
                    }
                    break;
                                    
                default :
                    /* Category Set Batch Delete */
                    foreach ($ids as $id) {
                        App::Model($mode)
                            ->setDeletedRow($id)
                            ->deleteById($id);
                    }
                    break;

            }
        }

        // Register a message notification
        App::Module('Notification')->Push("Deleted successfully.");
    }

    /**
     * An general function use to delete data
     * in the grid as per AJAX request.
     * 
     * It's a very secure function please
     * mantain authonication to during 
     * Edit/Update it
     */
    public function delete_rowAction( $model = NULL, $id = NULL)
    {
        $this->check_admin_login();    
        $this->layout = 'empty';

        if(isset($model)) {
            switch( $model ) {
                case "delete_sitesettings_file" :
                    $image = App::Helper('Config')->siteInfo($id);
                    $path = $this->get_config("filemanager_path") . "/{$image}";
                    
                    if(file_exists($path)) {
                        unlink($path);
                    }
                    App::Helper('Config')->setSiteInfo($id,'');
                    break;
                    
                case "delete_categoryset_file"    : 
                    /* Clear Category Fiels */
                    $catData = App::CategorySet()->findById($id);
                    $path = $this->get_config("filemanager_path") . "/{$catData['image']}";
                    
                    App::Helper('Utility')->deleteFile($path);
                    
                    App::Model('Category')
                        ->setImage('')
                        ->setId($id)
                        ->Save();
                    break;
                    
                case "delete_informationset_file" : 

					$info_dta = explode('|',$id);
                    $data = App::informationSet($info_dta[2])->findById($info_dta[1]);					
					$path = App::Config()->baseDir() .  DS . $this->get_config('filemanager_path') . DS . $data[$info_dta[0]];
				
					try{
						if(file_exists($path) && !empty($data[$info_dta[0]])){
							if(!unlink($path)){
								throw new AppException($this->__("Could no remove file from server, check file permission."));
							}
						}						
						$obj = App::informationSet($info_dta[2])
	                    ->Save(
							array(
								'Information'=>array(
									'id'=>$info_dta[1],
									$info_dta[0]=>''
								)
							)
						);
						if($obj->getErrorInfo()){
							throw new AppException(
							$this->__("Sorry! Could not delete the file, Check system Database field\n"));
						}
					}
					catch (AppException $e) {
						echo $e->getMessage();
					}		
                    break;
                    
                case "Information":                 
                    /* Delete Information Set */
                    App::informationset()
                        ->setDeletedRow($id)
                        ->Delete($id);
                    break;
                    
                case "Category":
                    /* Delete Category Set */
                    App::Categoryset()
                        ->setDeletedRow($id)
                        ->Delete($id);
                    break;
                    
                default:
                    /* Delete entry from model */
                    App::Model($model)
                        ->setDeletedRow($id)
                        ->deleteById($id);
                    break;
            }
        }
    }



    /**
     * A function to support multiple uploader addon
     *
     * @return null
     */
    public function batchuploadAction($upload_path = "")
    {
		$this->layout = 'empty';
		if(App::Config()->setting('flash_file_uploader','No') == 'Yes'){
		
			if (empty($_FILES)) {
				die();
			}
			
			$this->layout = "empty";

			$utility = App::Load("Helper/Utility");
			$restrictedExt = explode(',',app::__def()->sysConfig('FILE_MANAGER_RESTRICTED_EXT'));

			/* Check if there any HTTP ERROR */
			if ((!isset($_FILES["Filedata"]))
				 || (!is_uploaded_file($_FILES["Filedata"]["tmp_name"])) 
				 || ($_FILES["Filedata"]["error"] != 0)
			){
				header("HTTP/1.1 500 File Upload Error");

				if (isset($_FILES["Filedata"])) {
					echo $_FILES["Filedata"]["error"];
				}
				exit(0);
			}
			elseif (in_array(strtolower($utility->getExt($_FILES["Filedata"]['name'])),$restrictedExt)) {
			
				header("HTTP/1.1 401 Restricted by admin");
				echo $this->__("Upload failed! File type is restricted by admin.");
				exit(0);
			}

			/* Generate upload path */
			if ($upload_path == ""){
				$upload_path = App::Config()->filemanagerDir(DS);
			}
			else {
				$upload_path = base64_decode($upload_path);
			}

			App::Load("Helper/Utility")->upload($_FILES["Filedata"],"{$upload_path}");
			echo "1";
		}
		
		die();
    }

    /**
     * Generate capacha
     *
     * @return NULL
     */
    public function get_capachaAction($name = "image0",$options = NULL)
    {
        /* Decode the parematers */
        $name = base64_decode($name);
        $arr = explode(',',base64_decode($options));
        $back_color = App::Load("Helper/Utility")->HexToRGB($arr[0] );
        $fore_color = App::Load("Helper/Utility")->HexToRGB($arr[1] );

        /* Set layout */
        $this->layout = 'blank';

        /* Set image header */
        header("Content-type: image/png");

        /* Capacha text */
        $string =  rand(1000,9999);

        /* Register the session */
        App::Load("Module/Session")
            ->write(
                'capacha',
                array(
                    $name => $string
                )
            );

        /* Set image size */
        $im = imagecreatefromgif(App::Config()->baseDir("/images/capachabg.gif")); //imagecreate(100, 30);

        /* Set color */
        $bg = imagecolorallocate($im, $back_color["r"], $back_color["g"], $back_color["b"]);
        $orange = imagecolorallocate($im, $fore_color["r"], $fore_color["g"], $fore_color["b"]);

        /* Set out put */
        $px     = (imagesx($im) - 7.5 * strlen($string)) / 2;
        imagestring($im, 3, $px, 9, $string, $orange);
        imagepng($im);
        imagedestroy($im);
        exit;
    }

    /**
    * Downlaod any server file
    * 
    * Example: 
    * http://www.abc.com/common/downlaod/base64_encode(/home/public_html/myfile.pdf))
    *
    * @parameter dwn_path string (Base 64 encoded file path)
    * @return NULL
    */
    public function downloadAction( $dwn_path = NULL)
    {
        /* Decode the file */
        $dwn_path = base64_decode($dwn_path);
		$file_name = '';
		
        /* Check the file if exists */
        if( @file_exists($dwn_path)) {
            $tmp = @explode( "/", $dwn_path);
            $file_name = @end($tmp);
            $tmp = @explode( ".", $file_name);
            $ext = @end($tmp);

            @header("Content-type:{$ext}");
            @header("Content-Disposition: attachment; filename=\"{$file_name}\"");
            @readfile($dwn_path);
        }
        else {
            /*  Die if no file exists */
			if(!empty($dwn_path)){
				$tmp = @explode( "/", $dwn_path);
				$file_name = @end($tmp);
				$tmp = @explode( ".", $file_name);
				$ext = @end($tmp);
			}
			
            die("Sorry {$file_name}! <br /> File is not available or moved!  Please try after sometime.");
        }
    }

    /**
     * Render dynamic CSS from 
     * - Collected Component css block
     * - Any css added in template file
     */
    public function default_cssAction()
    {
        @header("Content-type:text/css");
		
		echo "/*
*  File Defination
*  - Website CSS Section
*
*  Template Name : {$this->theme}
*  Project Name    : {$this->get_config('site_title')}
**/";
		
		App::Module('Hook')->getHandler('CSS', 'register_css_code', __FILE__, 'display');
		
		exit;
    }

    /**
     * Render dynamic JavaScript from 
     * - Collected Component JS block
     * - Any JS added in template file
     */    
    public function default_jsAction()
    {
		$this->layout ='empty';
		
        @header("Content-type:text/javascript");
		
		echo "/*
*  File Defination
*  - Website JS Section
*
*  Template Name : {$this->theme}
*  Project Name    : {$this->get_config('site_title')}
**/";
		
		App::Module('Hook')->getHandler('Javascript', 'register_javascript_code', __FILE__, 'display');
		exit;
    }
  }
