<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tests\Stubs\Length\Metre;
use Tests\Stubs\Weight\Gram;
use Ukon\Exceptions\DifferentUnitException;
use Ukon\Math;

class SubtractTest extends TestCase
{
    public function testSubtractPositiveUnit()
    {
        $metre = new Metre(1, new Math(1));
        $metre->sub(new Metre(1, new Math(1)));
        $this->assertSame(0.0, $metre->getValue());
    }

    public function testSubtractZeroUnit()
    {
        $metre = new Metre(1, new Math(1));
        $metre->sub(new Metre(0.0, new Math(1)));
        $this->assertSame(1.0, $metre->getValue());
    }

    public function testSubtractNegativeUnit()
    {
        $metre = new Metre(1, new Math(1));
        $metre->sub(new Metre(-2, new Math(1)));
        $this->assertSame(3.0, $metre->getValue());
    }

    public function testSubtractPositiveDecimalUnit()
    {
        $metre = new Metre(1.1, new Math(1));
        $metre->sub(new Metre(1.2, new Math(1)));
        $this->assertSame(-0.1, $metre->getValue());
    }

    public function testSubtractZeroDecimalUnit()
    {
        $metre = new Metre(1.1, new Math(1));
        $metre->sub(new Metre(0.0, new Math(1)));
        $this->assertSame(1.1, $metre->getValue());
    }

    public function testSubtractNegativeDecimalUnit()
    {
        $metre = new Metre(1.1, new Math(1));
        $metre->sub(new Metre(-2.3, new Math(1)));
        $this->assertSame(3.4, $metre->getValue());
    }

    public function testAddDifferentUnit()
    {
        $metre = new Metre(1, new Math(1));
        $this->expectException(DifferentUnitException::class);
        $metre->sub(new Gram(1, new Math(1)));
    }
}
