<?php

namespace Components;

/** Storage of values that store at client side in cookies and(!) at session.
*
*
*/
class Storage {

    public static function get($key, $defaultValue = null) {
        if (isset($_SESSION[$key])) return $_SESSION[$key];

        if (isset($_COOKIE[$key])) {
            $_SESSION[$key] = $_COOKIE[$key];
            return $_SESSION[$key];
        }

        return $defaultValue;
    }

    public static function set($key, $value) {
        $_COOKIE[$key] = $_SESSION[$key] = $value;
        setcookie($key, $value, time() + 1000 * 60 * 60 * 24 * 365, '/');
    }

}