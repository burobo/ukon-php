<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tests\Stubs\Length\Metre;
use Tests\Stubs\Weight\Gram;
use Ukon\Exceptions\DifferentUnitException;
use Ukon\Math;

class AddTest extends TestCase
{
    public function testAddPositiveUnit()
    {
        $metre = new Metre(1, new Math(1));
        $metre->add(new Metre(1, new Math(1)));
        $this->assertSame(2.0, $metre->getValue());
    }

    public function testAddZeroUnit()
    {
        $metre = new Metre(1, new Math(1));
        $metre->add(new Metre(0.0, new Math(1)));
        $this->assertSame(1.0, $metre->getValue());
    }

    public function testAddNegativeUnit()
    {
        $metre = new Metre(1, new Math(1));
        $metre->add(new Metre(-2, new Math(1)));
        $this->assertSame(-1.0, $metre->getValue());
    }

    public function testAddPositiveDecimalUnit()
    {
        $metre = new Metre(1.1, new Math(1));
        $metre->add(new Metre(1.2, new Math(1)));
        $this->assertSame(2.3, $metre->getValue());
    }

    public function testAddZeroDecimalUnit()
    {
        $metre = new Metre(1.1, new Math(1));
        $metre->add(new Metre(0.0, new Math(1)));
        $this->assertSame(1.1, $metre->getValue());
    }

    public function testAddNegativeDecimalUnit()
    {
        $metre = new Metre(1.1, new Math(1));
        $metre->add(new Metre(-2.3, new Math(1)));
        $this->assertSame(-1.2, $metre->getValue());
    }

    public function testAddDifferentUnit()
    {
        $metre = new Metre(1, new Math(1));
        $this->expectException(DifferentUnitException::class);
        $metre->add(new Gram(1, new Math(1)));
    }
}
