<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\ValueObjects;

use App\Modules\Reviews\Domain\Exceptions\ObjectValue\InvalidNaturalValueException;

class NaturalValue extends IntegerValue
{
    private const ZERO_VALUE = 0;

    public function __construct(int $value)
    {
        parent::__construct($value);

        if ($this->isNotNatural()) {
            throw new InvalidNaturalValueException($value);
        }
    }

    public function isNatural(): bool
    {
        return $this->getValue() > self::ZERO_VALUE;
    }

    public function isNotNatural(): bool
    {
        return !$this->isNatural();
    }
}
