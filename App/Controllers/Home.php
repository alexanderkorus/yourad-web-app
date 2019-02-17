<?php

namespace App\Controllers;

use App\Models\Post;
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
        $posts = Post::findAll();

        //var_dump($posts);
        View::renderTemplate('Home/index.html', ['posts' => $posts]);
    }
}
