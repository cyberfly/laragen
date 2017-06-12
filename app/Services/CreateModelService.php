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
        $this->modelCode = '<?php

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
    
    //scope
    
}        ';
    }

    private function getModel()
    {
        return $this->modelCode;
    }

}

