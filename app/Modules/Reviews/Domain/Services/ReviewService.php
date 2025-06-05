<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\Services;

use App\Modules\Reviews\Domain\Entities\Review;
use App\Modules\Reviews\Domain\Events\DomainEventPublisherInterface;
use App\Modules\Reviews\Domain\Repositories\ReviewRepositoryInterface;

class ReviewService
{
    public function __construct(
        private ReviewRepositoryInterface $repository,
        private DomainEventPublisherInterface $domainPublisher,
    ) {
    }

    public function createReview(
        string $content,
        int $userId,
        int $applicationId
    ): Review {
        $review = Review::create(
            $content,
            $userId,
            $applicationId
        );

        $this->repository->save($review);

        $this->domainPublisher->publishFrom($review);

        return $review;
    }

    public function acceptReview(int $reviewId): void
    {
        $review = $this->repository->findOrFail($reviewId);

        $review->accept();

        $this->repository->update($review);

        $this->domainPublisher->publishFrom($review);
    }

    public function rejectReview(int $reviewId): void
    {
        $review = $this->repository->findOrFail($reviewId);

        $review->reject();

        $this->repository->update($review);

        $this->domainPublisher->publishFrom($review);
    }

    public function updateReviewContent(
        int $reviewId,
        string $newContent,
        int $version,
    ): void {
        $review = $this->repository->findOrFail($reviewId);

        $review->updateContent($newContent, $version);

        $this->repository->update($review);

        $this->domainPublisher->publishFrom($review);
    }

    public function removeReview(int $reviewId): void
    {
        $review = $this->repository->findOrFail($reviewId);

        $review->remove();

        $this->repository->remove($review);

        $this->domainPublisher->publishFrom($review);
    }

    public function getReview(int $reviewId): ?Review
    {
        $review = $this->repository->find($reviewId);

        return $review;
    }
}
