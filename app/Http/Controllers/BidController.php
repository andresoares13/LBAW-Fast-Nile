<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\User;
use App\Models\Bid;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{

  public function create(Request $request)
  {
    
    $bid = new Bid();
    $bid->iduser = $request->input('user');
    $this->authorize('create', $bid);
    $bid->idauction = $request->input('auction');
    $bid->valuee = $request->input('bid');
    $bid->save();
    $bid->username = $bid->getUsername($bid->iduser);
    return $bid;
  }


}
