<?php
/**
 * Created by PhpStorm.
 * User: AlKo
 * Date: 2019-02-20
 * Time: 18:53
 */

namespace App\Controllers;


use Core\Session;
use \Core\View;

/**
 * Home controller
 * User: Alexander Korus
 * Date: 2019-02-17
 */

class Category extends \Core\Controller
{


    protected function before()
    {
        // placeholder for before handling
        Session::init();
    }

    public function indexAction()
    {

        // Save route param to categoryId
        if (isset($this->route_params['id'])) {

            $categoryId = $this->route_params['id'];

            // Get categories, choosen category and corresponding posts
            $categories = \App\Models\Category::findAll();
            $category = \App\Models\Category::find($categoryId);
            $posts = \App\Models\Post::findByCategory($categoryId);

            View::renderTemplate('Category/index.html', array(
                "categories" => $categories,
                "category" => $category,
                "posts" => $posts
            ));
        } else {
            $categories = \App\Models\Category::findAll();
            $posts = \App\Models\Post::findAll();
            $category = new \App\Models\Category();
            $category->name = "Alle";

            View::renderTemplate('Category/index.html', array(
                "categories" => $categories,
                "category" => $category,
                "posts" => $posts
            ));
        }
    }

    public function searchAction() {

        $categoryId = $this->route_params['id'];
        $searchText = $_POST['searchText'];

        // Get categories, choosen category and corresponding posts
        $categories = \App\Models\Category::findAll();
        $category = \App\Models\Category::find($categoryId);
        $posts = \App\Models\Post::findByTitleInCategory($searchText, $categoryId);

        View::renderTemplate('Category/index.html', array(
            "categories" => $categories,
            "category" => $category,
            "posts" => $posts
        ));

    }



}