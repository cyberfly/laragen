<?php

namespace App\Services;

use App\Traits\ControllerGenerator;
use App\Traits\FieldGenerator;
use App\Traits\GeneratorParameter;

class CreateAPIRouteService{

//    use ControllerGenerator;
//    use FieldGenerator;
    use GeneratorParameter;

    protected $apiRoute = '';

    public function generateAPIRoute($request)
    {
        $this->setGeneratorParameter($request);
        $this->writeAPIRoute();
        return $this->getAPIRoute();
    }

    private function writeAPIRoute()
    {
        $apiRoute = '
        //get list of meeting agenda
        $api->get(\'meeting/{meeting_id}/agenda\',\''.$this->getControllerName().'@index\');
        //store a meeting agenda
        $api->post(\'meeting/{meeting_id}/agenda\',\''.$this->getControllerName().'@store\');
        //update a meeting agenda
        $api->put(\'meeting/{meeting_id}/agenda/{agenda_id}\',\''.$this->getControllerName().'@update\');
        //show specific meeting agenda
        $api->get(\'meeting/{meeting_id}/agenda/{agenda_id}\',\''.$this->getControllerName().'@show\');
        ';

        $this->apiRoute = $apiRoute;
    }

    private function writeAPIRouteRelationship()
    {
        $relationship_code = '';

        $db_relationships = request()->session()->get('db_relationships');
        $table_relationships = $db_relationships[$this->getTableName()];

        foreach ($table_relationships as $relationship) {
            $relationship_code .= 'public function '.$relationship['relationship_name'].'(){
        return $this->'.$relationship['relationship_type'].'('.$relationship['relationship_class'].'::class, \''.$relationship['foreign_key'].'\');
    }
    
    ';
        }

        return $relationship_code;
    }

    private function getAPIRoute()
    {
        return $this->apiRoute;
    }

}

