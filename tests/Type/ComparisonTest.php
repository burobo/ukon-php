<?php
namespace Tests\Type;

use Tests\Stubs\Length\Length;
use Tests\Stubs\Weight\Weight;
use PHPUnit\Framework\TestCase;
use Ukon\Exceptions\DifferentTypeException;
use Ukon\Exceptions\DivisionByZeroException;

class ComparisonTest extends TestCase
{
    public function testEqualToTrue()
    {
        $length = (new Length(1))->addMetre(1);
        $this->assertTrue($length->equalTo((new Length(1))->addMetre(1)));
        $this->assertTrue($length->equalTo((new Length(1))->addMetre(1)));
        $this->assertTrue($length->equalTo((new Length(1))->addCentimetre(100)));
        $this->assertTrue($length->equalTo((new Length(1))->addMillimetre(1000)));
        $this->assertTrue($length->equalTo((new Length(1))->addCentimetre(50)->addMillimetre(500)));
        $this->assertTrue($length->equalTo((new Length(1))->addCentimetre(50.000)->addMillimetre(500.0)));
        $this->assertTrue((new Length(1))->addMetre(1)->equalTo($length));
        $this->assertTrue((new Length(1))->addCentimetre(100)->equalTo($length));
        $this->assertTrue((new Length(1))->addMillimetre(1000)->equalTo($length));
        $this->assertTrue((new Length(1))->addCentimetre(50)->addMillimetre(500)->equalTo($length));
        $this->assertTrue((new Length(1))->addCentimetre(50.000)->addMillimetre(500.0)->equalTo($length));
        $length->addMillimetre(1.1);
        $this->assertTrue($length->equalTo((new Length(2))->addCentimetre(50.50)->addMillimetre(496.1)));
        // This assertTrue passes because the scale is 1.
        $this->assertTrue($length->equalTo((new Length(2))->addCentimetre(50.50)->addMillimetre(496.19)));
    }

    public function testEqualToFalse()
    {
        $length = (new Length(1))->addMetre(1);
        $this->assertFalse($length->equalTo((new Length(1))->addMetre(0)));
        $this->assertFalse($length->equalTo((new Length(1))->addCentimetre(101)));
        $this->assertFalse($length->equalTo((new Length(1))->addMillimetre(1001)));
        $this->assertFalse($length->equalTo((new Length(1))->addCentimetre(50)->addMillimetre(499)));
        $this->assertFalse((new Length(1))->addCentimetre(50.9)->addMillimetre(499.9)->equalTo($length));
        $this->assertFalse((new Length(1))->addMetre(0)->equalTo($length));
        $this->assertFalse((new Length(1))->addCentimetre(101)->equalTo($length));
        $this->assertFalse((new Length(1))->addMillimetre(1001)->equalTo($length));
        $this->assertFalse((new Length(1))->addCentimetre(50)->addMillimetre(499)->equalTo($length));
        $this->assertFalse((new Length(1))->addCentimetre(50.9)->addMillimetre(499.9)->equalTo($length));
        $length->addMillimetre(1.1);
        // This assertFalse passes because the scale is 2.
        $this->assertFalse((new Length(2))->addCentimetre(50.50)->addMillimetre(496.19)->equalTo($length));
    }

    public function testGreaterThanTrue()
    {
        $length = (new Length(1))->addMetre(1);
        $this->assertTrue($length->greaterThan((new Length(1))->addMetre(0.9)));
        $this->assertTrue($length->greaterThan((new Length(1))->addCentimetre(99.9)));
        $this->assertTrue($length->greaterThan((new Length(1))->addMillimetre(999.9)));
        $this->assertTrue($length->greaterThan((new Length(2))->addMillimetre(999.99)));
    }

    public function testGreaterThanFalse()
    {
        $length = (new Length(1))->addMetre(1);
        $this->assertFalse((new Length(1))->addMetre(0.9)->greaterThan($length));
        $this->assertFalse((new Length(1))->addCentimetre(99.9)->greaterThan($length));
        $this->assertFalse((new Length(1))->addMillimetre(999.9)->greaterThan($length));
        $this->assertFalse((new Length(2))->addMillimetre(999.99)->greaterThan($length));
        $this->assertFalse((new Length(1))->addMetre(1)->greaterThan($length));
        // This assertFalse passes because the scale is 1.
        $this->assertFalse((new Length(1))->addMetre(1.01)->greaterThan($length));
    }

