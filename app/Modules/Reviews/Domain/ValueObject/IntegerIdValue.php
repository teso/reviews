<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\ValueObject;

use App\Modules\Reviews\Domain\Exception\ObjectValue\InvalidIngeterIdValueException;

class IntegerIdValue extends IntValue
{
    public function __construct(int $value)
    {
        parent::__construct($value);

        if ($this->isNotNatural()) {
            throw new InvalidIngeterIdValueException($value);
        }
    }
}
