<?php

namespace kakalika\components\submodule;

use ntentan\Model;
use ntentan\Ntentan;
use kakalika\modules\projects\Projects;
use ntentan\utils\Input;

class SubmoduleComponent extends \ntentan\controllers\components\Component
{

    private $modules = array();

    public function __construct($modules)
    {
        $this->modules = $modules;
    }

    public function submodule($module, $id, $command = null, $subId = null)
    {
        $project = Projects::fetchFirstWithId($id);
        $model = Model::load($this->modules[$module]['model']);
        $this->getView()->setTemplate("projects_submodule.tpl.php");

        $this->set('module', $module);
        $this->set('id', $id);
        $this->set('sub_section', $this->modules[$module]['title']);
        $this->set('sub_section_path', "admin/projects/$module/$id");

        switch ($command) {
            case 'edit':
                $subItem = $model->fetchFirstWithId($subId);
                $post = Input::post();
                $errors = [];
                if (count($post) > 0) {
                    $subItem->mergeData($post);
                    $subItem->project_id = $id;
                    if ($subItem->save()) {
                        Ntentan::redirect(Ntentan::getUrl("admin/projects/$module/$id"));
                    } else {
                        $errors = $subItem->getInvalidFields();
                    }
                }

                $this->set('title', "Edit the {$subItem} {$this->modules[$module]['item']}");
                $this->set('data', $subItem->toArray());
                $this->set('errors', $errors);
                $this->getView()->setTemplate("projects_submodule_edit.tpl.php");
                break;
            case 'delete':
                $item = $model->fetchFirstWithId($subId);
                $this->getView()->setTemplate('delete.tpl.php');

                if (Input::get('confirm') == 'yes') {
                    $item->delete();
                    Ntentan::redirect(Ntentan::getUrl("admin/projects/$module/$id"));
                }

                $this->set(
                        array(
                            'item_type' => $this->modules[$module]['item'],
                            'item_name' => $item,
                        )
                );
                $this->set('title', "Delete a {$this->modules[$module]['item']} from the $project project");
                $this->set('show_side', false);
                break;

            case 'add':
                $post = Input::post();
                $formVars = ['errors' => [], 'data' => []];
                if (count($post) > 0) {
                    $newItem = $model->createNew();
                    $newItem->setData($post);
                    $newItem->project_id = $id;
                    if ($newItem->save()) {
                        Ntentan::redirect(Ntentan::getUrl("admin/projects/$module/$id"));
                    } else {
                        $formVars['errors'] = $newItem->getInvalidFields();
                        $formVars['data'] = $post;
                    }
                }

                $this->getView()->setTemplate("projects_submodule_add.tpl.php");

                if (is_object($this->modules[$module]['get_form_vars'])) {
                    $formVars = array_merge($formVars, $this->modules[$module]['get_form_vars']());
                }

                $this->set('form_vars', $formVars);
                $this->set('title', "Add a new {$this->modules[$module]['item']} to the $project project");

                break;

            default:

                $items = $model->fields($this->modules[$module]['fields'])->sortDescById()->fetchWithProjectId($id);

                if (is_object($this->modules[$module]['filter'])) {
                    $items = $this->modules[$module]['filter']($items);
                } else {
                    $items = $items->toArray();
                }

                $this->set('disable_edit', $this->modules[$module]['disable_edit']);
                $this->set('project', $project->name);
                $this->set('title', ucfirst($this->modules[$module]['items']) . " of the $project project");
                $this->set('items', $items);
                $this->set('item_type', $this->modules[$module]['item']);
                $this->set('id', $id);
                $this->set('add_path', "admin/projects/$module/$id/add");
        }
    }

}
