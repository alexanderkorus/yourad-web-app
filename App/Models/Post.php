<?php

namespace App\Models;

use PDO;

/**
 * Category model
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
    public $images;


    public static function findAll(): ?array {

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

    public static function findByCategory(int $id) {

        try {
            $db = static::getDB();

            $stmt = $db->prepare('select * from post where category_id = :id');
            $stmt->execute(array(
                ":id" => $id
            ));
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Post');
            $results = $stmt->fetchAll();

            foreach ($results as $key => $field) {
                $results[$key]["images"] = Image::findByPost($field["id"]);
            }

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public static function findByTitleInCategory(string $searchText, int $categoryId) {

        try {
            $db = static::getDB();

            $stmt = $db->prepare('select * from post where category_id = :id and title like :text');
            $stmt->execute(array(
                ":id" => $categoryId,
                ":text" => "%". $searchText . "%"
            ));
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Post');
            $results = $stmt->fetchAll();

            foreach ($results as $key => $field) {
                $results[$key]["images"] = Image::findByPost($field["id"]);
            }

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public static function findByTitle(string $searchText) {

        try {
            $db = static::getDB();

            $stmt = $db->prepare('select * from post where title like :text');
            $stmt->execute(array(
                ":text" => "%" . $searchText . "%"
            ));
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Post');
            $results = $stmt->fetchAll();

            foreach ($results as $key => $field) {
                $results[$key]["images"] = Image::findByPost($field["id"]);
            }

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }
}
