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
use Core\Session;
use \Core\View;


class Authentication extends \Core\Controller
{

    protected function before()
    {
        // placeholder for before handling
        Session::init();
    }


    protected function after()
    {
        // placeholder for after handling
    }

    public function signInAction()
    {
        View::renderTemplate('Authentication/signin.html');
    }

    public function signUpAction()
    {
        View::renderTemplate('Authentication/signup.html');
    }

    public function loginAction()
    {

        $user = User::login($_POST['credential'], Hash::create('sha256', $_POST['password'], Config::HASH_KEY));

        if (!is_null($user)) {
            Auth::startSession($user);
            header('location: ' . Config::URL);
        } else {
            echo 'Login failed';
        }

    }

    public function registerAction()
    {

        $user = new User(null, $_POST['firstname'], $_POST['name'], $_POST['username'], $_POST['email'],
            $_POST['mobile_number'], $_POST['plz'], $_POST['street'], $_POST['country'], $_POST['city']);

        if ($user->areCredentialsAvailable()) {

            if ($user->add(Hash::create('sha256', $_POST['password'], Config::HASH_KEY))) {

                $message = 'Registrierung erfolgreich! Logge dich jetzt ein!';

            } else {
                $message = 'Registrierung fehlgeschlagen! Unbekannter Fehler!';
            }

        } else {
            $message = 'Registrierung fehlgeschlagen! Der Benutzername existiert schon!';
        }
        echo $message;
        View::renderTemplate('Authentication/signup.html', array('message' => $message));

    }


    public function logoutAction()
    {
        Session::destroy();
        header('location: ' . Config::URL);
    }
}