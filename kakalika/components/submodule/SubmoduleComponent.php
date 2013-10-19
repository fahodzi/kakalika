<?php
namespace kakalika\components\submodule;

use ntentan\models\Model;
use ntentan\Ntentan;

class SubmoduleComponent extends \ntentan\controllers\components\Component
{
    private $modules = array();
    
    public function __construct($modules)
    {
        $this->modules = $modules;
    }
    
    public function submodule($module, $id)
    {
        /*$this->module = $module;
        $items = Model::load($module)->getAll();
        
        $this->set('id', $id);
        $this->set($module, $items->toArray());
        $this->view->template = "projects_{$module}.tpl.php";*/
        
        $project = \kakalika\modules\projects\Projects::getJustFirstWithId($id);
        $this->view->template = "projects_{$module}.tpl.php";
        $this->set('sub_section', $this->modules[$module]['title']);
        $this->set('sub_section_path', "admin/projects/$module/$id");
        $this->set('sub_section_menu', 
            array(
                array(
                    'label' => "Add a new {$this->modules[$module]['item']}",
                    'url' => Ntentan::getUrl("admin/projects/$module/$id/add"),
                    'id' => "menu-item-projects-$module-add"
                )
            )
        );                 
    }
}

