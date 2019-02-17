<?php

namespace App\Models;

use PDO;

/**
 * Post model
 * User: Alexander Korus
 * Date: 2019-02-17
 */
class Post extends \Core\Model
{

    public $id;
    public $user_id;
    public $category_id;
    public $title;
    public $description;
    public $is_seller;
    public $created;
    public $updated;
    public $pricing_base;
    public $price;
    public $category;
    public $user;


    public static function findAll()
    {

        try {
            $db = static::getDB();

            $stmt = $db->prepare('select * from post 
              inner join user on post.user_id = user.id
              inner join category on POST.category_id = category.id');
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Post');
            $results = $stmt->fetchAll();


            return $results;
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}
