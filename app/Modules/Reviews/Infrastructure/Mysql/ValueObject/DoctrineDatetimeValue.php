<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Infrastructure\Mysql\ValueObject;

use App\Modules\Reviews\Domain\ValueObject\DatetimeValue;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class DoctrineDatetimeValue extends Type
{
    private const NAME = 'datetimeValue';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return 'DATETIME';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new DatetimeValue($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!$value instanceof DatetimeValue) {
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
