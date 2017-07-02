<?php

namespace App\Services;

use App\Traits\FieldGenerator;
use App\Traits\GeneratorParameter;

class CreateAPIControllerService{

    use GeneratorParameter;
    use FieldGenerator;

    public function generateAPIController($request)
    {
        $this->setInput($request);
        $this->setGeneratorParameter($request);
        $this->writeController();
        return $this->getController();
    }

    public function writeController()
    {
        $this->controllerCode = '<?php

namespace App\Http\Controllers\Api;

use App\\'.$this->getModelName().';
use App\Transformers\\'.$this->getTransformerName().';
use Illuminate\Http\Request;

class '.$this->getControllerName().' extends BaseController
{
    '.$this->writeIndexMethod().'

    '.$this->writeStoreMethod().'

    '.$this->writeShowMethod().'

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
    public function index(Request $request)
    {
        '.$this->getPluralVariable().' = new '.$this->getModelName().';
        ';

        $indexMethodCode .= '
        if(!empty($request->sort)) {
            
            $sort_by = substr($request->sort, 0, 1);
            
            if($sort_by===\'-\') {
                $sort_by = \'asc\';
            }
            else {
                $sort_by = \'desc\';
            }
            
            $sort_by_column = ltrim($request->sort, "- ");
            
            '.$this->getPluralVariable().' = '.$this->getPluralVariable().'->orderBy($sort_by_column, $sort_by);
        }
        else {
            '.$this->getPluralVariable().' = '.$this->getPluralVariable().'->orderBy(\'created_at\', \'desc\');
        }
        
        ';

        $indexMethodCode .= $this->getPluralVariable().' = '.$this->getPluralVariable().'->paginate(50);';

        $indexMethodCode .= '
   
        return $this->response->paginator('.$this->getPluralVariable().', new '.$this->getTransformerName().'());
    }   ';

        return $indexMethodCode;

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
        '.$this->getSingularVariable().' = new '.$this->getModelName().';'. "\n\t\t";


        foreach ($this->getCreateKeys() as $field_key) {
            $storeMethodCode .= $this->getSingularVariable().'->'.$field_key.' = $request->'.$field_key.';'. "\n\t\t";
        }

        $storeMethodCode .= $this->getSingularVariable().'->save();

        return $this->response->item('.$this->getSingularVariable().', new '.$this->getTransformerName().'())->setStatusCode(201);
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
        '.$this->getSingularVariable().' = '.$this->getModelName().'::find($id);'. "\n\t\t";

        $showMethodCode .= '
        if(!'.$this->getSingularVariable().') {
            return $this->response->errorNotFound();
        }
            
        ';

        $showMethodCode .= 'return $this->response->item('.$this->getSingularVariable().', new '.$this->getTransformerName().'());
    }        ';

        return $showMethodCode;
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
        '.$this->getSingularVariable().' = '.$this->getModelName().'::find($id);'. "\n\t\t";

        $updateMethodCode .= '
        if(!'.$this->getSingularVariable().') {
            return $this->response->errorNotFound();
        }
            
        ';

        foreach ($this->getEditKeys() as $field_key) {
            $updateMethodCode .= $this->getSingularVariable().'->'.$field_key.' = $request->'.$field_key.';'. "\n\t\t";
        }

        $updateMethodCode .= $this->getSingularVariable().'->save();

        return $this->response->item('.$this->getSingularVariable().', new '.$this->getTransformerName().'());
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
        '.$this->getSingularVariable().' = '.$this->getModelName().'::find($id);'. "\n\t\t";

        $destroyMethodCode .= '
        if(!'.$this->getSingularVariable().') {
            return $this->response->errorNotFound();
        }
            
        ';

        $destroyMethodCode .= $this->getSingularVariable().'->delete();
            
        return $this->response->noContent();
                  
    }        ';

        return $destroyMethodCode;
    }

}

