<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Models\User;
use App\Models\Notification;

class FeaturesController extends Controller
{



    public function showFeatures()
    {
        
      return view('pages.features');
      
    }



}