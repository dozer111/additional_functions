<?php

/**
 * List of custom functions for variable handling functions
 * @see https://www.php.net/manual/en/ref.strings.php
 *
 */


if (!function_exists('normalizeImplode')) {


    /**
     * Addition for https://www.php.net/manual/en/function.implode.php
     *
     * 1)Join elements in string
     * 2)remove multiple glue characters
     *
     * Need for situation, when
     * We have some value after implode[1], or concatenation[2]
     * and there is need to check, that imploded symbol is not duplicated
     * /test1/test2/test3/test4/test5 instead of /test1//test2/test3/test4//test5
     *
     *
     * @param string $glue
     * @param array $pieces
     * @return string
     * @example Same idea from yii2
     * @see https://www.yiiframework.com/doc/api/2.0/yii-web-urlnormalizer#$collapseSlashes-detail
     *
     *
     * @example
     * $rootPath = dirname(dirname(__DIR__));
     * $dirPath = SomeObj->getPath();
     * $file = $user->getImage();
     * [1] => $fullPath = implode('/',[$rootPath,$dirPath,$file]);
     * [2] => $fullPath = $rootPath.'/'.$dirPath.'/'.$file;
     *
     * #To prevent this we also do
     * $fullPath = preg_replace('/\s{2,}/',' ',$fullPath);
     *
     * #New solution =>
     * $fullPath = normalizeImplode('/',[$rootPath,$dirPath,$file]);
     *
     *
     *
     */
    function normalizeImplode(string $glue, array $pieces): string
    {

        $string = implode($glue, $pieces);


        $removeDuplicatesClosure = function (string $implodedString, string $duplicateSymbol) {
            $symbolToReplace = $duplicateSymbol;

            /**
             * @see https://www.regular-expressions.info/characters.html#special
             */
            $specialRegexSymbols = [
                '[',
                ']',
                '\\',
                '/',
                '^',
                '$',
                '.',
                '|',
                '?',
                '*',
                '+',
                '(',
                ')',
                '{',
                '}',
            ];

            if (in_array($duplicateSymbol, $specialRegexSymbols)) {
                $duplicateSymbol = "\\$duplicateSymbol";
            }
            return preg_replace("/{$duplicateSymbol}{2,}/", $symbolToReplace, $implodedString);

        };


        return $removeDuplicatesClosure($string, $glue);

    }


}

if (!function_exists('truncateNumber')) {

    /**
     * Same logic as
     * @see https://www.php.net/manual/en/function.number-format
     *
     * Difference is this function don`t round value
     * and give you string value of it
     * or null, if you paste real empty value
     *
     *
     *
     * @important
     * There can be troubles,when u try to paste float val with tooMany digits after comma
     * 123.828282828282828282828
     * It would be better to work with same values as with sting
     *
     *
     * @example
     * $number = 123.459278;
     * $data = truncateNumber($number,2); // 123.45
     * $data = truncateNumber($number,4); // 123.4592
     *
     * @example 2
     * $number = '123456.1234567890123456789012345678901';
     * $value = truncateNumber($number,9); // 123456.123456789
     *
     * @param $number
     * @param int $decimals
     * @return string|null
     */
    function truncateNumber($number, int $decimals = 0):?string
    {

        if(emptiest($number))
            return null;

        if (preg_match('/^-?\d+.*/', $number)) {

            preg_match('/^-?\d+[,.]?\d*/', $number, $matches);
            $numberChanged = str_replace(',', '.', $matches[0]);

        }else
        {
            throw new InvalidArgumentException('$number must be numeric!');
        }


        $decimals = abs($decimals);

        /**
         * @see https://www.php.net/manual/en/regexp.reference.repetition.php
         */
        $pregMatchLimit = 65535;
        $decimals = ($decimals > $pregMatchLimit) ? $pregMatchLimit : $decimals;
        /**
         * @see https://regex101.com/r/m42H7h/1
         */
        $findE = preg_match('/^-?\d+[,.]?\d*(?<e>e-?\d+)?/',$number,$matches);
        $e = $matches['e'] ?? '';

        $pattern = ($decimals > 0) ? "/^-?\d+(\.\d{1,$decimals})?/" : "/^-?\d+/";
        preg_match($pattern, $numberChanged, $matches);

        $numberWithE = $matches[0].$e;


        return $numberWithE;
    }

}




