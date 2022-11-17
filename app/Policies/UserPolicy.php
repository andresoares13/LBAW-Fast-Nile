<?php

namespace App\Policies;

use App\Models\User;


use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;

    public function editAllow(User $user, int $id)
    {
      echo $user->id;
      echo $id;
      exit();
      return $user->id == $id;
    }

    
}