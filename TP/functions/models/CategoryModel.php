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
     * @return PDOStatement
     */
    static public function get() {
        $query = self::getBaseQuery();
        return PDOManipulator::create()
            ->query($query);
    }

    /**
     * @param $id
     * @return bool
     */
    static public function getOne($id) {
        $query = self::getBaseQuery();
        $query.= "WHERE e.id :id";

        return PDOManipulator::create()
            ->query($query)
            ->bindParam('id', $id);
    }
}