    public function testLessThanTrue()
    {
        $length = (new Length(1))->addMetre(1);
        $this->assertTrue($length->lessThan((new Length(1))->addMetre(1.1)));
        $this->assertTrue($length->lessThan((new Length(1))->addCentimetre(100.1)));
        $this->assertTrue($length->lessThan((new Length(1))->addMillimetre(1000.1)));
        $this->assertTrue($length->lessThan((new Length(2))->addMillimetre(1000.1)));
    }

    public function testLessThanFalse()
    {
        $length = (new Length(1))->addMetre(1);
        $this->assertFalse($length->lessThan((new Length(1))->addMetre(1.0)));
        $this->assertFalse($length->lessThan((new Length(1))->addCentimetre(100.0)));
        $this->assertFalse($length->lessThan((new Length(1))->addMillimetre(1000.0)));
        $this->assertFalse($length->lessThan((new Length(1))->addMillimetre(999.9)));
        // This assertFalse passes because the scale is 1.
        $this->assertFalse($length->lessThan((new Length(1))->addMetre(1.01)));
    }

    public function testGreaterThanOrEqualToTrue()
    {
        $length = (new Length(1))->addMetre(1);
        $this->assertTrue($length->greaterThanOrEqualTo((new Length(1))->addMetre(1.0)));
        $this->assertTrue($length->greaterThanOrEqualTo((new Length(1))->addCentimetre(100.0)));
        $this->assertTrue($length->greaterThanOrEqualTo((new Length(1))->addMillimetre(1000.0)));
        $this->assertTrue($length->greaterThanOrEqualTo((new Length(1))->addMillimetre(999.9)));
        // This assertTrue passes because the scale is 1.
        $this->assertTrue($length->greaterThanOrEqualTo((new Length(1))->addMetre(1.01)));
    }

    public function testGreaterThanOrEqualToFalse()
    {
        $length = (new Length(1))->addMetre(1);
        $this->assertFalse($length->greaterThanOrEqualTo((new Length(1))->addMetre(1.1)));
        $this->assertFalse($length->greaterThanOrEqualTo((new Length(1))->addCentimetre(100.1)));
        $this->assertFalse($length->greaterThanOrEqualTo((new Length(1))->addMillimetre(1000.1)));
        $this->assertFalse($length->greaterThanOrEqualTo((new Length(2))->addMillimetre(1000.1)));
    }

    public function testLessThanOrEqualToTrue()
    {
        $length = (new Length(1))->addMetre(1);
        $this->assertTrue((new Length(1))->addMetre(0.9)->lessThanOrEqualTo($length));
        $this->assertTrue((new Length(1))->addCentimetre(99.9)->lessThanOrEqualTo($length));
        $this->assertTrue((new Length(1))->addMillimetre(999.9)->lessThanOrEqualTo($length));
        $this->assertTrue((new Length(2))->addMillimetre(999.99)->lessThanOrEqualTo($length));
        $this->assertTrue((new Length(1))->addMetre(1)->lessThanOrEqualTo($length));
        // This assertTrue passes because the scale is 1.
        $this->assertTrue((new Length(1))->addMetre(1.01)->lessThanOrEqualTo($length));
    }

    public function testLessThanOrEqualToFalse()
    {
        $length = (new Length(1))->addMetre(1);
        $this->assertFalse($length->lessThanOrEqualTo((new Length(1))->addCentimetre(99.9)));
        $this->assertFalse($length->lessThanOrEqualTo((new Length(1))->addMillimetre(999.9)));
        $this->assertFalse($length->lessThanOrEqualTo((new Length(2))->addMillimetre(999.99)));
    }

