<?php
namespace Ukon;

use Ukon\Math;
use ReflectionClass;
use ReflectionMethod;
use ReflectionFunction;
use BadMethodCallException;
use Ukon\Exceptions\DifferentTypeException;
use Ukon\Exceptions\InvalidUnitClassNameException;
use Ukon\Exceptions\InvalidCallableDefinitionException;

abstract class Type
{
    /**
     * Prefix for add method.
     */
    private const PREFIX_FOR_ADD_METHOD = 'add';

    /**
     * Prefix for sub method.
     */
    private const PREFIX_FOR_SUB_METHOD = 'sub';

    /**
     * Prefix for mul method.
     */
    private const PREFIX_FOR_MUL_METHOD = 'mul';

    /**
     * Prefix for div method.
     */
    private const PREFIX_FOR_DIV_METHOD = 'div';

    /**
     * Units.
     *
     * @var Unit[]
     */
    protected $units = [];

    /**
     * Ratios of the units.
     *
     * @var float[]
     */
    private $unitRatios = [];

    /**
     * Scale of units.
     *
     * @var int
     */
    private $scale;

    /**
     * Math.
     *
     * @var Math
     */
    private $math;

    /**
     * Constructor.
     *
     * @param integer $scale
     */
    public function __construct(int $scale)
    {
        $this->setScale($scale);
        $this->setMath(new Math($this->scale()));
    }

    /**
     * Unit class names order by ratio desc.
     *
     * @return array
     */
    private function unitClassNamesOrderByRatioDesc(): array
    {
        return array_keys($this->unitRatios());
    }

    /**
     * Register a ratio of a unit.
     *
     * @param string $unitClassName
     * @param float $ratio
     * @return void
     */
    public function registerUnitRatio(string $unitClassName, float $ratio) : void
    {
        if (!class_exists($unitClassName)) {
            throw new InvalidUnitClassNameException($unitClassName);
        }

        $parentClass = (new ReflectionClass($unitClassName))->getParentClass();

        if (!$parentClass || $parentClass->getName() !== Unit::class) {
            throw new InvalidUnitClassNameException($unitClassName);
        }

        $this->unitRatios[$unitClassName] = $ratio;

        if (!isset($this->units[$unitClassName])) {
            $this->units[$unitClassName] = new $unitClassName(0.0, $this->math());
        }
    }

    /**
     * Class name of alias.
     *
     * @param string $alias
     * @return null|string
     */
    private function classNameOfAlias(string $alias): ?string
    {
        foreach ($this->unitClassNamesOrderByRatioDesc() as $unitClassName) {
            if ($alias === $unitClassName::alias()) {
                return $unitClassName;
            }
        }

        return null;
    }

    /**
     * Determine if other object is same type as this.
     *
     * @param Type $other
     * @return boolean
     */
    private function isSameType(Type $other): bool
    {
        return get_class($this) === get_class($other);
    }

    /**
     * Add a type.
     *
     * @param Type $other
     * @return self
     */
    public function add(Type $other): self
    {
        if (!$this->isSameType($other)) {
            throw new DifferentTypeException(get_class($this), get_class($other));
        }

        foreach ($this->units as $className => $unit) {
            $unit->add($other->getUnitOf($className));
        }

        return $this;
    }

    /**
     * Subtract a type.
     *
     * @param Type $other
     * @return self
     */
    public function sub(Type $other): self
    {
        if (!$this->isSameType($other)) {
            throw new DifferentTypeException(get_class($this), get_class($other));
        }

        foreach ($this->units as $className => $unit) {
            $unit->sub($other->getUnitOf($className));
        }

        return $this;
    }

    /**
     * Add value to the unit.
     *
     * @param float $addBy
     * @return self
     */
    protected function addUnit(string $unitName, float $addBy): self
    {
        $this->units[$unitName]->add((new $unitName($addBy, $this->math())));
        return $this;
    }

    /**
     * Subtract value to the unit.
     *
     * @param float $subtractBy
     * @return self
     */
    protected function subUnit(string $unitName, float $subtractBy): self
    {
        $this->units[$unitName]->sub((new $unitName($subtractBy, $this->math())));
        return $this;
    }

    /**
     * Multiply value of the unit.
     *
     * @param string $unitName
     * @param float $multiplyBy
     * @return self
     */
    protected function mulUnit(string $unitName, float $multiplyBy) : self
    {
        $this->units[$unitName]->mul($multiplyBy);
        return $this;
    }

    /**
     * Divide value of the unit.
     *
     * @param string $unitName
     * @param float $divideBy
     * @return self
     */
    protected function divUnit(string $unitName, float $divideBy) : self
    {
        $this->units[$unitName]->div($divideBy);
        return $this;
    }

    /**
     * Multiply values of all units.
     *
     * @param float $multiplyBy
     * @return self
     */
    public function mul(float $multiplyBy): self
    {
        foreach ($this->units as $unit) {
            $unit->mul($multiplyBy);
        }
        return $this;
    }

