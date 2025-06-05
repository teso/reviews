<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Application\Queries;

class GetReview
{
    public function __construct(
        public int $reviewId,
    ) {
    }
}
