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


    public function __construct($id = null, $first_name = null, $last_name = null, $username = null, $email = null,
                                $mobile_number = null, $plz = null, $street = null, $country = null, $city = null) {

        // Attribute initialisieren
        $this->id = $id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->username = $username;
        $this->email = $email;
        $this->mobile_number = $mobile_number;
        $this->plz = $plz;
        $this->street = $street;
        $this->country = $country;
        $this->city = $city;
        parent::__construct();

    }



    public static function login(string $credential, string $password): ?User {

        try {
            $db = static::getDB();
            var_dump($password);
            $stmt = $db->prepare('select id, username, email from user where email = :email and password = :password');

            $stmt->execute(array(
                ':email' => $credential,
                ':password' => $password
            ));

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
            $result = $stmt->fetchObject();

            if (!is_null($result)) {
                $user = new User($result->id, null, null, $result->username, $result->email);
                var_dump($user);
                return $user;
            } else {
                return null;
            }


        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }


    public function areCredentialsAvailable(): bool {

        $data = $this->db->select('select username from user where username = :username or email = :email',
            array(
                ':username' => $this->username,
                ':email' => $this->email
            )
        );

        return count($data) == 0;

    }

    public function add(string $password): bool {

        $rc = $this->db->insert('user', array(
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'email' => $this->email,
            'mobile_number' => $this->mobile_number,
            'password' => $password,
            'plz' => $this->plz,
            'street' => $this->street,
            'country' => $this->country,
            'city' => $this->city
        ));

        return $rc;
    }

}