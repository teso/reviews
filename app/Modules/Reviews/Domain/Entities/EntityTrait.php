<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\Entities;

use App\Modules\Reviews\Domain\ValueObjects\IntegerIdValue;
use Doctrine\ORM\Mapping as ORM;

trait EntityTrait
{
    private $id;

    public function getId(): ?IntegerIdValue
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = new IntegerIdValue($id);
    }
}
