<?php
class PDOManipulator {
    static function create() {
        try {
            $pdo = new PDO("mysql:
            host=" . PDO_HOST . ";
            dbname=" . PDO_DATABASE . ";
            charset=utf8",
                PDO_USERNAME,
                PDO_PASSWORD);

            $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);

            return $pdo;
        }
        catch (Exception $e) {
            echo "<h2>Aucune connexion à la base de données n'a pu être établie</h2>";
            return null;
        }
    }
}