    /**
     * Divide values of all units.
     *
     * @param float $divideBy
     * @return self
     */
    public function div(float $divideBy): self
    {
        foreach ($this->units as $unit) {
            $unit->div($divideBy);
        }
        return $this;
    }

    public function __call($name, $arguments)
    {
        $splittedName = preg_split('/(?=[A-Z])/', $name);

        if ($splittedName[0] === self::PREFIX_FOR_ADD_METHOD
            && !!$this->classNameOfAlias(ltrim($name, self::PREFIX_FOR_ADD_METHOD))
            && is_numeric($arguments[0])) {
            return $this->addUnit($this->classNameOfAlias(ltrim($name, self::PREFIX_FOR_ADD_METHOD)), $arguments[0]);
        }

        if ($splittedName[0] === self::PREFIX_FOR_SUB_METHOD
            && !!$this->classNameOfAlias(ltrim($name, self::PREFIX_FOR_SUB_METHOD))
            && is_numeric($arguments[0])) {
            return $this->subUnit($this->classNameOfAlias(ltrim($name, self::PREFIX_FOR_SUB_METHOD)), $arguments[0]);
        }

        if ($splittedName[0] === self::PREFIX_FOR_MUL_METHOD
            && !!$this->classNameOfAlias(ltrim($name, self::PREFIX_FOR_MUL_METHOD))
            && is_numeric($arguments[0])) {
            return $this->mulUnit($this->classNameOfAlias(ltrim($name, self::PREFIX_FOR_MUL_METHOD)), $arguments[0]);
        }

        if ($splittedName[0] === self::PREFIX_FOR_DIV_METHOD
            && !!$this->classNameOfAlias(ltrim($name, self::PREFIX_FOR_DIV_METHOD))
            && is_numeric($arguments[0])) {
            return $this->divUnit($this->classNameOfAlias(ltrim($name, self::PREFIX_FOR_DIV_METHOD)), $arguments[0]);
        }

        throw new BadMethodCallException();
    }

    /**
     * Stgingify the value.
     *
     * @param callable $callback
     * @return string
     */
    public function stringify(callable $callback): string
    {
        $callbackReflection = is_array($callback)
        ? new ReflectionMethod($callback[0], $callback[1])
        : new ReflectionFunction($callback);

        $unitClassNamesOrderByArguments = [];

        // Analyse the arguments of the callback.
        foreach ($callbackReflection->getParameters() as $parameter) {
            $argumentClassName = $parameter->getType()->getName();
            if (!array_key_exists($argumentClassName, $this->units)) {
                throw new InvalidCallableDefinitionException($argumentClassName);
            }
            $unitClassNamesOrderByArguments[] = $argumentClassName;
        }

        $valueInSmallestUnit = $this->inSmallestUnit()->getValue();

        // Sort class names of the arguments order by ratio desc.
        $unitClassNamesOrderByRatioDesc = $unitClassNamesOrderByArguments;
        usort($unitClassNamesOrderByRatioDesc, function ($a, $b) {
            return $this->getRatioOf($a) < $this->getRatioOf($b) ? 1 : -1;
        });

        // Generate the arguments for the callback.
        $arguments = [];

        foreach ($unitClassNamesOrderByRatioDesc as $idx => $unitClassName) {
            $value = $valueInSmallestUnit / $this->getRatioOf($unitClassName);

            if (count($unitClassNamesOrderByRatioDesc) - 1 !== $idx) {
                $value = floor($value);
            }

            $valueInSmallestUnit -= $value * $this->getRatioOf($unitClassName);
            $arguments[$unitClassName] = (new $unitClassName($value, $this->math()));
        }

        $argumentsOrderByArgument = [];

        foreach ($unitClassNamesOrderByArguments as $unitClassNamesOrderByArgument) {
            $argumentsOrderByArgument[] = $arguments[$unitClassNamesOrderByArgument];
        }

        // Execute the callback.
        return call_user_func_array($callback, array_values($argumentsOrderByArgument));
    }

    /**
     * Get unit of class name.
     *
     * @param string $className
     * @return Unit
     */
    public function getUnitOf(string $className): Unit
    {
        return $this->units[$className];
    }

    /**
     * Get Ratio of unit.
     *
     * @param string $unitClassName
     * @return float
     */
    public function getRatioOf(string $unitClassName): float
    {
        return $this->unitRatios()[$unitClassName];
    }

    /**
     * Unit ratios.
     *
     * @return float[]
     */
    protected function unitRatios(): array
    {
        return $this->unitRatios;
    }

    /**
     * Scale.
     *
     * @return int
     */
    public function scale(): int
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

    /**
     * Math.
     *
     * @return Math
     */
    public function math(): Math
    {
        return $this->math;
    }

    /**
     * Set math.
     *
     * @param Math $math
     *
     * @return void
     */
    private function setMath(Math $math): void
    {
        $this->math = $math;
    }

