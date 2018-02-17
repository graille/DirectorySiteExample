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
     * Return the category specified by id {$id}
     *
     * @param $id
     *
     * @return PDOStatement
     */
    static public function getOne($id) {
        $query = self::getBaseQuery();
        $query.= "WHERE e.id = {$id}";

        return PDOManipulator::create()
            ->query($query);
    }
}