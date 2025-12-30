<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Stmt\TryCatch;

class Helper
{
    public static function getUser()
    {
        // Get the authenticated user from the 'users' guard
        $user = Auth::guard('users')->user();
        // Optional: Debugging the user object
        // echo "<pre>"; print_r($user); die;
        return $user;
    }

}
