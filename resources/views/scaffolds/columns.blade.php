@extends('layouts.master-full')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title">Table Columns</h4>
                    <p class="category">Select your table columns to generate code</p>
                </div>
                <div class="content table-responsive table-full-width">

                    <form method="POST" action="{{ route('scaffold.generate') }}">

                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><button type="button" class="btn btn-info btn-fill">General Code Attribute</button></h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row builder_row">
                                            <div class="col-md-11">
                                                <div class="col-md-3">
                                                    <label for="">Object Name (singular)</label>
                                                    <input type="text" name="object_name" id="object_name" class="form-control border-input"  placeholder="" value="{{ $table_parameters['object_name'] or '' }}" >
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="">Controller Name</label>
                                                    <input type="text" name="controller_name" id="controller_name" class="form-control border-input"  placeholder="" value="{{ $table_parameters['controller_name'] or '' }}" >
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="">API Route</label>
                                                    <input type="text" name="api_route_name" id="api_route_name" class="form-control border-input" value="{{ $table_parameters['api_route_name'] or '' }}"  placeholder="" >
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="">Model Name</label>
                                                    <input type="text" name="model_name" id="model_name" class="form-control border-input"  placeholder="" value="{{ $table_parameters['model_name'] or '' }}" >
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="">Transformer Name</label>
                                                    <input type="text" name="transformer_name" id="transformer_name" class="form-control border-input"  placeholder="" value="{{ $table_parameters['transformer_name'] or '' }}" >
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="">View Folder Name</label>
                                                    <input type="text" name="view_name" id="view_name" class="form-control border-input"  placeholder="" value="{{ $table_parameters['views_folder_name'] or '' }}" >
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="">Table Name</label>
                                                    <input type="text" readonly="readonly" name="table_name" id="table_name" class="form-control border-input"  placeholder="" value="{{ $table or '' }}" >
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="">Single Variable</label>
                                                    <input type="text" name="singular_variable" id="singular_variable" class="form-control border-input" value="{{ $table_parameters['singular_variable'] or '' }}"  placeholder="" >
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="">Plural Variable</label>
                                                    <input type="text" name="plural_variable" id="plural_variable" class="form-control border-input" value="{{ $table_parameters['plural_variable'] or '' }}"  placeholder="" >
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="">Table PK</label>
                                                    <input type="text" readonly="readonly" name="table_pk" id="table_pk" class="form-control border-input" value="id"  placeholder="" >
                                                </div>
                                                <div class="col-md-4" style="padding-top:25px;">
                                                    {{--<button type="submit" class="btn btn-primary">Generate</button>--}}
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="btn-group-vertical" role="group" aria-label="...">
                                                    <button type="submit" class="btn btn-primary btn-lg btn-fill">Generate</button>
                                                    <button type="submit" class="btn btn-success btn-lg btn-fill">Generate</button>
                                                    <button type="submit" class="btn btn-warning btn-lg btn-fill">Generate</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <table class="table table-striped">
                            <thead>
                            <th>No.</th>
                            <th>Field Key</th>
                            <th>Label</th>
                            <th>Field Type</th>
                            <th>Field Class & Id</th>
                            <th>Validation</th>
                            <th>Relationship</th>
                            <th>Model Attribute</th>
                            <th>Default Value & Placeholder</th>
                            <th>Show In</th>
                            </thead>
                            <tbody>
                            @foreach($table_columns as $column)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <button class="btn btn-info btn-fill">{{ $column->Field }}</button>
                                    </td>
                                    <td>
                                        <input type="text" name="fieldKey_{{ $loop->iteration }}" class="form-control border-input field_key" placeholder="" value="{{ $column->Label }}" >
                                    </td>
                                    <td>
                                        <select name="fieldType_{{ $loop->iteration }}" class="form-control border-input field_type">
                                            <option value="text">Textfield</option>
                                            <option value="select">Dropdown</option>
                                            <option value="selectDynamic">Dynamic Dropdown</option>
                                            <option value="checkbox">Checkbox</option>
                                            <option value="radio">Radio</option>
                                            <option value="textarea">Textarea</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="fieldClass_{{ $loop->iteration }}" class="form-control border-input field_key" placeholder="" value="form-control" >
                                        <input type="text" name="fieldId_{{ $loop->iteration }}" class="form-control border-input field_id" placeholder="" value="{{ $column->Field }}" >
                                    </td>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                    <td>
                                        <input type="text" name="fieldValue_{{ $loop->iteration }}" class="form-control border-input field_key" placeholder="" value="" >
                                        <input type="text" name="fieldPlaceholder_{{ $loop->iteration }}" class="form-control border-input field_key" placeholder="" value="" >
                                    </td>
                                    <td>
                                        <select name="showField_{{ $loop->iteration }}" class="form-control border-input">
                                            <option value="create_edit_transformer">Create & Edit & Transformer</option>
                                            <option value="create_edit">Create & Edit</option>
                                            <option value="create">Create Only</option>
                                            <option value="edit">Edit Only</option>
                                            <option value="list_transformer">List & Transformer Only</option>
                                            <option value="list">List Only</option>
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </form>



                </div>
            </div>
        </div>

    </div>

@endsection