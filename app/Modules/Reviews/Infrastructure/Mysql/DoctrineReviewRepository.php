<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Infrastructure\Mysql;

use App\Modules\Reviews\Domain\Entity\Review;
use App\Modules\Reviews\Domain\Exception\Repository\EntityNotFoundException;
use App\Modules\Reviews\Domain\Repository\ReviewRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class DoctrineReviewRepository implements ReviewRepositoryInterface
{
    private $entityManager;
    private $genericRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ObjectRepository $genericRepository
    ) {
        $this->entityManager = $entityManager;
        $this->genericRepository = $genericRepository;
    }

    public function find(int $reviewId): ?Review
    {
        // todo return NullReview if fail
        return $this->genericRepository->find($reviewId);
    }

    public function findOrFail($reviewId): Review
    {
        $review = $this->find($reviewId);

        if (empty($review)) {
            throw new EntityNotFoundException($reviewId);
        }

        return $review;
    }

    public function save(Review $review): void
    {
        $this->entityManager->persist($review);
        $this->entityManager->flush();
    }

    public function update(Review $review): void
    {
        $this->entityManager->persist($review);
        $this->entityManager->flush();
    }

    public function remove(Review $review): void
    {
        $this->entityManager->remove($review);
        $this->entityManager->flush();
    }
}

