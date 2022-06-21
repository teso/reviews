<?php

declare(strict_types=1);

namespace Reviews\Infrastructure\Mysql;

use App\Models\ReviewModel;
use App\Modules\Reviews\Domain\Entity\Review;
use App\Modules\Reviews\Domain\Exception\Repository\ReviewEntityNotFoundException;
use App\Modules\Reviews\Domain\Repository\RepositoryInterface;

class ReviewRepository implements RepositoryInterface
{
    public function find($reviewId): Review
    {
        $row = [];

        $review = new Review(
            $row['content'],
            $row['status'],
            $row['userId'],
            $row['applicationId'],
            $row['createdAt']
        );

        $review->setId($row['id']);

        return $review;
    }

    public function findOrFail($reviewId): Review
    {
        $review = $this->find($reviewId);

        if (!$review) {
            throw new ReviewEntityNotFoundException($reviewId);
        }

        return $review;
    }

    public function save(Review $review): void
    {
        // todo add create

        $reviewId = 0;

        $review->setId($reviewId);
    }

    public function update(Review $review): void
    {
        // todo add update
    }

    public function remove(Review $review): void
    {
        // todo add remove
        // todo notify builder about remove
    }
}