    public function testNotEqualToFalse()
    {
        $length = (new Length(1))->addMetre(1);
        $this->assertFalse($length->notEqualTo((new Length(1))->addMetre(1)));
        $this->assertFalse($length->notEqualTo((new Length(1))->addMetre(1)));
        $this->assertFalse($length->notEqualTo((new Length(1))->addCentimetre(100)));
        $this->assertFalse($length->notEqualTo((new Length(1))->addMillimetre(1000)));
        $this->assertFalse($length->notEqualTo((new Length(1))->addCentimetre(50)->addMillimetre(500)));
        $this->assertFalse($length->notEqualTo((new Length(1))->addCentimetre(50.000)->addMillimetre(500.0)));
        $this->assertFalse((new Length(1))->addMetre(1)->notEqualTo($length));
        $this->assertFalse((new Length(1))->addCentimetre(100)->notEqualTo($length));
        $this->assertFalse((new Length(1))->addMillimetre(1000)->notEqualTo($length));
        $this->assertFalse((new Length(1))->addCentimetre(50)->addMillimetre(500)->notEqualTo($length));
        $this->assertFalse((new Length(1))->addCentimetre(50.000)->addMillimetre(500.0)->notEqualTo($length));
        $length->addMillimetre(1.1);
        $this->assertFalse($length->notEqualTo((new Length(2))->addCentimetre(50.50)->addMillimetre(496.1)));
        // This assertFalse passes because the scale is 1.
        $this->assertFalse($length->notEqualTo((new Length(2))->addCentimetre(50.50)->addMillimetre(496.19)));
    }

    public function testNotEqualToTrue()
    {
        $length = (new Length(1))->addMetre(1);
        $this->assertTrue($length->notEqualTo((new Length(1))->addMetre(0)));
        $this->assertTrue($length->notEqualTo((new Length(1))->addCentimetre(101)));
        $this->assertTrue($length->notEqualTo((new Length(1))->addMillimetre(1001)));
        $this->assertTrue($length->notEqualTo((new Length(1))->addCentimetre(50)->addMillimetre(499)));
        $this->assertTrue((new Length(1))->addCentimetre(50.9)->addMillimetre(499.9)->notEqualTo($length));
        $this->assertTrue((new Length(1))->addMetre(0)->notEqualTo($length));
        $this->assertTrue((new Length(1))->addCentimetre(101)->notEqualTo($length));
        $this->assertTrue((new Length(1))->addMillimetre(1001)->notEqualTo($length));
        $this->assertTrue((new Length(1))->addCentimetre(50)->addMillimetre(499)->notEqualTo($length));
        $this->assertTrue((new Length(1))->addCentimetre(50.9)->addMillimetre(499.9)->notEqualTo($length));
        $length->addMillimetre(1.1);
        // This assertTrue passes because the scale is 2.
        $this->assertTrue((new Length(2))->addCentimetre(50.50)->addMillimetre(496.19)->notEqualTo($length));
    }

    public function testNotGreaterThanFalse()
    {
        $length = (new Length(1))->addMetre(1);
        $this->assertFalse($length->notGreaterThan((new Length(1))->addMetre(0.9)));
        $this->assertFalse($length->notGreaterThan((new Length(1))->addCentimetre(99.9)));
        $this->assertFalse($length->notGreaterThan((new Length(1))->addMillimetre(999.9)));
        $this->assertFalse($length->notGreaterThan((new Length(2))->addMillimetre(999.99)));
    }

    public function testNotGreaterThanTrue()
    {
        $length = (new Length(1))->addMetre(1);
        $this->assertTrue((new Length(1))->addMetre(0.9)->notGreaterThan($length));
        $this->assertTrue((new Length(1))->addCentimetre(99.9)->notGreaterThan($length));
        $this->assertTrue((new Length(1))->addMillimetre(999.9)->notGreaterThan($length));
        $this->assertTrue((new Length(2))->addMillimetre(999.99)->notGreaterThan($length));
        $this->assertTrue((new Length(1))->addMetre(1)->notGreaterThan($length));
        // This assertTrue passes because the scale is 1.
        $this->assertTrue((new Length(1))->addMetre(1.01)->notGreaterThan($length));
    }

    public function testNotLessThanFalse()
    {
        $length = (new Length(1))->addMetre(1);
        $this->assertFalse($length->notLessThan((new Length(1))->addMetre(1.1)));
        $this->assertFalse($length->notLessThan((new Length(1))->addCentimetre(100.1)));
        $this->assertFalse($length->notLessThan((new Length(1))->addMillimetre(1000.1)));
        $this->assertFalse($length->notLessThan((new Length(2))->addMillimetre(1000.1)));
    }

