<?php
namespace Ukon;

use BadMethodCallException;
use Ukon\Exceptions\DifferentUnitException;
use Ukon\Exceptions\DivisionByZeroException;
use Ukon\Math;

abstract class Unit
{
    /**
     * Value of the unit.
     *
     * @var float
     */
    private $value = 0.0;

    /**
     * Math.
     *
     * @var Math
     */
    private $math;

    /**
     * Prefix for fmt method.
     */
    private const PREFIX_FOR_FMT_METHOD = 'fmt';

    /**
     * Constructor.
     *
     * @param float $value
     * @param Math $math
     */
    public function __construct(float $value, Math $math)
    {
        $this->setValue($value);
        $this->setMath($math);
    }

    /**
     * Determine if the value of the unit equals to that of the other.
     *
     * @param Unit $other
     * @return boolean
     */
    public function equalTo(Unit $other): bool
    {
        return $this->math->comp($this->value, $other->getValue()) === 0;
    }

    /**
     * Determine if the value of the unit is greater than that of the other.
     *
     * @param Unit $other
     * @return boolean
     */
    public function greaterThan(Unit $other): bool
    {
        return $this->math->comp($this->value, $other->getValue()) === 1;
    }

    /**
     * Determine if the value of the unit is less than that of the other.
     *
     * @param Unit $other
     * @return boolean
     */
    public function lessThan(Unit $other): bool
    {
        return $this->math->comp($this->value, $other->getValue()) === -1;
    }

    /**
     * Determine if the value of the unit is greater than or equals to that of the other.
     *
     * @param Unit $other
     * @return boolean
     */
    public function greaterThanOrEqualTo(Unit $other): bool
    {
        return $this->greaterThan($other) || $this->equalTo($other);
    }

    /**
     * Determine if the value of the unit is less than or equals to that of the other.
     *
     * @param Unit $other
     * @return boolean
     */
    public function lessThanOrEqualTo(Unit $other): bool
    {
        return $this->lessThan($other) || $this->equalTo($other);
    }

    /**
     * Determine if the value of the unit doesn't equal to that of the other.
     *
     * @param Unit $other
     * @return boolean
     */
    public function notEqualTo(Unit $other): bool
    {
        return !$this->equalTo($other);
    }

    /**
     * Determine if the value of the unit is not greater than that of the other.
     *
     * @param Unit $other
     * @return boolean
     */
    public function notGreaterThan(Unit $other): bool
    {
        return !$this->greaterThan($other);
    }

    /**
     * Determine if the value of the unit is not less than that of the other.
     *
     * @param Unit $other
     * @return boolean
     */
    public function notLessThan(Unit $other): bool
    {
        return !$this->lessThan($other);
    }

    /**
     * Determine if the value of the unit is not greater than or does not equal to that of the other.
     *
     * @param Unit $other
     * @return boolean
     */
    public function notGreaterThanOrEqualTo(Unit $other): bool
    {
        return !$this->greaterThanOrEqualTo($other);
    }

    /**
     * Determine if the value of the unit is not less than or does not equal to that of the other.
     *
     * @param Unit $other
     * @return boolean
     */
    public function notLessThanOrEqualTo(Unit $other): bool
    {
        return !$this->lessThanOrEqualTo($other);
    }

    /**
     * Calculate how many times greater the value of the unit is than that of other.
     *
     * @param Unit $other
     * @return float
     */
    public function compareTo(Unit $other): float
    {
        if ($other->getValue() === 0 || $other->getValue() === 0.0) {
            throw new DivisionByZeroException();
        }

        return $this->math()->div($this->getValue(), $other->getValue());
    }

    /**
     * Determine if other object is same unit as this.
     *
     * @param Unit $other
     * @return boolean
     */
    private function isSameUnit(Unit $other): bool
    {
        return get_class($this) === get_class($other);
    }

    /**
     * Add value of the unit.
     *
     * @param unit $other
     * @return self
     */
    public function add(Unit $other): self
    {
        if (!$this->isSameUnit($other)) {
            throw new DifferentUnitException(get_class($this), get_class($other));
        }

        $this->value = $this->math()->add($this->value, $other->getValue());
        return $this;
    }

    /**
     * Subtract value of the unit.
     *
     * @param Unit $other
     * @return self
     */
    public function sub(Unit $other): self
    {
        if (!$this->isSameUnit($other)) {
            throw new DifferentUnitException(get_class($this), get_class($other));
        }

        $this->value = $this->math()->sub($this->value, $other->getValue());
        return $this;
    }

    /**
     * Multiply value of the unit.
     *
     * @param float $multiplyBy
     * @return self
     */
    public function mul(float $multiplyBy): self
    {
        $this->value = $this->math()->mul($this->value, $multiplyBy);
        return $this;
    }

    /**
     * Divide value of the unit.
     *
     * @param float $divideBy
     * @return self
     */
    public function div(float $divideBy): self
    {
        if ($divideBy === 0 || $divideBy === 0.0) {
            throw new DivisionByZeroException();
        }
        $this->value = $this->math()->div($this->value, $divideBy);
        return $this;
    }

    public function __call($name, $arguments)
    {
        $splittedName = preg_split('/(?=[A-Z])/', $name);
        $sizeOfSplittedName = count($splittedName);

        if ($splittedName[0] === self::PREFIX_FOR_FMT_METHOD) {
            $unitId = lcfirst(implode(array_slice($splittedName, 1)));
            return $this->fmt(
                $unitId,
                isset($arguments[0])
                ? $arguments[0]
                : null
            );
        }

        throw new BadMethodCallException();
    }

    private function fmt(string $unitId, ?int $precision): string
    {
        $this->textdomain();
        return sprintf(
            "{$this->unitFormatOfUnitId($unitId)}",
            $precision !== null
            ? (string) round($this->value, $precision)
            : (string) floatval($this->value)
        );
    }

    /**
     * Unit format of unit id.
     *
     * @param string $unitId
     * @return string
     */
    private function unitFormatOfUnitId(string $unitId): string
    {
        if (array_key_exists($unitId, $this->languageSpecificFormats())) {
            $msgid = lcfirst($this->alias()) . "." . $unitId;
            $translated = _($msgid);
            return $translated !== $msgid
            ? $translated
            : $this->languageSpecificFormats()[$unitId];
        } else if (array_key_exists($unitId, $this->globalFormats())) {
            return $this->globalFormats()[$unitId];
        } else {
            throw new BadMethodCallException();
        }
    }

    /**
     * Set value.
     *
     * @param float $value
     * @return void
     */
    public function setValue(float $value): void
    {
        $this->value = $value;
    }

    /**
     * Get value.
     *
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * Alias of the unit.
     *
     * @return string
     */
    public static function alias(): string
    {
        return substr(strrchr(get_called_class(), "\\"), 1);
    }

    /**
     * Language specific formats.
     *
     * @return string[]
     */
    abstract protected function languageSpecificFormats(): array;

    /**
     * Global formats.
     *
     * @return string[]
     */
    abstract protected function globalFormats(): array;

    /**
     * math
     *
     * @return Math
     */
    public function math(): Math
    {
        return $this->math;
    }

    /**
     * set math
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
     * Which domain to use.
     *
     * @return string
     */
    abstract protected function domain(): string;

    /**
     * Set domain.
     *
     * @return void
     */
    private function textdomain(): void
    {
        textdomain($this->domain());
    }
}
