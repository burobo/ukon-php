<?php
namespace Ukon;

class Math
{
    /**
     * Scale.
     *
     * @var int
     */
    private $scale;

    /**
     * Constructor.
     *
     * @param integer $scale
     */
    public function __construct(int $scale)
    {
        $this->setScale($scale);
    }

    /**
     * Add.
     *
     * @param float $a
     * @param float $b
     * @return float
     */
    public function add(float $a, float $b): float
    {
        return (float) bcadd($a, $b, $this->getScale());
    }

    /**
     * Subtract.
     *
     * @param float $a
     * @param float $b
     * @return float
     */
    public function sub(float $a, float $b): float
    {
        return (float) bcsub($a, $b, $this->getScale());
    }

    /**
     * Multiply.
     *
     * @param float $a
     * @param float $b
     * @return float
     */
    public function mul(float $a, float $b): float
    {
        return (float) bcmul($a, $b, $this->getScale());
    }

    /**
     * Divide.
     *
     * @param float $a
     * @param float $b
     * @return float
     */
    public function div(float $a, float $b): float
    {
        return (float) bcdiv($a, $b, $this->getScale());
    }

    /**
     * Compare.
     *
     * @return integer
     */
    public function comp(float $a, float $b): int
    {
        return bccomp($a, $b, $this->getScale());
    }

    /**
     * Scale.
     *
     * @return int
     */
    public function getScale(): int
    {
        return $this->scale;
    }

    /**
     * Set scale.
     *
     * @param int $scale
     *
     * @return void
     */
    private function setScale(int $scale): void
    {
        $this->scale = $scale;
    }

}
