<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\Exception\ObjectValue;

use App\Exceptions\AbstractInvalidArgumentException;

class WrongContentLengthException extends AbstractInvalidArgumentException
{
    public function __construct(string $value, int $minimalLength, int $maximalLenght)
    {
        parent::__construct(
            sprintf(
                'Length limit: %s-%s, content text: "%s"',
                $minimalLength,
                $maximalLenght,
                $value
            )
        );
    }
}
