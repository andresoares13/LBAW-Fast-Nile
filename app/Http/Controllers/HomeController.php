<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Models\Auction;
use App\Models\User;
use App\Models\Notification;

class HomeController extends Controller
{



    public function showHome()
    {
      $auction = new Auction();
      $auctions = $auction->allAuctions();
      $soonAuction = $auction->getSoonAuction();
      
      return view('pages.home', ['auctions' => $auctions,'soonAuction' => $soonAuction[0]]);
    }

    public function showAboutUs()
    {
        
      return view('pages.aboutUs');
      
    }

    public function showContacts()
    {
        
      return view('pages.contacts');
      
    }


    public function showFeatures()
    {
        
      return view('pages.features');
      
    }



}


