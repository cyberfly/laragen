@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Generated Code</div>

                <div class="panel-body">


                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#createform" aria-controls="createform" role="tab" data-toggle="tab">Create Form</a></li>
                        <li role="presentation"><a href="#editform" aria-controls="editform" role="tab" data-toggle="tab">Edit Form</a></li>
                        <li role="presentation"><a href="#controller" aria-controls="controller" role="tab" data-toggle="tab">Controller</a></li>
                        <li role="presentation"><a href="#model" aria-controls="model" role="tab" data-toggle="tab">Model</a></li>
                        <li role="presentation"><a href="#formrequest" aria-controls="formrequest" role="tab" data-toggle="tab">Form Request</a></li>
                        <li role="presentation"><a href="#migration" aria-controls="migration" role="tab" data-toggle="tab">Migration</a></li>
                        <li role="presentation"><a href="#route" aria-controls="route" role="tab" data-toggle="tab">Route</a></li>
                        <li role="presentation"><a href="#api_route" aria-controls="api_route" role="tab" data-toggle="tab">API Route</a></li>
                        <li role="presentation"><a href="#api_controller" aria-controls="api_controller" role="tab" data-toggle="tab">API Controller</a></li>
                        <li role="presentation"><a href="#api_createform" aria-controls="api_createform" role="tab" data-toggle="tab">API Create Form</a></li>
                        <li role="presentation"><a href="#api_editform" aria-controls="api_editform" role="tab" data-toggle="tab">API Edit Form</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="createform">
                            <pre class=""><code class="language-html line-numbers">{{ $createForm }}</code></pre>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="editform">
                            <pre class=""><code class="language-html line-numbers">{{ $editForm }}</code></pre>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="controller">
                            <pre class=""><code class="language-php line-numbers">{{ $objectController }}</code></pre>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="model">
                            <pre class=""><code class="language-php line-numbers">{{ $objectModel}}</code></pre>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="formrequest">
                            <pre class=""><code class="language-php line-numbers">{{ $editForm }}</code></pre>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="migration">
                            <pre class=""><code class="language-php line-numbers">{{ $objectMigration }}</code></pre>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="route">
                            <pre class=""><code class="language-php line-numbers">{{ $objectMigration }}</code></pre>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="api_route">
                            <pre class=""><code class="language-php line-numbers">{{ $objectMigration }}</code></pre>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="api_controller">
                            <pre class=""><code class="language-php line-numbers">{{ $objectMigration }}</code></pre>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="api_createform">
                            <pre class=""><code class="language-php line-numbers">{{ $objectMigration }}</code></pre>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="api_editform">
                            <pre class=""><code class="language-php line-numbers">{{ $objectMigration }}</code></pre>
                        </div>
                    </div>




                </div>
            </div>
        </div>
    </div>
</div>
@endsection
