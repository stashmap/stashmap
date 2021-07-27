<?php

namespace Components;

class Validator
{

    public static function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function isValidName($name)
    {
        $v = "/^[a-z][a-z '-.,]{1,32}$/i";
        return preg_match($v, $name) ? true : false;
    }

    public static function isValidTask($task)
    {
        return strlen($task) > 3 ? true : false;
    }

}

?>

Validator