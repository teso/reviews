<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\Event;

use App\Modules\Reviews\Domain\Entity\AggregateRootInterface;

interface DomainEventPublisherInterface
{
    public function publishFrom(AggregateRootInterface $aggregateRoot): void;
}
