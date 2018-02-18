<?php

class DataManipulator {
    /**
     * @param  array $array The array we want to transform
     *
     * @return bool|string The array as a string
     */
    static public function transformArrayToString($array) {
        $result = '[';

        foreach ($array as $key => $item)
            if (is_int($item))
                $result .= "{$item},";
            else
                $result .= "\"{$item}\",";

        // Remove last ","
        if ($result !== '[')
            $result = substr($result, 0, strlen($result) - 1);

        $result .= "]";

        return $result;
    }
}