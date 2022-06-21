<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\Entity;

use App\Modules\Reviews\Domain\Event\DomainEventInterface;

trait AggregateRootTrait
{
    private $domainEvents = [];
    private $version;

    final public function pullDomainEvents(): array
    {
        $domainEvents = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }

    final public function pushDomainEvent(DomainEventInterface $event)
    {
        $this->domainEvents[] = $event;
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    public function setVersion(int $version)
    {
        $this->version = $version;
    }
}
