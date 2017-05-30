<?php

namespace App\Services;

use App\Traits\ControllerGenerator;
use App\Traits\FieldGenerator;

class CreateResourceControllerService{

    use ControllerGenerator;
    use FieldGenerator;

    public function generateResourceController($request)
    {
        $this->setInput($request);
        $this->setControllerParameter($request);
        $this->writeController();
        return $this->getController();
    }

}

