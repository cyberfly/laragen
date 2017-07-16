<?php

namespace App\Traits;

trait GeneratorParameter
{

    private $controllerName;
    private $viewsName;
    private $modelName;
    private $controllerCode;
    private $singularVariableRecord;
    private $pluralVariableRecord;
    private $singleTransformer;
    private $tableName;
    private $objectName;
    private $objectClassName;
    private $apiRouteName;

    //set generator parameters on database load

    public function setDatabaseTableParameter($table_name)
    {
        //set table name

        $this->setTableName($table_name);

        //get variable name

        $new_table_name = $this->getSingularString($table_name);

        $variable_name = strtolower($new_table_name);

        //get object name

        $object_name = str_replace('_', ' ', $new_table_name);
        $object_name = ucwords($object_name);

        //get object class name

        $object_class_name = $this->getObjectClassNameFromTableName($new_table_name);

        $this->setObjectName($object_name);
        $this->setObjectClassName($object_class_name);
        $this->setSingularVariable($variable_name);
        $this->setPluralVariable($variable_name);
        $this->setControllerName($object_class_name);
        $this->setViewsName($variable_name);
        $this->setModelName($object_class_name);
        $this->setTransformerName();
        $this->setAPIRouteName($new_table_name);
    }

    //set final generator parameter on user submit form

    public function setGeneratorParameter($request)
    {
        $table_name = $request->table_name;

        $db_table_parameters = $request->session()->get('db_table_parameters');
        $table_parameters = $db_table_parameters[$table_name];

        $this->setTableName($table_name);

//        dd($request->all());

        $object_name = $table_parameters['object_name'];
        $object_class_name = $table_parameters['object_class_name'];

        $new_table_name = rtrim($table_name, "s ");
        $variable_name = strtolower($new_table_name);

        $this->setObjectName($object_name);
        $this->setSingularVariable($variable_name, $request->singular_variable);
        $this->setPluralVariable($variable_name, $request->plural_variable);
        $this->setControllerName($object_class_name, $request->controller_name);
        $this->setViewsName($variable_name, $request->view_name);
        $this->setModelName($object_class_name, $request->model_name);
        $this->setTransformerName();
    }

    public function setTableName($table_name)
    {
        $this->tableName = $table_name;
    }

    public function setObjectName($object_name)
    {
        $this->objectName = $object_name;
    }

    public function setObjectClassName($object_class_name)
    {
        $this->objectClassName = $object_class_name;
    }

    public function setAPIRouteName($new_table_name)
    {
        $exp_table_name = explode('_', $new_table_name);

        $this->apiRouteName = $new_table_name . '/{' . $new_table_name . '_id}';

        if (!empty($exp_table_name)) {

            if (sizeof($exp_table_name) === 2) {

                $this->apiRouteName = $exp_table_name[0] . '/{' . $exp_table_name[0] . '_id}/' . $exp_table_name[1] . '/{' . $exp_table_name[1] . '_id}';

            } else {
                if (sizeof($exp_table_name) === 3) {

                    $this->apiRouteName = $exp_table_name[1] . '/{' . $exp_table_name[1] . '_id}/' . $exp_table_name[2] . '/{' . $exp_table_name[2] . '_id}';
                }
            }

        }
    }

    public function setSingularVariable($variable_name, $singular_variable_name = '')
    {
        if (!empty($singular_variable_name)) {
            $this->singularVariableRecord = $singular_variable_name;
        } else {
            $this->singularVariableRecord = '$' . $variable_name;
        }
    }

    public function setPluralVariable($variable_name, $plural_variable_name = '')
    {
        if (!empty($plural_variable_name)) {
            $this->pluralVariableRecord = $plural_variable_name;
        } else {
            $variable_name = $this->getPluralString($variable_name);
            $this->pluralVariableRecord = '$' . $variable_name;
        }
    }

    public function setControllerName($object_class_name, $controller_name = '')
    {
        if (!empty($controller_name)) {
            $this->controllerName = $controller_name;
        } else {
            $this->controllerName = ucfirst($object_class_name) . 'Controller';
        }
    }

    public function setViewsName($variable_name, $views_name = '')
    {
        if (!empty($views_name)) {
            $this->viewsName = $views_name;
        } else {
            $variable_name = $this->getPluralString($variable_name);
            $this->viewsName = $variable_name;
        }
    }

    public function setModelName($object_class_name, $model_name = '')
    {
        if (!empty($model_name)) {
            $this->modelName = $model_name;
        } else {
            $this->modelName = ucfirst($object_class_name);
        }
    }

