<form class="form-horizontal" method="PUT" action="{{ route ('projects.update') }}">
    {{ csrf_field() }}

    <div class="form-group">
        <label for="id">Id</label>
        <input type="text" name="id" class="form-control" id="id" value="{{ old('id',$project->id) }}" placeholder="">
    </div>

    <div class="form-group">
        <label for="user_id">User</label>
        <input type="text" name="user_id" class="form-control" id="user_id"
               value="{{ old('user_id',$project->user_id) }}" placeholder="">
    </div>

    <div class="form-group">
        <label for="project_name">Project Name</label>
        <input type="text" name="project_name" class="form-control" id="project_name"
               value="{{ old('project_name',$project->project_name) }}" placeholder="">
    </div>

    <div class="form-group">
        <label for="type">Type</label>
        <input type="text" name="type" class="form-control" id="type" value="{{ old('type',$project->type) }}"
               placeholder="">
    </div>

    <div class="form-group">
        <label for="api_url">Api Url</label>
        <input type="text" name="api_url" class="form-control" id="api_url"
               value="{{ old('api_url',$project->api_url) }}" placeholder="">
    </div>

    <div class="form-group">
        <label for="created_at">Created At</label>
        <input type="text" name="created_at" class="form-control" id="created_at"
               value="{{ old('created_at',$project->created_at) }}" placeholder="">
    </div>

    <div class="form-group">
        <label for="updated_at">Updated At</label>
        <input type="text" name="updated_at" class="form-control" id="updated_at"
               value="{{ old('updated_at',$project->updated_at) }}" placeholder="">
    </div>

</form>