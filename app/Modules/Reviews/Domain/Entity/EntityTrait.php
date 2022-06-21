<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\Entity;

use App\Modules\Reviews\Domain\ValueObject\IntegerIdValue;

trait EntityTrait
{
    private $id;

    public function getId(): IntegerIdValue
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = new IntegerIdValue($id);
    }
}
