@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Register New DB Preset</div>

                <div class="panel-body" id="formbuilder">

                    <form action="/connectdb" method="POST">

                        {{ csrf_field() }}

                        <div class="row builder_row">
                          <div class="col-md-6 col-md-offset-2">
                            <label for=""></label>
                          </div>
                        </div>
                        

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
