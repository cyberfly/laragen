<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use Auth;
use Hashids;
use Illuminate\Support\Facades\Crypt;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_settings = Setting::where("user_id", Auth::User()->id) -> get();
        return view("dbSettings.settings-index", compact("user_settings"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('dbSettings.settings-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          $this->validate($request, [
           'db_connection' => 'required',
           'db_port' => 'required',
           'db_host' => 'required',
           'db_name' => 'required|unique:settings|max:255',
           'db_username' => 'required',
         ]);

        $setting = new Setting;
        $user_setting_name = $request -> db_name;
        $setting -> db_connection = $request -> db_connection;
        $setting -> db_port = $request -> db_port;
        $setting -> db_host = $request -> db_host;
        $setting -> db_name = $request -> db_name;
        $setting -> db_username = $request -> db_username;
        $setting -> db_password = Crypt::encryptString($request -> db_password);
        $setting -> user_id = Auth::User() -> id;
        $setting -> save();

        flash("The preset for " . $user_setting_name . " database successfully updated");
        return redirect() -> route('settings.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_setting = Setting::find($id);
        $user_setting -> db_password = Crypt::decryptString($user_setting -> db_password);
        return view("dbSettings.settings-edit", compact("user_setting"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

      $this->validate($request, [
       'db_connection' => 'required',
       'db_port' => 'required',
       'db_host' => 'required',
       'db_name' => 'required',
       'db_username' => 'required',
      ]);

      $user_setting = Setting::find($id);
      $user_setting_name = $user_setting -> db_name;
      $user_setting -> db_connection = $request -> db_connection;
      $user_setting -> db_port = $request -> db_port;
      $user_setting -> db_host = $request -> db_host;
      $user_setting -> db_name = $request -> db_name;
      $user_setting -> db_username = $request -> db_username;
      $user_setting -> db_password = Crypt::encryptString($request -> db_password);
      $user_setting -> update();


      flash("The preset for " . $user_setting_name . " database successfully updated");
      return redirect() -> route('settings.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user_setting = Setting::find($id);
      $user_setting_name = $user_setting -> db_name;
      $user_setting -> delete();

      flash("The preset for " . $user_setting_name . " database successfully deleted");
      return redirect() -> route('settings.index');
    }
}
