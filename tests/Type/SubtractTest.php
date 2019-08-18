<?php
namespace Tests\Type;

use Closure;
use Ukon\Math;
use Tests\Stubs\Length\Metre;
use Tests\Stubs\Length\Length;
use Tests\Stubs\Weight\Weight;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\Length\Centimetre;
use Tests\Stubs\Length\Millimetre;
use Ukon\Exceptions\DifferentTypeException;

class SubtractTest extends TestCase
{

    public function testSubPositiveUnit()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->subMetre(1)->subCentimetre(80)->subMillimetre(50);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(1, new Math(1), new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(-10, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(0, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testSubZeroUnit()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->subMetre(0)->subCentimetre(0)->subMillimetre(0);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(2, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(70, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(50, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testSubNegativeUnit()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->subMetre(-2)->subCentimetre(-80)->subMillimetre(-40);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(4, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(150, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(90, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testSubPositiveType()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->sub((new Length(1))->addMetre(1)->addCentimetre(70)->addMillimetre(80));
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(1, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(0, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(-30, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testSubZeroType()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->sub((new Length(1))->addMetre(0)->addCentimetre(0)->addMillimetre(0));
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(2, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(70, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(50, new Math(1))));
        }, $length, Length::class)($this);

    }

    public function testSubNegativeType()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->sub((new Length(1))->addMetre(-3)->addCentimetre(-20)->addMillimetre(-100));
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(5, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(90, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(150, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testSubPositiveDecimalUnit()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->subMetre(1.5)->subCentimetre(80.8)->subMillimetre(50.3);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(0.5, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(-10.8, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(-0.3, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testSubZeroDecimalUnit()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->subMetre(0.0)->subCentimetre(0.0)->subMillimetre(0.0);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(2, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(70, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(50, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testSubNegativeDecimalUnit()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->subMetre(-2.5)->subCentimetre(-80.8)->subMillimetre(-40.4);
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(4.5, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(150.8, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(90.4, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testSubPositiveDecimalType()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->sub((new Length(1))->addMetre(1.5)->addCentimetre(70.3)->addMillimetre(80.7));
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(0.5, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(-0.3, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(-30.7, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testSubZeroDecimalType()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->sub((new Length(1))->addMetre(0.0)->addCentimetre(0.0)->addMillimetre(0.0));
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(2, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(70, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(50, new Math(1))));
        }, $length, Length::class)($this);

    }

    public function testSubNegativeDecimalType()
    {
        $length = (new Length(1))->addMetre(2)->addCentimetre(70)->addMillimetre(50);
        $length->sub((new Length(1))->addMetre(-3.3)->addCentimetre(-20.5)->addMillimetre(-100.7));
        Closure::bind(function ($self) {
            $self->assertTrue($this->units[Metre::class]->equalTo(new Metre(5.3, new Math(1))));
            $self->assertTrue($this->units[Centimetre::class]->equalTo(new Centimetre(90.5, new Math(1))));
            $self->assertTrue($this->units[Millimetre::class]->equalTo(new Millimetre(150.7, new Math(1))));
        }, $length, Length::class)($this);
    }

    public function testSubDifferentType()
    {
        $length = new Length(1);
        $weight = new Weight(1);
        $this->expectException(DifferentTypeException::class);
        $length->sub($weight);
    }
}
