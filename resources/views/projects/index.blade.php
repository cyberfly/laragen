@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title">Project List</h4>
                    <p class="category">Your Laravel projects ready to scaffold</p>
                    <a class="btn btn-info btn-fill" href="{{ route('projects.create') }}">New Project</a>
                </div>
                <div class="content table-responsive table-full-width">

                    <table class="table table-striped">
                        <thead>
                        <th>ID</th>
                        <th>Project Name</th>
                        <th>API Url</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach($projects as $project)
                        <tr>
                            <td>{{ $project->id }}</td>
                            <td>{{ $project->project_name }}</td>
                            <td><code>{{ $project->api_url }}</code></td>
                            <td>
                                <a href="{{ route('scaffold.select','project='.$project->id) }}" class="btn btn-primary">Scaffold</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>

@endsection