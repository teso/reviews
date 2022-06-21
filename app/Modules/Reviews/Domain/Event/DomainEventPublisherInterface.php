<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\Event;

use App\Modules\Reviews\Domain\Entity\EntityInterface;
use App\Modules\Reviews\Domain\Entity\Review;

interface DomainEventPublisherInterface
{
    public function publish(EntityInterface $entity, DomainEventInterface $event);
}
