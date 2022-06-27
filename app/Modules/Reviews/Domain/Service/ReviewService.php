<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\Service;

use App\Modules\Reviews\Domain\Entity\Review;
use App\Modules\Reviews\Domain\Event\DomainEventPublisherInterface;
use App\Modules\Reviews\Domain\Repository\ReviewRepositoryInterface;

class ReviewService
{
    private $repository;
    private $domainPublisher;

    public function __construct(
        ReviewRepositoryInterface $repository,
        DomainEventPublisherInterface $domainPublisher
    ) {
        $this->repository = $repository;
        $this->domainPublisher = $domainPublisher;
    }

    public function createReview(
        string $content,
        int $userId,
        int $applicationId
    ): Review {
        $review = Review::createReview(
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

    public function updateReviewContent(int $reviewId, string $newContent): void
    {
        $review = $this->repository->findOrFail($reviewId);

        $review->updateContent($newContent);

        $this->repository->update($review);

        $this->domainPublisher->publishFrom($review);
    }

    public  function removeReview(int $reviewId): void
    {
        $review = $this->repository->findOrFail($reviewId);

        $review->remove();

        $this->repository->remove($review);

        $this->domainPublisher->publishFrom($review);
    }
}
