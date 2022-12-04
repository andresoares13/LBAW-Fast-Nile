<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Policies\UserPolicy;

use App\Models\User;
use App\Models\Auctioneer;
use App\Models\Auction;
use App\Models\Car;
use App\Models\Bid;
use App\Models\Follow;
use App\Models\Notification;

class UserController extends Controller
{

    public function show($id)
    {
      $user = User::find($id);
      return view('pages.profile', ['user' => $user]);
    }

    public function showEdit($id){
      $user = User::find($id);
      if (Auth::guard('admin')->check()){
        return view('pages.profileEdit', ['user' => $user]);
      }
      else if ($this->authorize('correctUser', $user)){
        return view('pages.profileEdit', ['user' => $user]);
      }
      else{
        abort(403);
      }
    }

    public function showWallet($id){
      $user = User::find($id);
      if ($this->authorize('correctUser', $user)){
        return view('pages.profileWallet', ['user' => $user]);
      }
      else{
        abort(403);
      }
    }

    public function showUpgrade($id){
      $user = User::find($id);
      if ($this->authorize('correctUser', $user)){
        $auctioneer = $user->getAuctioneer($user->id);
        if (count($auctioneer) == 0){
          return view('pages.profileUpgrade', ['user' => $user]);
        }
        else{
          abort(404);
        }
      }
      else{
        abort(403);
      }
    }

    public function showPicture($id){
      $user = User::find($id);
      if ($this->authorize('correctUser', $user)){
        return view('pages.profilePicture', ['user' => $user]);
      }
      else{
        abort(403);
      }
    }

    public function showAuctionCreate($id){
      
      $user = User::find($id);
      if ($this->authorize('correctUser', $user)){
        $auctioneer = $user->getAuctioneer($user->id);
        if (count($auctioneer) != 0){
          return view('pages.createAuction', ['user' => $user,'auctioneer' => $auctioneer]);
        }
        else{
          abort(404);
        }
      }
      else{
        abort(403);
      }
    }

    public function showUserAuctions($id,$pageNr){
      $limit = 5 * intval($pageNr);
      $auctioneer = Auctioneer::Find($id);
      if ($auctioneer != NULL){
        $name = $auctioneer->getName($auctioneer->iduser);
        $userId = $auctioneer->getUserId($auctioneer->iduser);
        $auctions = Auction::where('states','Active')->where('owners',$id)->orderBy('timeclose')->limit($limit)->get();
        $totalCount = count(Auction::where('states','Active')->where('owners',$id)->get());
        $lastEl = $totalCount - (5 * (intval($pageNr)-1)); //if the page is not complete we dont want repetitives, if there are 7, first page gets 5, 2nd gets 2
        $auctions = array_slice($auctions->toArray(), -$lastEl); //only get the last 5
        $auctions = Auction::hydrate($auctions);
        $totalPages = intval(ceil($totalCount /5)); //gets the total number of pages of auctions assuming each has 20
        return view('pages.auctionsAllPages', ['auctions' => $auctions,'totalPages' => $totalPages,'pageNr' => $pageNr,'id' =>$id,'name' => $name,'userId'=>$userId]);
      }
      else{
        abort(404);
      }
      
    }


    public function showUserBids($id,$pageNr){
      if (!auth()->check() && !Auth::guard('admin')->check()){
        abort(404);
      }
      $user = User::find($id);
      if (Auth::guard('admin')->check()){
        $user = User::find($id);
        $limit = 20 * intval($pageNr);
        $bids = Bid::where('iduser',$id)->orderBy('id','desc')->limit($limit)->get();
        $totalCount = count(Bid::where('iduser',$id)->get());
        $lastEl = $totalCount - (20 * (intval($pageNr)-1)); //if the page is not complete we dont want repetitives, if there are 7, first page gets 5, 2nd gets 2
        $bids = array_slice($bids->toArray(), -$lastEl); //only get the last 5
        $bids = Bid::hydrate($bids);
        $totalPages = intval(ceil($totalCount /20)); //gets the total number of pages of auctions assuming each has 20
        return view('pages.userBids', ['bids' => $bids,'totalPages' => $totalPages,'pageNr' => $pageNr, 'name' => $user->names,'id' => $id]);
      }
      else if ($this->authorize('correctUser', $user)){
        $limit = 20 * intval($pageNr);
        $bids = Bid::where('iduser',$id)->orderBy('id','desc')->limit($limit)->get();
        $totalCount = count(Bid::where('iduser',$id)->get());
        $lastEl = $totalCount - (20 * (intval($pageNr)-1)); //if the page is not complete we dont want repetitives, if there are 7, first page gets 5, 2nd gets 2
        $bids = array_slice($bids->toArray(), -$lastEl); //only get the last 5
        $bids = Bid::hydrate($bids);
        $totalPages = intval(ceil($totalCount /20)); //gets the total number of pages of auctions assuming each has 20
        return view('pages.userBids', ['bids' => $bids,'totalPages' => $totalPages,'pageNr' => $pageNr,'id' => Auth::user()->id]);
      }
      else{
        abort(403);
      }
      
    }

