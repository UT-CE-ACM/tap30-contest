<?php

namespace App\Utils\Submissions;

/**
 * Created by PhpStorm.
 * User: mamareza
 * Date: 2/3/17
 * Time: 7:15 PM
 */
class RunSubmissionsUtil
{
    /**
     * Replaces {{ var }} substrings in a given string.
     *
     * @param string $str
     * @param array $items
     * @return string
     */
    public static function contextify(string $str, array $items) {
        $keys = array_keys($items);
        for ($i = 0; $i < count($keys); $i++)
            $keys[$i] = '{{ ' . $keys[$i] . ' }}';
        return str_replace($keys, array_values($items), $str);
    }
}