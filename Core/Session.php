<?php
/**
 * Created by PhpStorm.
 * User: AlKo
 * Date: 2019-02-18
 * Time: 01:17
 */

namespace Core;


class Session
{

    public static function  init()
    {
        @session_start();
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }

    public static function destroy()
    {
        session_destroy();
    }
}