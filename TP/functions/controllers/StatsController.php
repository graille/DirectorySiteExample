<?php

class StatsController {
    /**
     * @return PDOStatement The visits on the directory
     */
    static public function getVisit() {
        return PDOManipulator::create()->query("SELECT * FROM visits;");
    }

    /**
     * Add a visit
     *
     * @param string $page            The page of the visit
     * @param float  $pageDisplayTime The time needed to display the page
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
        $genderRepartition = PDOManipulator::create()->query(
            "SELECT gender, COUNT(id) AS nb 
                FROM entries
                GROUP BY gender"
        )->fetchAll();

        if (!empty($genderRepartition)) {
            if ($genderRepartition[0]['gender'] === 'male')
                $repartition = [
                    intval($genderRepartition[0]['nb']),
                    (count($genderRepartition) > 1) ? intval($genderRepartition[1]['nb']) : 0
                ];
            else
                $repartition = [
                    (count($genderRepartition) > 1) ? intval($genderRepartition[1]['nb']) : 0,
                    intval($genderRepartition[0]['nb'])
                ];

            return [["Hommes", "Femmes"], $repartition];
        } else
            return [[], []];

    }

    /**
     * @return array An array which contains, for each categories, the number of persons in it
     * @throws Exception
     */
    static public function getCategoriesRepartition() {
        $categories = CategoryController::get()->fetchAll();

        $catName = [];
        $catNb = [];

        foreach ($categories as $category) {
            $catName[] = $category['name'];
            $catNb[] = EntryController::getByCategory(intval($category['id']))->rowCount();
        }

        return [$catName, $catNb];
    }

    static public function getPageDisplayTimeStats() {
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

    static public function getPageVisitsStats() {
        $results = PDOManipulator::create()->query(
            "SELECT page, COUNT(id) AS nb FROM visits GROUP BY page"
        )->fetchAll();

        $pages = [];
        $nb = [];

        foreach ($results as $result) {
            $pages[] = $result["page"];
            $nb[] = $result["nb"];
        }

        return [$pages, $nb];
    }

    /**
     * @return int The number of people in directory
     */
    static public function getNumber() {
        // TODO
        return 500;
    }
}