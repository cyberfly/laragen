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

use App\Http\Requests\StoreMeetingCaseCommitteeReviewRequest;
use App\Http\Requests\UpdateMeetingCaseCommitteeReviewRequest;
use App\Transformers\\'.$this->getTransformerName().'();
use Illuminate\Http\Request;

class '.$this->getControllerName().' extends Controller
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
    public function index()
    {
        '.$this->getPluralVariable().' = '.$this->getModelName().'::paginate(20);
   
        return $this->response->paginator('.$this->getPluralVariable().', new '.$this->getTransformerName().'());
    }   ';

        return $indexMethodCode;

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

        return $this->response->item('.$this->getSingularVariable().', new '.$this->getTransformerName().'());
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
        '.$this->getSingularVariable().' = '.$this->getModelName().'::findOrFail($id);'. "\n\t\t";

        foreach ($this->getEditKeys() as $field_key) {
            $updateMethodCode .= $this->getSingularVariable().'->'.$field_key.' = $request->'.$field_key.';'. "\n\t\t";
        }

        $updateMethodCode .= $this->getSingularVariable().'->save();

        return $this->response->item('.$this->getSingularVariable().', new '.$this->getTransformerName().'())
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
        $this->setResponse(\'messages\', \'record deleted\');
        $this->setResponse(\'data\', []);
        $this->setResponse(\'status_code\', 200);

        return $this->response->array($this->getResponse())->setStatusCode(200);
    }        ';

        return $destroyMethodCode;
    }

}

