<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Block extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;
  protected $table = 'block';

  public function getUsername($id){
    return User::find($id)->names;
  }

  public function getUsernameAdmin($id){
    return Admin::find($id)->names;
  }



}
