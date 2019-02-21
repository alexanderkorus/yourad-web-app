<?php
/**
 * Created by PhpStorm.
 * User: AlKo
 * Date: 2019-02-20
 * Time: 22:54
 */

namespace App\Models;

use PDO;

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


    public static function findByPost(int $id) {

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

    public function add() {

        // TODO: pre processing images

        $rc = $this->db->insert('image', array(
            'path' => $this->path,
            'thumbnail' => $this->thumbnail,
            'post_id' => $this->post_id
        ));

        return $rc;

    }

}
