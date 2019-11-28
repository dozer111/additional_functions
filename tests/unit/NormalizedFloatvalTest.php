<?php

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

    public function testOnDotAsDelimiter()
    {
        $value = '123.123asdasdasdads';

        $normalizedValue = normalized_floatval($value);

        $this->assertIsFloat($normalizedValue);
        $this->assertSame(123.123,$normalizedValue);
    }
    public function testOnCommaAsDelimiter(){
        $value = '123,123asdasdasdads';

        $normalizedValue = normalized_floatval($value);

        $this->assertIsFloat($normalizedValue);
        $this->assertSame(123.123,$normalizedValue);
    }


}