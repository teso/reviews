<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\ValueObject;

class IntegerValue
{
    private $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function isBiggerThan(IntegerValue $otherValue): bool
    {
        return $this->getValue() > $otherValue->getValue();
    }

    public function isLowerThen(IntegerValue $otherValue): bool
    {
        return $this->getValue() < $otherValue->getValue();
    }

    public function isEqualTo(IntegerValue $otherValue): bool
    {
        return $this->getValue() === $otherValue->getValue();
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
