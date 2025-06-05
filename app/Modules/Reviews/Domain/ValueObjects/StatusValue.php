<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\ValueObjects;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
enum StatusValue: string {
    case PENDING_MODERATION = 'pending_moderation';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';

    public static function getValues(): array
    {
        return array_map(fn (StatusValue $case) => $case->value, self::cases());
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
