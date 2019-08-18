<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tests\Stubs\Length\Metre;
use Ukon\Math;

class MulTest extends TestCase
{
    public function testMulPositiveUnit()
    {
        $metre = new Metre(1, new Math(1));
        $metre->mul(2);
        $this->assertSame(2.0, $metre->getValue());
    }

    public function testMulZeroUnit()
    {
        $metre = new Metre(1, new Math(1));
        $metre->mul(0);
        $this->assertSame(0.0, $metre->getValue());
    }

    public function testMulNegativeUnit()
    {
        $metre = new Metre(1, new Math(1));
        $metre->mul(-2);
        $this->assertSame(-2.0, $metre->getValue());
    }

    public function testMulPositiveDecimalUnit()
    {
        $metre = new Metre(1.1, new Math(1));
        $metre->mul(1.2);
        $this->assertSame(1.3, $metre->getValue());
    }

    public function testMulZeroDecimalUnit()
    {
        $metre = new Metre(1.1, new Math(1));
        $metre->mul(0.0);
        $this->assertSame(0.0, $metre->getValue());
    }

    public function testMulNegativeDecimalUnit()
    {
        $metre = new Metre(1.1, new Math(1));
        $metre->mul(-1.2);
        $this->assertSame(-1.3, $metre->getValue());
    }
}
