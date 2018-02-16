<?php

define('PDO_HOST', 'localhost');
define('PDO_DATABASE', 'web239_main');
define('PDO_USERNAME', 'web239_main');
define('PDO_PASSWORD', 'weRQe6tb');

class PDOManipulator {
    static function create() {
        return new PDO("mysql:
            host=".PDO_HOST.";
            dbname=".PDO_DATABASE.";
            charset=utf8",
            PDO_USERNAME,
            PDO_PASSWORD);
    }
}