<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Bid extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;

  /**
   * The card this item belongs to.
   */
  public function auction() {
    return $this->belongsTo('App\Models\Auction');
  }

  public function getUserName(int $id){
    $user = DB::table('users')->where('id', $id)->get();
    return $user[0]->names;
  }
}
