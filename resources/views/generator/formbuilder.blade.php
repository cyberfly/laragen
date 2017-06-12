@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @include('flash::message')
    <div class="row">
        <div class="col-md-12">
        </div>
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Form Builder</div>

                <div class="panel-body" id="formbuilder">

                    <form action="/connectdb" method="POST" id="dbPreset">

                        {{ csrf_field() }}

                        <!-- Input fields to select database -->
                        <div class="row builder_row">
                          <div class="col-md-6">
                            <div class="form-group">
                            <label for="db_preset">Select DB_Preset:</label>
                            <select class="form-control" id="db_preset" name="db_preset">
                              @if(sizeof($selectDBs) == 0)
                                <option value="" >Please register datababase preset</option>
                                @else
                                <option class="" value="" >Please select a database preset</option>
                                @foreach($selectDBs as $selectDB)
                                  <option class="selectDB" value="{{ $selectDB -> id or " " }}"> {{ $selectDB -> db_name}} </option>
                                @endforeach
                              @endif
                            </select>
                            </div>
                          </div>
                        </div>

                        <div class="progress">
                            <div class="progress-bar progress-bar-success" style="width: 95%">
                                <span class="sr-only">35% Complete (success)</span>
                            </div>
                        </div>

                        <div class="row builder_row">
                          <div class="col-md-12">
                            <!-- Error message -->
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            <!-- Error message -->
                          </div>
                          <div class="col-md-6">
                              <label for="">DB_Connection</label>
                              <input type="text" name="db_connection" id="db_connection" class="form-control"  placeholder="mysql" value="">
                          </div>
                          <div class="col-md-6">
                              <label for="">DB_port</label>
                              <input type="text" name="db_port" id="db_port" class="form-control"  placeholder="3306" value="">
                          </div>
                          <div class="col-md-6">
                              <label for="">DB_host</label>
                              <input type="text" name="db_host" id="db_host" class="form-control"  placeholder="127.0.0.1 / localhost" value="">
                          </div>
                          <div class="col-md-6">
                              <label for="">DB_name</label>
                              <input type="text" name="db_name" id="db_name" class="form-control"  placeholder="DB_name" value="">
                          </div>
                          <div class="col-md-6">
                              <label for="">DB_username</label>
                              <input type="text" name="db_username" id="db_username" class="form-control"  placeholder="root" value="">
                          </div>
                          <div class="col-md-6">
                              <label for="">DB_password</label>
                              <input type="password" name="db_password" id="db_password" class="form-control"  placeholder="secret" value="">
                          </div>

                          <!-- connect_to_db button and register_db_preset button -->
                          <div class="col-md-4" style="padding-top:25px;">
                              <button type="submit" class="btn btn-success">Connect to DB</button>
                              <button type="submit" class="btn btn-primary" name="storeDbPreset" id="storeDbPreset" style="margin-left:20px;">Register DB Preset</button>
                          </div>

                        </div>

                      </form>

                        <div class="progress">
                            <div class="progress-bar progress-bar-success" style="width: 95%">
                                <span class="sr-only">35% Complete (success)</span>
                            </div>
                        </div>

                <form  action="/selectTable" method="POST">

                  {{ csrf_field() }}

                  <div class="row builder_row">


                      <?php
                          $selectStatus = (is_null($selectTable) == true) ? "disabled" : "" ;
                       ?>

                      <div class="col-md-6">
                        <label for="selectTable">Select table:</label>
                        <select class="form-control" id="selectTable" name="selectTable" <?php echo $selectStatus ?>>
                          @if(is_null($selectTable) == true)
                              <option value="Please configure the database section first">Please configure the database section first</option>
                            @else
                            @foreach($selectTable as $table)
                              <option value="{{ $table }}">{{ $table }}</option>
                            @endforeach
                          @endif
                        </select>
                      </div>

                      <!-- select and populate table -->
                      <div class="col-md-4" style="padding-top:25px;">
                          <button type="submit" class="btn btn-primary">Select Table</button>
                      </div>
                  </div>

                </form>

                <div class="progress">
                    <div class="progress-bar progress-bar-success" style="width: 95%">
                        <span class="sr-only">35% Complete (success)</span>
                    </div>
                </div>

                <form action="/build" method="POST">

                    {{ csrf_field() }}

                        <div class="row builder_row">
                            <div class="col-md-2">
                                <label for="">Object Name (singular)</label>
                                @if(isset($targetTable))
                                  <input type="text" name="object_name" id="object_name" class="form-control"  placeholder="" value="{{ $targetTable }}">
                                @else
                                  <input type="text" name="object_name" id="object_name" class="form-control"  placeholder="">
                                @endif
                            </div>
                            <div class="col-md-2">
                                <label for="">Controller Name</label>
                                <input type="text" name="controller_name" id="controller_name" class="form-control"  placeholder="">
                            </div>
                            <div class="col-md-2">
                                <label for="">Model Name</label>
                                <input type="text" name="model_name" id="model_name" class="form-control"  placeholder="">
                            </div>
                            <div class="col-md-2">
                                <label for="">View Folder Name</label>
                                <input type="text" name="view_name" id="view_name" class="form-control"  placeholder="">
                            </div>
                            <div class="col-md-2">
                                <label for="">Table Name</label>
                                <input type="text" name="table_name" id="table_name" class="form-control"  placeholder="">
                            </div>
                            <div class="col-md-2">
                                <label for="">Table PK</label>
                                <input type="text" name="table_pk" id="table_pk" class="form-control" value="id"  placeholder="">
                            </div>
                            <div class="col-md-4" style="padding-top:25px;">
                                <button type="submit" class="btn btn-primary">Generate</button>
                            </div>
                        </div>

                        <div class="progress">
                            <div class="progress-bar progress-bar-warning" style="width: 95%">
                                <span class="sr-only">35% Complete (success)</span>
                            </div>
                        </div>

                        @for ($i=0;$i<$fieldTotal;$i++)
                          <div class="row builder_row">
                              <div class="col-md-2">
                                  <label for="">Key</label>
                                  <input type="text" name="fieldKey_{{ $i }}" class="form-control field_key"  placeholder="first_name" value="{{ $tableColumns[$i] -> Field or ''}}" >
                              </div>
                              <div class="col-md-2">
                                  <label for="formlabel">Label</label>
                                  <input type="text" name="fieldLabel_{{ $i }}" class="form-control field_label" id="" placeholder="First Name" value="{{ $inputName[$i] or ''}}">
                              </div>
                            <div class="col-md-2">
                                <label for="">Field Type</label>
                                <select name="fieldType_{{ $i }}" class="form-control">
                                    <?php $selectDynamic = (strcmp($inputCheck[$i], "selectDynamic") == 0) ? "selected" : "" ; ?>
                                    <option value="text">Textfield</option>
                                    <option value="select">Dropdown</option>
                                    <option value="selectDynamic" <?php echo $selectDynamic ?>>Dynamic Dropdown</option>
                                    <option value="checkbox">Checkbox</option>
                                    <option value="radio">Radio</option>
                                    <option value="textarea">Textarea</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label for="">Field Class</label>
                                <input type="text" name="fieldClass_{{ $i }}" class="form-control"  value="form-control" placeholder="form-control">
                            </div>

                            <div class="col-md-2">
                                <label for="">Field Id</label>
                                <input type="text" name="fieldId_{{ $i }}" class="form-control"  placeholder="first_name" value="{{ $tableColumns[$i] -> Field or ''}}">
                            </div>

                            <div class="col-md-2">
                                <label for="">Show In</label>
                                <select name="showField_{{ $i }}" class="form-control">
                                    <option value="both">Create & Edit</option>
                                    <option value="create">Create Only</option>
                                    <option value="edit">Edit Only</option>
                                    <option value="none">None</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label for="">Relationship</label>
                                <input type="text" name="fieldRelationship_{{ $i }}" class="form-control"  placeholder="relationship name">
                                <input type="text" name="fieldRelationshipModel_{{ $i }}" class="form-control"  placeholder="relationship model name">
                                <input type="text" name="fieldRelationshipFK_{{ $i }}" class="form-control"  placeholder="relationship key">
                            </div>

                            <div class="col-md-2">
                                <label for="">Value</label>
                                <input type="text" name="fieldValue_{{ $i }}" class="form-control"  placeholder="">
                            </div>

                            <div class="col-md-2">
                                <label for="">Placeholder</label>
                                <input type="text" name="fieldPlaceholder_{{ $i }}" class="form-control"  placeholder="John Doe">
                            </div>
                            <div class="col-md-4">
                                <label for="">Validation</label>
                                <div>

                                    <input type="checkbox" id="inlineCheckbox1" value="option1"> Required

                                    <input type="checkbox" id="inlineCheckbox2" value="option2"> Alpha

                                    <input type="checkbox" id="inlineCheckbox3" value="option3"> Numeric

                                </div>

                            </div>
                            <div class="col-md-2">
                                <label for="">Extra Validation Rule</label>
                                <input type="text" name="fieldExtraValidation_{{ $i }}" class="form-control"  placeholder="">
                            </div>

                        </div>

                            <div class="progress">
                                <div class="progress-bar progress-bar-success" style="width: 35%">
                                    <span class="sr-only">35% Complete (success)</span>
                                </div>
                                <div class="progress-bar progress-bar-warning progress-bar-striped" style="width: 20%">
                                    <span class="sr-only">20% Complete (warning)</span>
                                </div>
                                <div class="progress-bar progress-bar-info progress-bar-striped" style="width: 40%">
                                    <span class="sr-only">10% Complete (danger)</span>
                                </div>
                            </div>

                        @endfor

                        <input type="hidden" name="fieldTotal" value="{{ $fieldTotal }}">

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_script')

    <script type="text/javascript">
        $( document ).ready(function() {

            //Modal trigger function
             $('#flash-overlay-modal').modal();

            //Trigger the function when the page loads
              var object_name = $("#object_name").val();
              if(object_name === "") {
                console.log("object_name is empty");
              } else if(object_name.endsWith("s")) {
                object_name = object_name.substring(0, object_name.length - 1);
                generateControllerModelViewName(object_name);
              } else {
                generateControllerModelViewName(object_name);
              }

            //Will populate the form if selected
            $('#db_preset').change(function(){

              var setting_id = $( "#db_preset option:selected" ).val();

              // ajax jquery
              $.get("/populateTableForm/" + setting_id + "/get", function(data){
                  var JsonObject = JSON.parse(data);
                  console.log(JsonObject);

                  //Set the input of the database setting form
                  $('#db_connection').val(JsonObject.db_connection);
                  $('#db_port').val(JsonObject.db_port);
                  $('#db_host').val(JsonObject.db_host);
                  $('#db_name').val(JsonObject.db_name);
                  $('#db_username').val(JsonObject.db_username);
                  $('#db_password').val(JsonObject.db_password);

              });
            })

            //Change the form action to store the DB preset
            $("#storeDbPreset").on("click", function(e){
                e.preventDefault();
                $('#dbPreset').attr('action', "/settings").submit();
            });

            $( "#object_name" ).keyup(function() {
                var object_name = $(this).val();
                generateControllerModelViewName(object_name);
            });

            $( ".field_key" ).keyup(function() {
                var field_key = $(this).val();
                var label = generateLabelName(field_key);
            });

            function generateLabelName(field_key) {

            }

            //expected output
            //ProductsController.php
            //Product.php
            //resources/products

            function generateControllerModelViewName(object_name) {

                var split_obj = object_name.split(" ");

                var controller_prefix = '';

                if (split_obj.length>0) {
                    for (var i = 0; i < split_obj.length; i++) {
                        controller_prefix = controller_prefix + ucfirst(split_obj[i]);
                    }
                }
                else{
                    controller_prefix = ucfirst(object_name);
                }

                var table_name = object_name.toLowerCase().replace(/ /g,"_")+'s';
//                var view_folder_name = controller_prefix.toLowerCase()+'s';
                var view_folder_name = table_name;

                var controller_name = controller_prefix + 'sController.php';
                var model_name = controller_prefix + '.php';
                var view_name = 'resources/'+view_folder_name;

                $( "#controller_name" ).val(controller_name);
                $( "#model_name" ).val(model_name);
                $( "#view_name" ).val(view_name);
                $( "#table_name" ).val(table_name);

            }

            function ucfirst(s)
            {
                return s && s[0].toUpperCase() + s.slice(1);
            }

        });
    </script>

@endsection
