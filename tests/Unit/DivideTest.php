<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tests\Stubs\Length\Metre;
use Ukon\Exceptions\DivisionByZeroException;
use Ukon\Math;

class DivTest extends TestCase
{
    public function testDivPositiveUnit()
    {
        $metre = new Metre(1, new Math(1));
        $metre->div(2);
        $this->assertSame(0.5, $metre->getValue());
    }

    public function testDivZeroUnit()
    {
        $metre = new Metre(1, new Math(1));
        $this->expectException(DivisionByZeroException::class);
        $metre->div(0);
    }

    public function testDivNegativeUnit()
    {
        $metre = new Metre(1, new Math(1));
        $metre->div(-2);
        $this->assertSame(-0.5, $metre->getValue());
    }

    public function testDivPositiveDecimalUnit()
    {
        $metre = new Metre(1.1, new Math(1));
        $metre->div(1.2);
        $this->assertSame(0.9, $metre->getValue());
    }

    public function testDivZeroDecimalUnit()
    {
        $metre = new Metre(1.1, new Math(1));
        $this->expectException(DivisionByZeroException::class);
        $metre->div(0.0);
    }

    public function testDivNegativeDecimalUnit()
    {
        $metre = new Metre(1.1, new Math(1));
        $metre->div(-1.2);
        $this->assertSame(-0.9, $metre->getValue());
    }
}
