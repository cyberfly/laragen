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
                        <li role="presentation" class="active" ><a href="#api_controller" aria-controls="api_controller" role="tab" data-toggle="tab">API Controller</a></li>
                        <li role="presentation"><a href="#transformer" aria-controls="transformer" role="tab" data-toggle="tab">Transformer</a></li>
                        <li role="presentation"><a href="#model" aria-controls="model" role="tab" data-toggle="tab">Model</a></li>
                        <li role="presentation"><a href="#formrequest" aria-controls="formrequest" role="tab" data-toggle="tab">Form Request</a></li>
                        <li role="presentation"><a href="#api_route" aria-controls="api_route" role="tab" data-toggle="tab">API Route</a></li>
                        <li role="presentation"><a href="#angular_createform" aria-controls="angular_createform" role="tab" data-toggle="tab">Angular Create</a></li>
                        <li role="presentation"><a href="#angular_editform" aria-controls="angular_editform" role="tab" data-toggle="tab">Angular Edit</a></li>
                        <li role="presentation"><a href="#angular_list" aria-controls="angular_list" role="tab" data-toggle="tab">Angular List</a></li>
                        <li role="presentation"><a href="#angular_controller" aria-controls="angular_controller" role="tab" data-toggle="tab">Angular Controller</a></li>
                        <li role="presentation"><a href="#angular_service" aria-controls="angular_service" role="tab" data-toggle="tab">Angular Service</a></li>
                        <li role="presentation"><a href="#createform" aria-controls="createform" role="tab" data-toggle="tab">Create Form</a></li>
                        <li role="presentation"><a href="#editform" aria-controls="editform" role="tab" data-toggle="tab">Edit Form</a></li>
                        <li role="presentation"><a href="#controller" aria-controls="controller" role="tab" data-toggle="tab">Controller</a></li>
                        <li role="presentation"><a href="#service" aria-controls="model" role="tab" data-toggle="tab">Service</a></li>
                        <li role="presentation"><a href="#migration" aria-controls="migration" role="tab" data-toggle="tab">Migration</a></li>
                        <li role="presentation"><a href="#route" aria-controls="route" role="tab" data-toggle="tab">Route</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="api_controller">
                            <pre class=""><code class="language-php line-numbers">{{ $objectAPIController }}</code></pre>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="transformer">
                            <pre class=""><code class="language-php line-numbers">{{ $objectAPITransformer}}</code></pre>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="model">
                            <pre class=""><code class="language-php line-numbers">{{ $objectModel}}</code></pre>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="formrequest">
                            <pre class=""><code class="language-php line-numbers">{{ $editForm }}</code></pre>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="createform">
                            <pre class=""><code class="language-html line-numbers">{{ $createForm }}</code></pre>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="editform">
                            <pre class=""><code class="language-html line-numbers">{{ $editForm }}</code></pre>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="controller">
                            <pre class=""><code class="language-php line-numbers">{{ $objectController }}</code></pre>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="service">
                            <pre class=""><code class="language-php line-numbers">{{ $objectModel}}</code></pre>
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
                        <div role="tabpanel" class="tab-pane" id="angular_createform">
                            <pre class=""><code class="language-php line-numbers">{{ $objectMigration }}</code></pre>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="angular_editform">
                            <pre class=""><code class="language-php line-numbers">{{ $objectMigration }}</code></pre>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="angular_list">
                            <pre class=""><code class="language-php line-numbers">{{ $objectMigration }}</code></pre>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="angular_controller">
                            <pre class=""><code class="language-php line-numbers">{{ $objectMigration }}</code></pre>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="angular_service">
                            <pre class=""><code class="language-php line-numbers">{{ $objectMigration }}</code></pre>
                        </div>
                    </div>




                </div>
            </div>
        </div>
    </div>
</div>
@endsection
