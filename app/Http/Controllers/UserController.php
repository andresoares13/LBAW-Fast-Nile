<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Policies\UserPolicy;

use App\Models\User;
use App\Models\Auctioneer;

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

    

   
}
