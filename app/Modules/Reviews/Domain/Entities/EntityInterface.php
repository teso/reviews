<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\Entities;

use App\Modules\Reviews\Domain\ValueObjects\IntegerIdValue;

interface EntityInterface
{
    public function getId(): ?IntegerIdValue;

    public function setId(int $id): void;
}
