<?php

class EntryModel {
    /**
     * @return string
     */
    static private function getBaseQuery() {
        return "SELECT e.*, c.name AS category_name 
            FROM entries AS e
            JOIN categories AS c 
              ON c.id = e.category_id";
    }

    /**
     * @return PDOStatement
     */
    static public function getEntries() {
        $query = self::getBaseQuery();
        return PDOManipulator::create()
            ->query($query);
    }

    /**
     * @param $id
     * @return bool
     */
    static public function getEntry($id) {
        $query = self::getBaseQuery();
        $query.= "WHERE e.id :id";

        return PDOManipulator::create()
            ->query($query)
            ->bindParam('id', $id);
    }

    /**
     * @param $data
     * @return array
     * @throws Exception
     */
    static private function processData($data) {
        $result = [];

        $result['first_name'] = htmlentities($data['first_name']);
        $result['last_name'] = htmlentities($data['last_name']);
        $result['birthdate'] = intval($data['birthdate']);
        $result['email'] = htmlentities($data['email']);
        $result['image_path'] = htmlentities($data['image_path']);
        $result["category_id"] = intval($data["category_id"]);
        $result['gender'] = htmlentities($data['gender']);
        $result['personal_page'] = htmlentities($data['personal_page']);

        if(!in_array($result['gender'], ['male', 'female']))
            throw new Exception("{$gender} gender undefined");

        return $result;
    }

    /**
     * @param $data
     * @throws Exception
     */
    static public function addEntry($data) {
        $result = self::processData($data);

        $query = "INSERT INTO entries VALUES (
            '',
            {$result['first_name']}, 
            {$result['last_name']},
            {$result['birthdate']},
            {$result['email']},
            {$result['image_path']},
            {$result["category_id"]},
            {$result['gender']},
            {$result['personal_page']}
        )";

        PDOManipulator::create()
            ->query($query)
            ->exec();
    }
}