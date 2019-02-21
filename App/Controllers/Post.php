<?php
/**
 * Created by PhpStorm.
 * User: AlKo
 * Date: 2019-02-20
 * Time: 18:15
 */

namespace App\Controllers;

use Core\Session;
use \Core\View;
use App\Models\Category;
use App;

class Post extends \Core\Controller
{

    protected function before() {
        // placeholder for before handling
        Session::init();

    }


    protected function after() {
        // placeholder for after handling
    }

    /*
     * GET Actions
     */

    // Show new Category page
    public function newPostAction() {

        if (isset($_SESSION['isLoggedIn'])) {
            if ($_SESSION['isLoggedIn'] == true) {
                // Show new Category Page
                $categories = Category::findAll();

                View::renderTemplate('Post/add.html', array(
                    "categories" => $categories
                ));
            } else {
                // Show Login Page
                View::renderTemplate('Authentication/signin.html');
            }
        } else {
            // Show Login Page
            View::renderTemplate('Authentication/signin.html');
        }

    }

    /*
     * POST Actions
     */

    // Create new Category
    public function addPostAciton() {

    }

    public function searchAction() {

        $searchText = $_POST['searchText'];

        // Get categories, choosen category and corresponding posts
        $categories = \App\Models\Category::findAll();
        $posts = \App\Models\Post::findByTitle($searchText);
        $category = new App\Models\Category();
        $category->name = "Alle";

        View::renderTemplate('Category/index.html', array(
            "categories" => $categories,
            "category" => $category,
            "posts" => $posts
        ));

    }


}