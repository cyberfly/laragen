<?php

use App\Setting;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
//    return view('welcome');

      return redirect() -> route('login');
});

Route::get('/form', function () {

      $fieldTotal = 10;
      $selectTable = null;

      $selectDBs = Setting::where('user_id', Auth::user() -> id) -> get();

      //boilerplate inputCheck variable
      $inputCheck = array();
      for ($i=0; $i < 10 ; $i++) {
        array_push($inputCheck, "");
      }

      //boilerplate inputName variable
      $inputName = array();
      for ($i=0; $i < 10 ; $i++) {
        array_push($inputName, "");
      }

      return view('generator.formbuilder',compact('selectDBs', 'fieldTotal', 'selectTable', 'inputCheck', 'inputName'));
});

Route::get('/populateTableForm/{id}/get', 'GeneratorController@populateTableForm');

Route::resource('settings', 'SettingController');

Route::post('/build', 'GeneratorController@generate');

Auth::routes();

Route::post('/connectdb', 'GeneratorController@connectdb');

Route::post('/selectTable', 'GeneratorController@populateField');

Route::get('/home', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');
