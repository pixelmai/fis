<?php

namespace App\Policies;

use App\Accounts;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any accounts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the accounts.
     *
     * @param  \App\User  $user
     * @param  \App\Accounts  $accounts
     * @return mixed
     */
    public function view(User $user, Accounts $accounts)
    {
        //
    }

    /**
     * Determine whether the user can create accounts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the accounts.
     *
     * @param  \App\User  $user
     * @param  \App\Accounts  $accounts
     * @return mixed
     */
    public function update(User $user, Accounts $accounts)
    {
        //
        //return $user->id == $profile->user_id;
    }

    /**
     * Determine whether the user can delete the accounts.
     *
     * @param  \App\User  $user
     * @param  \App\Accounts  $accounts
     * @return mixed
     */
    public function delete(User $user, Accounts $accounts)
    {
        //
    }

    /**
     * Determine whether the user can restore the accounts.
     *
     * @param  \App\User  $user
     * @param  \App\Accounts  $accounts
     * @return mixed
     */
    public function restore(User $user, Accounts $accounts)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the accounts.
     *
     * @param  \App\User  $user
     * @param  \App\Accounts  $accounts
     * @return mixed
     */
    public function forceDelete(User $user, Accounts $accounts)
    {
        //
    }
}
