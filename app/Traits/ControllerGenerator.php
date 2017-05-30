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

    public function getCompactVariables($variables='')
    {
        if (empty($variables)) {
            return '';
        }

        $variables = (array)$variables;
        $variables = "'" .implode("','", $variables) . "'";
        $compact_variable = str_replace('$', '', $variables);

        if (!empty($compact_variable)) {
            $compact_variable = ", compact($compact_variable)";
        }

        return $compact_variable;
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
        '.$this->getPluralVariable().' = '.$this->getModelName().'::paginate(20);
        return view(\''.$this->getViewsName().'.index\''.$this->getCompactVariables($this->getPluralVariable()).');
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
       return view(\''.$this->getViewsName().'.create\''.$this->getCompactVariables().');
    }';

        return $createMethodCode;
    }

    private function writeStoreMethod()
    {
//        var_dump($this->getCreateKeys());
//        exit;

        $storeMethodCode = '
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        '.$this->getSingularVariable().' = new '.$this->getModelName().';'. "\n\t\t";

        foreach ($this->getCreateKeys() as $field_key) {
            $storeMethodCode .= $this->getSingularVariable().'->'.$field_key.' = $request->'.$field_key.';'. "\n\t\t";
        }

        $storeMethodCode .= $this->getSingularVariable().'->save();
        
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
        '.$this->getSingularVariable().' = '.$this->getModelName().'::findOrFail($id);'. "\n\t\t";
        $showMethodCode .= 'return view(\''.$this->getViewsName().'.show\''.$this->getCompactVariables($this->getSingularVariable()).');
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
        '.$this->getSingularVariable().' = '.$this->getModelName().'::findOrFail($id);'. "\n\t\t";
        $editMethodCode .= 'return view(\''.$this->getViewsName().'.edit\''.$this->getCompactVariables($this->getSingularVariable()).');
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
        '.$this->getSingularVariable().' = '.$this->getModelName().'::findOrFail($id);'. "\n\t\t";

        foreach ($this->getEditKeys() as $field_key) {
            $updateMethodCode .= $this->getSingularVariable().'->'.$field_key.' = $request->'.$field_key.';'. "\n\t\t";
        }

        $updateMethodCode .= $this->getSingularVariable().'->save();

        return redirect();
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

}