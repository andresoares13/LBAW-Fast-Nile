<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Auction;
use App\Models\Car;

use URL;

class AuctionController extends Controller
{

    public function show($id)
    {
      try{
        $auction = Auction::find($id);
        if (!$auction){
          abort(404);
        }
        $time = new \DateTime($auction->timeclose);
        $diff = $time->diff(new \DateTime("now"));
        $minutes = $diff->days * 24 * 60;
        $minutes += $diff->h * 60;
        $minutes += $diff->i;     
        $seconds = $diff->days * 24 * 60 * 60;
        $seconds +=$diff->h * 60 *60;
        $seconds += $minutes * 60;
        $seconds += $diff->s;
        if ($diff->invert == 0){
          $minutes = $minutes * (-1);
          $seconds = $seconds * (-1);
        }
        if ($minutes <= 0 && $auction->states != 'Closed' && $seconds <=0){
          DB::table('auction')->where('id',$auction->id)->update(['states' => 'Closed']);
          $auction = Auction::find($id);
        }
        else if ($minutes < 15 && !$auction->ending && $auction->states != 'Closed'){
          DB::table('auction')->where('id',$auction->id)->update(['ending' => true]);
          $auction = Auction::find($id);
        }
      }
      catch(\Illuminate\Database\QueryException $ex){
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




    public function showAuctionsPage($pageNr, Request $request){ //gets 6 results based on the page number
      $limit = 6 * intval($pageNr);
      if ($request->input('category') == null && $request->input('states') == null){
        $auctions = Auction::where('states','Active')->orderBy('timeclose')->limit($limit)->get();
        $totalCount = count(Auction::where('states','Active')->get());
        $lastEl = $totalCount - (6 * (intval($pageNr)-1)); //if the page is not complete we dont want repetitives, if there are 7, first page gets 6, 2nd gets 1
        $auctions = array_slice($auctions->toArray(), -$lastEl); //only get the last 6
        $auctions = Auction::hydrate($auctions);
        $totalPages = intval(ceil($totalCount /6)); //gets the total number of pages of auctions assuming each has 20
        if ($limit > $totalCount+6){
          $auctions = [];
        }
      }
      else{ //in case of search filters
        
        if ($request->category != null && $request->states == null){
          $auctions = DB::table('auction')->join('car', 'auction.idcar', '=', 'car.id')
          ->select('auction.*','car.id','car.names','car.category','car.states as carState','car.color','car.consumption','car.kilometers','car.picture')
          ->where('auction.states','Active')->where('category',$request->input('category'))->orderBy('timeclose')->limit($limit)->get();
          $totalCount = count(DB::table('auction')->join('car', 'auction.idcar', '=', 'car.id')->where('auction.states','Active')->where('category',$request->input('category'))->get());
        }
        else if ($request->states != null && $request->category == null){
          $auctions = DB::table('auction')->join('car', 'auction.idcar', '=', 'car.id')
          ->select('auction.*','car.id','car.names','car.category','car.states as carState','car.color','car.consumption','car.kilometers','car.picture')
          ->where('auction.states','Active')->where('car.states',$request->input('states'))->orderBy('timeclose')->limit($limit)->get();

          $totalCount = count(DB::table('auction')->join('car', 'auction.idcar', '=', 'car.id')
          ->where('auction.states','Active')->where('car.states',$request->input('states'))->get());
        }
        else{
          $auctions = DB::table('auction')->join('car', 'auction.idcar', '=', 'car.id')
          ->select('auction.*','car.id','car.names','car.category','car.states as carState','car.color','car.consumption','car.kilometers','car.picture')
          ->where('auction.states','Active')->where('category',$request->input('category'))->where('car.states',$request->input('states'))->orderBy('timeclose')->limit($limit)->get();
          $totalCount = count(DB::table('auction')->join('car', 'auction.idcar', '=', 'car.id')->where('auction.states','Active')->where('category',$request->input('category'))->where('car.states',$request->input('states'))->get());
        }

        
    
        $lastEl = $totalCount - (6 * (intval($pageNr)-1)); //if the page is not complete we dont want repetitives, if there are 7, first page gets 6, 2nd gets 1
        $auctions = array_slice($auctions->toArray(), -$lastEl); //only get the last 6
        $auctions = Auction::hydrate($auctions);
        $totalPages = intval(ceil($totalCount /6)); //gets the total number of pages of auctions assuming each has 20
        if ($limit > $totalCount+6){
          $auctions = [];
        }
      }
      
      
      if ($request->input('category') == null && $request->input('states') == null){
        return view('pages.auctionsAllPages', ['auctions' => $auctions,'totalPages' => $totalPages,'pageNr' => $pageNr,'filter' =>false]);
      }
      else{
        if ($request->category != null && $request->states == null){
          return view('pages.auctionsAllPages', ['auctions' => $auctions,'totalPages' => $totalPages,'pageNr' => $pageNr,'category' => $request->input('category'),'filter' =>true]);
        }
        else if ($request->states != null && $request->category == null){
          return view('pages.auctionsAllPages', ['auctions' => $auctions,'totalPages' => $totalPages,'pageNr' => $pageNr,'state' => $request->input('states'),'filter' =>true]);
        }
        else{
          return view('pages.auctionsAllPages', ['auctions' => $auctions,'totalPages' => $totalPages,'pageNr' => $pageNr,'state' => $request->input('states'),'category' => $request->input('category'),'filter' =>true]);
        }
        
      }

    }



    public function showAllAuctionsPage($pageNr, Request $request){ //gets 6 results based on the page number
      $limit = 6 * intval($pageNr);
      if ($request->input('category') == null && $request->input('states') == null){
        $auctions = Auction::orderBy('id')->limit($limit)->get();
        $totalCount = count(Auction::get());
        $lastEl = $totalCount - (6 * (intval($pageNr)-1)); //if the page is not complete we dont want repetitives, if there are 7, first page gets 6, 2nd gets 1
        $auctions = array_slice($auctions->toArray(), -$lastEl); //only get the last 6
        $auctions = Auction::hydrate($auctions);
        $totalPages = intval(ceil($totalCount /6)); //gets the total number of pages of auctions assuming each has 20
        if ($limit > $totalCount+6){
          $auctions = [];
        }
      }
      else{ //in case of search filters
        
        if ($request->category != null && $request->states == null){
          $auctions = DB::table('auction')->join('car', 'auction.idcar', '=', 'car.id')
          ->select('auction.*','car.id','car.names','car.category','car.states as carState','car.color','car.consumption','car.kilometers','car.picture')
          ->where('category',$request->input('category'))->orderBy('timeclose')->limit($limit)->get();
          $totalCount = count(DB::table('auction')->join('car', 'auction.idcar', '=', 'car.id')->where('category',$request->input('category'))->get());
        }
        else if ($request->states != null && $request->category == null){
          $auctions = DB::table('auction')->join('car', 'auction.idcar', '=', 'car.id')
          ->select('auction.*','car.id','car.names','car.category','car.states as carState','car.color','car.consumption','car.kilometers','car.picture')
          ->where('car.states',$request->input('states'))->orderBy('timeclose')->limit($limit)->get();

          $totalCount = count(DB::table('auction')->join('car', 'auction.idcar', '=', 'car.id')
          ->where('car.states',$request->input('states'))->get());
        }
        else{
          $auctions = DB::table('auction')->join('car', 'auction.idcar', '=', 'car.id')
          ->select('auction.*','car.id','car.names','car.category','car.states as carState','car.color','car.consumption','car.kilometers','car.picture')
          ->where('category',$request->input('category'))->where('car.states',$request->input('states'))->orderBy('timeclose')->limit($limit)->get();
          $totalCount = count(DB::table('auction')->join('car', 'auction.idcar', '=', 'car.id')->where('category',$request->input('category'))->where('car.states',$request->input('states'))->get());
        }

        
    
        $lastEl = $totalCount - (6 * (intval($pageNr)-1)); //if the page is not complete we dont want repetitives, if there are 7, first page gets 6, 2nd gets 1
        $auctions = array_slice($auctions->toArray(), -$lastEl); //only get the last 6
        $auctions = Auction::hydrate($auctions);
        $totalPages = intval(ceil($totalCount /6)); //gets the total number of pages of auctions assuming each has 20
        if ($limit > $totalCount+6){
          $auctions = [];
        }
      }
      

      
      if ($request->input('category') == null && $request->input('states') == null){
        return view('pages.auctionsAllPages', ['auctions' => $auctions,'totalPages' => $totalPages,'pageNr' => $pageNr,'filter' =>false,'all' =>true]);
      }
      else{
        if ($request->category != null && $request->states == null){
          return view('pages.auctionsAllPages', ['auctions' => $auctions,'totalPages' => $totalPages,'pageNr' => $pageNr,'category' => $request->input('category'),'filter' =>true,'all' =>true]);
        }
        else if ($request->states != null && $request->category == null){
          return view('pages.auctionsAllPages', ['auctions' => $auctions,'totalPages' => $totalPages,'pageNr' => $pageNr,'state' => $request->input('states'),'filter' =>true,'all' =>true]);
        }
        else{
          return view('pages.auctionsAllPages', ['auctions' => $auctions,'totalPages' => $totalPages,'pageNr' => $pageNr,'state' => $request->input('states'),'category' => $request->input('category'),'filter' =>true,'all' =>true]);
        }
        
      }

    }

    public function editAuction(Request $request){
      if (auth()->check()){
        if ($this->authorize('showEdit', $auction)){ 
          $auction = Auction::find($request->input('auction'));
          $auction->title = $request->input('title');
          $auction->descriptions = $request->input('description');
          if($request->hasFile('image')){
            $filename = $request->image->getClientOriginalName();
            $filename = $request->input('auction') . "." .pathinfo($filename,PATHINFO_EXTENSION);

            $request->image->storeAs('',$filename,'my_files2');
            $car = Car::find($auction->idcar);
            $car->picture = $filename;
            $car->save();
          }
          $auction->save();
          return redirect('auction/'.$auction->id);
        }
      }
      else if (auth()->guard('admin')->check()){
        $auction = Auction::find($request->input('auction'));
        $auction->title = $request->input('title');
        $auction->descriptions = $request->input('description');
        if($request->hasFile('image')){
          $filename = $request->image->getClientOriginalName();
          $filename = $request->input('auction') . "." .pathinfo($filename,PATHINFO_EXTENSION);

          $request->image->storeAs('',$filename,'my_files2');
          $car = Car::find($auction->idcar);
          $car->picture = $filename;
          $car->save();
        }
        $auction->save();
        return redirect('auction/'.$auction->id);
      }
      else{
        abort(403);
      }  
    }

    public function statusAuction(Request $request){
      if (auth()->check()){
        if ($this->authorize('showEdit', $auction)){
          $auction = Auction::find($request->auction);
          if (isset($request->ending)){
            $auction->ending = true;
          }
          else{
            $auction->ending = false;
          }
          if (isset($request->close)){
            $auction->states="Closed";
          }
          $auction->save();
          return redirect('auction/'.$auction->id);
        }
      }
      else if (auth()->guard('admin')->check()){
        $auction = Auction::find($request->auction);
        if (isset($request->ending)){
          $auction->ending = true;
        }
        else{
          $auction->ending = false;
        }
        if (isset($request->close)){
          $auction->states="Closed";
        }
        $auction->save();
        return redirect('auction/'.$auction->id);
      }
      else{
        abort(403);
      }  

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

    public function showAuctionStatus($id){
      if (auth()->check()){
        $auction = Auction::find($id);
        if ($this->authorize('showEdit', $auction)){ 
          return view('pages.auctionStatus', ['auction' => $auction]);
        }
        else{
          abort(403);
        }
      }
      elseif(auth()->guard('admin')->check()){
        $auction = Auction::find($id);
        return view('pages.auctionStatus', ['auction' => $auction]);
      }
      else{
        abort(403);
      }
    }

    public function deleteAuction(Request $request){
      $auction = Auction::find($request->input('auction'));
      if (auth()->check()){
        if ($this->authorize('showEdit', $auction)){ 
          if ((!$auction->hasBids($auction->id) || $auction->onlyBidsDel($auction->id)) && $auction->states != 'Closed'){
            $auction->delete();
            return redirect('/');
          }
          abort(404);
        }
        else{
          abort(403);
        }
      }  
      elseif(auth()->guard('admin')->check()){
        if ((!$auction->hasBids($auction->id) || $auction->onlyBidsDel($auction->id)) && $auction->states != 'Closed'){
          $auction->delete();
          return redirect('/');
        }
        abort(404);
      }
      else{
        abort(403);
      } 
    }

    public function getAuctionAPI(Request $request){
      $auction = Auction::find($request->input('id'));
      return $auction;
    }

    public function closeAuctionAPI(Request $request){
      
      $auction = Auction::find($request->input('id'));
      $time = new \DateTime($auction->timeclose);
      $diff = $time->diff(new \DateTime("now"));
      $minutes = $diff->days * 24 * 60;
      $minutes += $diff->h * 60;
      $minutes += $diff->i; 
      $seconds = $diff->days * 24 * 60 * 60;
      $seconds +=$diff->h * 60 *60;
      $seconds += $minutes * 60;
      $seconds += $diff->s;
      if ($minutes < 0 || $auction->states == 'Closed'){
        return header("HTTP/1.1 500 Internal Server Error");
      }
      if ($minutes > 0 && $seconds >0 &&$auction->states != 'Closed'){
        DB::table('auction')->where('id',$auction->id)->update(['states' => 'Closed']);
        $auction = Auction::find($id);
      } 
      return $auction;
    }

    public function endingAuctionAPI(Request $request){
      $auction = Auction::find($request->input('id'));
      $time = new \DateTime($auction->timeclose);
      $diff = $time->diff(new \DateTime("now"));
      $minutes = $diff->days * 24 * 60;
      $minutes += $diff->h * 60;
      $minutes += $diff->i; 
      if ($minutes >15 || $auction->ending){
        return header("HTTP/1.1 500 Internal Server Error");
      }
      if ($minutes < 15 && !$auction->ending){
        DB::table('auction')->where('id',$auction->id)->update(['ending' => true]);
        $auction = Auction::find($id);
      } 
      return $auction;
    }

}
