<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\User;
use App\Models\Bid;
use App\Models\Notification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{

  public function create(Request $request)
  {
    
    $bid = new Bid();
    $bid->iduser = $request->input('user');
    $bid->idauction = $request->input('auction');
    $bid->valuee = $request->input('bid');

    //send notifications

    $users = Bid::distinct()->select('iduser')->where('idauction',$request->input('auction'))->where('iduser', '!=' , $request->input('user'))->orWhereNull('iduser')->get();

    /* remove later, please don't forget it is literally one of the checklists
    foreach ($users as $user){
      DB::table('notification')->insert(['idauction' => $request->input('auction'), 'iduser' => $user['iduser'],'messages' => 'New bid on participating auction']);
    }
    $auction = Auction::find($request->input('auction'));
    DB::table('notification')->insert(['idauction' => $request->input('auction'), 'iduser' => $auction->getUser($auction->owners)->id,'messages' => 'New bid on your auction']);
    */

    //note: we don't use $bid->save() as this would refresh the page and we don't want that when we make a bid
    DB::table('bid')->insert(['idauction' => $request->input('auction'), 'iduser' => $request->input('user'),'valuee' => $request->input('bid')]);
    $bidToSend = Bid::where('iduser',$request->input('user'))->where('idauction',$request->input('auction'))->where('valuee',$request->input('bid'))->get();
    $bidToSendFinal = Bid::find($bidToSend[0]->id);
    event(new \App\Events\PlaygroundEvent($bidToSendFinal,$bid->getUsername($bid->iduser)));
    $bid->username = $bid->getUsername($bid->iduser);
    return $bid;
  }




}
