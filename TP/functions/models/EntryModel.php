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
     * @return PDOStatement
     * @throws Exception
     */
    static public function getOne($id) {
        if(!is_int($id))
            throw new Exception("Un id doit être un entier");

        $query = self::getBaseQuery();
        $query .= " WHERE e.id = {$id};";

        return PDOManipulator::create()
            ->query($query);
    }

    /**
     * @param array $data
     *
     * @return array
     * @throws Exception
     */
    static public function validateData($data) {
        if (!in_array($gender = $data['gender'], ['male', 'female']))
            throw new Exception("{$gender} gender undefined");

        if (!filter_var($email = $data['email'], FILTER_VALIDATE_EMAIL))
            throw new Exception("L'email {$email} est invalide");

        if (!filter_var($url = $data['website'], FILTER_VALIDATE_URL))
            throw new Exception("L'url {$url} est invalide");

        if (!filter_var($url = $data['twitter'], FILTER_VALIDATE_URL))
            throw new Exception("L'url {$url} est invalide");

        if (!filter_var($url = $data['facebook'], FILTER_VALIDATE_URL))
            throw new Exception("L'url {$url} est invalide");

        if (!filter_var($url = $data['linkedin'], FILTER_VALIDATE_URL))
            throw new Exception("L'url {$url} est invalide");

        if (!file_exists($path = $data['image_path']))
            throw new Exception("Le fichier avec le chemin {$path} n'existe pas");

        if(CategoryModel::getOne(intval($data['category_id']))->rowCount() === 0)
            throw new Exception("Aucune catégorie ne porte l'id {$data['category_id']}");

        return $data;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    static public function escapeData($data) {
        $result = [];
        $result['firstname'] = htmlspecialchars($data['firstname']);
        $result['lastname'] = htmlspecialchars($data['lastname']);
        $result['birthday'] = intval($data['birthday']);
        $result['email'] = htmlspecialchars($data['email']);
        $result['gender'] = htmlspecialchars($data['gender']);

        $result['image_path'] = htmlspecialchars($data['image_path']);

        $result["category_id"] = intval($data["category_id"]);

        $result['website'] = htmlspecialchars($data['website']);
        $result['twitter'] = htmlspecialchars($data['twitter']);
        $result['facebook'] = htmlspecialchars($data['facebook']);
        $result['linkedin'] = htmlspecialchars($data['linkedin']);

        return $result;
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
        $data = self::validateData($data);
        $data = self::escapeData($data);

        $query = "INSERT INTO entries 
          (id, firstname, lastname, birthdate, email, image_path, category_id, gender, website, twitter, facebook, linkedin) 
          VALUES (
            '',
            :firstname, 
            :lastname,
            :birthday,
            :email,
            
            :image_path,
            :category_id,
            :gender,
            
            :website,
            :twitter,
            :facebook,
            :linkedin
        );";

        PDOManipulator::create()
            ->prepare($query)
            ->execute($data);
    }

    /**
     * @param $id
     * @param $data
     *
     * @throws Exception
     */
    static public function updateEntry($id, $data) {
        self::validateData($data);
        self::escapeData($data);

        $query = "UPDATE entries
                SET 
                    firstname = :firstname,
                    lastname = :lastname,
                    birthday = :birthday,
                    email = :email,
                    gender = :gender,
                    
                    image_path = :image_path,
                    category_id = :category_id,
                    
                    website = :website,
                    linkedin = :linkedin,
                    facebook = :facebook,
                    twitter = :twitter
                WHERE id = :id;";

        $pdo = PDOManipulator::create()
            ->prepare($query);

        $pdo->bindParam('id', $id);

        $pdo->execute($data);
    }
}