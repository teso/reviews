<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Application\CommandHandlers;

use App\Modules\Reviews\Application\Commands\UpdateReviewContent;
use App\Modules\Reviews\Domain\Services\ReviewService;

class UpdateReviewContentHandler
{
    public function __construct(
        private ReviewService $service,
    ){
    }

    public function __invoke(UpdateReviewContent $command): void
    {
        $this->service->updateReviewContent(
            $command->reviewId,
            $command->content,
            $command->version,
        );
    }
}
