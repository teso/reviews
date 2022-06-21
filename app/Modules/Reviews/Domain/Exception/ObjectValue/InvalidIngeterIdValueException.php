<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\Exception\ObjectValue;

use App\Modules\Reviews\Domain\Exception\AbstractRuntimeException;

class InvalidIngeterIdValueException extends AbstractRuntimeException
{
    public function __construct(int $value)
    {
        parent::__construct(sprintf('Value: %s', $value));
    }
}
