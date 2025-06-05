<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\Entities;

use App\Modules\Reviews\Domain\Events\DomainEventInterface;

interface AggregateRootInterface extends EntityInterface
{
    public function getVersion(): ?int;

    public function setVersion(int $version);

    public function pullDomainEvents(): array;

    public function pushDomainEvent(DomainEventInterface $event);
}
