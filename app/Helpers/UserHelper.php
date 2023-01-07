<?php

namespace App\Helpers;



class UserHelper
{

    /**
     * Get current user
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public static function currentUser()
    {
        return auth()->user();
    }

    /**
     * Get current user's data
     *
     * @return \App\Models\Data
     */
    public static function currentUserData()
    {
        return self::currentUser()->data();
    }
}
