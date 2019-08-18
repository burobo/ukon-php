<?php
namespace Tests\Type;

use Closure;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\Length\Centimetre;
use Tests\Stubs\Length\Length;
use Tests\Stubs\Length\Metre;
use Tests\Stubs\Length\Millimetre;
use Ukon\Math;

class MultiplyTest extends TestCase
{

    public function testMulPositiveUnit()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->mulMetre(2);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(4, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(70, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(50, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testMulZeroUnit()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->mulMetre(0);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(0, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(70, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(50, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testMulNegativeUnit()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->mulMetre(-2);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(-4, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(70, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(50, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testMulPositiveDecimalUnit()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->mulMetre(1.5);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(3, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(70, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(50, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testMulZeroDecimalUnit()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->mulMetre(0.0);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(0, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(70, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(50, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testMulNegativeDecimalUnit()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->mulMetre(-2.5);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(-5, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(70, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(50, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testMulPositiveValue()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->mul(2);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(4, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(140, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(100, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testMulZeroValue()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->mul(0);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(0, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(0, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(0, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testMulNegativeValue()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->mul(-2);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(-4, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(-140, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(-100, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testMulPositiveDecimalValue()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->mul(1.5);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(3, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(105, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(75, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testMulZeroDecimalValue()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->mul(0.0);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(0, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(0, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(0, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testMulNegativeDecimalValue()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->mul(-2.5);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(-5, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(-175, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(-125, new Math(1))));
        }, $length, Length::class)($this);
    }
}
