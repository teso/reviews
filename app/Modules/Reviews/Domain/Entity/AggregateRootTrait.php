<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\Entity;

use App\Modules\Reviews\Domain\Event\DomainEventInterface;
use Doctrine\ORM\Mapping as ORM;

trait AggregateRootTrait
{
    /**
     * @ORM\Version
     * @ORM\Column(
     *     type = "integer",
     *     options = {"unsigned": true, "comment": "Version of aggregate"}
     * )
     */
    private $version;
    private $domainEvents = [];

    public function getVersion(): int
    {
        return $this->version;
    }

    public function setVersion(int $version)
    {
        $this->version = $version;
    }

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
}
