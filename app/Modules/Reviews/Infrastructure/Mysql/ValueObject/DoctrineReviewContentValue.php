<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Infrastructure\Mysql\ValueObject;

use App\Modules\Reviews\Domain\DomainConfig;
use App\Modules\Reviews\Domain\ValueObject\ContentValue;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class DoctrineReviewContentValue extends Type
{
    private const NAME = 'reviewContentValue';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return 'VARCHAR(' . DomainConfig::MAXIMUM_CONTENT_LENGTH . ')';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new ContentValue($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!$value instanceof ContentValue) {
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
