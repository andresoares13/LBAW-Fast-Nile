<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Auction;

class AuctionController extends Controller
{

    public function show($id)
    {
      $auction = Auction::find($id);
      return view('pages.auction', ['auction' => $auction]);
    }


    public function list()
    {
      $auction = new Auction();
      $auctions = $auction->allAuctions();

      return view('pages.auctions', ['auctions' => $auctions]);
    }


    public function showAuctionsPage($pageNr){ //gets 5 results based on the page number
      $limit = 5 * intval($pageNr);
      $auctions = Auction::where('states','Active')->orderBy('timeclose')->limit($limit)->get();
      $totalCount = count(Auction::where('states','Active')->get());
      $lastEl = $totalCount - (5 * (intval($pageNr)-1)); //if the page is not complete we dont want repetitives, if there are 7, first page gets 5, 2nd gets 2
      $auctions = array_slice($auctions->toArray(), -$lastEl); //only get the last 5
      $auctions = Auction::hydrate($auctions);
      $totalPages = intval(ceil($totalCount /5)); //gets the total number of pages of auctions assuming each has 20
      return view('pages.auctionsAllPages', ['auctions' => $auctions,'totalPages' => $totalPages,'pageNr' => $pageNr]);

    }
}
