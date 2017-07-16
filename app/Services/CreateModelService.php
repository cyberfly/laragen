<?php

namespace App\Services;

use App\Traits\ControllerGenerator;
use App\Traits\FieldGenerator;
use App\Traits\GeneratorParameter;

class CreateModelService{

//    use ControllerGenerator;
//    use FieldGenerator;
    use GeneratorParameter;

    protected $modelCode = '';

    public function generateModel($request)
    {
        $this->setGeneratorParameter($request);
        $this->writeModel();
        return $this->getModel();
    }

    private function writeModel()
    {
        $modelCode = '<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class '.$this->getModelName().' extends Model
{
    use SoftDeletes;
    
    protected $table = "";
    protected $primary_key = "";
    
    protected $fillable = [
    
    ];
    
    //relationship
    
    ';

        $modelCode .= $this->writeModelRelationship();
        
        $modelCode .='
    //scope
    
}        ';

        $modelCode .= $this->writeModelScope();

        $this->modelCode = $modelCode;
    }

    private function writeModelRelationship()
    {
        $relationship_code = '';

        $db_relationships = request()->session()->get('db_relationships');
        $db_hasmany_relationships = request()->session()->get('db_hasmany_relationships');
        $table_relationships = $db_relationships[$this->getTableName()];

        foreach ($table_relationships as $relationship) {
            $relationship_code .= 'public function '.$relationship['relationship_name'].'(){
        return $this->'.$relationship['relationship_type'].'('.$relationship['relationship_class'].'::class, \''.$relationship['foreign_key'].'\');
    }
    
    ';
        }

        if (isset($db_hasmany_relationships[$this->getModelName()])) {
            $table_hasmany_relationships = $db_hasmany_relationships[$this->getModelName()];

            foreach ($table_hasmany_relationships as $relationship) {
                $relationship_code .= 'public function '.$relationship['relationship_name'].'(){
        return $this->'.$relationship['relationship_type'].'('.$relationship['relationship_class'].'::class);
    }
    
    ';
            }
        }


        return $relationship_code;
    }

    private function writeModelScope()
    {
        $scope_code = '';

        return $scope_code;
    }

    private function getModel()
    {
        return $this->modelCode;
    }

}

