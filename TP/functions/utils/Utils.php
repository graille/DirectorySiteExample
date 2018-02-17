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
}