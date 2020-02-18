<?php

use Codeception\Specify;
use Codeception\Test\Unit;

/**
 * This test suite shall coverage https://www.php.net/manual/ru/function.empty.php
 *
 * The main idea is, that we want to get from emptiest() function real bool value, whether it`s empty
 */

class NormalizedFloatvalTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    use Specify;

    public function testOnDotAsDelimiter()
    {


        $this->specify('test on positive value',function (){
            $value = '123.123asdasdasdads';

            $normalizedValue = normalizeFloatval($value);

            $this->assertIsFloat($normalizedValue);
            $this->assertSame(123.123,$normalizedValue);
        });
        $this->specify('test on negative value',function (){
            $value = '-123.123asdasdasdads';

            $normalizedValue = normalizeFloatval($value);

            $this->assertIsFloat($normalizedValue);
            $this->assertSame(-123.123,$normalizedValue);
        });


    }
    public function testOnCommaAsDelimiter(){
        $this->specify('test on positive value',function (){
            $value = '123,123asdasdasdads';

            $normalizedValue = normalizeFloatval($value);

            $this->assertIsFloat($normalizedValue);
            $this->assertSame(123.123,$normalizedValue);
        });

        $this->specify('test on negative value',function (){
            $value2 = '-123,123asdasdasdads';
            $normalizedValue2 = normalizeFloatval($value2);

            $this->assertIsFloat($normalizedValue2);
            $this->assertSame(-123.123,$normalizedValue2);
        });

    }
    public function testOnPastingIntValue(){
        $this->specify('test on positive value',function (){
            $intVal = 456;
            $floatVal = normalizeFloatval($intVal);

            $this->assertIsFloat($floatVal);
            $this->assertSame(456.0,$floatVal);
        });
        $this->specify('test on negative value',function (){
            $intVal2 = -456;
            $floatVal2 = normalizeFloatval($intVal2);

            $this->assertIsFloat($floatVal2);
            $this->assertSame(-456.0,$floatVal2);
        });






    }

    public function testOnPasteInvalidData()
    {
        $invalidData = [
            'this is some string',
        ];


        foreach ($invalidData as $testCase)
        {
            $this->expectException(InvalidArgumentException::class);
            normalizeFloatval($testCase);
        }


    }

}