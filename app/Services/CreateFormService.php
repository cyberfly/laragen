<?php

namespace App\Services;

use App\Traits\FieldGenerator;

class CreateFormService{

    use FieldGenerator;

    public function generateCreateForm($request)
    {
        $this->setInput($request);
//        dd($request);
//        9556232001137
    }

}

