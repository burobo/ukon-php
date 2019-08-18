<?php
namespace Ukon\Exceptions;

use LogicException;

class InvalidCallableDefinitionException extends LogicException
{
    /**
     * Class name of argument.
     *
     * @var string
     */
    private $argumentClassName;

    /**
     * Constructor.
     *
     * @param string $argumentClassName
     * @param integer $code
     * @param Exception $previous
     */
    public function __construct(string $argumentClassName, $code = 0, Exception $previous = null)
    {
        $this->setArgumentClassName($argumentClassName);
        parent::__construct("Class {$this->getArgumentClassName()} is invalid argument for the callable definition.", $code = 0, $previous = null);
    }

    /**
     * Get Class name of argument.
     *
     * @return string
     */
    public function getArgumentClassName(): string
    {
        return $this->argumentClassName;
    }

    /**
     * Set Class name of argument.
     *
     * @param string $argumentClassName
     *
     * @return void
     */
    private function setArgumentClassName(string $argumentClassName): void
    {
        $this->argumentClassName = $argumentClassName;
    }

}
