<?php
namespace Tests\Type;

use PHPUnit\Framework\TestCase;
use Tests\Stubs\Length\Centimetre;
use Tests\Stubs\Length\Length;
use Tests\Stubs\Length\Metre;
use Tests\Stubs\Length\Millimetre;
use Tests\Stubs\Weight\Gram;
use Ukon\Exceptions\InvalidCallableDefinitionException;

class StringifyTest extends TestCase
{
    public function testStringifyUsingFunction()
    {
        $height = (new Length(1))
            ->addMetre(1.7)
            ->addMillimetre(1);

        $abbr = $height->stringify(function (Metre $metre, Centimetre $centimetre, Millimetre $millimetre) {
            return $metre->fmtAbbr() . ' ' . $centimetre->fmtAbbr() . ' ' . $millimetre->fmtAbbr();
        });

        $this->assertEquals('1m 70cm 1mm', $abbr);
    }

    public function testStringifyUsingArrayCallback()
    {
        $height = (new Length(1))
            ->addMetre(1.7)
            ->addMillimetre(1);

        $abbr = $height->stringify(
            [
                new class

        {
                    public function abbrFormat(Metre $metre, Centimetre $centimetre, Millimetre $millimetre)
            {
                        return $metre->fmtAbbr() . $centimetre->fmtAbbr() . $millimetre->fmtAbbr();
                    }
                }
                ,
                'abbrFormat',
            ]
        );

        $this->assertEquals('1m70cm1mm', $abbr);
    }

    public function testStringifyUsingInvalidCallable()
    {
        $height = (new Length(1))
            ->addMetre(1.7)
            ->addMillimetre(1);

        $this->expectException(InvalidCallableDefinitionException::class);
        $this->expectExceptionMessage("Class Tests\Stubs\Weight\Gram is invalid argument for the callable definition.");

        $height->stringify(function (Gram $gram) {
            return $gram->fmtAbbr();
        });
    }
}
