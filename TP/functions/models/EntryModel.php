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
     * @throws Exception
     */
    static public function validateData(&$data) {
        if(!in_array($gender = $data['gender'], ['male', 'female']))
            throw new Exception("{$gender} gender undefined");

        if(!filter_var($email = $data['email'], FILTER_VALIDATE_EMAIL))
            throw new Exception("The email {$email} is invalid");

        if(!filter_var($url = $data['website'], FILTER_VALIDATE_URL))
            throw new Exception("The url {$url} is invalid");

        if(!filter_var($url = $data['twitter'], FILTER_VALIDATE_URL))
            throw new Exception("The url {$url} is invalid");

        if(!filter_var($url = $data['facebook'], FILTER_VALIDATE_URL))
            throw new Exception("The url {$url} is invalid");

        if(!filter_var($url = $data['linkedin'], FILTER_VALIDATE_URL))
            throw new Exception("The url {$url} is invalid");

        if(!file_exists($path = $data['image_path']))
            throw new Exception("The file with path {$path} does not exist");
    }

    /**
     * @param $data
     */
    static public function escapeData(&$data) {
        $data['first_name'] = htmlentities($data['first_name']);
        $data['last_name'] = htmlentities($data['last_name']);
        $data['birthdate'] = intval($data['birthdate']);
        $data['email'] = htmlentities($data['email']);
        $data['gender'] = htmlentities($data['gender']);

        $data['image_path'] = htmlentities($data['image_path']);

        $data["category_id"] = intval($data["category_id"]);

        $data['website'] = htmlentities($data['website']);
        $data['twitter'] = htmlentities($data['twitter']);
        $data['facebook'] = htmlentities($data['facebook']);
        $data['linkedin'] = htmlentities($data['linkedin']);
    }

    /**
     * @param $data
     * @throws Exception
     */
    static public function addEntry($data) {
        self::validateData($data);
        self::escapeData($data);

        $query = "INSERT INTO entries VALUES (
            '',
            {$data['first_name']}, 
            {$data['last_name']},
            {$data['birthdate']},
            {$data['email']},
            {$data['image_path']},
            {$data["category_id"]},
            {$data['gender']},
            {$data['website']},
            {$data['twitter']},
            {$data['facebook']},
            {$data['linkedin']},
        )";

        PDOManipulator::create()
            ->query($query)
            ->execute();
    }
}