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

  
}