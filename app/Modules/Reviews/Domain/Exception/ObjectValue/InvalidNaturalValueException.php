<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\Exception\ObjectValue;

use App\Exceptions\AbstractInvalidArgumentException;

class InvalidNaturalValueException extends AbstractInvalidArgumentException
{
    public function __construct(int $value)
    {
        parent::__construct(sprintf('Value: %s', $value));
    }
}
