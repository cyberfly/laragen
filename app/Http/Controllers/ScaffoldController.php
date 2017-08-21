<?php

namespace App\Http\Controllers;

use App\Project;
use App\Services\CreateAPIControllerService;
use App\Services\CreateAPIRouteService;
use App\Services\CreateFormRequestService;
use App\Services\CreateModelService;
use App\Services\CreateTransformerService;
use App\Traits\GeneratorParameter;
use Illuminate\Http\Request;
use App\Services\CreateFormService;
use App\Services\EditFormService;
use App\Services\CreateResourceControllerService;
use Config;
use DB;
use App\Setting;
use Auth;
use Illuminate\Support\Facades\Crypt;
use GuzzleHttp\Client;

class ScaffoldController extends Controller
{
    use GeneratorParameter;

    protected $generateForm;
    protected $useCollective;
    protected $useRouteName;
    protected $useMassAssignment;
    protected $generateDataTable;
    protected $generateController;
    protected $generateModel;
    protected $generateMigration;
    protected $generateJobs;
    protected $generateService;
    protected $generateEvent;
    protected $generateTrait;

    private $service;

    public function __construct(
        CreateFormService $service,
        EditFormService $editFormService,
        CreateResourceControllerService $resourceControllerService,
        CreateModelService $createModelService,
        CreateAPIControllerService $createApiControllerService,
        CreateTransformerService $createTransformerService,
        CreateAPIRouteService $createAPIRouteService,
        CreateFormRequestService $createFormRequestService
    ) {
        $this->middleware('auth');
        $this->CreateFormService = $service;
        $this->EditFormService = $editFormService;
        $this->CreateResourceControllerService = $resourceControllerService;
        $this->CreateModelService = $createModelService;
        $this->CreateAPIControllerService = $createApiControllerService;
        $this->CreateTransformerService = $createTransformerService;
        $this->CreateAPIRouteService = $createAPIRouteService;
        $this->CreateFormRequestService = $createFormRequestService;
        $this->generateForm = true;
        $this->generateForm = false;
        $this->useRouteName = false;
        $this->useMassAssignment = false;
    }

    public function generate()
    {
        //generate API
        $objectAPIController = $this->CreateAPIControllerService->generateAPIController(request());

        dd($objectAPIController);

        //generate model with relationship, scope
        $objectModel = $this->CreateModelService->generateModel(request());

        //generate API transformer

        $objectAPITransformer = $this->CreateTransformerService->generateTransformer(request());

        //generate Form Request class

        $objectFormRequest = $this->CreateFormRequestService->generateTransformer(request());

        //generate API routes

        $objectAPIRoute = $this->CreateAPIRouteService->generateAPIRoute(request());

        //generate form

        $createForm = $this->CreateFormService->generateCreateForm(request());
        $editForm = $this->EditFormService->generateEditForm(request());

        //generate controller

        $objectController = $this->CreateResourceControllerService->generateResourceController(request());
        $objectMigration = $this->EditFormService->generateEditForm(request());

        //generate migration

        //generate trait

        //generate listing page with search/filter

        return view('generator.generatedcode',
            compact('createForm', 'editForm', 'objectController', 'objectModel', 'objectMigration',
                'objectAPIController','objectAPITransformer', 'objectAPIRoute', 'objectFormRequest'));

    }

    public function scaffoldSelection(Request $request)
    {
        $project_id = $request->project;
        $project = Project::find($project_id);
        $api_url = $project->api_url;

        $client = new Client();
        $result = $client->get($api_url, []);

        $db_structure = [];
        $db_relationships = [];
        $db_table_parameters = [];
        $selectTable = [];
        $db_hasmany_relationships = [];

        if ($result->getStatusCode() == 200) {

            $result_body = json_decode($result->getBody());

            $db_structure = $result_body;

            foreach ($result_body as $table => $columns) {

                //populate dropdown table input
                array_push($selectTable, $table);

                //populate global fields array to determine all relationship

//                $tableColumns = DB::connection('mysql-mod')->select('SHOW COLUMNS FROM ' . $table);
//                $db_relationships[$table] = $this->getTablesRelationship($tableColumns);

                //set table parameters

                $this->setDatabaseTableParameter($table);

                //get generated table parameters

                $db_table_parameters[$table] = $this->getGeneratorParameters();

            }

        }

        $request->session()->put('db_structure', $db_structure);

        //store db_relationships in session to use later in service/trait/controller

        $request->session()->put('db_relationships', $db_relationships);

        //store db_hasmany_relationships in session to use later in service/trait/controller

        $request->session()->put('db_hasmany_relationships', $db_hasmany_relationships);

        //store db table parameters in session to use later in service/trait/controller
        $request->session()->put('db_table_parameters', $db_table_parameters);

        //boilerplate inputCheck variable
        $inputCheck = array();
        for ($i = 0; $i < 10; $i++) {
            array_push($inputCheck, "");
        }

        $selectDBs = Setting::where('user_id', Auth::user()->id)->get();

        $transformer_fields = [];
        $hidden_fields = [];

        $current_steps = 'load_db_connection';

        flash()->overlay("Successfully connected to '" . $request->db_name . "''<br>Please proceed by selecting the table of your choice for code generation",
            'Success');

        return view('scaffolds.index', compact('selectDBs', 'selectTable', 'fieldTotal', 'inputCheck', 'tableColumns', 'hidden_fields','transformer_fields','current_steps'));
    }

    //select columns from table

    public function scaffoldColumnSelection(Request $request)
    {
        $project_id = $request->project_id;
        $table = $request->table;

        $db_structure = $request->session()->get('db_structure');

        if (!$db_structure) {
            return redirect()->route('projects.index');
        }

        $table_columns = $db_structure->$table;

        foreach ($table_columns as $table_column) {
            $table_column->Label = $this->formatLabelName($table_column->Field);
        }


//        dd($table_columns);

        return view('scaffolds.columns', compact('table_columns','table'));
    }

    public function formatLabelName($label)
    {

        $name = "";
        $exploded = "";

        if (preg_match('/^[a-z]+_[a-z]+$/i', $label)) {
            if (preg_match('/_id$/', $label)) {
                preg_match('/.+?(?=_)/', $label, $exploded);
                $name = ucwords($exploded[0]);
            } else {
                $name = ucwords(str_replace("_", " ", $label));
            }
        } else {
            $name = ucwords($label);
        }

        return $name;

    }

}
