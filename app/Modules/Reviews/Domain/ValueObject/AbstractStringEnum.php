<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\ValueObject;

use App\Modules\Reviews\Domain\Exception\ObjectValue\StringValueNotFoundInEnumException;
use function \in_array;

abstract class AbstractStringEnum
{
    private $value;

    public function __construct(string $value)
    {
        if ($this->notContains($value)) {
            throw new StringValueNotFoundInEnumException($value, $this);
        }

        $this->value = $value;
    }

    public function contains(string $value)
    {
        return in_array($value, $this->getValues());
    }

    public function notContains(string $value)
    {
        return !$this->contains($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return sprintf('[%s]', implode(', ', $this->getValues()));
    }

    private function getValues(): array
    {
        $reflectedSelf = new ReflectionClass(static::class);

        return $reflectedSelf->getConstants();
    }
}
