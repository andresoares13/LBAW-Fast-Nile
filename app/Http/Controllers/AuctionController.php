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
      try{
        $auction = Auction::find($id);
        $time = new \DateTime($auction->timeclose);
        $diff = $time->diff(new \DateTime("now"));
        $minutes = $diff->days * 24 * 60;
        $minutes += $diff->h * 60;
        $minutes += $diff->i;
        //var_dump($diff);
        //exit();
        
        //if ($minutes <= 0){
            //DB::table('auction')->where('id',$auction->id)->update(['ending' => true]);
        //}
      }
      catch(Illuminate\Database\QueryException $ex){
        dd($ex->getMessage()); 
      }
      return view('pages.auction', ['auction' => $auction]);
    }


    public function list()
    {
      $auction = new Auction();
      $auctions = $auction->allAuctions();
      

      return view('pages.auctions', ['auctions' => $auctions]);
    }


    public function showAuctionsPage($pageNr){ //gets 6 results based on the page number
      $limit = 6 * intval($pageNr);
      $auctions = Auction::where('states','Active')->orderBy('timeclose')->limit($limit)->get();
      $totalCount = count(Auction::where('states','Active')->get());
      $lastEl = $totalCount - (6 * (intval($pageNr)-1)); //if the page is not complete we dont want repetitives, if there are 7, first page gets 6, 2nd gets 1
      $auctions = array_slice($auctions->toArray(), -$lastEl); //only get the last 6
      $auctions = Auction::hydrate($auctions);
      $totalPages = intval(ceil($totalCount /6)); //gets the total number of pages of auctions assuming each has 20
      return view('pages.auctionsAllPages', ['auctions' => $auctions,'totalPages' => $totalPages,'pageNr' => $pageNr]);

    }

    public function editAuction(Request $request){
      $auction = Auction::find($request->input('auction'));
      $auction->title = $request->input('title');
      $auction->descriptions = $request->input('description');
      $auction->save();
      return redirect('auction/'.$auction->id);
    }


    public function showAuctionEdit($id){
      if (auth()->check()){
        $auction = Auction::find($id);
        if ($this->authorize('showEdit', $auction)){ 
          return view('pages.auctionEdit', ['auction' => $auction]);
        }
        else{
          abort(403);
        }
      }
      elseif(auth()->guard('admin')->check()){
        $auction = Auction::find($id);
        return view('pages.auctionEdit', ['auction' => $auction]);
      }
      else{
        abort(403);
      }
    }

    public function deleteAuction(Request $request){
      $auction = Auction::find($request->input('auction'));
      if (!$auction->hasBids($auction->id)){
        $auction->delete();
        return redirect('/');
      }
      abort(404);
      
    }

}
