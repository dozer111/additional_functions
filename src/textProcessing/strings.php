<?php

/**
 * List of custom functions for variable handling functions
 * @see https://www.php.net/manual/en/ref.strings.php
 *
 */


if (!function_exists('implode_and_normalize')) {


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
     * $fullPath = implode_and_normalize('/',[$rootPath,$dirPath,$file]);
     *
     *
     *
     * @param string $glue
     * @param array $pieces
     * @return string
     */
    function implode_and_normalize(string $glue,array $pieces): string
     {

         $string = implode($glue,$pieces);


         $removeDuplicatesClosure = function (string $implodedString,string $duplicateSymbol)
         {
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

             if(in_array($duplicateSymbol,$specialRegexSymbols))
             {
                 $duplicateSymbol = "\\$duplicateSymbol";
             }
             return preg_replace("/{$duplicateSymbol}{2,}/",$symbolToReplace,$implodedString);

         };


         return $removeDuplicatesClosure($string,$glue);

     }


}
