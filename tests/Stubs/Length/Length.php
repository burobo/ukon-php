<?php
namespace Tests\Stubs\Length;

use Tests\Stubs\Length\Centimetre;
use Tests\Stubs\Length\Metre;
use Tests\Stubs\Length\Millimetre;
use Ukon\Type;

class Length extends Type
{
    /**
     * @inheritDoc
     */
    public function __construct(int $scale)
    {
        parent::__construct($scale);
        $this->registerUnitRatio(Metre::class, 1000);
        $this->registerUnitRatio(Centimetre::class, 10);
        $this->registerUnitRatio(Millimetre::class, 1);
    }
}
