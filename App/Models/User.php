<?php
/**
 * Created by PhpStorm.
 * User: AlKo
 * Date: 2019-02-18
 * Time: 00:44
 */

namespace App\Models;

use PDO;


class User extends \Core\Model
{


    public $id;
    public $first_name;
    public $last_name;
    public $username;
    public $email;
    public $mobile_number;
    public $plz;
    public $street;
    public $country;
    public $city;




    public static function login($username, $password) {

        try {
            $db = static::getDB();

            $stmt = $db->prepare('select id, username, email from user where username = :username and password = :password');

            $stmt->execute(array(
                ':username' => $username,
                ':password' => $password
            ));

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
            $result = $stmt->fetchObject();


            return $result;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }


    }

}