    public function showUserFollowed($id,$pageNr){
      $limit = 5 * intval($pageNr);
      $auctions = [];
      $follows = Follow::where('iduser',$id)->limit($limit)->get()->toArray();
      $totalCount = count(Follow::where('iduser',$id)->get());
      foreach($follows as $follow){
          $auction = Auction::find($follow['idauction']);
          $auctions[] = $auction;
      }
      $lastEl = $totalCount - (5 * (intval($pageNr)-1)); //if the page is not complete we dont want repetitives, if there are 7, first page gets 5, 2nd gets 2
      $auctions = array_slice($auctions, -$lastEl); //only get the last 5
      $totalPages = intval(ceil($totalCount /5)); //gets the total number of pages of auctions assuming each has 20
      return view('pages.auctionsAllPages', ['auctions' => $auctions,'totalPages' => $totalPages,'pageNr' => $pageNr,'follow' => true]);

    }

    public function addFunds(Request $request){
      if ((int) $request->input('funds') > 50000 || (int) $request->input('funds') < 500){
        return header("HTTP/1.1 500 Internal Server Error");
      }
      $user = User::find($request->input('user'));
      $addedFunds = $user->wallet + $request->input('funds');
      if ($this->authorize('correctUser', $user)){
        DB::table('users')->where('id',$request->input('user'))->update(['wallet' => $addedFunds]);
        return $addedFunds;
      }
      else{
        abort(403);
      }
    }


    public function editProfile(Request $request){
      if (Auth::guard('admin')->check()){
        $user = User::find($request->input('user'));
        $user->names = $request->input('name');
        $user->address = $request->input('address');
        if($request->input('phone') != NULL){
          $auctioneer = Auctioneer::find($user->getAuctioneer($user->id)[0]['id']);
          $auctioneer->phone = $request->input('phone');
          $auctioneer->save();
        }
        $user->save();
        return redirect('profile/'.$request->input('user'));
      }
      $user = User::find($request->input('user'));
      if ($this->authorize('correctUser', $user)){
        $user->names = $request->input('name');
        $user->address = $request->input('address');
        if($request->input('phone') != NULL){
          $auctioneer = Auctioneer::find($user->getAuctioneer($user->id)[0]['id']);
          $auctioneer->phone = $request->input('phone');
          $auctioneer->save();
        }
        $user->save();
        return redirect('profile/'.$request->input('user'));
      }
      else{
        abort(403);
      }
    }


    public function becomeAuctioneer(Request $request){
      $user = User::find($request->input('user'));
      if ($this->authorize('correctUser', $user)){
        $auctioneer = new Auctioneer();
        $auctioneer->iduser = $request->input('user');
        $auctioneer->phone = $request->input('phone');
        $auctioneer->save();
        return redirect('profile/'.$request->input('user'));
      }
      else{
        abort(403);
      }
    }


    public function updatePicture(Request $request)
    {
      $user = User::find($request->input('user'));
      if ($this->authorize('correctUser', $user)){
        if($request->hasFile('image')){
            $filename = $request->image->getClientOriginalName();
            $filename = $request->input('user') . "." .pathinfo($filename,PATHINFO_EXTENSION);
            
            $request->image->storeAs('',$filename,'my_files');
            $user->picture = $filename;
            $user->save();
            
        }
        return redirect('profile/'.$request->input('user'));
      }
      else{
        abort(403);
      }
    }


