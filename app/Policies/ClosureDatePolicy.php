<?php

namespace App\Policies;

use App\Models\ClosureDate;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClosureDatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        // return $user->hasRole(['admin','qam','qac']);
       return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ClosureDate  $closureDate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ClosureDate $closureDate)
    {
        // return $user->hasRole('admin');
        return $user->isQAM() || $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        // return $user->hasRole('admin');
        return $user->isAdmin() ;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ClosureDate  $closureDate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ClosureDate $closureDate)
    {
        // return $user->hasRole('admin');
        return $user->isAdmin() ;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ClosureDate  $closureDate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ClosureDate $closureDate)
    {
        // return $user->hasRole('admin');
        return $user->isAdmin() ;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ClosureDate  $closureDate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ClosureDate $closureDate)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ClosureDate  $closureDate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ClosureDate $closureDate)
    {
        //
    }
}
