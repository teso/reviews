<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Infrastructure\Mysql\ValueObject;

use App\Modules\Reviews\Domain\ValueObject\IntegerIdValue;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class DoctrineIntegerIdValue extends Type
{
    private const NAME = 'integerIdValue';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return 'INT UNSIGNED';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (!is_int($value) && !ctype_digit($value)) {
            // todo concrete exception
            throw new \InvalidArgumentException();
        }

        return new IntegerIdValue((int) $value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (is_integer($value)) {
            return $value;
        }

        if (!$value instanceof IntegerIdValue) {
            // todo concrete exception
            throw new \InvalidArgumentException();
        }

        return $value->getValue();
    }

    public function getName()
    {
        return self::NAME;
    }
}
