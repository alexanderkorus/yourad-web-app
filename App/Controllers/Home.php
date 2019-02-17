<?php

namespace App\Controllers;

use \Core\View;

/**
 * Home controller
 * User: Alexander Korus
 * Date: 2019-02-17
 */

class Home extends \Core\Controller
{


    protected function before()
    {
       // placeholder for before handling
    }


    protected function after()
    {
        // placeholder for after handling
    }

    public function indexAction()
    {

        View::renderTemplate('Home/index.html');
    }
}
