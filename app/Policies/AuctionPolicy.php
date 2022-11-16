<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Auction;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AuctionPolicy
{
    use HandlesAuthorization;

    public function show(User $user, Auction $auction)
    {
      // Only a card owner can see it
      return $user->id == $card->user_id;
    }

    public function list(User $user)
    {
      // Any user can list its own cards
      return Auth::check();
    }

    public function create(User $user)
    {
      // Any user can create a new card
      return Auth::check();
    }

    public function delete(User $user, Auction $auction)
    {
      // Only a card owner can delete it
      return $user->id == $auction->owner;
    }
}
