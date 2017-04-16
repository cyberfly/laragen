<?php

namespace App\Services;

use App\Traits\FieldGenerator;

class EditFormService{

    use FieldGenerator;

    public function generateEditForm($request)
    {
        $this->setFormType('edit');
        return $this->setInput($request);
    }

}

