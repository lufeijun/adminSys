<?php

namespace App\Model\Privilege;

use Illuminate\Database\Eloquent\Model;

class Ability extends Model
{
  //
  protected $fillable = ['role_id', 'ability','type'];
}
