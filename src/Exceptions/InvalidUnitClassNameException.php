<?php
namespace Ukon\Exceptions;

use InvalidArgumentException;

class InvalidUnitClassNameException extends InvalidArgumentException
{
    /**
     * The class name of unit.
     *
     * @var string
     */
    private $unitClassName;

    public function __construct(string $unitClassName, $code = 0, Exception $previous = null)
    {
        $this->setUnitClassName($unitClassName);
        parent::__construct("{$this->getUnitClassName()} is invalid because it isn't a child class of Ukon\Unit.", $code = 0, $previous = null);
    }

    /**
     * Get the class name of unit.
     *
     * @return string
     */
    public function getUnitClassName(): string
    {
        return $this->unitClassName;
    }

    /**
     * Set the class name of unit.
     *
     * @param string $unitClassName
     *
     * @return void
     */
    private function setUnitClassName(string $unitClassName): void
    {
        $this->unitClassName = $unitClassName;
    }

}
