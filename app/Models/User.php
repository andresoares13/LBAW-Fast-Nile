<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'names','email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


     public function auctions() {
      return $this->hasMany('App\Models\Auction');
    }

    public function getAuctioneer($id){
        $auct = DB::table('auctioneer')->where('iduser', $id)->get()->toArray();
        return Auctioneer::hydrate($auct); 
    }

    public function isAuctioneer($id){
        $auct = Auctioneer::where('iduser',$id)->get();
        if (count($auct) == 0){
            return false;
        }
        else{
            return true;
        }
    }

    public function getBidsMade($id){
        $bids=Bid::where('iduser',$id)->get();
        return $bids;
    }

    public function getAuctionsWon($id){
        $auctions=Auction::where('highestbidder',$id)->where('states','Closed')->get();
        return $auctions;
    }
}
