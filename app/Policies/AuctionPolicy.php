<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Auction;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AuctionPolicy
{
    use HandlesAuthorization;

    public function showEdit(User $user, Auction $auction)
    {

      return $user->id == $auction->getUser($auction->owners)->id;
    }

}
