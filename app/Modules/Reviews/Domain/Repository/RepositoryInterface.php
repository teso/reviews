<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\Repository;

use App\Modules\Reviews\Domain\Entity\Review;
use App\Modules\Reviews\Domain\Exception\Repository\ReviewEntityNotFoundException;

interface RepositoryInterface
{
    public function find($reviewId): Review;

    /**
     * @throws ReviewEntityNotFoundException
     */
    public function findOrFail($reviewId): Review;

    public function save(Review $review): void;

    public function update(Review $review): void;

    public function remove(Review $review): void;
}
