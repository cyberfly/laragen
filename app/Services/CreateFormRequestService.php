<?php

namespace App\Services;

use App\Traits\FieldGenerator;
use App\Traits\GeneratorParameter;

class CreateFormRequestService{

    use FieldGenerator;
    use GeneratorParameter;

    protected $formRequestCode = '';

    public function generateTransformer($request)
    {
        //get form field key
        $this->setInput($request);
        //get generator parameter
        $this->setGeneratorParameter($request);
        $this->writeFormRequest();
        return $this->getFormRequest();
    }

    private function writeFormRequest()
    {
        $formRequestCode = '<?php

namespace App\Http\Requests;

use App\Traits\CheckRequestPermission;
use App\Traits\RouteValidation;
use Dingo\Api\Http\FormRequest;

class Store'.$this->getModelName().'Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //check role

        $current_user = $this->getCurrentUser();
        $user_role_code = $current_user->role_code;

        $role_code = \'approval_committee\';
        $check_role_permission = $this->checkRolePermission($role_code, $user_role_code);

        if (!$check_role_permission) {
            return false;
        }

        //check is chairman / chairperson

        $meeting_id = $this->meeting_id;
        $approval_committee_id = $current_user->user_id;

        $is_chairperson = $this->checkIsChairperson($meeting_id, $approval_committee_id);

        if (!$is_chairperson) {
            return false;
        }

        //check if approval cannot be edited anymore

        return true;
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            \'meeting_case_id\' => \'required|integer|exists:meeting_case,id|unique:meeting_case_approval,meeting_case_id\',
            \'approval_committee_id\' => \'required|integer|exists:user,id\',
            \'status_id\' => \'required|integer|exists:status,id\'
        ];
    }

    /**
     * Get the custom validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
        
        ];
    }
    
    
}        ';

        $this->transformerCode = $formRequestCode;
    }

    private function writeTransformerFields()
    {
        $transformer_fields_code = '
    public function transform('.$this->getModelName().' '.$this->getSingularVariable().')
    {
        return [';

        foreach ($this->getFormRequestKeys() as $field_key) {
            $field_cast = $this->fieldCasting($field_key);
            $transformer_fields_code .= '
            \''.$field_key.'\' => '.$field_cast.''.$this->getSingularVariable().'->'.$field_key.','. "";
        }

            $transformer_fields_code .='
        ];
    }
        ';

        return $transformer_fields_code;
    }

    private function writeTransformerIncludes()
    {
        $transformer_includes = '';

        $db_relationships = request()->session()->get('db_relationships');
        $table_relationships = $db_relationships[$this->getTableName()];

        foreach ($table_relationships as $relationship) {
            $transformer_includes .= '\''.$relationship['relationship_name'].'\','. "\n\t\t";
        }

        return $transformer_includes;
    }


    private function writeTransformerRelationship()
    {
        $relationship_code = '';

        $db_relationships = request()->session()->get('db_relationships');
        $table_relationships = $db_relationships[$this->getTableName()];


        foreach ($table_relationships as $relationship) {
            $relationship_code .= '
    public function include'.$relationship['relationship_class'].'('.$this->getModelName().' '.$this->getSingularVariable().'){
        
        $'.$relationship['relationship_name'].' = '.$this->getSingularVariable().'->'.$relationship['relationship_name'].';
        
        if(!$'.$relationship['relationship_name'].'){
            return $this->null();
        }
        else{
            return $this->item($'.$relationship['relationship_name'].', new '.$relationship['relationship_class'].'Transformer());
        }
    }
    
    ';
        }

        return $relationship_code;
    }

    private function getFormRequest()
    {
        return $this->transformerCode;
    }

}

