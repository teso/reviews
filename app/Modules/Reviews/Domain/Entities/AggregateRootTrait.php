<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\Entities;

use App\Modules\Reviews\Domain\Events\DomainEventInterface;
use Doctrine\ORM\Mapping as ORM;

trait AggregateRootTrait
{
    private $version;
    private $domainEvents = [];

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setVersion(int $version)
    {
        $this->version = $version;
    }

    public function pullDomainEvents(): array
    {
        $domainEvents = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }

    public function pushDomainEvent(DomainEventInterface $event)
    {
        $this->domainEvents[] = $event;
    }
}
