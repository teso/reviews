<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\Events;

use App\Modules\Reviews\Domain\Entities\AggregateRootInterface;

interface DomainEventPublisherInterface
{
    public function publishFrom(AggregateRootInterface $aggregateRoot): void;
}
