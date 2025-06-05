<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\ValueObjects;

class StringValue
{
    private $value;
    private $length;

    public function __construct(string $value)
    {
        $this->value = $value;
        $this->length = \mb_strlen($value, 'utf-8');
    }

    public function isLengthInRange(int $minimalValue, int $maximalValue): bool
    {
        $length = new IntegerValue($this->length);
        $minimalLength = new IntegerValue($minimalValue);
        $maximalLength = new IntegerValue($maximalValue);

        return ($length->isBiggerThan($minimalLength) || $length->isEqualTo($minimalLength))
            && ($length->isLowerThen($maximalLength) || $length->isEqualTo($maximalLength));
    }

    public function isLengthOutOfRange(int $minimalValue, int $maximalValue): bool
    {
        return !$this->isLengthInRange($minimalValue, $maximalValue);
    }

    public function isEqualTo(StringValue $otherValue): bool
    {
        return $this->getValue() === $otherValue->getValue();
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getLength(): int
    {
        return $this->length;
    }
}
