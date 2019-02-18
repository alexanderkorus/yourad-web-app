<?php
/**
 * Created by PhpStorm.
 * User: AlKo
 * Date: 2019-02-18
 * Time: 01:10
 */

namespace Core;

use App\Config;

class Auth
{

    public static function handleLogin()
    {
        @session_start();
        $isLoggedIn = $_SESSION['isLoggedIn'];
        if ($isLoggedIn == false)
        {
            session_destroy();
            header('location:'.Config::URL);
            exit;
        }
    }

    public static function startSession($user) {

        Session::init();
        Session::set('isLoggedIn', true);
        Session::set('userId', $user->userid);
        Session::set('username', $user->username);
        Session::set('email', $user->email);

    }

}