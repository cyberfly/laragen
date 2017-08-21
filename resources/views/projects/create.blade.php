@extends('layouts.master')

@section('content')

    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h4 class="title">New Project</h4>
                </div>
                <div class="content">
                    <form class="" method="POST" action="{{ route ('projects.store') }}">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Project Name</label>
                                    <input type="text" class="form-control border-input" name="project_name" id="project_name" value="{{ old('project_name') }}"
                                           placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>API Url</label>
                                    <input type="text" name="api_url" class="form-control border-input" id="api_url" value="{{ old('api_url') }}" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <a href="{{ route('projects.index') }}" class="btn btn-info">Cancel</a>
                            <button type="submit" class="btn btn-info btn-fill btn-wd">Create Project</button>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>

    </div>

@endsection