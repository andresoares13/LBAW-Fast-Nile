<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Auction extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;
  protected $table = 'auction';

  /**
   * The user this card belongs to
   */
  public function user() {
    return $this->belongsTo('App\Models\User');
  }

  /**
   * Items inside this card
   */
  public function bids() {
    return $this->hasMany('App\Models\Bid');
  }
  
  public function allAuctions(){
    $auctions = DB::table('auction')->orderBy('pricenow','desc')->limit(20)->get()->toArray();
    return Auction::hydrate($auctions);
  }
  
  public function getTopBid(int $id){
    $bid = DB::table('bid')->where('idauction', $id)->limit(1)->get()->toArray();
    return Bid::hydrate($bid);
  }
  
  public function getTop10Bids(int $id){
    $bids = DB::table('bid')->where('idauction', $id)->orderBy('valuee', "desc")->limit(10)->get()->toArray();

    return Bid::hydrate($bids); 
  }

  public function getCarPicture(int $id){
    $car = DB::table('car')->where('id', $id)->limit(1)->get();
    return $car[0]->picture;
  }
}
