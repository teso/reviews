<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\Events;

class CreateReviewEvent implements DomainEventInterface
{
    use ReviewDataCarrierTrait;
}
