<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\ValueObject;

class ReviewStatusEnum extends AbstractStringEnum {
    public const PENDING_MODERATION = 'pending_moderation';
    public const ACCEPTED = 'accepted';
    public const REJECTED = 'rejected';
}
