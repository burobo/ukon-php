<?php
namespace Ukon\Exceptions;

use LogicException;

class DifferentTypeException extends LogicException
{
    /**
     * Correct type.
     *
     * @var string
     */
    private $correctType;

    /**
     * Incorrect type.
     *
     * @var string
     */
    private $incorrectType;

    public function __construct(string $correctType, string $incorrectType, $code = 0, Exception $previous = null)
    {
        $this->setCorrectType($correctType);
        $this->setIncorrectType($incorrectType);
        parent::__construct("Type {$this->getIncorrectType()} is diffrent from type {$this->getCorrectType()}.", $code = 0, $previous = null);
    }

    /**
     * Get incorrectType.
     *
     * @return string
     */
    public function getIncorrectType(): string
    {
        return $this->incorrectType;
    }

    /**
     * Set incorrectType.
     *
     * @param string $incorrectType
     *
     * @return void
     */
    private function setIncorrectType(string $incorrectType): void
    {
        $this->incorrectType = $incorrectType;
    }

    /**
     * Get correctType.
     *
     * @return string
     */
    public function getCorrectType(): string
    {
        return $this->correctType;
    }

    /**
     * Set correctType.
     *
     * @param string $correctType
     *
     * @return void
     */
    private function setCorrectType(string $correctType): void
    {
        $this->correctType = $correctType;
    }

}
