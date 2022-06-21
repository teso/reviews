<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\Entity;

use App\Modules\Reviews\Domain\ValueObject\IntegerIdValue;

interface EntityInterface
{
    public function getId(): IntegerIdValue;

    public function setId(int $id): void;
}
