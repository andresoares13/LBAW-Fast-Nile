<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Auctioneer extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;
  protected $table = 'auctioneer';

  /**
   * The card this item belongs to.
   */
  public function user() {
    return $this->belongsTo('App\Models\User');
  }

  public function getName($id){
    $user = DB::table('users')->where('id',$id)->get()->toArray();
    return $user[0]->names;
  }

  public function getUserId($id){
    $user = DB::table('users')->where('id',$id)->get()->toArray();
    return $user[0]->id;
  }

  
}