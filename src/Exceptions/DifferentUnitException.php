<?php
namespace Ukon\Exceptions;

use LogicException;

class DifferentUnitException extends LogicException
{
    /**
     * Correct type.
     *
     * @var string
     */
    private $correctUnit;

    /**
     * Incorrect type.
     *
     * @var string
     */
    private $incorrectUnit;

    /**
     * Constructor.
     *
     * @param string $correctUnit
     * @param string $incorrectUnit
     * @param integer $code
     * @param Exception $previous
     */
    public function __construct(string $correctUnit, string $incorrectUnit, $code = 0, Exception $previous = null)
    {
        $this->setCorrectUnit($correctUnit);
        $this->setIncorrectUnit($incorrectUnit);
        parent::__construct("Unit {$this->getIncorrectUnit()} is diffrent from type {$this->getCorrectUnit()}.", $code = 0, $previous = null);
    }

    /**
     * Get incorrectUnit.
     *
     * @return string
     */
    public function getIncorrectUnit(): string
    {
        return $this->incorrectUnit;
    }

    /**
     * Set incorrectUnit.
     *
     * @param string $incorrectUnit
     *
     * @return void
     */
    private function setIncorrectUnit(string $incorrectUnit): void
    {
        $this->incorrectUnit = $incorrectUnit;
    }

    /**
     * Get correctUnit.
     *
     * @return string
     */
    public function getCorrectUnit(): string
    {
        return $this->correctUnit;
    }

    /**
     * Set correctUnit.
     *
     * @param string $correctUnit
     *
     * @return void
     */
    private function setCorrectUnit(string $correctUnit): void
    {
        $this->correctUnit = $correctUnit;
    }

}
