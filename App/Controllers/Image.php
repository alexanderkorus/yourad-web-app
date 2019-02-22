<?php
/**
 * Created by PhpStorm.
 * User: AlKo
 * Date: 2019-02-22
 * Time: 18:11
 */


namespace App\Controllers;

use Core\Session;
use \Core\View;
use App;
use Gmagick;

class Image extends \Core\Controller
{

    protected function before() {
        // placeholder for before handling
        Session::init();

    }

    /*
     * GET Actions
     */

    // Show new Category page
    public function thumbnailAction() {

        $image = App\Models\Image::getThumbnail('testimage.jpg');
        //$image = new Imagick('images/testimage.jpg');
        //$image->cropThumbnailImage(200, 200);
        var_dump($image);

        View::renderTemplate('Image/preview.html', array(
            "image" => $image
        ));

    }




}