<?php
/**
 * Created by PhpStorm.
 * User: AlKo
 * Date: 2019-02-18
 * Time: 01:10
 */

namespace Core;

use App\Config;
use App\Models\User;

class Auth
{

    public static function handleAuth()
    {
        $isLoggedIn = $_SESSION['isLoggedIn'];
        if ($isLoggedIn == false)
        {
            session_destroy();
            header('location:'.Config::URL);
            exit;
        }
    }

    public static function startSession(User $user) {

        Session::init();
        Session::set('isLoggedIn', true);
        Session::set('userId', $user->id);
        Session::set('username', $user->username);
        Session::set('email', $user->email);

    }

}