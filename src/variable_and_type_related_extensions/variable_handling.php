<?php

/**
 * List of custom functions for variable handling functions
 * @see https://www.php.net/manual/en/book.var.php
 *
 */

if (!function_exists('emptiest')) {
    /**
     * Addition for https://www.php.net/manual/ru/function.empty.php
     *
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

if(!function_exists('normalized_floatval'))
{
    /**
     * Sometimes, we have boolean value in wrong format:
     * 123,123213 instead 123.123213
     *
     * Because of it we have a couple of problems
     * floatval(123,123213) => 123.0
     * yii\i18n\Formatter->normalizeNumericValue('1,5') => InvalidArgumentException
     *
     * This function copy logic from floatval(),and add ',' as delimiter
     */
    function normalized_floatval($value):float
    {
        $value = trim($value);

        if (preg_match('/^\d+.*/', $value)) {

            preg_match('/^\d+[,.]?\d*/',$value,$matches);
            $value = str_replace(',','.',$matches[0]);

        }


        return floatval($value);
    }
}













