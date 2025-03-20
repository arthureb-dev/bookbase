<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;

class BookPolicy
{
    /**
     * Determine whether the user can manage the model.
     */
    public function manageAny(User $user): bool
    {
        return $user->hasRole(Role::LIBRARIAN);
    }
}
