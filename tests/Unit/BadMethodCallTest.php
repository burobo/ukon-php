<?php
namespace Tests\Unit;

use BadMethodCallException;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\Length\Metre;
use Ukon\Math;

class BadMethodCallTest extends TestCase
{
    public function testBadFmtMethodCall()
    {
        $this->expectException(BadMethodCallException::class);
        (new Metre(1, new Math(1)))->fmtFoo();
    }

    public function testBadMethodCall()
    {
        $this->expectException(BadMethodCallException::class);
        (new Metre(1, new Math(1)))->foo();
    }
}
