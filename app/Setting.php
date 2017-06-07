<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

protected $connection = 'mysql';

class Setting extends Model
{
  protected $fillable = [
      'db_connection', 'db_port', 'db_host', 'db_name', 'db_username',
  ];

  protected $hidden = [
      'password', 'remember_token',
  ];
}
