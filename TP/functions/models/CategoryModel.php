<?php

class CategoryModel {
    /**
     * @return string
     */
    static private function getBaseQuery() {
        return "SELECT * 
            FROM categories";
    }

    /**
     * Return all categories
     * @return PDOStatement
     */
    static public function get() {
        $query = self::getBaseQuery();
        return PDOManipulator::create()
            ->query($query);
    }

    /**
     * Find a category with its name
     * @param $name
     *
     * @return PDOStatement
     */
    static public function getOneByName($name) {
        $name = htmlspecialchars($name);
        $name = mb_strtolower($name);

        $query = self::getBaseQuery();
        $query.= " WHERE LOWER(name) = '{$name}'";

        return PDOManipulator::create()
            ->query($query);
    }

    /**
     * Return the category specified by id {$id}
     *
     * @param $id
     *
     * @return PDOStatement
     * @throws Exception
     */
    static public function getOne($id) {
        if(!is_int($id))
            throw new Exception("Un id doit être un entier");

        $query = self::getBaseQuery();
        $query.= " WHERE id = {$id}";

        return PDOManipulator::create()
            ->query($query);
    }

    static public function add($name) {
        $name = htmlspecialchars($name);

        $query = "INSERT INTO categories VALUES ('', :name)";
        $pdo = PDOManipulator::create()
            ->prepare($query);

        $pdo->bindParam('name', $name);
        $pdo->execute();
    }
}