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

class '.$this->getModelName().' extends Model
{
    protected $table = "";
    protected $primary_key = "";
    
}        ';
    }

    private function getModel()
    {
        return $this->modelCode;
    }

}

