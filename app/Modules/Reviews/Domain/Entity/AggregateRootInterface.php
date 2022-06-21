<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\Entity;

use App\Modules\Reviews\Domain\Event\DomainEventInterface;

interface AggregateRootInterface extends EntityInterface
{
    public function pullDomainEvents(): array;

    public function pushDomainEvent(DomainEventInterface $event);

    public function getVersion(): int;

    public function setVersion(int $version);
}
