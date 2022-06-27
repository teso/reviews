<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\Exception\ObjectValue;

use App\Exceptions\AbstractInvalidArgumentException;
use App\Modules\Reviews\Domain\ValueObject\AbstractStringEnum;

class StringValueNotFoundInEnumException extends AbstractInvalidArgumentException
{
    public function __construct(string $value, AbstractStringEnum $enum)
    {
        parent::__construct(sprintf('Enum: %s, value: %s', $enum, $value));
    }
}
