<?php

namespace App\Services;

use App\Traits\ControllerGenerator;

class CreateResourceControllerService{

    use ControllerGenerator;

    public function generateResourceController($request)
    {
        $this->setControllerParameter($request);
        $this->writeController();
        return $this->getController();
    }

}

