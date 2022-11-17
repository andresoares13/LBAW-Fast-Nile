<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{

  public function create(Request $request, $auction_id)
  {
    $item = new Item();
    $item->card_id = $card_id;
    $this->authorize('create', $item);
    $item->done = false;
    $item->description = $request->input('description');
    $item->save();
    return $item;
  }


}
