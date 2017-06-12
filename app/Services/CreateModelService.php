<?php

namespace App\Services;

use App\Traits\ControllerGenerator;
use App\Traits\FieldGenerator;

class CreateModelService{

//    use ControllerGenerator;
//    use FieldGenerator;

    protected $modelName = 'Test';
    protected $modelCode = '';

    public function generateModel($request)
    {
//        $this->setInput($request);
//        $this->setControllerParameter($request);
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

    public function getModelName()
    {
        return $this->modelName;
    }

    private function getModel()
    {
        return $this->modelCode;
    }

}

