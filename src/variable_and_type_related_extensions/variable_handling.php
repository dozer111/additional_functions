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
     * @covers EmptiestTest
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

if(!function_exists('normalizeFloatval'))
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
     *
     * @covers NormalizedFloatvalTest
     * @param $value
     * @return float
     */
    function normalizeFloatval($value):float
    {
        $value = truncateNumber($value,1e9);
        return floatval($value);
    }
}




if(!function_exists('toArray'))
{

    /**
     * Give the $value,
     * and if it`s not an array
     *      => wrap to array
     *
     * Difference of this function, and (array)$smth,
     * is that i just wrap, and do nothing specific with value
     * @see https://gist.github.com/dozer111/916283f6ff7f93b63532bd91cc026002
     *
     *
     * @example
     * $from = $data->from; // string|array
     * $from2 = toArray($data->from); // 100% array
     *
     * @covers ToArrayTest
     * @param $value
     * @return array
     */
    function toArray($value):array
    {
        return (is_array($value))
            ? $value
            : [$value];
    }

}








