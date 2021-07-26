<?php
 
class Component_Ethical_Register extends appRain_Base_Component
{
    public function init(){
    
        // Load Controller
		App::Module('Hook')
            ->setHookName('Controller')
            ->setAction("register_controller")
            ->Register(get_class($this),"register_controller");
			
		App::Component('Ethical')->Helper('Aes')->checkPlacement();
			
        App::Module('Hook')
            ->setHookName('InterfaceBuilder')
            ->setAction("update_definition")
            ->Register(get_class($this),"interfacebuilder_update_definition");
			
			App::Module('Hook')
            ->setHookName('Sitesettings')
            ->setAction("register_definition")
            ->Register(get_class($this), "register_sitesettings_defination");
    }
    public function init_on_install(){}

    public function init_on_uninstall(){}
	
	 public function interfacebuilder_update_definition($send)
    {

        if(isset($send['component']['child']))
        {
            $send['component']['child'][] = Array(
                "title"=>"Ethical",
                "items"=>Array(
					array(
                        "title"=>"Setting",
                        "link"=>"/admin/config/ethical"
                    )
                ),
                "adminicon" => array("type"=>"filePath",'location'=>'/component/ethical/icon.jpg')
            );
            
            return $send;
        }
    }
    
    public function register_controller()
    {
        $srcpaths = Array();
        $srcpaths[] =   array(
			'name'=>'Ethical',
            'controller_path'=>$this->attachMyPath('controllers')
		);
        return $srcpaths;
    }
	
	
	public function register_sitesettings_defination()
    {
        $srcpaths = Array();
        $srcpaths[] = $this->attachMyPath('sitesettings/settings.xml');

        return array(
            'filepaths' => $srcpaths
        );
    }

	
}