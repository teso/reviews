<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\ValueObject;

use App\Modules\Reviews\Domain\Exception\Entity\WrongContentLengthException;

class ContentValue extends StringValue
{
    private const MINIMAL_CONTENT_LENGTH = 10;
    private const MAXIMAL_CONTENT_LENGTH = 1000;

    public function __construct(string $value)
    {
        parent::__construct($value);

        if ($this->isLengthInRange(
            self::MINIMAL_CONTENT_LENGTH,
            self::MAXIMAL_CONTENT_LENGTH,
        )) {
            throw new WrongContentLengthException(
                $value,
                self::MINIMAL_CONTENT_LENGTH,
                self::MAXIMAL_CONTENT_LENGTH
            );
        }
    }
}
