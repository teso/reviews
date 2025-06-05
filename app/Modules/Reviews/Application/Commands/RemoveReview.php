<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Application\Commands;

class RemoveReview
{
    public function __construct(
        public int $reviewId,
    ) {
    }
}
