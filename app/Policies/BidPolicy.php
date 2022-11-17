<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Auction;
use App\Models\Bid;

use Illuminate\Auth\Access\HandlesAuthorization;

class BidPolicy
{
    use HandlesAuthorization;

    public function create(User $user, Bid $bid)
    {
      // User can only create items in cards they own
      return $user->id == $bid->iduser;
    }


}
