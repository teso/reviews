<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Application\Commands;

class AcceptReview
{
    public function __construct(
        public int $reviewId,
    ) {
    }
}
