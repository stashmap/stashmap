<?php

namespace Components;

class Config {

    public static $config = null;

    public static function get($key) {
        if (!static::$config) self::$config = include(ROOT . '/config.php');
        return self::$config[$key];
    }

}
