<?php
/**
 * Created by PhpStorm.
 * User: AlKo
 * Date: 2019-02-20
 * Time: 18:15
 */

namespace App\Controllers;

use Core\Auth;
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


    // Show page of a single post
    public function indexAction() {

        $postId = $this->route_params['id'];
        $post = App\Models\Post::findById($postId);
        if (!is_null($post)) {
            View::renderTemplate('Post/index.html', array(
                "post" => $post
            ));
        } else {
            throw new \Exception('Der Post existiert nicht!', 500);
        }

    }


    /*
     * POST Actions
     */

    // Create new Category
    public function addPostAction() {

        // First add Post
        Auth::handleAuth();

        $post = new App\Models\Post(null, $_SESSION['userId'], $_POST['category'], $_POST['title'],
            $_POST['description'], true, null, null, $_POST['pricingbase'], $_POST['price'],
            null, null, null);

        if ($post->add()) {

            $statusMessage = $this->uploadImages($post->id);

        } else {
            $statusMessage = "Es ist ein Fehler beim Hinzufügen deines Posts aufgetreten. Versuche es nocheinmal";
        }




        // Display status message
        $categories = Category::findAll();

        View::renderTemplate('Post/add.html', array(
            "message" => $statusMessage,
            "categories" => $categories
        ));


    }

    // Upload Images
    private function uploadImages($postId) {

        $targetDir = "uploads/";
        $allowTypes = array('jpg','png','jpeg','gif');

        $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';

        if(!empty(array_filter($_FILES['fileselect']['name']))) {

            foreach($_FILES['fileselect']['name'] as $key=>$val) {

                // File upload path
                $fileName = basename($_FILES['fileselect']['name'][$key]);
                $targetFilePath = $targetDir . $fileName;

                // Check whether file type is valid
                $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

                if (in_array($fileType, $allowTypes)) {

                    // Upload file to server
                    if(move_uploaded_file($_FILES["fileselect"]["tmp_name"][$key], $targetFilePath)) {
                        // Image db insert sql
                        $insertValuesSQL .= "('".$fileName."', NOW()),";

                        $image = new App\Models\Image();
                        $image->path = $fileName;
                        $image->post_id = $postId;
                        if ($image->add()) {
                            $statusMsg = "Deine Anzeige wurde erfolgreich aufgegeben!";
                        } else {
                            $statusMsg = "Es ist ein Fehler beim Hochladen deiner Bilder aufgetreten.";
                        }

                    } else {
                        $errorUpload .= $_FILES['fileselect']['name'][$key].', ';
                    }

                } else {
                    $errorUploadType .= $_FILES['fileselect']['name'][$key].', ';
                }
            }

        } else {
            $statusMsg = 'Bitte wähle ein Bild für den Upload aus!';
        }

        return $statusMsg;

    }

    // Search for a post
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