    public function testNotLessThanTrue()
    {
        $length = (new Length(1))->addMetre(1);
        $this->assertTrue($length->notLessThan((new Length(1))->addMetre(1.0)));
        $this->assertTrue($length->notLessThan((new Length(1))->addCentimetre(100.0)));
        $this->assertTrue($length->notLessThan((new Length(1))->addMillimetre(1000.0)));
        $this->assertTrue($length->notLessThan((new Length(1))->addMillimetre(999.9)));
        // This assertTrue passes because the scale is 1.
        $this->assertTrue($length->notLessThan((new Length(1))->addMetre(1.01)));
    }

    public function testNotGreaterThanOrEqualToFalse()
    {
        $length = (new Length(1))->addMetre(1);
        $this->assertFalse($length->notGreaterThanOrEqualTo((new Length(1))->addMetre(1.0)));
        $this->assertFalse($length->notGreaterThanOrEqualTo((new Length(1))->addCentimetre(100.0)));
        $this->assertFalse($length->notGreaterThanOrEqualTo((new Length(1))->addMillimetre(1000.0)));
        $this->assertFalse($length->notGreaterThanOrEqualTo((new Length(1))->addMillimetre(999.9)));
        // This assertFalse passes because the scale is 1.
        $this->assertFalse($length->notGreaterThanOrEqualTo((new Length(1))->addMetre(1.01)));
    }

    public function testNotGreaterThanOrEqualToTrue()
    {
        $length = (new Length(1))->addMetre(1);
        $this->assertTrue($length->notGreaterThanOrEqualTo((new Length(1))->addMetre(1.1)));
        $this->assertTrue($length->notGreaterThanOrEqualTo((new Length(1))->addCentimetre(100.1)));
        $this->assertTrue($length->notGreaterThanOrEqualTo((new Length(1))->addMillimetre(1000.1)));
        $this->assertTrue($length->notGreaterThanOrEqualTo((new Length(2))->addMillimetre(1000.1)));
    }

    public function testNotLessThanOrEqualToFalse()
    {
        $length = (new Length(1))->addMetre(1);
        $this->assertFalse((new Length(1))->addMetre(0.9)->notLessThanOrEqualTo($length));
        $this->assertFalse((new Length(1))->addCentimetre(99.9)->notLessThanOrEqualTo($length));
        $this->assertFalse((new Length(1))->addMillimetre(999.9)->notLessThanOrEqualTo($length));
        $this->assertFalse((new Length(2))->addMillimetre(999.99)->notLessThanOrEqualTo($length));
        $this->assertFalse((new Length(1))->addMetre(1)->notLessThanOrEqualTo($length));
        // This assertFalse passes because the scale is 1.
        $this->assertFalse((new Length(1))->addMetre(1.01)->notLessThanOrEqualTo($length));
    }

    public function testNotLessThanOrEqualToTrue()
    {
        $length = (new Length(1))->addMetre(1);
        $this->assertTrue($length->notLessThanOrEqualTo((new Length(1))->addCentimetre(99.9)));
        $this->assertTrue($length->notLessThanOrEqualTo((new Length(1))->addMillimetre(999.9)));
        $this->assertTrue($length->notLessThanOrEqualTo((new Length(2))->addMillimetre(999.99)));
    }

    public function testCompareToEquals()
    {
        $length = (new Length(1))->addMetre(1);
        $this->assertEquals(1.5, (new Length(1))->addMetre(1)->mul(1.5)->compareTo($length));
        // This assertEquals passes because the scale is 1.
        $this->assertEquals(1.5, (new Length(1))->addMetre(1)->mul(1.55)->compareTo($length));
        $this->assertEquals(0, (new Length(1))->compareTo($length));
    }

    public function testCompareToNotEquals()
    {
        $length = (new Length(1))->addMetre(1);
        $this->assertNotEquals(1.5, (new Length(2))->addMetre(1)->mul(1.55)->compareTo($length));
    }

    public function testCompareToDivisionByZeroException()
    {
        $length = (new Length(1))->addMetre(1);
        $this->expectException(DivisionByZeroException::class);
        $length->compareTo(new Length(1));
    }

    public function testEqualToUsingDifferentType()
    {
        $length = (new Length(1))->addMetre(1);
        $weight = (new Weight(1))->addGram(1);
        $this->expectException(DifferentTypeException::class);
        $this->expectExceptionMessage('Type Tests\Stubs\Weight\Weight is diffrent from type Tests\Stubs\Length\Length.');
        $length->equalTo($weight);
    }

