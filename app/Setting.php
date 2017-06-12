<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

  protected $connection = 'mysql';
  
  protected $fillable = [
      'db_connection', 'db_port', 'db_host', 'db_name', 'db_username',
  ];

  protected $hidden = [
      'password', 'remember_token',
  ];
}
