<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\ValueObject;

use App\Modules\Reviews\Domain\DomainConfig;
use App\Modules\Reviews\Domain\Exception\ObjectValue\WrongContentLengthException;

class ContentValue extends StringValue
{
    private const MINIMUM_LENGTH = DomainConfig::MINIMUM_CONTENT_LENGTH;
    private const MAXIMUM_LENGTH = DomainConfig::MAXIMUM_CONTENT_LENGTH;

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
