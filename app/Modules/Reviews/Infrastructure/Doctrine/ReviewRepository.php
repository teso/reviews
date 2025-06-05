<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Infrastructure\Doctrine;

use App\Modules\Reviews\Domain\Entities\Review as DomainReview;
use App\Modules\Reviews\Domain\Exceptions\Repository\EntityNotFoundException;
use App\Modules\Reviews\Domain\Repositories\ReviewRepositoryInterface;
use App\Modules\Reviews\Infrastructure\Doctrine\Entities\Review;
use Doctrine\ORM\EntityManagerInterface;

class ReviewRepository implements ReviewRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function find(int $reviewId): ?DomainReview
    {
        /** @var Review $review */
        $review = $this->entityManager->find(Review::class, $reviewId);

        return $review?->toDomain();
    }

    public function findOrFail($reviewId): DomainReview
    {
        $review = $this->find($reviewId);

        if (empty($review)) {
            throw new EntityNotFoundException(
                sprintf("Review with id %s is not found", $reviewId)
            );
        }

        return $review;
    }

    public function save(DomainReview $review): void
    {
        $entity = Review::fromDomain($review);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        $review->setId($entity->getId());
        $review->setVersion($entity->getVersion());
    }

    public function update(DomainReview $review): void
    {
        /** @var Review $entity */
        $entity = $this->entityManager->find(
            Review::class,
            $review->getId()->getValue()
        );

        if (empty($entity)) {
            throw new EntityNotFoundException(sprintf(
                "Review with id %s is not found",
                $review->getId()->getValue()
            ));
        }

        $entity->updateFromDomain($review);

        $this->entityManager->flush();
    }

    public function remove(DomainReview $review): void
    {
        /** @var Review $entity */
        $entity = $this->entityManager->find(
            Review::class,
            $review->getId()->getValue()
        );

        if (empty($entity)) {
            throw new EntityNotFoundException(sprintf(
                "Review with id %s is not found",
                $review->getId()->getValue()
            ));
        }

        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }
}