    public function createAuction(Request $request){
      $user = User::find($request->input('user'));
      if ($this->authorize('correctUser', $user)){
        $auctioneer = $user->getAuctioneer($user->id);
        if (count($auctioneer) != 0){

          //create car
          $car = new Car();
          $car->names = $request->input('carName');
          $car->category = $request->input('categorie');
          $car->states = $request->input('state');
          $car->color = $request->input('color');
          $car->consumption = $request->input('consumption');
          $car->kilometers = $request->input('kilometers');
          $car->save();

          //get car id to store picture
          $filename = $request->image->getClientOriginalName();
          $filename = $car->id . "." .pathinfo($filename,PATHINFO_EXTENSION);
          $request->image->storeAs('',$filename,'my_files2');
          $car->picture = $filename;
          //save picture name
          $car->save();

          //create auction
          $auction = new Auction();
          $auction->idcar = $car->id;
          $auction->descriptions = $request->input('description');
          $auction->pricestart = $request->input('priceStart');
          $auction->pricenow = $request->input('priceStart');

          //calculate date
          $date1 = strtotime($request->input('timeClose'));
          $date1 = date("Y-m-d", $date1);
          $date2 = date("H:i:s",strtotime("+2 hours"));
          $auction->timeclose = $date1 . " " . $date2;
          $auction->owners = $auctioneer[0]['id'];
          $auction->states = "Active";
          $auction->title = $request->input('title');
          $auction->save();
          return redirect('auction/'.$auction->id);


        }
        else{
          abort(404);
        }
      }
      else{
        abort(403);
      }
    }



    public function showUsersPage($pageNr){ //gets 30 results based on the page number
      $limit = 30 * intval($pageNr);
      $users = User::orderBy('id')->limit($limit)->get();
      $totalCount = count(User::get());
      $lastEl = $totalCount - (30 * (intval($pageNr)-1)); 
      $users = array_slice($users->toArray(), -$lastEl); //only get the last 30
      $users = User::hydrate($users);
      $totalPages = intval(ceil($totalCount /30)); //gets the total number of pages of auctions assuming each has 30
      return view('pages.userCard', ['users' => $users,'totalPages' => $totalPages,'pageNr' => $pageNr]);

    }

    public function followAuction(Request $request){
      $test = Follow::where('iduser',$request->input('user'))->where('idauction',$request->input('auction'))->get()->toArray();
      if (count($test) != 0){
        return header("HTTP/1.1 500 Internal Server Error");
      }
      $follow = new Follow();
      $follow->iduser = $request->input('user');
      $follow->idauction = $request->input('auction');
      DB::table('follow')->insert(['idauction' => $request->input('auction'), 'iduser' => $request->input('user')]);
      return $follow;
    }

    public function unfollowAuction(Request $request){
      $test = Follow::where('iduser',$request->input('user'))->where('idauction',$request->input('auction'))->get()->toArray();
      if (count($test) == 0){
        return header("HTTP/1.1 500 Internal Server Error");
      }
      DB::table('follow')->where('iduser',$request->input('user'))->where('idauction',$request->input('auction'))->delete();
    }
    

    public function markRead(Request $request){
      DB::table('notification')->where('id',$request->input('id'))->update(['viewed' => true]);
      return [$request->input('row'),$request->input('id')];
    }

    public function markAllRead(Request $request){
      DB::table('notification')->where('viewed',false)->where('iduser',auth()->user()->id)->update(['viewed' => true]);
      return true;
    }

    public function showNotifications($id,$pageNr){
      $user = User::find($id);
      if ($this->authorize('correctUser', $user)){
        $limit = 20 * intval($pageNr);
        $notifications = $user->getAllNotifications($id,$limit);
        $totalCount = $user->getNotificationsCount($id);
        $lastEl = $totalCount - (20 * (intval($pageNr)-1)); //if the page is not complete we dont want repetitives, if there are 7, first page gets 5, 2nd gets 2
        $notifications = array_slice($notifications->toArray(), -$lastEl); //only get the last 5
        $notifications = Notification::hydrate($notifications);
        $totalPages = intval(ceil($totalCount /20)); //gets the total number of pages of auctions assuming each has 20
        return view('pages.userNotifications', ['notifications' => $notifications,'totalPages' => $totalPages,'pageNr' => $pageNr,'id' => Auth::user()->id]);
      }
      else{
        abort(403);
      }
    }

    

    

   
}
