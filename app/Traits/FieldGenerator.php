<?php

namespace App\Traits;

trait FieldGenerator{

    private $formType;

    public function __construct()
    {
        $this->formType = 'create';
    }

    public function setFormType($formType)
    {
        $this->formType = $formType;
    }

    public function getFormType()
    {
        return $this->formType;
    }

    public function formStartWrapper()
    {
        $formStartWrapper = '<form class="form-horizontal" method="POST" action="" >
                            ';

        return $formStartWrapper;
    }

    public function formEndWrapper()
    {
        $formEndWrapper = '
</form>';

        return $formEndWrapper;
    }

    public function setInput($request)
    {
//        dd($request);
        $fieldTotal = $request->fieldTotal;

        $finalCode = $this->formStartWrapper();

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

//            only process field that match the condition
            if($this->showFieldInCreateEdit($request->$fieldKey,$request->$showField))
            {
                $fieldHtml = $this->getFieldHtml($request->$fieldType,$request->$fieldKey,$request->$fieldLabel,$request->$fieldPlaceholder);
                $finalCode .= $fieldHtml;
            }
        }

        $finalCode .= $this->formEndWrapper();

        return $finalCode;

    }

    //    determine show the field in create/edit form

    private function showFieldInCreateEdit($fieldKey,$showField)
    {
        if (empty($fieldKey)) {
            return FALSE;
        }

        //do not generate field from create/edit form

        if ($showField==='none') {
            return FALSE;
        }

        //do not generate field on create form if field only shown in Edit Form

        if ($showField==='create' && $this->getFormType()=='edit') {
            return FALSE;
        }

        //do not generate field on edit form if field only shown in Create Form

        if ($showField==='edit' && $this->getFormType()=='create') {
            return FALSE;
        }

        return TRUE;
    }

    //write each form field in form group/custom wrapper

    private function formGroupWrapper()
    {

    }

    private function getFieldHtml(String $fieldType, String $fieldKey, String $fieldLabel, $fieldPlaceholder='')
    {
        $fieldHtml = '';

        switch($fieldType)
        {
            case 'text' && $this->getFormType()==='create':
                $fieldHtml = '<div class="form-group">
                                <label for="'.$fieldKey.'">'.$fieldLabel.'</label>
                                <input type="text" name="'.$fieldKey.'" class="form-control" id="'.$fieldKey.'" value="{{ old(\''.$fieldKey.'\') }}" placeholder="'.$fieldPlaceholder.'">
                              </div>';
                break;
            case 'text' && $this->getFormType()==='edit':
                $fieldHtml = '<div class="form-group">
                                <label for="'.$fieldKey.'">'.$fieldLabel.'</label>
                                <input type="text" name="'.$fieldKey.'" class="form-control" id="'.$fieldKey.'" value="{{ old(\''.$fieldKey.'\',$'.$fieldKey.') }}" placeholder="'.$fieldPlaceholder.'">
                              </div>';
                break;
            case 'email' && $this->getFormType()==='create':
                $fieldHtml = '<div class="form-group">
                                <label for="'.$fieldKey.'">'.$fieldLabel.'</label>
                                <input type="email" name="'.$fieldKey.'" class="form-control" id="'.$fieldKey.'" value="{{ old(\''.$fieldKey.'\') }}" placeholder="'.$fieldPlaceholder.'">
                              </div>';
                break;
            case 'email' && $this->getFormType()==='edit':
                $fieldHtml = '<div class="form-group">
                                <label for="'.$fieldKey.'">'.$fieldLabel.'</label>
                                <input type="email" name="'.$fieldKey.'" class="form-control" id="'.$fieldKey.'" value="{{ old(\''.$fieldKey.'\',$'.$fieldKey.') }}" placeholder="'.$fieldPlaceholder.'">
                              </div>';
                break;
            case 'date':
                $fieldHtml = '<div class="form-group">
                                <label for="'.$fieldKey.'">'.$fieldLabel.'</label>
                                <input type="text" name="'.$fieldKey.'" class="form-control" id="'.$fieldKey.'" value="{{ old(\''.$fieldKey.'\') }}" placeholder="'.$fieldPlaceholder.'">
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