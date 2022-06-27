<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\ValueObject;

use function strval;

class IntegerIdValue extends NaturalValue
{
    public function __toString(): string
    {
        return strval($this->getValue());
    }
}
