<?php

namespace App\Services;

use App\Traits\FieldGenerator;
use App\Traits\GeneratorParameter;

class CreateTransformerService{

    use FieldGenerator;
    use GeneratorParameter;

    protected $transformerCode = '';

    public function generateTransformer($request)
    {
        //get form field key
        $this->setInput($request);
        //get generator parameter
        $this->setGeneratorParameter($request);
        $this->writeTransformer();
        return $this->getTransformer();
    }

    private function writeTransformer()
    {
        $transformerCode = '<?php

namespace App\Transformers;

use App\\'.$this->getModelName().';
use League\Fractal\TransformerAbstract;

class '.$this->getTransformerName().' extends TransformerAbstract
{
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
     
    protected $availableIncludes = [
        '.$this->writeTransformerIncludes().'
    ];
    ';

        $transformerCode .= $this->writeTransformerFields();

        $transformerCode .='
    //belongsTo relationship
    ';

        $transformerCode .= $this->writeTransformerRelationship();

        $transformerCode .='
    //hasMany and other relationship
    
}        ';

        $this->transformerCode = $transformerCode;
    }

    private function writeTransformerFields()
    {
        $transformer_fields_code = '
    public function transform('.$this->getModelName().' '.$this->getSingularVariable().')
    {
        return [';

        foreach ($this->getTransformerKeys() as $field_key) {
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

    private function fieldCasting($field_key)
    {
        $cast = '';

        //cast to integer for id key

        if (preg_match('/_id/', $field_key)) {
            $cast = '(int) ';
        }

        //cast to string for date

        if (preg_match('/ted_at/', $field_key)) {
            $cast = '(string) ';
        }

        //cast to boolean for active

        if (preg_match('/active/', $field_key)) {
            $cast = '(bool) ';
        }

        //if key is id

        if ($field_key == 'id') {
            $cast = '(int) ';
        }

        return $cast;
    }

    private function writeTransformerIncludes()
    {
        $transformer_includes = '';

        $db_relationships = request()->session()->get('db_relationships');
        $db_hasmany_relationships = request()->session()->get('db_hasmany_relationships');
        $table_relationships = $db_relationships[$this->getTableName()];

        foreach ($table_relationships as $relationship) {
            $transformer_includes .= '\''.$relationship['relationship_name'].'\','. "\n\t\t";
        }

        if (isset($db_hasmany_relationships[$this->getModelName()])) {

            $table_hasmany_relationships = $db_hasmany_relationships[$this->getModelName()];

            foreach ($table_hasmany_relationships as $relationship) {
                $transformer_includes .= '\''.$relationship['relationship_name'].'\','. "\n\t\t";
            }
        }

        $transformer_includes = rtrim($transformer_includes, "\n\t\t ");

        return $transformer_includes;
    }


    private function writeTransformerRelationship()
    {
        $relationship_code = '';

        $db_relationships = request()->session()->get('db_relationships');
        $db_hasmany_relationships = request()->session()->get('db_hasmany_relationships');
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

        if (isset($db_hasmany_relationships[$this->getModelName()])) {

            $table_hasmany_relationships = $db_hasmany_relationships[$this->getModelName()];

            foreach ($table_hasmany_relationships as $relationship) {
                $relationship_code .= '
    public function include'.$this->getPluralString($relationship['relationship_class']).'('.$this->getModelName().' '.$this->getSingularVariable().'){
        
        $'.$relationship['relationship_name'].' = '.$this->getSingularVariable().'->'.$relationship['relationship_name'].';
        
        if(!$'.$relationship['relationship_name'].'){
            return $this->null();
        }
        else{
            return $this->collection($'.$relationship['relationship_name'].', new '.$relationship['relationship_class'].'Transformer());
        }
    }
    
    ';
            }

        }

        return $relationship_code;
    }

    private function getTransformer()
    {
        return $this->transformerCode;
    }

}

