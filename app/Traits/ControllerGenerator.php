<?php

namespace App\Traits;

trait ControllerGenerator{

    private $controllerName;
    private $viewsName;
    private $modelName;
    private $controllerCode;
    private $singularVariableRecord;
    private $pluralVariableRecord;

    public function setControllerParameter($request)
    {
        $object_name = strtolower($request->object_name);

        $this->setSingularVariable($object_name);
        $this->setPluralVariable($object_name);
        $this->setControllerName($object_name);
        $this->setViewsName($object_name);
        $this->setModelName($object_name);
    }

    public function setSingularVariable($object_name)
    {
        $this->singularVariableRecord = '$'.$object_name;
    }

    public function setPluralVariable($object_name)
    {
        $this->pluralVariableRecord = '$'.$object_name.'s';
    }

    public function setControllerName($object_name)
    {
        $this->controllerName = ucfirst($object_name).'s'.'Controller';
    }

    public function setViewsName($object_name)
    {
        $this->viewsName = $object_name.'s';
    }

    public function setModelName($object_name)
    {
        $this->modelName = ucfirst($object_name);
    }

    public function getSingularVariable()
    {
        return $this->singularVariableRecord;
    }

    public function getPluralVariable()
    {
        return $this->pluralVariableRecord;
    }

    public function getControllerName()
    {
        return $this->controllerName;
    }

    public function getViewsName()
    {
        return $this->viewsName;
    }

    public function getModelName()
    {
        return $this->modelName;
    }

    public function getController()
    {
        return $this->controllerCode;
    }

    public function getCompactVariables($variables='')
    {
        if (empty($variables)) {
            return '';
        }

        $variables = (array)$variables;
        $variables = "'" .implode("','", $variables) . "'";
        $compact_variable = str_replace('$', '', $variables);

        if (!empty($compact_variable)) {
            $compact_variable = ", compact($compact_variable)";
        }

        return $compact_variable;
    }

    

}
