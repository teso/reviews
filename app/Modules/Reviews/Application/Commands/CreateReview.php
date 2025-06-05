<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Application\Commands;

class CreateReview
{
    public function __construct(
        public string $content,
        public int $userId,
        public int $applicationId,
    ) {
    }
}
