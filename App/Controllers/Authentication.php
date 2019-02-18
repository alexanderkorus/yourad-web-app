<?php
/**
 * Created by PhpStorm.
 * User: AlKo
 * Date: 2019-02-18
 * Time: 01:25
 */

namespace App\Controllers;

use App\Config;
use App\Models\User;
use Core\Auth;
use Core\Hash;
use \Core\View;


class Authentication extends \Core\Controller
{

    protected function before()
    {
        // placeholder for before handling
    }


    protected function after()
    {
        // placeholder for after handling
    }

    public function signInAction()
    {

        View::renderTemplate('Authentication/signin.html');
    }

    public function loginAction()
    {
        var_dump($_POST);

        $user = User::login($_POST['credential'], Hash::create('sha256', $_POST['password'], 'isdj2309jisdjgsdg9bn30ßjfg'));

        var_dump($user);

        if ($user != null) {
            Auth::startSession($loginResult);
            header('location: ' . Config::URL);
        } else {
            echo 'Login failed';
        }

    }
}