<?php

/**
 * List of custom functions for variables
 * This is the addition for https://www.php.net/manual/ru/function.empty.php
 */

if (!function_exists('emptiest')) {
    /**
     * Show is the value is really empty
     * Btw we assume, that $value is exists
     *
     * We says, that value is really empty, when
     * 1) null
     * 2) empty array
     * 3) empty string
     *
     * @param $value
     * @return bool
     */
    function emptiest($value): bool
    {
        $type = gettype($value);

        switch ($type) {
            case 'boolean':
            case 'integer':
            case 'double':
            case 'float':
            case 'object':
            case 'resource':
                return false;
            case 'string':
                return !boolval(mb_strlen($value)); // 0 => true, 1+ => false
            case 'array':
                return empty($value);
            default:
                return true;
        }
    }
}













