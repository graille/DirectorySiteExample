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
    static public function get() {
        $query = self::getBaseQuery();
        return PDOManipulator::create()
            ->query($query);
    }

    /**
     * @param $id
     *
     * @return bool
     */
    static public function getOne($id) {
        $query = self::getBaseQuery();
        $query .= "WHERE e.id :id";

        return PDOManipulator::create()
            ->query($query)
            ->bindParam('id', $id);
    }

    /**
     * @param array $data
     *
     * @throws Exception
     */
    static public function validateData(&$data) {
        if (!in_array($gender = $data['gender'], ['male', 'female']))
            throw new Exception("{$gender} gender undefined");

        if (!filter_var($email = $data['email'], FILTER_VALIDATE_EMAIL))
            throw new Exception("The email {$email} is invalid");

        if (!filter_var($url = $data['website'], FILTER_VALIDATE_URL))
            throw new Exception("The url {$url} is invalid");

        if (!filter_var($url = $data['twitter'], FILTER_VALIDATE_URL))
            throw new Exception("The url {$url} is invalid");

        if (!filter_var($url = $data['facebook'], FILTER_VALIDATE_URL))
            throw new Exception("The url {$url} is invalid");

        if (!filter_var($url = $data['linkedin'], FILTER_VALIDATE_URL))
            throw new Exception("The url {$url} is invalid");

        if (!file_exists($path = $data['image_path']))
            throw new Exception("The file with path {$path} does not exist");
    }

    /**
     * @param array $data
     */
    static public function escapeData(&$data) {
        $data['first_name'] = htmlspecialchars($data['first_name']);
        $data['last_name'] = htmlspecialchars($data['last_name']);
        $data['birthdate'] = intval($data['birthdate']);
        $data['email'] = htmlspecialchars($data['email']);
        $data['gender'] = htmlspecialchars($data['gender']);

        $data['image_path'] = htmlspecialchars($data['image_path']);

        $data["category_id"] = intval($data["category_id"]);

        $data['website'] = htmlspecialchars($data['website']);
        $data['twitter'] = htmlspecialchars($data['twitter']);
        $data['facebook'] = htmlspecialchars($data['facebook']);
        $data['linkedin'] = htmlspecialchars($data['linkedin']);
    }

    /**
     * Replace PDOStatement parameters with goods parameters
     * @param array        $data
     * @param PDOStatement $pdo
     */
    static private function pdoBind($data, &$pdo) {
        foreach ($data as $key => $datum)
            $pdo->bindParam($key, $datum);
    }

    /**
     * @param array $data
     *
     * @throws Exception
     */
    static public function addEntry($data) {
        self::validateData($data);
        self::escapeData($data);

        $query = "INSERT INTO entries VALUES (
            '',
            :first_name, 
            :last_name,
            :birthday,
            :email,
            
            :image_path,
            :category_id,
            :gender,
            
            :website,
            :twitter,
            :facebook,
            :linkedin,
        )";

        $pdo = PDOManipulator::create()
            ->query($query);

        self::pdoBind($data, $pdo);
        $pdo->execute();
    }

    static public function updateEntry($id, $data) {
        self::validateData($data);
        self::escapeData($data);

        $query = "UPDATE entries
                SET 
                    first_name = :first_name,
                    last_name = :lastname,
                    birthday = :birthday,
                    email = :email,
                    gender = :gender,
                    
                    image_path = :image_path,
                    category_id = :category_id,
                    
                    website = :website,
                    linkedin = :linkedin,
                    facebook = :facebook,
                    twitter = :twitter
                WHERE id = :id";

        $pdo = PDOManipulator::create()
            ->query($query);

        $pdo->bindParam('id', $id);

        self::pdoBind($data, $pdo);
        $pdo->execute();
    }
}