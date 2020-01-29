<?php 
class TruncateNumberTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    use \Codeception\Specify;


    public function testDataValid()
    {
        $this->specify('test on int',function(){
            $number = 123456;
            $this->assertSame(strval($number),truncateNumber($number));
        });

        $this->specify('test on float',function(){
            $number = 123456.129951474859;
            $this->assertSame('123456.12',truncateNumber($number,2));
            $this->assertSame('123456.1299',truncateNumber($number,4));
            $this->assertSame('123456.12995',truncateNumber($number,5));
        });

        $this->specify('test on float with sting in end',function(){
            $number = '12.75 HP left';
            $this->assertSame('12',truncateNumber($number));
            $this->assertSame('12.75',truncateNumber($number,2));

        });


        $this->specify('test on too big decimal value',function(){
            $number = '123456.129951474859';
            $this->assertSame('123456.129951474859',truncateNumber($number,1e15));


            $number = '123456.1234567890123456789012345678901';
            $this->assertSame('123456.123456789',truncateNumber($number,9));
            $this->assertSame('123456.123456789012',truncateNumber($number,12));
            $this->assertSame('123456.12345678901234567890',truncateNumber($number,20));

            $number2 = 123456.129951474859;
            $this->assertSame('123456.12995147',truncateNumber($number2,1e15));

        });



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



}