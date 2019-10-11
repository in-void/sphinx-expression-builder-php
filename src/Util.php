<?php

namespace Sphinx;

class Util
{
    /**
     * Convert multi-dimensional array to one-dimensional.
     *
     * @param array $array
     * @return array
     */
    public static function arrayFlatten(array $array = [])
    {
        $arr = array();

        foreach($array as $key => $value) {
            if(is_array($value)) {
                $arr += self::arrayFlatten($value);
            } else {
                $arr[$key] = $value;
            }
        }

        return $arr;
    }
}