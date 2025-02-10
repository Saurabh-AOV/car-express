<?php

if (!function_exists('capitalize_first')) {
    /**
     * Capitalize the first letter of a string and make the rest lowercase.
     *
     * @param string $string
     * @return string
     */
    function capitalize_first($string)
    {
        return ucfirst(strtolower($string));
    }
}
