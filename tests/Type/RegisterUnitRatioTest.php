<?php
namespace Tests\Type;

use PHPUnit\Framework\TestCase;
use Tests\Stubs\Currency\Currency;
use Tests\Stubs\Currency\JPY;
use Tests\Stubs\Currency\USD;
use Ukon\Exceptions\InvalidUnitClassNameException;

class RegisterUnitRatioTest extends TestCase
{
    public function testRegisterValidUnitRatio()
    {
        $currency = (new Currency(2));
        $currency->registerUnitRatio(JPY::class, 105.08);
        $currency->registerUnitRatio(USD::class, 1);
        $currency->addJPY(1);
        $currency->addUSD(1);

        $fmtFnc = function (USD $usd) {
            return $usd->fmtDefault();
        };

        $this->assertEquals("106.08 dollar", $currency->stringify($fmtFnc));

        $currency->registerUnitRatio(JPY::class, 110.08);
        $this->assertEquals("111.08 dollar", $currency->stringify($fmtFnc));

        $currency->addJPY(1);
        $currency->addUSD(1);
        $this->assertEquals("222.16 dollar", $currency->stringify($fmtFnc));
    }

    public function testRegisterInvalidUnitClass()
    {
        $currency = (new Currency(2));
        $this->expectException(InvalidUnitClassNameException::class);
        $this->expectExceptionMessage("Tests\Type\InvalidUnitClass is invalid because it isn't a child class of Ukon\Unit.");
        $currency->registerUnitRatio(InvalidUnitClass::class, 1);
    }

    public function testRegisterNotClassName()
    {
        $currency = (new Currency(2));
        $this->expectException(InvalidUnitClassNameException::class);
        $this->expectExceptionMessage("JPY is invalid because it isn't a child class of Ukon\Unit.");
        $currency->registerUnitRatio("JPY", 1);
    }

}

class InvalidUnitClass
{}
