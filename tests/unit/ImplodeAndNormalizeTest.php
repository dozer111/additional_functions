<?php

use Codeception\Test\Unit;


class ImplodeAndNormalizeTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;


    protected function _before()
    {

    }

    protected function _after()
    {

    }

    /**
     * First step with correct data
     * @return void
     * @throws Exception
     */
    public function testNonDuplicatedData()
    {
        $data = [
            'var/www/test',
            'someDir/system',
            'web/icons/',
            'prettyImage123.jpg'
        ];

        $filePath = implode_and_normalize('/', $data);

        $expected = 'var/www/test/someDir/system/web/icons/prettyImage123.jpg';
        $this->tester->assertSame($expected, $filePath);
    }

    public function testDuplicatedData()
    {
        $data = [
            'var/www/test/',
            '/someDir/system/',
            '/web/icons/',
            'prettyImage123.jpg'
        ];

        $data2 = [
            'var/www/test',
            'someDir/system',
            'web/icons',
            'prettyImage123.jpg'
        ];


        $filePath1 = implode_and_normalize('/', $data);
        $filePath2 = implode_and_normalize('/', $data2);


        $expected = 'var/www/test/someDir/system/web/icons/prettyImage123.jpg';

        $this->tester->assertSame($expected, $filePath1);
        $this->tester->assertSame($expected, $filePath2);
    }



}