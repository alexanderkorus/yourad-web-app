<?php
/**
 * Created by PhpStorm.
 * User: AlKo
 * Date: 2019-02-20
 * Time: 22:54
 */

namespace App\Models;

use PDO;
use Gmagick;

/**
 * Category model
 * User: Alexander Korus
 * Date: 2019-02-17
 */
class Image extends \Core\Model
{

    public $id;
    public $path;
    public $thumbnail;
    public $post_id;


    /**
     * @param int $id
     * @return array
     */
    public static function findByPost(int $id)
    {

        try {
            $db = static::getDB();


            $stmt = $db->prepare('select * from image 
                 where post_id = :post_id');
            $stmt->execute(array(
                ":post_id" => $id
            ));
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Image');
            $results = $stmt->fetchAll();

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    /**
     * @return bool
     * @throws \GmagickException
     */
    public function add()
    {

        $rc = $this->db->insert('image', array(
            'path' => $this->addWatermark($this->cropImageFromCenter($this->path, 'cropped', 350, 350)),
            'thumbnail' => $this->cropImageFromCenter($this->path, 'thumbnail', 50, 50),
            'post_id' => $this->post_id
        ));

        return $rc;

    }


    /**
     * @param string $source
     * @param $target
     * @param int $height
     * @param int $width
     * @return string
     * @throws \GmagickException
     */
    private function cropImageFromCenter(string $source, $target, int $height, int $width): string
    {


        $image = new Gmagick('uploads/' . $source);

        $image->cropthumbnailimage($width, $height);

        $image->write('uploads/' . $target . '_' . $source);

        return $target . '_' . $source;
    }


    /**
     * @param $source
     * @return mixed
     */
    private function addWatermark($source)
    {

        $stamp = imagecreatefrompng("images/yourad.png");
        $image = imagecreatefromjpeg('uploads/' . $source);

        $marge_right = 10;
        $marge_bottom = 10;
        $sx = imagesx($stamp);
        $sy = imagesy($stamp);

        imagecopy($image, $stamp, imagesx($image) - $sx - $marge_right,
            imagesy($image) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
        ob_start();
            imagepng($image, 'uploads/' . $source);
        ob_end_clean();

        // be tidy; free up memory
        imagedestroy($image);

        return $source;

    }

}
