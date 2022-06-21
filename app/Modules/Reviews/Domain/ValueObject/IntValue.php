<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\ValueObject;

class IntValue
{
    private const ZERO_VALUE = 0;

    private $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function isNatural()
    {
        return $this->getValue() > self::ZERO_VALUE;
    }

    public function isNotNatural()
    {
        return !$this->isNatural();
    }

    public function isBiggerThan(IntValue $otherValue)
    {
        return $this->getValue() > $otherValue->getValue();
    }

    public function isLowerThen(IntValue $otherValue)
    {
        return $this->getValue() < $otherValue->getValue();
    }

    public function isEqualTo(IntValue $otherValue)
    {
        return $this->getValue() === $otherValue->getValue();
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
