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
        // TODO
    }

    /**
     * @return array An array which contains, for each gender, the number of persons of it
     */
    static public function getGenderRepartition() {
        // TODO
        return [
            'male' => 200,
            'female' => 452,
        ];
    }

    /**
     * @return array An array which contains, for each categories, the number of persons in it
     */
    static public function getCategoriesRepartition() {
        // TODO
        return [
            'teacher' => 500
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