<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\Repository;

use App\Modules\Reviews\Domain\Entity\Review;
use App\Modules\Reviews\Domain\Exception\Repository\EntityNotFoundException;

interface ReviewRepositoryInterface
{
    public function find(int $reviewId): ?Review;

    /**
     * @throws EntityNotFoundException
     */
    public function findOrFail(int $reviewId): Review;

    public function save(Review $review): void;

    public function update(Review $review): void;

    public function remove(Review $review): void;
}
