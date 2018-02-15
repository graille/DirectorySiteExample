<?php

class DataManipulator {
    /**
     * @param      $array
     *
     * @return bool|string
     */
    static public function transformArrayToString($array) {
        $result = '[';

        foreach ($array as $key => $item)
            if(is_int($item))
                $result .= "{$item},";
            else
                $result .= "\"{$item}\",";

        // Remove last ","
        $result = substr($result, 0, strlen($result) - 1);

        $result .= "]";

        return $result;
    }
}