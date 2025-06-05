<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\ValueObjects;

use App\Modules\Reviews\Domain\DomainConfig;
use App\Modules\Reviews\Domain\Exceptions\ObjectValue\WrongContentLengthException;

class ContentValue extends StringValue
{
    private const MINIMUM_LENGTH = DomainConfig::MIN_CONTENT_LENGTH;
    private const MAXIMUM_LENGTH = DomainConfig::MAX_CONTENT_LENGTH;

    public function __construct(string $value)
    {
        parent::__construct($value);

        if ($this->isLengthOutOfRange(
            self::MINIMUM_LENGTH,
            self::MAXIMUM_LENGTH,
        )) {
            throw new WrongContentLengthException(
                $value,
                self::MINIMUM_LENGTH,
                self::MAXIMUM_LENGTH
            );
        }
    }
}
