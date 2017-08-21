@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title">Database Table List</h4>
                    <p class="category">Your Laravel database tables ready to scaffold</p>
                </div>
                <div class="content table-responsive table-full-width">

                    <table class="table table-striped">
                        <thead>
                        <th>No.</th>
                        <th>Table Name</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach($selectTable as $table)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $table }}</td>
                            <td>
                                <a href="{{ route('scaffold.column','project_id=1&table='.$table) }}" class="btn btn-primary btn-fill">Generate Code</a>
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