    /**
     * Convert units into the unit of the smallest ratio.
     *
     * @return Unit
     */
    public function inSmallestUnit(): Unit
    {
        $smallestUnitClassName = array_search(min($this->unitRatios()), $this->unitRatios());
        $valueInSmallestUnit = 0.0;

        foreach ($this->units as $className => $unit) {
            $valueInSmallestUnit += $unit->getValue() * $this->getRatioOf($className) / $this->getRatioOf($smallestUnitClassName);
        }

        return new $smallestUnitClassName($valueInSmallestUnit, $this->math());
    }

    /**
     * Determine if the value of the type equals to that of the other.
     *
     * @param Type $other
     * @return boolean
     */
    public function equalTo(Type $other): bool
    {
        if (!$this->isSameType($other)) {
            throw new DifferentTypeException(get_class($this), get_class($other));
        }

        return $this->inSmallestUnit()->equalTo($other->inSmallestUnit());
    }

    /**
     * Determine if the value of the type is greater than that of the other.
     *
     * @param Type $other
     * @return boolean
     */
    public function greaterThan(Type $other): bool
    {
        if (!$this->isSameType($other)) {
            throw new DifferentTypeException(get_class($this), get_class($other));
        }

        return $this->inSmallestUnit()->greaterThan($other->inSmallestUnit());
    }

    /**
     * Determine if the value of the type is less than that of the other.
     *
     * @param Type $other
     * @return boolean
     */
    public function lessThan(Type $other): bool
    {
        if (!$this->isSameType($other)) {
            throw new DifferentTypeException(get_class($this), get_class($other));
        }

        return $this->inSmallestUnit()->lessThan($other->inSmallestUnit());
    }

    /**
     * Determine if the value of the type is greater than or equals to that of the other.
     *
     * @param Type $other
     * @return boolean
     */
    public function greaterThanOrEqualTo(Type $other): bool
    {
        if (!$this->isSameType($other)) {
            throw new DifferentTypeException(get_class($this), get_class($other));
        }

        return $this->inSmallestUnit()->greaterThanOrEqualTo($other->inSmallestUnit());
    }

    /**
     * Determine if the value of the type is less than or equals to that of the other.
     *
     * @param Type $other
     * @return boolean
     */
    public function lessThanOrEqualTo(Type $other): bool
    {
        if (!$this->isSameType($other)) {
            throw new DifferentTypeException(get_class($this), get_class($other));
        }

        return $this->inSmallestUnit()->lessThanOrEqualTo($other->inSmallestUnit());
    }

    /**
     * Determine if the value of the type doesn't equal to that of the other.
     *
     * @param Type $other
     * @return boolean
     */
    public function notEqualTo(Type $other): bool
    {
        if (!$this->isSameType($other)) {
            throw new DifferentTypeException(get_class($this), get_class($other));
        }

        return $this->inSmallestUnit()->notEqualTo($other->inSmallestUnit());
    }

    /**
     * Determine if the value of the type is not greater than that of the other.
     *
     * @param Type $other
     * @return boolean
     */
    public function notGreaterThan(Type $other): bool
    {
        if (!$this->isSameType($other)) {
            throw new DifferentTypeException(get_class($this), get_class($other));
        }

        return $this->inSmallestUnit()->notGreaterThan($other->inSmallestUnit());
    }

    /**
     * Determine if the value of the type is not less than that of the other.
     *
     * @param Type $other
     * @return boolean
     */
    public function notLessThan(Type $other): bool
    {
        if (!$this->isSameType($other)) {
            throw new DifferentTypeException(get_class($this), get_class($other));
        }

        return $this->inSmallestUnit()->notLessThan($other->inSmallestUnit());
    }

    /**
     * Determine if the value of the type is not greater than or does not equal to that of the other.
     *
     * @param Type $other
     * @return boolean
     */
    public function notGreaterThanOrEqualTo(Type $other): bool
    {
        if (!$this->isSameType($other)) {
            throw new DifferentTypeException(get_class($this), get_class($other));
        }

        return $this->inSmallestUnit()->notGreaterThanOrEqualTo($other->inSmallestUnit());
    }

    /**
     * Determine if the value of the type is not less than or does not equal to that of the other.
     *
     * @param Type $other
     * @return boolean
     */
    public function notLessThanOrEqualTo(Type $other): bool
    {
        if (!$this->isSameType($other)) {
            throw new DifferentTypeException(get_class($this), get_class($other));
        }

        return $this->inSmallestUnit()->notLessThanOrEqualTo($other->inSmallestUnit());
    }

    /**
     * Calculate how many times greater the value of the unit is than that of other.
     *
     * @param Type $other
     * @return float
     */
    public function compareTo(Type $other): float
    {
        if (!$this->isSameType($other)) {
            throw new DifferentTypeException(get_class($this), get_class($other));
        }

        return $this->inSmallestUnit()->compareTo($other->inSmallestUnit());
    }

}
