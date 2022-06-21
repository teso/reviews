<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\Service;

use App\Modules\Reviews\Domain\Entity\Review;
use App\Modules\Reviews\Domain\Event\DomainEventPublisherInterface;
use App\Modules\Reviews\Domain\Repository\RepositoryInterface;

class ReviewService
{
    private $repository;
    private $domainPublisher;

    public function __construct(
        RepositoryInterface $repository,
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

        $this->domainPublisher->publish($review, $review->pullDomainEvents());

        return $review;
    }

    public function acceptReview(int $reviewId): void
    {
        $review = $this->repository->findOrFail($reviewId);

        $review->accept();

        $this->repository->update($review);

        $this->domainPublisher->publish($review, $review->pullDomainEvents());
    }

    public function rejectReview(int $reviewId): void
    {
        $review = $this->repository->findOrFail($reviewId);

        $review->reject();

        $this->repository->update($review);

        $this->domainPublisher->publish($review, $review->pullDomainEvents());
    }

    public function updateReviewContent(int $reviewId, string $newContent): void
    {
        $review = $this->repository->findOrFail($reviewId);

        $review->updateContent($newContent);

        $this->repository->update($review);

        $this->domainPublisher->publish($review, $review->pullDomainEvents());
    }

    public  function removeReview(int $reviewId): void
    {
        $review = $this->repository->findOrFail($reviewId);

        $review->remove();

        $this->repository->remove($review);

        $this->domainPublisher->publish($review, $review->pullDomainEvents());
    }
}
