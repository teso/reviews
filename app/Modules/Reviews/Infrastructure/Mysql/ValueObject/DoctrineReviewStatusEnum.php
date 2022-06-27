<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Infrastructure\Mysql\ValueObject;

use App\Modules\Reviews\Domain\ValueObject\StatusEnum;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class DoctrineReviewStatusEnum extends Type
{
    private const NAME = 'reviewStatusEnum';

    private $values = [
        StatusEnum::PENDING_MODERATION,
        StatusEnum::ACCEPTED,
        StatusEnum::REJECTED
    ];

    public function getSQLDeclaration(
        array $fieldDeclaration,
        AbstractPlatform $platform
    ) {
        return 'ENUM(\''.implode('\', \'', $this->values ) .'\')';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new StatusEnum($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!$value instanceof StatusEnum) {
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
