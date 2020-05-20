<?php 
class TruncateNumberTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    use \Codeception\Specify;


    /**
     * @dataProvider dataValid
     * @param $input
     * @param $expected
     * @param $decimals
     * @return void
     */
    public function testDataValid($input,$expected,$decimals)
    {
        expect(truncateNumber($input,$decimals))->same($expected);
    }

    public function dataValid()
    {
        $testInt = 123456;
        $testFloat = 123456.129951474859;
        $testFloatWithE = '123456.129951474859e7';
        $testFloatWithEMinus = '123456.129951474859e-7';
        $testFloatWithEAsFloat = 123456.129951474859e3;
        $tooBigDecAsString = '123456.1234567890123456789012345678901';
        $tooBigDecAsStringWithE = '123456.1234567890123456789012345678901e4';
        // input,expected,decimals
        return [
            'test on int' => [$testInt,strval($testInt),0],

            'test on float 1' => [$testFloat,'123456.12',2],
            'test on float 2' =>[$testFloat,'123456.1299',4],
            'test on float 3' =>[$testFloat,'123456.12995',5],

            'test on float with e 1' =>[$testFloatWithE,'123456.12e7',2],
            'test on float with e 2' =>[$testFloatWithE,'123456.1299e7',4],
            'test on float with e 3' =>[$testFloatWithE,'123456.12995e7',5],
            'test on float with e 11' =>[$testFloatWithEMinus,'123456.12e-7',2],
            'test on float with e 12' =>[$testFloatWithEMinus,'123456.1299e-7',4],
            'test on float with e 13' =>[$testFloatWithEMinus,'123456.12995e-7',5],


            'test on float with sting in end 1' => ['12.75 HP left','12',0],
            'test on float with sting in end 2' => ['12.75 HP left','12.75',2],

            'test on too big decimal value 1' => ['123456.129951474859','123456.129951474859',1e15],
            'test on too big decimal value 2' => [$tooBigDecAsString,'123456.123456789',9],
            'test on too big decimal value 3' => [$tooBigDecAsString,'123456.123456789012',12],
            'test on too big decimal value 4' => [$tooBigDecAsString,'123456.12345678901234567890',20],
            'test on too big decimal value 5' => [123456.129951474859,'123456.12995147',1e15],

            'test on too big decimal value with e 1' => ['123456.129951474859e3','123456.129951474859e3',1e15],
            'test on too big decimal value with e 2' => [$tooBigDecAsStringWithE,'123456.123456789e4',9],
            'test on too big decimal value with e 3' => [$tooBigDecAsStringWithE,'123456.123456789012e4',12],
            'test on too big decimal value with e 4' => [$tooBigDecAsStringWithE,'123456.12345678901234567890e4',20],
            'test on too big decimal value with e 5' => ['123456.129951474859e5','123456.129951474859e5',1e15],

            'test on too big decimal value with e as float 1' => [$testFloatWithEAsFloat,'123456129.95',2],
            'test on too big decimal value with e as float 2' => [$testFloatWithEAsFloat,'123456129.9514',4],
        ];
    }





    public function testDataInvalid()
    {
        $this->specify('$number is pure string',function(){
            $number = 'LOL KEK';
            $this->expectException(InvalidArgumentException::class);
            truncateNumber($number);
        });

        $this->specify('$number is string on start',function(){
            $number = 'LOL KEK 12345';
            $this->expectException(InvalidArgumentException::class);
            truncateNumber($number);
        });
    }

    public function testDataEmpty()
    {
        $emptyData = [
            '',
            null
        ];

        foreach ($emptyData as $testCaseData)
        {
            $this->assertSame(null,truncateNumber($testCaseData));
        }
    }

}