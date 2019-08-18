<?php
namespace Tests\Type;

use Closure;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\Length\Centimetre;
use Tests\Stubs\Length\Length;
use Tests\Stubs\Length\Metre;
use Tests\Stubs\Length\Millimetre;
use Ukon\Math;
use Ukon\Exceptions\DifferentTypeException;
use Tests\Stubs\Weight\Weight;

class AddTest extends TestCase
{
    public function testAddPositiveUnit()
    {
        $length = (new Length(1))->addMetre(1);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(1, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(0, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(0, new Math(1))));
        }, $length, Length::class)($this);

        $length->addCentimetre(70)->addMillimetre(50);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(1, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(70, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(50, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testAddZeroUnit()
    {
        $length = (new Length(1))->addMetre(1)->addCentimetre(70)->addMillimetre(50);
        $length->addMetre(0)->addCentimetre(0)->addMillimetre(0);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(1, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(70, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(50, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testAddNegativeUnit()
    {
        $length = (new Length(1))->addMetre(1)->addCentimetre(70)->addMillimetre(50);
        $length->addMetre(-2)->addCentimetre(-80)->addMillimetre(-50);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(-1, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(-10, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(0, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testAddPositiveType()
    {
        $length = (new Length(1))->addMetre(1)->addCentimetre(70)->addMillimetre(50);
        $length->add((new Length(1))->addMetre(1)->addCentimetre(70)->addMillimetre(50));
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(2, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(140, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(100, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testAddZeroType()
    {
        $length = (new Length(1))->addMetre(1)->addCentimetre(70)->addMillimetre(50);
        $length->add((new Length(1))->addMetre(0)->addCentimetre(0)->addMillimetre(0));
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(1, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(70, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(50, new Math(1))));
        }, $length, Length::class)($this);

    }

    public function testAddNegativeDecimalType()
    {
        $length = (new Length(1))->addMetre(1)->addCentimetre(70)->addMillimetre(50);
        $length->add((new Length(1))->addMetre(-3)->addCentimetre(-20)->addMillimetre(-100));
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(-2, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(50, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(-50, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testAddPositiveDecimalUnit()
    {
        $length = (new Length(1))->addMetre(1);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(1, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(0, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(0, new Math(1))));
        }, $length, Length::class)($this);

        $length->addCentimetre(70.5)->addMillimetre(50.5);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(1, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(70.5, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(50.5, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testAddZeroDecimalUnit()
    {
        $length = (new Length(1))->addMetre(1)->addCentimetre(70)->addMillimetre(50);
        $length->addMetre(0.0)->addCentimetre(0.0)->addMillimetre(0.0);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(1, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(70, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(50, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testAddNegativeDecimalUnit()
    {
        $length = (new Length(1))->addMetre(1)->addCentimetre(70)->addMillimetre(50);
        $length->addMetre(-2.1)->addCentimetre(-80.5)->addMillimetre(-50.7);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(-1.1, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(-10.5, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(-0.7, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testAddPositiveDecimalType()
    {
        $length = (new Length(1))->addMetre(1)->addCentimetre(70)->addMillimetre(50);
        $length->add((new Length(1))->addMetre(1.5)->addCentimetre(70.5)->addMillimetre(50.5));
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(2.5, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(140.5, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(100.5, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testAddZeroDecimalType()
    {
        $length = (new Length(1))->addMetre(1)->addCentimetre(70)->addMillimetre(50);
        $length->add((new Length(1))->addMetre(0.0)->addCentimetre(0.0)->addMillimetre(0.0));
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(1, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(70, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(50, new Math(1))));
        }, $length, Length::class)($this);

    }

    public function testAddNegativeType()
    {
        $length = (new Length(1))->addMetre(1)->addCentimetre(70)->addMillimetre(50);
        $length->add((new Length(1))->addMetre(-3.5)->addCentimetre(-20.3)->addMillimetre(-100.7));
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(-2.5, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(49.7, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(-50.7, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testAddDifferentType()
    {
        $length = new Length(1);
        $weight = new Weight(1);
        $this->expectException(DifferentTypeException::class);
        $length->add($weight);
    }
}
