<?php

class Utils {
    /**
     * Calculate the age
     *
     * @param int $timestamp the birthday timestamp
     *
     * @return int The age (in year)
     */
    static public function calculateAgeFromTimestamp($timestamp) {
        $today = new DateTime('now');
        $bithdate = (new DateTime('now'))->setTimestamp($timestamp);

        $diff = $today->diff($bithdate);

        return $diff->y;
    }

    /**
     * Check if an id is valid
     *
     * @param $id
     *
     * @throws Exception
     */
    static public function checkId($id) {
        if (!is_int($id))
            throw new Exception("Un id doit être un entier, " . gettype($id) . " ({$id}) given");
    }
}