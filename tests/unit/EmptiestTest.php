<?php

use Codeception\Test\Unit;

/**
 * This test suite shall coverage https://www.php.net/manual/ru/function.empty.php
 *
 * The main idea is, that we want to get from emptiest() function real bool value, whether it`s empty
 */

class EmptiestTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    private $resource;

    protected function _before()
    {
        $filePath = __DIR__ . '/../_data/text.txt';

        $this->resource = fopen($filePath, 'rb');
    }

    protected function _after()
    {
        fclose($this->resource);
    }

    public function testEmptyString()
    {
        $emptyString = '';

        $this->assertTrue(emptiest($emptyString));
    }

    public function testNotEmptyString()
    {
        $notEmptyString1 = ' ';
        $notEmptyString2 = 'some test text';

        $this->assertFalse(emptiest($notEmptyString1));
        $this->assertFalse(emptiest($notEmptyString2));
    }

    public function testOnPasteZero()
    {
        $input1 = 0;
        $input2 = 0.0;
        $input3 = '0';

        $this->assertFalse(emptiest($input1));
        $this->assertFalse(emptiest($input2));
        $this->assertFalse(emptiest($input3));
    }

    public function testOnPasteNull()
    {
        $input = null;
        $this->assertTrue(emptiest($input));
    }

    public function testOnPasteBool()
    {
        $input = false;
        $input2 = true;
        $this->assertFalse(emptiest($input));
        $this->assertFalse(emptiest($input2));
    }

    public function testOnPasteArray()
    {
        $emptyArray = [];
        $notEmptyArray = [1, 2, 3, 4, 5];


        $this->assertTrue(emptiest($emptyArray));
        $this->assertFalse(emptiest($notEmptyArray));


    }

    public function testOnPasteResource()
    {
        $resource = $this->resource;

        $this->assertFalse(emptiest($resource));

    }

    public function testOnPasteObject()
    {
        $object = new ArrayObject();

        $this->assertFalse(emptiest($object));
    }


}