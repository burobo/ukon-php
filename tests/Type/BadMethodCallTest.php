<?php
namespace Tests\Type;

use BadMethodCallException;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\Length\Length;

class BadMethodCallTest extends TestCase
{
    public function testBadMethodCall()
    {
        $this->expectException(BadMethodCallException::class);
        (new Length(1))->addKilometre(1);
    }
}
