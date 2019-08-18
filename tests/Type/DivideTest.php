<?php
namespace Tests\Type;

use Closure;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\Length\Centimetre;
use Tests\Stubs\Length\Length;
use Tests\Stubs\Length\Metre;
use Tests\Stubs\Length\Millimetre;
use Ukon\Exceptions\DivisionByZeroException;
use Ukon\Math;

class DivideTest extends TestCase
{

    public function testDivPositiveUnit()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->divMetre(2);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(1, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(70, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(50, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testDivZeroUnit()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $this->expectException(DivisionByZeroException::class);
        $length->divMetre(0);
    }

    public function testDivNegativeUnit()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->divMetre(-2);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(-1, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(70, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(50, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testDivPositiveDecimalUnit()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->divMetre(2.5);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(0.8, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(70, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(50, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testDivZeroDecimalUnit()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $this->expectException(DivisionByZeroException::class);
        $length->divMetre(0.0);
    }

    public function testDivNegativeDecimalUnit()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->divMetre(-2.5);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(-0.8, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(70, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(50, new Math(1))));
        }, $length, Length::class)($this);
    }
    public function testDivPositiveValue()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->div(2);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(1, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(35, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(25, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testDivZeroValue()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $this->expectException(DivisionByZeroException::class);
        $length->div(0);
    }

    public function testDivNegativeValue()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->div(-2);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(-1, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(-35, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(-25, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testDivPositiveDecimalValue()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->div(2.5);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(0.8, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(28, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(20, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testDivZeroDecimalValue()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $this->expectException(DivisionByZeroException::class);
        $length->div(0.0);
    }

    public function testDivNegativeDecimalValue()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->div(-2.5);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(-0.8, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(-28, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(-20, new Math(1))));
        }, $length, Length::class)($this);
    }
}
