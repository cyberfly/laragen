@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">

        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-primary">
                <div class="panel-heading">User DB Preset</div>

                <div class="panel-body" id="formbuilder">

                    <table class="table table-striped">
                      <thead>
                        <th>Connection</th>
                        <th>Port</th>
                        <th>Host</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Action</th>
                      </thead>
                      <tbody>
                      @if($user_settings -> isEmpty())
                        <tr>
                          <td colspan="6">Please register database preset</td>
                        </tr>
                      @else
                      @foreach($user_settings as $setting)
                        <tr>
                          <td>{{ $setting -> db_name }}</td>
                          <td>{{ $setting -> db_connection }}</td>
                          <td>{{ $setting -> db_port }}</td>
                          <td>{{ $setting -> db_host }}</td>
                          <td>{{ $setting -> db_username }}</td>
                          <td><a href="{{ route('settings.edit', $setting -> id) }}" class="btn btn-md btn-warning">Edit</a></td>
                          <td>
                            <form class="" action="{{ route('settings.destroy', $setting -> id) }}" method="post">
                              <input type="hidden" name="_method" value="DELETE">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <input type="submit" class="btn btn-md btn-danger" value="Delete">
                            </form>
                          </td>
                        </tr>
                      @endforeach
                      @endif
                      </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-md-8 col-md-offset-2">
          @include('flash::message');
        </div>
    </div>
</div>

@endsection
@section('page_script')
  <script>
  $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
  </script>
@endsection
