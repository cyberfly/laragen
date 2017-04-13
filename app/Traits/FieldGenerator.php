<?php

namespace App\Traits;

trait FieldGenerator{

    public function formStartWrapper()
    {
        $formStartWrapper = '<form class="form-inline">';

        return $formStartWrapper;
    }

    public function formEndWrapper()
    {
        $formEndWrapper = '</form>';

        return $formEndWrapper;
    }

    public function setInput($request)
    {
//        dd($request);
        $fieldTotal = $request->fieldTotal;

        for($i=1;$i<=$fieldTotal;$i++)
        {
            $fieldType = 'fieldType_'.$i;
            $fieldKey = 'fieldKey_'.$i;
            $fieldLabel = 'fieldLabel_'.$i;
            $fieldClass = 'fieldClass_'.$i;
            $fieldPlaceholder = 'fieldPlaceholder_'.$i;
            $fieldValue = 'fieldValue_'.$i;
            $showField = 'showField_'.$i;

//            var_dump($fieldType);
//            var_dump($request->$fieldKey);

//            only process field with defined value
            if(!empty($request->$fieldKey))
            {
                var_dump($this->fieldHtml($request->$fieldType,$request->$fieldKey,$request->$fieldLabel,$request->$fieldPlaceholder));
            }
        }

    }

    public function getInput()
    {

    }

    private function fieldHtml(String $fieldType, String $fieldKey, String $fieldLabel, String $fieldPlaceholder)
    {
        $fieldHtml = '';

        switch($fieldType)
        {
            case 'text':
                $fieldHtml = '<div class="form-group">
                                <label for="'.$fieldKey.'">'.$fieldLabel.'</label>
                                <input type="text" name="'.$fieldKey.'" class="form-control" id="'.$fieldKey.'" value="" placeholder="'.$fieldPlaceholder.'">
                              </div>';
                break;
            case 'email':
                $fieldHtml = '<div class="form-group">
                                <label for="'.$fieldKey.'">'.$fieldLabel.'</label>
                                <input type="text" name="'.$fieldKey.'" class="form-control" id="'.$fieldKey.'" value="" placeholder="'.$fieldPlaceholder.'">
                              </div>';
                break;
            case 'date':
                $fieldHtml = '<div class="form-group">
                                <label for="'.$fieldKey.'">'.$fieldLabel.'</label>
                                <input type="text" name="'.$fieldKey.'" class="form-control" id="'.$fieldKey.'" value="" placeholder="'.$fieldPlaceholder.'">
                              </div>';
                break;
            case 'select':
                break;
            case 'dynamic_select':
                break;
            case 'checkbox':
                break;
            case 'radio':
                break;
            case 'textarea':
                break;
            default:
                break;
        }

        return $fieldHtml;
    }

}