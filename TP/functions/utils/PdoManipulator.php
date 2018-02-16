<?php
class PDOManipulator {
    static function create() {
        try {
            return new PDO("mysql:
            host=" . PDO_HOST . ";
            dbname=" . PDO_DATABASE . ";
            charset=utf8",
                PDO_USERNAME,
                PDO_PASSWORD);
        }
        catch (Exception $e) {
            echo "<h2>Aucune connexion à la base de données n'a pu être établie</h2>";
            return null;
        }
    }
}