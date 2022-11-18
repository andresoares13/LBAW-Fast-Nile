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

class UserController extends Controller
{
    /**
     * Shows the card for a given id.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
      $user = User::find($id);
      return view('pages.profile', ['user' => $user]);
    }

    public function showEdit($id){
      $user = User::find($id);
      if ($user->id == Auth::user()->id){
        return view('pages.profileEdit', ['user' => $user]);
      }
      else{
        abort(403);
      }
    }

    public function showWallet($id){
      $user = User::find($id);
      if ($user->id == Auth::user()->id){
        return view('pages.profileWallet', ['user' => $user]);
      }
      else{
        abort(403);
      }
    }

    public function showUpgrade($id){
      $user = User::find($id);
      if ($user->id == Auth::user()->id){
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
      if ($user->id == Auth::user()->id){
        return view('pages.profilePicture', ['user' => $user]);
      }
      else{
        abort(403);
      }
    }

    public function showAuctionCreate($id){
      
      $user = User::find($id);
      if ($user->id == Auth::user()->id){
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

    public function addFunds(Request $request){
      if ($request->input('user') == Auth::user()->id){
        $user = User::find($request->input('user'));
        $user->wallet = $user->wallet + $request->input('funds');
        $user->save();
        return redirect('profile/'.$request->input('user'));
      }
      else{
        abort(403);
      }
    }


    public function editProfile(Request $request){
      if ($request->input('user') == Auth::user()->id){
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
      else{
        abort(403);
      }
    }


    public function becomeAuctioneer(Request $request){
      if ($request->input('user') == Auth::user()->id){
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
      if ($request->input('user') == Auth::user()->id){
        if($request->hasFile('image')){
            $filename = $request->image->getClientOriginalName();
            $filename = $request->input('user') . "." .pathinfo($filename,PATHINFO_EXTENSION);
            
            $request->image->storeAs('',$filename,'my_files');
            $user = User::find($request->input('user'));
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
      if ($user->id == Auth::user()->id){
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

    

   
}
