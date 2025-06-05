<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Modules\Reviews\Application\Queries\GetReview as GetReviewQuery;
use App\Modules\Reviews\Application\QueryHandlers\GetReviewHandler;
use Illuminate\Console\Command;

class GetReview extends Command
{
    protected $signature = 'review:get {--id= : ID of the review}';
    protected $description = 'Display information about a single review';

    public function handle(GetReviewHandler $handler): int
    {
        $id = $this->option('id');

        if (!$id) {
            $this->error('Missing ID');

            return Command::FAILURE;
        }

        $review = $handler(new GetReviewQuery((int) $this->option('id')));

        if (!$review) {
            $this->error('Review not found');

            return Command::FAILURE;
        }

        $this->table(
            [],
            [
                ['ID', $review->getId()->getValue()],
                ['content', $review->getContent()->getValue()],
                ['status', $review->getStatus()->getValue()],
                ['userId', $review->getUserId()->getValue()],
                ['applicationId', $review->getApplicationId()->getValue()],
                ['createdAt', $review->getCreatedAt()->getValue()],
                ['version', $review->getVersion()],
            ]
        );

        return Command::SUCCESS;
    }
}
