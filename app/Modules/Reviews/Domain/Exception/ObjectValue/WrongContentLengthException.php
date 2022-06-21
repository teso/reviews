<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\Exception\Entity;

use App\Modules\Reviews\Domain\Exception\AbstractRuntimeException;

class WrongContentLengthException extends AbstractRuntimeException
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
