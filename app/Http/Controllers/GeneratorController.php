<?php

namespace App\Http\Controllers;

use App\Services\CreateModelService;
use Illuminate\Http\Request;
use App\Services\CreateFormService;
use App\Services\EditFormService;
use App\Services\CreateResourceControllerService;
use Config;
use DB;
use App\Setting;
use Auth;
use Illuminate\Support\Facades\Crypt;

class GeneratorController extends Controller
{
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

    public function __construct(CreateFormService $service, EditFormService $editFormService, CreateResourceControllerService $resourceControllerService, CreateModelService $createModelService)
    {
        $this->middleware('auth');
        $this->CreateFormService = $service;
        $this->EditFormService = $editFormService;
        $this->CreateResourceControllerService = $resourceControllerService;
        $this->CreateModelService = $createModelService;
        $this->generateForm = TRUE;
        $this->generateForm = FALSE;
        $this->useRouteName = FALSE;
        $this->useMassAssignment = FALSE;
    }

    public function create()
    {
        $fieldTotal = 10;
        $selectTable = 0;
        return view('generator.formbuilder',compact('fieldTotal'));
    }

    public function generate()
    {


        //            generate form
       $createForm = $this->CreateFormService->generateCreateForm(request());
       $editForm = $this->EditFormService->generateEditForm(request());
       $objectController = $this->CreateResourceControllerService->generateResourceController(request());
       $objectModel = $this->CreateModelService->generateModel(request());
       $objectMigration = $this->EditFormService->generateEditForm(request());

        //            generate migration

//            generate controller
//            generate model with relationship, scope
//            generate trait
//            generate listing page with search/filter

        return view('generator.generatedcode',compact('createForm','editForm','objectController','objectModel','objectMigration'));

    }

    public function display()
    {

    }

    public function connectdb(Request $request)
    {

        $defaultConnection = Config::get('database.connections');


        //Set values of default config to the value of request
        $defaultConnection['mysql-mod']['host'] = $request -> db_host;
        $defaultConnection['mysql-mod']['port'] = $request -> db_port;
        $defaultConnection['mysql-mod']['database'] = $request -> db_name;
        $defaultConnection['mysql-mod']['username'] = $request -> db_username;
        $defaultConnection['mysql-mod']['password'] = $request -> database_password;

        //tamper the connection config with the input
        config(['database.connections' => $defaultConnection]);

        //pdo command to get the list of tables of selected database
        $sql_show_table = "Tables_in_" . $request -> db_name;

        //init variable of selectTable inputs
        $selectTable = array();
        $fieldTotal = 10;

        try {
            DB::connection('mysql-mod')->getPdo();
            $tables = DB::connection('mysql-mod')->select('SHOW TABLES');

            foreach ($tables as $table) {
              //populate dropdown table input
              array_push($selectTable, $table -> $sql_show_table);
            }


            //flash session item
            $request->session()->put('connection', $defaultConnection);
            $request->session()->put('selectTable', $selectTable);

            //boilerplate inputCheck variable
            $inputCheck = array();
            for ($i=0; $i < 10 ; $i++) {
              array_push($inputCheck, "");
            }

            $selectDBs = Setting::where('user_id', Auth::user() -> id) -> get();

            flash()->overlay("Successfully connected to '" . $request -> db_name . "''<br>Please proceed by selecting the table of your choice for code generation", 'Success');

            return view('generator.formbuilder', compact('selectDBs', 'selectTable', 'fieldTotal', 'inputCheck'));

        } catch (\Exception $e) {
            flash()->overlay($e -> getMessage() . "<br>Please check your preset configuration for '". $request -> db_name . "' database preset", 'Failed');
            return redirect('/form');
        }

    }

   public function formatLabelName($label) {

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

    public function populateTableForm($id) {
      $selectedSetting = Setting::find($id);
      $selectedSetting -> db_password = Crypt::decryptString($selectedSetting -> db_password);
      return json_encode($selectedSetting);
    }

    public function populateField(Request $request) {

      //Init array to automate input selection for dynamic dropdown / foreign key
      $inputCheck = array();

      //Init array for input name
      $inputName = array();

      //pull the connection data from previous session
      $defaultConnection = ($request -> session() -> pull('connection'));
      $selectTable = ($request -> session() -> pull('selectTable'));

      //tamper the connection config with the previous session connection data
      config(['database.connections' => $defaultConnection]);

      $targetTable = $request -> selectTable;

      $tableColumns = DB::connection('mysql-mod')->select('SHOW COLUMNS FROM ' . $targetTable);

      $fieldTotal = sizeof($tableColumns);


      foreach ($tableColumns as $tableColumn) {

        //check for possible input automation selection - $inputCheck array
        if (preg_match('/_id$/', $tableColumn -> Field)) {
          array_push($inputCheck, "selectDynamic");
        } else {
          array_push($inputCheck, "");
        }

        //format label name accordingly - $inputName array
        $name = $tableColumn -> Field;

        $label = $this->formatLabelName($name);

        array_push($inputName, $label);

      }

      $request->session()->put('connection', $defaultConnection);
      $request->session()->put('selectTable', $selectTable);

      $selectDBs = Setting::where('user_id', Auth::user() -> id) -> get();

      return view('generator.formbuilder', compact('selectDBs', 'selectTable','fieldTotal', 'targetTable', 'tableColumns', 'inputCheck', 'inputName'));


    }



}
