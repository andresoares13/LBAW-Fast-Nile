<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
Use Exception;

use App\Models\Auction;
use App\Models\User;

class SearchController extends Controller
{
    public function viewSearchFull(Request $request){
        try{
            $result = Auction::search($request->input('q'))->get();
        }
        catch(Exception $ex){
            abort(404);
        }
        return view('pages.searchAuctionFT', ['auctions' => $result,'query' => $request->input('q')]);
    }

    public function viewSearchExact(Request $request){
        try{
            $result = Auction::whereRaw('LOWER(title) = (?)',[strtolower($request->input('q'))])->orWhereRaw('LOWER(descriptions) = (?)', [strtolower($request->input('q'))])->get();
        }
        catch(Exception $ex){
            abort(404);
        }
        return view('pages.searchAuctionM', ['auctions' => $result,'query' => $request->input('q')]);
    }

    public function viewSearchUser(Request $request){
        try{
            $result = User::where('names', 'ilike', '%' . $request->input('q') . '%')->limit(20)->get();
        }
        catch(Exception $ex){
            abort(404);
        }
        return view('pages.searchUser', ['users' => $result,'query' => $request->input('q')]);
    }

    public function viewSearchPage(){
        return view('pages.searchPage');
    }
}