    public function testGreaterThanUsingDifferentType()
    {
        $length = (new Length(1))->addMetre(1);
        $weight = (new Weight(1))->addGram(1);
        $this->expectException(DifferentTypeException::class);
        $this->expectExceptionMessage('Type Tests\Stubs\Weight\Weight is diffrent from type Tests\Stubs\Length\Length.');
        $length->greaterThan($weight);
    }

    public function testLessThanUsingDifferentType()
    {
        $length = (new Length(1))->addMetre(1);
        $weight = (new Weight(1))->addGram(1);
        $this->expectException(DifferentTypeException::class);
        $this->expectExceptionMessage('Type Tests\Stubs\Weight\Weight is diffrent from type Tests\Stubs\Length\Length.');
        $length->lessThan($weight);
    }

    public function testGreaterThanOrEqualToUsingDifferentType()
    {
        $length = (new Length(1))->addMetre(1);
        $weight = (new Weight(1))->addGram(1);
        $this->expectException(DifferentTypeException::class);
        $this->expectExceptionMessage('Type Tests\Stubs\Weight\Weight is diffrent from type Tests\Stubs\Length\Length.');
        $length->greaterThanOrEqualTo($weight);
    }

    public function testLessThanOrEqualToUsingDifferentType()
    {
        $length = (new Length(1))->addMetre(1);
        $weight = (new Weight(1))->addGram(1);
        $this->expectException(DifferentTypeException::class);
        $this->expectExceptionMessage('Type Tests\Stubs\Weight\Weight is diffrent from type Tests\Stubs\Length\Length.');
        $length->lessThanOrEqualTo($weight);
    }

    public function testNotEqualToUsingDifferentType()
    {
        $length = (new Length(1))->addMetre(1);
        $weight = (new Weight(1))->addGram(1);
        $this->expectException(DifferentTypeException::class);
        $this->expectExceptionMessage('Type Tests\Stubs\Weight\Weight is diffrent from type Tests\Stubs\Length\Length.');
        $length->notEqualTo($weight);
    }

    public function testNotGreaterThanUsingDifferentType()
    {
        $length = (new Length(1))->addMetre(1);
        $weight = (new Weight(1))->addGram(1);
        $this->expectException(DifferentTypeException::class);
        $this->expectExceptionMessage('Type Tests\Stubs\Weight\Weight is diffrent from type Tests\Stubs\Length\Length.');
        $length->notGreaterThan($weight);
    }

    public function testNotLessThanUsingDifferentType()
    {
        $length = (new Length(1))->addMetre(1);
        $weight = (new Weight(1))->addGram(1);
        $this->expectException(DifferentTypeException::class);
        $this->expectExceptionMessage('Type Tests\Stubs\Weight\Weight is diffrent from type Tests\Stubs\Length\Length.');
        $length->notLessThan($weight);
    }

    public function testNotGreaterThanOrEqualToUsingDifferentType()
    {
        $length = (new Length(1))->addMetre(1);
        $weight = (new Weight(1))->addGram(1);
        $this->expectException(DifferentTypeException::class);
        $this->expectExceptionMessage('Type Tests\Stubs\Weight\Weight is diffrent from type Tests\Stubs\Length\Length.');
        $length->notGreaterThanOrEqualTo($weight);
    }

    public function testNotLessThanOrEqualToUsingDifferentType()
    {
        $length = (new Length(1))->addMetre(1);
        $weight = (new Weight(1))->addGram(1);
        $this->expectException(DifferentTypeException::class);
        $this->expectExceptionMessage('Type Tests\Stubs\Weight\Weight is diffrent from type Tests\Stubs\Length\Length.');
        $length->notLessThanOrEqualTo($weight);
    }

    public function testCompareToUsingDifferentType()
    {
        $length = (new Length(1))->addMetre(1);
        $weight = (new Weight(1))->addGram(1);
        $this->expectException(DifferentTypeException::class);
        $this->expectExceptionMessage('Type Tests\Stubs\Weight\Weight is diffrent from type Tests\Stubs\Length\Length.');
        $length->compareTo($weight);
    }

}
