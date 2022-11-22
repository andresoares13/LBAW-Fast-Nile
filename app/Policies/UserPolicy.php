<?php

namespace App\Policies;

use App\Models\User;


use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;

    public function correctUser(User $user, User $tryUser)
    {
      return $user->id == $tryUser->id;
    }

    
}