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

    public function getNotificationsUnread5($id){
        $notifications = Notification::where('iduser',$id)->where('viewed',false)->orderBy('id','desc')->limit(5)->get();
        return $notifications;
    }

    public function getAllNotifications($id,$limit){
        $notifications = Notification::where('iduser',$id)->orderBy('id','desc')->limit($limit)->get();
        return $notifications;
    }

    public function getNotificationsCount($id){
        return count(Notification::where('iduser',$id)->get()->toArray());
    }

    public function isBlocked($id){
        $block = DB::table('block')->where('iduser',$id)->get()->toArray();
        
        if (count($block) > 0){
            return true;
        }
        return false;
    }

    public function countAuctionsWon($id,$idAuctioneer){
        $auctions=Auction::where('highestbidder',$id)->where('owners',$idAuctioneer)->where('states','Closed')->get();
        return count($auctions);
    }

    public function countRatingOnAuct($id,$idAuctioneer){
        $ratings = DB::table('rating')->where('iduser',$id)->where('idauctioneer',$idAuctioneer)->get()->toArray();
        return count($ratings);
    }

}
