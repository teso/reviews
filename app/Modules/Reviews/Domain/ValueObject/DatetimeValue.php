<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\ValueObject;

use \DateTimeImmutable;

class DatetimeValue extends DateTimeImmutable
{
    public function getValue(): string
    {
        return $this->format('Y-m-d H:i:s');
    }
}
