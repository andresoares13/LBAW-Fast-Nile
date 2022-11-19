<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Auction;
use App\Models\User;

class SearchController extends Controller
{
    public function viewSearchFull(Request $request){
        $result = Auction::search($request->input('q'))->get();
        return view('pages.searchAuctionFT', ['auctions' => $result,'query' => $request->input('q')]);
    }

    public function viewSearchExact(Request $request){
        $result = Auction::where('title',$request->input('q'))->orWhere('descriptions',$request->input('q'))->get();
        return view('pages.searchAuctionM', ['auctions' => $result,'query' => $request->input('q')]);
    }

    public function viewSearchUser(Request $request){
        $result = User::where('names', 'ilike', '%' . $request->input('q') . '%')->limit(20)->get();
        return view('pages.searchUser', ['users' => $result,'query' => $request->input('q')]);
    }

    public function viewSearchPage(){
        return view('pages.searchPage');
    }
}
