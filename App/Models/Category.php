<?php
/**
 * User: Alexander Korus
 * Date: 2019-02-17
 */

namespace App\Models;

use PDO;


class Category extends \Core\Model
{

    public $id;
    public $name;
    public $parent_category_id;
    public $icon;
    public $border;


    public static function findAll()
    {

        try {
            $db = static::getDB();

            $stmt = $db->prepare('select * from category');
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Category');
            $results = $stmt->fetchAll();

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


}