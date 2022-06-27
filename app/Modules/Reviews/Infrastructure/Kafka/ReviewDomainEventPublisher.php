<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Infrastructure\Kafka;

use App\Modules\Reviews\Domain\Entity\AggregateRootInterface;
use App\Modules\Reviews\Domain\Event\DomainEventPublisherInterface;

class ReviewDomainEventPublisher implements DomainEventPublisherInterface
{
    public function publishFrom(AggregateRootInterface $aggregateRoot): void
    {
        $events = $aggregateRoot->pullDomainEvents();
    }
}
