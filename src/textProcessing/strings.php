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
     * 2)remove multiple same characters
     *
     * Need for situation, when
     * We have some value after implode
     * BUT, we also don`t know, does this value contains duplicate symbols:
     * test1/test2/test3 instead test1//test2/test3
     *
     * So, sometimes we do something like this
     * @example
     * $x = implode([$a,$b,$c,$d]);
     * OR $x = $a.$b.$c.$d;
     *
     * $x = preg_replace('/\s{2,}/',' ',$x);
     *
     * This function created exactly for this case
     *
     *
     * @param string $glue
     * @param array $pieces
     * @param mixed $removeDuplicates
     * @return string
     * @throws Exception
     */
    function implode_and_normalize(string $glue,array $pieces,$removeDuplicates): string
     {

         $string = implode($glue,$pieces);


         $removeDuplicatesType = gettype($removeDuplicates);

         $removeDuplicatesClosure = function (string $string,string $symbol)
         {
             $symbolToReplace = $symbol;

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

             if(in_array($symbol,$specialRegexSymbols))
             {
                 $symbol = "\\$symbol";
             }
             return preg_replace("/{$symbol}{2,}/",$symbolToReplace,$string);

         };


         switch ($removeDuplicatesType)
         {
             case 'string':
             case 'integer':
                return $removeDuplicatesClosure($string,$removeDuplicates);
             case 'array':
                 foreach ($removeDuplicates as $duplicateSymbol)
                 {
                     $string = $removeDuplicatesClosure($string,$duplicateSymbol);
                 }
                 return $string;
                 break;
             default:
                 throw new Exception("\$removeDuplicates cannot be type {$removeDuplicatesType}");

         }

     }


}
