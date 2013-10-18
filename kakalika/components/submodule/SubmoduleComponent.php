<?php
namespace kakalika\components\submodule;

use ntentan\models\Model;

class SubmoduleComponent extends \ntentan\controllers\components\Component
{
    private $module;
    
    public function submodule($module, $id)
    {
        $this->module = $module;
        $model = Model::load($module);
        
        $this->set('id', $id);
        $this->set('items', $model);
        $this->view->template = "projects_{$module}.tpl.php";
    }
}

