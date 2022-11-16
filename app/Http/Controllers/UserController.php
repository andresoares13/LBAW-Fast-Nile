<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

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

    

   
}
