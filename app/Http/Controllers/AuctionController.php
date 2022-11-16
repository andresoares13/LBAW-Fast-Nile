<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Auction;

class AuctionController extends Controller
{
    /**
     * Shows the card for a given id.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
      $auction = Auction::find($id);
      return view('pages.auction', ['auction' => $auction]);
    }

    /**
     * Shows all cards.
     *
     * @return Response
     */
    public function list()
    {
      $auction = new Auction();
      $auctions = $auction->allAuctions();

      return view('pages.auctions', ['auctions' => $auctions]);
    }

    /**
     * Creates a new card.
     *
     * @return Card The card created.
     */
    public function create(Request $request)
    {
      $card = new Auction();

      $this->authorize('create', $card);

      $card->name = $request->input('name');
      $card->user_id = Auth::user()->id;
      $card->save();

      return $card;
    }

    public function delete(Request $request, $id)
    {
      $card = Auction::find($id);

      $this->authorize('delete', $card);
      $card->delete();

      return $card;
    }
}
