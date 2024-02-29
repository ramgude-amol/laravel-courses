<?php

namespace App\Policies;

use App\Models\Listing;
use App\Models\User;

class ListingPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function before(?User $user, $ability)
    {
        /** check user is not null and is_admin to have all page/actions access */
        if ($user?->is_admin /*&& $ability === 'update' */) {
            return true;
        }
    }

    public function viewAny(?User $user)
    {
        return true;
    }

    public function view(User $user, Listing $listing)
    {
        return true;
    }

    public function update(User $user, Listing $listing)
    {
        return $user->id == $listing->by_user_id;
    }

    public function delete(User $user, Listing $listing)
    {
        return $user->id == $listing->by_user_id;
    }

    public function restore(User $user, Listing $listing)
    {
        return $user->id == $listing->by_user_id;
    }

    public function forceDelete(User $user, Listing $listing)
    {
        return $user->id == $listing->by_user_id;
    }
}
