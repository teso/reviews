<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\ValueObject;

use function \strlen;

class StringValue
{
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function isLengthInRange(int $minimalValue, int $maximalValue)
    {
        $length = new IntValue(strlen($this->value));
        $minimalLength = new IntValue($minimalValue);
        $maximalLength = new IntValue($maximalValue);

        return ($length->isBiggerThan($minimalLength) || $length->isEqualTo($minimalLength))
            && ($length->isLowerThen($maximalLength) || $length->isEqualTo($maximalLength));
    }

    public function isLengthOutOfRange(IntValue $minimalValue, IntValue $maximalValue)
    {
        return !$this->isInRange($minimalValue, $maximalValue);
    }

    public function isEqualTo(StringValue $otherValue)
    {
        return $this->getValue() === $otherValue->getValue();
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
