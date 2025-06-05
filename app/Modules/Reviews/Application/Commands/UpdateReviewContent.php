<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Application\Commands;

class UpdateReviewContent
{
    public function __construct(
        public int $reviewId,
        public string $content,
        public int $version,
    ) {
    }
}
