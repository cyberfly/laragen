<?php

namespace App\Traits;

trait ControllerGenerator{

    private $controllerName;
    private $viewsName;
    private $modelName;
    private $controllerCode;
    private $singularVariableRecord;
    private $pluralVariableRecord;

    public function setControllerParameter($request)
    {
        $object_name = strtolower($request->object_name);

        $this->setSingularVariable($object_name);
        $this->setPluralVariable($object_name);
        $this->setControllerName($object_name);
        $this->setViewsName($object_name);
        $this->setModelName($object_name);
    }

    public function setSingularVariable($object_name)
    {
        $this->singularVariableRecord = '$'.$object_name;
    }

    public function setPluralVariable($object_name)
    {
        $this->pluralVariableRecord = '$'.$object_name.'s';
    }

    public function setControllerName($object_name)
    {
        $this->controllerName = ucfirst($object_name).'s'.'Controller';
    }

    public function setViewsName($object_name)
    {
        $this->viewsName = $object_name.'s';
    }

    public function setModelName($object_name)
    {
        $this->modelName = ucfirst($object_name);
    }

    public function getSingularVariable()
    {
        return $this->singularVariableRecord;
    }

    public function getPluralVariable()
    {
        return $this->pluralVariableRecord;
    }

    public function getControllerName()
    {
        return $this->controllerName;
    }

    public function getViewsName()
    {
        return $this->viewsName;
    }

    public function getModelName()
    {
        return $this->modelName;
    }

    public function getController()
    {
        return $this->controllerCode;
    }

    public function getCompactVariables()
    {

    }

    public function writeController()
    {
        $this->controllerCode = '<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class '.$this->getControllerName().' extends Controller
{
    '.$this->writeIndexMethod().'

    '.$this->writeCreateMethod().'

    '.$this->writeStoreMethod().'

    '.$this->writeShowMethod().'

    '.$this->writeEditMethod().'

    '.$this->writeUpdateMethod().'

    '.$this->writeDestroyMethod().'
}        ';

    }

    private function writeIndexMethod()
    {
        $indexMethodCode = '
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        '.$this->getPluralVariable().' = '.$this->getModelName().'::all();
        return view(\''.$this->getViewsName().'.index\',compact(\''.$this->getPluralVariable().'\'));
    }   ';

        return $indexMethodCode;

    }

    private function writeCreateMethod()
    {
        $createMethodCode = '
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
       return view(\''.$this->getViewsName().'.create\');
    }';

        return $createMethodCode;
    }

    private function writeStoreMethod()
    {
        $storeMethodCode = '
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $brand = new Brand;
        $brand->name = $request->brand_name;
        $brand->description = $request->description;
        $brand->save();
        
        
        return redirect();
    }        ';

        return $storeMethodCode;

    }

    private function writeShowMethod()
    {
        $showMethodCode = '
    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        return view(\''.$this->getViewsName().'.show\');
    }        ';

        return $showMethodCode;
    }

    private function writeEditMethod()
    {
        $editMethodCode = '
    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        return view(\''.$this->getViewsName().'.edit\');
    }        ';

        return $editMethodCode;

    }

    private function writeUpdateMethod()
    {
        $updateMethodCode = '
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        //
    }        ';

        return $updateMethodCode;

    }

    private function writeDestroyMethod()
    {
        $destroyMethodCode = '
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        return redirect();
    }        ';

        return $destroyMethodCode;
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



}