<?php

namespace App\Services;

use App\Traits\FieldGenerator;

class CreateFormService{

    use FieldGenerator;

    public function generateCreateForm($request)
    {
        return $this->setInput($request);
    }

}

