<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function view(User $user)
    {
        return $user->permission == 1;
    }
    public function update(User $user,User $requestingUser) {
        return $user->id == $requestingUser->id || $user->permission == 1;
    }
}
