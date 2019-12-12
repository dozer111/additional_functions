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
    public function testOnNonDuplicatedData()
    {
        $data = [
            'var/www/test',
            'someDir/system',
            'web/icons/',
            'prettyImage123.jpg'
        ];

        $filePath = implode_and_normalize('/', $data, '/');

        $expected = 'var/www/test/someDir/system/web/icons/prettyImage123.jpg';
        $this->tester->assertSame($expected, $filePath);
    }

    public function testOnDuplicatedDataWithRemoveStingType()
    {
        $data = [
            'var/www/test/',
            '/someDir/system/',
            '/web/icons/',
            'prettyImage123.jpg'
        ];

        $filePath = implode_and_normalize('/', $data, '/');

        $expected = 'var/www/test/someDir/system/web/icons/prettyImage123.jpg';
        $this->tester->assertSame($expected, $filePath);
    }

    public function testOnDuplicatedDataWithRemoveArrayType()
    {
        $data = [
            'var/www/test/',
            '/some|Dir/system/',
            '/web/icons/',
            'pretty||Image123.jpg'
        ];
        $duplicateSymbsArray = ['/','|'];
        $filePath = implode_and_normalize('/', $data, $duplicateSymbsArray);

        $expected = 'var/www/test/some|Dir/system/web/icons/pretty|Image123.jpg';
        $this->tester->assertSame($expected, $filePath);
    }

    public function testOnDuplicatedDataWithRemoveIntType()
    {
        $data = [
            'var/www/test',
            'some22222Dir/system',
            'web/icons/',
            'prettyImage122222222223.jpg'
        ];

        $filePath = implode_and_normalize('/', $data, 2);

        $expected = 'var/www/test/some2Dir/system/web/icons//prettyImage123.jpg';
        $this->tester->assertSame($expected, $filePath);
    }

    public function testOnDuplicatedDataWithInvalidType()
    {
        $this->expectException(Exception::class);

        $data = [
            'var/www/test',
            'someDir/system',
            'web/icons/',
            'prettyImage123.jpg'
        ];

       implode_and_normalize('/', $data, false);

    }


}