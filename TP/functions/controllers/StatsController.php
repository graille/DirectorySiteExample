<?php

class StatsController {
    /**
     * @return int The number of visit on the directory
     */
    static public function getVisit() {
        // TODO
        return 500;
    }

    /**
     * Add a visit
     */
    static public function addVisit() {
        PDOManipulator::create()->query("
              INSERT INTO visit 
              VALUES ('', {time()}, '{$_SERVER['REMOTE_ADDR']}')
        ");
    }

    /**
     * @return array An array which contains, for each gender, the number of persons of it
     */
    static public function getGenderRepartition() {
        // TODO
        return [[
            "Hommes",
            "Femmes"
        ], [
            500,
            200
        ]];
    }

    /**
     * @return array An array which contains, for each categories, the number of persons in it
     */
    static public function getCategoriesRepartition() {
        // TODO
        return [[
            "Enseignant",
            "Etudiant"
        ], [
            500,
            200
        ]];
    }

    static public function getPageStats() {
        // TODO
        return [
            [
                'user.homepage',
                'user.directory...'
            ],
            [
                1.151454,
                1.1471
            ]
        ];
    }

    /**
     * @return int The number of people in directory
     */
    static public function getNumber() {
        // TODO
        return 500;
    }
}