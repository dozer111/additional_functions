<?php

use Codeception\Specify;

class ToArrayTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    use Specify;



    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testValueIsArray(){
        $data = [
            [],
            array(),
            [1,2,3,4]
        ];


        foreach ($data as $testCase){
            $toArrayVal = toArray($testCase);
            $this->tester->assertIsArray($toArrayVal);
            $this->tester->assertSame($testCase,$toArrayVal);
        }


    }

    public function testValueIsNotArray(){
        $data = [
            1,
            'asd',
            null,
            false,
            new DateTime(),
        ];

        foreach ($data as $testCase){
            $toArrayVal = toArray($testCase);
            $this->tester->assertIsArray($toArrayVal);
        }

    }
}