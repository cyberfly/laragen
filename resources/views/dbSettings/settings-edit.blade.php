@extends('layouts.app')

@section('content')

<div class="container-fluid">
  <form class="" action="{{ route('settings.update', $user_setting -> id) }}" method="post">
    <div class="row">

        <input type="hidden" name="_method" value="PATCH">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="col-md-8 col-md-offset-2">

            @include('flash::message');

            <div class="panel panel-primary">
                <div class="panel-heading">Update DB Preset - {{ $user_setting -> db_name }}</div>

                <div class="panel-body">

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
                        <input type="text" name="db_connection" id="db_connection" class="form-control"  placeholder="" value="{{ $user_setting -> db_connection }}">
                    </div>
                    <div class="col-md-6">
                        <label for="">DB_port</label>
                        <input type="text" name="db_port" id="db_port" class="form-control"  placeholder="" value="{{ $user_setting -> db_port }}">
                    </div>
                    <div class="col-md-6">
                        <label for="">DB_host</label>
                        <input type="text" name="db_host" id="db_host" class="form-control"  placeholder="127.0.0.1 / localhost" value="{{ $user_setting -> db_host }}">
                    </div>
                    <div class="col-md-6">
                        <label for="">DB_name</label>
                        <input type="text" name="db_name" id="db_name" class="form-control"  placeholder="" value="{{ $user_setting -> db_name }}">
                    </div>
                    <div class="col-md-6">
                        <label for="">DB_username</label>
                        <input type="text" name="db_username" id="db_username" class="form-control"  placeholder="root" value="{{ $user_setting -> db_username }}">
                    </div>
                    <div class="col-md-6">
                        <label for="">DB_password</label>
                        <input type="password" name="db_password" id="db_password" class="form-control"  placeholder="" value="{{ $user_setting -> db_password }}">
                    </div>

                    <!-- connect_to_db button and register_db_preset button -->
                    <div class="col-md-4" style="padding-top:25px;">
                        <button type="submit" class="btn btn-success">Update Setting</button>
                    </div>

                  </div>

                </div>
            </div>
        </div>
    </div>
  </form>

</div>
@endsection
@section('page_script')
  <script>
  $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
  </script>
@endsection
