<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
Use Exception;

class Auction extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;
  protected $table = 'auction';

  public function user() {
    return $this->belongsTo('App\Models\User');
  }


  public function bids() {
    return $this->hasMany('App\Models\Bid');
  }
  
  public function allAuctions(){
    try{
      $auctions = DB::table('auction')->where('states','Active')->orderBy('pricenow','desc')->limit(20)->get()->toArray();
    }
    catch(Exception $ex){
      return [];
    }
    return Auction::hydrate($auctions);
  }
  
  public function getTopBid(int $id){
    $bid = DB::table('bid')->where('idauction', $id)->limit(1)->get()->toArray();
    return Bid::hydrate($bid);
  }
  
  public function getTopBids(int $id){
    $bids = DB::table('bid')->where('idauction', $id)->orderBy('valuee', "desc")->limit(5)->get()->toArray();

    return Bid::hydrate($bids); 
  }

  public function getCarPicture(int $id){
    $car = DB::table('car')->where('id', $id)->limit(1)->get();
    return $car[0]->picture;
  }

  public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }
        return $query->whereRaw('tsvectors @@ plainto_tsquery(\'english\', ?)', [$search])
            ->orderByRaw('ts_rank(tsvectors, plainto_tsquery(\'english\', ?)) DESC', [$search]);
    }

  public function getAuctioneerName($id){
    $auctioneer = Auctioneer::find($id);
    $user = User::find($auctioneer->iduser);
    return $user->names;
  }

  public function isOwner($id,$Aid){
    $user = User::find($id);
    $auctioneer = $user->getAuctioneer($id);
    $auction = Auction::where('owners',$auctioneer[0]->id)->where('id',$Aid)->get();
    if (count($auction)==1){
      return TRUE;
    }
    else{
      return FALSE;
    }
  }

  public function hasBids($id){
    $auction = Auction::find($id);
    $bids = Bid::where('idauction',$auction->id)->get()->toArray();
    if (count($bids)>0){
      return TRUE;
    }
    else{
      return FALSE;
    }
  }

  public function getUser($auctioneerId){
    $auctioneer = Auctioneer::find($auctioneerId);
    $user = User::find($auctioneer->iduser);
    return $user;
  }

  public function getHighestBidderName($id){
    $user = User::find($id);
    return $user->names;
  }

  public function isAuct($id){
    $auctioneer = Auctioneer::where('iduser',$id)->get();

    if (isset($auctioneer[0]['id'])){
      return TRUE;
    }
    

    return FALSE;
  }

  public function getCar($id){
    $car = Car::find($id);
    return $car;
  }

  public function getSoonAuction(){
    try{
      $auction = Auction::where('states','Active')->orderBy('timeclose')->limit(1)->get();
      return $auction;
    }
    catch(Exception $ex){
      return null;
    }
  }


  public function getBidsNum($id){
    try{
      $bids = Bid::where('idauction',$id)->get();
      return count($bids->toArray());
    }
    catch(Exception $ex){
      return null;
    }
  }

  public function isFollowed($idAuction,$idUser){
    $test = Follow::where('iduser',$idUser)->where('idauction',$idAuction)->get()->toArray();
    if (count($test) == 0){
      return false;
    }
    return true;

  }

  
  public function onlyBidsDel($id){
    $auction = Auction::find($id);
    if (!$this->hasBids($id)){
      return FALSE;
    }
    $bids = Bid::where('idauction',$auction->id)->whereNull('iduser')->get()->toArray();
    $notNull = Bid::where('idauction',$auction->id)->whereNotNull('iduser')->get()->toArray();
    if (count($bids)>0 && count($bids) == count($notNull)){
      return TRUE;
    }
    else{
      return FALSE;
    }
  }
}