    public function setTransformerName($transformer_name = '')
    {
        if (!empty($transformer_name)) {
            $this->singleTransformer = $transformer_name;
        } else {
            $this->singleTransformer = $this->getModelName() . 'Transformer';
        }
    }

    public function getGeneratorParameters()
    {
        $generator_parameters = [
            'table_name' => $this->getTableName(),
            'object_name' => $this->getObjectName(),
            'object_class_name' => $this->getObjectClassName(),
            'singular_variable' => $this->getSingularVariable(),
            'plural_variable' => $this->getPluralVariable(),
            'controller_name' => $this->getControllerName(),
            'model_name' => $this->getModelName(),
            'transformer_name' => $this->getTransformerName(),
            'views_folder_name' => $this->getViewsName(),
            'api_route_name' => $this->getAPIRouteName(),
        ];

        return $generator_parameters;
    }

    public function getSingularVariable()
    {
        return $this->singularVariableRecord;
    }

    public function getPluralVariable()
    {
        return $this->pluralVariableRecord;
    }

    public function getViewsName()
    {
        return $this->viewsName;
    }

    public function getModelName()
    {
        return $this->modelName;
    }

    public function getControllerName()
    {
        return $this->controllerName;
    }

    public function getAPIRouteName()
    {
        return $this->apiRouteName;
    }

    //get controller code for Create API Service

    public function getController()
    {
        return $this->controllerCode;
    }

    public function getTransformerName()
    {
        return $this->singleTransformer;
    }

    public function getCompactVariables($variables = '')
    {
        if (empty($variables)) {
            return '';
        }

        $variables = (array)$variables;
        $variables = "'" . implode("','", $variables) . "'";
        $compact_variable = str_replace('$', '', $variables);

        if (!empty($compact_variable)) {
            $compact_variable = ", compact($compact_variable)";
        }

        return $compact_variable;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function getObjectName()
    {
        return $this->objectName;
    }

    public function getObjectClassName()
    {
        return $this->objectClassName;
    }

    private function getObjectClassNameFromTableName($table_name)
    {
        //get object class name

        $object_class_name = '';

        $exp_table_name = explode('_', $table_name);

        foreach ($exp_table_name as $value) {
            $object_class_name .= ucfirst($value);
        }

        return $object_class_name;
    }

    public function getRelationshipClass($foreign_key)
    {
        $new_table_name = rtrim($foreign_key, "_id ");
        $relationship_class = $this->getObjectClassNameFromTableName($new_table_name);

        return $relationship_class;
    }

    public function getRelationshipName($foreign_key)
    {
        $relationship_name = rtrim($foreign_key, "_id ");

        $relationship_name = lcfirst(implode('', array_map('ucfirst', explode('_', $relationship_name))));

        return $relationship_name;
    }

    //check for ies at the end of table name. eg : categories, agencies

    private function checkSpecialPlural($string)
    {
        $check_special_plural = substr($string, -3);

        if ($check_special_plural == 'ies') {
            return true;
        }

        return false;
    }

    //check for y at the end of string name. eg : category

    private function checkSpecialSingular($string)
    {
        $check_special_singular = substr($string, -1);

        if ($check_special_singular == 'y') {
            return true;
        }

        if ($check_special_singular == 's') {
            return true;
        }

        return false;
    }

    //get single string from given plural string

    public function getSingularString($string)
    {
        $check_special_plural = substr($string, -3);

        if ($check_special_plural === 'ies') {
            $singular_string = str_replace('ies', 'y', $string);
        }
        else if($check_special_plural === 'ses') {
            $singular_string = substr($string, 0, -2);
        }
        else {
            $singular_string = rtrim($string, "s ");
        }

        return $singular_string;
    }

    //get plural string from given single string

    public function getPluralString($string)
    {
        $plural_string = $string;
        $check_special_singular = substr($string, -1);

        if ($check_special_singular == 'y') {
            $string = rtrim($string, "y ");
            $plural_string = $string . 'ies';
        } else {
            if ($check_special_singular == 's') {
                $plural_string = $plural_string . 'es';
            } else {
                $plural_string = $plural_string . 's';
            }
        }

        return $plural_string;
    }

    //convert Model to hasMany relationship name

    public function modelToHasManyRelationship($model_name)
    {
        $relationship_name = $model_name;

        //convert Class camel case to snake case

        $relationship_name = $this->camelToSnakeCase($relationship_name);

        //convert back to method snake case

        $relationship_name = lcfirst(implode('', array_map('ucfirst', explode('_', $relationship_name))));

        $relationship_name = $this->getPluralString($relationship_name);

        return $relationship_name;
    }

    //convert camel case to snake case

    private function camelToSnakeCase($string)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $string, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }
}
