@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Form Builder</div>

                <div class="panel-body">

                    <form class="form-inline" action="{{ url('/build') }}" method="POST">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="">Object Name (singular)</label>
                            <input type="text" name="object_name" class="form-control"  placeholder="">
                        </div>

                        <input type="hidden" name="fieldTotal" value="{{ $fieldTotal }}">
                        @for ($i=1;$i<=$fieldTotal;$i++)
                        <fieldset>
                            <div class="form-group">
                                <label for="exampleInputEmail2">Key</label>
                                <input type="text" name="fieldKey_{{ $i }}" class="form-control"  placeholder="first_name">
                            </div>
                            <div class="form-group">
                                <label for="formlabel">Label</label>
                                <input type="text" name="fieldLabel_{{ $i }}" class="form-control" id="" placeholder="First Name">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail2">Field Type</label>
                                <select name="fieldType_{{ $i }}" class="form-control">
                                    <option value="text">Textfield</option>
                                    <option value="select">Dropdown</option>
                                    <option value="checkbox">Checkbox</option>
                                    <option value="radio">Radio</option>
                                    <option value="textarea">Textarea</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail2">Class</label>
                                <input type="text" name="fieldClass_{{ $i }}" class="form-control"  placeholder="form-control">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail2">Placeholder</label>
                                <input type="text" name="fieldPlaceholder_{{ $i }}" class="form-control"  placeholder="John Doe">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail2">Value</label>
                                <input type="text" name="fieldValue_{{ $i }}" class="form-control"  placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail2">Show In</label>
                                <select name="showField_{{ $i }}" class="form-control">
                                    <option value="both">Create & Edit</option>
                                    <option value="create">Create Only</option>
                                    <option value="edit">Edit Only</option>
                                    <option value="none">None</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail2">Validation</label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="inlineCheckbox1" value="option1"> Required
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="inlineCheckbox2" value="option2"> Alpha
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="inlineCheckbox3" value="option3"> Numeric
                                </label>

                            </div>

                        </fieldset>
                        @endfor

                        <button type="submit" class="btn btn-primary">Generate</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
