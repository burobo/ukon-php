<?php
namespace Tests\Stubs\Weight;

use Ukon\Type;

class Weight extends Type
{
    /**
     * @inheritDoc
     */
    public function __construct(int $scale)
    {
        parent::__construct($scale);
        $this->registerUnitRatio(Gram::class, 1000);
    }
}
