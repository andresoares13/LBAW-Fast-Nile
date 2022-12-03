<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Follow extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;
  protected $table = 'follow';



}
