<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Notification extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;
  protected $table = 'notification';

  public function getAuctionName($id){
    return Auction::find($id)->title;
  }



}
