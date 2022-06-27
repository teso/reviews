<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class StatusEnum extends AbstractStringEnum {
    public const PENDING_MODERATION = 'pending_moderation';
    public const ACCEPTED = 'accepted';
    public const REJECTED = 'rejected';
}
