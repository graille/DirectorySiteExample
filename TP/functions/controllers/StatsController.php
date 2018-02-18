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
    static public function addVisit($page, $pageDisplayTime) {
        PDOManipulator::create()->prepare("
              INSERT INTO visits 
              (id, ip, page, page_display_time)
              VALUES (
                '',
                :ip,
                :page,
                :page_display_time
              )
        ")
        ->execute([
            'ip' => $_SERVER['REMOTE_ADDR'],
            'page' => $page,
            'page_display_time' => $pageDisplayTime
        ]);
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
        $results = PDOManipulator::create()->query(
            "SELECT page, AVG(page_display_time) * 1000 AS avg_display_time FROM visits GROUP BY page"
        )->fetchAll();

        $pages = [];
        $times = [];

        foreach ($results as $result) {
            $pages[] = $result["page"];
            $times[] = $result["avg_display_time"];
        }

        return [$pages, $times];
    }

    /**
     * @return int The number of people in directory
     */
    static public function getNumber() {
        // TODO
        return 500;
    }
}