<?php

class CategoryController {
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
        Utils::checkId($id);

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

    /**
     * Delete a category
     * @param $id
     *
     * @throws Exception
     */
    static public function delete($id) {
        Utils::checkId($id);

        PDOManipulator::create()->prepare("DELETE FROM categories WHERE id = :id")->execute(['id' => $id]);
    }
}