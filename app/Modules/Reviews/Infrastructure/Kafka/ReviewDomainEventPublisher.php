<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Infrastructure\Kafka;

use App\Modules\Reviews\Domain\Entities\AggregateRootInterface;
use App\Modules\Reviews\Domain\Events\DomainEventPublisherInterface;

class ReviewDomainEventPublisher implements DomainEventPublisherInterface
{
    public function publishFrom(AggregateRootInterface $aggregateRoot): void
    {
        $events = $aggregateRoot->pullDomainEvents();
    }
}
