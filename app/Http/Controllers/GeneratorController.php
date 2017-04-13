<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CreateFormService;

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

    public function __construct(CreateFormService $service)
    {
        $this->middleware('auth');
        $this->CreateFormService = $service;
        $this->generateForm = TRUE;
        $this->generateForm = FALSE;
        $this->useRouteName = FALSE;
        $this->useMassAssignment = FALSE;
    }

    public function create()
    {
        $fieldTotal = 10;
        return view('generator.formbuilder',compact('fieldTotal'));
    }

    public function generate()
    {


        //            generate form
       $createForm = $this->CreateFormService->generateCreateForm(request());

        //            generate migration

//            generate controller
//            generate model with relationship, scope
//            generate trait
//            generate listing page with search/filter


    }

    public function display()
    {

    }
}
